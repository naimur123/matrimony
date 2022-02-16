@extends('frontEnd.masterPage')
@section('title')
    Blog Post || 
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
            @foreach($blogs as $blog)
                <div class="col-sm-12">
                    <div class="thumbnail">                        
                        <div class="caption">
                            <div class="row">
                                <div class="col-xs-3 col-sm-2">
                                    <a href="{{ url('/blog/view-post/'.$blog->slug) }}">
                                        <img src="{{ asset($blog->image_path) }}" >
                                    </a>
                                </div>
                                <div class="col-xs-9 col-sm-10">
                                    <h3>
                                        <a href="{{ url('/blog/view-post/'.$blog->slug) }}"> {{ $blog->title }} </a><small style="font-size: 12px;">{{ Carbon\Carbon::parse($blog->created_at)->format('d-M, Y') }}</small>
                                    </h3>
                                    <p>
                                        {!! substr($blog->description, 0, 350) !!}                                  
                                    </p> 
                                    <a href="{{ url('/blog/view-post/'.$blog->slug) }}">Read More</a> 
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-12 text-right">{!! $blogs->links() !!}</div>
        </div>
    </div>
</div>
@endsection