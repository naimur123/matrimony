<?php 

namespace App\Http\Components;

use App\AdminMonitoring;
use Illuminate\Support\Facades\Auth;

trait Monitoring{

    /**
     * Store Admin Monitoring Info
     */
    protected function addMonitoring($page, $action = "view", $from_status = Null, $to_status = Null){
        $data = new AdminMonitoring();
        $data->admin_id  = Auth::guard('admin')->user()->id;
        $data->active_page = $page;
        $data->action = $action;
        $data->from_status = $from_status;
        $data->to_status = $to_status;
        $data->save();
    }
}