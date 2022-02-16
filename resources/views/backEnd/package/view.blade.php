<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $data->title }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row">
        <div class="col-12 row mt-2">
            <div class="col-6 col-md-3 font-weight-bold"> Duration </div>
            <div class="col-6 col-md-3 "> {{ $data->duration }} {{ ucfirst($data->duration_type) }}</div>
            <div class="col-6 col-md-3 font-weight-bold"> View Contact</div>
            <div class="col-6 col-md-3 "> {{ ucfirst($data->profile_view) }}</div>
        </div>
        
        <div class="col-12 row mt-2">
            <div class="col-6 col-md-3 font-weight-bold"> Total Proposal Limit</div>
            <div class="col-6 col-md-3 "> {{ $data->total_proposal }}</div>
            <div class="col-6 col-md-3 font-weight-bold"> Daily Proposal Limit </div>
            <div class="col-6 col-md-3 ">  {{ $data->daily_proposal }}</div>            
        </div>
        {{-- <div class="col-12 row mt-2">
            <div class="col-6 col-md-3 "> Total Proposal Limit </div>
            <div class="col-6 col-md-3 ">  {{ $data->total_send_message }}</div>
            <div class="col-6 col-md-3 font-weight-bold"> Post Photo Limit </div>
            <div class="col-6 col-md-3 ">  {{ $data->post_photo }}</div>           
        </div> --}}
        {{-- <div class="col-12 row mt-2">
            <div class="col-6 col-md-3 "> Accept Proposal Limit </div>
            <div class="col-6 col-md-3 ">  {{ $data->accept_proposal }}</div>
            <div class="col-6 col-md-3 "> Decline proposal Limit</div>
            <div class="col-6 col-md-3 "> {{ $data->decline_proposal }}</div>            
        </div> --}}
        <div class="col-12 row mt-2">
            
            <div class="col-6 col-md-3 font-weight-bold"> Block Profile Avaibility</div>
            <div class="col-6 col-md-3 "> {{ ucfirst($data->block_profile) }}</div>
            <div class="col-6 col-md-3 font-weight-bold"> Discount Percent </div>
            <div class="col-6 col-md-3 ">  {{ $data->discount_percentage }}%</div>
            
        </div>
        <div class="col-12 row mt-2">
            <div class="col-6 col-md-3 font-weight-bold"> Regular Fee</div>
            <div class="col-6 col-md-3 "> {{ number_format($data->regular_fee) }} {{ $system->currency }} </div>            
            <div class="col-6 col-md-3 font-weight-bold"> Current Fee</div>
            <div class="col-6 col-md-3 "> {{ number_format($data->current_fee) }} {{ $system->currency }} </div>            
        </div>

        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Description </div>
            <div class="col-12 col-md-9 "> {{ $data->description }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Image </div>
            <div class="col-12 col-md-9 ">
                <img src="{{ asset($data->image_path) }}" height="200" alt="N/A">
            </div>
        </div>
        

        

        <div class="col-12"> <hr> </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Publication Status </div>
            <div class="col-12 col-md-7"> {{ ucfirst($data->status) }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Status </div>
            <div class="col-12 col-md-7"> {{ $data->deleted_at ? 'Deleted' : 'Active' }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Created By </div>
            <div class="col-12 col-md-7 "> {{ $data->createdBy->name }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Created At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->created_at)->format($system->date_format) }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Updated By </div>
            <div class="col-12 col-md-7 "> {{ empty($data->modified_by) ? 'N/A' : $data->modifiedBy->name }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Updated At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->updated_at)->format($system->date_format) }}</div>
        </div>

    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>