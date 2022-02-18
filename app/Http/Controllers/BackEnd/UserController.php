<?php

namespace App\Http\Controllers\BackEnd;

use App\CareerProfessional;
use App\Country;
use App\District;
use App\Division;
use App\EducationLevel;
use App\Http\Components\Profile;
use App\Http\Controllers\Controller;
use App\Jobs\AccountNotification;
use App\MaritalStatus;
use App\MonthlyIncome;
use App\Religious;
use App\ReligiousCast;
use App\SystemInfo;
use App\User;
use App\UserImage;
use App\Visitor;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use Profile;
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'action',  'status', 'image', 'name', 'email', 'phone', 'marital_status', 'profession'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'action', 'status', 'image', 'name', 'email', 'phone', 'marital_status', 'profession',  ];
        return $columns;
    }

    /**
     * Show user List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable($request);
        }
        // $this->addMonitoring('User List');
        $params = [
            'nav'               => 'user',
            'subNav'            => 'user.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('user.create'),
            'pageTitle'         => 'user List',
            'tableStyleClass'   => 'bg-success',
            'professions'       => CareerProfessional::orderBy('name','ASC')->get(),
            'educations'        => EducationLevel::orderBy('name','ASC')->get(),
            'religious'         => Religious::orderBy('name','ASC')->get(),
            'countries'         => Country::orderBy('country', 'ASC')->get(),
            'divisions'         => Division::orderBy('name', 'ASC')->get(),
            'districts'         => District::orderBy('name','ASC')->get(),
            'maritalStatus'     => MaritalStatus::where('status','published')->orderBy('name','ASC')->get(),
        ];
        return view('backEnd.user.table', $params);
    }


    /**
     * Create New user
     */
    public function create(){
        // $this->addMonitoring('Create user');
        $prams['religions'] = Religious::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['religious_casts'] = ReligiousCast::where('status','published')->orderBy('religious_id', 'ASC')->get();
        $prams['professions'] = CareerProfessional::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['incomes'] = MonthlyIncome::where('status','published')->get();
        $prams['educations'] = EducationLevel::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['countries'] = Country::orderBy('country', 'ASC')->get();
        $prams['maritalStatus'] = MaritalStatus::where('status','published')->orderBy('name','ASC')->get();

        return view('backEnd.user.create', $prams)->render();
    }

    /**
     * Store User Information
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => ['required','unique:users'],
        ]);
        try{
            DB::beginTransaction();
            $email_error = "";
            if( $request->id == "0" ){
                if($validator->failed()){
                    $this->message = $this->getValidationError($validator);
                    return $this->output();
                }
                $this->addMonitoring('Create user','Add');
                $data = new User();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                $this->addMonitoring('Create user','Update');
                $data = User::withTrashed()->where('id', $request->id)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
                if( $request->user_status != $data->user_status && $request->user_status == 1){
                    try{
                        $message = $this->ProfileVerifiedMessage();
                        AccountNotification::dispatch($data->email, 'Your profile has been verified', $message)->delay(1);
                    }catch(Exception $e){
                        $email_error = $this->getError($e) . ' in Email Send';
                    }
                }
            }
            $data->creating_account = $request->creating_account;
            $data->looking_for = $request->looking_for;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->password = !empty($request->password) ? bcrypt($request->password) : $data->password;
            $data->gender = $request->gender;
            $data->marital_status = $request->marital_status;
            $data->date_of_birth = $request->date_of_birth;
            $data->religious_id = $request->religious_id;
            $data->religious_cast_id = $request->religious_cast_id;
            $data->location_country = $request->location_country;
            $data->gardian_contact_no = $request->gardian_contact_no;
            $data->nid  = $request->nid;
            $data->passport = $request->passport;

            $data->user_present_address = $request->user_present_address;
            $data->user_present_city = $request->user_present_city;
            $data->user_present_country = $request->user_present_country;
            $data->user_permanent_address = $request->user_permanent_address;
            $data->user_permanent_city = $request->user_permanent_city;
            $data->user_permanent_country = $request->user_permanent_country;

            $data->career_working_name = $request->career_working_name;
            $data->organisation = $request->organisation;
            $data->career_working_profession_id = $request->career_working_profession_id;
            $data->career_monthly_income_id = $request->career_monthly_income_id;
            $data->education_level_id = $request->education_level_id;
            $data->edu_institute_name = $request->edu_institute_name;

            $data->user_height = $request->user_height;
            $data->user_blood_group = $request->user_blood_group;
            $data->user_body_weight = $request->user_body_weight;
            $data->user_body_color = $request->user_body_color;
            $data->user_fitness_disabilities = $request->user_fitness_disabilities;
            $data->no_of_brother = $request->no_of_brother;
            $data->no_of_sister = $request->no_of_sister;
            $data->father_occupation = $request->father_occupation;
            $data->father_name = $request->father_name;
            $data->mother_occupation = $request->mother_occupation;
            $data->mother_name = $request->mother_name;
            $data->smoke = $request->smoke;
            $data->email_verified_at = empty($data->email_verified_at) && $request->email_verified_at == 1 ? Carbon::now() : $data->email_verified_at;
            $data->user_status = $request->user_status;
            $data->user_bio_data_path = $this->uploadFile($request, 'user_bio_data_path', $this->file_dir, $data->user_bio_data_path);
            $data->comments = $request->comments;
            $data->save();

            if($request->hasFile('image_path')){
                UserImage::where('user_id', $data->id)->update(['profile_pic' => false]);
                $userImage = new UserImage();
                $userImage->user_id = $data->id;
                $userImage->image_path = $this->UploadImage($request, 'image_path', $this->client_images_dir, 150, Null, Null);
                $userImage->profile_pic = true;
                $userImage->save();
            }
            try{
                event(new Registered($data));
                $message = $this->getRegisterSuccessfullyMessage($request->password, $request->email);
                AccountNotification::dispatch($data->email, 'Registration Successfully', $message)->delay(1);
            }catch(Exception $e){
                //
            }
            DB::commit();
            $this->success('user Information Add Successfully. '. $email_error);
        }catch(Exception $e){
            DB::rollBack();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Get Profile Verified Message
     */
    protected function ProfileVerifiedMessage(){
        $system = SystemInfo::first();
        $message = '
            <div>
                <div>
                    <img src="'.asset($system->logo).'" style="height: 80px;">
                </div>
                <h3 style="margin: 0px 0px 10px 0px; color: #fff; font-size: 22px; background: #dd2476; padding: 5px 0px 5px 15px;">
                Great! Your profile has been verified.
                    <span style="font-size: 14px; padding: 10px; float: right; margin-top:-5px;">'.date('d-M-Y').'</span>
                </h3>
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                Your profile has been verified successfully.<br><br>
                <img src="'.asset('image.png').'"><br><br>
                All the best for your Partner Search!

            </div>
        ';
        return $message;
    }

    /**
     * Update Password Email
     * Attached Password with Email
     * @prams Password Plain Text
     */
    protected function passwordChangeMessage($password){
        $system = SystemInfo::first();
        $message = '
            <div>
                <div>
                    <img src="'.asset($system->logo).'" style="height: 80px;">
                </div>
                <h3 style="margin: 0px 0px 10px 0px; color: #fff; font-size: 22px; background: #dd2476; padding: 5px 0px 5px 15px;">
                    Account Password reset.
                    <span style="font-size: 14px; padding: 10px; float: right; margin-top:-5px;">'.date('d-M-Y').'</span>
                </h3>
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                Your password has been changeed successfully.<br>
                Your New Password is: '.$password.'<br><br>
                All the best for your Partner Search!

            </div>
        ';
        return $message;
    }

    /**
     * Edit user Info
     */
    public function edit(Request $request){
        // $this->addMonitoring('Edit user');
        $prams['data'] = User::withTrashed()->where('id', $request->id)->first();
        $prams['religions'] = Religious::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['religious_casts'] = ReligiousCast::where('status','published')->orderBy('religious_id', 'ASC')->get();
        $prams['professions'] = CareerProfessional::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['incomes'] = MonthlyIncome::where('status','published')->get();
        $prams['educations'] = EducationLevel::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['countries'] = Country::orderBy('country', 'ASC')->get();
        $prams['maritalStatus'] = MaritalStatus::where('status','published')->orderBy('name','ASC')->get();
        return view('backEnd.user.create', $prams)->render();
    }

    /**
     * Change User Status Page Show
     */
    public function createStatusUpdate(Request $request){
        $this->addMonitoring('Change User Status');
        $prams['data'] = User::withTrashed()->where('id', $request->id)->first();
        return view('backEnd.user.changeStatus', $prams)->render();
    }

    /**
     * Chage User Status
     */
    public function storeStatusUpdate(Request $request){
        try{
            DB::beginTransaction();
            // $this->addMonitoring('Change User Status','Update');
            $data = User::withTrashed()->where('id', $request->id)->first();
            $data->modified_by = Auth::guard('admin')->user()->id;
            if( $request->user_status != $data->user_status && $request->user_status == 1){
                try{
                    $message = $this->ProfileVerifiedMessage();
                    AccountNotification::dispatch($data->email, 'Your profile has been verified', $message)->delay(1);
                }catch(Exception $e){
                //
                }
            }
            $data->user_status = $request->user_status;
            $data->email_verified_at = empty($data->email_verified_at) && $request->email_verified_at == 1 ? Carbon::now() : $data->email_verified_at;
            $data->comments = $request->comments;
            $data->save();
            DB::commit();
            $this->success('user Status Update Successfully.');
        }catch(Exception $e){
            DB::rollback();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Change Password Page Show
     */
    public function showChangePassword(Request $request){
        // $this->addMonitoring('User password change');
        $prams['data'] = User::withTrashed()->where('id', $request->id)->first();
        return view('backEnd.user.changePassword', $prams)->render();
    }

    /**
     * Update Password
     */
    public function updatePassword(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'password' => ['required','string','min:6']
            ]);
            if($validator->fails()){
                $this->message = $this->getValidationError($validator);
                return $this->output();
            }

            DB::beginTransaction();
            // $this->addMonitoring('Change Password','Update');
            $data = User::withTrashed()->where('id', $request->id)->first();
            $data->modified_by = Auth::guard('admin')->user()->id;


            try{
                $message = $this->passwordChangeMessage($request->password);
                AccountNotification::dispatch($data->email, 'Password Reset', $message)->delay(1);
            }catch(Exception $e){
                //
            }

            $data->password = bcrypt($request->password);
            $data->comments = $request->comments;
            $data->save();
            DB::commit();
            $this->success('user Status Update Successfully.');
        }catch(Exception $e){
            DB::rollback();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show user Profile
     */
    public function showProfile(Request $request){
        // $this->addMonitoring('View user Profile');
        $data = User::withTrashed()->where('id', $request->id)->first();
        return view('backEnd.user.profile',['data' => $data])->render();
    }

    /**
     * Download Bio Data
     */
    public function downloadBio(Request $request){
        $data = User::withTrashed()->where('id', $request->id)->first();
        if( file_exists($data->user_bio_data_path) ){
            return response()->download($data->user_bio_data_path);
        }
        return back()->with('error','File Not Found');
    }

    /**
     * Make the selected user As Archive
     */
    public function archive(Request $request){
        try{
            // $this->addMonitoring('user List','Make Archive', 'active', 'archive');
            $data = User::withTrashed()->where('id', $request->id)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected user As Active from Archive
     */
    public function restore(Request $request){
        try{
            // $this->addMonitoring('user Archive List', 'Make active', 'archive', 'active');
            $data = User::withTrashed()->where('id', $request->id)->first();
            $data->restore();
            $this->success('user Restore Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive user List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable($request, 'archive');
        }

        // $this->addMonitoring('user Archive List');
        $params = [
            'nav'               => 'user',
            'subNav'            => 'user.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'user Archive List',
            'tableStyleClass'   => 'bg-success',
            'professions'       => CareerProfessional::orderBy('name','ASC')->get(),
            'educations'        => EducationLevel::orderBy('name','ASC')->get(),
            'religious'         => Religious::orderBy('name','ASC')->get(),
            'countries'         => Country::orderBy('country', 'ASC')->get(),
            'divisions'         => Division::orderBy('name', 'ASC')->get(),
            'districts'         => District::orderBy('name','ASC')->get(),
            'maritalStatus'     => MaritalStatus::where('status','published')->orderBy('name','ASC')->get(),
        ];
        return view('backEnd.user.table', $params);
    }

    /**
     * Get user DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable(Request $request, $type = 'list'){

        if( $type == "list" ){
            $data = User::orderBy('id', 'DESC');
        }else{
            $data = User::onlyTrashed()->orderBy('id', 'DESC');
        }

        if( !is_null($request->profession_id) ){
            $data->where(function($qry) use($request){
                foreach($request->profession_id as $id){
                    $qry->orWhere('career_working_profession_id', $id);
                }
            });
        }
        if( !is_null($request->education_id) ){
            $data->where(function($qry) use($request){
                foreach($request->education_id as $id){
                    $qry->orWhere('education_level_id', $id);
                }
            });
        }
        if( !is_null($request->religious_id) ){
            $data->where(function($qry) use($request){
                foreach($request->religious_id as $id){
                    $qry->orWhere('religious_id', $id);
                }
            });
        }
        if( !is_null($request->country) ){
            $data->where(function($qry) use($request){
                foreach($request->country as $country){
                    $qry->orWhere('location_country', $country)
                        ->orWhere('user_present_country', $country);
                }
            });
        }

        if( !is_null($request->division) ){
            $data->where(function($qry) use($request){
                foreach($request->division as $division){
                    $qry->orWhere('division_id', $division);
                }
            });
        }

        if( !is_null($request->district) ){
            $data->where(function($qry) use($request){
                foreach($request->district as $district){
                    $qry->orWhere('district_id', $district);
                }
            });
        }

        if( !is_null($request->gender) ){
            $data->where(function($qry) use($request){
                foreach($request->gender as $gender){
                    $qry->orWhere('gender', $gender);
                }
            });
        }

        if( !is_null($request->marital_status) ){
            $data->where(function($qry) use($request){
                foreach($request->marital_status as $status){
                    $qry->orWhere('marital_status', $status);
                }
            });
        }


        if( !empty($request->partner_min_age) && !empty($request->partner_max_age) ){
            $data->whereBetween('date_of_birth', $this->getDOBRange($request->partner_min_age-1, $request->partner_max_age+1) );
        }

        if( !empty($request->part_min_feet) && !empty($request->part_max_feet) ){
            $min = $this->calculateHeight($request, 'part_min_feet', 'part_min_inch');
            $max = $this->calculateHeight($request, 'part_max_feet', 'part_max_inch');
            $data->where('user_height','>=', $min)->where('user_height','<=', $max);
        }

        $data = $data->get();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('created_by', function($row){ return empty($row->createdBy) ? 'N/A' : $row->createdBy->name; })
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            ->addcolumn('name', function($row){ return $row->first_name . ' ' . $row->last_name; })
            ->addcolumn('gender', function($row){ return $row->gender == "M" ? 'Male' : 'Female'; })
            ->addcolumn('marital_status', function($row){
                if( $row->marital_status == "M" ){
                    return 'Married';
                }elseif( $row->marital_status == "U" ){
                    return 'Unmarried';
                }elseif( $row->marital_status == "D" ){
                    return 'Unmarried';
                }
                else{
                    return $row->marital_status;
                }
            })
            ->addColumn('profession', function($row){ return isset($row->careerProfession->name) ? $row->careerProfession->name : 'N/A'; })
            ->addColumn('country', function($row){ return $row->location_country; })
            ->addcolumn('image', function($row){ return isset($row->profilePic->image_path) && file_exists($row->profilePic->image_path) ? '<img src="'.asset($row->profilePic->image_path).'"height="180">' : '<img src="'.asset('frontEnd/dummy_user.jpg').'"height="180">'; })
            ->addColumn('status', function($row){
                if( $row->user_status == 1 ){
                    return '<span class="badge badge-success">Active</span>';
                }
                elseif( $row->user_status == 2 ){
                    return '<span class="badge badge-primary">verified</span>';
                }
                elseif( $row->user_status == 3 ){
                    return '<span class="badge badge-warning">Unverified</span>';
                }else{
                    return '<span class="badge badge-danger">Deactive</span>';
                }
            })
            ->addColumn('action',function($row) use($type){
                return $this->getUserActionOptions($row, $type);
            })
            ->rawColumns(['action', 'image','status'])
            ->make(true);
    }


    /*************************************************************************************************
     * User Access Log
     */
    public function accessLog(Request $request){
        if( $request->ajax() ){
            return $this->getAccessLogDataTable($request, 'archive');
        }
        $params = [
            'nav'               => 'user',
            'subNav'            => 'user.monitor_list',
            'tableColumns'      => $this->getAccessLogColumns(),
            'dataTableColumns'  => $this->getAccessLogDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'User Access Log',
            'tableStyleClass'   => 'bg-success',
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Get AccessLog Table Column List
     */
    private function getAccessLogColumns(){
        $columns = ['#', 'ip', 'os', 'device', 'name', 'phone', 'city','country','visitpage','time'];
        return $columns;
    }

    /**
     * Get AccessLog DataTable Column List
     */
    private function getAccessLogDataTableColumns(){
        $columns = ['index', 'ip', 'os', 'device', 'name', 'phone', 'city', 'countryCode', 'visit_count','time'];
        return $columns;
    }

    /**
     * Access Log DataTable
     */
    protected function getAccessLogDataTable(){
        $data = Visitor::where('user_id', '!=', Null)->orderBy('id', 'DESC')->get();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('name', function($row){ return $row->user->first_name.' '.$row->user->last_name; })
            ->addColumn('phone', function($row){ return $row->user->phone; })
            ->addColumn('time', function($row){ return Carbon::parse($row->updated_at)->diffForHumans(); })
            ->make(true);
    }


    /**
     * Profile Image Section
     */
    public function showImages($id){
        $user = User::where('id', $id)->withTrashed()->firstOrFail();
        return view('backEnd.user.profileImage',['data' => $user])->render();
    }

    /**
     * Delete Picture
     */
    protected function deletePicture(Request $request){
        try{
            $user_image = UserImage::findOrFail($request->id);
            $user_id = $user_image->user->id;
            $this->RemoveFile($user_image->image_path);
            $user_image->delete();
            $this->success('Image Delete Successfully');
            $this->html_page = $this->showImages($user_id);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

     /**
     * Rotated Picture
     */
    protected function rotatePicture(Request $request){
        try{
            $user_image = UserImage::findOrFail($request->id);
            $user_image->image_path = $this->rotateImage($user_image->image_path);
            $user_image->save();
            $this->html_page = $this->showImages($user_image->user_id);
            $this->success('Image Rotated Successfully');
            $this->table="true";
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Upload Images
     */
    public function uploadImages(Request $request){
        try{
            $user = User::findOrFail($request->id );
            $this->uploadProPic($request, $user);
            $all_images = $this->UploadMultipleImage($request, 'multi_profile_image', $this->client_images_dir, Null, 220);
            if( is_array($all_images) ){
                foreach($all_images as $image){
                    $data = new UserImage();
                    $data->user_id = $user->id;
                    $data->image_path = $image;
                    $data->save();
                }
            }
            try{
                $user->user_bio_data_path = $this->uploadFile($request, 'user_bio_data_path', $this->file_dir, $user->user_bio_data_path);
                $user->nid_image = $this->UploadImage($request, 'nid_image', $this->file_dir,  Null, 480, $user->nid_image);
                $user->passport_image = $this->UploadImage($request, 'passport_image', $this->file_dir,  Null, 480, $user->passport_image);
            }catch(Exception $e){

            }
            $user->save();
            $this->success('Documents Added Successfully');
            $this->html_page = $this->showImages($user->id);
            $this->modal = false;
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }
}
