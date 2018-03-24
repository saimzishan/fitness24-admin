<?php

class Challengeleveldays extends Eloquent {

    protected $table = 'challengeleveldays';
    protected $primaryKey = 'id';
    public $timestamps = false;


     protected $fillable = [
        'challenge_LevelID','DaySeq','No_of_Sets',      
    ];

}
