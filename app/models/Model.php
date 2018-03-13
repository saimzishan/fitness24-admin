<?php

class Model extends Eloquent {

    protected $table = 'models';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'make_id',
        'model',
        'generation',
        'archive'
    );

    //////////////////////// Relations //////////////////////
    public function make() {
        return $this->belongsTo("Make", "make_id", "id");
    }
    
    public function photos() {
        return $this->hasOne("Photo", "model_id", "id");
    }

    ////////////////////////// Methods ///////////////////////
    //////////////////////Save new Model//////////////////////
    public static function save_new_model($model, $make_id) {
        $model_data = new Model($model);
        $model_data->make_id = $make_id;
        if ($model_data->save()) {
            return $model_data;
        } else {
            return false;
        }
    }

    //////////////////////Get Make Models////////////////////
    public static function vehicle_models($make_id) {
        return Model::where("make_id", "=", "$make_id")->get()->toArray();
    }

    //////////////////Change Model status using jquery ajax///////////////////
    public static function archive_model_via_jquery($inputs, $id) {
        Model::where("id", "=", "$id")->update($inputs);
    }

    //////////////////Get Model///////////////////
    public static function get_model($id, $make_id) {
        return Model::where("id", "=", "$id")->where("make_id", "=", "$make_id")->with("photos")->first()->toArray();
    }

    ////////////////// update single Model ///////////////////
    public static function update_single_model($inputs, $model_id) {
        return Model::where("id", "=", "$model_id")->update($inputs);
    }
    
    //////////////////Get particular Model///////////////////
    public static function get_particular_model($id) {
        return Model::where("id", "=", "$id")->with("photos")->first()->toArray();
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]