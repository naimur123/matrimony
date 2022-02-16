<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect to Facebook
     */
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Get Data From Facebook
     */
    public function getDataFromFacebook(){
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }

    /**
     * Redirect to Facebook
     */
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    /**
     * Get Data From Google
     */
    public function getDataFromGoogle(){
        $user = Socialite::driver('google')->user();
        dd($user);
    }

}
