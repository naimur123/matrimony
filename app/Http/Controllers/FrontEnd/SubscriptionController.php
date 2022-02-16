<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Components\Curl;
use App\Http\Components\Profile;
use App\Http\Components\SSLCommerz;
use App\Http\Components\Subscription;
use App\Http\Controllers\Controller;
use App\Jobs\AccountNotification;
use App\Package;
use App\PaymentTransactionDetails;
use App\SubscribePackage;
use App\SystemInfo;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    use Profile, SSLCommerz, Curl, Subscription;
    /**
     * Show Available Subscribe Packages
     */
    public function showPackages(){
        $prams['packages'] = $this->getPackages();
        $prams['user'] = Auth::user();
        return view('frontEnd.subscription.packages', $prams);
    }

    /**
     * Confirm Subscription
     */
    public function confirmSubscription(Request $request){
        try{
            DB::beginTransaction();
            $package = Package::findOrFail($request->id);
            $subscribed_package = $this->subscriptionConfirmed($package);                        
            return $this->goToPaymentGetaway($subscribed_package);
        }catch(Exception $e){
            DB::rollBack();            
            $this->message = $this->getError($e);
        }        
        return redirect('/packages')->with('output', $this->output());
    }

    protected function goToPaymentGetaway($subscribed_package){
        $post_data = $this->preparePaymentGetawayData(Auth::user(), $subscribed_package->payment_amount, $subscribed_package->tran_id);
        $url = $this->getBaseUrl().'gwprocess/v4/api.php';
        $response = json_decode($this->curl($url, 'POST', $post_data));
        if( isset($response->GatewayPageURL) && !empty($response->GatewayPageURL) ){
            DB::commit();
            return redirect()->to($response->GatewayPageURL);
        }else{
            DB::rollBack();
            $this->status = false;
            $this->message = "Failed To Load Payment Gateway ";
        }
        return redirect('/packages')->with('output', $this->output());
    }

    /**
     * After Success Payment
     * Check Payment and Update the DB
     */
    public function paymentSuccess(Request $request){
        try{
            DB::beginTransaction();
            $param = ['status' => false, 'tran_id' => Null, 'amount' => Null,'message' => Null];
            $validate = Validator::make($request->all(),[
                'tran_id'   => ['required','string','min:12','max:16'],
                'val_id'    => ['required','string'],
                'amount'    => ['required','numeric','min:1'],
            ]);
            if( $validate->fails() ){
                $param['message'] = 'This Payment Data is Invalid';
            }else{
                $subscriptionData = SubscribePackage::where('tran_id', $request->tran_id)->firstOrFail();
                $this->savePaymentTrasactionData($request, $subscriptionData->user_id);
                $subscriptionData->paid_amount = $request->amount;
                if($subscriptionData->payment_amount <= $request->amount && $request->status == "VALID"){
                    $subscriptionData->payment_status = 'paid';
                    $this->makeUserActive($subscriptionData->user_id);
                    try{
                        $message = $this->getPaymentConfirmEmailMessage($request);
                        $user = User::find($subscriptionData->user_id);
                        AccountNotification::dispatch($user->email, "Payment Confirmation", $message);                      
                    }catch(Exception $e){
                        //
                    }
                }
                $subscriptionData->save();
                $param['status'] = true;
                $param['amount'] = $request->amount;
                $param['tran_id'] = $request->tran_id;
                $param['message'] = "Your Payment Processed Successfully.";
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            $param['message'] = $this->getError($e);
        }
        return redirect('subscription/message')->with($param);
    }

    /**
     * Get Payment Confirm Email Body
     */
    protected function getPaymentConfirmEmailMessage($request){
        $system = SystemInfo::first();
        $message = 
            '<div>                
                <div>
                    <img src="'.asset($system->logo).'" style="height: 80px;">
                </div>
                <h3 style="margin: 0px 0px 10px 0px; color: #fff; font-size: 22px; background: #dd2476; padding: 5px 0px 5px 15px;">
                    Payment Information                    
                </h3>                
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                Dear User,<br><br>
                Your payment amount '.$request->amount.' '. $system->currency .' has been paid successfully. your transaction id is :'. $request->tran_id.'<br><br>
                Thank you for choosing <a href="https://marriagematchbd.com/">Marriagematchbd.com</a><br>
            </div>';
        return $message;
    }

    /**
     * IF Transaction Failed or 
     * user Cancel the Transaction
     */
    public function paymentFail(Request $request){
        try{
            DB::beginTransaction();
            $param = ['status' => false, 'tran_id' => Null, 'amount' => Null,'message' => Null];
            $validate = Validator::make($request->all(),[
                'tran_id'   => ['required','string','min:12','max:16'],
                'val_id'    => ['required','string'],
                'amount'    => ['required','numeric','min:1'],
            ]);
            if( $validate->fails() ){
                $param['message'] = 'This Payment Data is Invalid';
            }else{
                $subscriptionData = SubscribePackage::where('tran_id', $request->tran_id)->firstOrFail();
                $this->savePaymentTrasactionData($request, $subscriptionData->user_id);
                if($request->status != "VALID"){
                    $subscriptionData->payment_status = 'cancel';
                }
                $subscriptionData->save();
                $param['message'] = "Payment Canceled";
                $param['tran_id'] = $request->tran_id;
            }
            DB::commit();
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return redirect('subscription/message')->with($param);
    }

    /**
     * Transaction Cancel
     */
    public function paymentCancel(Request $request){
        return $this->paymentFail($request);
    }

    /**
     * Show Package Subscribe Message
     */
    public function sebscriptionMessage(){
        return view('frontEnd.subscription.paymentMessage');
    }

    

    /**
     * Successfully Subscription
     */
    public function subscriptionSuccessfully(){
        $prams['user'] = Auth::user();
        return view('frontEnd.subscription.successfully', $prams);
    }



}
