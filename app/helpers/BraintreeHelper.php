<?php

class BraintreeHelper {
    #-------------------------- Helper Purpose -------------------#
    # BraintreeHelper , payment related methods will be here.
    #--------------------------------------------------------------#

//    public static $braintree_sandbox = array(
//        "merchant_id" => "4q8nxvmkg5rm2hsd",
//        "public_key" => "myk92nhvctgtj4h7",
//        "private_key" => "cdc8d43ec77f785a871b09f9e83ef507"
//    );
//    public static $braintree_production = array(/// please change when get production keys.
//        "merchant_id" => "4q8nxvmkg5rm2hsd",
//        "public_key" => "myk92nhvctgtj4h7",
//        "private_key" => "cdc8d43ec77f785a871b09f9e83ef507"
//    );

    ////////////////// Braintree Configuration /////////////////////
    public static function configure_braintree() {
        Braintree_Configuration::environment('sandbox');
//        Braintree_Configuration::merchantId(BraintreeHelper::$braintree_sandbox['merchant_id']);
//        Braintree_Configuration::publicKey(BraintreeHelper::$braintree_sandbox['public_key']);
//        Braintree_Configuration::privateKey(BraintreeHelper::$braintree_sandbox['private_key']);
        Braintree_Configuration::merchantId('prsp9xqpy2xzzkbp');
        Braintree_Configuration::publicKey('8ymv7djwq4s7k7jj');
        Braintree_Configuration::privateKey('e4aeb57d8bc15df0bcaf1356e544e47f');
    }

    /////////////////////// Create Marchent ///////////////////
    public static function create_merchant($inputs, $lat_long) {
        $result_data = array();
        BraintreeHelper::configure_braintree();
        $result = Braintree_MerchantAccount::create(
                        [
                            'individual' => BraintreeHelper::process_individual_param($inputs, $lat_long),
                            'funding' => BraintreeHelper::process_funding_param($inputs),
                            'tosAccepted' => true,
                            'masterMerchantAccountId' => "fy4my88f6ys8qjrr"
                        ]
        );
        if ($result->success) {
            $result_data['status'] = "success";
            $result_data['merchant_id'] = $result->merchantAccount->id;
        } else {
            foreach ($result->errors->deepAll() AS $error) {
                $result_data['status'] = "error";
                $result_data['message'] = $error->message;
            }
        }
        return $result_data;
    }

    public static function process_individual_param($inputs, $lat_long) {
        $address = CommonHelper::get_lat_long_address($lat_long["lat"], $lat_long["lng"]);
        if ($address) {
            $address = [
                'streetAddress' => $address['street'],
                'locality' => $address['locality'],
                'region' => $address['region'],
                'postalCode' => $address['postal_code']
            ];
        }
        $array = ['firstName' => $inputs["first_name"],
            'lastName' => $inputs["first_name"],
            'email' => $inputs["email"],
            'dateOfBirth' => '1990-01-01',
            'address' => $address
        ];
        return $array;
    }

    public static function process_funding_param($inputs) {
        $funding = [
            'descriptor' => 'ilsa interactive',
            'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
            'email' => $inputs["email"],
            'accountNumber' => $inputs["account_no"],
            'routingNumber' => $inputs["routing_no"]
        ];
        return $funding;
    }

    ///////////////////// update merchant account ///////////////////
    public static function update_merchant($merchant_id, $inputs, $lat_long) {
        $result_data = array("status" => "error", "message" => "Braintree merchant not found");
        if (BraintreeHelper::find_merchant($merchant_id)) {
            $result = Braintree_MerchantAccount::update(
                            $merchant_id, [
                        'individual' => BraintreeHelper::process_individual_param($inputs, $lat_long),
                        'funding' => BraintreeHelper::process_funding_param($inputs),
                            ]
            );
            if ($result->success) {
                $data = array("account_no" => $result->merchantAccount->funding['accountNumberLast4'], "routing_no" => $result->merchantAccount->funding['routingNumber']);

                $result_data = array("status" => "success", "data" => $data);
            } else {
                foreach ($result->errors->deepAll() AS $error) {
                    $result_data = array("status" => "error", "message" => $error->message);
                }
            }
        }
        return $result_data;
    }

    # return merchant account , routing no if merchant found

    public static function find_merchant($merchant_id) {
        BraintreeHelper::configure_braintree();
        $merchantAccount = Braintree_MerchantAccount::find($merchant_id);
        if ($merchantAccount) {
            return array("account_no" => $merchantAccount->funding['accountNumberLast4'], "routing_no" => $merchantAccount->funding['routingNumber']);
        } else {
            return false;
        }
    }

    //////////////////////// Find region of Marchent ///////////////////
    public static function merchant_country_check($lat_long) {
        $address = CommonHelper::get_lat_long_address($lat_long["lat"], $lat_long["lng"]);
        if ($address && $address['country'] == "US") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //////////////////////// Create Customer ////////////////////
    public static function create_braintree_customer($inputs) {
        $result_data = array("status" => "error", "message" => "Please try again later");
        BraintreeHelper::configure_braintree();
        $result = Braintree_Customer::create([
                    'firstName' => $inputs['first_name'],
                    'lastName' => $inputs['last_name'],
                    'company' => 'Gravel',
                    'email' => $inputs['email'],
        ]);
        if ($result->success) {
            $result_data['status'] = "success";
            $result_data['brain_tree_customer_id'] = $result->customer->id; # Generated customer id
        } else {
            foreach ($result->errors->deepAll() AS $error) {
                $result_data['status'] = "error";
                $result_data['message'] = $error->message;
            }
        }
        return $result_data;
    }

    public static function find_braintree_customer($customer_id) {
        BraintreeHelper::configure_braintree();
        return Braintree_Customer::find($customer_id);
    }

    public static function create_payment_method($customer_id, $inputs) {
        BraintreeHelper::configure_braintree();
        $result_data = array("status" => "error", "message" => "Please try again later");
        $result = Braintree_CreditCard::create([
                    'customerId' => $customer_id,
//                    'cardholderName' => $inputs["credit_card_name"],
                    'cvv' => $inputs["cvv"],
                    'number' => $inputs["credit_card_no"],
                    'expirationMonth' => $inputs["expirationMonth"],
                    'expirationYear' => $inputs["expirationYear"],
                    'options' => [
                        'failOnDuplicatePaymentMethod' => true
                    ]
        ]);
        if ($result->success) {
            $result_data = array('status' => "success", "message" => "success", "card_details" => $result);
        } else {
            foreach ($result->errors->deepAll() AS $error) {
                $result_data['status'] = "error";
                $result_data['message'] = $error->message;
            }
        }
        return $result_data;
    }

    public static function get_payment_methods($customer_id) {
        $payment_methods = array();
        $customer = BraintreeHelper::find_braintree_customer($customer_id);
        if (isset($customer->creditCards) && count($customer->creditCards) > 0) {
            foreach ($customer->creditCards as $method) {
                $card = array();
                $card["cardType"] = $method->cardType;
                $card["cardholderName"] = $method->cardholderName;
                $card["number"] = $method->last4;
                $card["expirationMonth"] = $method->expirationMonth;
                $card["expirationYear"] = $method->expirationYear;
                $card["token"] = $method->token;
                $payment_methods[] = $card;
            }
        }
        return $payment_methods;
    }

    public static function update_payment_method($card_token, $inputs) {
        BraintreeHelper::configure_braintree();
        $result_data = array("status" => "error", "message" => "Please try again later");
        $result = Braintree_CreditCard::update($card_token, $inputs);
        if ($result->success) {
            $result_data = array('status' => "success", "message" => "success", "card_details" => $result);
        } else {
            foreach ($result->errors->deepAll() AS $error) {
                $result_data['status'] = "error";
                $result_data['message'] = $error->message;
            }
        }
        return $result_data;
    }

    public static function delete_payment_method($card_token) {
        BraintreeHelper::configure_braintree();
        $result_data = array("status" => "error", "message" => "Please try again later");
        $result = Braintree_CreditCard::delete($card_token);
        if ($result->success) {
            $result_data = array('status' => "success", "message" => "success", "card_details" => $result);
        } else {
            foreach ($result->errors->deepAll() AS $error) {
                $result_data['status'] = "error";
                $result_data['message'] = $error->message;
            }
        }
        return $result_data;
    }

    #======================================= End of BraintreeHelper Class ===============================
}

#--------------------------------------------------[Developed by: Maqsood Shah]