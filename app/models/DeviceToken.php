<?php

class DeviceToken extends Eloquent {

    protected $table = 'device_tokens';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'user_id',
        'lat',
        'lng',
        'timezone',
        'archive'
    );

//////////////////////// Relations //////////////////////
    public function device_token() {
        return $this->belongsTo("User", "user_id", "id");
    }

////////////////////////// Methods ///////////////////////
//////////////////////Save Photos//////////////////////
    public static function save_token($user_id, $timezone) {
        $create = new DeviceToken();
        $create->user_id = $user_id;
        $create->lat = 39.5296329;
        $create->lng = -119.8138027;
        $create->timezone = $timezone;
        if ($create->save()) {
            return true;
        } else {
            return false;
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]