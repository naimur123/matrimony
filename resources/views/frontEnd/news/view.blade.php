@extends('frontEnd.masterPage')
@section('title')
    {{ $news->title }} ||
@stop
@section('seo')
    <meta name="Description" content= "{{ $news->meta_description }}" >
    <meta name="Keywords" content="{{ $news->meta_tag }}" >
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">News | {{ $news->title }}</li> 
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4" style="margin-top: 15px;">
                <img src="{{ asset($news->image_path) }}"  class="img-responsive img-thumbnail">
            </div>
            <div class="col-xs-12 col-sm-8" style="margin-top: 15px;">
                <h3>
                    {{ $news->title }} <small style="font-size: 12px;">{{ Carbon\Carbon::parse($news->created_at)->format('d-M, Y') }}</small>
                </h3>                
                <p>
                    {!! $news->description !!}                                  
                </p> 
            </div>
        </div>
    </div>
</div>
@endsection