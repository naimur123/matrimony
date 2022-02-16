<?php

namespace App\Http\Controllers\Install;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Composer\Semver\Comparator;
use App\SystemInfo;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InstallController extends Controller
{

    //Show Instrallation page
    public function ShowInstallPage(Request $request){     
          
        if( config('setup') ){
            abort(404);
        }    
        try{
            Artisan::call('migrate:reset');
        }catch(Exception $e){
            // nothing
        }
        return view('install.install')->with('title','Install');
    }
    
    // Application Install
    public function Install(Request $request){
        if( config('setup')){
            abort(404);
        }
        $this->validate($request,[
            'application_name'   => ['required'],
            'title_name'         =>['required'],
            'phone'             => ['required','min:6'],
            'country'           =>['required'],
            'date_format'       => ['required'],
            'logo'              => ['image|mimes:jpeg,png,jpg'],
            'favicon'           => ['image|mimes:jpeg,png,jpg'],
            'email'             => ['required|email|max:100']
        ]);

        try{
            DB::beginTransaction();
            Artisan::call('storage:link');
            $this->RunInstall();            
            $this->GenerateAutomaticData();                       
            $this->AddSystemInfo($request);
            $this->UpdateConfigaration(); 
            $this->createUser($request, Admin::class);
            DB::commit();
            $this->status = true;
            $this->message = 'Application Installed Successfully.Now you can login using email:'. $request->email.' And Password: ' . $request->email;
            return response()->json($this->output());
        } catch (Exception $e) {
            DB::rollback();
            $this->RemoveFile(base_path().'/config/setup.php');
            $this->message = $this->getError($e);
            return response()->json($this->output());
        }
    }

    protected function createUser($request, $model){
        $data = new $model;
        $data->name = $request->applicationName;
        $data->email = $request->email;
    }
    
    /*
     * Add Default System Info
     */
    public function AddSystemInfo($request) {
        $data = new SystemInfo();
        $data->applicationName = $request->applicationName;
        $data->titleName = $request->titleName;
        $data->phoneNo = $request->phoneNo;
        $data->city = $request->city;
        $data->email = $request->email;
        $data->zipCode = $request->zipCode;
        $data->address = $request->address;
        $data->country = $request->country;
        $data->dateFormat = $request->dateFormat;
        $data->state = $request->state;
        $data->version = '1.0.0';
        $data->logo = $this->UploadImage($request, 'logo', $this->logoImageDir, 200, null, $data->logo);
        $data->favicon = $this->UploadImage($request, 'favicon', $this->logoImageDir, 35, 35, $data->favicon);
        $data->save();
    }
    
    /*
     * Update the Application
    */

    public function ShowUpdatePage(){
        $system = SystemInfo::first();
        $systemVersion = !empty($system->version)?$system->version:'00';
        $appVersion = config('setup.version');
        if(Comparator::greaterThan($appVersion,$systemVersion)){
            return view('install.installUpdate')->with('title','Install');
        }else{
            abort(404);
        }
        
    }

    public function UpdateInstall() {
        $system = SystemInfo::first();
        $systemVersion = !empty($system->systemVersion)?$system->systemVersion:'00';
        $appVersion = config('setup.version');
        if(Comparator::greaterThan($systemVersion, $appVersion)){
           try{
                DB::beginTransaction();
                $this->RunInstall();            
                $this->UpdateSystemInfo($system);
                DB::commit();
                $output = ['status' => 'success', 'message' => 'Version Update successfully' ];
                return response()->json($output);
            } catch (\Exception $e) {
                DB::rollback();  
                $output = ['status' => 'error', 'message' => $this->getError($e) ];
                return response()->json($output);              
            }
        }
        else{
            abort(404);
        }
        
    }
    
    /*
     * Update System Information
     */    
    protected function UpdateSystemInfo($system) {
        $system->version = config('setup.version');
        $system->save();
    }
    
    /*
     * Run Install Command
     */
    protected function RunInstall() {
        $this->InstallationPrepration();
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '1024M');
        DB::statement('SET default_storage_engine=INNODB;');
        Artisan::call('migrate', ["--force"=> true]);        
    }
    
    /*
     * Generate Automatic value into Database
     */
    protected function GenerateAutomaticData() {
        try{
            Artisan::call('db:seed');
        }catch(Exception $e){
            //
        }
    }
    
    /*
     * Prepare Installation Settings
     */    
    protected function InstallationPrepration() {
        config(['app.debug' => true]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');        
    }
    
    /*
     * Rewrite Configuration File
     */    
    protected function UpdateConfigaration(){
        $file = fopen(base_path().'/'.'config/setup.php','w');
        $text = " <?php \n\n/* \n* Application Setup Done \n* @Developer: Sm Shahjalal Shaju \n * Email: shajushahjalal@gmail.com \n*/\n";
        $text .= "return[ \n \t'version' => '1.0.0',\n];";        
        fwrite($file,$text);
        fclose($file);
    }    
    
}
