@extends('frontEnd.masterPage')
@section('title')
    FAQ ||
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">FAQ</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8" style="margin-top: 15px;">
                <h3>FAQ</h3>                     
                <p> </p> 
            </div>
        </div>
    </div>
</div>
@endsection