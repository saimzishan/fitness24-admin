<?php

class Goal extends Eloquent {

    protected $table = 'goals';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
    protected $guarded = array();
    //public $timestamps = false;
   

}

#--------------------------------------------------[Developed by: Maqsood Shah]