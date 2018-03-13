<?php

class ParkingFeature extends Eloquent {

    protected $table = 'parking_features';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'feature_id',
        'parking_id',
        'archive'
    );

    //////////////////////// Relations //////////////////////
    public function user() {
        return $this->belongsTo("User", "user_id", "id");
    }

    public function feature() {
        return $this->belongsTo("Feature", "feature_id", "id");
    }

    ////////////////////////// Methods ///////////////////////
    //////////////////////Save parking features //////////////////////
    public static function save_parking_features($parking_feature, $parking_id) {
        foreach ($parking_feature['parking_feature'] as $features) {
            $single_feature = new ParkingFeature($parking_feature['parking_feature']);
            $single_feature->feature_id = $features;
            $single_feature->parking_id = $parking_id;
            $single_feature->save();
        }
        return $single_feature;
    }
    
    public static function add_particular_feature($inputs) {
        $feature = new ParkingFeature($inputs);
        if($feature->save()){
            return TRUE;
        }  else {
            return FALSE;
        }
    }

    //////////////////////Get Single Spot//////////////////////
    public static function single_spot_features($spot_id) {
        return ParkingFeature::where("parking_id", "=", "$spot_id")->with("feature")->get()->toArray();
    }

    //////////////////////Get Single Spot//////////////////////
    public static function delete_single_spot_feature($feature_id) {
        if (ParkingFeature::where("id", "=", "$feature_id")->delete()) {
            return true;
        } else {
            return false;
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]