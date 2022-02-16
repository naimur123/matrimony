<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ isset($data->id) ? 'Edit Testimonial' : 'Add Testimonial' }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['route'=>'testimonial.create', 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
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
                        <label>Image <span class="text-danger"> {{ isset($data->id) ? Null : '*' }} </span> </label><br>
                        <input type="file" name="image_path" accept="image/png,image/jpeg" {{ isset($data->id) ? Null : 'required' }} >
                    </div>
                </div> 

                 <!-- SEO Tag -->
                 <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Meta Tag </label>
                        <input type="text" placeholder="Meta Tag" name="meta_tag" value="{{ isset($data->id) ? $data->meta_tag : Null }}" class="form-control" >
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Meta Description </label>
                        <input type="text" placeholder="Meta Description" name="meta_description" value="{{ isset($data->id) ? $data->meta_description : Null }}" class="form-control" >
                    </div>
                </div> 
                
                <!-- Description -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Description </label>
                        <textarea class="form-control editor" name="description" style="min-height:200px">{{ isset($data->id) ? $data->description : Null }}</textarea>
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
    ClassicEditor.create( document.querySelector( '.editor' ) );
</script>