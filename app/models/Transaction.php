<?php

class Transaction extends Eloquent {

    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'user_id',
        'host_id',
        'parking_id',
        'transaction_id',
        'card_type',
        'token',
        'amount',
        'status',
        'archive'
    );

    //////////////////////// Relations //////////////////////
    public function customer_transaction() {
        return $this->belongsTo("User", "user_id", "id");
    }

    public function merchant_transaction() {
        return $this->belongsTo("User", "host_id", "id");
    }

    ////////////////////////// Methods ///////////////////////

    public static function get_merchant_payments($user_id) {
        return Transaction::where("host_id", "=", "$user_id")->with("customer_transaction")->get()->toArray();
    }

    public static function save_transaction($data = null) {
        $transaction = new Transaction($data);
        if ($transaction->save()) {
            return $transaction->id;
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]