@extends('frontEnd.masterPage')
@section('style')
<style type="text/css">
    .profile-img-section{padding:10px; border: 1px solid #eee; border-radius: 5px; font-size: 14px;}
    .round-profile-img{width:200px; height:200px; overflow: hidden; border-radius: 150%; position: relative; margin: 0px auto;}
    .round-profile-img img{display: inline; margin: 0px auto; width: 100%;}
    .thumbnail-box{background:#fff; padding: 10px; border:1px solid #eee;}
    .panel-body p{font-size: 13px;}
    .panel{height: 100px; overflow: hidden;}
    .panel hr{ margin: 5px 0px;}
    .connect{margin:10px 0px; color:#aaa; font-size:13px;}
    .botder-top{border-top:1px solid #ddd;}
    @media (min-width:992px){
        .connect{margin-top:50px;}
    }
</style>
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container-fluid" style="width:95%;">
        <div class="row">
            <!-- Subscribe Package Info Alert -->
            @if( isset($user->subscribePackage) && !empty($user->subscribePackage) && !empty($package_usees_data))
                @php 
                    $package_details = $user->subscribePackage->packageDetails;
                @endphp
                <div class="col-sm-12">
                    <div class="alert alert-warning alert-dismissible text-center" role="alert" style="font-size: 14px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>                        
                        Available Sent Proposal <b>{{ $package_details->total_proposal - $package_usees_data->sent_proposal}}</b> out of <b>{{$package_details->total_proposal}}</b>, &nbsp;
                        Available View Contact Details <b>{{ $package_details->profile_view - $package_usees_data->view_contacts}}</b> out of <b>{{ $package_details->profile_view }}</b>. &nbsp;
                        Your Current Package is <b>{{ $package_details->title }}</b>.&nbsp; For subscribe a new package <a href="{{ url('/packages') }}">Cick here</a>    
                    </div>
                </div>
            @endif

            <div class="col-md-9">
                <!-- Profile Section -->
                <div class="row">
                    <!-- Profile Image Part -->
                    <div class="col-sm-6 col-md-4">
                        <div>
                            <div class="thumbnail profile-img-section">
                                <div class="round-profile-img">
                                    <img src="{{ asset(isset($user->profilePic) && file_exists($user->profilePic->image_path) ? $user->profilePic->image_path : 'image-not-found.png') }}" alt="Not Found" >
                                </div>                                
                                <div class="caption border">
                                    <div class="row">
                                        <div class="col-xs-8">
                                            <strong>{{ $user->first_name .' '. $user->last_name }} </strong>
                                        </div>
                                        <div class="col-xs-4 text-right">
                                            <a href="{{ url('profile/update') }}" class="btn btn-info btn-xs">Edit Profile</a>
                                        </div>
                                        <div class="col-xs-8">
                                            <b>Profile Complete</b>
                                        </div>
                                        <div class="col-xs-4 text-right">{{ $profile_complete }}%</div>
                                        <div class="col-xs-12"> <hr/> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-8">
                                            Account Type <br>
                                            @if( empty($user->subscribePackage) )
                                                <b>Unsubscribe</b>
                                            @else
                                                <b> {{ $user->subscribePackage->packageDetails->title }} </b>
                                            @endif
                                        </div>
                                        <div class="col-xs-4 text-right">
                                            @if( empty($user->subscribePackage) )
                                            <a href="{{ url('account/membership/upgrade') }}" class="btn btn-info btn-xs">Upgrade</a>
                                            @endif
                                        </div>                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div><h4>Activity Summary</h4></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <h4> {{ $status['pending_proposal'] }} </h4>
                                            <hr/>
                                            <p>Pending Invitations</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <h4> {{ $status['accept_proposal'] }}  </h4>
                                            <hr/>
                                            <p>Accepted Invitations</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <h4> {{ $status['profile_visitor'] }}  </h4>
                                            <hr/>
                                            <p>Recent visitor</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <!-- My Match -->
                    <div class="col-sm-6 col-md-8">
                        <div class="row" style="box-shadow: 0px 0px 3px #aaa;padding:10px 0px;height:300;width:100%;">
                            <div class="col-sm-12">
                                <h4 class="text-info">My Matches </h4>
                            </div>
                                                            
                            @forelse($myMatches as $profile)
                            <div class="col-sm-12">
                                <div class="row botder-top" style="margin-top:10px;">
                                    <div class="col-xs-4">
                                        <a href="{{ url('profile/'.$profile->id.'/'.str_replace(' ','-', $profile->first_name).'/view') }}" >
                                            <img src="{{ asset( !is_null($profile->profilePic) && file_exists($profile->profilePic->image_path) ? $profile->profilePic->image_path : 'dummy-user.png') }}" class="img-responsive" style="margin:15px 0px;">
                                        </a>
                                    </div>
                                    <div class="col-xs-8 col-md-6" style="margin-top:10px;">
                                        <div class="col-xs-12">
                                            <div>
                                                <a href="{{ url('profile/'.$profile->id.'/'.str_replace(' ','-', $profile->first_name).'/view') }}" > MMBD-{{ $profile->id }} </a> <br>
                                            </div>
                                            <div>
                                                <div style="width: 50%; float: left;">
                                                    {!! $profile->is_online ? '<label class="label label-success">Online</label>' : '<label class="label label-default">Offline</label>' !!}
                                                </div>
                                                <div style="width: 50%; float: left; font-size:14px; color:#aaa;">
                                                    <i class="fas fa-user-friends"></i> You & Her
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-xs-12">
                                            <div style="height: 1px;background: #ddd; margin:10px 0px;"></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div style="width:65%; float: left;">
                                                <p>
                                                    {{ !is_null($profile->date_of_birth) ? Carbon\Carbon::parse($profile->date_of_birth)->diffInYears(date('Y-m-d')) .' Yrs, ' : Null }}
                                                    {{ !is_null($profile->user_height) ? $profile->user_height : Null }}<br>
                                                
                                                    {{ !is_null($profile->religious) ? $profile->religious->name : Null }} {{ !is_null($profile->religionCast) ? ', '.$profile->religionCast->name : Null }} <br>
                                                    {!! !is_null($profile->careerProfession) ? $profile->careerProfession->name.'<br>' : Null !!}
                                                    Monthly Income : {{!is_null( $profile->monthlyIncome) ?  $profile->monthlyIncome->range : 'N/A' }}
                                                </p>                                            
                                            </div>
                                            <div style="width:35%; float: left;">
                                                <p>
                                                    
                                                    {{ !is_null($profile->educationLevel) ? $profile->educationLevel->name : Null }}<br>
                                                    @if($profile->marital_status  == 'U')
                                                        Single
                                                    @elseif($profile->marital_status == 'M')                                                        
                                                        Married
                                                    @else
                                                        Divorce
                                                    @endif
                                                    <br>
                                                    {{ $profile->user_present_city }} {{ ', '.$profile->user_present_address }} <br>
                                                    {{ $profile->user_present_country }}
                                                <p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">                                                
                                            <p style="padding:5px 0px;"> 
                                                {!! substr($profile->user_bio_myself, 0, 150) !!} ... 
                                                <a href="{{ url('profile/'.$profile->id.'/'.str_replace(' ','-', $profile->first_name).'/view') }}" > Read more</a>
                                            </p>                                                
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 connect">
                                        <div class="col-md-12 col-sm-6 text-center p-0">Connect with {{ $profile->gender == "M" ? 'His' : 'Her'}}</div> 
                                        <div class="col-md-12 col-sm-6 text-center p-0">
                                            <a href="{{ url('profile/'.$profile->id.'/proposal/sent') }}" class="sent-invitation" title="sent invitation" {{ $user->isSentProposal($profile->id) ? 'data-is_sent =1' : Null}} > <i class="far fa-check-circle fa-3x"></i></a>
                                        </div>
                                        <div class="col-md-12 col-sm-6 text-center p-0">
                                            <a href="{{  url('profile/'.$profile->id.'/proposal/reject') }}" class="cancel-invitation text-danger" title="cancel invitation" {{ !$user->isSentProposal($profile->id) ? 'data-is_cancel =1' : Null}} > <i class="far fa-times-circle fa-3x"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-sm-12 text-center">
                                <h3 class="text-danger mt-5">No Match Found</h3>
                            </div>
                            @endforelse                            
                            <div class="col-sm-12 text-right" style="margin:10px 0px 20px 0px;"> {{ $myMatches->links() }}</div>
                        </div>
                    </div>                                
                </div>
            </div>

            <!-- Chatting Part -->
            <div class="col-md-3 chatting-section">
                <h3> Online </h3>
                <hr/>
                @include('frontEnd.chatting.chat')
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
    $(document).on('click', '.sent-invitation', function(e){
        e.preventDefault();
        let self = $(this);
        if(self[0].dataset.is_sent == 1){
            alert('You already Sent the proposal');
            return false;
        }

        let buttonText = self.html();            
        self.html('Sending...');
        $.ajax({
            url : $(this).attr('href'),
            method : 'GET',
            success : function(output){
                if(output.status){
                    self.html('Invitation Sent')
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
        
    $(document).on('click', '.cancel-invitation', function(e){
        e.preventDefault();
        let self = $(this);
        if(self[0].dataset.is_cancel == 1){
            alert('you don\'t sent any proposal to this Person');
            return false;
        }

        let buttonText = self.html();            
        self.html('canceling...');
        $.ajax({
            url : $(this).attr('href'),
            method : 'GET',
            success : function(output){
                if(output.status){
                    self.html('canceled')
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

</script>
@endsection