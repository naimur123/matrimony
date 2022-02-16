<?php

namespace App\Http\Components;

use App\Visitor as AppVisitor;
use Jenssegers\Agent\Agent;
use Exception;
use Illuminate\Support\Facades\Session;

trait Visitor{

    use Helper;
    /**
     * Store Visitor Info
     */
    protected function storeVisitorData($request, $ck = null){
        $agent = new Agent();
        $data = new AppVisitor();
        $data->ip = $request->ip();
        if($ck){
            $data->browser = $agent->browser().$agent->version($agent->browser());
            $data->device =  $agent->isDesktop() == 1?'Desktop':$agent->device();
            $data->os = $agent->platform().'-'.$agent->version($agent->platform());
            try{
                $ip_details = $this->getDataFromIP($request->ip());
                $data->countryCode = $ip_details->country;
                $data->city = $ip_details->city;
            }catch(Exception $ex){
                $data->countryCode = 'N/A';
                $data->city = "N/A";
            }  
        }
        $data->user_id = !empty($request->user()) ? $request->user()->id : Null;
        $data->visit_count = 1; 
        $data->date = date('Y-m-d');
        $data->save();
        return $data;
    }

    /**
     * Store Area Information
     */
    protected function addAreaInfo($location){
        $data = AppVisitor::find(Session::get('visitor_id'));
        $data->area = $location;
        $data->save();
    }
}