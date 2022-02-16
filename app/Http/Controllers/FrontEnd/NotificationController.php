<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Components\Profile;
use App\Http\Controllers\Controller;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use Profile;
    /**
     * Show Latest 15 Notification 
     */
    public function showAll(){
        if( !$this->isProfileApprove(Auth::user()) ){
            return redirect('/profile');
        }
        Notification::where('to_user', Auth::user()->id)
            ->where('seen_at', Null)
            ->update(['seen_at' => Carbon::now()]);
        $prams['notifications'] = Notification::where('to_user', Auth::user()->id)->orderBy('id', 'DESC')->paginate(15);
        $prams['user'] = Auth::user();
        return view('frontEnd.others.notification', $prams);
    }
}
