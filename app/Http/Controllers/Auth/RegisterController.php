<?php

namespace App\Http\Controllers\Auth;

use App\Http\Components\Profile;
use App\Http\Controllers\Controller;
use App\Jobs\AccountNotification;
use App\Providers\RouteServiceProvider;
use App\SystemInfo;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, Profile;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request)
    { 
        if( $request->ajax() ){
            return view('frontEnd.account.register');
        }
        return redirect('/');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'creating_account' => ['required','string'],
            'marital_status' => ['required','string'],
            'looking_for' => ['required','string'],
            'gender' => ['required','string'],
            'year' => ['required','numeric'],
            'month' => ['required','numeric'],
            'day' => ['required','numeric'],
            'location_country' => ['required','string'],
            'religious_id' => ['required','numeric'],
            'religious_cast_id' => ['nullable','numeric'],
            'phone' => ['required','string','min:10', 'max:15'],
        ]);
    }

    public function register(Request $request)
    {
        $validate = $this->validator($request->all());
        if($validate->fails()){
            $this->message = $this->getValidationError($validate);
            return $this->output();
        }
        $user = $this->create($request);
        try{            
            event(new Registered($user));             
        }catch(Exception $e){
            //
        }
        
        $this->guard()->login($user);
        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new Response('', 201)
                    : redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create($request)
    {
        $dob = Carbon::parse($request->year.'-'.$request->month.'-'.$request->day)->format('Y-m-d');
        return User::create([
            'creating_account' => $request->creating_account,
            'phone' => $request->phone,
            'marital_status' => $request->marital_status,
            'looking_for' => $request->looking_for,
            'gender' => $request->gender,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,            
            'password' => Hash::make($request->password),
            'date_of_birth' => $dob,
            'location_country' => $request->location_country,
            'gardian_contact_no' => $request->gardian_contact_no,
            'education_level_id' => $request->education_level_id,
            'organisation' => $request->organisation,
            'career_working_profession_id' => $request->career_working_profession_id,
            'religious_id' => $request->religious_id,
            'religious_cast_id' => $request->religious_cast_id,
            'signup_ip' => $request->ip(),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $this->success();
        $this->url = url($this->redirectPath());        
        $this->table = false;
        return $this->output();
    }

    /**
     * Check Unique Email
     */
    public function checkUniqueEmail(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
        if( $validator->fails() ){
            $this->message = $this->getValidationError($validator);
        }else{
            $this->apiSuccess('Validate Successfully');
        }
        return $this->apiOutput();
    }

}
