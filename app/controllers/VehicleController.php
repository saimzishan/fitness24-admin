<?php

class VehicleController extends \BaseController {

    ///////////////////// Add Vehicle view //////////////////////
    public function add_vehicle($id) {
        try {
            $user_id = $id;
            $user = UserHelper::edit_user_by_id($id);
            $vehicle_make = VehicleHelper::all_vehicle_make();
            return View :: make("vehicles.add_vehicle", compact("user", "vehicle_make", "user_id"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Select Vehicle model jQuery Ajax //////////////////////
    public function select_model() {
        try {
            $make_id = Input::get("make_id");
            $models = VehicleHelper::view_vehicle_model($make_id);
            return View::make("jqueryviews.add_model", compact("models"));
        } catch (Exception $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        }
    }

    ///////////////////// Add Vehicle //////////////////////
    public function post_vehicle() {
        try {
            return VehicleHelper::add_vehicle();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Edit Vehicle view //////////////////////
    public function edit_vehicle($user_id, $vehicle_id) {
        try {
            $user = UserHelper::edit_user_by_id($user_id);
            $vehicle = VehicleHelper::get_vehicle_by_id($user_id, $vehicle_id);
            $vehicle_make = VehicleHelper::all_vehicle_make();
            foreach ($vehicle_make as $make) {
                if ($vehicle->make == $make['name']) {
                    $models = Model::vehicle_models($make['id']);
                }
            }
            return View :: make("vehicles.edit_vehicle", compact("vehicle", "user_id", "user", "vehicle_make", "models"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Update Vehicle process //////////////////////
    public function update_vehicle() {
        try {
            return VehicleHelper::update_vehicle();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Change Vehicle Status through jQuery /////////////
    public function change_vehicle_status_jquery() {
        try {
            VehicleHelper::archive_vehicle_via_jquery();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// User vehicle views /////////////
    public function user_vehicles($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $vehicles = VehicleHelper::get_all_vehicles($user_id);
            return View :: make("vehicles.user_all_vehicle", compact("vehicles", "user_id", "user"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Add Vehicle make & model view /////////////
    public function add_make_model() {
        try {
            return View :: make("vehicles.add_new_make");
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Add Vehicle make & model view /////////////
    public function post_make_model() {
        try {
            return VehicleHelper::add_make_model();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Edit Vehicle make view /////////////
    public function edit_make($id) {
        try {
            $make = Make::get_single_vehicle_make($id);
            return View :: make("vehicles.edit_make_type", compact("make"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Update Vehicle make type /////////////
    public function update_make_type() {
        try {
            return VehicleHelper::update_make_type();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// view all vehicle types /////////////
    public function all_vehicle_make() {
        try {
            $make = VehicleHelper::all_vehicle_make();
            return View :: make("vehicles.vehicle_all_make", compact("make"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// view vehicle models /////////////
    public function view_vehicle_model($make_id) {
        try {
            $vehicle_make = VehicleHelper::get_single_vehicle_make($make_id);
            $models = VehicleHelper::view_vehicle_model($make_id);
            return View :: make("vehicles.view_vehicle_model", compact("models", "vehicle_make"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Add new models view /////////////
    public function add_model($make_id) {
        try {
            return View :: make("vehicles.add_model", compact("make_id"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Post new models /////////////
    public function post_new_model() {
        try {
            return VehicleHelper::add_new_model();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Edit model view /////////////
    public function edit_model($id, $make_id) {
        try {
            $model = Model::get_model($id, $make_id);
            return View :: make("vehicles.edit_model", compact("model"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Update model /////////////
    public function update_model() {
        try {
            return VehicleHelper::update_particular_model();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Towing Vehichel list /////////////
    public function towing_vehicle_list() {
        try {
            $vehicles = VehicleHelper::towing_vehicles();
            return View :: make("vehicles.all_towing_vehicle", compact("vehicles"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Change Towing Vehichel status /////////////
    public function change_towing_status($id) {
        try {
            return VehicleHelper::change_towing_status($id);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////// Archive a model /////////////
    public function change_model_status_jquery() {
        try {
            return VehicleHelper::archive_model_via_jquery();
        } catch (Exception $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        }
    }

    ///////////// Archive a vehicle Make type /////////////
    public function change_make_status_jquery() {
        try {
            return VehicleHelper::archive_make_via_jquery();
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
        if ($width >= 498 && $height >= 498) {
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
        $this->layout = View::make('crop_images_views.imageSelector', compact("name", "url"));
    }

    public function imageCrop() {
        $new_name = Session::get('image_name'); // Thumbnail image name
        $img = Session::get('image_name');
        $ext_array = explode(".", $img);
        $ext = strtolower($ext_array[count($ext_array) - 1]);
        if (isset($_GET['t']) and $_GET['t'] == "ajax") {
            extract($_GET);
            $path = CommonHelper::$driver['banner_path'];
            $t_width = 498; // Maximum thumbnail width
            $t_height = 498; // Maximum thumbnail height
            $ratio = ($t_width / $w);
            $nw = ceil($w * $ratio);
            $nh = ceil($h * $ratio);
            $target_height = 498;
            $target_width = 498;
            $v_fact = $target_height / $h;
            $h_fact = $target_width / $w;
            $im_fact = min($v_fact, $h_fact);
            $new_height = $h * $im_fact;
            $new_width = $w * $im_fact;
            $nimg = imagecreatetruecolor(498, 498);
            switch ($ext) {
                case 'gif':
                    $im_src = imagecreatefromgif($path . $img);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, 498, 498, $w, $h);
                    imagegif($nimg, $path . $new_name, 90);
                    break;

                case 'jpg':
                    $im_src = imagecreatefromjpeg($path . $img);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, 498, 498, $w, $h);
                    imagejpeg($nimg, $path . $new_name, 90);
                    break;
                case 'jpeg':
                    $im_src = imagecreatefromjpeg($path . $img);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, 498, 498, $w, $h);
                    imagejpeg($nimg, $path . $new_name, 90);
                    break;
                case 'png':
                    $im_src = imagecreatefrompng($path . $img);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, 498, 498, $w, $h);
                    imagepng($nimg, $path . $new_name, 9);
                    break;
            }
            echo CommonHelper::$driver['banner_path'] . $new_name;
            exit;
        }
    }

    public function delImages() {
        $name = Input::get('name');
        if (file_exists(CommonHelper::$driver['banner_path'] . $name)) {
            unlink(CommonHelper::$driver['banner_path'] . $name);
        }
        if (file_exists(CommonHelper::$driver['main_banner_path'] . $name)) {
            unlink(CommonHelper::$driver['main_banner_path'] . $name);
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]
