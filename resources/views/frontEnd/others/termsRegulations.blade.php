@extends('frontEnd.masterPage')
@section('title')
    Terms & Regulation ||
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">Terms & Regulation</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($termsRegulations as $regulation)              
                <div class="col-xs-12" style="margin-top: 15px;">
                    <div class="caption">
                        <h3>{{ $regulation->title }}</h3>                  
                        <p>{!! $regulation->description !!} </p>                        
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>
</div>
@endsection