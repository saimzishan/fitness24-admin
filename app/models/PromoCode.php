<?php

class PromoCode extends Eloquent {

    protected $table = 'coupons';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
    protected $guarded = array();


    //////////////////////// Relations //////////////////////
    ////////////////////////// Methods ///////////////////////
    //////////////////////Save new Promo  Code//////////////////////
    public static function save_promo_code($inputs) {
        $data = new PromoCode($inputs);
        return $data->save();
        
    }
    
    public static function update_promo_code($inputs) {
        $data = PromoCode::where('id', '=', $inputs['id']);
        return $data->update($inputs);
        
    }
    
    ////////////////////// Get all Promo  Code//////////////////////
    public static function all_promo_codes() {
        return PromoCode::with('user')->get()->toArray();
    }
    
    public function user() {
        return PromoCode::hasOne('UserCoupon', "coupon_id", "id");
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]