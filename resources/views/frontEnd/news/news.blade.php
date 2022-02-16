@extends('frontEnd.masterPage')
@section('title')
    News ||
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">News</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($newses as $news)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail"> 
                        <a href="{{ url('/news/view-news/'.$news->slug) }}">
                            <img src="{{ asset($news->image_path) }}" style="height:200px;" >
                        </a>                       
                        <div class="caption">
                            <h4 style="height: 40px;">{{ $news->title }}</h4>
                            <p> {!! substr($news->description, 0, 150) !!} </p> 
                            <a href="{{ url('/news/view-news/'.$news->slug) }}">Read More</a>                        
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-12 text-right">{!! $newses->links() !!}</div>
        </div>
    </div>
</div>
@endsection