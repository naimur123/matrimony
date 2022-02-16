@extends('backEnd.masterPage')
@section('mainPart')

<!-- task, page, download counter  start -->
<div class="row">
    <!-- first Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6 ">
        <div class="card bg-c-yellow update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $today_register }}</h4>
                        <h6 class="text-white m-b-0">Today Registered</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418263"></iframe>
                        <canvas id="update-chart-1" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('report.user',['type'=>'today_register']) }}">Today Register</a>
            </div>
        </div>
    </div>
    <!-- first Block End-->
    <!-- Second Block Start-->
     
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card bg-c-green update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $total_register }}</h4>
                        <h6 class="text-white m-b-0">Total Registered</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('report.user',['type'=>'total_register']) }}"> Total Registered</a>
            </div>
        </div>
    </div>
    
    <!-- Second Block End-->
    <!-- Third Block End-->
    
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card bg-c-pink update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $today_visit }}</h4>
                        <h6 class="text-white m-b-0">Today Page Visit</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="#"> Today Page Visit</a>
            </div>
        </div>
    </div>
    
    <!-- Third Block End-->
    <!-- Fourth Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-lite-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $total_monthly_visit }}</h4>
                        <h6 class="text-white m-b-0">Monthly Page Views</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Current Month Views</p>
            </div>
        </div>
    </div> 
    
    <!-- %5h Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-yellow">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $today_pending_payment }}</h4>
                        <h6 class="text-white m-b-0">Today Pending Payment Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('report.payment',['type'=>'today-pending-payment']) }}">Today Pending Payment</a>
            </div>
        </div>
    </div> 

    <!-- 6h Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $monthly_pending_payment }}</h4>
                        <h6 class="text-white m-b-0">Monthly Pending Payment Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('report.payment',['type'=>'monthly-pending-payment'])}}">Monthly Pending Payments</a>
            </div>
        </div>
    </div> 

    <!-- 7h Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-pink">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $all_pending_payment }}</h4>
                        <h6 class="text-white m-b-0">All Pending Payment Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('report.payment',['type'=>'all-pending-payment'])}}">All Pending Payments</a>
            </div>
        </div>
    </div> 

    <!-- 8h Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-lite-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $today_paid_payment }}</h4>
                        <h6 class="text-white m-b-0">Today Paid Payment Amount</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('report.payment',['type'=>'today-paid-payment'])}}">Today Paid Payment</a>
            </div>
        </div>
    </div> 

    <!-- 8h Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-yellow">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $monthly_paid_payment }}</h4>
                        <h6 class="text-white m-b-0">Monthly Paid Payment Amount</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('report.payment',['type'=>'monthly-paid-payment'])}}">Monthly Paid Payment</a>
            </div>
        </div>
    </div> 

    <!-- 9h Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $all_paid_payment }}</h4>
                        <h6 class="text-white m-b-0">All Paid Payment Amount</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('report.payment',['type'=>'all-paid-payment'])}}">All Paid Payment</a>
            </div>
        </div>
    </div> 

    <!-- 10h Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-pink">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $all_subscribe_users }}</h4>
                        <h6 class="text-white m-b-0">Total Subscribe Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>
                    {{-- <a href="{{ route('report.user',['type'=>'total-subscribe-users']) }}">Views List</a> --}}
                    <a href="#">Views List</a>
                </p>
            </div>
        </div>
    </div> 

    <!-- 11h Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $all_male_users }}</h4>
                        <h6 class="text-white m-b-0">Total Male Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>
                    <a href="{{ route('report.user',['type'=>'male']) }}">Views List</a>
                </p>
            </div>
        </div>
    </div> 

    <!-- 12th Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-pink">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $all_female_users }}</h4>
                        <h6 class="text-white m-b-0">Total Female Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>
                    <a href="{{ route('report.user',['type'=>'female']) }}">Views List</a>
                </p>
            </div>
        </div>
    </div> 

    <!-- 13th Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-yellow">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $verified_users }}</h4>
                        <h6 class="text-white m-b-0">Total Verified Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>
                    <a href="{{ route('report.user',['type'=>'verified']) }}">Views List</a>
                </p>
            </div>
        </div>
    </div> 

    <!-- 14th Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $unverified_users }}</h4>
                        <h6 class="text-white m-b-0">Total Unverified Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>
                    <a href="{{ route('report.user',['type'=>'unverified']) }}">Views List</a>
                </p>
            </div>
        </div>
    </div> 

    <!-- 15th Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $incomplete_users }}</h4>
                        <h6 class="text-white m-b-0">Total Incomplete Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Views List</p>
            </div>
        </div>
    </div> 

    <!-- 16th Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $active_users }}</h4>
                        <h6 class="text-white m-b-0">Total Active Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>
                    <a href="{{ route('report.user',['type'=>'active']) }}">Views List</a>
                </p>
            </div>
        </div>
    </div> 

    <!-- 17th Block Start-->
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card update-card bg-c-green">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">{{ $deactive_users }}</h4>
                        <h6 class="text-white m-b-0">Total Deactive Users</h6>
                    </div>
                    <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                        <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>
                    <a href="{{ route('report.user',['type'=>'deactive']) }}">Views List</a>
                </p>
            </div>
        </div>
    </div> 

</div>

<div class="row">
    <div class="col-sm-12">
        <h3>Subscribe Package & Debscribe Details</h3>
    </div>
    @foreach($subscribtion_packages as $package)
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card update-card bg-c-yellow">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ $package->title }}</h4>
                            <h6 class="text-white m-b-0">
                                {{ $package->subscribeUsers->count() }} <span style="font-size:14px;" >User Subscribed</span> 
                            </h6>
                        </div>
                        <div class="col-4 text-right">
                            <iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Views List</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Visitor Monthly Summary Country Based -->
<div class="row">
    <div class="col-sm-12">
        <div class="card-body">
            <h3>Website Visitor Country Based Summary</h3>
        </div>        
    </div>
    <div class="col-sm-12">
        <div class="card-body">
            <div class="dt-plugin-buttons"></div>
            <div class="dt-responsive table-responsive">
                <table id="table2" class="table table-striped table-bordered nowrap">
                    <thead class="{{ isset($tableStyleClass) ? $tableStyleClass : 'bg-primary'}}">
                        <tr>
                            @foreach($tableColumns2 as $column)
                                <th> @lang('table.'.$column)</th>
                            @endforeach                                
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--All Visitor Summary -->
<div class="row">
    <div class="col-sm-12">
        <div class="card-body">
            <h3>Website Visitor List</h3>
        </div>        
    </div>
    <div class="col-sm-12">        
        <div class="card-body">
            <div class="dt-plugin-buttons"></div>
            <div class="dt-responsive table-responsive">
                <table id="table" class="table table-striped table-bordered nowrap">
                    <thead class="{{ isset($tableStyleClass) ? $tableStyleClass : 'bg-primary'}}">
                        <tr>
                            @foreach($tableColumns as $column)
                                <th> @lang('table.'.$column)</th>
                            @endforeach                                
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let table;
    $(function() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ isset($dataTableUrl) && !empty($dataTableUrl) ? $dataTableUrl : URL::current() }}',
            columns: [
                @foreach($dataTableColumns as $column)
                    { data: '{{ $column }}', name: '{{ $column }}' },
                @endforeach                
            ],
            "lengthMenu": [[25, 50, 100, 500,1000, -1], [25, 50, 100, 500,1000, "All"]],
        });

        $('#table2').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ isset($dataTableUrl2) && !empty($dataTableUrl2) ? $dataTableUrl2 : URL::current() }}',
            columns: [
                @foreach($dataTableColumns2 as $column)
                    { data: '{{ $column }}', name: '{{ $column }}' },
                @endforeach                
            ],
            "lengthMenu": [[25, 50, 100, 500,1000, -1], [25, 50, 100, 500,1000, "All"]],
        });

        
    });
</script>
@endsection
