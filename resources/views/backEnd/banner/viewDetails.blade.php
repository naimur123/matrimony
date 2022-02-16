<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $data->name }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row">        
        <div class="col-6 row">
            <div class="col-12 col-md-4 "> Email </div>
            <div class="col-12 col-md-8 "> {{ $data->email }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-4 "> Phone Number </div>
            <div class="col-12 col-md-8 "> {{ $data->phone }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-4"> Access Type </div>
            <div class="col-12 col-md-8"> {{ ucfirst(str_replace('_', ' ', $data->user_type)) }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-4"> Status </div>
            <div class="col-12 col-md-8"> {{ $data->deleted_at ? 'Deleted' : 'Active' }}</div>
        </div>

        <div class="col-12"> <hr> </div>
        <div class="col-6 row">
            <div class="col-12 col-md-4 "> Created By </div>
            <div class="col-12 col-md-8 "> {{ $data->created_by }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-4"> Created At </div>
            <div class="col-12 col-md-8"> {{ Carbon\carbon::parse($data->created_at)->format($system->date_format) }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-4 "> Updated By </div>
            <div class="col-12 col-md-8 "> {{ $data->modified_by }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-4"> Updated At </div>
            <div class="col-12 col-md-8"> {{ Carbon\carbon::parse($data->updated_at)->format($system->date_format) }}</div>
        </div>

    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>