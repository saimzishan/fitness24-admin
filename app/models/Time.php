<?php

class Time extends Eloquent {

    protected $table = 'times';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'day_id',
        'time',
        'price',
        'max_price',
        'start_time',
        'end_time'
    );

    //////////////////////// Relations //////////////////////
    public function day() {
        return $this->belongsTo("Day", "day_id", "id");
    }

    ////////////////////////// Methods ///////////////////////
    //////////////////////Save Time//////////////////////
    public static function save_time($day_id) {
        $data = new Time();
        $data->day_id = $day_id;
        $data->start_time = '01:00:00';
        $data->end_time = '23:59:00';
        $data->save();
    }
    
    ////////////////// update Day Time ///////////////////
    public static function update_time_info($day_id, $time_inputs) {
        return Time::where("day_id", "=", "$day_id")->update($time_inputs);
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]