@extends('frontEnd.masterPage')
@section('style')
    <style>
        .instruction-text{font-weight: bold;font-size: 18px; text-align: left}
    </style>
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center"><b>Instructions</b></h2>
            <div class="instruction-text">
                <b>Dear {{ Auth::user()->first_name .' '. Auth::user()->last_name}},</b>
                @if(!Auth::user()->user_status)
                    Your Profile is not approve yet. Admin will verify within <b>24</b> hours after <b>100%</b> complete your profile. Now your profile is {{ $profile_complete }}% Complete. 
                    <br><br>
                @endif
                You are using Free subscription Plan. To skip profile approval step, view contact cetails, send message & connect with others, upgrade your membership.
                <br><br>

                1. Free user members can profile view <br>
                2. Free user members can't text message <br>
                3. Free user members can't see contact details of partner<br>
                4. Free user members can't accept partner request<br>
                Hot line number: +880 1722 063276
            </div>
            <div style="margin: 30px; 0px;" >
                <a class="btn btn-danger" href="{{ url('/home') }}">Cancel</a>
                <a class="btn btn-primary" href="{{ url('/our-service') }}">Our service</a>
                <a class="btn btn-info" href="{{ url('/account/membership/upgrade') }}">Subscription</a>
            </div>
        </div>
    </div>  
@endsection