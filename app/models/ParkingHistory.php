<?php

class ParkingHistory extends Eloquent {

    protected $table = 'parking_histories';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'user_id',
        'parking_id',
        'parking_time',
        'checkout_time',
        'charge',
        'is_towed',
        'expiration_time',
        'archive'
    );

    //////////////////////// Relations //////////////////////
    public function user() {
        return $this->belongsTo("User", "user_id", "id");
    }

    public function parking() {
        return $this->belongsTo("Parking", "parking_id", "id");
    }

    public function vehicle() {
        return $this->belongsTo("Vehicle", "vehicle_id", "id");
    }

    ////////////////////////// Methods ///////////////////////
    //////////////////////Get particular parking History ////////////////////
    public static function get_parking_history($id) {
        return ParkingHistory::where("id", "=", $id)->with("user")->with("parking.user")->with("vehicle")->first()->toArray();
    }

    //////////////////////Get user parking History ////////////////////
    public static function user_parking_history($usrer_id) {
        return ParkingHistory::where("user_id", "=", $usrer_id)->get();
    }

    //////////////////////Get Expired parking History ////////////////////
    public static function get_expired_parking_history() {
        return ParkingHistory::where("is_towed", "=", 1)->with("parking")->with("vehicle.user")->get()->toArray();
    }

    /////////////////update particular History//////////////
    public static function update_parking_history($data = null) {
        $parking_history = ParkingHistory::where("user_id", "=", $data['user_id'])->where("parking_id", "=", $data['parking_id'])->orderBy('created_at', 'DESC')->first(array('id'))->toArray();
        if (!empty($parking_history['id'])) {
            $history_data = ParkingHistory::where("id", "=", $parking_history['id'])->update($data);
            return $parking_history['id'];
        }
    }

    /////////////////update particular History status//////////////
    public static function update_status($id, $data) {
        $result = ParkingHistory::where("id", "=", $id)->update($data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]