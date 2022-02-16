@extends('frontEnd.masterPage')
@section('title')
    {{ $blog->title }} ||
@stop
@section('seo')
    <meta name="Description" content= "{{ $blog->meta_description }}" >
    <meta name="Keywords" content="{{ $blog->meta_tag }}" >
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">Blog Post</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4" style="margin-top: 15px;">
                <img src="{{ asset($blog->image_path) }}"  class="img-responsive img-thumbnail">
            </div>
            <div class="col-xs-12 col-sm-8" style="margin-top: 15px;">
                <h3>
                    {{ $blog->title }} <small style="font-size: 12px;">{{ Carbon\Carbon::parse($blog->created_at)->format('d-M, Y') }}</small>
                </h3>                
                <p>
                    {!! $blog->description !!}                                  
                </p> 
            </div>

            <div class="col-xs-12 text-right">
                <div class="fb-share-button"  data-href="{{ URL::current() }}" data-layout="button_count"> </div>
                {{-- <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ URL::current() }}"> </a> --}}
            </div>
        </div>
    </div>
</div>

<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
</script>
@endsection