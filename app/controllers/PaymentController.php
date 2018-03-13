<?php

class PaymentController extends \BaseController {

    ///////////////////// Add Credit card view //////////////////////
    public function add_credit_card($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            return View :: make("creditCardViews.add_credit_card", compact("user_id", "user"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////////// Add Credit card //////////////////////
    public function post_credit_card() {
        try {
            return PaymentHelper::add_credit_card();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////// Edit Credit card view ///////////
    public function edit_credit_card($id, $token) {
        try {
            $user_id = $id;
            $user = UserHelper::get_particular_user($user_id);
            return View :: make("creditCardViews.edit_credit_card", compact("user_id", "token", "user"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////// Edit Credit card ///////////
    public function update_credit_card() {
        try {
            return PaymentHelper::update_credit_card();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    ///////////////// Delete Credit card ///////////
    public function delete_credit_card($id, $token) {
        try {
            return PaymentHelper::delete_credit_card($id, $token);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
    ///////////////// All Credit cards view ///////////
    public function user_credit_cards($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $credit_cards = PaymentHelper::credit_cards($user_id);
            return View::make("creditCardViews.user_credit_cards", compact("credit_cards", "user_id", "user"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
    ///////////// Merchant payment history view /////////////
    public function merchant_payments($user_id) {
        try {
            $user = UserHelper::get_particular_user($user_id);
            $merchant_payments = Transaction::get_merchant_payments($user_id);
            return View :: make("payments.merchant_payment", compact("merchant_payments", "user_id", "user"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]
