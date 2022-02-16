@extends('frontEnd.masterPage')
@section('title')
    Our Services ||
@stop
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
                <li class="current-page">Our Services</li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
          <div class="col-sm-12"><h2 class="text-center">Our Services</h2></div>
        </div>
        <div class="row" style="margin-top: 30px;">
          @foreach($ourServices as $service)
            <div class="col-sm-4 text-center" style="margin-top: 15px;">
                <div class="circle-box" >
                  <a href="javascript:;" class="text-info" > 
                    <img src="{{ asset('service'.$loop->iteration.'.png') }}" class="img-responsive img-thumbnail img-circle" >
                  </a>
                </div>
                <br>
                <a href="javascript:;" class="fa-lg text-info"> {{ $service->title }} </a>
                <p>{{ substr($service->description, 0, 150) }}</p>
            </div>
          @endforeach
          <div class="col-xs-12 text-right" style="margin-top: 20px;">
             {!! $ourServices->links() !!}
          </div>
        </div>
      </div>
</div>
@endsection