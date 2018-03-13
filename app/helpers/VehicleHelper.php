<?php

Class VehicleHelper {
    #----------------------------------------/Helper Functions\--------------------------------------

    public static function add_vehicle() {
        $check_inputs = Input::all();
        $validator = Validator::make($check_inputs, array(
                    'make' => array('required'),
                    'model' => array('required'),
        ));
        if ($validator->fails()) {
            return Redirect::back()->withInput()->with('message', "danger=" . $validator->errors()->first());
        } else {
//            $image = CommonHelper::image_upload(Input::file('vehicle_image'), CommonHelper::$driver['local_img_path']);
//            if ($image['status'] == 'pass') {
//                $image_new_name = $image['message'];
//            } else {
//                return Redirect::back()->with('message', "danger= Image could not be uploaded");
//            }
            $inputs = Input::except('make');
            return VehicleHelper::process_add_vehicle($inputs);
        }
    }

    public static function process_add_vehicle($inputs) {
        $make_id = Input::get("make");
        $make = Make::get_single_vehicle_make($make_id);
        $result = Vehicle::save_new_vehicle($inputs, $make['name']);
        if ($result) {
            return Redirect::route('user_vehicles', array('id' => $inputs['user_id']))->with('message', "success= New vehicle has been added.");
        } else {
            return Redirect::back()->with('message', "danger= New vehicle could not be added");
        }
    }

    public static function edit_user_by_id($id) {
        return User::get_user_by_id($id);
    }

    public static function get_vehicle_by_id($user_id, $vehicle_id) {
        return Vehicle::get_vehicle_by_id($user_id, $vehicle_id);
    }

    ///////////////////Update particular Vehicle//////////////
    public static function update_vehicle() {
        $inputs = Input::all();
        $validator = Validator::make($inputs, Vehicle::$update_vehicle_rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->with('message', "danger=" . $validator->errors()->first());
        } else {
//            $image = Input::file('vehicle_image');
//            if (!empty($image)) {
//                $image_name = CommonHelper::image_upload(Input::file('vehicle_image'), CommonHelper::$driver['local_img_path']);
//                if ($image_name['status'] == 'pass') {
//                    $image = $image_name['message'];
//                } else {
//                    return Redirect::back()->withInput()->with('message', "danger= Photo could not be uploaded");
//                }
//            }
            return VehicleHelper::update_particular_vehicle_by_id();
        }
    }

    public static function update_particular_vehicle_by_id() {
        $inputs = Input::except('vehicle_image', 'make');
        $id = Input::get('id');
        $user_id = Input::get('user_id');
        $make_id = Input::get('make');
        $make = Make::get_single_vehicle_make($make_id);
        $vehicle_data = new Vehicle($inputs);
//        if (!empty($image)) {
//            $vehicle_data->vehicle_image = $image;
//        }
        $vehicle_data->make = $make['name'];
        $vehicle_update = $vehicle_data->toArray();
//        $old_image_name = "";
//        if (!empty($image)) {
//            $vehicle_image = Vehicle::get_vehicle_by_id($user_id, $id);
//            $old_image_name = $vehicle_image->vehicle_image;
//        }
        return VehicleHelper::update_vehicle_process($id, $user_id, $vehicle_update);
    }

    public static function update_vehicle_process($id, $user_id, $vehicle_update) {
        $result = Vehicle::update_vehicle($id, $vehicle_update);
        if ($result) {
//            if (!empty($old_image_name)) {
//                CommonHelper::delete_image_from_local_folder($old_image_name);
//            }
            return Redirect::route('user_vehicles', array('id' => $user_id))->with('message', "success= Vehicle info Updated Successfully");
        } else {
            return Redirect::route('edit_vehicle', array('user_id' => $user_id, 'vehicle_id' => $id))->withInput()->with('message', "danger= Vehicle info could not be Updated");
        }
    }

    public static function get_all_vehicles($id) {
        return Vehicle::get_all_vehicles($id);
    }

    public static function archive_vehicle_via_jquery() {
        $inputs = Input::all();
        $id = $inputs['id'];
        return Vehicle::archive_vehicle_via_jquery($inputs, $id);
    }

    public static function add_make_model() {
        $make_model = Input::all();
        $image_new_name = Input::get("image");
        if (empty($image_new_name)) {
            return Redirect::back()->withInput()->with('message', "danger= Please select an image");
        }
//        $image = CommonHelper::image_upload(Input::file('image'), CommonHelper::$driver['local_img_path']);
//        if ($image['status'] == 'pass') {
//            $image_new_name = $image['message'];
//        } else {
//            return Redirect::back()->with('message', "danger= Photo could not be uploaded");
//        }
        $make = Input::get("name");
        $make_check = Make::all_vehicle_make();
        foreach ($make_check as $check) {
            if ($check['name'] == $make) {
                return Redirect::back()->withInput()->with('message', "danger= Vehicle type Already exists");
            }
        }
        $result = Make::save_make_model($make_model, $image_new_name);
        if ($result) {
            $local_directory = base_path(CommonHelper::$driver['banner_path']) . $image_new_name;
            $s3directory = CommonHelper::$driver['s3_upload_vehicle_make_path'] . $image_new_name;
            CommonHelper::S3Upload($local_directory, $s3directory);
            CommonHelper::delete_local_crop_image($image_new_name);
            return Redirect::route('all_make')->with('message', "success= Vehicle type Added Successfully");
        } else {
            return Redirect::back()->withInput()->with('message', "danger= Vehicle type could not be added");
        }
    }

    public static function update_make_type() {
        $make_inputs = Input::except("_token");
        $make_id = Input::get("id");
//        $image = Input::file('image');
//        $image_new_name = '';
//        if (!empty($image)) {
//            $image = CommonHelper::image_upload(Input::file('image'), CommonHelper::$driver['local_img_path']);
//            if ($image['status'] == 'pass') {
//                $image_new_name = $image['message'];
//            } else {
//                return Redirect::back()->with('message', "danger= Photo could not be uploaded");
//            }
//        }
//        $old_data = Make::get_single_vehicle_make($make_id);
//        $old_image = $old_data['photos']['image'];
        $result = Make::update_make_type($make_inputs, $make_id);
        if ($result) {
            return Redirect::route('view_vehicle_model', array('id' => $make_id))->with('message', "success= Vehicle Make type Updated Successfully");
        } else {
            return Redirect::back()->withInput()->with('message', "danger= Vehicle Make type could not be Updated");
        }
    }

//    public static function update_photo($make_id, $image_new_name) {
//        $update_photo = array('make_id' => $make_id, 'image' => $image_new_name);
//        $update = Photo::update_vehicle_make_photo($update_photo, $make_id);
//        if ($update) {
//            $local_directory = base_path(CommonHelper::$driver['local_img_path']) . $image_new_name;
//            $s3directory = CommonHelper::$driver['s3_upload_vehicle_make_path'] . $image_new_name;
//            CommonHelper::S3Upload($local_directory, $s3directory);
//            CommonHelper::delete_image_from_local_folder($image_new_name);
//            return Redirect::route('view_vehicle_model', array('id' => $make_id))->with('message', "success= Vehicle Make type Updated Successfully");
//        } else {
//            return Redirect::back()->withInput()->with('message', "danger= Photo could not be updated");
//        }
//    }

    public static function update_particular_model() {
        $model_inputs = Input::except("_token", "image");
        $image = Input::get("image");
        $model_id = Input::get("id");
        $make_id = Input::get("make_id");
        $old_data = Model::get_particular_model($model_id);
        $result = Model::update_single_model($model_inputs, $model_id);
        if ($result) {
            if (!empty($image)) {
                return VehicleHelper::process_update_model($make_id, $model_id, $image, $old_data['photos']['image']);
            }
            return Redirect::route('view_vehicle_model', array('id' => $make_id))->with('message', "success= Model Updated Successfully");
        } else {
            return Redirect::back()->withInput()->with('message', "danger= Model could not be Updated");
        }
    }

    public static function process_update_model($make_id, $model_id, $image, $old_image) {
        $photo = Photo::update_model_photo($model_id, $image);
        if ($photo) {
            $local_directory = base_path(CommonHelper::$driver['banner_path']) . $image;
            $s3directory = CommonHelper::$driver['s3_upload_vehicle_make_path'] . $image;
            CommonHelper::S3Upload($local_directory, $s3directory);
            CommonHelper::delete_local_crop_image($image);
            CommonHelper::S3_delete_Upload(CommonHelper::$driver['s3_upload_vehicle_make_path'] . $old_image);
            return Redirect::route('view_vehicle_model', array('id' => $make_id))->with('message', "success= Model Updated Successfully");
        } else {
            return Redirect::back()->withInput()->with('message', "danger= Model image could not be Updated");
        }
    }

    public static function all_vehicle_make() {
        return Make::all_vehicle_make();
    }

    public static function get_single_vehicle_make($make_id) {
        return Make::get_single_vehicle_make($make_id);
    }

    public static function view_vehicle_model($make_id) {
        return Model::vehicle_models($make_id);
    }

    public static function add_new_model() {
        $inputs = Input::all();
        $image_new_name = Input::get("image");
        if (empty($image_new_name)) {
            return Redirect::back()->withInput()->with('message', "danger= Please select an image");
        }
//        $image = CommonHelper::image_upload(Input::file('image'), CommonHelper::$driver['local_img_path']);
//        if ($image['status'] == 'pass') {
//            $image_new_name = $image['message'];
//        } else {
//            return Redirect::back()->with('message', "danger= Photo could not be uploaded");
//        }
        $make_id = Input::get("make_id");
        $model_data = Input::get("model");
        $generation = Input::get("generation");
        $check_model = Model::vehicle_models($make_id);
        foreach ($check_model as $model) {
            if ($model['model'] == $model_data && $model['generation'] == $generation) {
                return Redirect::back()->withInput()->with('message', "danger= Vehicle model with this generation already exists");
            }
        }
        $result = Model::save_new_model($inputs, $make_id);
        if ($result) {
            return VehicleHelper::model_photo($result->id, $make_id, $image_new_name);
        } else {
            return Redirect::back()->withInput()->with('message', "danger= Vehicle model could not be added");
        }
    }

    public static function model_photo($model_id, $make_id, $image_name) {
        $result = Photo::save_model_photo($model_id, $image_name);
        if ($result) {
            $local_directory = base_path(CommonHelper::$driver['banner_path']) . $image_name;
            $s3directory = CommonHelper::$driver['s3_upload_vehicle_make_path'] . $image_name;
            CommonHelper::S3Upload($local_directory, $s3directory);
            CommonHelper::delete_local_crop_image($image_name);
            return Redirect::route('view_vehicle_model', array('id' => $make_id))->with('message', "success= Vehicle Model Added Successfully");
        } else {
            return Redirect::back()->withInput()->with('message', "danger= New Model added but Photo could not be saved");
        }
    }

    public static function towing_vehicles() {
        $result = array();
        $parking_time = ParkingHistory::get_expired_parking_history();
        if (!empty($parking_time)) {
            $count = 0;
            foreach ($parking_time as $times) {
//                $current_time = CommonHelper::current_time_with_lat_lng($times['parking']['lat'], $times['parking']['lng']);
                $current_time = CommonHelper::current_time_with_timeZone($times['parking']['timezone']);
                $thistime = strtotime($current_time['time']);
                $extime = strtotime($times['expiration_time']);
                $result[$count]['id'] = $times['id'];
                $result[$count]['name'] = $times['vehicle']['user']['first_name'];
                $result[$count]['user_id'] = $times['vehicle']['user_id'];
                $result[$count]['parking_id'] = $times['parking_id'];
                $result[$count]['licence'] = $times['vehicle']['licence'];
                $result[$count]['is_tow'] = $times['is_towed'];
                $count++;
            }
        }
        return $result;
    }

    public static function change_towing_status($id) {
        $parking = ParkingHistory::get_parking_history($id);
        $current_time = CommonHelper::current_time_with_timeZone($parking['parking']['timezone']);
        $current_date = CommonHelper::current_day_date_with_timeZone($parking['parking']['timezone']);
        $current_day = Day::get_day_data($parking['parking_id'], $current_time['day']);
        $charges = VehicleHelper::get_remaining_time($current_time['time'], $current_day['max_price'], $parking['expiration_time'], $current_day['price_per_hour'], $parking['parking_time']);
        $total_charge = $charges['charges'] + 50;
        $data = array(
            "user_id" => $parking['user_id'],
            "parking_id" => $parking['parking_id'],
            "host_id" => $parking['parking']['user_id'],
            "customer_id" => $parking['user']['customer_id'],
            "checkout_time" => $current_time['time'],
            "charge" => $total_charge
        );
//        $status_data = array('id' => $id, 'is_towed' => 2);
//        $change_status = ParkingHistory::update_status($id, $status_data);
//        if ($change_status) {
        return PaymentHelper::checkout($data, $parking, $current_day, $current_time, $current_date, $id);
//        } else {
//            return Redirect::route('vehicle_list')->with('message', "danger= Please try again");
//        }
    }

    public static function get_remaining_time($current_time, $max_price, $expiration_time, $price_per_hour, $parking_time) {
        $time['over_time'] = false;
        $charging_time = 0;
//        $result_time = strtotime($data["parking_histories"][0]["expiration_time"]) - strtotime($data['current_time']);
        $result_time = strtotime($expiration_time) - strtotime($current_time);
        if ($result_time < 0) {
            $time['over_time'] = true;
            $result_time = strtotime($current_time) - strtotime($expiration_time);
            $time['remaining_time'] = $result_time * 1000;
        } else {
            $time['remaining_time'] = $result_time * 1000;
        }
//        charges calculation   
        $charging_time = strtotime($current_time) - strtotime($parking_time);
//        $minutes = ($charging_time > 0) ? round(abs($charging_time) / 60) : 0;
//        $price_per_minute = $price_per_hour / 60;
//        $charges = number_format((float) ($minutes * $price_per_minute), 2, '.', '');
        $hours = ($charging_time > 0) ? ceil($charging_time / 3600) : 1;
        $charges = number_format((float) ($hours * $price_per_hour), 2, '.', '');
        $time['charges'] = $charges;
        if ($charges > $max_price) {
            $time['charges'] = $max_price;
        }
        return $time;
    }

    public static function archive_model_via_jquery() {
        $inputs = Input::all();
        $id = $inputs['id'];
        return Model::archive_model_via_jquery($inputs, $id);
    }

    public static function archive_make_via_jquery() {
        $inputs = Input::all();
        $id = $inputs['id'];
        return Make::archive_make_via_jquery($inputs, $id);
    }

    #======================================= End of VehicleHelper Class ===============================
}

#--------------------------------------------------------------[Developed by: Maqsood Shah]