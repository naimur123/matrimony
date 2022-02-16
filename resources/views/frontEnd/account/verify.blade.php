@extends('frontEnd.masterPage')
@section('mainPart')
    <div class="grid_3">
        <div class="container">            
            <div class="services">
                <div class="col-sm-12 col-md-12">
                    <div class="breadcrumb1">
                        <ul>
                            <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                            <span class="divider">&nbsp;|&nbsp;</span>                            
                            <li class="current-page"><i class="fa fa-check-circle"></i> Email Verify</li>
                        </ul>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Email Verification</h4>
                        </div>
                        <div class="panel-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif
                            {{ __('Before proceeding, please check your email for a verification link. Also you check your spam folder.') }}
                            {{ __('If you did not receive the email') }},
                            
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                            </form>
                        </div>
                    </div>                    
                </div>                
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
@endsection