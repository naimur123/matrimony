@extends('backEnd.masterPage')
@section('mainPart')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card-default">
                <div class="row">
                    <div class="col-6">Subscriber List</div>
                    <div class="col-6 text-right">                        
                        <a href="{{url('newslatter/subscribe/send-message')}}" class="btn btn-info btn-sm">Group Message</a>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="newslater" class="table table-striped ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country Code</th>
                            <th>IP</th>
                            <th>Browser</th>
                            <th>Device</th>
                            <th>OS</th>
                            <th>Date Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
    $(function() {         
        // Load Data via datatable
        $('#newslater').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{url()->current()}}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'countryCode', name: 'countryCode' },
                { data: 'ip', name: 'ip' },
                { data: 'browser', name: 'browser' },
                { data: 'device', name: 'device' },
                { data: 'os', name: 'os' },
                { data: 'created_at', name: 'created_at'},
                { data: 'action', name: 'action' }
            ],
            "lengthMenu": [[25, 50, 100, 500,1000, -1], [25, 50, 100, 500,1000, "All"]]
        }); 
    });        
    
</script>
@endsection

