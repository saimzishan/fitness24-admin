<?php

class Vehicle extends Eloquent {

    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
    public static $update_vehicle_rules = array(
        'licence' => 'required',
        'make' => 'required',
        'model' => 'required',
        'year' => 'required'
    );
//    protected $guarded = array();
    protected $fillable = array(
        'user_id',
        'year',
        'make',
        'model',
        'licence',
        'archive'
    );

    //////////////////////// Relations //////////////////////
    public function user() {
        return $this->belongsTo("User", "user_id", "id");
    }

    ////////////////////////// Methods ///////////////////////
    //////////////////////Creating new User//////////////////////
    public static function save_new_vehicle($inputs, $make) {
        $vehicle = new Vehicle($inputs);
        $vehicle->make = $make;
        if ($vehicle->save()) {
            return true;
        } else {
            return false;
        }
    }

    ////////////////////////Get particular vehicle data////////////////
    public static function get_vehicle_by_id($user_id, $vehicle_id) {
        return Vehicle::where("id", "=", $vehicle_id)->where("user_id", "=", $user_id)->first();
    }

    ////////////////////////Update particular vehicle////////////////
    public static function update_vehicle($id, $vehicle_update) {
        $result = Vehicle::where("id", "=", $id)->update($vehicle_update);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    ////////////////////////Get all vehicles////////////////
    public static function get_all_vehicles($user_id) {
        return Vehicle::where("user_id", "=", $user_id)->get()->toArray();
    }

    //////////////////Change Vehicle status using jquery ajax///////////////////
    public static function archive_vehicle_via_jquery($inputs, $id) {
        Vehicle::where("id", "=", "$id")->update($inputs);
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]