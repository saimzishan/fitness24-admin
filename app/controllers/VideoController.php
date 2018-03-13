<?php

class VideoController extends \BaseController {
    public function get_videos() {
        // die("adee");
        try {
            $videos = VideoHelper::get_videos(0);
            return View :: make("videos.all_videos", compact("videos"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function get_nutrition() {
        try {
            $videos = VideoHelper::get_videos(1);
            return View :: make("videos.all_nutrition", compact("videos"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
      public function delete_nutrition() {
        try {
            $inputs = Input::all();
            $video = UserVideo::where("id", "=", $inputs['id'])->first();
            $video->archived = 1;
            $video->save();
            
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
    public function change_video_status() {
        try {
            $updated = VideoHelper::change_video_status();
            if(empty($updated))
                echo 'false';
            else
                echo 'true';
        } catch (Exception $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        }
    }
    
     public function add_video() {
        try {
            $data = Category::where('archived', '=', 0)->get(['id', 'title_ar','title_en'])->toArray();
            $goals = Goal::get();
            foreach ($data as $key => $category) {
                $categories[] = array('title' => $category['title_ar'].'/'.$category['title_en'], 'id' => $category['id']);
            }
            return View :: make("videos.add_video")->with('categories', $categories)->with('goals', $goals);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
     public function add_nutrition() {
        try { 
             $data = Category::where('archived', '=', 0)->get(['id', 'title_ar','title_en'])->toArray();
            $goals = Goal::get();
            foreach ($data as $key => $category) {
                $categories[] = array('title' => $category['title_ar'].'/'.$category['title_en'], 'id' => $category['id']);
            }
            return View :: make("videos.add_nutrition")->with('categories', $categories)->with('goals', $goals);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
    public function post_video() {
        try {
            $inputs = Input::all();
            $add = VideoHelper::add_video($inputs);
         
          if(!empty($add)){
               if(!empty($inputs['nutrition'])){
                return  Redirect::route('all_nutrition')->with('message', "success= Nutrition added Successfully."); 
               }else{
                   return Redirect::to('/allvideos')->with('message', "success= Video added Successfully.");
               }     
          }else{
                return Redirect::back()->withInput(Input::except('password'))->with('message', "danger= Video Not Added, Try again!"); 
          }
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function edit_video() {
        $nutrition=0;
        $video_id=Input::get('id');
        $nutrition=Input::get('nutrition');
        
       try {
            $video = VideoHelper::edit_one_video($video_id);
             $data = Category::where('archived', '=', 0)->get(['id', 'title_ar','title_en'])->toArray();
            $goals = Goal::get();
            foreach ($data as $key => $category) {
                $categories[] = array('title' => $category['title_ar'].'/'.$category['title_en'], 'id' => $category['id']);
            }
            return View :: make("videos.edit_video", compact("video", "video_id", "categories","goals", "nutrition"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
   
    public function post_edit_video() {
        try {
            $inputs = Input::all();
            $add = VideoHelper::update_video($inputs);
         
          if(!empty($add)){
               if(!empty($inputs['nutrition'])){
                return  Redirect::route('all_nutrition')->with('message', "success= Nutrition Updated Successfully."); 
               }else{
                   return Redirect::to('/allvideos')->with('message', "success= Video Updated Successfully.");
               }     
          }else{
                return Redirect::back()->withInput(Input::except('password'))->with('message', "danger= Video Not Added, Try again!"); 
          }
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

   
}

