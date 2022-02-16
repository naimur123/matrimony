@extends('frontEnd.masterPage')
@section('style')
<style>
    .panel-heading{padding: 5px 15px 0px 15px;}
    .input-range{width: 46%; float: left; margin-right: 2%;}
</style>
@stop
@section('mainPart')
    <div class="grid_3">
        <div class="container-fluid" style="width:95%;">
            <div class="col-md-10 row">
                <div class="col-sm-4 col-md-3">

                    <!-- Profile Picture -->
                    <div class="row col-sm-12">
                        <h4 class="font-weight-bold">Profile Picture</h4> 
                        <p><b>Profile Complete :</b> {{ $profile_complete }}%</p>
                        <hr/>
                        <img src="{{ asset( isset($user->profilePic->image_path) && file_exists($user->profilePic->image_path) ? $user->profilePic->image_path : 'dummy-user.png' )}}" class="img-responsive img-thumbnail">
                        <br><br>
                        {!! Form::open(['url' => 'profile/update/profile-pic', 'method' => 'post' ,'files' => true, 'class' => 'form-horizontal' ]) !!}
                            <input type="file" name="image_path" required ><br>
                            <button type="submit" class="btn btn-info form-control">Change Picture</button>
                        {!! Form::close() !!}
                    </div>

                    <!-- Change Password -->
                    <div class="row col-sm-12" style="margin-top: 30px;">
                        <h4 class="font-weight-bold">Change Password</h4> <hr/>
                        {!! Form::open(['url' => 'profile/update/password', 'class' => 'ajax-form', 'method' => 'post']) !!}
                            <div class="form-group">
                                <label >Password <span class="text-danger" >*</span></label>
                                <input type="password" name="password" size="60" maxlength="128" class="form-text" required placeholder="Your Password" autocomplete="off" >
                                @error('password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Confirm Password <span class="text-danger" >*</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Retype your Password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info form-control">Update Password</button>
                            </div>
                        {!! Form::close() !!}
                    </div>

                    <!-- Upload Picture -->
                    
                    <div class="row col-sm-12">
                        <h4 class="font-weight-bold">Upload Photos</h4> <hr/>
                        @foreach($user->userImages as $image)
                            @if( file_exists($image->image_path))
                            <img src="{{ asset($image->image_path) }}" class="img-responsive img-thumbnail">
                            <a href="{{ route('profilepic.delete',['id' => $image->id ]) }}" onclick="return confirm('Are you sure to delete it ???')" title="click to remove" class="btn btn-danger btn-xs" style="position: absolute; z-index:100;margin-left: -25px">X</a>
                            @endif                        
                        @endforeach
                        <br><br>                        
                        {!! Form::open(['url' => 'profile/upload/image', 'method' => 'post' ,'files' => true ]) !!}
                            <input type="file" name="image_path" required ><br>
                            <button type="submit" class="btn btn-info form-control">Upload Image</button>
                        {!! Form::close() !!}
                        
                    </div>
                </div>

                <!-- Update Profile Information -->
                <div class="col-sm-8 col-md-9">
                    {!! Form::open(['url' => 'profile/update','method' => 'post','class' => 'ajax-form', 'files' => true ]) !!}
                        <!-- Basic Information -->
                        <div class="panel panel-info">
                            <div class="panel-heading text-white" style="background-color:rgb(42, 196, 218);">
                                <h3>Basic Information</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">                            
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name}}" required >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name}}" placeholder="Last Name" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="text" readonly class="form-control" value="{{ $user->email}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control" value="{{ $user->phone}}" required >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Gender <span class="text-danger">*</span></label><br>
                                            <label>
                                                <input type="radio" name="gender" value="M" {{ $user->gender == "M" ? 'checked' : Null }} > <i class="fa fa-male fa-2x color-male"></i> 
                                            </label> &nbsp; 
                                            <label>
                                                <input type="radio" name="gender" value="F" {{ $user->gender == "F" ? 'checked' : Null }} > <i class="fa fa-female fa-2x color-female"></i> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Looking For <span class="text-danger">*</span></label><br>
                                            <label>
                                                <input type="radio" name="looking_for" value="groom" {{ $user->looking_for == 'groom' ? 'checked' : Null }} > <i class="fa fa-male fa-2x color-male"></i> 
                                            </label> &nbsp; 
                                            <label>
                                                <input type="radio" name="looking_for" value="bride" {{ $user->looking_for == 'bride' ? 'checked' : Null }} > <i class="fa fa-female fa-2x color-female"></i> 
                                            </label>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Marital status <span class="text-danger">*</span></label><br>
                                            <select name="marital_status" required class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="M" {{ $user->marital_status == 'M' ? 'Selected' : Null }} > {{ ucfirst('Married') }} </option>                                
                                                <option value="U" {{ $user->marital_status == 'U' ? 'Selected' : Null }} > {{ ucfirst('Unmarried') }} </option>                                
                                                <option value="D" {{ $user->marital_status == 'D' ? 'Selected' : Null }} > {{ ucfirst('Divorce') }} </option>                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Religion <span class="text-danger">*</span></label>
                                            <select name="religious_id" class="form-control religion-select" required >
                                                <option value="">Select Religion</option>
                                                @foreach($religious as $religion)
                                                <option value="{{$religion->id}}" {{ $user->religious_id == $religion->id ? 'selected' : Null }}>{{$religion->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
            
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Religion Cast</label>
                                            <select name="religious_cast_id" class="form-control religion-cast" >
                                                <option value="">Select Religious Cast</option>   
                                                @if(isset($user->religionCast))
                                                <option value="{{ $user->religionCast->id }}" selected >{{ $user->religionCast->name }}</option> 
                                                @endif                             
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Country <span class="text-danger">*</span></label>
                                            <select name="location_country" class="form-control select2" required placeholder="select your Country">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->country}}" {{ $country->country == $user->location_country ? 'selected' : Null }}>{{$country->country}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
        
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Date Of Birth <span class="text-danger">*</span></label><br>

                                            <select name="day" required class="input-group-addon form-control" style="width: 30%; margin-right:2%;">
                                                <option value="">Day</option>
                                                @for($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}" {{ Carbon\Carbon::parse($user->date_of_birth)->format('d') == $i ? 'selected' : Null }} >{{$i}}</option>
                                                @endfor
                                            </select>
                                            <select name="month" required class="input-group-addon form-control" style="width: 30%; margin-right:2%">
                                                <option value="">Month</option>
                                                @for($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ Carbon\Carbon::parse($user->date_of_birth)->format('m') == $i ? 'selected' : Null }} >{{ Carbon\Carbon::parse('2020-'.$i.'-01')->format('F') }}</option>
                                                @endfor
                                            </select>
                                            <select name="year" class="input-group-addon form-control" style="width: 30%">
                                                <option value="">Year</option>
                                                @for($i = Carbon\Carbon::now()->subYears(18)->format('Y'); $i >= 1950; $i--)
                                                    <option value="{{ $i }}" {{ Carbon\Carbon::parse($user->date_of_birth)->format('Y') == $i ? 'selected' : Null }} >{{ $i }}</option>
                                                @endfor
                                            </select>
                                        
                                            {{-- <input type="date" name="date_of_birth" class="input-group-addon form-control" value="{{ $user->date_of_birth }}" max="{{ Carbon\Carbon::now()->subYears(15)->format('Y-m-d')}}" required > --}}
                                        </div>
                                    </div>                                    
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>About Myself <span class="text-danger">*</span></label>                                     
                                            <textarea name="user_bio_myself" class="form-control" required >{{ $user->user_bio_myself }}</textarea>                                  
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>

                        <!-- Education & Career-->
                        <div class="panel panel-info">
                            <div class="panel-heading text-white" style="background-color:rgb(42, 196, 218);">
                                <h3>Education & Career</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">                            
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Education Lavel <span class="text-danger">*</span></label>                          
                                            <select name="education_level_id" class="form-control" required>
                                                <option value="">Select Education</option>
                                                @foreach($educations as $education)
                                                <option value="{{ $education->id }}" {{ $education->id == $user->education_level_id ? 'selected' : Null }} >{{ ucfirst($education->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Institute Name</label>                          
                                            <input type="text" placeholder="Institute Name" name="edu_institute_name" value="{{ $user->edu_institute_name }}" class="form-control"  >                        
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Major subject</label>                          
                                            <input type="text" placeholder="major subject" name="major_subject" value="{{ $user->major_subject }}" class="form-control"  >                        
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Working Profession </label>                              
                                            <select name="career_working_profession_id" class="form-control"  >
                                                <option value="">Select Profession</option>
                                                @foreach($professions as $profession)
                                                <option value="{{ $profession->id }}" {{ $profession->id == $user->career_working_profession_id ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- career_working_name -->   
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Designation / Post </label>                              
                                            <input type="text" placeholder="Designation / Post" name="career_working_name" value="{{ $user->career_working_name }}" class="form-control" >                        
                                        </div>
                                    </div>
                                    <!-- career_working_name -->   
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Organisation Name</label>                              
                                            <input type="text" placeholder="Organisation Name" name="organisation" value="{{ $user->organisation }}" class="form-control" >                        
                                        </div>
                                    </div>
        
                                    <!-- Yearly Income -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Yearly Income </label>                              
                                            <select name="career_monthly_income_id" class="form-control"  >
                                                <option value="">Select Income Range</option>
                                                @foreach($incomes as $income)
                                                <option value="{{ $income->id }}" {{ $income->id == $user->career_monthly_income_id ? 'selected' : Null }} >{{ ucfirst($income->range) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Personal Information -->
                        <div class="panel panel-info">
                            <div class="panel-heading text-white" style="background-color:rgb(42, 196, 218);">
                                <h3>Personal Information</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row"> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>NID </label>
                                            <input type="text" name="nid" class="form-control" value="{{ $user->nid }}" placeholder="NID Number">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Passport </label>
                                            <input type="text" name="passport" class="form-control" value="{{ $user->passport }}" placeholder="Passport Number" >
                                        </div>
                                    </div>
                                    
                                    <!-- mother_tongue -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Mother tongue <span class="text-danger">*</span> </label>
                                            <select name="mother_tongue" class="form-control select2" required >
                                                <option value="">Select Mother tongue</option>
                                                <option value="Arabic" {{ $user->mother_tongue == 'Arabic' ? 'selected' : Null }} >Arabic</option>
                                                <option value="Bengali" {{ $user->mother_tongue =='Bengali' ? 'selected' : Null }} >Bengali</option>
                                                <option value="Chinise" {{ $user->mother_tongue =='Chinise' ? 'selected' : Null }} >Chinise</option>
                                                <option value="English" {{ $user->mother_tongue =='English' ? 'selected' : Null }}>English</option>
                                                <option value="French" {{ $user->mother_tongue =='French' ? 'selected' : Null }}>French</option>
                                                <option value="German" {{ $user->mother_tongue =='German' ? 'selected' : Null }}>German</option>
                                                <option value="Hindi" {{ $user->mother_tongue =='Hindi' ? 'selected' : Null }}>Hindi</option>
                                                <option value="Indonesion" {{ $user->mother_tongue =='Indonesion' ? 'selected' : Null }}>Indonesion</option>
                                                <option value="Italian" {{ $user->mother_tongue =='Italian' ? 'selected' : Null }}>Italian</option>
                                                <option value="Japanese" {{ $user->mother_tongue =='Japanese' ? 'selected' : Null }}>Japanese</option>
                                                <option value="Korean" {{ $user->mother_tongue =='Korean' ? 'selected' : Null }}>Korean</option>
                                                <option value="Nepali" {{ $user->mother_tongue =='Nepali' ? 'selected' : Null }}>Nepali</option>
                                                <option value="Punjabi" {{ $user->mother_tongue =='Punjabi' ? 'selected' : Null }}>Punjabi</option>
                                                <option value="Russian" {{ $user->mother_tongue =='Russian' ? 'selected' : Null }}>Russian</option>
                                                <option value="Spanish" {{ $user->mother_tongue =='Spanish' ? 'selected' : Null }}>Spanish</option>
                                                <option value="Swedish" {{ $user->mother_tongue =='Swedish' ? 'selected' : Null }}>Swedish</option>
                                                <option value="Tamil" {{ $user->mother_tongue =='Tamil' ? 'selected' : Null }}>Tamil</option>
                                                <option value="Telugu" {{ $user->mother_tongue =='Telugu' ? 'selected' : Null }}>Telugu</option>
                                                <option value="Turkish" {{ $user->mother_tongue =='Turkish' ? 'selected' : Null }}>Turkish</option>
                                                <option value="Urdu" {{ $user->mother_tongue =='Urdu' ? 'selected' : Null }}>Urdu</option>
                                            </select>
                                        </div>
                                    </div> 
                                    

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            @php
                                                $height_arr = explode('.', $user->user_height);
                                            @endphp
                                            <label>Height <span class="text-danger">*</span></label>
                                            <div class="row" style="margin: 0px;">
                                                <select class="form-control" style="width:47%;float:left" required name="feet" >
                                                    <option value="3" {{ $height_arr[0] == 3 ? 'selected' : Null }} >3 Feet</option>
                                                    <option value="4" {{ $height_arr[0] == 4 ? 'selected' : Null }} >4 Feet</option>
                                                    <option value="5" {{ $height_arr[0] == 5 ? 'selected' : Null }}>5 Feet</option>
                                                    <option value="6" {{ $height_arr[0] == 6 ? 'selected' : Null }}>6 Feet</option>
                                                    <option value="7" {{ $height_arr[0] == 7 ? 'selected' : Null }}>7 Feet</option>
                                                    <option value="8" {{ $height_arr[0] == 8 ? 'selected' : Null }}>8 Feet</option>
                                                </select>
                                                <select class="form-control" style="width:47%;float:left;margin-left:2%;" required name="inch" >
                                                    <option value="0" {{ isset($height_arr[1]) && $height_arr[1] == 0 ? 'selected' : Null }} >0 Inch </option>
                                                    <option value="1" {{ isset($height_arr[1]) &&  $height_arr[1] == 1 ? 'selected' : Null }} >1 Inch </option>
                                                    <option value="2" {{ isset($height_arr[1]) &&  $height_arr[1] == 2 ? 'selected' : Null }}>2 Inch </option>
                                                    <option value="3" {{ isset($height_arr[1]) &&  $height_arr[1] == 3 ? 'selected' : Null }}>3 Inch </option>
                                                    <option value="4" {{ isset($height_arr[1]) &&  $height_arr[1] == 4 ? 'selected' : Null }}>4 Inch </option>
                                                    <option value="5" {{ isset($height_arr[1]) &&  $height_arr[1] == 5 ? 'selected' : Null }}>5 Inch </option>
                                                    <option value="6" {{ isset($height_arr[1]) &&  $height_arr[1] == 6 ? 'selected' : Null }}>6 Inch </option>
                                                    <option value="7" {{ isset($height_arr[1]) &&  $height_arr[1] == 7 ? 'selected' : Null }}>7 Inch </option>
                                                    <option value="8" {{ isset($height_arr[1]) &&  $height_arr[1] == 8 ? 'selected' : Null }}>8 Inch </option>
                                                    <option value="9" {{ isset($height_arr[1]) &&  $height_arr[1] == 9 ? 'selected' : Null }}>9 Inch </option>
                                                    <option value="10" {{ isset($height_arr[1]) &&  $height_arr[1] == 10 ? 'selected' : Null }}>10 Inch </option>
                                                    <option value="11" {{ isset($height_arr[1]) &&  $height_arr[1] == 11 ? 'selected' : Null }}>11 Inch </option>
                                                    <option value="12" {{ isset($height_arr[1]) &&  $height_arr[1] == 12 ? 'selected' : Null }}>12 Inch </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- user_body_weight -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Body Type <span class="text-danger">*</span></label>   
                                            <select name="user_body_weight" class="form-control" required >
                                                <option value="" >Select Body Type</option>
                                                <option value="skinny" {{ $user->user_body_weight == 'skinny' ? 'selected' : Null }}>Skinny</option>
                                                <option value="healthy" {{ $user->user_body_weight == 'healthy' ? 'selected' : Null }}>Healthy</option>
                                                <option value="moderate" {{ $user->user_body_weight == 'moderate' ? 'selected' : Null }}>Moderate</option>
                                                <option value="fatty" {{ $user->user_body_weight == 'fatty' ? 'selected' : Null }}>Fatty</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- user_body_color -->                    
                                    <div class="col-sm-4 hidden">
                                        <div class="form-group">
                                            <label>Body color</label>                          
                                            <input type="text" placeholder="Body color" name="user_body_color" value="{{ $user->user_body_color }}" class="form-control"  >                        
                                        </div>
                                    </div>

                                    
                                    <!-- Blood Group -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Blood Group</label> 
                                            <select name="user_blood_group" class="form-control select2" >
                                                <option value="A+" {{ $user->user_blood_group == "A+" ? 'selected' : Null }} >A+</option>
                                                <option value="A-" {{ $user->user_blood_group == "A-" ? 'selected' : Null }} >A-</option>
                                                <option value="B+" {{ $user->user_blood_group == "B+" ? 'selected' : Null }} >B+</option>
                                                <option value="B-" {{ $user->user_blood_group == "B-" ? 'selected' : Null }} >B-</option>
                                                <option value="AB+" {{ $user->user_blood_group == "AB+" ? 'selected' : Null }} >AB+</option>
                                                <option value="AB-" {{ $user->user_blood_group == "AB-" ? 'selected' : Null }} >AB-</option>
                                                <option value="O+" {{ $user->user_blood_group == "O+" ? 'selected' : Null }} >O+</option>
                                                <option value="O-" {{ $user->user_blood_group == "O-" ? 'selected' : Null }} >O-</option>
                                            </select>                         
                                        </div>
                                    </div>
                                    
                                    
                                    <!-- user_fitness_disabilities -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Fitness Disabilities <span class="text-danger">*</span> </label>                          
                                            <select name="user_fitness_disabilities" class="form-control" required>
                                                <option value="N" {{ $user->user_fitness_disabilities == "N" ? 'selected': Null }} >No</option>
                                                <option value="Y" {{ $user->user_fitness_disabilities == "Y" ? 'selected': Null }} >Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Life Style</label>
                                            <select name="lifestyle_id" class="form-control" >
                                                <option value="">Select life Style</option>   
                                                @foreach($lifeStyles as $style)
                                                    <option value="{{ $style->id }}" {{ $user->lifestyle_id == $style->id ? 'selected' : Null }} >{{ $style->name }}</option> 
                                                @endforeach                            
                                            </select>                                    
                                        </div>
                                    </div>

                                    <!-- Eye Color -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Eye color </label>                          
                                            <select name="eye_color" class="form-control">
                                                <option value="Amber" {{ $user->eye_color == 'Amber' ? 'selected' : Null }} >Amber</option>
                                                <option value="Black" {{ $user->eye_color == 'Black' ? 'selected' : Null }} >Black</option>
                                                <option value="Blue" {{ $user->eye_color == 'Blue' ? 'selected' : Null }} >Blue</option>
                                                <option value="Brown" {{ $user->eye_color == 'Brown' ? 'selected' : Null }} >Brown</option>
                                                <option value="Gray" {{ $user->eye_color == 'Gray' ? 'selected' : Null }} >Gray</option>
                                                <option value="Green" {{ $user->eye_color == 'Green' ? 'selected' : Null }} >Green</option>
                                                <option value="Red" {{ $user->eye_color == 'Red' ? 'selected' : Null }} >Red</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- hair color -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Hair color </label>                          
                                            <select class="form-control" name="hair_color">
                                                <option value="" >Select Hair color</option>
                                                <option value="Black" {{ $user->hair_color == "Black" ? 'selected' : Null }} >Black</option>
                                                <option value="Brown" {{ $user->hair_color == "Brown" ? 'selected' : Null }} >Brown</option>
                                                <option value="Blonde" {{ $user->hair_color == "Blonde" ? 'selected' : Null }} >Blonde</option>
                                                <option value="Auburn" {{ $user->hair_color == "Auburn" ? 'selected' : Null }} >Auburn</option>
                                                <option value="Red" {{ $user->hair_color == "Red" ? 'selected' : Null }} >Red</option>
                                                <option value="Gray & white" {{ $user->hair_color == "Gray & white" ? 'selected' : Null }} >Gray & white</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- complexion -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Complexion </label>                          
                                            <select name="complexion" class="form-control" >
                                                <option value="">Select Complexion</option>
                                                <option value="Light skin" {{ $user->complexion == 'Light skin' ? 'selected' : Null }} >Light skin</option>
                                                <option value="Fair skin" {{ $user->complexion == 'Fair skin' ? 'selected' : Null }} >Fair skin</option>
                                                <option value="Medium skin" {{ $user->complexion == 'Medium skin' ? 'selected' : Null }} >Medium skin</option>
                                                <option value="Olive skin" {{ $user->complexion == 'Olive skin' ? 'selected' : Null }} >Olive skin</option>
                                                <option value="Dark skin" {{ $user->complexion == 'Dark skin' ? 'selected' : Null }} >Dark skin</option>
                                                <option value="Tan brown skin" {{ $user->complexion == 'Tan brown skin' ? 'selected' : Null }} >Tan brown skin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- diet -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Diet </label>   
                                            <select name="diet" class="form-control" >
                                                <option value="">Select Diet</option>
                                                <option value="Vegetarian " {{ $user->diet == 'Vegetarian' ? 'selected' : Null }} >Vegetarian</option>
                                                <option value="Non vegetarian" {{ $user->diet == 'Non vegetarian' ? 'selected' : Null }} >Non vegetarian</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Smoke -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Smoke </label>                          
                                            <select name="smoke" class="form-control" >
                                                <option value="No" {{ $user->smoke == "No" ? 'selected': Null }} >No</option>
                                                <option value="Yes" {{ $user->smoke == "Yes" ? 'selected': Null }} >Yes</option>                                        
                                            </select>
                                        </div>
                                    </div>
                                     <!-- Drink -->                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Drink </label>                          
                                            <select name="drink" class="form-control" >
                                                <option value="No" {{ $user->smoke == "No" ? 'selected': Null }} >No</option>
                                                <option value="Yes" {{ $user->smoke == "Yes" ? 'selected': Null }} >Yes</option>                                        
                                            </select>
                                        </div>
                                    </div>

                                    @if($user->marital_status == 'M' || $user->marital_status == 'D')                  
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Have child </label>  
                                                <select name="no_children" class="form-control">
                                                    <option value="No" {{ $user->no_children == 'No' ? 'selected' : Null }}>No</option>
                                                    <option value="Yes" {{ $user->no_children == 'Yes' ? 'selected' : Null }}>Yes</option>
                                                </select> 
                                            </div>
                                        </div>
                                    @endif                                  
        
                                </div>
                            </div>
                        </div>

                         <!-- Family Information Information -->
                         <div class="panel panel-info">
                            <div class="panel-heading text-white" style="background-color:rgb(42, 196, 218);">
                                <h3>Family Information</h3>
                            </div>
                            <div class="panel-body">
                                <!-- Gardian Contact -->    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Gardian contact</label>                          
                                        <input type="text" placeholder="Gardian contact" name="gardian_contact_no" value="{{ $user->gardian_contact_no }}" class="form-control"  >                        
                                    </div>
                                </div>

                                <!-- Father Name -->                    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Father's Name </label>                          
                                        <input type="text" placeholder="Father's Name" name="father_name" value="{{ $user->father_name }}" class="form-control"  >                        
                                    </div>
                                </div>
                                <!-- Father Occupation -->                    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Father's occupation </label>  
                                        <select name="father_occupation" class="form-control select2">
                                            <option value="">Select Profession</option>
                                            @foreach($professions as $profession)
                                                <option value="{{ $profession->name }}" {{ $profession->name == $user->father_occupation ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                            @endforeach
                                        </select>  
                                    </div>
                                </div>

                                <!-- Mother Name -->    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Mother's Name </label>                          
                                        <input type="text" placeholder="Mother's name" name="mother_name" value="{{ $user->mother_name }}" class="form-control"  >                        
                                    </div>
                                </div>
                                <!-- Mother Occupation -->    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Mother's occupation </label>   
                                        <select name="mother_occupation" class="form-control select2">
                                            <option value="">Select Profession</option>
                                            @foreach($professions as $profession)
                                                <option value="{{ $profession->name }}" {{ $profession->name == $user->mother_occupation ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Number of Brother -->                    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Number Of Brother <span class="text-danger">*</span> </label>                          
                                        <select name="no_of_brother" class="form-control" >
                                            <option value="0" {{ $user->no_of_brother == "0" ? 'selected': Null }} >0</option>                                        
                                            <option value="1" {{ $user->no_of_brother == "1" ? 'selected': Null }} >1</option>                                        
                                            <option value="2" {{ $user->no_of_brother == "2" ? 'selected': Null }} >2</option>                                        
                                            <option value="3" {{ $user->no_of_brother == "3" ? 'selected': Null }} >3</option>                                        
                                            <option value="4" {{ $user->no_of_brother == "4" ? 'selected': Null }} >4</option>                                        
                                            <option value="5" {{ $user->no_of_brother == "5" ? 'selected': Null }} >5</option>                                        
                                            <option value="6" {{ $user->no_of_brother == "6" ? 'selected': Null }} >6</option>                                        
                                            <option value="7" {{ $user->no_of_brother == "7" ? 'selected': Null }} >7</option>                                        
                                            <option value="8" {{ $user->no_of_brother == "8" ? 'selected': Null }} >8</option>                                        
                                        </select>
                                    </div>
                                </div>

                                <!-- Number of Sister -->                    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Number Of Sister <span class="text-danger">*</span> </label>                          
                                        <select name="no_of_sister" class="form-control" >
                                            <option value="0" {{ $user->no_of_sister == "0" ? 'selected': Null }} >0</option>                                        
                                            <option value="1" {{ $user->no_of_sister == "1" ? 'selected': Null }} >1</option>                                        
                                            <option value="2" {{ $user->no_of_sister == "2" ? 'selected': Null }} >2</option>                                        
                                            <option value="3" {{ $user->no_of_sister == "3" ? 'selected': Null }} >3</option>                                        
                                            <option value="4" {{ $user->no_of_sister == "4" ? 'selected': Null }} >4</option>                                        
                                            <option value="5" {{ $user->no_of_sister == "5" ? 'selected': Null }} >5</option>                                        
                                            <option value="6" {{ $user->no_of_sister == "6" ? 'selected': Null }} >6</option>                                        
                                            <option value="7" {{ $user->no_of_sister == "7" ? 'selected': Null }} >7</option>                                        
                                            <option value="8" {{ $user->no_of_sister == "8" ? 'selected': Null }} >8</option>                                        
                                        </select>
                                    </div>
                                </div> 
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Family Value</label>                                     
                                        <select class="form-control" name="family_values">
                                            <option>Select Family Value</option>
                                            <option value="moderate" {{ $user->family_values == 'moderate' ? 'selected' : Null }}>Moderate</option>
                                            <option value="open minded" {{ $user->family_values == 'open minded' ? 'selected' : Null }} >Open minded</option>
                                            <option value="religious" {{ $user->family_values == 'religious' ? 'selected' : Null }} >Religious</option>
                                            <option value="not applicable" {{ $user->family_values == 'not applicable' ? 'selected' : Null }} >Not applicable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Family details</label>                                     
                                        <textarea name="family_details" class="form-control" >{{ $user->family_details }}</textarea>                                  
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Address -->
                        <div class="panel panel-info">
                            <div class="panel-heading text-white" style="background-color: rgb(42, 196, 218);">
                                <h3>Address</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">                            
                                    <!-- Present Address -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Present Address <span class="text-danger">*</span></label>                              
                                            <input type="text" placeholder="Your Present Address" name="user_present_address" value="{{ $user->user_present_address }}" class="form-control" required >                        
                                        </div>
                                    </div>
                                    <!-- Present City -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Present City <span class="text-danger">*</span></label>                              
                                            <input type="text" placeholder="Your Present City" name="user_present_city" value="{{ $user->user_present_city }}" class="form-control" required >                        
                                        </div>
                                    </div>

                                    <!-- Division -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Division </label>                              
                                            <select class="form-control division" name="division_id"  >
                                                <option value="">Select Division</option>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->id }}" {{ $division->id == $user->division_id ? 'selected' : Null }} >{{ $division->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- District -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>District </label>                              
                                            <select class="form-control district" name="district_id" >
                                                <option value="">Select District</option>                                                
                                            </select>
                                        </div>
                                    </div>

                                     <!-- Upazila -->
                                     <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Upazila </label>                              
                                            <select class="form-control upazila" name="upozila_id" >
                                                <option value="">Select Upazila</option>                                                
                                            </select>
                                        </div>
                                    </div>

                                    <!-- user_present_country -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Present Country <span class="text-danger">*</span> </label>                              
                                            <select name="user_present_country" class="form-control select2" >
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->country }}" {{ $country->country == $user->user_present_country ? 'selected' : Null }} >{{ ucfirst($country->country) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
        
                                    <!-- Permanent Address -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Permanent Address</label>                              
                                            <input type="text" placeholder="Your Permanent Address" name="user_permanent_address" value="{{ $user->user_permanent_address }}" class="form-control"  >                        
                                        </div>
                                    </div>
                                    <!-- Permanent City -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Permanent City</label>                              
                                            <input type="text" placeholder="Your Permanent City" name="user_permanent_city" value="{{ $user->user_permanent_city }}" class="form-control"  >                        
                                        </div>
                                    </div>
                                    <!-- user_permanent_country -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Permanent Country</label>                              
                                            <select name="user_permanent_country" class="form-control select2">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->country }}" {{ $country->country == $user->user_permanent_country ? 'selected' : Null }} >{{ ucfirst($country->country) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Partner  -->
                        <div class="panel panel-info">
                            <div class="panel-heading text-white" style="background-color: rgb(42, 196, 218);">
                                <h3>Partner Information</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row"> 

                                    <!-- Age -->                          
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Partner Min Age</label>
                                            <input type="number" class="form-control" name="partner_min_age" min="15" max="80" step="1" value="{{ is_null($user->partner_min_age) ? 18 : $user->partner_min_age }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">                                            
                                            <label>Partner Max Age</label>
                                            <input type="number" class="form-control" name="partner_max_age" min="15" max="80" step="1" value="{{ is_null( $user->partner_max_age) ? 24 : $user->partner_max_age }}">
                                        </div>                                   
                                    </div>

                                   <!-- Religion -->
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Partner Religion <span class="text-danger">*</span></label>
                                            <select name="partner_religion" class="partner-religion-select form-control" required >
                                                <option value="">Select Religion</option>
                                                @foreach($religious as $religion)
                                                    <option value="{{ $religion->id }}" {{ $user->partner_religion == $religion->id ? 'selected' : Null }} > {{ $religion->name }} </option>
                                                @endforeach
                                            </select>                                    
                                        </div>
                                    </div>

                                    <!-- Min Height -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            @php
                                                $min_height_arr = explode('.', $user->partner_min_height);
                                            @endphp
                                            <label>Partnet Min. Height <span class="text-danger">*</span></label><br>
                                            <select class="form-control col-xs-6" style="width:47%;float:left" required name="part_min_feet" >
                                                <option value="3" {{ $min_height_arr[0] == 3 ? 'selected' : Null }} >3 Feet</option>
                                                <option value="4" {{ $min_height_arr[0] == 4 ? 'selected' : Null }} >4 Feet</option>
                                                <option value="5" {{ $min_height_arr[0] == 5 ? 'selected' : Null }}>5 Feet</option>
                                                <option value="6" {{ $min_height_arr[0] == 6 ? 'selected' : Null }}>6 Feet</option>
                                                <option value="7" {{ $min_height_arr[0] == 7 ? 'selected' : Null }}>7 Feet</option>
                                                <option value="8" {{ $min_height_arr[0] == 8 ? 'selected' : Null }}>8 Feet</option>
                                            </select>
                                            <select class="form-control col-xs-6" style="width:47%;float:left;margin-left:2%;" required name="part_min_inch" >
                                                <option value="0" {{ isset($min_height_arr[1]) && $min_height_arr[1] == 0 ? 'selected' : Null }} >0 Inch </option>
                                                <option value="1" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 1 ? 'selected' : Null }} >1 Inch </option>
                                                <option value="2" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 2 ? 'selected' : Null }}>2 Inch </option>
                                                <option value="3" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 3 ? 'selected' : Null }}>3 Inch </option>
                                                <option value="4" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 4 ? 'selected' : Null }}>4 Inch </option>
                                                <option value="5" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 5 ? 'selected' : Null }}>5 Inch </option>
                                                <option value="6" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 6 ? 'selected' : Null }}>6 Inch </option>
                                                <option value="7" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 7 ? 'selected' : Null }}>7 Inch </option>
                                                <option value="8" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 8 ? 'selected' : Null }}>8 Inch </option>
                                                <option value="9" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 9 ? 'selected' : Null }}>9 Inch </option>
                                                <option value="10" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 10 ? 'selected' : Null }}>10 Inch </option>
                                                <option value="11" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 11 ? 'selected' : Null }}>11 Inch </option>
                                                <option value="12" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 12 ? 'selected' : Null }}>12 Inch </option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- max height -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            @php
                                                $max_height_arr = explode('.', $user->partner_max_height);
                                            @endphp
                                            <label>Partnet Max. Height <span class="text-danger">*</span></label><br>
                                            <select class="form-control" style="width:47%;float:left;clear:left;" required name="part_max_feet" >
                                                <option value="3" {{ $max_height_arr[0] == 3 ? 'selected' : Null }} >3 Feet</option>
                                                <option value="4" {{ $max_height_arr[0] == 4 ? 'selected' : Null }} >4 Feet</option>
                                                <option value="5" {{ $max_height_arr[0] == 5 ? 'selected' : Null }}>5 Feet</option>
                                                <option value="6" {{ $max_height_arr[0] == 6 ? 'selected' : Null }}>6 Feet</option>
                                                <option value="7" {{ $max_height_arr[0] == 7 ? 'selected' : Null }}>7 Feet</option>
                                                <option value="8" {{ $max_height_arr[0] == 8 ? 'selected' : Null }}>8 Feet</option>
                                            </select>
                                            <select class="form-control" style="width:47%;float:left; margin-left:2%;" required name="part_max_inch" >
                                                <option value="0" {{ isset($max_height_arr[1]) && $max_height_arr[1] == 0 ? 'selected' : Null }} >0 Inch </option>
                                                <option value="1" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 1 ? 'selected' : Null }} >1 Inch </option>
                                                <option value="2" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 2 ? 'selected' : Null }}>2 Inch </option>
                                                <option value="3" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 3 ? 'selected' : Null }}>3 Inch </option>
                                                <option value="4" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 4 ? 'selected' : Null }}>4 Inch </option>
                                                <option value="5" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 5 ? 'selected' : Null }}>5 Inch </option>
                                                <option value="6" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 6 ? 'selected' : Null }}>6 Inch </option>
                                                <option value="7" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 7 ? 'selected' : Null }}>7 Inch </option>
                                                <option value="8" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 8 ? 'selected' : Null }}>8 Inch </option>
                                                <option value="9" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 9 ? 'selected' : Null }}>9 Inch </option>
                                                <option value="10" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 10 ? 'selected' : Null }}>10 Inch </option>
                                                <option value="11" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 11 ? 'selected' : Null }}>11 Inch </option>
                                                <option value="12" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 12 ? 'selected' : Null }}>12 Inch </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="col-sm-6 hidden">
                                        <div class="form-group">
                                            <label>Partner city</label>
                                            <input type="text" name="partner_city" value="{{ $user->partner_city }}" class="form-control" >                                  
                                        </div>
                                    </div>

                                    <!-- partner body color Hidden -->
                                    <div class="col-sm-4 hidden">
                                        <div class="form-group">
                                            <label>Partner body color</label>
                                            <input type="text" name="partner_body_color" value="{{ $user->partner_body_color }}" class="form-control" placeholder="Body Color">
                                        </div>                                
                                    </div>

                                    <!--partner Mother taungh -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Partner Mother tongue</label>
                                            <select name="partner_mother_tongue[]" class="form-control select2" multiple >
                                                <option value="Arabic" {{ is_array($user->partner_mother_tongue) && in_array('Arabic', $user->partner_mother_tongue) ? 'selected' : Null }} >Arabic</option>
                                                <option value="Bengali" {{ is_array($user->partner_mother_tongue) && in_array('Bengali', $user->partner_mother_tongue) ? 'selected' : Null }} >Bengali</option>
                                                <option value="Chinise" {{ is_array($user->partner_mother_tongue) && in_array('Chinise', $user->partner_mother_tongue) ? 'selected' : Null }} >Chinise</option>
                                                <option value="English" {{ is_array($user->partner_mother_tongue) && in_array('English', $user->partner_mother_tongue) ? 'selected' : Null }}>English</option>
                                                <option value="French" {{ is_array($user->partner_mother_tongue) && in_array('French', $user->partner_mother_tongue) ? 'selected' : Null }}>French</option>
                                                <option value="German" {{ is_array($user->partner_mother_tongue) && in_array('German', $user->partner_mother_tongue) ? 'selected' : Null }}>German</option>
                                                <option value="Hindi" {{ is_array($user->partner_mother_tongue) && in_array('Hindi', $user->partner_mother_tongue) ? 'selected' : Null }}>Hindi</option>
                                                <option value="Indonesion" {{ is_array($user->partner_mother_tongue) && in_array('Indonesion', $user->partner_mother_tongue) ? 'selected' : Null }}>Indonesion</option>
                                                <option value="Italian" {{ is_array($user->partner_mother_tongue) && in_array('Italian', $user->partner_mother_tongue) ? 'selected' : Null }}>Italian</option>
                                                <option value="Japanese" {{ is_array($user->partner_mother_tongue) && in_array('Japanese', $user->partner_mother_tongue) ? 'selected' : Null }}>Japanese</option>
                                                <option value="Korean" {{ is_array($user->partner_mother_tongue) && in_array('Korean', $user->partner_mother_tongue) ? 'selected' : Null }}>Korean</option>
                                                <option value="Nepali" {{ is_array($user->partner_mother_tongue) && in_array('Nepali', $user->partner_mother_tongue) ? 'selected' : Null }}>Nepali</option>
                                                <option value="Punjabi" {{ is_array($user->partner_mother_tongue) && in_array('Punjabi', $user->partner_mother_tongue) ? 'selected' : Null }}>Punjabi</option>
                                                <option value="Russian" {{ is_array($user->partner_mother_tongue) && in_array('Russian', $user->partner_mother_tongue) ? 'selected' : Null }}>Russian</option>
                                                <option value="Spanish" {{ is_array($user->partner_mother_tongue) && in_array('Spanish', $user->partner_mother_tongue) ? 'selected' : Null }}>Spanish</option>
                                                <option value="Swedish" {{ is_array($user->partner_mother_tongue) && in_array('Swedish', $user->partner_mother_tongue) ? 'selected' : Null }}>Swedish</option>
                                                <option value="Tamil" {{ is_array($user->partner_mother_tongue) && in_array('Tamil', $user->partner_mother_tongue) ? 'selected' : Null }}>Tamil</option>
                                                <option value="Telugu" {{ is_array($user->partner_mother_tongue) && in_array('Telugu', $user->partner_mother_tongue) ? 'selected' : Null }}>Telugu</option>
                                                <option value="Turkish" {{ is_array($user->partner_mother_tongue) && in_array('Turkish', $user->partner_mother_tongue) ? 'selected' : Null }}>Turkish</option>
                                                <option value="Urdu" {{ is_array($user->partner_mother_tongue) && in_array('Urdu', $user->partner_mother_tongue) ? 'selected' : Null }}>Urdu</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- partner_eye_color -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Partner eye color</label>
                                            <select name="partner_eye_color[]" class="form-control select2" multiple>
                                                <option value="Amber" {{ is_array($user->partner_eye_color) && in_array('Amber', $user->partner_eye_color) ? 'selected' : Null }} >Amber</option>
                                                <option value="Black" {{ is_array($user->partner_eye_color) && in_array('Black', $user->partner_eye_color) ? 'selected' : Null }} >Black</option>
                                                <option value="Blue" {{ is_array($user->partner_eye_color) && in_array('Blue', $user->partner_eye_color) ? 'selected' : Null }} >Blue</option>
                                                <option value="Brown" {{ is_array($user->partner_eye_color) && in_array('Brown', $user->partner_eye_color) ? 'selected' : Null }} >Brown</option>
                                                <option value="Gray" {{ is_array($user->partner_eye_color) && in_array('Gray', $user->partner_eye_color) ? 'selected' : Null }} >Gray</option>
                                                <option value="Green" {{ is_array($user->partner_eye_color) && in_array('Green', $user->partner_eye_color) ? 'selected' : Null }} >Green</option>
                                                <option value="Red" {{ is_array($user->partner_eye_color) && in_array('Red', $user->partner_eye_color) ? 'selected' : Null }} >Red</option>
                                            </select>                                    
                                        </div>
                                    </div>


                                    <!-- partner_complexion -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Partner complexion</label>                                    
                                            <select name="partner_complexion[]" class="form-control select2" multiple>
                                                <option value="">Select Complexion</option>
                                                <option value="Light skin" {{ is_array($user->partner_complexion) && in_array('Light skin', $user->partner_complexion) ? 'selected' : Null }} >Light skin</option>
                                                <option value="Fair skin" {{ is_array($user->partner_complexion) && in_array('Fair skin', $user->partner_complexion) ? 'selected' : Null }} >Fair skin</option>
                                                <option value="Medium skin" {{ is_array($user->partner_complexion) && in_array('Medium skin', $user->partner_complexion) ? 'selected' : Null }} >Medium skin</option>
                                                <option value="Olive skin" {{ is_array($user->partner_complexion) && in_array('Olive skin', $user->partner_complexion) ? 'selected' : Null }} >Olive skin</option>
                                                <option value="Dark skin" {{ is_array($user->partner_complexion) && in_array('Dark skin', $user->partner_complexion) ? 'selected' : Null }} >Dark skin</option>
                                                <option value="Tan brown skin" {{ is_array($user->partner_complexion) && in_array('Tan brown skin', $user->partner_complexion) ? 'selected' : Null }} >Tan brown skin</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- partner_dite -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Diet </label>                          
                                            <select name="partner_dite[]" class="form-control select2" multiple >
                                                <option value="">Select Diet</option>
                                                <option value="Vegetarian" {{ is_array($user->partner_dite) && in_array('Vegetarian' ,$user->partner_dite) ? 'selected' : Null }} >Vegetarian</option>
                                                <option value="Non vegetarian" {{ is_array($user->partner_dite) && in_array('Non vegetarian', $user->partner_dite) ? 'selected' : Null  }} >Non vegetarian</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- partner_father_occupation Hidden -->
                                    <div class="col-sm-4 hidden">
                                        <div class="form-group">
                                            <label>Partner Father's occupation</label>
                                            <select name="partner_father_occupation" class="form-control">
                                                <option value="">Select Profession</option>
                                                @foreach($professions as $profession)
                                                    <option value="{{ $profession->name }}" {{ $profession->name == $user->partner_father_occupation ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Marital Status -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Partner Marital Status</label>
                                            <select name="partner_marital_status[]" class="select2" multiple >
                                                <option value="M" {{ !is_null($user->partner_marital_status) && in_array('M', $user->partner_marital_status) ? 'selected' : Null}} > Married </option>                                
                                                <option value="U" {{ !is_null($user->partner_marital_status) && in_array('U', $user->partner_marital_status) ? 'selected' : Null}} > Unmarried </option>                                
                                                <option value="D" {{ !is_null($user->partner_marital_status) && in_array('D', $user->partner_marital_status) ? 'selected' : Null}} > Divorce </option>                                
                                                <option value="not applicable" {{ !is_null($user->partner_marital_status) && in_array('not applicable', $user->partner_marital_status) ? 'selected' : Null}}> Not Applicable </option>
                                            </select>                                    
                                        </div>
                                    </div>
        
                                                                
        
                                    <!-- Religion Cast -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Partner Religion Cast</label>
                                            <select name="partner_religion_cast[]" class="partner-religion-cast select2" multiple >
                                                @if( !is_null($user->partner_religion_cast) )
                                                    @foreach($user->partner_religion_cast as $value)
                                                        <option value="{{ $value }}" selected > {{ $value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>                                    
                                        </div>
                                    </div>
        
                                    <!-- Country -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Country <span class="text-danger">*</span></label>
                                            <select name="partner_country[]" class="select2" multiple required>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->country }}" {{ !is_null($user->partner_country) && in_array($country->country, $user->partner_country) ? 'selected' : Null }} > {{ $country->country }} </option>
                                                @endforeach
                                            </select>                                    
                                        </div>
                                    </div>
                                    
                                    <!-- Education -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Partner Education <span class="text-danger">*</span></label>
                                            <select name="partner_education[]" class="select2 form-control" required multiple>
                                                <option value="">Select Education</option>
                                                @foreach($educations as $education)
                                                    <option value="{{ $education->name }}" {{ !is_null($user->partner_education) && in_array($education->name, $user->partner_education) ? 'selected' : Null }} > {{ $education->name }} </option>
                                                @endforeach
                                            </select>                                    
                                        </div>
                                    </div>
        
                                    <!-- Education -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Partner Profession </label>
                                            <select name="partner_profession[]" class="select2 form-control" multiple>
                                                <option value="">Select Profession</option>
                                                @foreach($professions as $profession)
                                                    <option value="{{ $profession->name }}" {{ !is_null($user->partner_profession) && in_array($profession->name, $user->partner_profession) ? 'selected' : Null }} > {{ $profession->name }} </option>
                                                @endforeach
                                            </select>                                    
                                        </div>
                                    </div>

                                    <!-- Partner Blood Group -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Blood Group</label> 
                                            <select name="partner_blood_group[]" class="form-control select2" multiple >
                                                <option value="A+" {{ is_array($user->partner_blood_group) && in_array('A+', $user->partner_blood_group) ? 'selected' : Null }} >A+</option>
                                                <option value="A-" {{ is_array($user->partner_blood_group) && in_array('A-', $user->partner_blood_group) ? 'selected' : Null }} >A-</option>
                                                <option value="B+" {{ is_array($user->partner_blood_group) && in_array('B+', $user->partner_blood_group) ? 'selected' : Null }} >B+</option>
                                                <option value="B-" {{ is_array($user->partner_blood_group) && in_array('B-', $user->partner_blood_group) ? 'selected' : Null }} >B-</option>
                                                <option value="AB+" {{ is_array($user->partner_blood_group) && in_array('AB+', $user->partner_blood_group) ? 'selected' : Null }} >AB+</option>
                                                <option value="AB-" {{ is_array($user->partner_blood_group) && in_array('AB-', $user->partner_blood_group) ? 'selected' : Null }} >AB-</option>
                                                <option value="O+" {{ is_array($user->partner_blood_group) && in_array('O+', $user->partner_blood_group) ? 'selected' : Null }} >O+</option>
                                                <option value="O-" {{ is_array($user->partner_blood_group) && in_array('O-', $user->partner_blood_group) ? 'selected' : Null }} >O-</option>
                                            </select>                         
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="panel panel-info">
                            <div class="panel-heading text-white" style="background-color:rgb(42, 196, 218);">
                                <h3>Documents</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">                             
                                    <!-- Bio data -->
                                    <div class="col-sm-4">
                                        <div class="form-group"> 
                                            <label>Bio Data</label><br>                                            
                                            <input type="file" name="user_bio_data_path" >
                                            @if( file_exists($user->user_bio_data_path) )
                                                <a href="{{ asset($user->user_bio_data_path) }}" class="btn btn-link" target="_blank">View Bio-Data</a><br>
                                            @endif
                                        </div>
                                    </div>                            
        
                                    <!-- NID Image -->
                                    <div class="col-sm-4">
                                        <div class="form-group"> 
                                            <label>NID</label><br>                                            
                                            <input type="file" name="nid_image" accept="image/png,image/jpeg">
                                            @if( file_exists($user->nid_image) )
                                                <img src="{{ asset($user->nid_image) }}" class="img-responsive"><br>
                                            @endif
                                        </div>
                                    </div>                            
        
                                    <!-- Passport Image -->
                                    <div class="col-sm-4">
                                        <div class="form-group"> 
                                            <label>Passport</label><br>                                            
                                            <input type="file" name="passport_image" accept="image/png,image/jpeg">
                                            @if( file_exists($user->passport_image) )
                                                <img src="{{ asset($user->passport_image) }}" class="img-responsive"><br>
                                            @endif
                                        </div>
                                    </div>
        
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Uploading</label>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"> 0% </div>
                                            </div>
                                        </div>
                                    </div>
        
                                    <!-- Submit -->
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info form-control">Update Information</button>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-2 chatting-section">
                <h3> Online </h3>
                <hr/>
                @include('frontEnd.chatting.chat')
            </div>
        </div>
    </div>

    <!-- Instruction Modal -->
    <div class="modal auth-modal fade" keyboard="false" data-backdrop="static" >
		<div class="modal-dialog modal-md" role="document" >
			<div class="modal-content" style="background-image: url({{$system->logo}});background-repeat: no-repeat;background-position: right; background-size:contain; " >
				<div class="modal-header text-left">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ $system->application_name }}
                </div>
                <div class="modal-body row">
                    <div class="col-sm-12">
                        <p style="color:#000; font-size:18px;"> <b>Dear {{ $user->first_name .' '. $user->last_name}},</b> <br><br>
                            @if(!Auth::user()->user_status)
							    Your Profile is not approve yet. Admin will verify within <b>24</b> hours after <b>100%</b> complete your profile. Now your Profile is {{ $profile_complete }}% complete.
							    <br><br>
						    @endif
							You are using Free subscription Plan. To skip profile approval step, view contact cetails, send message & connect with others, upgrade your membership.
                            <br><br><b>
                            1. Free user members can profile view <br>
                            2. Free user members can't text message <br>
                            3. Free user members can't see contact details of partner<br>
                            4. Free user members can't accept partner request<br>
                            Hot line number: +880 1722 063276</b>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <a href="{{ route('membership.upgrade') }}" title="Click here to show Packages" class="btn btn-info">Subscribe Now</a>
                </div>
			</div>
		</div>
	</div>

    <script>
        $(document).ready(function(){
            $('.religion-select').change();
            $('.partner-religion-select').change();
            $('.division').change();            
            @if( empty($user->subscribePackage) )
                $('.modal').modal('show');
            @endif
        })
        $(document).on('change', '.religion-select', function(){
            let id = $(this).val();
            let old_val = $('.religion-cast').val();
            $.ajax({
                url : "{{ route('religious.cast.get')}}",
                data : { id : id},
                success : function(output){
                    let option = `<option value="">Select Option</option>`;
                    $.each(output, function(index, value){           
                        option += `<option value = "`+value.id+`"`;
                        option += value.id == old_val ? `selected` : ``;
                        option += `>` + value.name +`</option>`;
                    });
                    $('.religion-cast').html(option);
                },error : function(output){
                    // console.log(output);
                }
             });
        });
        
    $('#same-address').change(function(){
        if( $(this).is(':checked') ){
            $('input[name="user_permanent_city"]').val($('input[name="user_present_city"]').val());
            $('input[name="user_permanent_address"]').val($('input[name="user_present_address"]').val());
            $('select[name="user_permanent_country"]').val($('select[name="user_present_country"]').val());
        }else{
            $('input[name="user_permanent_city"]').val("");
            $('input[name="user_permanent_address"]').val("");
            $('select[name="user_permanent_country"]').val("");
        }
    });


    $(document).on('change', '.partner-religion-select', function(){
        let id = $(this).val();
        let old_val = $('.partner-religion-cast').val();
        $.ajax({
            url : "{{ route('religious.cast.get')}}",
            data : { id : id},
            success : function(output){
                let option = `<option value="">Select Option</option>`;
                $.each(output, function(index, value){           
                    option += `<option value = "`+value.name+`"`;
                    option += inArray(value.name, old_val) ? `selected` : ``;
                    option += `>` + value.name +`</option>`;
                });
                $('.partner-religion-cast').html(option);
            },error : function(output){
                // console.log(output);
            }
        });
    });

    function inArray(value, array) {
        if( array === null) return false;
        var length = array.length;
        for(var i = 0; i < length; i++) {
            if(array[i] == value) return true;
        }
        return false;
    }

    $('.division').change(function(){
        $.ajax({
            url : '{{ route('get.district') }}',
            data : { division_id : $('.division').val() },
            success : function(option){
                $('.district').html(option);
                $('.district').change();
            }
        });
    });

    $('.district').change(function(){
        $.ajax({
            url : '{{ route('get.upazila') }}',
            data : { district_id : $('.district').val() },
            success : function(option){
                $('.upazila').html(option);
            }
        });
    });

    </script>
@endsection