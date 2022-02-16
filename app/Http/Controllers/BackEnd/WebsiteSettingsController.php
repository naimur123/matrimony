<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\SystemInfo;
use Exception;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    /**
     * Create Website Settings
     */
    public function create(){
        $this->addMonitoring('Website Settings');
        $params = ['nav' => 'admin', 'subNav' => 'admin.website.setting'];
        return view('backEnd.admin.settings', $params);
    }

    /**
     * Save website Settings Information
     */
    public function store(Request $request){
        try{
            $this->addMonitoring('Website Settings','Update');
            $system = SystemInfo::first();
            if( empty($system) ){
                $system = new SystemInfo();
            }
            $system->application_name = $request->application_name;
            $system->title_name = $request->title_name;
            $system->phone = $request->phone;
            $system->email = $request->email;
            $system->city = $request->city;
            $system->zip = $request->zip;
            $system->address = $request->address;
            $system->state = $request->state;
            $system->country = $request->country;
            $system->currency = $request->currency;
            $system->date_format = $request->date_format;
            $system->logo = $this->UploadImage($request, 'logo', $this->logo_dir, 120, Null, $system->logo);
            $system->favicon = $this->UploadImage($request, 'favicon', $this->logo_dir, 35, 35, $system->favicon);
            $system->save();
            $this->success('Website Settings Info Added Successfully', false, false, false, true);
    
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }
}
