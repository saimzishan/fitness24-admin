<?php

class Day extends Eloquent {

    protected $table = 'days';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'parking_id',
        'day',
        'price_per_hour',
        'max_price'
    );

    //////////////////////// Relations //////////////////////
    public function time() {
        return $this->hasOne("Time", "day_id", "id");
    }

    ////////////////////////// Methods ///////////////////////
    //////////////////////Save Days//////////////////////
    public static function save_days($parking_id, $days) {
        foreach ($days['day'] as $day) {
            $single_day = new Day($days['day']);
            $single_day->day = $day;
            $single_day->price_per_hour = 2;
            $single_day->max_price = 20;
            $single_day->parking_id = $parking_id;
            $single_day->save();
            Time::save_time($single_day->id);
        }
        return $single_day;
    }

    public static function get_all_days($parking_id) {
        return Day::where("parking_id", "=", "$parking_id")->with("time")->get()->toArray();
    }

    public static function get_day_data($parking_id, $day) {
        return Day::where("parking_id", "=", "$parking_id")->where("day", "=", "$day")->with("time")->first()->toArray();
    }

    public static function get_single_day($day_id) {
        return Day::where("id", "=", "$day_id")->with("time")->first()->toArray();
    }

    ////////////////// update Day ///////////////////
    public static function update_day_info($day_id, $day_inputs) {
        return Day::where("id", "=", "$day_id")->update($day_inputs);
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]