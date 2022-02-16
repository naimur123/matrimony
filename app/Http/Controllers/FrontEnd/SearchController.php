<?php

namespace App\Http\Controllers\FrontEnd;

use App\CareerProfessional;
use App\Country;
use App\EducationLevel;
use App\Http\Components\Profile;
use App\Http\Controllers\Controller;
use App\Religious;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    use Profile;
    /**
     * Show Search Page
     */
    public function showSearchPage(){
        if( !$this->isProfileApprove(Auth::user()) ){
            return redirect('/profile');
        }
        $prams['professions'] = CareerProfessional::orderBy('name','ASC')->get();
        $prams['educations'] = EducationLevel::orderBy('name','ASC')->get();
        $prams['religious'] = Religious::orderBy('name','ASC')->get();
        $prams['countries'] = Country::orderBy('country', 'ASC')->get();
        $prams['cities'] = User::where('user_present_city', '!=', Null)
            ->select('user_present_city as city')->groupBy('city')
            ->orderBy('city', 'ASC')->get();
        $prams['user'] = Auth::user();    
        return view('frontEnd.others.search', $prams);
    }


    /**
     * Search Profile
     */
    public function search(Request $request){
        try{
            $users = User::where('gender', Auth::user()->looking_for == 'bride' ? 'F' : 'M' );            
            if( !is_null($request->profession_id) ){
                $users->where(function($qry) use($request){
                    foreach($request->profession_id as $id){
                        $qry->orWhere('career_working_profession_id', $id);
                    }
                });
            }
            if( !is_null($request->education_id) ){
                $users->where(function($qry) use($request){
                    foreach($request->education_id as $id){
                        $qry->orWhere('education_level_id', $id);
                    }
                });
            }
            if( !is_null($request->religious_id) ){
                $users->where(function($qry) use($request){
                    foreach($request->religious_id as $id){
                        $qry->orWhere('religious_id', $id);
                    }
                });
            }
            if( !is_null($request->country) ){
                $users->where(function($qry) use($request){
                    foreach($request->country as $country){
                        $qry->orWhere('location_country', $country)
                            ->orWhere('user_present_country', $country);
                    }
                });
            }
            if( !is_null($request->city) ){
                $users->where(function($qry) use($request){
                    foreach($request->city as $city){
                        $qry->orWhere('user_present_city', $city)
                        ->orWhere('user_permanent_city', $city);
                    }
                });
            }

            if( !empty($request->partner_min_age) && !empty($request->partner_max_age) ){
                $users->whereBetween('date_of_birth', $this->getDOBRange($request->partner_min_age-1, $request->partner_max_age+1) );
            }

            if( !empty($request->part_min_feet) && !empty($request->part_max_feet) ){
                $min = $this->calculateHeight($request, 'part_min_feet', 'part_min_inch');
                $max = $this->calculateHeight($request, 'part_max_feet', 'part_max_inch');
                $users->where('user_height','>=', $min)->where('user_height','<=', $max);
            }

            $param['profiles'] = $users->where('email_verified_at', '!=', Null)
                ->where('id', '!=', Auth::user()->id)
                ->orderBy('first_name','asc')
                ->orderBy('last_name','asc')->paginate(20);
            $this->data = view('frontEnd.others.searchResult', $param)->render();
            $this->apiSuccess();
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->apiOutput();
    }
}
