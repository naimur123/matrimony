<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Country;
use App\Http\Components\Curl;
use App\Http\Components\Profile;
use App\Http\Components\Visitor;
use App\News;
use App\OurService;
use App\Package;
use App\ProfileVisitor;
use App\Proposal;
use App\Religious;
use App\SuccessStory;
use App\Testimonial;
use App\User;
use App\UserActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    use Profile , Curl, Visitor;
    /**
     * Application Main Index page
     */
    public function index(){
        if( Auth::user() ){
            return redirect('/home');
        }
        $parms['banners'] = Banner::where('status', 'published')->first();
        $parms['success_stories'] = SuccessStory::where('status', 'published')->limit(4)->orderBy('id','DESC')->get();
        $parms['testimonials'] = Testimonial::where('status', 'published')->limit(4)->orderBy('id','DESC')->get();
        $parms['newses'] = News::where('status', 'published')->limit(10)->orderBy('id','DESC')->get();
        $parms['religious'] = Religious::where('status', 'published')->get();
        $parms['countries'] = Country::orderBy('country', 'ASC')->get(); 
        $parms['packages'] = Package::where('status','published')->get();
        $parms['our_services'] = OurService::where('status','published')->orderBy('id','DESC')->limit(3)->get();
        $parms['index_page'] = true;
        return view('frontEnd.home.index', $parms);
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {    

        if( !$this->IsProfileComplete() ){
            if( !Session::has('instruction_status') ){
                Session::put('instruction_status', true);
            }            
            return redirect('profile/incomplete');            
        }
        if( !$this->isProfileApprove(Auth::user()) ){
            if( !Session::has('instruction_status') ){
                Session::put('instruction_status', true);
            }
            return redirect('profile/instruction');
        }
        $user = Auth::user();
        $prams['profile_complete'] = $this->getProfileCompleteCount($user);
        $prams['user'] = $user;     
        $prams['myMatches'] = $this->matcheProfile($user, 'all', false, 15);
        $prams['newMatches'] = $this->matcheProfile($user, 'new_match');
        $status['pending_proposal'] = Proposal::where('status','pending')->where('proposal_sent_to', $user->id)->count();
        $status['accept_proposal'] = Proposal::where('status','accept')->where('proposal_sent_to', $user->id)->count();
        $status['profile_visitor'] = ProfileVisitor::where('visit_profile_id', $user->id)->where('created_at','>=', date('Y-m-d').' 00:00:00')->groupBy('visit_profile_id')->count();
        $prams['status'] = $status;
        $prams['package_usees_data'] = $this->getPackageUsedData($user);
        return view('frontEnd.account.home', $prams);        
    }

    public function instruction(){

        if(!$this->isProfileApprove(Auth::user())){
            if( Session::has('instruction_status') && Session::get('instruction_status') ){
                Session::put('instruction_status', false);
                $profile_complete = $this->getProfileCompleteCount(Auth::user());
                return view('frontEnd.account.instruction',['profile_complete' => $profile_complete]);
            }
        }
        return redirect('/profile');
        
    }

    /**
     * Get Package Used Data
     */
    protected function getPackageUsedData($user){
        $subscribe_package = $user->subscribePackage;
        if( empty($subscribe_package) ){
            return Null;
        }
        $uses_data = UserActivity::where('user_id', $user->id)->where('subscribe_package_id', $subscribe_package->id)
            ->select( 
                DB::raw('sum(sent_proposal) as sent_proposal'), DB::raw('sum(accept_proposal) as accept_proposal'),
                DB::raw('sum(decline_proposal) as decline_proposal'), DB::raw('sum(profile_view) as view_contacts'),
            )->first();
        return $uses_data;
    }


    /**
     * Connected User List
     */
    public function connectedUser(){
        $user = Auth::user();
        $prams['profile_complete'] = $this->getProfileCompleteCount($user);
        $prams['user'] = $user;    
        $prams['myMatches'] = User::whereIn('id', $this->connectedUserArr($user))->orderBy('id', 'DESC')->paginate(15);
        // $prams['newMatches'] = $this->matcheProfile($user, 'new_match');
        $status['pending_proposal'] = Proposal::where('status','pending')->where('proposal_sent_to', $user->id)->count();
        $status['accept_proposal'] = Proposal::where('status','accept')->where('proposal_sent_to', $user->id)->count();
        $status['profile_visitor'] = ProfileVisitor::where('visit_profile_id', $user->id)->where('created_at','>=', date('Y-m-d').' 00:00:00')->groupBy('visit_profile_id')->count();
        $prams['status'] = $status;
        $prams['package_usees_data'] = $this->getPackageUsedData($user);
        return view('frontEnd.account.connectedUser', $prams); 
    }

    /**
     * Run Schedule $ artisan Command
     */
    public function runCommand(){
        try{
            Artisan::call("user:offline");
            Artisan::call("user:online");            
            Artisan::call("queue:work --once");
            return "Run All";
        }catch(Exception $e){
            return $this->getError($e);
        }
    }

    /**
     * Store Visitor Area Name
     */
    public function storeAreaInfo(Request $request){
        try{
            $latlon = $request->lat . ','. $request->lon;
            $key = "AIzaSyArxv0g5nuWsNezYu4oQRKAA7_zBeIKRbg";
            $url = "https://maps.googleapis.com/maps/api/geocode/json?key=".$key."&latlng=".$latlon;
            $response = json_decode($this->curl($url, 'GET', Null, false));
            $location = explode(' ', $response->plus_code->compound_code)[1] . ' ' . $response->results[0]->formatted_address;
            $this->addAreaInfo($location);
            return 'success';
        }catch(Exception $e){
            return $this->getError($e);
        }
    }
}
