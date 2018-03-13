<?php

class UserVideo extends Eloquent {

    protected $table = 'videos';
    protected $guarded = array();
    protected $primaryKey = 'id';
    //public $timestamps = false;

    public function categories() {
        return $this->belongsTo("Category", "category_id", "id");
    }
   //////////////////////Count all videos////////////////////
    public static function count_all_videos() {
        return UserVideo::where("archived", "=", 0)->where('is_nutrition', '!=', 1)->count();
    }
    public static function count_nutrition_videos() {
        return UserVideo::where('is_nutrition', '=', 1)->count();
    }
    public static function get_all_videos() {
        return User::where("archived", "=", 0)->get();
    }
}
