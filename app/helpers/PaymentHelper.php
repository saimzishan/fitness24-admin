<?php

Class PaymentHelper {

    public static $checkout_params = array(
        'user_id' => 'required|Integer',
        'parking_id' => 'required|Integer',
        'host_id' => 'required|Integer',
        'customer_id' => 'required',
        'checkout_time' => 'required',
        'charge' => 'required',
    );

    #----------------------------------------/Helper Functions\--------------------------------------

    public static function add_credit_card() {
        $inputs = Input::all();
        $id = Request::get('user_id');
        $customer = User::get_user_by_id($id);
        if ($customer['customer_id'] == NULL || $customer['customer_id'] == "") {
            $braintree_customer = BraintreeHelper::create_braintree_customer($customer);
            if ($braintree_customer['status'] == "success") {
                $result = User::braintree_customer_user_update($id, $braintree_customer['brain_tree_customer_id']);
                return PaymentHelper::process_credit_card($id, $result, $braintree_customer['brain_tree_customer_id'], $inputs);
            } else {
                return Redirect::back()->with('message', "danger= " . $braintree_customer['message']);
            }
        } else {
            $result = TRUE;
            return PaymentHelper::process_credit_card($id, $result, $customer['customer_id'], $inputs);
        }
    }

    public static function process_credit_card($id, $result, $braintree_customer_id, $inputs) {
        if ($result) {
            $method = BraintreeHelper::create_payment_method($braintree_customer_id, $inputs);
            if ($method['status'] == "success") {
                return Redirect::route('user_credit_cards', array('id' => $id))->with('message', "success= Credit card Successfully added");
            } else {
                return Redirect::back()->with('message', "danger= " . $method['message']);
            }
        } else {
            return Redirect::back()->with('message', "danger= Customer data could not be updated");
        }
    }

    public static function post_merchant() {
        $user_id = Input::get("user_id");
        $lat_long = CommonHelper::getLatAndLongFromAddress(Input::get("address"));
        $address_info = CommonHelper::get_lat_long_address($lat_long['lat'], $lat_long['lng']);
        $inputs = Input::all();
        return PaymentHelper::create_merchant($inputs, $user_id, $address_info);
    }

    // create merchant account 
    public static function create_merchant($data = null, $user_id, $address_info) {
        BraintreeHelper::configure_braintree();
        $host = User::get_user_by_id($user_id)->toArray();
        if (empty($host['merchant_id'])) {
            $result = PaymentHelper::createMerchantAccount($host, $data, $address_info);
            if ($result->success) {
                $host['merchant_id'] = $result->merchantAccount->id;
                $is_updated = User::update_user_with_id($host);
                if (!empty($is_updated)) {
                    return Redirect::route('add_parking_spot', array('id' => $user_id))->with('message', "success= Merchant created Successfully");
//                    return Response::json(array('success' => 'true', 'message' => AppHelper::$all_messages['merchant_created']));
                } else {
                    return Redirect::back()->withInput()->with('message', "danger= Merchant could not be created");
                }
            } else {
                $error_msg = "Please try again later";
                if ($result->errors) {
                    foreach ($result->errors->deepAll() AS $error) {
                        $error_msg = $error->message;
                    }
                }
//                return Response::json(array('success' => 'false', 'message' => $error_msg));
                return Redirect::back()->withInput()->with('message', "danger= " . $error_msg);
            }
        } else {
            return Redirect::route('add_parking_spot', array('id' => $user_id));
        }
    }

    // create merchant on braintree
    public static function createMerchantAccount($host_info = null, $merchant_data = null, $address_info) {
        $host_info['phone_number'] = str_replace("+92", "0", $host_info['phone_number']);
        $host_info['phone_number'] = str_replace("-", "", $host_info['phone_number']);
        if (!empty($merchant_data['name'])) {
            $name = explode(" ", $merchant_data['name']);
            if (empty($name[1])) {
                $first_name = $name[0];
                $last_name = $name[0];
            } else {
                $first_name = $name[0];
                $last_name = $name[1];
            }
        }
        $result = Braintree_MerchantAccount::create(array(
                    'individual' => array(
                        'firstName' => $first_name,
                        'lastName' => $last_name,
                        'email' => $host_info['email'],
//                        'phone' => $host_info['phone_number'],
                        'dateOfBirth' => $merchant_data['dob'],
                        //'ssn' => '456-45-4567',
                        'address' => array(
                            'streetAddress' => $address_info['street'],
                            'locality' => $merchant_data['city'],
                            'region' => $merchant_data['state'],
                            'postalCode' => $merchant_data['zipcode'],
                        )
                    ),
                    'funding' => array(
                        //            'descriptor' => 'Blue Ladders',
                        'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
                        'email' => $host_info['email'],
//                        'mobilePhone' => $host_info['phone_number'],
                        'accountNumber' => $merchant_data['account_no'],
                        'routingNumber' => $merchant_data['routing_no'],
                    ),
                    'tosAccepted' => true,
                    'masterMerchantAccountId' => "gravel",
//            'masterMerchantAccountId' => "5qz85d4vw7rqgrft",
        ));
        return $result;
    }

    public static function credit_cards($id) {
        $result = array();
        $customer = User::get_user_by_id($id);
        $braintree_id = $customer['customer_id'];
        if ($braintree_id != "" || $braintree_id != NULL) {
            $result = BraintreeHelper::get_payment_methods($braintree_id);
            return $result;
        }
        return $result;
    }

    public static function update_credit_card() {
        $inputs = Request::only('number', 'cvv', 'expirationYear', 'expirationMonth');
        $token = Request::get('token');
        $id = Request::get('user_id');
        $result = BraintreeHelper::update_payment_method($token, $inputs);
        if ($result['status'] == "success") {
            return Redirect::route('user_credit_cards', array('id' => $id))->with('message', "success= Credit Card Successfully updated");
        } else {
            return Redirect::back()->with('message', "danger= " . $result['message']);
        }
    }

    public static function delete_credit_card($id, $token) {
        $result = BraintreeHelper::delete_payment_method($token);
        if ($result['status'] == "success") {
            return Redirect::route('user_credit_cards', array('id' => $id))->with('message', "success= Credit Card Successfully deleted");
        } else {
            return Redirect::back()->with('message', "danger= " . $result['message']);
        }
    }

    public static function save_promo_code() {
        $coupon = Str::random(8);
        $users = User::get_users();
        $state = Input::get("state");
        $city = Input::get("city");
        $inputs = Input::except("send_to", "email", "name", "city", "state");
        $result = PromoCode::save_promo_code($inputs, $coupon);
        if ($result) {
            if (!empty($state)) {
                if ($state == 'all') {
                    return PaymentHelper::process_promo_code($users, $coupon);
                } else {
                    return PaymentHelper::promo_code_process($users, $coupon, $state, $city);
                }
            } else {
                $data = array(
                    'coupon' => $coupon,
                    'email' => Input::get("email"),
                    'name' => Input::get("name")
                );
                CommonHelper::send_email($data, 'emails.myemail', "Gravel Coupon Received");
                return Redirect::route('all_promo_codes')->with('message', "success= Promo Code Successfully sent");
            }
        } else {
            return Redirect::back()->with('message', "danger= Promo Code could not be added");
        }
    }

    public static function process_promo_code($users, $coupon) {
        foreach ($users as $user) {
            $data = array(
                'coupon' => $coupon,
                'email' => $user['email'],
                'name' => $user['first_name']
            );
            CommonHelper::send_email($data, 'emails.myemail', "Gravel Coupon Received");
        }
        return Redirect::route('all_promo_codes')->with('message', "success= Promo Code Successfully sent");
    }

    public static function promo_code_process($users, $coupon, $state, $city) {
        foreach ($users as $user) {
            $data = array();
            $address = CommonHelper::get_lat_long_address($user['devicetoken']['lat'], $user['devicetoken']['lng']);
            if ($address['region'] == $state && $city == 'all') {
                $data = array(
                    'coupon' => $coupon,
                    'email' => $user['email'],
                    'name' => $user['first_name']
                );
            } else {
                if ($address['region'] == $state && $address['region'] == $city) {
                    $data = array(
                        'coupon' => $coupon,
                        'email' => $user['email'],
                        'name' => $user['first_name']
                    );
                }
            }
            if (!empty($data)) {
                CommonHelper::send_email($data, 'emails.myemail', "Gravel Coupon Received");
            }
        }
        return Redirect::route('all_promo_codes')->with('message', "success= Promo Code Successfully sent");
    }

    // checkout
    public static function checkout($data, $parking_history, $current_day, $current_time, $current_date, $history_id) {
        try {
            $validation = Validator::make($data, PaymentHelper::$checkout_params);
            if ($validation->fails()) {
                return Redirect::route('vehicle_list')->with('message', "danger=" . $validation->errors()->first());
            } else {
                $model_gen = explode("=", $parking_history['vehicle']['model']);
                $email_data = array(
                    'email' => $parking_history['user']['email'],
                    'host_first_name' => $parking_history['parking']['user']['first_name'],
                    'host_last_name' => $parking_history['parking']['user']['last_name'],
                    'host_email' => $parking_history['parking']['user']['email'],
                    'vehicle_plate' => $parking_history['vehicle']['licence'],
                    'vehicle_make' => $parking_history['vehicle']['make'],
                    'vehicle_model' => $model_gen[0],
                    'driver_first_name' => $parking_history['user']['first_name'],
                    'driver_last_name' => $parking_history['user']['last_name'],
                    'street' => $parking_history['parking']['address'],
                    'city' => $parking_history['parking']['city'],
                    'state' => $parking_history['parking']['state'],
                    'country' => $parking_history['parking']['country'],
                    'day' => $current_date,
                    'driver_parking_time' => $parking_history['parking_time'],
                    'parking_start_time' => $current_day['time']['start_time'],
                    'parking_end_time' => $current_day['time']['end_time'],
                    'current_time' => $current_time['time'],
                    'price_per_hour' => $current_day['price_per_hour'],
                    'charges' => $data['charge'],
                );
                return PaymentHelper::checkout_user($data, $email_data, $history_id);
            }
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }

    // checkout
    public static function checkout_user($data = null, $email_data, $history_id) {
//        AppHelper::braintreeAccount();
        BraintreeHelper::configure_braintree();
        $host = User::get_user_by_id($data['host_id'])->toArray();
        if (!empty($host['merchant_id'])) {
            $user_promo_codes = UserPromoCode::where('user_id', '=', $data['user_id'])
                            ->where('parking_id', '=', null)
                            ->with(["promo_code" => function($query) {
                                    $query->select(["id", "type", "value"]);
                                }])->get(array('id', 'promo_code_id'))->toArray();
                    if (!empty($user_promo_codes)) {
                        $data['charge'] = PaymentHelper::promo_code_concession($data, $user_promo_codes);
                    }
                    $data['merchant_id'] = $host['merchant_id'];
                    return PaymentHelper::checkout_transaction_response($data, $email_data, $history_id);
                } else {
                    return Redirect::route('vehicle_list')->with('message', "danger= This host is not a Merchant");
                }
            }

//    promo code amount concession
            public static function promo_code_concession($data = null, $user_promo_codes = null) {
                foreach ($user_promo_codes as $value) {
                    if ($value["promo_code"]["type"] == 'percentage' && $data['charge'] != 0) {
                        $percent_amount = ($value["promo_code"]["value"] / 100) * $data['charge'];
                        $new_amount = $data['charge'] - $percent_amount;
                        $data['charge'] = ($new_amount > 0) ? $new_amount : 0;
                        UserPromoCode::where("id", "=", $value['id'])->update(array('parking_id' => $data['parking_id']));
                    } elseif ($value["promo_code"]["type"] == 'float' && $data['charge'] != 0) {
                        $new_amount = $data['charge'] - $value["promo_code"]["value"];
                        $data['charge'] = ($new_amount > 0) ? $new_amount : 0;
                        UserPromoCode::where("id", "=", $value['id'])->update(array('parking_id' => $data['parking_id']));
                    }
                }
                return $data['charge'];
            }

//    checkout set merchant id of host
            public static function checkout_transaction_response($data, $email_data, $history_id) {
                if ($data['charge'] > 0) {
                    $result = PaymentHelper::braintreeTransaction($data);
                    if ($result->success) {
                        $status_data = array('id' => $history_id, 'is_towed' => 2);
                        $change_status = ParkingHistory::update_status($history_id, $status_data);
                        $output_data = PaymentHelper::braintree_tansaction_saving($result, $data);
                        CommonHelper::send_email($email_data, 'emails.driverEmail', "Gravel Vehicle Status");
                        $email_data['email'] = $email_data['host_email'];
                        CommonHelper::send_email($email_data, 'emails.hostEmail', "Gravel Vehicle Status");
                        if (!empty($output_data['transaction_id']) && !empty($output_data['parking_history_id'])) {
                            $total_praking_time = PaymentHelper::get_total_parking_time($output_data['parking_history_id']);
//                            return Response::json(array('success' => 'true', 'data' => array('parking_time' => $total_praking_time)));
                            return Redirect::route('vehicle_list')->with('message', "success= Successfully checkout");
                        } else {
//                            return Response::json(array('success' => 'true', 'message' => AppHelper::$all_messages['data_not_saved']));
                            return Redirect::route('vehicle_list')->with('message', "danger= Data_not_saved");
                        }
                    } else {
                        $error_msg = "Please try again later";
                        if ($result->errors) {
                            foreach ($result->errors->deepAll() AS $error) {
                                $error_msg = $error->message;
                            }
                        }
//                        return Response::json(array('success' => 'false', 'message' => $error_msg));
                        return Redirect::route('vehicle_list')->with('message', "danger=" . $error_msg);
                    }
                } else {
                    $status_data = array('id' => $history_id, 'is_towed' => 2);
                    $change_status = ParkingHistory::update_status($history_id, $status_data);
                    $parking_inputs = array('id' => $data['parking_id'], 'is_reserved' => 0);
                    $is_updated_parking = Parking::update_spot($data['parking_id'], $parking_inputs);
                    $history_inputs = array('parking_id' => $data['parking_id'], 'user_id' => $data['user_id'], 'checkout_time' => $data['checkout_time'], 'charge' => $data['charge']);
                    $output_data['parking_history_id'] = ParkingHistory::update_parking_history($history_inputs);
//                    $output_data['parking_history_id'] = ParkingHistory::update_parking_history($history_inputs);
                    $total_praking_time = PaymentHelper::get_total_parking_time($output_data['parking_history_id']);
//                    return Response::json(array('success' => 'true', 'data' => array('parking_time' => $total_praking_time)));
                    return Redirect::route('vehicle_list')->with('message', "success= Successfully checkout");
                }
            }

            // braintree transaction
            public static function braintreeTransaction($data = null) {
                $result = Braintree_Transaction::sale(array(
                            'amount' => $data['charge'],
                            'merchantAccountId' => $data['merchant_id'],
                            'customerId' => $data['customer_id'],
                            'options' => array(
                                'submitForSettlement' => true,
                                'holdInEscrow' => true,
                            ),
                            'serviceFeeAmount' => "0"
                                )
                );
                return $result;
            }

            // user, parking and trasaction info saving on local database
            public static function braintree_tansaction_saving($result = null, $data = null) {
                $parking_inputs = array('id' => $data['parking_id'], 'is_reserved' => 0);
                $is_updated_parking = Parking::update_spot($data['parking_id'], $parking_inputs);
                $history_inputs = array('parking_id' => $data['parking_id'], 'user_id' => $data['user_id'], 'checkout_time' => $data['checkout_time'], 'charge' => $data['charge']);
                $output_data['parking_history_id'] = ParkingHistory::update_parking_history($history_inputs);
                if (!empty($output_data['parking_history_id'])) {
                    $transaction_inputs = array(
                        'user_id' => $data['user_id'],
                        'host_id' => $data['host_id'],
                        'parking_id' => $data['parking_id'],
                        'transaction_id' => $result->transaction->id,
                        'token' => $result->transaction->creditCard['token'],
                        'amount' => $result->transaction->amount,
                        'card_type' => $result->transaction->creditCard['cardType'],
                        'status' => $result->transaction->status,
                    );
                    $output_data['transaction_id'] = Transaction::save_transaction($transaction_inputs);
                    return $output_data;
                } else {
                    $parking_inputs = array('id' => $data['parking_id'], 'is_reserved' => 2);
                    $is_updated_parking = Parking::update_spot($data['parking_id'], $parking_inputs);
                }
            }

            // get total parking time from history
            public static function get_total_parking_time($parking_history_id = null) {
                $history_data = ParkingHistory::where("id", "=", $parking_history_id)->first(array('parking_time', 'checkout_time'))->toArray();
                $parking_time = strtotime($history_data['checkout_time']) - strtotime($history_data['parking_time']);
                $total_parking_time = round(($parking_time / 3600), 1);
                if (!empty($total_parking_time) && ($total_parking_time > 0)) {
                    if ($total_parking_time < 1) {
                        $total_parking_time = round(($parking_time / 60), 1) . ' mints';
                    } else {
                        $total_parking_time = $total_parking_time . ' hrs';
                    }
                } else {
                    $total_parking_time = '0 sec';
                }
                return $total_parking_time;
            }

            #======================================= End of PaymentHelper Class ===============================
        }

#--------------------------------------------------------------[Developed by: Maqsood Shah]