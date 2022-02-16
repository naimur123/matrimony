@extends('frontEnd.masterPage')
@section('style')
    <style>
        .box-effect{border:1px solid #ddd; border-radius: 5px; padding: 10px 15px;margin:0px;}
        .box-effect:hover{ background: rgb(250, 235, 204);cursor: pointer;}
        .mt-20{margin-top: 20px;}
        .time-stamp{font-size: 12px; color:#aaa;}
        .btn{border-radius: 0px;}
    </style>
@stop
@section('mainPart')

<!-- Available Subscription Packages -->
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">Notifications</li>
            </ul>
        </div>
    </div>
    <div class="container">       
        <div class="row">
            <div class="col-sm-10 col-md-9">
                @forelse($notifications as $notification)
                    <div class="row mt-20 box-effect">
                        <div class="col-xs-3 col-sm-2">
                            <a href="{{ url('profile/'.$notification->notificationFrom->id.'/'.$notification->notificationFrom->first_name.'/view') }}" >
                                <img src="{{ isset($notification->notificationFrom->profilePic->image_path) && file_exists($notification->notificationFrom->profilePic->image_path) ? asset($notification->notificationFrom->profilePic->image_path) : asset('dummy-user.png') }}" class="img-circle" width="40">
                            </a>
                        </div>
                        <div class="col-xs-9 col-sm-6">
                            {{ $notification->notification }}
                            <p class="time-stamp">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</p>
                        </div>
                        @if( !is_null($notification->proposal) )
                            <div class="col-xs-12 col-sm-4 text-right">
                                @if($notification->proposal->status == "pending")
                                    <a href="{{ url('proposal/'.$notification->proposal->id.'/accept') }}" class="btn btn-primary ajax-click" >Accept</a>
                                    <a href="{{ url('proposal/'.$notification->proposal->id.'/reject') }}" class="btn btn-danger ajax-click" >Reject</a>
                                @elseif($notification->proposal->status == "accept")
                                    <button type="button" class="btn btn-success">Accepted</button>                                    
                                @else
                                    <button type="button" class="btn btn-danger">Rejected</button>                                    
                                @endif                                
                            </div>
                        @endif
                    </div>
                @empty
                <div class="col-sm-10 col-md-9 text-center">
                    <h3 class="text-danger">No Data Found</h3>
                </div>
                @endforelse 
                <div class="row mt-20">
                    <div class="col-sm-12 text-center">
                        {{ $notifications->links() }}
                    </div>
                </div> 
            </div>

            <div class="col-sm-2 col-md-3 chatting-section">
                <h3> Online </h3>
                <hr/>
                @include('frontEnd.chatting.chat')
            </div>
        </div>     
    </div>
</div>
@endsection