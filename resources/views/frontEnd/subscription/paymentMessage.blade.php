@extends('frontEnd.masterPage')

@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @if( Session::has('status') )
                <div class="panel {{ Session::get('status') ? 'panel-success' : 'panel-danger' }}">
                    <div class="panel-heading">
                        <h4>Package Subscription Notification</h4>
                    </div>
                    <div class="panel-body text-center {{ Session::get('status') ? 'text-success' : 'text-danger' }}">
                        @if(Session::get('status'))
                            <p> <span class="fa fa-check-circle-o fa-3x"></span></p>
                            <h3>Congratulation!</h3>
                            <p>{{ Session::get('message') }}</p>
                            <p>Total Paid Amount : {{ number_format(Session::get('amount')) }}</p>
                            <p> Your Payment Transaction ID : {{ Session::get('tran_id') }} </p>
                        @else                            
                            <span class="fa fa-times-circle fa-3x"></span>
                            <h3>Sorry!</h3>
                            <p>{{ Session::get('message') }}</p>
                        @endif
                        <a href="{{ url('/home') }}" class="btn btn-warning mt-5">Back To Dashboard</a>
                    </div>
                </div>
                @else
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4>Package Subscription Notification</h4>
                        </div>
                        <div class="panel-body text-center text-danger">
                            <span class="fa fa-times-circle fa-3x"></span>
                            <h3>Sorry!</h3>
                            <p>Try to direct access</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
