<?php

namespace App\Http\Controllers\FrontEnd;

use App\BlockProfile;
use App\CareerProfessional;
use App\Country;
use App\District;
use App\Division;
use App\EducationLevel;
use App\Http\Components\Profile;
use App\Http\Controllers\Controller;
use App\Jobs\AccountNotification;
use App\LifeStyle;
use App\MaritalStatus;
use App\MonthlyIncome;
use App\Religious;
use App\ReligiousCast;
use App\Upozila;
use App\User;
use App\UserImage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    use Profile;
    /**
     * Show or View Update Profile Page
     */
    public function showUpdateProfile(){
        $user = Auth::user();
        $prams['user'] = $user;
        $prams['profile_complete'] = $this->getProfileCompleteCount($user);
        $prams['religious'] = Religious::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['professions'] = CareerProfessional::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['incomes'] = MonthlyIncome::where('status','published')->get();
        $prams['educations'] = EducationLevel::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['countries'] = Country::orderBy('country', 'ASC')->get();
        $prams['lifeStyles'] = LifeStyle::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['divisions'] = Division::orderBy('name', 'ASC')->get();
        
        return view('frontEnd.account.profileUpdate', $prams);
    }

    /**
     * Update Profile Picture
     */
    public function updateProfilePic(Request $request, $user = Null){        
        try{
            if( empty($user) ){
                $user = Auth::user();
            }
            $this->uploadProPic($request, $user);
            $this->success('Profile Picture Update Successfully');
            $this->button = true;
        }catch(Exception $e){
            $this->message = $this->getError($e);
        } 
        return back()->with('output', $this->output());       
    }

    /**
     * Upload Picture
     */
    public function uploadPicture(Request $request){
        try{
            if($request->hasFile('image_path')){
                $userImage = new UserImage();
                $userImage->user_id = Auth::user()->id;
                $userImage->image_path = $this->UploadImage($request, 'image_path', $this->client_images_dir, null, 420, $userImage->image_path);
                $userImage->save();
                $this->success('Image Upload Successfully');
            }
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return back()->with('output', $this->output());
    }

    /**
     * Delete Picture
     */
    protected function deletePicture($id){
        try{
            $user_image = UserImage::findOrFail($id);
            $this->RemoveFile($user_image->image_path);
            $user_image->delete();
            $this->success('Image Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return back()->with('output', $this->output());
    }

    /**
     * Update Profile Password
     */
    protected function updatePassword(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            if( $validator->fails() ){
                $this->message = $this->getValidationError($validator);
                return $this->output();
            }
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->password);
            $user->save();
            $this->success('Password Update Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        $this->table = false;
        $this->reset = true;
        $this->button = true;
        return $this->output();
    }

    /**
     * Update Profile Data
     */
    public function updateProfile(Request $request){
        try{
            $validator = Validator::make($request->all(), $this->getProfileValidateData());
            if( $validator->fails() ){
                $this->message = $this->getValidationError($validator);
                return $this->output();
            }
            $user = User::find(Auth::user()->id);
            $dob = Carbon::parse($request->year.'-'.$request->month.'-'.$request->day)->format('Y-m-d');
            // dd($request->year, $request->month, $request->day, $dob);
            // Basic Information
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->marital_status = $request->marital_status;
            $user->gender = $request->gender;
            $user->looking_for = $request->looking_for;
            $user->location_country = $request->location_country;
            $user->date_of_birth = $dob;
            $user->religious_id = $request->religious_id;
            $user->religious_cast_id = $request->religious_cast_id;
            $user->lifestyle_id = $request->lifestyle_id;
            $user->user_bio_myself = $request->user_bio_myself;
            $user->nid  = $request->nid;
            $user->passport = $request->passport;
            $user->nid_image = $this->UploadImage($request, 'nid_image', $this->file_dir, Null, 240, $user->nid_image);
            $user->passport_image = $this->uploadFile($request, 'passport_image', $this->file_dir, Null, 240, $user->passport_image);
            
            // Education & Career
            $user->education_level_id = $request->education_level_id;
            $user->edu_institute_name = $request->edu_institute_name;
            $user->career_working_profession_id = $request->career_working_profession_id;
            $user->career_working_name = $request->career_working_name;
            $user->career_monthly_income_id = $request->career_monthly_income_id;
            $user->organisation = $request->organisation;
            $user->major_subject = $request->major_subject;

            // Personal & family Information
            $user->user_height = $this->calculateHeight($request);
            $user->user_blood_group = $request->user_blood_group;
            $user->user_body_weight = $request->user_body_weight;
            $user->user_body_color = $request->user_body_color;
            $user->user_fitness_disabilities = $request->user_fitness_disabilities;
            $user->smoke = $request->smoke;
            $user->mother_tongue = $request->mother_tongue;
            $user->no_of_brother = $request->no_of_brother;
            $user->no_of_sister = $request->no_of_sister;
            $user->father_occupation = $request->father_occupation;
            $user->father_name = $request->father_name;
            $user->mother_occupation = $request->mother_occupation;
            $user->mother_name = $request->mother_name;
            $user->gardian_contact_no = $request->gardian_contact_no;
            $user->family_details = $request->family_details;
            $user->family_values = $request->family_values;
            
            // Address
            $user->user_present_address = $request->user_present_address;
            $user->user_present_city = $request->user_present_city;
            $user->division_id = $request->division_id;
            $user->district_id = $request->district_id;
            $user->upozila_id = $request->upozila_id;
            $user->user_present_country = $request->user_present_country;
            $user->user_permanent_address = $request->user_permanent_address;
            $user->user_permanent_city = $request->user_permanent_city;
            $user->user_permanent_country = $request->user_permanent_country;

            // Partneer Info 
            $user->partner_min_age = $request->partner_min_age;
            $user->partner_max_age = $request->partner_max_age;
            $user->partner_min_height = $this->calculateHeight($request, 'part_min_feet', 'part_min_inch');
            $user->partner_max_height = $this->calculateHeight($request, 'part_max_feet', 'part_max_inch');
            $user->partner_mother_tongue = $request->partner_mother_tongue;

            $user->partner_body_color = $request->partner_body_color;
            $user->partner_blood_group = $request->partner_blood_group;
            $user->partner_eye_color = $request->partner_eye_color;
            $user->partner_complexion = $request->partner_complexion;
            $user->partner_dite = $request->partner_dite;
            $user->partner_father_occupation = $request->partner_father_occupation;
            $user->partner_mother_occupation = $request->partner_mother_occupation;

            $user->partner_city = $request->partner_city;
            $user->partner_marital_status = $request->partner_marital_status;
            $user->partner_religion = $request->partner_religion;
            $user->partner_religion_cast = $request->partner_religion_cast;
            $user->partner_country = $request->partner_country;
            $user->partner_education = $request->partner_education;
            $user->partner_profession = $request->partner_profession;
            
            $user->user_bio_data_path = $this->uploadFile($request, 'user_bio_data_path', $this->file_dir, $user->user_bio_data_path);
            $user->save();
            $this->success('Profile Information Update Successfully');
            $this->button = true;
            $this->table = false;
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * View User Profile
     */
    public function viewProfile(Request $request){
        
        $profile = User::findOrFail($request->id);        
        $prams['profile'] = $profile;
        $prams['similar_profiles'] = $this->matcheProfile($profile, 'All', true);
        
        $prams['visitor_profiles'] = $this->getProfileVisitor($profile);
        $prams['sent_proposal'] = is_null($this->isProposalSent($profile->id, Auth::user()->id)) ? true : false;
        $prams['block_profile'] = $this->isBlockProfile(Auth::user()->id, $profile->id);
        $prams['is_connected'] = $this->isConnected($profile->id, Auth::user()->id);
        $this->addProfileVisitorInfo($profile->id);
        try{
            $subject = $profile->firstname.' visit your Profile';
            $notification_message = $this->getProfileVisitMessage(Auth::user(), $profile);
            AccountNotification::dispatch($profile->email, $subject, $notification_message)->delay(1);
        }catch(Exception $e){
            // Mail is not Sent
        }
        return view('frontEnd.account.profile', $prams);
    }

    /**
     * View Contact Details
     */
    public function viewContactDetails(Request $request){
        try{
            $user = Auth::user();
            if( !$this->checkActivityPermission('view_profile', $user)){
                return $this->apiOutput();
            }
            $this->updateUserActivity('view_profile', $user, $request->profile_id);
            $this->data = $this->getContactDetails($request->profile_id);
            try{
                $sent_to = User::find($request->profile_id);
                $message = $this->getViewContactMessage($user, $sent_to);
                AccountNotification::dispatch($sent_to->email, "View Contact Details", $message);
            }catch(Exception $e){

            }
            $this->apiSuccess();
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->apiOutput();
    }

    /**
     * Sent a Proposal to Other Profile
     */
    public function sentProposal(Request $request){ 
        if($request->profile_id == Auth::user()->id){
            $this->message('You Can\'t Send Self Invitation');
            return $this->output();
        }
        if( !$this->checkActivityPermission('proposal', Auth::user()) ){
            return $this->output();
        }else{
            try{
                DB::beginTransaction();
                if($proposal_id = $this->addSentProposal($request->profile_id)){
                    $this->updateUserActivity('proposal', Auth::user());
                    $profile = User::find($request->profile_id);   
                    $error = "";                 
                    try{
                        $subject = 'Congratulations, '.$profile->firstname.' wants to Connect with you.';
                        $notification_message = $this->getProposalInvitationMessage(Auth::user(), $profile, $proposal_id);
                        AccountNotification::dispatch($profile->email, $subject, $notification_message)->delay(1);
                    }catch(Exception $e){
                        // $error = "But Failed to Send Mail";
                    }
                    $this->success('Proposal has been Sent Successfully. '.$error);
                    $this->button = true; 
                    DB::commit();                    
                } 
            }catch(Exception $e){
                $this->message = $this->getError($e);
            }
            return $this->output();
        }
    }


    /**
     * Block User Profile
     */
    public function blockProfile(Request $request){
        try{
            if( !$this->checkActivityPermission('block_profile', Auth::user()->id) ){
                return $this->output();
            }
            if( $this->isBlockProfile(Auth::user()->id, $request->profile_id) ){
                $this->message = "You already blocked this Profile";
                return $this->output();
            }
            $data = new BlockProfile();
            $data->user_id = Auth::user()->id;
            $data->block_user_id = $request->profile_id;
            $data->save();
            $this->success('Profile Blocked Successfully');
            $this->button = true;
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Unblock User Profile
     */
    public function unBlockProfile(Request $request){
        try{
            if( $this->isBlockProfile(Auth::user()->id, $request->profile_id) ){
                BlockProfile::where('user_id', Auth::user()->id)->where('block_user_id', $request->profile_id)->delete();
                $this->success('Profile Unblock Successfully');
            }else{
                $this->success('You already unblocked this Profile');
            }
            $this->button = true;
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }


    /********************************************************************************************
     *  Incomplete Profile Section
     */
    public function showIncompleteProfilePage(){
        $user = Auth::user();
        $incomplete_step = 0;
        if( empty($user->profilePic) || !file_exists($user->profilePic->image_path) ){
            // Profile Image Missing
            $incomplete_step = 1;
        }
        elseif( empty($user->user_height) || empty($user->marital_status) || empty($user->user_present_address) || empty($user->father_name) || empty($user->mother_name) ){
            // Basic Imformation missing
            $incomplete_step = 2;
        }
        elseif( empty($user->education_level_id) || empty($user->edu_institute_name) ){
            // Education or Career Information Meesing
            $incomplete_step = 3;

        }elseif( empty($user->partner_min_height) || empty($user->partner_religion) || empty($user->partner_country) ){
            // Patner Information Messing
            $incomplete_step = 4;
        }
        else{            
            return redirect('/profile/instruction');
        }
        $param['incomplete_step'] = $incomplete_step; 
        $param['profile'] = $user;
        $param['religious'] = Religious::where('status','published')->orderBy('name', 'ASC')->get();
        $param['professions'] = CareerProfessional::where('status','published')->orderBy('name', 'ASC')->get();
        $param['incomes'] = MonthlyIncome::where('status','published')->get();
        $param['educations'] = EducationLevel::where('status','published')->orderBy('name', 'ASC')->get();
        $param['countries'] = Country::orderBy('country', 'ASC')->get();
        $param['lifeStyles'] = LifeStyle::where('status','published')->orderBy('name', 'ASC')->get();
        $param['divisions'] = Division::orderBy('name', 'ASC')->get();
        $param['maritalStatus'] = MaritalStatus::where('status','published')->orderBy('name','ASC')->get();
        return view('frontEnd.account.incompleteProfile', $param);
    }

    /**
     * Incomplete profile data save
     */
    public function storeIncompleteProfile(Request $request){

        $profile = User::find(Auth::user()->id);
        $profile->nid = !is_null( $request->nid ) ? $request->nid : $profile->nid;
        $profile->passport = !is_null( $request->passport ) ? $request->passport : $profile->passport;
        if( $request->hasFile('image_path') ){
            $this->updateProfilePic($request);
        }
        $profile->user_bio_data_path = $this->uploadFile($request, 'user_bio_data_path', $this->file_dir, $profile->user_bio_data_path);
        $profile->nid_image = $this->UploadImage($request, 'nid_image', $this->file_dir,  Null, 480, $profile->nid_image);
        $profile->passport_image = $this->UploadImage($request, 'passport_image', $this->file_dir,  Null, 480, $profile->passport_image);
        
        // Step 2 
        $height = $this->calculateHeight($request);
        $profile->marital_status = !is_null( $request->marital_status ) ? $request->marital_status : $profile->marital_status;
        $profile->mother_tongue = !is_null( $request->mother_tongue ) ? $request->mother_tongue : $profile->mother_tongue;
        $profile->user_height = !is_null( $height ) ? $height : $profile->user_height;
        $profile->user_body_weight = !is_null( $request->user_body_weight ) ? $request->user_body_weight : $profile->user_body_weight;
        $profile->user_body_color = !is_null( $request->user_body_color ) ? $request->user_body_color : $profile->user_body_color;
        $profile->user_blood_group = !is_null( $request->user_blood_group ) ? $request->user_blood_group : $profile->user_blood_group;
        $profile->user_fitness_disabilities = !is_null( $request->user_fitness_disabilities ) ? $request->user_fitness_disabilities : $profile->user_fitness_disabilities;
        $profile->lifestyle_id = !is_null( $request->lifestyle_id ) ? $request->lifestyle_id : $profile->lifestyle_id;
        $profile->lifestyle_id = !is_null( $request->lifestyle_id ) ? $request->lifestyle_id : $profile->lifestyle_id;
        $profile->eye_color = !is_null( $request->eye_color ) ? $request->eye_color : $profile->eye_color;
        $profile->hair_color = !is_null( $request->hair_color ) ? $request->hair_color : $profile->hair_color;
        $profile->complexion = !is_null( $request->complexion ) ? $request->complexion : $profile->complexion;
        $profile->diet = !is_null( $request->diet ) ? $request->diet : $profile->diet;
        $profile->drink = !is_null( $request->drink ) ? $request->drink : $profile->drink;
        $profile->no_children = !is_null( $request->no_children ) ? $request->no_children : $profile->no_children;
        $profile->user_bio_myself = !is_null( $request->user_bio_myself ) ? $request->user_bio_myself : $profile->user_bio_myself;
        
        // Family Info
        $profile->father_name = !is_null( $request->father_name ) ? $request->father_name : $profile->father_name;
        $profile->mother_name = !is_null( $request->mother_name ) ? $request->mother_name : $profile->mother_name;
        $profile->father_occupation = !is_null( $request->father_occupation ) ? $request->father_occupation : $profile->father_occupation;
        $profile->mother_occupation = !is_null( $request->mother_occupation ) ? $request->mother_occupation : $profile->mother_occupation;
        $profile->no_of_sister = !is_null( $request->no_of_sister ) ? $request->no_of_sister : $profile->no_of_sister;
        $profile->no_of_brother = !is_null( $request->no_of_brother ) ? $request->no_of_brother : $profile->no_of_brother;
        $profile->family_details = !is_null( $request->family_details ) ? $request->family_details : $profile->family_details;
        $profile->family_values = !is_null( $request->family_values ) ? $request->family_values : $profile->family_values;
        
        // Address
        $profile->user_permanent_address = !is_null( $request->user_permanent_address ) ? $request->user_permanent_address : $profile->user_permanent_address;
        $profile->user_permanent_city = !is_null( $request->user_permanent_city ) ? $request->user_permanent_city : $profile->user_permanent_city;
        $profile->division_id = !is_null( $request->division_id ) ? $request->division_id : $profile->division_id;
        $profile->district_id = !is_null( $request->district_id ) ? $request->district_id : $profile->district_id;
        $profile->upozila_id = !is_null( $request->upozila_id ) ? $request->upozila_id : $profile->upozila_id;

        $profile->user_permanent_country = !is_null( $request->user_permanent_country ) ? $request->user_permanent_country : $profile->user_permanent_country;
        $profile->user_present_country = !is_null( $request->user_present_country ) ? $request->user_present_country : $profile->user_present_country;
        $profile->user_present_city = !is_null( $request->user_present_city ) ? $request->user_present_city : $profile->user_present_city;
        $profile->user_present_address = !is_null( $request->user_present_address ) ? $request->user_present_address : $profile->user_present_address;

        // Step 3 || Education Or Career Info Meesing        
        $profile->edu_institute_name = !is_null( $request->edu_institute_name ) ? $request->edu_institute_name : $profile->edu_institute_name;
        $profile->major_subject = !is_null( $request->major_subject ) ? $request->major_subject : $profile->major_subject;
        $profile->career_working_profession_id = !is_null( $request->career_working_profession_id ) ? $request->career_working_profession_id : $profile->career_working_profession_id;
        $profile->career_working_name = !is_null( $request->career_working_name ) ? $request->career_working_name : $profile->career_working_name;
        $profile->organisation = !is_null( $request->organisation ) ? $request->organisation : $profile->organisation;
        $profile->career_monthly_income_id = !is_null( $request->career_monthly_income_id ) ? $request->career_monthly_income_id : $profile->career_monthly_income_id;
        
        // Step 4 Life Partner Information
        $min_height = $this->calculateHeight($request, 'part_min_feet', 'part_min_inch');
        $max_height = $this->calculateHeight($request, 'part_max_feet', 'part_max_inch');
        $profile->partner_min_age = !is_null( $request->partner_min_age ) ? $request->partner_min_age : $profile->partner_min_age;
        $profile->partner_max_age = !is_null( $request->partner_max_age ) ? $request->partner_max_age : $profile->partner_max_age;
        $profile->partner_min_height = !is_null( $min_height ) ? $min_height : $profile->partner_min_height;
        $profile->partner_max_height = !is_null( $max_height ) ? $max_height : $profile->partner_max_height;
        $profile->partner_mother_tongue = !is_null( $request->partner_mother_tongue ) ? $request->partner_mother_tongue : $profile->partner_mother_tongue;
        $profile->partner_body_color = !is_null( $request->partner_body_color ) ? $request->partner_body_color : $profile->partner_body_color;
        $profile->partner_blood_group = !is_null( $request->partner_blood_group ) ? $request->partner_blood_group : $profile->partner_blood_group;
        $profile->partner_eye_color = !is_null( $request->partner_eye_color ) ? $request->partner_eye_color : $profile->partner_eye_color;
        $profile->partner_complexion = !is_null( $request->partner_complexion ) ? $request->partner_complexion : $profile->partner_complexion;
        $profile->partner_dite = !is_null( $request->partner_dite ) ? $request->partner_dite : $profile->partner_dite;
        $profile->partner_father_occupation = !is_null( $request->partner_father_occupation ) ? $request->partner_father_occupation : $profile->partner_father_occupation;
        $profile->partner_mother_occupation = !is_null( $request->partner_mother_occupation ) ? $request->partner_mother_occupation : $profile->partner_mother_occupation;
        

        $profile->partner_city = !is_null( $request->partner_city ) ? $request->partner_city : $profile->partner_city;
        $profile->partner_marital_status = !is_null( $request->partner_marital_status ) ? $request->partner_marital_status : $profile->partner_marital_status;
        $profile->partner_religion = !is_null( $request->partner_religion ) ? $request->partner_religion : $profile->partner_religion;
        $profile->partner_religion_cast = !is_null( $request->partner_religion_cast ) ? $request->partner_religion_cast : $profile->partner_religion_cast;
        $profile->partner_country = !is_null( $request->partner_country ) ? $request->partner_country : $profile->partner_country;
        $profile->partner_education = !is_null( $request->partner_education ) ? $request->partner_education : $profile->partner_education;
        $profile->partner_profession = !is_null( $request->partner_profession ) ? $request->partner_profession : $profile->partner_profession;        
        $profile->save();

        if( !is_null($profile->partner_min_height) && !is_null($profile->partner_religion) && !is_null($profile->partner_country) ){
            $message = $this->getRegisterSuccessfullyMessage();      
            AccountNotification::dispatch($profile->email, 'Registration Successfully', $message)->delay(1);           
        }

        $this->success('Information Update Successfully');
        return redirect('profile/incomplete')->with('output', $this->output());
    }

    /**
     * Get District
     */
    public function getDistrict(Request $request){
        try{
            $data_list = District::where('division_id', $request->division_id)->orderBy('name','ASC')->get();
            $option = '<option value=""> Select District </option>';
            foreach($data_list as $list){
                $option .= '<option value="'.$list->id.'" ';
                if( !is_null(Auth::user()) && Auth::user()->district_id == $list->id){
                    $option .= 'selected';
                }
                $option .= '> '.$list->name.'</option>';
            }
            return $option;
        }catch(Exception $e){
            return 'error';
        }
    }

    /**
     * Get  Upozila
     */
    public function getUpazila(Request $request){
        try{
            $data_list = Upozila::where('district_id', $request->district_id)->orderBy('name','ASC')->get();
            $option = '<option value=""> Select Upazila </option>';
            foreach($data_list as $list){
                $option .= '<option value="'.$list->id.'" ';
                if( !is_null(Auth::user()) && Auth::user()->upozila_id == $list->id ){
                    $option .= 'selected';
                }
                $option .= '> '.$list->name.'</option>';
            }
            return $option;
        }catch(Exception $e){
            return 'error';
        }
    }
}
