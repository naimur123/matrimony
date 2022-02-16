<?php

namespace App\Http\Components;

use App\BlockProfile;
use App\CareerProfessional;
use App\ChatTracking;
use App\EducationLevel;
use App\Notification;
use App\ProfileVisitor;
use App\Proposal;
use App\ReligiousCast;
use App\SystemInfo;
use App\User;
use App\UserActivity;
use App\UserImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait Profile{
    
    /**
     * Check Profile 
     */
    protected function IsProfileComplete(){
        $user = Auth::user();        
        if( empty($user->profilePic) ||
            empty($user->user_height) || empty($user->marital_status) || empty($user->user_present_address) ||
            empty($user->education_level_id) || empty($user->edu_institute_name) ||
            empty($user->father_name) || empty($user->mother_name) ||
            empty($user->partner_min_height) || empty($user->partner_religion) || empty($user->partner_country)          
        ){
            return false;
        }
        return true;
    }

    /**
     * Check Profile is Approve or nor
     */
    protected function isProfileApprove($profile){
        if( !empty($profile->subscribePackage) ){
            return true;
        }
        if($profile->user_status){
            return true;
        }
        return false;
    }

    /**
     * Check Photo upload permission
     */
    protected function checkUploadPhotoPermission($user){
        $current_package = $user->subscribePackage;
        if( empty($current_package) ){
            $this->message = "For Upload Photo, you have to subscribe a package first.";
            return false;
        }else{
            $package_details = $user->subscribePackage->packageDetails;
            if($package_details->post_photo < count($user->userImages) ){
                return true;
            }
            $this->message = "Sorry! Your Photo uploading limit was over";
            return false;
        }
    }

    /**
     * Check All Activity Limit Permission
     */
    protected function checkActivityPermission($activity_name, $user, $to_user_id = 0){
        $current_package = $user->subscribePackage;
        if( empty($current_package) ){
            $this->message = $this->packageUpgradeMessage();
            return false;
        }else{            
            $package_details = $user->subscribePackage->packageDetails;
            $user_activity = $this->getActivitySum($package_details->subscribe_package_id);
            
            if( strtolower($activity_name) == "proposal" || strtolower($activity_name) == "sent_proposal"){
                if( $user_activity->total_sent_proposal < $package_details->total_proposal ){
                    return true;
                }else{
                    $this->message = "Your Proposal Sending Limit was Over. Please Sunscribe a Package. Thank you.";
                    return false;
                }
            } 
            elseif( strtolower($activity_name) == "accept_proposal"){
                // if( $user_activity->total_accept_proposal < $package_details->accept_proposal ){
                //     return true;
                // }else{
                //     $this->message = "Your Proposal accept Limit was Over. Please Sunscribe a Package. Thank you.";
                //     return false;
                // }
            }
            elseif( strtolower($activity_name) == "view_profile"){
                if( $user_activity->total_profile_view < $package_details->profile_view ){
                    return true;
                }else{
                    $this->message = "Your Monthly Profile's Contact details view Limit was Over. Please Sunscribe a new  Package. Thank you.";
                    return false;
                }
            }
            elseif( strtolower($activity_name) == "message"){
                $proposal = Proposal::where('proposal_sent_from', $user->id)->where('proposal_sent_to', $to_user_id)
                    ->orWhere(function($qry)use($user, $to_user_id){
                        $qry->where('proposal_sent_from', $to_user_id)->where('proposal_sent_to', $user->id);
                    })->orderBy('status','ASC')->first();
                if( !is_null($proposal) ){
                    if($proposal->status == "accept"){
                        return true;
                    }else{
                        $this->message = "<div style=\"padding:20px;text-align:center; \"><b>This Person is not accept your proposal yet. Please wait for accept it.</b>";
                        return false;
                    }                    
                }else{
                    $this->message = "<div style=\"padding:20px;text-align:center; \"><b>You are not connected with this person. If you want to connect with is person <br><a href=".url('profile/'.$to_user_id.'/proposal/sent')." class=\"ajax-click\">click here</a></b>";
                    return false;
                }
            }
            elseif( strtolower($activity_name) == "block_profile" ){
                if($package_details->block_profile == "yes" ){
                    $this->message = "Block profile feature is not available for you. To use this feature, please upgrade your package. Thank you.";
                    return false;
                }
                return true;
            }           
            return true;
        }
    }

    /**
     * Use Chat Calculation
     * Calculate the total Number of Chat is used 
     * in this package with Diffrent User
     */
    protected function getUsedChatCount($user){
        return ChatTracking::where('user_id', $user->id)
            ->where('subscribe_package_id', $user->subscribe_package_id)->count();
    }

    /**
     * Package Upgrade Message
     */
    protected function packageUpgradeMessage(){
        return "<div class=\"text-center\" style=\"padding-top:30px;\"><b>You are not eligible to use this feature. <br>To send invitation / proposal or view message, please upgrade your subscription package.<b><br> <a href=".url('/packages').">Upgrade Now</a></div>";
    }

    /**
     * Get Activity Sum
     */
    protected function getActivitySum($subscribe_package_id){
        return UserActivity::where('subscribe_package_id',$subscribe_package_id)
            ->select(
                DB::raw('sum(sent_proposal) as total_sent_proposal') ,
                DB::raw('sum(profile_view) as total_profile_view') ,
                DB::raw('sum(accept_proposal) as total_accept_proposal') 
            )->first();
    }
    
    /**
     * Get Profile Validate Data
     */
    protected function getProfileValidateData(){
        return [
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['nullable', 'string', 'max:255'],
            'phone'             => ['required', 'numeric','string','min:9'],
            'marital_status'    => ['required', 'string', 'max:1', 'min:1'],
            'gender'            => ['required', 'string', 'max:1', 'min:1' ],
            'looking_for'       => ['required', 'string', 'max:255'],
            'location_country'  => ['required', 'string', 'max:255'],
            'day'               => ['required'],
            'month'             => ['required'],
            'year'              => ['required'],
            'religious_id'      => ['required', 'numeric'],
            'religious_cast_id' => ['nullable', 'numeric'],
            'lifestyle_id'      => ['nullable', 'numeric'],
            'nid'               => ['nullable', 'numeric'],
            'passport'          => ['nullable', 'string', 'max:20'],

            'education_level_id' => ['required', 'numeric'],
            'edu_institute_name' => ['nullable', 'string', 'max:255'],
            'career_working_name'=> ['nullable', 'string', 'max:255'],
            'career_working_profession_id' => ['nullable', 'numeric'],
            'career_monthly_income_id' => ['nullable', 'numeric'],
            'organisation'       => ['nullable', 'string', 'max:255'],

            'feet'               => ['required', 'string', 'max:255'],
            'user_blood_group'   => ['nullable', 'string', 'max:255'],
            'user_body_weight'   => ['nullable', 'string', 'max:255'],
            'user_body_color'    => ['nullable', 'string', 'max:255'],
            'user_fitness_disabilities' => ['required', 'string', 'max:1', 'min:1'],
            'smoke'             => ['nullable', 'string', 'max:3', 'min:2'],
            'mother_tongue'     => ['required', 'string', 'max:255'],
            'no_of_brother'     => ['required', 'numeric', 'min:0', 'max:8'],
            'no_of_sister'      => ['required', 'numeric', 'min:0', 'max:8'],
            'father_occupation' => ['nullable', 'string', 'max:255'],
            'mother_occupation' => ['nullable', 'string', 'max:255'],
            'gardian_contact_no' => ['nullable', 'string', 'max:15'],

            'user_present_address'  => ['required', 'string', 'max:1000'],
            'user_present_city'     => ['required', 'string', 'max:255'],
            'user_present_country'  => ['required', 'string', 'max:255'],
            'user_permanent_address'=> ['nullable', 'string', 'max:1000'],
            'user_permanent_city'   => ['nullable', 'string', 'max:255'],
            'user_permanent_country'=> ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get Matches Profile
     * Default return Value All Profile
     * new_match => New Profile which are create on today 
     */
    protected function matcheProfile($user, $match_type = "all", $similar_profile = false, $paginate = 0){
        
        $data = User::where('user_status', 1);     
        if( !is_null($user->partner_religion) ){
            $data->Where('religious_id', $user->partner_religion)  ;              
        }        
        // Similar Profile
        if($similar_profile){
            $data->where('gender', $user->gender == 'M' ? 'M' : 'F');
        }else{
            $data->where('gender', $user->looking_for == 'bride' ? 'F' : 'M') ;
        }        
        // if( $match_type == "new_match" || $match_type == "new"){
        //     $data->where('created_at', '>', date('Y-m-d').' 00:00:00');
        // }elseif($match_type == "my_match" || $match_type == "old"){
        //     $data->where('created_at', '<', date('Y-m-d').' 00:00:00');
        // }else{
        //     //
        // }
        $data->whereNotIn('id', $this->connectedUserArr())->orderBy('id', 'DESC');
        if( $paginate > 0){
            $data = $data->paginate($paginate);                
        }else{
            $data = $data->limit(15)->get();
        }        
        return $data;        
    }

    /**
     * get Connected User Array
     */
    protected function connectedUserArr($user = Null){
        if( empty($user) ){
            $user = Auth::user();
        }
        $sentProposal_list = Proposal::where('proposal_sent_from', $user ->id)->select('proposal_sent_to')->get()->pluck('proposal_sent_to')->toArray();
        $rcv_proposal_list = Proposal::where('proposal_sent_to', $user ->id)->select('proposal_sent_from')->get()->pluck('proposal_sent_from')->toArray();
        $arr = array_merge($rcv_proposal_list, $sentProposal_list);
        return array_unique($arr);
    }

    /**
     * Calculate Min Max Date Range based min & max age
     */
    protected function getDOBRange($min_age, $max_age){
        if($min_age > $max_age){
            $val = $max_age;
            $max_age = $min_age;
            $min_age = $val;
        }
        $min_diff = Carbon::now()->subYears($min_age)->format('Y-m-d');
        $max_diff = Carbon::now()->subYears($max_age)->format('Y-m-d');
        return [$max_diff, $min_diff];
    }

    /**
     * Get Religious Cast By Name
     */
    protected function getReligiousCast($cast_name){
        return ReligiousCast::where('name', $cast_name)->first();
    }
    
    /**
     * Get Education
     */
    protected function getEducation($name){
        return EducationLevel::where('name', $name)->first();
    }

    /**
     * Get Profession
     */
    protected function getProfession($name){
        return CareerProfessional::where('name', 'like','%'.$name.'%')->first();
    }

    /**
     * Get Notifications
     */
    protected function getNotifications($user){
        return [];
    }

    /**
     * Convert to Array
     */
    public function convertToArray($string, $seperator = ","){
        if( !is_null($string) ){
            return explode($seperator, $string);
        }
        return Null;
    }

    /**
     * Get Block Profile
     * If Profile is blocked by user then 
     * @return true  Or
     * @return false
     */
    protected function isBlockProfile($user_id, $profile_id){
        $data = BlockProfile::where('user_id', $user_id)->where('block_user_id', $profile_id)->first();
        if( !is_null($data) ){
            return true;
        }
        return false;
    }

    /**
     * Add Profile Visitor info
     */
    protected function addProfileVisitorInfo($visit_profile_id){
        if(Auth::user()->id == $visit_profile_id){
            return false;
        }
        $data = new ProfileVisitor();
        $data->visit_profile_id = $visit_profile_id;
        $data->visitor_profile_id = Auth::user()->id;
        $data->save();
        return $data;
    }

    /**
     * add or Store Notification
     */
    protected function sentNotification($to_user, $from_user = Null, $message, $type_id, $type ='proposal'){
        $data = new Notification();
        $data->from_user = $from_user;
        $data->to_user  = $to_user;
        if($type == "proposal"){
            $data->proposal_id = $type_id;
        }else{
            $data->profile_visitor_id = $type_id;
        }
        $data->notification = $message;
        $data->save();
    }

    /**
     * Get Profile Visitors
     */
    protected function getProfileVisitor($profile){
        $visitors_arr =  ProfileVisitor::where('visit_profile_id', $profile->id)
            ->groupBy('visit_profile_id')
            ->where('visitor_profile_id','!=', Auth::user()->id)
            ->orderBy('id','DESC')->get()->pluck('visitor_profile_id');
        return User::whereIn('id',$visitors_arr)->get();
    }

    /**
     * Sent a Proposal to profile
     */
    protected function addSentProposal($proposal_to_id){
        $user = Auth::user();
        $data = $this->isProposalSent($proposal_to_id, $user->id);
        if( is_null($data) ){
            $data = new Proposal();
            $data->proposal_sent_to = $proposal_to_id;
            $data->proposal_sent_from = $user->id;
            $data->save();
            $message = $user->first_name." sent a request to connect with you.";
            $this->sentNotification($proposal_to_id, $user->id, $message, $data->id);
            return $data->id;
        }else{
            $this->message = "You already sent a Proposal";
            return false;
        }
        
    }

    protected function isProposalSent($proposal_to_id, $proposal_from_id){
        return Proposal::where('proposal_sent_to', $proposal_to_id)->where('proposal_sent_from', $proposal_from_id)->first();
    }

    /**
     * Add Or Update User Activity
     * 
     */
    protected function updateUserActivity($activity, $profile, $view_profile_id = 0){
        $data = UserActivity::where('user_id', $profile->id)
            ->where('subscribe_package_id', $profile->subscribe_package_id)
            ->where('view_profile_id', $view_profile_id)
            ->first();

        if( is_null($data) ){
            $data = new UserActivity();
        }       
        $data->user_id = $profile->id;
        $data->subscribe_package_id = $profile->subscribe_package_id;
        if( strtolower($activity) == 'proposal' || strtolower($activity) == 'sent_proposal' ){
            $data->sent_proposal = 1;
        }elseif(strtolower($activity) == "decline" || strtolower($activity) == 'decline_proposal'){
            $data->decline_proposal = 1;
        }elseif(strtolower($activity) == "view_profile" || strtolower($activity) == 'profile_view'){
            $data->view_profile_id  = $view_profile_id;
            $data->profile_view = 1;
        }else{
            //
        }        
        $data->save();
        return $data;
    }

    /**
     * Check User's are Connected or Nor
     */
    protected function isConnected($user_id, $profile_id){
        $data = Proposal::where('proposal_sent_from', $user_id)->where('proposal_sent_to', $profile_id)
            ->orWhere(function($qry)use($user_id, $profile_id){
                $qry->where('proposal_sent_from', $profile_id)->where('proposal_sent_to', $user_id);
            })->where('status', 'accept')->first();
        if( !is_null($data) ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get Contact Details
     */
    protected function getContactDetails($profile_id){
        $user = User::find($profile_id);
        if( is_null($user) ){
            return "No Data Found";
        }else{
            $contact_info = '
            <tr class="closed">
                <td class="day_label">Email :</td>
                <td class="day_value closed"><span>'. $user->email .'</span></td>
            </tr>
            <tr class="closed">
                <td class="day_label">Phone :</td>
                <td class="day_value closed"><span>'. $user->phone .'</span></td>
            </tr>
            <tr class="closed">
                <td class="day_label">Gardian No :</td>
                <td class="day_value closed"><span>'. $user->gardian_contact_no .'</span></td>
            </tr>
            <tr class="closed">
                <td class="day_label">Address :</td>
                <td class="day_value closed"><span>'. $user->user_present_address. '<br>' .$user->user_present_city.'<br>'.$user->user_present_country.'</span></td>
            </tr>';
            if( file_exists($user->user_bio_data_path) ){
                $contact_info .= '<tr class="closed">
                    <td class="day_label">Bio Data :</td>
                    <td class="day_value closed"><span> <a href="'.asset($user->user_bio_data_path).'" class="btn btn-link" target="_blank"> View Bio-Data</a> </span></td>
                </tr>';
            }
            return $contact_info;
        }
    }

    /**
     * Prepare Send Invitation Message
     */
    protected function getProposalInvitationMessage($sent_from, $sent_to, $proposal_id){
        $system = SystemInfo::first();
        $message = '
            <div style="border-bottom: 1px solid #ddd;">
                <div style="padding: 0px 0px 0px 15px;">
                    <div>
                        <img src="'.asset($system->logo).'" style="height: 80px;">
                    </div>
                    <h3 style="margin: 0px 0px 10px 0px; color: #0fcceb; font-size: 22px;">
                        Invitation To Connect 
                        <span style="font-size: 14px;background: #ddd; padding: 5px; float: right; margin-top: 10px;">'.date('d-M-Y').'</span>
                    </h3>
                </div>
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                <strong>Hi MMBD-'.$sent_to->id.'</strong>,
                <p>MMBD-'.$sent_from->id.' has Invited you to Connect! How would you like to respond?</p><br>
                <a href="'.url('notification/list').'" style="border: none; padding: 8px 15px;cursor: pointer; margin-right:10px;background: #0fcceb; color:#fff;">Accept</a>
                <a href="'.url('notification/list').'" style="border: none; padding: 8px 15px;cursor: pointer; margin-right:10px;background: red; color:#fff;">Reject</a><br><br>

                <div style="margin-top: 10px; border: 2px solid #ddd; padding: 15px;">
                    <h3 style="font-size: 20px; color: #0fcceb;">MMBD-'.$sent_from->id.'</h3>
                    <p style="font-size: 14px; color:#aaa;">'.
                        Carbon::parse($sent_from->date_of_birth)->diffInYears().'Yrs, '.$sent_from->user_height.', '.
                        ( !is_null($sent_from->religious) ? $sent_from->religious->name.', ' : Null ).
                        ( !is_null($sent_from->religionCast) ? $sent_from->religionCast->name.', ' : Null ).
                        ( !is_null($sent_from->careerProfession) ? $sent_from->careerProfession->name.', ' : 'Not working, ').
                        'from '.$sent_from->user_present_city.' '.$sent_from->user_present_country.
                    '</p>
                    <a href="'.url('profile/'.$sent_from->id.'/MMBD-'.$sent_from->id.'/view').'" style="border: none; padding: 8px 15px;cursor: pointer; margin-right:10px; background: transparent; color:#0fcceb;padding: 0px;">View Profile</a>
                </div>
               
            </div>';
        return $message;
    }

    /**
     * Prepare Send Invitation Message
     */
    protected function getViewContactMessage($sent_from, $sent_to){
        $system = SystemInfo::first();
        $message = '
            <div style="border-bottom: 1px solid #ddd;">
                <div style="padding: 0px 0px 0px 15px;">
                    <div>
                        <img src="'.asset($system->logo).'" style="height: 80px;">
                    </div>
                    <h3 style="margin: 0px 0px 10px 0px; color: #0fcceb; font-size: 22px;">
                        View Contacts
                        <span style="font-size: 14px;background: #ddd; padding: 5px; float: right; margin-top: 10px;">'.date('d-M-Y').'</span>
                    </h3>
                </div>
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                <strong>Hi MMBD-'.$sent_to->id.'</strong>,
                <p>A premium Member MMBD-'.$sent_from->id.' viewed your contact details.</p><br>
                <div style="margin-top: 10px; border: 2px solid #ddd; padding: 15px;">
                    <h3 style="font-size: 20px; color: #0fcceb;">MMBD-'.$sent_from->id.'</h3>
                    <p style="font-size: 14px; color:#aaa;">'.
                        Carbon::parse($sent_from->date_of_birth)->diffInYears().'Yrs, '.$sent_from->user_height.', '.
                        ( !is_null($sent_from->religious) ? $sent_from->religious->name.', ' : Null ).
                        ( !is_null($sent_from->religionCast) ? $sent_from->religionCast->name.', ' : Null ).
                        ( !is_null($sent_from->careerProfession) ? $sent_from->careerProfession->name.', ' : 'Not working, ').
                        'from '.$sent_from->user_present_city.' '.$sent_from->user_present_country.
                    '</p>
                    <a href="'.url('profile/'.$sent_from->id.'/MMBD-'.$sent_from->id.'/view').'" style="border: none; padding: 8px 15px;cursor: pointer; margin-right:10px; background: transparent; color:#0fcceb;padding: 0px;">View Profile</a>
                </div>
               
            </div>';
        return $message;
    }

    /**
     * Prepare Send Invitation Message
     */
    protected function getProfileVisitMessage($sent_from, $sent_to){
        $system = SystemInfo::first();
        $message = '
            <div style="border-bottom: 1px solid #ddd;">
                <div style="padding: 0px 0px 0px 15px;">
                    <div>
                        <img src="'.asset($system->logo).'" style="height: 80px;">
                    </div>
                    <h3 style="margin: 0px 0px 10px 0px; color: #0fcceb; font-size: 22px;">
                        Profile Visit
                        <span style="font-size: 14px;background: #ddd; padding: 5px; float: right; margin-top: 10px;">'.date('d-M-Y').'</span>
                    </h3>
                </div>
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                <strong>Hi MMBD-'.$sent_to->id.'</strong>,
                <p>MMBD'.$sent_from->id.' Visit your Profile</p><br>

                <div style="margin-top: 10px; border: 2px solid #ddd; padding: 15px;">
                    <h3 style="font-size: 20px; color: #0fcceb;">MMBD-'.$sent_from->id.'</h3>
                    <p style="font-size: 14px; color:#aaa;">'.
                        Carbon::parse($sent_from->date_of_birth)->diffInYears().'Yrs, '.$sent_from->user_height.', '.
                        ( !is_null($sent_from->religious) ? $sent_from->religious->name.', ' : Null ).
                        ( !is_null($sent_from->religionCast) ? $sent_from->religionCast->name.', ' : Null ).
                        ( !is_null($sent_from->careerProfession) ? $sent_from->careerProfession->name.', ' : 'Not working, ').
                        'from '.$sent_from->user_present_city.' '.$sent_from->user_present_country.
                    '</p>
                    <a href="'.url('profile/'.$sent_from->id.'/MMBD-'.$sent_from->id.'/view').'" style="border: none; padding: 8px 15px;cursor: pointer; margin-right:10px; background: transparent; color:#0fcceb;padding: 0px;">View Profile</a>
                </div>	
            </div>';
        return $message;
    }

    /**
     * Get Registration Successfully Message
     */
    protected function getRegisterSuccessfullyMessage($password = Null, $email = Null){
        $system = SystemInfo::first();
        $message = '
            <div>                
                <div>
                    <img src="'.asset($system->logo).'" style="height: 80px;">
                </div>
                <h3 style="margin: 0px 0px 10px 0px; color: #fff; font-size: 22px; background: #dd2476; padding: 5px 0px 5px 15px;">
                    Great! Your registration has been completed
                    <span style="font-size: 14px; margin-top: -4px; padding: 10px; float: right;">'.date('d-M-Y').'</span>
                </h3>                
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                Your registration has been completed successfully.<br><br>';
                if( !empty($password) ){
                    $message .= "Your login User nane is :".$email."<br> And your login password is : ".$password;
                }                
                $message .= '<img src="'.asset('image.png').'"><br><br>
                All the best for your Partner Search!<br>                
            </div>
        ';
        return $message;
    }


    /**
     * Calculate Profile Complete Percent
     */
    protected function getProfileCompleteCount($user){
        $complete = 30;
        if( !empty($user->profilePic) && file_exists($user->profilePic->image_path) ){
            $complete += 20;
        }
        if( !empty($user->education_level_id) && !empty($user->edu_institute_name)  && !empty($user->career_working_profession_id) && !empty($user->major_subject) ){
            $complete += 10;
        }
        if( !empty($user->father_name) && !empty($user->mother_name) && !empty($user->father_occupation) ){
            $complete += 20;
        }
        if( !empty($user->user_present_address) && !empty($user->user_present_city) && !empty($user->user_present_country) ){
            $complete += 10;
        }
        if( !empty($user->partner_min_height) && !empty($user->partner_marital_status) && !empty($user->partner_country) ){
            $complete += 10;
        }
        return $complete;
    }

    /**
     * Calculate User Geight
     */
    public function calculateHeight($request, $feet = "feet", $inch = "inch"){
        if( !empty($request->$feet) ){
            return $request->$feet . '.'. $request->$inch;
        }
        return null;
    }

    /**
     * Upload Profile Pic Or Change Profile Pic
     */
    protected function uploadProPic($request, $user){
        if($request->hasFile('image_path')){
            $userImage = UserImage::where('user_id', $user->id)->where('profile_pic', true)->first();
            if( empty($userImage) ){
                $userImage = new UserImage();
                $userImage->user_id = $user->id;
            }
            $userImage->image_path = $this->UploadImage($request, 'image_path', $this->client_images_dir, Null, 420, $userImage->image_path);
            $userImage->profile_pic = true;
            $userImage->save();
        }
    }


    /**
     * Generate Action Column 
     * for User
     */
    protected function getUserActionOptions($row, $type = 'list'){
        $text ='<div class="btn-group">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                </button>
                <div class="dropdown-menu">
                    <a href="'.route('user.profile',['id' => $row->id]).'" class="dropdown-item ajax-click-page " title="View Details" > <span class="fa fa-eye"></span> View Profile </a> 
                    <a href="'.route('user.status_update',['id' => $row->id]).'" class="dropdown-item ajax-click-page " title="Change status"> Change status</a> 
                    <a href="'.route('user.password_update',['id' => $row->id]).'" class="ajax-click-page dropdown-item" title="Change Password" > Change Password </a>
                    <a href="'.route('user.image_update',['id' => $row->id]).'" class="ajax-click-page dropdown-item" title="Show Images" ><span class="fa fa-eye"></span> View Images & Documents</a>';
                if( !empty($row->user_bio_data_path) ){                    
                    $text .= '<a href="'.route('user.bio',['id' => $row->id]).'" class="dropdown-item" title="Download Bio-data" > <span class="fa fa-download"></span> Download</a> ';
                }
                $text .= '<a href="'.route('user.edit',['id' => $row->id]).'" class="ajax-click-page dropdown-item" title="Edit" > <span class="fa fa-edit"></span> Edit</a> ';
                if($type == 'list'){
                    $text .= '<a href="'.route('user.archive',['id' => $row->id]).'" class="ajax-click dropdown-item" > <span class="fa fa-trash" title="Delete" ></span> Delete</a> ';
                }else{
                    $text .= '<a href="'.route('user.restore',['id' => $row->id]).'" class="ajax-click dropdown-item" title="Restore User" > <i class="fas fa-redo"></i> Restore </a> ';
                }                
                $text .= '</div>
                </div>';
                return $text; 
    }

}