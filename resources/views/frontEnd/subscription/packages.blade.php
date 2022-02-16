@extends('frontEnd.masterPage')
@section('style')
    <style>
        .pricing-table-grid li{padding: 10px 0; display: block; text-decoration: none; font-size: 0.85em; color: #555;}
        .pricing-table {padding-left: 0; box-shadow: 2px 4px 15px #999; border-radius: 5px; border:1px solid transparent;margin-top:15px;}
        .pricing-table-grid, .pricing-table-grid:hover{ border: none;}
        .pricing-table:hover{border:1px solid #428bca;}
        .pricing-heading{background: #ffa417; padding-top: 12px !important; padding-bottom: 12px !important ; width: 100%;color:#fff !important;}
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
                <li class="current-page">Our Packages</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @foreach($packages as $package)
                <div class="col-sm-6 col-md-4 col-lg-3 text-center">
                    <div class="pricing-table">
                    <div class="pricing-table-grid">
                        <h3 class="pricing-heading bg-primary">{{ $package->title }}</h3>
                        <h3><span class="dollar">{{ $system->currency}}.</span> {{number_format($package->current_fee)}}<br></h3>
                        <ul>
                            <li> <img src="{{ file_exists($package->image_path) ? asset($package->image_path) : asset('image-not-found.png') }}" class="img-responsive" style="height:200px;"> </li>
                      <li><i class="fa fa-check-square icon_3"></i> Duration ({{ $package->duration }} {{ ucfirst($package->duration_type.'s') }})</li>
                      <li> <i class="fa fa-eye icon_3"></i> Profile View (Unlimited) </li>
                      <li> <i class="fa fa-envelope icon_3"></i>Send Unlimited Message</li>
                      <li> <i class="fas fa-location-arrow"></i> Total Proposal ({{ $package->total_proposal }}) </li>
                      <li> <i class="fas fa-reply-all"></i> Total Daily Proposal ({{ $package->daily_proposal }}) </li>
                      <li> <i class="fa fa-user icon_3"></i> View Contact Details ({{ $package->profile_view }}) </li>
                            {{-- <li> <i class="fa fa-download icon_3"></i>Download Biodata (Unlimited)</li> --}}
                        </ul>
                        @if( Auth::user() )
                            <a class="btn btn-primary" href="{{ route('subscription.confirm', ['id' => $package->id]) }}">Subscribe</a>
                        @endif
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
    </div>
</div>
@endsection