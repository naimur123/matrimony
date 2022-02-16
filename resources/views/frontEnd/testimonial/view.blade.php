@extends('frontEnd.masterPage')
@section('title')
    {{ $testimonial->title }} ||
@stop
@section('seo')
    <meta name="Description" content= "{{ $testimonial->meta_description }}" >
    <meta name="Keywords" content="{{ $testimonial->meta_tag }}" >
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">Testimonial || {{ $testimonial->title }}</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4" style="margin-top: 15px;">
                <img src="{{ asset($testimonial->image_path) }}"  class="img-responsive">
            </div>
            <div class="col-xs-12 col-sm-8" style="margin-top: 15px;">
                <h3>
                    {{ $testimonial->title }} <small style="font-size: 12px;">{{ Carbon\Carbon::parse($testimonial->created_at)->format('d-M, Y') }}</small>
                </h3>                
                <p>
                    {!! $testimonial->description !!}                                  
                </p> 
            </div>
        </div>
    </div>
</div>
@endsection