@extends('frontEnd.masterPage')
@section('title')
    Testimonial ||
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">Testimonial</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($testimonials as $testimonial)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{ asset($testimonial->image_path) }}" style="height:200px;">
                        <div class="caption" >
                            <h4 style="height: 40px;">{{ $testimonial->title }}</h4>
                            <p >{!! substr($testimonial->description, 0,150) !!}</p> 
                            <a href="{{ url('testimonial/view-testimonial/'.$testimonial->slug) }}">Read More</a>                           
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-12 text-right">{!! $testimonials->links() !!}</div>
        </div>
    </div>
</div>
@endsection