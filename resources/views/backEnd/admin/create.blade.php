<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ isset($data->id) ? 'Edit Admin' : 'Add Admin' }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['route'=>'admin.create', 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <!-- First Name -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span> </label>
                        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >                                
                        <input type="text" placeholder="your First Name" name="name" value="{{ isset($data->id) ? $data->name : Null }}" class="form-control" required >
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <!-- Email -->
                <div class="col-12 col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span> </label>
                        <input type="email" placeholder="example@gmail.com" name="email" value="{{ isset($data->id) ? $data->email : Null }}" class="form-control" required >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> 

                <!-- Address -->
                <div class="col-12 col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Address </label>
                        <input type="text" placeholder="your Address Here" value="{{ isset($data->id) ? $data->address : Null }}" name="address" class="form-control"  >
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> 

                <!-- Phone -->
                <div class="col-6 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Phone </label>
                        <input type="text" placeholder="Phone" value="{{ isset($data->id) ? $data->phone : Null }}" name="phone" class="form-control" >
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> 

                <!-- Country -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Access Type <span class="text-danger">*</span></label>
                        <select name="user_type" class="form-control" required >
                            <option value="">Select Access Type</option>
                            <option value="super_admin" {{ isset($data->user_type) && $data->user_type == "super_admin" ? 'selected' : Null }} >Super admin</option>
                            <option value="admin" {{ isset($data->user_type) && $data->user_type == "admin" ? 'selected' : Null }} >Admin</option>
                        </select>     
                    </div>
                </div>   

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Password <span class="text-danger">{{ isset($data->id) ? Null : '*' }}</span></label>                                
                        <input id="password" type="password"  placeholder="Password" class="form-control is-invalid" name="password" autocomplete="off" {{ isset($data->id) ? Null : 'required'}}>                                
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>                        
                </div>
                
                <!-- Profile Image -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group"> 
                        <label>Image</label><br>
                        <input type="file" name="image" accept="image/png,image/jpeg" >
                    </div>
                </div>  

                <div class="col-12 col-sm-6 col-md-3">
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