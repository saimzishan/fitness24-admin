<?php
use App\notification\SNSNoti;
Class UserHelper {

    public static $driver = array(
        "upload_image_path" => "/assets/uploads/",
        "site_title" => "Gravel",
        "sincerely" => "Gravel Team",
    );
    #----------------------------------------/Helper Functions\--------------------------------------
    public static function get_login_user() {
         User::get_login_user();
    }

    public static function get_all_user() {
        return User::get_all_user();
    }
    public static function getExpireUsers() {
        return DB::table('apple_pay')->where('expiry_date', '<=', date('Y-m-d H:i:s'))->count();
    }
    public static function getPremimumUsers() {
        return DB::table('apple_pay')->where('expiry_date', '>', date('Y-m-d H:i:s'))->count();
    }
    public static function broadCastMessage($inputs) {
        /**send notification***/
        if($inputs['type']==0)
        {
            $category=VideoHelper::getCategory(10);
            $message=['message'=>$inputs['broadcastMessage'],'type'=>'Generic'];
            $enpointtopic=SNSNoti::pushNoti($category, json_encode($message, true)); 
        }
        else{
            for($i=1; $i <=9; $i++)
            {
                $name=VideoHelper::getCategory($i);
                $message=['message'=>$inputs['broadcastMessage'],'type'=>'Category'];
                $enpointtopic=SNSNoti::pushNoti($name, json_encode($message, true));
            }
        }
    //    $allUser=DB::table('profiles')->leftJoin('device_tokens', 'device_tokens.user_id','=', 'profiles.user_id')->leftJoin('user_settings', 'user_settings.user_id','=', 'profiles.user_id')->select('profiles.goals_id', 'device_tokens.device_token', 'user_settings.is_notification')->get();
    //         $push=array();
    //        foreach($allUser as $user)
    //        {
    //            if(!empty($user->device_token) && $user->is_notification==1)
    //            {
    //                PushNotification::app('appNameIOS')
    //             ->to($user->device_token)
    //             ->send($inputs['broadcastMessage']);
    //            }              
    //        }
          return True;
    }
    public static function dashboard_data() {
        $dashboard_data = array(
            'users' => User::count_all_user()
        );
        return $dashboard_data;
    }

    public static function create_user() {
        $image_new_name = Input::get("profile_image");
        if (empty($image_new_name)) {
            return Redirect::back()->withInput()->with('message', "danger= Please select user image");
        }
        $check_inputs = Input::all();
        $validator = Validator::make($check_inputs, User::$singup_rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::except('password'))->with('message', "danger=" . $validator->errors()->first());
        } else {
            return UserHelper::process_customer($check_inputs, $image_new_name);
        }
    }

//    public static function process_user($check_inputs) {
//        $lat_long = CommonHelper::get_lat_long(Request::only('address'));
//        $marchent_id = UserHelper::user_merchent_id($check_inputs, $lat_long);
//        if ($marchent_id['status'] == "success") {
//            return UserHelper::create_process_user($marchent_id['merchant_id']);
//        } else {
//            return Redirect::back()->withInput(Input::except('password'))->with('message', "danger=" . $marchent_id['message']);
//        }
//    }

    public static function process_customer($check_inputs, $image_new_name) {
        
        return UserHelper::create_process_user(1, $image_new_name);
//        $braintree_customer_id = BraintreeHelper::create_braintree_customer($check_inputs);
//        if ($braintree_customer_id['status'] == "success") {
//            $result_data['customer_id'] = $braintree_customer_id['brain_tree_customer_id'];
//            return UserHelper::create_process_user($result_data['customer_id'], $image_new_name);
//        } else {
//            return Redirect::back()->with('message', "danger= " . $braintree_customer_id['message']);
//        }
    }

    public static function create_process_user($braintree_customer_id, $image_new_name) {

        $inputs = Input::except('password', 'profile_image');
        $password = Hash::make(Input::get('password'));
        return UserHelper::process_create_user($inputs, $image_new_name, $password, $braintree_customer_id);
    }

    public static function process_create_user($inputs, $image_new_name, $password, $braintree_customer_id) {
        $timezone = Input::get('timezone');
        $result = User::save_new_user($inputs, $image_new_name, $password, $braintree_customer_id);
        if ($result) {
           // NotificationSetting::save_settings($result->id);
            //DeviceToken::save_token($result->id, $timezone);
            $local_directory = base_path(CommonHelper::$driver['banner_path']) . $image_new_name;
//            $local_directory = base_path(CommonHelper::$driver['local_img_path']) . $image_new_name;
            $s3directory = CommonHelper::$driver['s3_upload_profile_path'] . 'users/'  . $image_new_name;
            CommonHelper::S3Upload($local_directory, $s3directory);
            CommonHelper::delete_local_crop_image($image_new_name);
//            CommonHelper::delete_image_from_local_folder($image_new_name);
            return Redirect::route('all_user')->with('message', "success= New user has been registered.");
        } else {
            return Redirect::back()->with('message', "danger= New user could not be registered");
        }
    }

    public static function user_merchent_id($check_inputs, $lat_long) {
        if (!empty($lat_long)) {
            if (!BraintreeHelper::merchant_country_check($lat_long)) {
                $result_data['status'] = "error";
                $result_data['message'] = "Address should be from US Country";
                return $result_data;
            }
            $marchent_id = BraintreeHelper::create_merchant($check_inputs, $lat_long);
            if ($marchent_id['status'] == "success") {
                $result_data['status'] = "success";
                $result_data['merchant_id'] = $marchent_id['merchant_id'];
                return $result_data;
            } else {
                $result_data['status'] = "error";
                $result_data['message'] = $marchent_id['message'];
                return $result_data;
            }
        } else {
            $result_data['status'] = "error";
            $result_data['message'] = "Please Enter a valid Address";
            return $result_data;
        }
    }

    public static function edit_user_by_id($id) {
        return User::getUserDetail($id);
    }

    ///////////////////Update particular user//////////////
    public static function update_user_by_id() {
        $inputs = Input::all();
      
        $image = "";
        $image = Input::get('profile_image');
        $id = Input::get('id');
        $password = Hash::make(Input::get('password'));
        $validator = Validator::make($inputs, User::$update_user_rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::except('password'))->with('message', "danger=" . $validator->errors()->first());
        } else {
           $targetBmi = self::calculateBMI(Input::get('current_date_weight'), Input::get('current_date_height'));
           $userUpdate=User::find($id);
           $userUpdate->full_name=Input::get('full_name');
           $userUpdate->email=Input::get('email');
           if(!empty(Input::get('password')))
           {
               $password = Hash::make(Input::get('password'));
               $userUpdate->password=$password;
           }
           $userUpdate->save();
            DB::table('profiles')->where('user_id', '=', $id )->update(['gender'=>Input::get('gender'),'current_date_height'=>Input::get('current_date_height'),'current_date_weight'=>Input::get('current_date_weight'),'current_bmi'=>Input::get('current_bmi'),'target_bmi'=>$targetBmi]);
//            if (!empty($image)) {
//                $image_name = CommonHelper::image_upload(Input::file('profile_image'), CommonHelper::$driver['local_img_path']);
//                if ($image_name['status'] == 'pass') {
//                    $image = $image_name['message'];
//                } else {
//                    return Redirect::back()->withInput()->with('message', "danger= Photo could not be uploaded");
//                }
//            }
            return UserHelper::update_particular_user_by_id($image);
        }
    }
    public static function calculateBMI($weight, $height) {
        if(!empty($weight) && !empty($height)){
 $bmi = $weight / ($height * $height);
        return round($bmi,2); 
        }else{
            return 0;
        }
    }

    public static function update_particular_user_by_id($image) {
        $user_inputs = Input::except('profile_image');
        $id = Input::get('id');
        $user_data = new User($user_inputs);
        if (!empty($image)) {
            $user_data->profile_image = $image;
        }
         
        $user_update = $user_data->toArray();
        $old_image_name = "";
        if (!empty($image)) {
            $user_image = User::get_user_by_id($id);
            $old_image_name = $user_image->profile_image;
        }
        
        return UserHelper::update_user_process($id, $user_update, $old_image_name, $image);
    }

    public static function update_user_process($id, $user_update, $old_image_name, $image) {
         $result='';
         if(array_key_exists('profile_image', $user_update))
         {
             $result=DB::table('profiles')->where('user_id', '=', $id )->update(['image'=>$user_update['profile_image']]);
         }
            if (!empty($image)) {
                CommonHelper::s3_image_processing($id, $old_image_name, $image);
                CommonHelper::delete_local_crop_image($image);
            }
            return Redirect::route('all_user')->with('message', "success= User Updated Successfully");
        }

    public static function get_particular_user($id) {
        return User::get_particular_user_data($id);
    }

    public static function archive_user_via_jquery() {
        $user_inputs = Input::all();
        $id = $user_inputs['id'];
        return User::archive_user_via_jquery($user_inputs, $id);
    }

    #======================================= End of UserHelper Class ===============================
}

#--------------------------------------------------------------[Developed by: Maqsood Shah]