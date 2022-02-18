<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Components\Profile;
use App\Http\Controllers\Controller;
use App\SubscribePackage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    use Profile;
    /********************************************************************************************
     * User REport Section
     */

     /**
     * Get Table Column List
     */
    private function getUserColumns(){
        $columns = ['#', 'action', 'image', 'status', 'user_id', 'name', 'gender', 'marital_status', 'profession', 'phone', 'email'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getUserDatatableColumns(){
        $columns = ['index', 'action', 'image', 'status', 'id', 'name', 'gender', 'marital_status', 'profession', 'phone', 'email'];
        return $columns;
    }

    /**
     * Get User List
     */
    public function userReport(Request $request, $type = 'active'){
        if( $request->ajax() ){
            return $this->getUserDataTable($type);
        }
        $available_types = [
            'active', 'deactive', 'male', 'female', 'verified', 'unverified',
            'pending', 'paid', 'today_register','total_register','total-subscribe-users'
        ];
        if( !in_array( $type, $available_types)){
            abort(404);
        }
        //$this->addMonitoring('Report');
        $params = [
            'nav'               => 'report',
            'subNav'            => 'user.'.$type,
            'tableColumns'      => $this->getUserColumns(),
            'dataTableColumns'  => $this->getUserDatatableColumns(),
            'dataTableUrl'      => Null,
            'create'            => Null,
            'pageTitle'         => $type.' Users',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.report.table',$params);
    }

    /**
     * GetUser DataTable
     */
    protected function getUserDataTable($type){
        $data = User::orderBy('id','DESC');
        if( $type == "active"){
            $data->where('user_status', true);
        }
        elseif($type == "deactive"){
            $data->where('user_status', false)->orwhere('user_status', null);
        }
        elseif($type == "male"){
            $data->where('gender', 'M');
        }
        elseif($type == "female"){
            $data->where('gender', 'F');
        }
        elseif($type == "verified"){
            $data->where('user_status', 2);
        }
        elseif($type == "unverified"){
            $data->where('user_status', 3);
        }
        elseif($type == "today_register"){
            $data->where('created_at', '>=', date('Y-m-d').' 00:00:00');
        }
        elseif($type == "total_register"){
            // Total Register Have to Condition
        }
        $data = $data->withTrashed()->get();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('id', function($row){ return 'MMBD-'.$row->id; })
            ->addcolumn('image', function($row){ return isset($row->profilePic->image_path) && file_exists($row->profilePic->image_path) ? '<img src="'.asset($row->profilePic->image_path).'"height="180">' : '<img src="'.asset('frontEnd/dummy_user.jpg').'"height="180">'; })
            ->addcolumn('name', function($row){ return $row->first_name . ' ' . $row->last_name; })
            ->addcolumn('gender', function($row){ return $row->gender == "M" ? 'Male' : 'Female'; })
            ->addColumn('profession', function($row){ return isset($row->careerProfession->name) ? $row->careerProfession->name : 'N/A'; })
            ->addColumn('status', function($row){
                if( $row->user_status == 1 ){
                    return '<span class="badge badge-success">Active</span>';
                }
                elseif( $row->user_status == 2 ){
                    return '<span class="badge badge-primary">verified</span>';
                }
                elseif( $row->user_status == 3 ){
                    return '<span class="badge badge-warning">Unverified</span>';
                }else{
                    return '<span class="badge badge-danger">Deactive</span>';
                }
            })
            ->addcolumn('marital_status', function($row){
                if( $row->marital_status == "M" ){
                    return 'Married';
                }elseif( $row->marital_status == "U" ){
                    return 'Unmarried';
                }elseif( $row->marital_status == "D" ){
                    return 'Unmarried';
                }
                else{
                    return $row->marital_status;
                }
            })
            ->addColumn('action',function($row) use($type){
                return $this->getUserActionOptions($row, $type);
            })
            ->rawColumns(['action', 'image','status'])
            ->make(true);
    }


    /********************************************************************************************
     * User Payment Report Section
     */

     /**
     * Get Table Column List
     */
    private function getUserColumns2(){
        $columns = ['#', 'action', 'image', 'status', 'user_id', 'name', 'gender', 'marital_status', 'package', 'activation_date', 'expire_date', 'paid_amount' ,'payment_status', 'profession', 'phone', 'email'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getUserDatatableColumns2(){
        $columns = ['index', 'action', 'image', 'status', 'id', 'name', 'gender', 'marital_status', 'package', 'activation_date', 'expire_date', 'paid_amount', 'payment_status', 'profession', 'phone', 'email'];
        return $columns;
    }

    /**
     * Get User List
     */
    public function paymentReport(Request $request, $type = 'active'){
        if( $request->ajax() ){
            return $this->getUserDataTable2($type);
        }

        $available_types = [
            'today-pending-payment','monthly-pending-payment','all-pending-payment',
            'today-paid-payment','monthly-paid-payment','all-paid-payment',
        ];

        if( !in_array( $type, $available_types)){
            abort(404);
        }
        //$this->addMonitoring('Report');
        $params = [
            'nav'               => 'report',
            'subNav'            => 'payment.'.$type,
            'tableColumns'      => $this->getUserColumns2(),
            'dataTableColumns'  => $this->getUserDatatableColumns2(),
            'dataTableUrl'      => Null,
            'create'            => Null,
            'pageTitle'         => $type.' Users',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.report.table',$params);
    }

    /**
     * GetUser DataTable
     */
    protected function getUserDataTable2($type){

        if( $type == "today-paid-payment" || $type == "monthly-paid-payment" ||  $type == "all-paid-payment" ){
            $data = $this->getTotalPaidPaymentUserList($type);
        }else{
            $data = $this->getTotalpendingPaymentUserList($type);
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('id', function($row){ return 'MMBD-'.$row->id; })
            ->addcolumn('image', function($row){ return isset($row->profilePic->image_path) && file_exists($row->profilePic->image_path) ? '<img src="'.asset($row->profilePic->image_path).'"height="180">' : '<img src="'.asset('frontEnd/dummy_user.jpg').'"height="180">'; })
            ->addcolumn('name', function($row){ return $row->first_name . ' ' . $row->last_name; })
            ->addcolumn('gender', function($row){ return $row->gender == "M" ? 'Male' : 'Female'; })
            ->addColumn('profession', function($row){ return isset($row->careerProfession->name) ? $row->careerProfession->name : 'N/A'; })
            ->addColumn('package', function($row){ return isset($row->subscribePackage->packageDetails) ? $row->subscribePackage->packageDetails->title : 'N/A'; })
            ->addColumn('activation_date', function($row){ return isset($row->subscribePackage->activation_date) ? $row->subscribePackage->activation_date : 'N/A'; })
            ->addColumn('expire_date', function($row){ return isset($row->subscribePackage->expire_date) ? $row->subscribePackage->expire_date : 'N/A'; })
            ->addColumn('payment_amount', function($row){ return isset($row->subscribePackage->payment_amount) ? number_format($row->subscribePackage->payment_amount) : 'N/A'; })
            ->addColumn('paid_amount', function($row){ return isset($row->subscribePackage->paid_amount) ? number_format($row->subscribePackage->paid_amount) : 'N/A'; })
            ->addColumn('tran_id', function($row){ return isset($row->subscribePackage->tran_id) ? $row->subscribePackage->tran_id : 'N/A'; })
            ->addColumn('payment_status', function($row){
                if(isset($row->subscribePackage->payment_status) && $row->subscribePackage->payment_status = "paid" ){
                    return '<span class="badge badge-success">'.$row->subscribePackage->payment_status.'</span>';
                }
                elseif(isset($row->subscribePackage->payment_status) && $row->subscribePackage->payment_status = "due" ){
                    return '<span class="badge badge-warning">'.$row->subscribePackage->payment_status.'</span>';
                }elseif( isset($row->subscribePackage->payment_status) ){
                    return '<span class="badge badge-danger">'.$row->subscribePackage->payment_status.'</span>';
                }else{
                    return 'N/A';
                }
            })
            ->addColumn('status', function($row){
                if( $row->user_status == 1 ){
                    return '<span class="badge badge-success">Active</span>';
                }
                elseif( $row->user_status == 2 ){
                    return '<span class="badge badge-primary">verified</span>';
                }
                elseif( $row->user_status == 3 ){
                    return '<span class="badge badge-warning">Unverified</span>';
                }else{
                    return '<span class="badge badge-danger">Deactive</span>';
                }
            })
            ->addcolumn('marital_status', function($row){
                if( $row->marital_status == "M" ){
                    return 'Married';
                }elseif( $row->marital_status == "U" ){
                    return 'Unmarried';
                }elseif( $row->marital_status == "D" ){
                    return 'Unmarried';
                }
                else{
                    return $row->marital_status;
                }
            })
            ->addColumn('action',function($row) use($type){
                return $this->getUserActionOptions($row, $type);
            })
            ->rawColumns(['action', 'image','status','payment_status'])
            ->make(true);
    }

    /**
     * get Paid User List
     */
    protected function getTotalPaidPaymentUserList($range = Null){
        $users = User::whereHas('subscribePackage', function($qry) use($range) {
            $qry->where('activation_date', '<=', date('Y-m-d'))
                ->where('expire_date', '>=', date('Y-m-d'))
                ->where('payment_status', 'paid');

            if( $range == 'today-paid-payment' ){
                $qry->where('created_at', '>=', date('Y-m-d'). ' 00:00:00' );
            }
            elseif($range == 'monthly-paid-payment'){
                $qry->where('created_at', '>=', Carbon::now()->firstOfMonth()->format('Y-m-d'). ' 00:00:00');
            }
        });
        return $users->withTrashed()->orderBy('id','DESC')->get();
    }

    /**
     * Get Pending PaymentList
     */
    protected function getTotalpendingPaymentUserList($range = Null){
        $paid_users_arr = SubscribePackage::where('activation_date', '<=', date('Y-m-d'))
            ->where('expire_date', '>=', date('Y-m-d'))
            ->where('payment_status', 'paid')
            ->select('user_id')
            ->groupBy('user_id')->get()->pluck('user_id');

        $user = User::whereNotIn('id', $paid_users_arr);
        if($range == 'today-pending-payment'){
            $user->where('created_at', '>=', date('Y-m-d').' 00:00:00');
        }elseif($range == 'monthly-pending-payment'){
            $user->where('created_at', '>=', Carbon::now()->firstOfMonth()->format('Y-m-d'). ' 00:00:00');
        }else{
            //
        }
        return $user->withTrashed()->orderBy('id','DESC')->get();

    }
}
