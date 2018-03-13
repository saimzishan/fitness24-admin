<?php

Class CommonHelper {

    public static $driver = array(
        "local_img_path" => "assets/uploads/",
        "main_banner_path" => "assets/main_banner/",
        "banner_path" => "assets/banner/",
        "local_crop_img_path" => "app/storage/banner/",
        "local_uncroped_img_path" => "app/storage/vehicle_banner/",
        "site_images" => "/assets/site-images/",
        "s3_upload_profile_path" => "users/",
        "s3_upload_vehicle_make_path" => "vehicles_make/",
//        "s3_uploads" => "https://s3.amazonaws.com/gravel-dev/",
//        "s3_uploads" => "https://s3.amazonaws.com/gravel-production/",
        "s3_uploads" => 'https://s3.amazonaws.com/fitness24-bucket/',
        "site_title" => "Fitness24",
        "sincerely" => "Fitness24 Team",
    );

    #------------------------------------------------------------/Helper Functions\---------------------------------------------

    public static function generateHtmlAlert($message) {
        $mod = "danger";
        if (strstr($message, "=")) {
            $msg = explode("=", $message);
            $mod = $msg[0];
            $message = $msg[1];
        }
        $title = "";
        $class = "";
        // dd($mod);
        switch ($mod) {
            case 'danger':
                $title = "Error!";
                $class = "alert-danger";
                break;
            case 'success':
                $title = "Success!";
                $class = "alert-success";
                break;
        }
        echo "<div class='alert $class'><strong>$title</strong>$message</div>";
    }

    ///////////////////////// Upload Image process /////////////////
    public static function image_upload($image, $path) {
        try {
            $filename = $image->getClientOriginalName();
            $new_name = Str::slug(Str::random(8) . $filename) . '.' . $image->getClientOriginalExtension();
            $upload = $image->move(base_path($path), $new_name);
            if ($upload) {
                $target_path = base_path($path . $new_name);
                chmod($target_path, 0777);
                $image_new_name = array('status' => 'pass', 'message' => $new_name);
                return $image_new_name;
            } else {
                $image_new_name = array('status' => 'fail', 'message' => "danger= Photo could not be uploaded");
                return $image_new_name;
            }
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public static function fileUpload($file, $source, $destination) {

        //file name
        $filename = $file->getClientOriginalName();
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        // file name + image extention
        $fullname = Str::slug(Str::random(8) . time()) . '.' . $file->getClientOriginalExtension();

        $upload = $file->move($source, $fullname);

        if ($upload) {

            CommonHelper::S3Upload($source . $fullname, $destination . $fullname);
        }
        return $fullname;
    }
    
    public static function getVideoThumbnail($name, $destination) {

        $source = CommonHelper::$driver['local_img_path'] . $name;
        $size = '477x268';
        $sec = 2;
        $thumbnail = explode(".", $name);
        $thumbnail = $thumbnail[0] . '.png';
//ffmpeg -i {input}.mov -vcodec h264 -acodec aac -strict -2 {output}.mp4
        shell_exec("ffmpeg -i $source -s $size -deinterlace -an -ss $sec -t 00:00:01 -r 1 -y -vcodec png -f mjpeg $thumbnail 2>&1");
        chmod($thumbnail, 0777);
        CommonHelper::S3Upload($thumbnail, $destination . $thumbnail);
        unlink($thumbnail);
    }
    
    public static function get_lat_long($location) {
        try {
//            $locatin = $location['address'];
            $address = str_replace(' ', '', $location);
            $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            $response_a = json_decode($response);
            curl_close($ch);
            $lat = $response_a->results[0]->geometry->location->lat;
            $long = $response_a->results[0]->geometry->location->lng;
            $result = array('lat' => $lat, 'lng' => $long);
            return $result;
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public static function getLatAndLongFromAddress($addres) {
        try {
            $address = str_replace(" ", "+", $addres);
            $jsone = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
            $json = json_decode($jsone);
            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            $result = array('lat' => $lat, 'lng' => $long);
            return $result;
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public static function get_lat_long_address($lat, $lng) {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($lat) . ',' . trim($lng) . '&sensor=false';
        $json = @file_get_contents($url);
        $data = json_decode($json);
        $status = $data->status;
        if ($status == "OK") {
            $info = array();
            foreach ($data->results[1]->address_components as $component) {
                $info['short'][$component->types[0]] = $component->short_name;
                $info['long'][$component->types[0]] = $component->long_name;
            }
            $location = array();
            $location['address'] = isset($data->results[0]->formatted_address) ? $data->results[0]->formatted_address : "";
            $location['street'] = $data->results[0]->address_components[0]->long_name;
            $location['locality'] = isset($info['long']['locality']) ? $info['long']['locality'] : "";
            $location['country'] = isset($info['short']['country']) ? $info['short']['country'] : "";
            $location['region'] = isset($info['short']['administrative_area_level_1']) ? $info['short']['administrative_area_level_1'] : "";
            $location['postal_code'] = isset($info['short']['postal_code']) ? $info['short']['postal_code'] : "";
            return $location;
        } else {
            return false;
        }
    }

    // get current time according parking's timezone
    public static function current_time_with_lat_lng($lat, $lng) {
        $google_time = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lng&timestamp=1331161200&key=AIzaSyAPS8ix2FlNXIPfqufcNENxoHdYCsRD8ME");
        $timez = json_decode($google_time);
        $d = new DateTime("now", new DateTimeZone($timez->timeZoneId));
//        return $d->format('l');
        $result = array('time' => $d->format('H:i:s'), 'day' => $d->format('l'));
//        return $d->format('H:i:s');
        return $result;
    }

    // get current time according parking's timezone
    public static function current_time_zone_with_lat_lng($lat, $lng) {
        $google_time = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lng&timestamp=1331161200&key=AIzaSyAPS8ix2FlNXIPfqufcNENxoHdYCsRD8ME");
        $timez = json_decode($google_time);
        return $timez->timeZoneId;
    }

    // get current time according parking's timezone
    public static function current_time_with_timeZone($timezone) {
//        $google_time = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lng&timestamp=1331161200&key=AIzaSyAPS8ix2FlNXIPfqufcNENxoHdYCsRD8ME");
//        $timez = json_decode($google_time);
//        $d = new DateTime("now", new DateTimeZone($timez->timeZoneId));
        $d = new DateTime("now", new DateTimeZone($timezone));
//        return $d->format('l');
        $result = array('time' => $d->format('H:i:s'), 'day' => $d->format('l'));
//        return $d->format('H:i:s');
        return $result;
    }

    public static function current_day_date_with_timeZone($timezone) {
        $d = new DateTime("now", new DateTimeZone($timezone));
        $result = $d->format('l, M j,');
        return $result;
    }

    // get utc time according parking's timezone
    public static function convert_time_with_timeZone($timezone, $time) {
        $date = new DateTime($time, new DateTimeZone($timezone));
        $date->setTimezone(new DateTimeZone('UTC'));
        $result = $date->format('H:i:s');
        return $result;
    }

    // get time according parking's timezone from UTC
    public static function convert_utc_time_with_timeZone($timezone, $time) {
        $date = new DateTime($time, new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone($timezone));
        $result = $date->format('H:i:s');
        return $result;
    }

    public static function delete_image_from_local_folder($image_name) {
        try {
            $upload_path = base_path(CommonHelper::$driver['local_img_path']);
            unlink($upload_path . $image_name);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public static function delete_local_crop_image($image_name) {
        try {
            $cropped_path = base_path(CommonHelper::$driver['main_banner_path']);
            $uncropped_path = base_path(CommonHelper::$driver['banner_path']);
            unlink($cropped_path . $image_name);
            unlink($uncropped_path . $image_name);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public static function s3_image_processing($id, $old_image_name, $image) {
        $local_directory = base_path(CommonHelper::$driver['banner_path']) . $image;
        $s3directory = CommonHelper::$driver['s3_upload_profile_path'] . $image;
        CommonHelper::S3Upload($local_directory, $s3directory);
        if(!empty($old_image_name))
        {
            $delete_path = '/users/user_' . $id . '/' . $old_image_name;
            CommonHelper::S3_delete_Upload($delete_path);
        }
    }

    public static function S3Upload($local_source, $s3directory) {

        $s3 = new S3("AKIAIVOPRJR5ALCRCYFQ", "iVKOA40oZJAOH7V89uYBmLVLBGHxYMqVxAlfEIMN");
        $s3->putObjectFile($local_source, "fitness24-bucket", $s3directory, S3::ACL_PUBLIC_READ);
    }

    public static function S3_delete_Upload($s3directory) {
        $s3 = new S3("AKIAIVOPRJR5ALCRCYFQ", "iVKOA40oZJAOH7V89uYBmLVLBGHxYMqVxAlfEIMN");
        $s3->putObjectFile("fitness24-bucket", $s3directory, S3::ACL_PUBLIC_READ);
    }

    public static function send_email($data, $template, $subject = "Coupon Email") {
        $admin_email = 'gravel@whiterabbit.is';
        $site_title = 'Gravel';
        return Mail::send($template, $data, function($m) use ($data, $subject, $admin_email, $site_title) {
                    $m->from($admin_email, $site_title);
                    $m->to($data['email'], $data['email']);
                    $m->subject($subject);
                });
    }

    public static function getCategoryImage($image) {
        try {
            return CommonHelper::setUrl($image, 'empty-image.jpg', CommonHelper::$driver['site_images']);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    private static function setUrl($id, $emptyValue, $path) {
        $url = url() . $path;
        if (!empty($id)) {
            return $url . $id;
        } else {
            return $url . $emptyValue;
        }
    }

    public static function showException($ex) {
        return Redirect::route('showException', array('ex' => $ex->getMessage()));
    }

    #======================================= End of CommonHelper Class ===============================
}

