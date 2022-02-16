<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ isset($data->id) ? 'Edit news' : 'Add news' }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['route'=>'package.create', 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="slug" value="{{ isset($data->id) ? $data->slug : 0 }}" >

                <!-- title -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Title" name="title" value="{{ isset($data->id) ? $data->title : Null }}" class="form-control" required >
                    </div>
                </div>   

                <!-- Duration -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Duration <span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Duration" name="duration" value="{{ isset($data->id) ? $data->duration : 30 }}" class="form-control" required >
                    </div>
                </div>  
                <!-- Duration Type -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Duration Type <span class="text-danger">*</span></label>
                        <select name="duration_type" class="form-control" required >
                            <option value="">Select Duration</option>
                            <option value="day" {{ isset($data->duration_type) && $data->duration_type == "day" ? 'selected' : Null }} >Day</option>
                            <option value="month" {{ isset($data->duration_type) && $data->duration_type == "month" ? 'selected' : Null }} >Month</option>
                            <option value="year" {{ isset($data->duration_type) && $data->duration_type == "year" ? 'selected' : Null }} >Year</option>
                        </select>     
                    </div>
                </div>

                <!-- Contact Details  -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>View Contact Details<span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Profile View" name="profile_view" value="{{ isset($data->id) ? $data->profile_view : 100 }}" class="form-control"  >
                    </div>
                </div>

                <!-- Show  Contact Details  -->
                <div class="col-12 col-sm-12 col-md-4 d-none">
                    <div class="form-group">
                        <label>Show Contact Details<span class="text-danger">*</span></label>
                        <select name="contact_details" class="form-control" required >
                            <option value="">Show Contact Details</option>
                            <option value="yes" selected >Yes</option>
                            <option value="no"  >No</option>
                        </select>   
                    </div>
                </div>

                <!-- Total Proposal  -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Total Proposal Limit <span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Total Proposal Limit" name="total_proposal" value="{{ isset($data->id) ? $data->total_proposal : 10000000 }}" class="form-control"  >
                    </div>
                </div>

                <!-- Total Daily Proposal  -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Total Daily Proposal Limit <span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Total Daily Proposal Limit" name="daily_proposal" value="{{ isset($data->id) ? $data->daily_proposal : 1000}}" class="form-control"  >
                    </div>
                </div>

                <!-- Block Profile -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Profile Block Avaibility<span class="text-danger">*</span></label>
                        <select name="block_profile" class="form-control" required >
                            <option value="">Select Profile Block Avaibility</option>
                            <option value="yes" {{ isset($data->block_profile) && $data->block_profile == "yes" ? 'selected' : Null }} >Yes</option>
                            <option value="no" {{ isset($data->block_profile) && $data->block_profile == "no" ? 'selected' : Null }} >No</option>
                        </select>   
                    </div>
                </div>

                <!-- Accept Proposal  -->
                <div class="col-12 col-sm-12 col-md-4 d-none">
                    <div class="form-group">
                        <label>Accept Proposal Limit<span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Accept Proposal Limit" name="accept_proposal" value="{{ isset($data->id) ? $data->accept_proposal : 10000000 }}" class="form-control"  >
                    </div>
                </div>                

                <!-- post photo  -->
                <div class="col-12 col-sm-12 col-md-4 d-none">
                    <div class="form-group">
                        <label>Total Post Photo Limit<span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Total Post Photo Limit" name="post_photo" value="{{ isset($data->id) ? $data->post_photo : 10000000 }}" class="form-control"  >
                    </div>
                </div>

                <div class="col-12"> <hr> </div>
                <!-- regular Fee  -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Regular Fee<span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Regular Fee" name="regular_fee" value="{{ isset($data->id) ? $data->regular_fee : 100 }}" class="form-control regular_fee"  >
                    </div>
                </div>
                <!-- Current Fee  -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Current Fee<span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Current Fee" name="current_fee" value="{{ isset($data->id) ? $data->current_fee : 80 }}" class="form-control current_fee"  >
                    </div>
                </div>
                <!-- Discount  -->
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Discount Persent<span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="Discount Persent" name="discount_percentage" value="{{ isset($data->id) ? $data->discount_percentage : 20 }}" class="form-control discount_percentage"  >
                    </div>
                </div>

                <!-- Status -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required >
                            <option value="">Status</option>
                            <option value="published" {{ isset($data->status) && $data->status == "published" ? 'selected' : Null }} >Published</option>
                            <option value="unpublished" {{ isset($data->status) && $data->status == "unpublished" ? 'selected' : Null }} >Unpublished</option>
                        </select>     
                    </div>
                </div>   
                
                <!-- Image -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group"> 
                        <label>Image <span class="text-danger"> </span> </label><br>
                        <input type="file" name="image_path" accept="image/png,image/jpeg" >
                    </div>
                </div> 
                
                <!-- Description -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Description </label>
                        <textarea class="form-control" name="description" style="min-height:200px">{{ isset($data->id) ? $data->description : Null }}</textarea>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <label>Uploading</label>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"> 0% </div>
                      </div>
                </div>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Save </button>
            </div>
        </div>
    {!! Form::close() !!}
</div>

<script>
    $(document).on('keyup','.regular_fee, .current_fee', function(){
        let regular_fee = parseFloat( $('.regular_fee').val() );
        let current_fee = parseFloat( $('.current_fee').val());
        let persent = ((regular_fee - current_fee) / regular_fee ) * 100
        $('.discount_percentage').val( persent.toFixed(2) );
    });

    $(document).on('change','.regular_fee, .current_fee', function(){
        let regular_fee = parseFloat( $('.regular_fee').val() );
        let current_fee = parseFloat( $('.current_fee').val());
        let persent = ((regular_fee - current_fee) / regular_fee ) * 100
        $('.discount_percentage').val( persent.toFixed(2) );
    });

</script>