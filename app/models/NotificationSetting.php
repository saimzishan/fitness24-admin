<?php

class NotificationSetting extends Eloquent {

    protected $table = 'notification_settings';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'user_id',
        'archive'
    );

//////////////////////// Relations //////////////////////
    public function notification() {
        return $this->belongsTo("User", "user_id", "id");
    }

////////////////////////// Methods ///////////////////////
//////////////////////Save Photos//////////////////////
    public static function save_settings($user_id) {
        $create = new NotificationSetting();
        $create->user_id = $user_id;
        if ($create->save()) {
            return true;
        } else {
            return false;
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]