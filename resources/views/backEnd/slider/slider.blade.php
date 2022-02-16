@extends('backEnd.masterPage')
@section('mainPart')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card-default">                
                <div class="row">
                    <div class="col-7 col-md-8">
                        Slider List
                    </div>
                    <div class="col-5 col-md-4 text-right">
                        <a href="{{ url('slider/create') }}" class="ajax-click-page btn btn-sm btn-info">Add Slider</a>
                    </div>
                </div> 
            </div>        
            <div class="card-body table-responsive">           
                <table class="table table-striped" id="table">
                    <thead class="bg-primary">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Text</th>
                            <th>Position</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr> 
                    </thead>                             
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var table;
    $(function() {         
        // Load Data via datatable
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ URL::current() }}',
            columns: [
                { data: 'index', name: 'index' },
                { data: 'image', name: 'image' },
                { data: 'text', name: 'text' },
                { data: 'position', name: 'position' },
                { data: 'url', name: 'url' },
                { data: 'publicationStatus', name: 'publicationStatus' },
                { data: 'action', name: 'action' }
            ],
            "lengthMenu": [[25, 50, 100, 500,1000, -1], [25, 50, 100, 500,1000, "All"]],
            "order": [[ 1, "ASC" ]] 
        });  
    });
</script>

@endsection

