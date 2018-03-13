<?php

class Photo extends Eloquent {

    protected $table = 'photos';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'user_id',
        'parking_id',
        'make_id',
        'image',
        'archive'
    );

//////////////////////// Relations //////////////////////
    public function spot() {
        return $this->belongsTo("Parking", "parking_id", "id");
    }

////////////////////////// Methods ///////////////////////
//////////////////////Save Photos//////////////////////
    public static function save_photo($parking_id, $image_name) {
        $result = false;
        foreach ($image_name as $image) {
            $photo = new Photo();
            $photo->parking_id = $parking_id;
            $photo->image = $image;
            if ($photo->save()) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

//////////////////////Get Photos//////////////////////
    public static function get_single_photo($parking_id, $user_id) {
        return Photo::where("user_id", "=", NULL)->where("parking_id", "=", "$parking_id")->first()->toArray();
    }

//////////////////////Save Vehicle type Photos//////////////////////
    public static function save_vehicle_make_photo($make_id, $model_id, $image_name) {
        $photo = new Photo();
        $photo->make_id = $make_id;
        $photo->model_id = $model_id;
        $photo->image = $image_name;
        if ($photo->save()) {
            return true;
        } else {
            return false;
        }
    }

//////////////////////Save Vehicle Model Photos//////////////////////
    public static function save_model_photo($model_id, $image_name) {
        $photo = new Photo();
        $photo->model_id = $model_id;
        $photo->image = $image_name;
        if ($photo->save()) {
            return true;
        } else {
            return false;
        }
    }

//////////////////////All Photos//////////////////////
    public static function get_all_photo($parking_id) {
        return Photo::where("parking_id", "=", "$parking_id")->get()->toArray();
    }

//////////////////////Update Photos//////////////////////
    public static function update_spot_photo($inputs, $user_id, $parking_id, $old_image_name) {
        $result = Photo::where("user_id", "=", "$user_id")->where("parking_id", "=", "$parking_id")->where("image", "=", "$old_image_name")->update($inputs);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

//////////////////////Update Photos//////////////////////
    public static function update_vehicle_make_photo($inputs, $make_id) {
        return Photo::where("make_id", "=", "$make_id")->update($inputs);
    }

//////////////////////Update model Photos//////////////////////
    public static function update_model_photo($model_id, $image) {
        $data = array('model_id' => $model_id, 'image' => $image);
        return Photo::where("model_id", "=", "$model_id")->update($data);
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]