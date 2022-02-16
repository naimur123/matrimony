<!-- Category Modal -->
<div class="modal fade" keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    {{ isset($slider->id) ? 'Edit Slider' : 'Add Slider'}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::Open(['url' => 'slider/create','class' => 'form-horizontal ajax-form','method' => 'POST','files'=>true]) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label>Slider Text</label>
                    <input type="hidden" name="id" value="{{isset($slider->id)?$slider->id:'0'}}">
                    <input type="text" name="text" value="{{isset($slider->id)?$slider->name:''}}" class="form-control" autocomplete="off" autofocus>
                </div>
                <div class="form-group">
                    <label>Link (URL)</label>
                    <input type="text" name="url" value="{{ isset($slider->id) ? $slider->url : Null }}" class="form-control"  placeholder="https://something/something">                          
                </div>
                <div class="form-group">
                    <label>Position</label>
                    <input type="number" name="position" value="{{isset($slider->id)?$slider->position:'0'}}" class="form-control"  placeholder="https://something/something">                          
                </div>
                <div class="form-group">
                    <label>Publication Status</label>
                    <select name="publicationStatus" class="form-control" required >
                        <option value="">Select Status</option>
                        <option value="1" selected >Published</option>
                        <option value="0" {{isset($slider->publicationStatus) && $slider->publicationStatus ==0?'selected':''}}>Unpublished</option>
                    </select>                       
                </div>
                <div class="form-group">
                    <label>Slider Image</label><br>
                    @if(isset($slider->id))
                    <img src="{{asset($slider->image)}}" width="80" ><br><br>
                    @endif
                    <input type="file" name="image" accept="image/png,image/jpeg" {{ !isset($slider->id) ? 'required' : null}} >  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Save </button>
            </div>
          {!! Form::close(); !!}
      </div>
    </div>
  </div>
  
  