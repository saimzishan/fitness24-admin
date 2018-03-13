<?php

class Feature extends Eloquent {

    protected $table = 'features';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'feature',
        'archive'
    );

    //////////////////////// Relations //////////////////////
    ////////////////////////// Methods ///////////////////////
    //////////////////////Creating new Feature//////////////////////
    public static function save_new_feature($inputs) {
        $feature = new Feature($inputs);
        if ($feature->save()) {
            return true;
        } else {
            return false;
        }
    }

    //////////////////////Get All Feature//////////////////////
    public static function all_feature() {
        return Feature::get();
    }

    //////////////////////Get All Feature//////////////////////
    public static function get_single_feature($id) {
        return Feature::where("id", "=", "$id")->first();
    }

    //////////////////////Update Single Feature//////////////////////
    public static function update_particular_feature($inputs, $id) {
        $result = Feature::where("id", "=", "$id")->update($inputs);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]