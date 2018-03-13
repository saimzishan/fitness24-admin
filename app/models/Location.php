<?php

class Location extends Eloquent {

    protected $table = 'locations';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'name',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'lat',
        'lng',
        'archive'
    );

    //////////////////////// Relations //////////////////////

    ////////////////////////// Methods ///////////////////////

}

#--------------------------------------------------[Developed by: Maqsood Shah]