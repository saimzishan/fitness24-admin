<?php

class ParkingSpotController extends \BaseController {

    ///////////////////// Add Parking Spot view //////////////////////
    public function add_parking_spot($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $userr = $user->toArray();
            if (empty($userr['merchant_id'])) {
                return View :: make("payments.add_merchant", compact("user_id", "user"));
            } else {
                $features = ParkingHelper::all_feature();
                return View :: make("parkingviews.add_parking_spot", compact("user_id", "features", "user"));
            }
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Add Parking Spot //////////////////////
    public function post_parking_spot() {
        try {
            return ParkingHelper::post_parking_spot();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Edit Parking Spot //////////////////////
    public function edit_parking_spot($user_id, $spot_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $spot = ParkingHelper::single_parking_spot($spot_id);
            $photos = Photo::get_all_photo($spot_id, $user_id);
            return View::make("parkingviews.edit_parking_spot", compact("user_id", "spot", "user", "photos"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Update Parking Spot //////////////////////
    public function update_parking_spot() {
        try {
            return ParkingHelper::update_parking_spot();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Add Particular Spot Feature View //////////////////////
    public function add_feature($user_id, $spot_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $features = ParkingHelper::all_feature();
            return View :: make("featureviews.add_single_spot_feature", compact("user", "features", "user_id", "spot_id"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Update Particular Spot Feature //////////////////////
    public function post_particular_feature() {
        try {
            return ParkingHelper::post_particular_feature();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Update Reservation Status //////////////////////
    public function change_reserve_status($user_id, $spot_id, $is_reserved) {
        try {
            return ParkingHelper::change_reserve_status($user_id, $spot_id, $is_reserved);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Add Parking Feature View //////////////////////
    public function add_parking_feature() {
        try {
            return View :: make("featureviews.add_parking_feature");
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Add Parking Feature //////////////////////
    public function post_parking_feature() {
        try {
            return ParkingHelper::post_parking_feature();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// All Parking Feature View //////////////////////
    public function all_feature() {
        try {
            $features = ParkingHelper::all_feature();
            return View :: make("featureviews.all_feature", compact("features"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Edit Parking Feature View //////////////////////
    public function edit_feature($id) {
        try {
            $feature = ParkingHelper::get_single_feature($id);
            return View :: make("featureviews.edit_feature", compact("feature"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Update Parking Feature //////////////////////
    public function update_feature() {
        try {
            return ParkingHelper::update_particular_feature();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Parking Spots //////////////////////
    public function user_parking_spots($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $active_spots = Parking::get_active_parking_spots($user_id);
            $inactive_spots = Parking::get_inactive_parking_spots($user_id);
            return View :: make("parkingviews.user_parking_spots", compact("user_id", "user", "active_spots", "inactive_spots"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Parking Spots //////////////////////
    public function single_parking_spot($user_id, $spot_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $spot = ParkingHelper::single_parking_spot($spot_id);
            $photos = Photo::get_all_photo($spot_id);
            $spot_features = ParkingHelper::single_spot_features($spot_id);
            $days = ParkingHelper::get_all_days($spot_id, $spot['timezone']);
            return View :: make("parkingviews.single_parking_spot", compact("user", "user_id", "spot", "spot_features", "photos", "days"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Parking Spots //////////////////////
    public function edit_availability($day_id, $user_id, $spot_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $day = ParkingHelper::get_single_day($day_id, $spot_id);
            return View :: make("parkingviews.edit_availability", compact("day", "user_id", "spot_id", "user"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Parking Spots //////////////////////
    public function update_availability() {
        try {
            return ParkingHelper::update_availability();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Archive Availability using jQuery Ajax //////////////////////
    public function change_spot_available_jquery() {
        try {
            $day_id = Input::get("id");
            $spot_id = Input::get("spot_id");
            $user_id = Input::get("user_id");
            $day_inputs = Input::except("spot_id", "user_id");
            Day::update_day_info($day_id, $day_inputs);
            $days = Day::get_all_days($spot_id);
            return View::make("jqueryviews.change_availability", compact("days", "spot_id", "user_id"));
        } catch (Exception $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        } catch (Illuminate\Database\QueryException $ex) {
            echo 'Caught exception: ', $ex->getMessage(), "\n";
        }
    }

    ///////////////// Delete Spot Feature ///////////
    public function delete_single_spot_feature($user_id, $spot_id, $feature_id) {
        try {
            return ParkingHelper::delete_single_spot_feature($user_id, $spot_id, $feature_id);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Parking History View //////////////////////
    public function user_parking_history($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $parking_history = ParkingHelper::user_parking_history($user_id);
            return View :: make("parkingviews.user_parking_history", compact("parking_history", "user", "user_id"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// User Favorite Locations //////////////////////
    public function user_favorite_location($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $favorite_locations = UserLocation::user_favorite_location($user_id);
            return View :: make("parkingviews.user_favorite_location", compact("favorite_locations", "user", "user_id"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// User Parking Search History //////////////////////
    public function user_search_history($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $parking_search = UserLocation::user_parking_search($user_id);
            return View :: make("parkingviews.user_search_history", compact("parking_search", "user_id", "user"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Change spot status via Ajax //////////////////////
    public function change_spot_status_jquery() {
        try {
            return ParkingHelper::archive_spot_via_jquery();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]
