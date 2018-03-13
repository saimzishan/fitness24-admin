<?php

class UserLocation extends Eloquent {

    protected $table = 'user_locations';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'user_id',
        'location_id',
        'is_favorite',
        'is_recent_search',
        'archive'
    );

    //////////////////////// Relations //////////////////////
    public function user() {
        return $this->belongsTo("User", "user_id", "id");
    }
    
    public function location() {
        return $this->belongsTo("Location", "location_id", "id");
    }

    ////////////////////////// Methods ///////////////////////
    //////////////////////Get user favorite Locations ////////////////////
    public static function user_favorite_location($user_id) {
        return UserLocation::where("user_id", "=", $user_id)->where("is_favorite", "=", 1)->with("location")->get()->toArray();
    }
    
    ///////////////////////// Get user parking Search ///////////////////////
    public static function user_parking_search($user_id) {
        return UserLocation::where("user_id", "=", $user_id)->where("is_recent_search", "=", 1)->with("location")->get()->toArray();
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]