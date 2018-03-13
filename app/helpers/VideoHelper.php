<?php
use App\notification\SNSNoti;
class VideoHelper {
  
    public static function featuredVideos($inputs) {
       $env = $inputs['Local'];
       $videos = UserVideo::where
               ('is_featured', '=' , 1)
               ->where('archived', '=' , 0)
               ->take($inputs['Limit'])->offset($inputs['Offset'])
               ->get(['id', 'title_'.$env, 'url', 'thumb','description_'.$env]);      
         if(!empty($videos)){
            $videos = $videos->toArray();
            foreach ($videos as $key => $video) {
                $videos[$key]['thumb'] = Config::get('paths.s3_url') . 'Images/' . $video['thumb'];
                $videos[$key]['url'] = Config::get('paths.s3_url') . 'Videos/' . $video['url'];
                $videos[$key]['title'] =  $video['title_'.$env];
                $videos[$key]['descriptions'] = $video['description_'.$env];
                unset($videos[$key]['title_'.$env], $videos[$key]['description_'.$env]);
            }
            return $videos;
         }else{
             return false;
         }
             
    }
       public static function freeVideos($inputs) {
       $env = $inputs['Local'];
       $videos = UserVideo::where
               ('is_free', '=' , 1)
               ->where('archived', '=' , 0)
               ->take($inputs['Limit'])->offset($inputs['Offset'])
               ->get(['id', 'title_'.$env, 'url', 'thumb','description_'.$env]);      
         if(!empty($videos)){
            $videos = $videos->toArray();
            foreach ($videos as $key => $video) {
                $videos[$key]['thumb'] = Config::get('paths.s3_url') . 'Images/' . $video['thumb'];
                $videos[$key]['url'] = Config::get('paths.s3_url') . 'Videos/' . $video['url'];
                $videos[$key]['title'] = $video['title_'.$env];
                $videos[$key]['descriptions'] = $video['description_'.$env];
                unset($videos[$key]['title_'.$env], $videos[$key]['description_'.$env]);
            }
            return $videos;
         }else{
             return false;
         }
             
    }
    
    public static function videos_data() {
       
        $video_data = array(
            'user_videos' => UserVideo::count_all_videos()
        );
        
        return $video_data;
    }
    public static function nutrition_videos_data() {
       
        $video_data = array(
            'user_nutrition_videos' => UserVideo::count_nutrition_videos()
        );
        
        return $video_data;
    }
    
     public static function get_videos($is_nutrition) {
       return UserVideo::where('is_nutrition', '=', $is_nutrition)->leftJoin('users', 'users.id', '=', 'videos.created_by')->select('videos.*', 'users.full_name')->with('categories')->orderBy('id', 'desc')->get();      
             
    }
    
    public static function change_video_status() {
       $inputs = Input::all();
       $video = UserVideo::where("id", "=", $inputs['id'])->first();
       
       if($inputs['key']=='archived')
       {
           return $video->delete();
       }
       else
       {
           $video->$inputs['key'] = $inputs['val'];
           return $video->save();
       }
    }
    
     public static function add_video($inputs) {
       $userId=Auth::user()->id;
       $tags = "";
       foreach ($inputs['tags'] as $selectedOption)
       $tags .= $selectedOption .",";
       $thumb = '';
       $video_name = '';
       if(!empty($inputs['video'])){
       $video_name = CommonHelper::fileUpload($inputs['video'], CommonHelper::$driver['local_img_path'], 'Videos/');
        
       CommonHelper::getVideoThumbnail($video_name, 'Images/');
       unlink(CommonHelper::$driver['local_img_path'] . $video_name);
       
      $thumb = explode(".", $video_name);
       $thumb = $thumb[0].'.png';
       }
       if(!empty($inputs['image'])){
       $thumb = CommonHelper::fileUpload($inputs['image'], CommonHelper::$driver['local_img_path'], 'Images/');
       unlink(CommonHelper::$driver['local_img_path'] . $thumb);
       }
        $data = array(
           'title_en' => $inputs['title_en'],
           'description_en' => $inputs['description_en'],
           'title_ar' => $inputs['title_ar'],
           'description_ar' => $inputs['description_ar'],
           'category_id' => !empty($inputs['category_id']) ? $inputs['category_id'] : 0,
           'type' => !empty($inputs['type']) ? $inputs['type'] : 'video',
           'keyword' => rtrim($tags, ","),
           'url' => $video_name,
           'thumb' => $thumb,
           'is_featured' => !empty($inputs['is_featured']) ? 1 : 0,
           'is_nutrition' => !empty($inputs['nutrition']) ? 1 : 0,
           'is_free' => !empty($inputs['is_free']) ? 1 : 0,
           'is_send_notification' => !empty($inputs['is_notification']) ? 1 : 0,
           'created_by' => $userId,        
       );
       $video = new UserVideo($data);
       
        $video->save();
       /**send notification***/
       $allUser=DB::table('profiles')->leftJoin('device_tokens', 'device_tokens.user_id','=', 'profiles.user_id')->select('profiles.goals_id', 'device_tokens.device_token')->get();
            $push=array();
            $tags_array=$inputs['tags'];
            if(!empty($inputs['is_notification']))
               {
                    foreach($tags_array as $tag)
                    {
                        if($tag==10)
                        {
                            $type='Generic';
                        }
                        else
                        {
                            $type='Video';
                        }
                        if(!empty($inputs['is_featured']))
                        {
                            $videoType='featured';
                        }
                        else{
                            $videoType='free';
                        }
                        if(array_key_exists('type', $inputs) && $inputs['type']=='video')
                        {
                            $message=['message'=>$inputs['notification'],'video_id'=>$video->id, 'type'=>!empty($inputs['type']) ? strtoupper($inputs['type']) : $type, 'video_type'=>$videoType];
                        }
                        elseif(!array_key_exists('nutrition', $inputs)){
                            $message=['message'=>$inputs['notification'], 'video_type'=>$videoType,'video_id'=>$video->id, 'type'=>$type];             
                        }
                        else
                        {
                             $message=['message'=>$inputs['notification'], 'type'=>!empty($inputs['type']) ? $inputs['type'] : $type];
                        }
                        $name=self::getCategory($tag);
                        $enpointtopic=SNSNoti::pushNoti($name, json_encode($message, true));                        
                    }
               }
           
           
       //$video_name = "qasim.mp4";   
      return $video->id;
    }
    public static function getCategory($num)
    {
        switch ($num) {
    case 1:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-1';
        break;
    case 2:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-2';
        break;
    case 3:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-3';
        break;
        case 4:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-4';
        break;
        case 5:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-5';
        break;
        case 6:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-6';
        break;
        case 7:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-7';
        break;
        case 8:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-8';
        break;
        case 9:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-9';
        break;
        case 10:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-10';
        break;
        case 11:
        $category='arn:aws:sns:us-west-2:046164549220:Fit-11';
        break;
}
return $category;
    }
    public static function edit_one_video($id) {
        $videos=UserVideo::find($id);
        return $videos;
    }
    public static function update_video($inputs) {
       $userId=Auth::user()->id;
       $tags = "";
      
       foreach ($inputs['tags'] as $selectedOption)
       $tags .= $selectedOption .",";
       
       $thumb = '';
       $video_name = '';
       if(!empty($inputs['video'])){
       $video_name = CommonHelper::fileUpload($inputs['video'], CommonHelper::$driver['local_img_path'], 'Videos/');
        
       CommonHelper::getVideoThumbnail($video_name, 'Images/');
       unlink(CommonHelper::$driver['local_img_path'] . $video_name);
       
      $thumb = explode(".", $video_name);
       $thumb = $thumb[0].'.png';
       }
       if(!empty($inputs['image'])){
       $thumb = CommonHelper::fileUpload($inputs['image'], CommonHelper::$driver['local_img_path'], 'Images/');
       unlink(CommonHelper::$driver['local_img_path'] . $thumb);
       }
      $tags_array=$inputs['tags'];
            if(!empty($inputs['is_notification']))
               {
                    foreach($tags_array as $tag)
                    {
                        if($tag==10)
                        {
                            $type='Generic';
                        }
                        else
                        {
                            $type='Video';
                        }
                        if(!empty($inputs['is_featured'])==1)
                        {
                            $videoType='featured';
                        }
                        elseif(array_key_exists('nutrition', $inputs))
                        {
                            $videoType='featured';
                        }
                        else{
                            $videoType='free';
                        }
                         if(array_key_exists('type', $inputs) && $inputs['type']=='video')
                        {
                            $message=['message'=>$inputs['notification'],'video_id'=>$video->id, 'type'=>!empty($inputs['type']) ? strtoupper($inputs['type']) : $type, 'video_type'=>$videoType];
                        }
                        elseif(!array_key_exists('nutrition', $inputs)){
                            $message=['message'=>$inputs['notification'], 'video_type'=>$videoType,'video_id'=>$video->id, 'type'=>$type];             
                        }
                        else
                        {
                             $message=['message'=>$inputs['notification'], 'type'=>!empty($inputs['type']) ? $inputs['type'] : $type];
                        }$name=self::getCategory($tag);
                        $enpointtopic=SNSNoti::pushNoti($name, json_encode($message, true)); 
                        // $name=self::getCategory($tag);
                        // $enpointtopic=SNSNoti::addEndPointToTopic($name, $inputs['notification']);                        
                    }
               }
       //$video_name = "qasim.mp4";   
       $data = array(
           'title_en' => $inputs['title_en'],
           'description_en' => $inputs['description_en'],
           'title_ar' => $inputs['title_ar'],
           'description_ar' => $inputs['description_ar'],
           'category_id' => !empty($inputs['category_id']) ? $inputs['category_id'] : 0,
           'type' => !empty($inputs['type']) ? $inputs['type'] : 'video',
           'keyword' => rtrim($tags, ","),
           'is_featured' => !empty($inputs['is_featured']) ? 1 : 0,
           'is_nutrition' => !empty($inputs['nutrition']) ? 1 : 0,
           'is_free' => !empty($inputs['is_free']) ? 1 : 0,
           'is_send_notification' => !empty($inputs['is_notification']) ? 1 : 0,
           'created_by' =>$userId   
       );
       $video = UserVideo::where('id','=',$inputs['id'])->update($data);
        if(!empty($video_name) || !empty($thumb) ){
            UserVideo::where('id','=',$inputs['id'])->update(['url' => $video_name,'thumb' => $thumb]);
           }
       return true;
    }
 
}
