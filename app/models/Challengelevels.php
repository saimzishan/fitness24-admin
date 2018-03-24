<?php

class Challengelevels extends Eloquent {

    protected $table = 'challengelevels';
    protected $primaryKey = 'id';
    public $timestamps = false;

     protected $fillable = [
        'challengeID','level', 'No_Of_Days',        
    ];

}
