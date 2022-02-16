@extends('frontEnd.masterPage')
@section('style')
    <style>
        .circle-box{height: 100px;width:100px; background: #007bff; border-radius: 150px;margin:0px auto;}
    </style>
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">Gallery</li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
          <div class="col-sm-12"><h2>Gallery View</h2></div>
        </div>
        <div class="row" style="margin-top: 30px;">
          @foreach($galleries as $gallery)
            <div class="col-sm-6 col-md-4" style="margin-top: 15px;">
                <div class="gallery-box" >
                    <img src="{{ asset($gallery->image_path) }}" class="img-responsive" title="{{$gallery->title}}">
                </div>
            </div>
          @endforeach
          <div class="col-xs-12 text-right" style="margin-top: 20px;">
             {!! $galleries->links() !!}
          </div>
        </div>
      </div>
</div>
@endsection