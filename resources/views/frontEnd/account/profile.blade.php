@extends('frontEnd.masterPage')
@section('style')
    <link rel="stylesheet" href="{{ asset('frontEnd/css/flexslider.css') }}" type="text/css" media="screen" />
@stop
@section('mainPart')
    <div class="grid_3">
        <div class="container">
            <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/home')}}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">View Profile</li>
            </ul>
            </div>
            <div class="profile">
                <div class="col-md-8 profile_left">
                    <h3>MMBD-{{ $profile->id }}</h3>
                    <div class="col_3">
                        <div class="col-sm-4 row_2">
                            <div class="flexslider">
                                <ul class="slides">
                                    @forelse($profile->userImages as $image)
                                    <li data-thumb="{{ asset($image->image_path) }}">
                                        <img src="{{ asset($image->image_path) }}" class="img-responsive" />
                                    </li>
                                    @empty
                                    <li data-thumb="{{ asset('image-not-found.png') }}">
                                        <img src="{{ asset('image-not-found.png') }}" class="img-responsive" />
                                    </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="col-sm-8 row_1">
                            <table class="table_working_hours profile-details">
                                <tbody>
                                    <tr class="opened_1">
                                        <td class="day_label">Status :</td>
                                        <td class="day_value">{!! $profile->is_online ? '<span class="label label-success">Online</span>' : '<span class="label label-warning">Offline</span>' !!}</td>
                                    </tr>
                                    
                                    <tr class="opened_1">
                                        <td class="day_label">Gender :</td>
                                        <td class="day_value">{{ $profile->grnder == 'M' ? 'Male' : 'Female' }}</td>
                                    </tr>
                                    <tr class="opened_1">
                                        <td class="day_label">Age :</td>
                                        <td class="day_value">{{ Carbon\Carbon::now()->diffInYears($profile->date_of_birth) }} Years.</td>
                                    </tr>
                                    <tr class="opened_1">
                                        <td class="day_label">Height :</td>
                                        <td class="day_value">
                                            @php
                                                $height = explode('.', $profile->user_height);
                                            @endphp
                                            {{ isset($height[0]) ? $height[0] . ' Feet ' : 'N/A' }}
                                            {{ isset($height[1]) ? $height[1] . ' Inch ' : Null }}
                                        </td>
                                    </tr>
                                    <tr class="opened_1">
                                        <td class="day_label">Body Type :</td>
                                        <td class="day_value">{{ is_null($profile->user_body_weight) ? 'N/A' : $profile->user_body_weight }} </td>
                                    </tr>
                                    
                                    <tr class="opened">
                                        <td class="day_label">Religion :</td>
                                        <td class="day_value"> {{ $profile->religious->name }} {{ !is_null($profile->religionCast) ? '- '. $profile->religionCast->name : Null }}</td>
                                    </tr>
                                    <tr class="opened">
                                        <td class="day_label">Marital Status :</td>
                                        <td class="day_value">
                                            @if($profile->marital_status == 'M')
                                                Married
                                            @elseif($profile->marital_status == 'U')
                                                Single
                                            @else
                                                Divorce
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="opened">
                                        <td class="day_label">Location :</td>
                                        <td class="day_value">{{ is_null($profile->location_country) ? 'N/A' : $profile->location_country  }}</td>
                                    </tr>
                                    <tr class="opened">
                                        <td class="day_label">Life Style :</td>
                                        <td class="day_value">{{ is_null($profile->lifeStyle) ? 'N/A' : $profile->lifeStyle->name  }}</td>
                                    </tr>                                   
                                    <tr class="closed">
                                        <td class="day_label">Education :</td>
                                        <td class="day_value closed"><span>{{ isset($profile->educationLevel->name) ? $profile->educationLevel->name : 'N/A' }}</span></td>
                                    </tr>
                                    <tr class="closed">
                                        <td class="day_label">Profession :</td>
                                        <td class="day_value closed"><span>{{ isset($profile->careerProfession->name) ? $profile->careerProfession->name : 'N/A' }}</span></td>
                                    </tr>
                                    <tr class="closed">
                                        <td class="day_label">Monthly Income :</td>
                                        <td class="day_value closed"><span>{{ isset($profile->monthlyIncome->range) ? $profile->monthlyIncome->range : 'N/A' }}</span></td>
                                    </tr>
                                    <tr class="closed">
                                        <td class="day_label">Profile Created by :</td>
                                        <td class="day_value closed"><span>{{ !is_null($profile->created_by) ? 'Admin' : 'Self' }}</span></td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>

                        <!-- Profile Contact Details-->
                        <div class="col-sm-8 row_1 col-sm-offset-4 view-contact-details  mt-3">                            
                            <a href="{{ url('profile/'.$profile->id.'/view-contact') }}" class="btn-primary btn view-contact" onclick="return confirm('Are you sure to view contact details ?')" >View Contact Details</a>
                            @if($profile->id != Auth::user()->id)                      
                                @if($sent_proposal)
                                    <a href="{{ url('profile/'.$profile->id.'/proposal/sent') }}" class="btn btn-info sent-invitation " >Sent Proposal </a>
                                @else
                                    @if($is_connected && !$block_profile)
                                        <button type="button" class="btn btn-success" >Connected</button>
                                    @else
                                        <button type="button" class="btn btn-danger" >Proposal Already Sent</button>
                                    @endif  
                                @endif                              
                            @endif
                            <a href="{{ url('profile/'.$profile->id.'/block') }}" class="btn btn-warning  block-profile {{ $block_profile ? 'hidden' : Null}}" >Block</a>
                            <a href="{{ url('profile/'.$profile->id.'/unblock') }}" class="btn btn-info unblock-profile {{ !$block_profile ? 'hidden' : Null}}" >Unblock</a>
                        
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    
                    <div class="col_4">
                        <h3>About <span class="text-info">MMBD-{{ $profile->id }}</span> </h3>
                        <div style="color:#999; font-size:14px;">
                            {!! is_null($profile->user_bio_myself) ? Null : $profile->user_bio_myself !!}
                        </div>

                        <div class="basic_1 mt-3">
                            <h3 class="bg-primary text-white" >Basics Profile & Lifestyle</h3>
                            <div class="col-md-6 basic_1-left">
                                <table class="table_working_hours">
                                    <tbody>
                                        <tr class="opened_1">
                                            <td class="day_label">Gender :</td>
                                            <td class="day_value">{{ $profile->grnder == 'M' ? 'Male' : 'Female' }} </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Country :</td>
                                            <td class="day_value">{{ is_null($profile->location_country) ? 'N/A' : $profile->location_country }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Marital Status :</td>
                                            <td class="day_value">
                                                @if($profile->marital_status == 'M')
                                                    Married
                                                @elseif($profile->marital_status == 'U')
                                                    UnMarried
                                                @else
                                                    Divorce
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Height :</td>                                           

                                            <td class="day_value">
                                                @php
                                                    $height = explode('.', $profile->user_height);
                                                @endphp
                                                {{ isset($height[0]) ? $height[0] . ' Feet ' : 'N/A' }}
                                                {{ isset($height[1]) ? $height[1] . ' Inch ' : Null }}                                                
                                            </td>
                                        </tr>
                                        {{-- <tr class="opened">
                                            <td class="day_label">Body Color :</td>
                                            <td class="day_value">{{ is_null($profile->user_body_color) ? 'N/A' : $profile->user_body_color }}</td>
                                        </tr>                                         --}}
                                        <tr class="closed">
                                            <td class="day_label">Hair color :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->hair_color) ? 'N/A' : $profile->hair_color }}</span></td>
                                        </tr>
                                        <tr class="closed">
                                            <td class="day_label">Eye color :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->eye_color) ? 'N/A' : $profile->eye_color }}</span></td>
                                        </tr>
                                        <tr class="closed">
                                            <td class="day_label">Complexion :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->complexion) ? 'N/A' : $profile->complexion }}</span></td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Profile Created by :</td>
                                            <td class="day_value closed"><span>Self</span></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6 basic_1-left">
                                <table class="table_working_hours">
                                    <tbody>
                                        <tr class="opened_1">
                                            <td class="day_label">Age :</td>
                                            <td class="day_value">{{ Carbon\Carbon::now()->diffInYears($profile->date_of_birth) }} Years </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Body Type :</td>
                                            <td class="day_value">{{ is_null($profile->user_body_weight) ? 'N/A' : $profile->user_body_weight }}</td>
                                        </tr>
                                        <tr class="opened_1">
                                            <td class="day_label">Life Style :</td>
                                            <td class="day_value">{{ is_null($profile->lifeStyle) ? 'N/A' : $profile->lifeStyle->name  }} </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Blood Group :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->user_blood_group) ? 'N/A' : $profile->user_blood_group }}</span></td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Fitness disabilities :</td>
                                            <td class="day_value closed"><span>
                                                @if( !empty($profile->user_fitness_disabilities) )
                                                    @if($profile->user_fitness_disabilities == 'Y')
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                @else
                                                    No
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Mother Tongue :</td>
                                            <td class="day_value">{{ is_null($profile->mother_tongue) ? 'N/A' : $profile->mother_tongue }}</td>
                                        </tr>  
                                        <tr class="closed">
                                            <td class="day_label">Diet :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->diet) ? 'N/A' : $profile->diet }}</span></td>
                                        </tr>                                 
                                        <tr class="closed">
                                            <td class="day_label">Smoke :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->smoke) ? 'N/A' : $profile->smoke }}</span></td>
                                        </tr>
                                        <tr class="closed">
                                            <td class="day_label">Drink :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->drink) ? 'N/A' : $profile->drink }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>                            
                            <div class="clearfix"> </div>
                        </div>

                        <div class="basic_1">
                            <h3 class="bg-primary text-white">Religious / Social Background</h3>
                            <div class="col-md-6 basic_1-left">
                                <table class="table_working_hours">
                                <tbody>
                                    <tr class="opened">
                                        <td class="day_label">Time of Birth :</td>
                                        <td class="day_value">{{ Carbon\Carbon::parse($profile->date_of_birth)->format('l') }}</td>
                                    </tr>
                                    <tr class="opened">
                                        <td class="day_label">Date of Birth :</td>
                                        <td class="day_value closed"><span>{{ Carbon\Carbon::parse($profile->date_of_birth)->format('d-F, Y') }}</span></td>
                                    </tr>
                                    <tr class="opened">
                                        <td class="day_label">Place of Birth :</td>
                                        <td class="day_value closed"><span>{{ $profile->location_country }}</span></td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>

                            <div class="col-md-6 basic_1-left">
                                <table class="table_working_hours">
                                <tbody>
                                    <tr class="opened_1">
                                        <td class="day_label">Religion :</td>
                                        <td class="day_value"> {{ ucfirst($profile->religious->name) }} </td>
                                    </tr>
                                    <tr class="opened">
                                        <td class="day_label">Sub Caste :</td>
                                        <td class="day_value">{{ !is_null($profile->religionCast) ? ucfirst($profile->religionCast->name) : 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        
                        <div class="basic_1">
                            <h3 class="bg-primary text-white" >Education & Career</h3>
                            <div class="basic_1-left">
                                <table class="table_working_hours">
                                    <tbody>
                                        <tr class="opened">
                                            <td class="day_label">Education   :</td>
                                            <td class="day_value">{{ is_null($profile->educationLevel) ? 'N/A' : $profile->educationLevel->name }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Institute :</td>
                                            <td class="day_value">{{ is_null($profile->edu_institute_name) ? 'N/A' : $profile->edu_institute_name }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Occupation </td>
                                            <td class="day_value closed"><span>{{ is_null($profile->careerProfession) ? 'N/A' : ucfirst($profile->careerProfession->name)  }}</span></td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Working Name / Post Name</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->career_working_name) ? 'N/A' : ucfirst($profile->career_working_name)  }}</span></td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Organisation</td>
                                            <td class="day_value closed">
                                                @if( is_null(Auth::user()->subscribePackage) )
                                                    <span>
                                                        <a href="url('/packages')" class="btn btn-info btn-xs" title="Click to Upgrade">Subscription upgrade</a>
                                                    </span>
                                                @else
                                                    <span>{{ is_null($profile->organisation) ? 'N/A' : ucfirst($profile->career_working_name)  }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Monthly Income :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->monthlyIncome) ? 'N/A' : $profile->monthlyIncome->range  }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="clearfix"> </div>
                        </div>

                        <!-- Family Information -->
                        <div class="basic_1">
                            <h3 class="bg-primary text-white" >Family Information</h3>
                            <div class="basic_1-left">
                                <table class="table_working_hours">
                                    <tbody>
                                        <tr class="opened">
                                            <td class="day_label">Gardian contact</td>
                                            <td class="day_value closed">
                                                @if( is_null(Auth::user()->subscribePackage) )
                                                    <span>
                                                        <a href="url('/packages')" class="btn btn-info btn-xs" title="Click to Upgrade">Subscription upgrade</a>
                                                    </span>
                                                @else
                                                    <span>{{ is_null($profile->gardian_contact_no) ? 'N/A' : $profile->gardian_contact_no  }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Father's Occupation :</td>
                                            <td class="day_value closed">{{ is_null($profile->father_occupation) ? 'N/A' : $profile->father_occupation }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Father's Occupation :</td>
                                            <td class="day_value closed">{{ is_null($profile->father_occupation) ? 'N/A' : $profile->father_occupation }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Father's Name :</td>
                                            <td class="day_value closed">{{ is_null($profile->father_name) ? 'N/A' : $profile->father_name }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Mother's Occupation :</td>
                                            <td class="day_value closed">{{ is_null($profile->mother_occupation) ? 'N/A' : $profile->mother_occupation }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Mother's Name :</td>
                                            <td class="day_value closed">{{ is_null($profile->mother_name) ? 'N/A' : $profile->mother_name }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">No. of Brothers :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->no_of_brother) ? 'N/A' : $profile->no_of_brother }}</span></td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">No. of Sisters :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->no_of_sister) ? 'N/A' : $profile->no_of_sister }}</span></td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Family Values :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->family_values) ? 'N/A' : $profile->family_values }}</span></td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Family Details :</td>
                                            <td class="day_value closed"><span>{{ is_null($profile->family_details) ? 'N/A' : $profile->family_details }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Partner Information -->
                        <div class="basic_1">
                            <h3 class="bg-primary text-white" >Partner Information</h3>
                            <div class="basic_1-left">
                                <table class="table_working_hours">
                                    <tbody>
                                       
                                        <tr class="opened">
                                            <td class="day_label">Height :</td>
                                            <td class="day_value closed">
                                                @php
                                                    $min_height = explode('.', $profile->partner_min_height);
                                                    $max_height = explode('.', $profile->partner_max_height);
                                                @endphp
                                                {{ isset($min_height[0]) ? $min_height[0] . ' Feet ' : 'N/A' }}
                                                {{ isset($min_height[1]) ? $min_height[1] . ' Inch ' : Null }} - 
                                                {{ isset($max_height[0]) ? $max_height[0] . ' Feet ' : 'N/A' }}
                                                {{ isset($max_height[1]) ? $max_height[1] . ' Inch ' : Null }}                                                
                                            </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Age :</td>
                                            <td class="day_value closed">{{ is_null($profile->partner_min_age) ? 'N/A' : $profile->partner_min_age .' Yrs - '. $profile->partner_max_age.' Yrs' }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Blood Group :</td>
                                            <td class="day_value closed">{{ is_array($profile->partner_blood_group) ? implode(',', $profile->partner_blood_group) : 'N/A' }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Eye Color :</td>
                                            <td class="day_value closed">{{ is_array($profile->partner_eye_color) ? implode(',', $profile->partner_eye_color) : 'N/A' }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label"> Complexion :</td>
                                            <td class="day_value closed">{{ is_array($profile->partner_complexion) ? implode(',', $profile->partner_complexion) : 'N/A' }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Dite :</td>
                                            <td class="day_value closed">{{ is_array($profile->partner_dite) ? implode(',', $profile->partner_dite) : 'N/A' }}</td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Marital status :</td>
                                            <td class="day_value closed">
                                                @if( is_array($profile->partner_marital_status) )
                                                    @foreach($profile->partner_marital_status as $status)
                                                        @if($status == 'M')
                                                            Married, 
                                                        @endif
                                                        @if($status == 'U')
                                                            Unmarried, 
                                                        @endif
                                                        @if($status == 'D')
                                                            Divorce 
                                                    @endif
                                                    @endforeach
                                                @endif                                                
                                            </td>
                                        </tr>
                                        <tr class="opened">
                                            <td class="day_label">Mother tongue :</td>
                                            <td class="day_value closed">{{ is_array($profile->partner_mother_tongue) ? implode(',', $profile->partner_mother_tongue) : 'N/A' }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 profile_right">
                    <div class="view_profile">
                        <h3>View Similar Profiles</h3>
                        @foreach($similar_profiles as $profile)
                        <ul class="profile_item">
                            <a href="{{ url('profile/'.$profile->id.'/MMBD-'.$profile->id.'/view') }}">
                            <li class="profile_item-img">
                                <img src="{{ !is_null($profile->profilePic) && file_exists($profile->profilePic->image_path) ? asset($profile->profilePic->image_path) : asset('dummy-user.png') }}" class="img-responsive img-circle text-center" alt="Image" style="width: 80px; height:80px;" />
                            </li>
                            <li class="profile_item-desc">
                                <h4>MMBD-{{ $profile->id }}</h4>
                                <p>{{ Carbon\Carbon::now()->diffInYears($profile->date_of_birth) }} Yrs, {{ $profile->religious->name }} {{ !is_null($profile->religionCast) ? '- '. $profile->religionCast->name : Null }}</p>
                                <h5>View Full Profile</h5>
                            </li>
                            {{-- <div class="clearfix"> </div> --}}
                            </a>
                        </ul>
                        @endforeach
                    </div>

                    <div class="view_profile view_profile1">
                        <h3>Members who viewed this profile also viewed</h3>
                        @foreach($visitor_profiles as $profile)
                        <ul class="profile_item">
                            <a href="{{url('profile/'.$profile->id.'/'.str_replace(' ','-', $profile->first_name).'/view')}}">
                            <li class="profile_item-img">
                                <img src="{{ !is_null($profile->profilePic) && file_exists($profile->profilePic->image_path) ? asset($profile->profilePic->image_path) : asset('dummy-user.png') }}" class="img-responsive img-circle text-center"  alt="Image" style="width: 80px; height:80px;" />
                            </li>
                            <li class="profile_item-desc">
                                <h4>MMBD-{{ $profile->id }}</h4>
                                <p>{{ Carbon\Carbon::now()->diffInYears($profile->date_of_birth) }} Yrs, {{ $profile->religious->name }} {{ !is_null($profile->religionCast) ? '- '. $profile->religionCast->name : Null }}</p>
                                <h5>View Full Profile</h5>
                            </li>
                            {{-- <div class="clearfix"> </div> --}}
                            </a>
                        </ul>
                        @endforeach
                    </div>
                </div>
                
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script defer src="{{ asset('frontEnd/js/jquery.flexslider.js') }}"></script>
    <script>
        $(window).load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });
        });

        $('.sent-invitation').click(function(e){
            e.preventDefault();
            let self = $(this);
            let buttonText = self.html();            
            self.html('Sending...');
            $.ajax({
                url : $(this).attr('href'),
                method : 'GET',
                success : function(output){
                    if(output.status){
                        self.html('Proposal Sent');
                        successMessage(output.message, output.button);                
                    }else{
                        self.html(buttonText);
                        errorMessage(output.message)
                    }
                },
                error : function (response){
                    self.html(buttonText)
                    errorMessage(getError(response));
                }
            });
        });
        $('.block-profile').click(function(e){
            e.preventDefault();
            if(confirm('Are you Sure to Block this profile ?')){
                let self = $(this);
                let buttonText = self.html();            
                self.html('Unblocking...');
                $.ajax({
                    url : $(this).attr('href'),
                    method : 'GET',
                    success : function(output){
                        if(output.status){                            
                            successMessage(output.message, output.button);  
                            $('.block-profile').addClass('hidden');
                            $('.unblock-profile').removeClass('hidden');
                            self.html(buttonText);
                        }else{
                            self.html(buttonText);
                            errorMessage(output.message)
                        }
                    },
                    error : function (response){
                        self.html(buttonText)
                        errorMessage(getError(response));
                    }
                });
            }
        });
        $('.unblock-profile').click(function(e){
            e.preventDefault();
            if(confirm('Are you Sure to Unblock this profile ?')){
                let self = $(this);
                let buttonText = self.html();            
                self.html('Unblocking...');
                $.ajax({
                    url : $(this).attr('href'),
                    method : 'GET',
                    success : function(output){
                        if(output.status){                            
                            successMessage(output.message, output.button);  
                            $('.unblock-profile').addClass('hidden');
                            $('.block-profile').removeClass('hidden');
                            self.html(buttonText);
                        }else{
                            self.html(buttonText);
                            errorMessage(output.message)
                        }
                    },
                    error : function (response){
                        self.html(buttonText)
                        errorMessage(getError(response));
                    }
                });
            }
        });

        $(document).on('click', '.view-contact', function(e){
            e.preventDefault();
            let self = $(this);
            url = self.attr('href');
            let buttonText = self.html();  
            self.html('Loading...');
            $.ajax({
                url : url,
                success : function(output){
                    if(output.status){
                        self.addClass('hidden');
                        $('.profile-details').append(output.data);
                    }else{
                        self.html(buttonText);
                        errorMessage(output.message);
                    }
                },
                error : function (response){
                    self.html(buttonText);
                    errorMessage(getError(response));
                }
            });
        });
    </script> 
@endsection