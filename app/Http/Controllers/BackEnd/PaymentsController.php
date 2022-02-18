<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Components\Subscription;
use App\Http\Controllers\Controller;
use App\Package;
use App\SubscribePackage;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PaymentsController extends Controller
{
    use Subscription;
    /****************************************************************************************
     * Offline Payment Section
     ****************************************************************************************/

    /**
     * Get offline Payment Table Column List
     */
    private function getOfflineColumns(){
        $columns = ['#', 'name', 'package', 'activation', 'expire', 'pay_amount', 'paid_amount','tran_id', 'payment_method', 'status', 'action'];
        return $columns;
    }

    /**
     * Get Offline Payment DataTable Column List
     */
    private function getOfflineDataTableColumns(){
        $columns = ['index', 'name', 'package', 'activation_date', 'expire_date', 'payment_amount', 'paid_amount', 'tran_id', 'payment_method', 'payment_status', 'action'];
        return $columns;
    }

    /**
      * Show Offline Payments
      */
    public function offlinePayments(Request $request){
        if( $request->ajax() ){
            return $this->getPaymentDataTable('offline');
        }
        //$this->addMonitoring('Offline Payment List');
        $params = [
            'nav'               => 'payments',
            'subNav'            => 'offline.list',
            'tableColumns'      => $this->getOfflineColumns(),
            'dataTableColumns'  => $this->getOfflineDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('payments.offline.create'),
            'pageTitle'         => 'Offline Payment List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.payments.table', $params);
    }

    /**
     * Create Offline Payment Page
     */
    public function createOfflinePayments(Request $request){
        if( $request->ajax() ){
            $params['packages'] = $this->getPackages();
            $params['users'] = User::all();
            return view('backEnd.payments.offline.createPayment', $params)->render();
        }
    }

    /**
     * Save Or Store Offline Payment Data
     */
    public function storeOfflinePayments(Request $request){
        try{
            DB::beginTransaction();
            $user = User::find($request->user_id);
            $package = Package::findOrFail($request->package_id);
            $subscription_package = $this->addSubscribePackage($user, $package, $request->tran_id, $request->paid_amount, $request->payment_status, 'offline', $request->payment_method, $request->comments);
            $this->addSubscriptionPackageDetails($subscription_package, $package);
            $this->saveOfflinePaymentTransactionData($request, $subscription_package->tran_id);
            $this->makeUserActive($request->user_id);
            DB::commit();
            $this->success('Offline Payment added Successfully');
        }catch(Exception $e){
            DB::rollBack();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * View Or Show Offline Payments Details
     */
    public function viewOfflinePayments(Request $request){
        $prams['title'] = "Offline Payments Details";
        $prams['subscription'] = SubscribePackage::findOrFail($request->id);
        return view('backEnd.payments.viewPayments', $prams);
    }

    /****************************************************************************************
     * Online Payments Section
     *****************************************************************************************/

    /**
     * Get offline Payment Table Column List
     */
    private function getOnlineColumns(){
        $columns = ['#', 'name', 'package', 'activation', 'expire', 'pay_amount', 'paid_amount','tran_id', 'status', 'action'];
        return $columns;
    }

    /**
     * Get Online Payment DataTable Column List
     */
    private function getOnlineDataTableColumns(){
        $columns = ['index', 'name', 'package', 'activation_date', 'expire_date', 'payment_amount', 'paid_amount', 'tran_id', 'payment_status', 'action'];
        return $columns;
    }


    /**
     * ShowOnline Payments
     */
    public function onlinePayments(Request $request){
        if( $request->ajax() ){
            return $this->getPaymentDataTable();
        }
        ////$this->addMonitoring('Online Payment List');
        $params = [
            'nav'               => 'payments',
            'subNav'            => 'online.list',
            'tableColumns'      => $this->getOnlineColumns(),
            'dataTableColumns'  => $this->getOnlineDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Online Payment List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.payments.table', $params);
    }

    /**
     * View Details of Online Payments
     */
    public function viewOnlinePayments(Request $request){
        $prams['title'] = "Online Payments Details";
        $prams['subscription'] = SubscribePackage::findOrFail($request->id);
        return view('backEnd.payments.viewPayments', $prams);
    }


    /*****************************************************************************************
     * Get Payment DataTable
     *****************************************************************************************/
    public function getPaymentDataTable( $type = "online" ){
        $data = SubscribePackage::where('payment_type', $type)->orderBy('id','DESC')->get();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('name', function($row){ return isset($row->user) ? $row->user->first_name .' '. $row->user->last_name : 'N/A'; })
            ->addColumn('package', function($row){ return isset($row->packageDetails) ? $row->packageDetails->title : 'N/A'; })
            ->editColumn('payment_status', function($row){
                if($row->payment_status == 'paid'){
                    return '<span class="badge badge-success">'.$row->payment_status.'</span>';
                }elseif($row->payment_status == 'due'){
                    return '<span class="badge badge-warning">'.$row->payment_status.'</span>';
                }else{
                    return '<span class="badge badge-danger">'.$row->payment_status.'</span>';
                }
            })
            ->addcolumn('action', function($row) use($type){
                if($type == 'offline'){
                    $li = '<a href="'.route('payments.offline.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                }else{
                    $li = '<a href="'.route('payments.online.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                }
                return $li;
             })
            ->rawColumns(['action','payment_status'])
            ->make(true);
    }
}
