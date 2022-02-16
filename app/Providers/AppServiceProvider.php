<?php

namespace App\Providers;

use App\CareerProfessional;
use App\Chat;
use App\Country;
use App\EducationLevel;
use App\Http\Components\Profile;
use App\MaritalStatus;
use App\Religious;
use App\Seo;
use App\SocialMedia;
use App\SystemInfo;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use Profile;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        View::composer('*', function($view){
            $system = SystemInfo::first();
            $seo = Seo::first();
            $view->with(['system' => $system,'seo' => $seo]);
        });

        
        View::composer('frontEnd.includes.menu', function($view){
            if(Auth::user()){                
                $chatMessages_list = Chat::where('to_id', Auth::user()->id)
                    ->orWhere('from_id', Auth::user()->id)
                    ->orderBy('id','DESC')
                    ->groupBy('to_id','from_id')
                    ->select('from_id','to_id')->get();

                $prams['chatMessages'] = $this->getMessageList($chatMessages_list);
                $new_message = Chat::where('to_id', Auth::user()->id)
                    ->where('load', false)->groupBy('to_id')->get();

                $prams['new_message'] = count($new_message);
                $view->with($prams);
            }            
        });

        View::composer('frontEnd.includes.footer', function($view){
            $social_icons = SocialMedia::where('publication_status', 1)->orderBy('position', 'ASC')->get();
            $view->with(['social_icons' => $social_icons]);
        });
        

        View::composer('frontEnd.chatting.chat', function($view){
            $auth_user = Auth::user();
            if( !is_null($auth_user) ){
                $chatList = User::whereIn('id', $this->connectedUserArr($auth_user))
                ->whereNotIn('id', [$auth_user->id])
                ->get();
                $view->with(['chatList'=> $chatList]);
            }            
        });

        View::composer('frontEnd.account.register', function($view){
            $parms['religious'] = Religious::where('status', 'published')->get();
            $parms['countries'] = Country::orderBy('country', 'ASC')->get(); 
            $parms['professions'] = CareerProfessional::where('status', 'published')->orderBy('name','ASC')->get();
            $parms['educations'] = EducationLevel::where('status', 'published')->orderBy('name','ASC')->get();
            $parms['maritalStatus'] = MaritalStatus::where('status','published')->orderBy('name','ASC')->get();
            $view->with($parms);         
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if( env('HTTPS') ){
            URL::forceScheme('https');
        }
        
    }

    protected function getMessageList($lists){
        $user = Auth::user();
        $arr = [];
        foreach($lists as $key => $row){
            if($row->from_id == $user->id){
                if( !in_array($row->to_id, $arr) ){
                    array_push($arr, $row->to_id);
                }else{
                    $lists->forget($key);
                }
            }else{
                if( !in_array($row->from_id, $arr) ){
                    array_push($arr, $row->from_id);
                }else{
                    $lists->forget($key);
                }
            }
        }
        unset($arr);
        return $lists;
    }
}
