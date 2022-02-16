<?php

namespace App\Http\Components;

trait SSLCommerz{
    protected $env_type = "live"; //Sandbox Or Live 
    protected $live_url = "https://securepay.sslcommerz.com/";
    protected $sandbox_url = "https://sandbox.sslcommerz.com/";
    protected $store_id = "marriagematchbdlive"; //"testbox";
    protected $store_passwd = "5F181EE55AD8440002"; //"qwerty";

    /**
     * 
     */

    /**
     * Get Transaction Data Based on Transaction_id
     */
    protected function getTransactionData($tran_id, $arr = []){
        $base_url = $this->getBaseUrl($this->env_type);
        $url = $base_url."validator/api/merchantTransIDvalidationAPI.php?tran_id=" . $tran_id;
        $url .= '&store_id=' . $this->store_id . '&store_passwd=' . $this->store_passwd;
        return  $this->curl($url);
    }

    /**
     * Get Base Payment URL
     */
    protected function getBaseUrl($env_type = "Sandbox"){
        if( strtolower($this->env_type) == "live"){
            return $this->live_url;
        }        
        return $this->sandbox_url;
    }

    /**
     * Prepare Post Datafield Array
     * For Transaction
     */
    protected function preparePaymentGetawayData($profile, $amount, $tran_id){
        $post_data = [];
        $post_data['store_id'] = $this->store_id;
        $post_data['store_passwd'] = $this->store_passwd;
        $post_data['total_amount'] = $amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $tran_id;
        $post_data['product_category'] = "Subscription Package";

        $post_data['success_url'] = url('subscription/payment/success');
        $post_data['fail_url'] = url('subscription/payment/fail');
        $post_data['cancel_url'] = url('subscription/payment/cancel');
        # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

        # EMI INFO
        $post_data['emi_option'] = "0";
        #$post_data['emi_max_inst_option'] = "9";
        #$post_data['emi_selected_inst'] = "9";

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $profile->first_name . ' ' .$profile->last_name;
        $post_data['cus_email'] = $profile->email;
        $post_data['cus_add1'] = is_null($profile->user_present_address) ? 'Dhaka' : $profile->user_present_address;
        $post_data['cus_city'] = is_null($profile->user_present_city) ? 'Dhaka' : $profile->user_present_city;
        $post_data['cus_country'] = $profile->user_present_country;
        $post_data['cus_phone'] = $profile->phone;

        # SHIPMENT INFORMATION
        $post_data['shipping_method'] = "NO";
        $post_data['num_of_item '] = 1;

        # OPTIONAL PARAMETERS
        $post_data['product_name'] = "Subscription";
        $post_data['product_category '] = "Subscribe a Package";
        $post_data['product_profile'] = "general";

        return $post_data;
    }
}