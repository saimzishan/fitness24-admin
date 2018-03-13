<?php

class Parking extends Eloquent {

    protected $table = 'parkings';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'user_id',
        'parking_image',
        'address',
        'spot_number',
        'city',
        'state',
        'country',
        'zipcode',
        'lat',
        'lng',
        'is_reserved',
        'archive',
        'description'
    );

    //////////////////////// Relations //////////////////////
    public function user() {
        return $this->belongsTo("User", "user_id", "id");
    }

    public function parkingFeature() {
        return $this->hasMany("ParkingFeature", "parking_id", "id");
    }

    public function photos() {
        return $this->hasMany("Photo", "parking_id", "id");
    }

    ///////////////////////  Methods /////////////
    //////////////////////Creating new Spot//////////////////////
    public static function save_parking_spot($parking_inputs, $lat, $lng, $address_info, $timezone) {
        $spot = new Parking($parking_inputs);
        $spot->lat = $lat;
        $spot->lng = $lng;
//        $spot->address = $address_info['street'];
        $spot->city = $address_info['locality'];
        $spot->state = $address_info['region'];
        $spot->country = $address_info['country'];
        if (!empty($address_info['postal_code'])) {
            $spot->zipcode = $address_info['postal_code'];
        }
        $spot->timezone = $timezone;
        $spot->archive = 0;
        $spot->save();
        return $spot;
    }

    /////////////////update particular spot//////////////
    public static function update_spot($id, $update_data) {
        $result = Parking::where("id", "=", "$id")->update($update_data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //////////////////////Get All Spots//////////////////////
    public static function get_parking_spots($user_id) {
        return Parking::where("user_id", "=", "$user_id")->with("parkingFeature.feature")->get()->toArray();
    }

    //////////////////////Get Active Spots//////////////////////
    public static function get_active_parking_spots($user_id) {
        return Parking::where("user_id", "=", "$user_id")->where("archive", "=", "0")->with("parkingFeature.feature")->get()->toArray();
    }

    //////////////////////Get InActive Spots//////////////////////
    public static function get_inactive_parking_spots($user_id) {
        return Parking::where("user_id", "=", "$user_id")->where("archive", "=", "1")->with("parkingFeature.feature")->get()->toArray();
    }

    //////////////////////Get Single Spot//////////////////////
    public static function single_parking_spot($spot_id) {
        return Parking::where("id", "=", "$spot_id")->first()->toArray();
    }

    //////////////////Change Reserve status ///////////////////
    public static function change_reserve_status($spot_id, $update_data) {
        $result = Parking::where("id", "=", "$spot_id")->update($update_data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //////////////////Change spot status using jquery ajax///////////////////
    public static function archive_spot_via_jquery($inputs, $id) {
        Parking::where("id", "=", "$id")->update($inputs);
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]