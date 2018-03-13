<?php

class PlanDays extends Eloquent {

    protected $table = 'plandays';
    protected $guarded = array();
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'planID','dayID',
    ];
}


