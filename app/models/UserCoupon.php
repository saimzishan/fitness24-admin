<?php

class UserCoupon extends Eloquent {

    protected $table = 'user_coupons';
    protected $guarded = array();
    protected $primaryKey = 'id';
    public $timestamps = false;

   
}
