<?php

namespace App\Http\Components;

use App\Package;
use App\PaymentTransactionDetails;
use App\SubscribePackage;
use App\SubscribePackageDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait Subscription{

    /**
     * Get Available Subscription Packages
     */
    protected function getPackages(){
        return Package::where('status', true)->orderBy('current_fee', 'ASC')->get();
    }

    /**
     * Store Sunscription Package Data
     * Store the data when subscribe a package
     */
    protected function subscriptionConfirmed($package){
        $user = User::find(Auth::user()->id);
        $subscription_package = $this->addSubscribePackage($user, $package);
        $this->addSubscriptionPackageDetails($subscription_package, $package);
        return $subscription_package;
    }

    /**
     * Add Subscribe Package Info
     */
    protected function addSubscribePackage($user, $package, $tran_id = Null, $paid_amount = 0, $payment_status = 'due', $payment_mode = "online", $payment_method = "sslcommerz", $comments = Null){
        
        $package_remain_days = $this->getPackageRemainDays($user);
        $data = new SubscribePackage();
        $data->user_id = $user->id;
        $data->package_id = $package->id;
        $data->activation_date = date('Y-m-d');
        $data->expire_date = $this->calculateExpireDate($package->duration, $package->duration_type, $package_remain_days);
        $data->payment_amount = $package->current_fee;
        $data->paid_amount = $paid_amount;
        $data->tran_id = !empty($tran_id)  ? $tran_id : $this->generateTranId();
        $data->payment_status = $payment_status;
        $data->payment_type = $payment_mode;
        $data->payment_method = $payment_method;
        $data->comments = $comments;
        $data->save();
        
        $user->subscribe_package_id = $data->id;
        $user->save();
        return $data;
    }

    /**
     * Calculate Package Expire Date
     */
    protected function calculateExpireDate($duration, $type, $remain_days = 0){
        $expire_date = "";
        switch ($type) {
            case 'day':
                $expire_date = Carbon::now()->addDays($duration + $remain_days)->format('Y-m-d');
                break;
            case 'month':
                $expire_date = Carbon::now()->addMonths($duration)->addDays($remain_days)->format('Y-m-d');
                    break;
            case 'year':
                $expire_date = Carbon::now()->addYears($duration)->addDays($remain_days)->format('Y-m-d');
                break;            
            default:
                $expire_date = Carbon::now()->addDays(30 + $remain_days)->format('Y-m-d');
                break;
        }
        return $expire_date;
    }

    /**
     * Calculate Package Remain Days
     */
    protected function getPackageRemainDays($user){
        $subscribe_package = $user->subscribePackage;
        if(isset($subscribe_package->expire_date)  && $subscribe_package->expire_date > date('Y-m-d') ){
            return Carbon::parse($subscribe_package->expire_date)->diffInDays() + 1;
        }
        return 0;
    }

    /**
     * Generate Transaction ID
     */
    protected function generateTranId(){
        return 'MMBD-'.time();
    }

    /**
     * Store Subscription Package Details Information
     */
    protected function addSubscriptionPackageDetails($subscription_package, $package){
        $data = new SubscribePackageDetails();
        $data->subscribe_package_id = $subscription_package->id;
        $data->title = $package->title;
        $data->description = $package->description;
        $data->image_path = $package->image_path;
        $data->image_64 = $package->image_64;
        $data->profile_view = $package->profile_view;
        $data->contact_details = $package->contact_details;
        $data->total_proposal = $package->total_proposal;
        $data->daily_proposal = $package->daily_proposal;
        // $data->total_send_message = $package->total_send_message;
        // $data->daily_send_message = $package->daily_send_message;
        $data->block_profile = $package->block_profile;
        $data->accept_proposal = $package->accept_proposal;
        // $data->decline_proposal = $package->decline_proposal;
        $data->post_photo = $package->post_photo;
        $data->save();
    }

    /**
     * Store Payment Transaction Details
     */
    protected function savePaymentTrasactionData($request, $user_id){
        $data = $request->all();
        $data['user_id'] = $user_id;
        PaymentTransactionDetails::create($data);
    }

    /**
     * Save Offline Transaction Data
     */
    protected function saveOfflinePaymentTransactionData($request, $tran_id){
        $data = [
            'user_id' => $request->user_id,
            'tran_id' => $tran_id,
            'val_id' => $tran_id,
            'card_type' => $request->payment_method,
            'amount' => $request->paid_amount,
            'store_amount' => $request->paid_amount,
            'status' => $request->payment_status,
            'tran_date' => Carbon::now(),
        ];
        PaymentTransactionDetails::create($data);
    }

    /**
     * Make the User As Active After Paid Payment Amount
     */
    protected function makeUserActive($user_id){
        User::where('id', $user_id)->update(['user_status' => 1]);
    }

    
}