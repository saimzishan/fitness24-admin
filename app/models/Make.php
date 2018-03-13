<?php

class Make extends Eloquent {

    protected $table = 'makes';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'name',
        'archive'
    );

    //////////////////////// Relations //////////////////////
    public function models() {
        return $this->hasMany("Model", "make_id", "id");
    }

    public function photos() {
        return $this->hasOne("Photo", "make_id", "id");
    }

    ////////////////////////// Methods ///////////////////////
    //////////////////////Save new Make//////////////////////
    public static function save_make_model($make, $image) {
        $make_data = new Make($make);
        if ($make_data->save()) {
            $result = Model::save_new_model($make, $make_data->id);
            if ($result) {
                return Photo::save_vehicle_make_photo($make_data->id, $result->id, $image);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //////////////////////Get all Make types////////////////////
    public static function all_vehicle_make() {
        return Make::with("models")->get()->toArray();
    }

    //////////////////////Get single Make types////////////////////
    public static function get_single_vehicle_make($make_id) {
        return Make::where("id", "=", "$make_id")->with("photos")->first()->toArray();
    }

    ////////////////// update make type ///////////////////
    public static function update_make_type($inputs, $make_id) {
        return Make::where("id", "=", "$make_id")->update($inputs);
    }

    //////////////////Change Make status using jquery ajax///////////////////
    public static function archive_make_via_jquery($inputs, $id) {
        Make::where("id", "=", "$id")->update($inputs);
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]