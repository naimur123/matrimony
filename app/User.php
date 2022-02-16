<?php

namespace App;

use App\Http\Components\Helper;
use App\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, Helper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creating_account', 'phone', 'marital_status', 'looking_for', 'gender', 'first_name', 'last_name', 'email', 'password', 'date_of_birth', 'location_country', 'gardian_contact_no','education_level_id','organisation','career_working_profession_id','religious_id','religious_cast_id','partner_min_age','partner_max_age','signup_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime','partner_profession' => 'array',
        'partner_education' => 'array', 'partner_country' => 'array',
        'partner_city' => 'array', 'partner_mother_tongue' => 'array',
        'partner_religion_cast' => 'array', 'partner_religion' => 'array',
        'partner_marital_status' => 'array','partner_blood_group' => 'array',
        'partner_eye_color' => 'array', 'partner_complexion' => 'array',
        'partner_dite' => 'array', 

    ];

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the Password Reset Email 
     * Through Implement The Interface
     * mathod sendPasswordResetNotification();
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function userImages(){
        return $this->hasMany(UserImage::class, 'user_id');
    }

    public function profilePic(){
        return $this->hasOne(UserImage::class, 'user_id')->where('profile_pic', true);
    }

    public function createdBy(){
        return $this->belongsTo(Admin::class, 'created_by')->withTrashed();
    }

    public function modifiedBy(){
        return $this->belongsTo(Admin::class, 'modified_by')->withTrashed();
    }
    public function religionCast(){
        return $this->belongsTo(ReligiousCast::class, 'religious_cast_id');
    }
    public function religious(){
        return $this->belongsTo(Religious::class, 'religious_id');
    }
    public function monthlyIncome(){
        return $this->belongsTo(MonthlyIncome::class, 'career_monthly_income_id');
    }
    public function careerProfession(){
        return $this->belongsTo(CareerProfessional::class, 'career_working_profession_id');
    }
    public function educationLevel(){
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }
    public function lifeStyle(){
        return $this->belongsTo(LifeStyle::class, 'lifestyle_id');
    }

    public function subscribePackage(){
        return $this->hasOne(SubscribePackage::class, 'user_id')
            ->where('activation_date', '<=', date('Y-m-d'))
            ->where('expire_date', '>=', date('Y-m-d'))
            ->where('payment_status', 'paid')
            ->orderBy('id', 'desc');
    }

    public function proposalReceived(){
        return $this->hasMany(Proposal::class, 'proposal_sent_to')->orderBy('id', 'DESC')->limit(10);
    }

    public function sentProposal(){
        return $this->hasMany(Proposal::class, 'proposal_sent_from')->orderBy('id', 'DESC')->limit(10);
    } 

    public function myNotification(){
        return $this->hasMany(Notification::class, 'to_user')->orderBy('id', 'DESC')->limit(10);
    }

    public function newNotification(){
        return $this->hasMany(Notification::class, 'to_user')->where('seen_at', null)->orderBy('id', 'DESC')->limit(10);
    }

    public function myActivity($package_id = Null, $dateTime = Null){
        $data = $this->hasmany(UserActivity::class, 'user_id');
        if( !is_null($package_id) ){
            $data->where('subscribe_package_id', $package_id);
        }
        if( !is_null($dateTime) ){
            $data->where('created', '>=',$dateTime);
        }
        return $data->get();
    }

    public function isSentProposal($to_id){
        $proposal = Proposal::where('proposal_sent_to', $to_id)
            ->where('proposal_sent_from', Auth::user()->id )->first();
        if( empty($proposal) ){
            return false;
        }
        return true;
    }

    public function getIPDetails($ip){
        return $this->getDataFromIP($ip);
    }

    public function isConnected($to_id){
        $proposal = Proposal::where('status','accept')
            ->where(function($qry) use($to_id){
                $qry->where('proposal_sent_to', $to_id)->orWhere('proposal_sent_to', Auth::user()->id)
                ->orWhere('proposal_sent_from', Auth::user()->id )->orWhere('proposal_sent_from', $to_id );
            })
            ->first();
        if( empty($proposal) ){
            return false;
        }
        return true;
    }

}
