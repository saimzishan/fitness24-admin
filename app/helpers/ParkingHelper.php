<?php

Class ParkingHelper {
    #----------------------------------------/Helper Functions\--------------------------------------

    public static function user_parking_history($user_id) {
        return ParkingHistory::user_parking_history($user_id);
    }

    public static function post_parking_spot() {
        $user_id = Input::get("user_id");
        $parking_inputs = Input::except("parking_image", "parking_feature", "day");
        $parking_feature = Input::only("parking_feature");
        $parking_images = Input::only("file");
        $days = Input::only("day");
//        $lat_long = CommonHelper::get_lat_long(Input::get("address"));
        $lat_long = CommonHelper::getLatAndLongFromAddress(Input::get("address"));
//        $current_time = CommonHelper::current_time_with_lat_lng($lat_long['lat'], $lat_long['lng']);
        $address_info = CommonHelper::get_lat_long_address($lat_long['lat'], $lat_long['lng']);
        $images = array();
        $count = 0;
        foreach ($parking_images['file'] as $image) {
            $name = CommonHelper::image_upload($image, CommonHelper::$driver['local_img_path']);
            if ($name['status'] == 'pass') {
                $images[$count] = $name['message'];
                $count = $count + 1;
            } else {
                return Redirect::back()->with('message', "danger= A Photo could not be uploaded");
            }
        }
        return ParkingHelper::spot_process($parking_inputs, $lat_long['lat'], $lat_long['lng'], $images, $address_info, $parking_feature, $days, $user_id);
    }

    public static function spot_process($parking_inputs, $lat, $lng, $image_name, $address_info, $parking_feature, $days, $user_id) {
        $timezone = CommonHelper::current_time_zone_with_lat_lng($lat, $lng);
        $result = Parking::save_parking_spot($parking_inputs, $lat, $lng, $address_info, $timezone);
        if (!empty($result)) {
            $photo = Photo::save_photo($result->id, $image_name);
            if ($photo) {
                foreach ($image_name as $image) {
                    $local_directory = base_path(CommonHelper::$driver['local_img_path']) . $image;
                    $s3directory = CommonHelper::$driver['s3_upload_profile_path'] . 'user_' . $user_id . '/spot_images/' . $image;
                    CommonHelper::S3Upload($local_directory, $s3directory);
                    CommonHelper::delete_image_from_local_folder($image);
                }
            } else {
                return Redirect::back()->with('message', "danger= Sorry! Something went wrong");
            }
            $process = ParkingHelper::process_spot($result->id, $parking_feature, $days);
            if ($process) {
                return Redirect::route('single_parking_spot', array('id' => $user_id, 'spot_id' => $result->id))->with('message', "success= Parking Spot added Successfully");
            }
        } else {
            return Redirect::back()->with('message', "danger= Parking spot could not be Added");
        }
    }

    public static function process_spot($parking_id, $parking_feature, $days) {
        $result = ParkingFeature::save_parking_features($parking_feature, $parking_id);
        if (!empty($result)) {
            $process = Day::save_days($parking_id, $days);
            if (!empty($process)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public static function update_parking_spot() {
        $image = "";
        $id = Input::get("id");
        $user_id = Input::get("user_id");
        $inputs = Input::except('parking_image');
        $img = Input::file('parking_image');
//        $lat_long = CommonHelper::get_lat_long(Input::get("address"));
        $lat_long = CommonHelper::getLatAndLongFromAddress(Input::get("address"));
        $address_info = CommonHelper::get_lat_long_address($lat_long['lat'], $lat_long['lng']);
        if (!empty($img)) {
            $image_name = CommonHelper::image_upload(Input::file('parking_image'), CommonHelper::$driver['local_img_path']);
            if ($image_name['status'] == 'pass') {
                $image = $image_name['message'];
            } else {
                return Redirect::back()->withInput()->with('message', "danger= Photo could not be uploaded");
            }
        }
        return ParkingHelper::update_particular_spot_by_id($id, $user_id, $inputs, $image, $lat_long['lat'], $lat_long['lng'], $address_info);
    }

    public static function update_particular_spot_by_id($id, $user_id, $inputs, $image, $lat, $lng, $address_info) {
        $data = new Parking($inputs);
        $data->lat = $lat;
        $data->lng = $lng;
//        $data->address = $address_info['street'];
        $data->city = $address_info['locality'];
        $data->state = $address_info['region'];
        $data->country = $address_info['country'];
        $data->zipcode = $address_info['postal_code'];
        $update_data = $data->toArray();
        return ParkingHelper::update_particular_spot($id, $user_id, $image, $update_data);
    }

    public static function update_particular_spot($id, $user_id, $image, $update_data) {
        $old_image_name = "";
        if (!empty($image)) {
            $parking_photo = Photo::get_single_photo($id, $user_id);
            $old_image_name = $parking_photo['image'];
        }
        $result = Parking::update_spot($id, $update_data);
        if ($result) {
            if (!empty($image)) {
                return ParkingHelper::update_spot_photo($user_id, $id, $image, $old_image_name);
            }
            return Redirect::route('single_parking_spot', array('id' => $user_id, 'spot_id' => $id))->with('message', "success= Spot information updated Successfully");
        } else {
            return Redirect::back()->withInput()->with('message', "danger= Spot could not be updated");
        }
    }

    public static function update_spot_photo($user_id, $spot_id, $image, $old_image_name) {
        $inputs = array('user_id' => $user_id, 'parking_id' => $spot_id, 'image' => $image);
        $result = Photo::update_spot_photo($inputs, $user_id, $spot_id, $old_image_name);
        if (!$result) {
            return Redirect::route('single_parking_spot', array('id' => $user_id, 'spot_id' => $spot_id))->with('message', "danger= Spot info updated but photo could not be updated");
        } else {
            $local_directory = base_path(CommonHelper::$driver['local_img_path']) . $image;
            $s3directory = CommonHelper::$driver['s3_upload_profile_path'] . 'user_' . $user_id . '/spot_images/' . $image;
            CommonHelper::S3Upload($local_directory, $s3directory);
//        $delete_path = '/users/user_' . $user_id . '/spot_images/' . $old_image_name;
//        CommonHelper::S3_delete_Upload($delete_path);
            CommonHelper::delete_image_from_local_folder($image);
            return Redirect::route('single_parking_spot', array('id' => $user_id, 'spot_id' => $spot_id))->with('message', "success= Spot information updated Successfully");
        }
    }

    public static function change_reserve_status($user_id, $spot_id, $is_reserved) {
        if ($is_reserved == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $update = array("is_reserved" => $status);
        $result = Parking::change_reserve_status($spot_id, $update);
        if ($result) {
            return Redirect::route('single_parking_spot', array('id' => $user_id, 'spot_id' => $spot_id))->with('message', "success= Reserve status Successfully changed");
        } else {
            return Redirect::route('single_parking_spot', array('id' => $user_id, 'spot_id' => $spot_id))->with('message', "success= Reserve status could not be changed");
        }
    }

    public static function archive_spot_via_jquery() {
        $inputs = Input::all();
        $id = $inputs['id'];
        return Parking::archive_spot_via_jquery($inputs, $id);
    }

    public static function update_availability() {
        $day_id = Input::get("id");
        $user_id = Input::get("user_id");
        $spot_id = Input::get("spot_id");
        $day_inputs = Input::only("id", "max_price", "price_per_hour", "archive");
        $spot = ParkingHelper::single_parking_spot($spot_id);
        $start_time = CommonHelper::convert_time_with_timeZone($spot['timezone'], Input::get("start_time"));
        $end_time = CommonHelper::convert_time_with_timeZone($spot['timezone'], Input::get("end_time"));
//        $time_inputs = array('start_time' => $start_time, 'end_time' => $end_time);
        $time_inputs = Input::only("start_time", "end_time");
        $result = Day::update_day_info($day_id, $day_inputs);
        if ($result) {
            $time_update = Time::update_time_info($day_id, $time_inputs);
            if ($time_update) {
                return Redirect::route('single_parking_spot', array('user_id' => $user_id, 'spot_id' => $spot_id))->with('message', "success= Spot Availability Updated");
            } else {
                return Redirect::back()->withInput()->with('message', "danger= Spot could not be updated");
            }
        } else {
            return Redirect::back()->withInput()->with('message', "danger= Spot could not be updated");
        }
    }

    public static function post_parking_feature() {
        $data = Input::all();
        $result = Feature::save_new_feature($data);
        if ($result) {
            return Redirect::route('all_feature')->with('message', "success= New feature has been saved");
        } else {
            return Redirect::back()->with('message', "danger= New feature could not be saved");
        }
    }

    public static function post_particular_feature() {
        $user_id = Input::get("user_id");
        $spot_id = Input::get("parking_id");
        $feature = Input::get("feature_id");
        $features = ParkingFeature::single_spot_features($spot_id);
        foreach ($features as $this_feature) {
            if ($this_feature['feature_id'] == $feature) {
                return Redirect::back()->withInput()->with('message', "danger= Feature Already exists");
            }
        }
        $result = ParkingFeature::add_particular_feature(Input::all());
        if ($result) {
            return Redirect::route('single_parking_spot', array('id' => $user_id, 'spot_id' => $spot_id))->with('message', "success= Feature Successfully added");
        } else {
            return Redirect::route('single_parking_spot', array('id' => $user_id, 'spot_id' => $spot_id))->with('message', "danger= Feature could not be added");
        }
    }

    public static function all_feature() {
        return Feature::all_feature();
    }

    public static function get_single_feature($id) {
        return Feature::get_single_feature($id);
    }

    public static function update_particular_feature() {
        $id = Input::get('id');
        $inputs = Input::except('_token');
        $result = Feature::update_particular_feature($inputs, $id);
        if ($result) {
            return Redirect::route('all_feature')->with('message', "success= Feature updated Successfully");
        } else {
            return Redirect::back()->with('message', "danger= Feature could not be updated");
        }
    }

    public static function single_parking_spot($spot_id) {
        return Parking::single_parking_spot($spot_id);
    }

    public static function single_spot_features($spot_id) {
        return ParkingFeature::single_spot_features($spot_id);
    }

    public static function get_all_days($spot_id, $timezone) {
        $days = Day::get_all_days($spot_id);
//        $count = 0;
//        foreach ($days as $day) {
//            $start_time = CommonHelper::convert_utc_time_with_timeZone($timezone, $day['time']['start_time']);
//            $end_time = CommonHelper::convert_utc_time_with_timeZone($timezone, $day['time']['end_time']);
//            $days[$count]['time']['start_time'] = $start_time;
//            $days[$count]['time']['end_time'] = $end_time;
//            $count++;
//        }
        return $days;
    }

    public static function get_single_day($day_id, $spot_id) {
        $spot = ParkingHelper::single_parking_spot($spot_id);
        $day = Day::get_single_day($day_id);
//        $start_time = CommonHelper::convert_utc_time_with_timeZone($spot['timezone'], $day['time']['start_time']);
//        $end_time = CommonHelper::convert_utc_time_with_timeZone($spot['timezone'], $day['time']['end_time']);
//        $day['time']['start_time'] = $start_time;
//        $day['time']['end_time'] = $end_time;
        return $day;
    }

    public static function delete_single_spot_feature($user_id, $spot_id, $feature_id) {
        $result = ParkingFeature::delete_single_spot_feature($feature_id);
        if ($result) {
            return Redirect::route('single_parking_spot', array('user_id' => $user_id, 'spot_id' => $spot_id))->with('message', "success= Spot feature Successfully deleted");
        } else {
            return Redirect::back()->with('message', "danger= Feature could not be deleted");
        }
    }

    #======================================= End of parkingHelper Class ===============================
}

#--------------------------------------------------------------[Developed by: Maqsood Shah]