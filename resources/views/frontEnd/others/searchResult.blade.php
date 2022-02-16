<style>
    .mt-5{margin-top: 5%;}
    .profile-block{ background: #eee; padding: 10px; border-radius: 5px;}
    .panel-body p{font-size: 13px;}
    .panel{height: 100px; overflow: hidden;}
    .panel hr{ margin: 5px 0px;}
    .connect{margin:10px 0px; color:#aaa; font-size:13px;}
    .botder-top{border-top:1px solid #ddd;}
    @media (min-width:992px){
        .connect{margin-top:50px;}
    }
</style>

<div class="row" style="box-shadow: 0px 0px 3px #aaa; min-height:400px;width:100%;margin:0px;">
    <div class="col-sm-12">
        <h3 class="text-info">Search Result</h3>
    </div>
    @foreach($profiles as $profile)    
        <div class="col-sm-12">
            <div class="row botder-top" style="margin-top:10px;">
                <div class="col-xs-4">
                    <a href="{{ url('profile/'.$profile->id.'/'.str_replace(' ','-', $profile->first_name).'/view') }}" >
                        <img src="{{ asset( !is_null($profile->profilePic) && file_exists($profile->profilePic->image_path) ? $profile->profilePic->image_path : 'dummy-user.png') }}" class="img-responsive" style="margin:15px 0px;">
                    </a>
                </div>

                <!-- Show Only XS Mode -->
                <div class="col-xs-8 hidden-sm" style="margin-top:10px;">
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
                </div>

                <div class="col-xs-12 col-sm-8 col-md-6" style="margin-top:10px;">
                    <div class="col-xs-12 hidden-xs visible-sm">
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
                                @if($profile->marital_status == 'U')
                                    Single
                                @elseif($profile->marital_status == 'M')
                                    Married
                                @elseif($profile->marital_status == 'D')
                                    Divorce
                                @else
                                    {{ $profile->marital_status }}
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
                <div class="col-md-12 col-xs-4 text-center p-0">Connect with {{ $profile->gender == "M" ? 'Him' : 'Her'}}</div> 
                    <div class="col-md-12 col-xs-4  text-center p-0 pt-10">
                        <a href="{{ url('profile/'.$profile->id.'/proposal/sent') }}" class="sent-invitation" title="sent invitation" {{ Auth::user()->isSentProposal($profile->id) ? 'data-is_sent =1' : Null}} > <i class="far fa-check-circle fa-3x"></i></a>
                    </div>
                    <div class="col-md-12 col-xs-4  text-center p-0">
                        <a href="{{  url('profile/'.$profile->id.'/proposal/reject') }}" class="cancel-invitation text-danger" title="cancel invitation" {{ !Auth::user()->isSentProposal($profile->id) ? 'data-is_cancel =1' : Null}} > <i class="far fa-times-circle fa-3x"></i></a>
                    </div>
                </div>
            </div>
        </div>    
    @endforeach
    
    @if( count($profiles) > 0 )
        <div class="col-sm-12 text-center">
            {!! $profiles->links() !!}
        </div>
    @else
        <div class="col-xs-12 text-center botder-top" style="padding-top: 50px;">
            <h2 class="text-danger"> <i class="far fa-frown"></i> Sorry!  No Match Found</h2>
        </div>
    @endif
    
</div>

