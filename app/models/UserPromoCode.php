<?php

class UserPromoCode extends Eloquent {

    protected $table = 'user_promo_codes';
    protected $primaryKey = 'id';
    protected $guarded = array('coupon');

    public function promo_code() {
        return $this->belongsTo("PromoCode", "promo_code_id", "id");
    }

    public function user() {
        return $this->belongsTo("User", "user_id", "id");
    }

#-----------------------------UserPromoCode Model--------------------------#
# UserPromoCode , UserPromoCode related methods here. #
#------------ -------------------------------------------------------------# 
//    Add user promo code

    public static function add_user_promo_code($data = null) {
        $promo_code = new UserPromoCode($data);
        if ($promo_code->save()) {
            return $promo_code->id;
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]