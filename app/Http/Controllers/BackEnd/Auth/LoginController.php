<?php

namespace App\Http\Controllers\BackEnd\Auth;

use App\Http\Controllers\Controller;
use App\Package;
use App\SubscribePackage;
use App\User;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = "dashboard";
    protected $logoutRedirect = "/dashboard/admin-login";
    protected $maxAttempts = 3;
    protected $decayMinutes = 10;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if( Auth::guard('admin')->check() ){
            return redirect($this->redirectTo);
        }
        return view('backEnd.admin.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * After Logout the redirect location
     */
    protected function loggedOut(){
        return redirect($this->logoutRedirect);
    }

    /**
     * Show Dashboard
     */
    public function showDashboard(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable($request);
        }
        $prams['today_register'] = User::where('created_at', '>=', date('Y-m-d') .' 00:00:00' )->count();
        $prams['total_register'] = User::withTrashed()->count();
        $prams['today_visit'] = Visitor::where('date', '=', date('Y-m-d'))->sum('visit_count');
        $prams['total_monthly_visit'] = Visitor::whereBetween('date', [ Carbon::now()->firstOfMonth()->format('Y-m-d'), Carbon::now()->lastOfMonth()->format('Y-m-d') ])->sum('visit_count');
       
        $prams['today_pending_payment'] = $this->getTotalPendingPayment('daily');
        $prams['monthly_pending_payment'] = $this->getTotalPendingPayment('monthly');
        $prams['all_pending_payment'] = $this->getTotalPendingPayment();
        $prams['today_paid_payment'] = $this->getTotalPaidPayment('daily');
        $prams['monthly_paid_payment'] = $this->getTotalPaidPayment('monthly');
        $prams['all_paid_payment'] = $this->getTotalPaidPayment();
        $prams['all_subscribe_users'] = $this->getAllSubscribeUsers();
        $prams['all_male_users'] = User::where('gender', 'M')->withTrashed()->count();
        $prams['all_female_users'] = User::where('gender', 'F')->withTrashed()->count();
        $prams['verified_users'] = User::where('email_verified_at', '!=', Null)->withTrashed()->count();
        $prams['unverified_users'] = User::where('email_verified_at', Null)->withTrashed()->count();
        $prams['incomplete_users'] = $this->getIncompleteUsers();
        $prams['active_users'] = User::where('user_status', true)->withTrashed()->count();
        $prams['deactive_users'] = User::where('user_status', false)->orWhere('user_status', Null)->withTrashed()->count();

        
        $prams['tableColumns']      = $this->getColumns();
        $prams['tableColumns2']      = $this->getColumns2();
        $prams['dataTableColumns']  = $this->getDataTableColumns();        
        $prams['dataTableColumns2']  = $this->getDataTableColumns2();
        $prams['dataTableUrl']      = Null;
        $prams['dataTableUrl2']     = route('visitor.country.summary');

        $prams['subscribtion_packages'] = $this->getSubscribePackages();

        $prams['nav']               = "dashboard";
        return view('backEnd.dashboard.index',$prams);
    }

    /**
     * Get Pending Payment Data
     */
    protected function getTotalPendingPayment($range = Null){
        $paid_users_arr = SubscribePackage::where('activation_date', '<=', date('Y-m-d'))
            ->where('expire_date', '>=', date('Y-m-d'))
            ->where('payment_status', 'paid')           
            ->select('user_id')
            ->groupBy('user_id')->get()->pluck('user_id');
        
        $data = User::whereNotIn('id', $paid_users_arr);
        if($range == 'daily'){
            $data->where('created_at', '>=', date('Y-m-d').' 00:00:00');
        }elseif($range == 'monthly'){
            $data->where('created_at', '>=', Carbon::now()->firstOfMonth()->format('Y-m-d'). ' 00:00:00');
        }else{
            //
        }
        $data = $data->orderBy('id')->count();
        return $data;
    }

    /**
     * 
     * Get Paid Payment  Data
     */
    protected function getTotalPaidPayment($range = Null){
        $paid_users_amt = SubscribePackage::where('activation_date', '<=', date('Y-m-d'))
            ->where('expire_date', '>=', date('Y-m-d'))
            ->where('payment_status', 'paid');
        if( $range == 'daily' ){
            $paid_users_amt->where('created_at', '>=', date('Y-m-d'). ' 00:00:00' );
        }elseif($range == 'monthly'){
            $paid_users_amt->where('created_at', '>=', Carbon::now()->firstOfMonth()->format('Y-m-d'). ' 00:00:00');
        }
        $paid_users_amt = $paid_users_amt->sum('paid_amount');        
        return $paid_users_amt;
    }


    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'country', 'city', 'area', 'ip', 'browser', 'device', 'os', 'visitpage','date'];
        return $columns;
    }

    private function getColumns2(){
        $columns = ['#', 'country', 'visitpage'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'countryCode', 'city', 'area', 'ip', 'browser', 'device', 'os', 'visit_count','date'];
        return $columns;
    }

    private function getDataTableColumns2(){
        $columns = ['index', 'country', 'totalVisit'];
        return $columns;
    }

    /**
     * Get DataTable
     */
    public function getDataTable( $request ){
        $date = Carbon::now()->format('Y-m-d');
        $data = Visitor::orderBy('id', 'DESC')->get();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; }) 
            ->editColumn('countryCode', function($row){ return empty($row->countryCode) ? 'N/A' : $row->countryCode; }) 
            ->editColumn('city', function($row){ return empty($row->city) ? 'N/A' : $row->city; }) 
        ->make(true);
    }

    /**
     * CountryBased Visitor Summary
     */
    public function countruBasedSummary(Request $request){
        if( $request->ajax() ){
            $data = Visitor::where('date', '>=', Carbon::now()->firstOfMonth()->format('Y-m-d') )
                ->select('countryCode as country', DB::raw('sum(visit_count) as totalVisit'))
                ->groupBy('country')
                ->orderBy('country', 'ASC')->get();
           
            return DataTables::of($data)
                ->addColumn('index', function(){ return ++$this->index; }) 
                ->editColumn('country', function($row){ return empty($row->country) ? 'N/A' : $row->country; })
            ->make(true);
        }
    }

    /**
     * Get All Subscribe Paclages
     */
    public function getSubscribePackages(){
        return Package::where('status', 'published')->orderBy('title', 'ASC')->get();
    }

    /**
     * Get Sunscribe Users
     */
    public function getAllSubscribeUsers(){
        $data =  SubscribePackage::where('activation_date', '<=', date('Y-m-d'))
            ->where('expire_date', '>=', date('Y-m-d'))
            ->where('payment_status', 'paid')->groupBy('user_id')->get();
        return count($data);
    }

    public function getIncompleteUsers(){
        return User::where('user_height', Null )
            ->orWhere('marital_status', Null )
            ->orWhere('user_present_address', Null)
            ->orWhere('education_level_id', Null)
            ->orWhere('edu_institute_name', Null)
            ->orWhere('father_name', Null)
            ->orWhere('mother_name', Null)
            ->orWhere('partner_min_height', Null)
            ->orWhere('partner_religion', Null)
            ->orWhere('partner_country', Null)
            ->withTrashed()
            ->count();
    }
}
