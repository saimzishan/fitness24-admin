<?php
//Gravel - web with Stable version ....!!!!
class UserController extends \BaseController {

    public function index() {
        try {
            return View :: make("home");
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }
    ///////////////////////// Login View /////////////////
    public function login() {
        try {
           
            return View :: make("login.login");
        } catch (Exception $ex) {
            echo 'Caught Exception: ' . $ex->getMessage();
        }
    }
    public function boradcastMessage() {
        try {
           
            return View :: make("userviews.broadcastMessage");
        } catch (Exception $ex) {
            echo 'Caught Exception: ' . "There is an error in device token";
        }
    }
     public function pBoradcastMessage() {
        try {
            $inputs=Input::all();
           $dashboard = UserHelper::broadCastMessage($inputs);
            return Redirect::route('broadcast_message')->with('message', "success= Message has been sent Successfully");;
        } catch (Exception $ex) {
            echo 'Caught Exception: ' . $ex->getMessage();
        }
    }

    ///////////////////////// Login User ////////////////////
    public function post_login() {
        
        try {
             $validation = Validator::make(Input::all(), User::$login_rules);
        if ($validation->fails()) {
            return Redirect::route('login')->withInput(Input::except('password'))->with('message', "danger=" . $validation->errors()->first());
        } else {
            $credentials = array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
//                'archive' => 0
            );
            if (Auth::attempt($credentials, false)) {
                $user = Auth::getUser()->attributesToArray();
                if ($user['role'] == "admin") {
                    return Redirect::route('home')->with('message', "success= Login successfully");
                }
            } else {
                return Redirect::to('/')->with('message', 'danger= Invalid Username/password');
            }
        }
        } catch (Exception $ex) {
            echo 'Caught Exception: ' . $ex->getMessage();
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught Exception: ' . $ex->getMessage();
        }
    }

    /////////////////// Logout User ////////////////
    public function get_logout() {
        try {
            Auth::logout();
            return Redirect::to('/');
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    /////////////////////// Dashboard View //////////////
    public function get_home() {
        try {
            $dashboard = UserHelper::dashboard_data();
            $videos = VideoHelper::videos_data();
            $nutrition_videos = VideoHelper::nutrition_videos_data();
            $expireUsers = UserHelper::getExpireUsers();
            $premimum = UserHelper::getPremimumUsers();
            
            return View :: make("dashboard.home",compact("videos", "nutrition_videos", "expireUsers", "premimum"), compact("dashboard"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////////// Add new User ////////////////////
    public function add_user() {
        try {
            return View :: make("userviews.add_user");
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////////// Add Merchant ////////////////////
    public function post_merchant() {
        try {
            return PaymentHelper::post_merchant();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////////// Post new User ////////////////////
    public function post_signup() {
        try {
            return UserHelper::create_user();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Get All User //////////////////////
    public function get_all_user() {
        
        try {
            $users = UserHelper::get_all_user();
            return View :: make("userviews.all_user", compact("users"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    /////////////////////Single User Details //////////////////////
    public function view_user($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            return View :: make("userviews.view_user", compact("user", "user_id"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ////////////////// Update user view /////////////////////
    public function edit_user($user_id) {
        try {
           
            $user = UserHelper::edit_user_by_id($user_id);
            
            return View :: make("userviews.update_user", compact("user", "user_id"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ////////////////// Update user process //////////////////
    public function update_user() {
        try {
            return UserHelper::update_user_by_id();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Change user Status through jQuery /////////////
    public function change_user_status_jquery() {
        try {
            UserHelper::archive_user_via_jquery();
        } catch (Exception $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        }
    }

    ///////////// Add promo code view /////////////
    public function add_promo_code() {
        try {
            $users = UserHelper::get_all_user();
            return View :: make("promocodeviews.add_promo_code", compact("users"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
     ///////////// Add promo code view /////////////
    public function edit_promo_code($id) {
        try {
             $coupon = PromoCode::where('id', '=', $id)->first();
                         //print_r(date('Y,m,d', strtotime($coupon->expiry_date)));exit;
            return View :: make("promocodeviews.edit_promo_code", compact("coupon"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Save promo code /////////////
    public function post_promo_code() {
        try {
            $inputs = Input::except("send_to", "email", "name", "city", "state","_token");
            $inputs['expiry_date'] = date('Y/m/d h:i:s', strtotime($inputs['expiry_date']));
//            $inputs['renewal_date'] = date('d/m/Y h:i:s');           
            $coupon = PromoCode::where('coupon_code', '=', $inputs['coupon_code'])->first();
            if(empty($coupon)){
                $result = PromoCode::save_promo_code($inputs);
                if($result){
                    return Redirect::route('all_promo_codes')->with('message', "success= Coupon Successfully Added"); 
                }else{
                    return Redirect::back()->with('message', "danger= Coupon could not be added");
                }
               
            }else{
               return Redirect::back()->with('message', "danger= Coupon with this code already exist"); 
            }
            
            
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
       ///////////// Update promo code /////////////
    public function update_promo_code() {
        try {
            
            $inputs = Input::except("send_to", "email", "name", "city", "state","_token");
            $inputs['expiry_date'] = date('Y/m/d h:i:s', strtotime($inputs['expiry_date']));
            $inputs['renewal_date'] = date('d/m/Y h:i:s');
            $coupon = PromoCode::where('id', '=', $inputs['id'])->first();
            
            if(!empty($coupon)){
                $result = PromoCode::update_promo_code($inputs);
                if($result){
                    return Redirect::route('all_promo_codes')->with('message', "success= Coupon Updated Successfully"); 
                }else{
                    return Redirect::back()->with('message', "danger= Coupon could not be added");
                }
               
            }else{
               return Redirect::back()->with('message', "danger= Coupon with this code already exist"); 
            }
            
            
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Get all promo code view /////////////
    public function all_promo_codes() {
        try {
            $promo_codes = PromoCode::all_promo_codes();
            return View :: make("promocodeviews.all_promo_codes", compact("promo_codes"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Select user email through jQuery /////////////
    public function select_email_jquery() {
        try {
            $user_id = Input::get("user_id");
            $user = UserHelper::get_particular_user($user_id);
            if ($user_id == 'all') {
                return View::make("jqueryviews.select_country_region");
            }
            return View::make("jqueryviews.select_email", compact("user"));
        } catch (Exception $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        }
    }

    ///////////// Select city through jQuery /////////////
    public function select_city_jquery() {
        try {
            $state = Input::get("state");
            $cities = Zip::get_cities_of_state($state);
//            echo '<pre>';
//            print_r($cities);
//            echo 'Hello';
//            exit;
//            $address = CommonHelper::get_lat_long_address($result['lat'], $result['lng']);
            return View::make("jqueryviews.select_city", compact("cities"));
        } catch (Exception $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        }
    }

    public function insert_data() {
        try {
//            ScriptHelper::insert_data();
        } catch (Exception $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        }
    }

    // upload ajax images
    public function ajaxUpload() {
        $time = time();
        $random = Str::random(5);
        $ext_array = explode(".", $_FILES['uploadfile']['name']);
        $ext = strtolower($ext_array[count($ext_array) - 1]);
        $name = $random . $time . '.' . $ext;
        Session::put('image_name', $name);
        $image_destination = CommonHelper::$driver['main_banner_path'] . $name;
        move_uploaded_file($_FILES['uploadfile']['tmp_name'], $image_destination);
        $test = getimagesize($image_destination);
        $width = $test[0];
        $height = $test[1];
        if ($width >= 132 && $height >= 132) {
            copy($image_destination, CommonHelper::$driver['banner_path'] . $name);
            $resulted_data['name'] = $name;
            return Response::json($resulted_data);
        } else {
            unlink($image_destination);
            $resulted_data['name'] = false;
            return Response::json($resulted_data);
        }
    }

    public function imageSelector() {
        $name = Input::get('name');
        $url = Input::get('url');
        $this->layout = View::make('crop_images_views.userImageSelector', compact("name", "url"));
    }

    public function imageCrop() {
        $new_name = Session::get('image_name'); // Thumbnail image name
        $img = Session::get('image_name');
        $ext_array = explode(".", $img);
        $ext = strtolower($ext_array[count($ext_array) - 1]);
        if (isset($_GET['t']) and $_GET['t'] == "ajax") {
            extract($_GET);
            $path = CommonHelper::$driver['banner_path'];
            $t_width = 132; // Maximum thumbnail width
            $t_height = 132; // Maximum thumbnail height
            $ratio = ($t_width / $w);
            $nw = ceil($w * $ratio);
            $nh = ceil($h * $ratio);
            $target_height = 132;
            $target_width = 132;
            $v_fact = $target_height / $h;
            $h_fact = $target_width / $w;
            $im_fact = min($v_fact, $h_fact);
            $new_height = $h * $im_fact;
            $new_width = $w * $im_fact;
            $nimg = imagecreatetruecolor(132, 132);
            switch ($ext) {
                case 'gif':
                    $im_src = imagecreatefromgif($path . $img);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, 132, 132, $w, $h);
                    imagegif($nimg, $path . $new_name, 90);
                    break;

                case 'jpg':
                    $im_src = imagecreatefromjpeg($path . $img);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, 132, 132, $w, $h);
                    imagejpeg($nimg, $path . $new_name, 90);
                    break;
                case 'jpeg':
                    $im_src = imagecreatefromjpeg($path . $img);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, 132, 132, $w, $h);
                    imagejpeg($nimg, $path . $new_name, 90);
                    break;
                case 'png':
                    $im_src = imagecreatefrompng($path . $img);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, 132, 132, $w, $h);
                    imagepng($nimg, $path . $new_name, 9);
                    break;
            }
            echo CommonHelper::$driver['banner_path'] . $new_name;
            exit;
        }
    }

}

#--------------------------------------------------------------[Developed by: Maqsood Shah]