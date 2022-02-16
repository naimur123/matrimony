    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center" style="border:none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <img src="{{ isset($system->logo) ? asset($system->logo) : Null }}">
                <h4 class="modal-title">Signup & Find your life partner</h4>
            </div>
            {!! Form::open(['route'=>'register', 'method' => 'post', 'files' => 'true', 'class'=>'ajax-form']) !!}
                <!-- First Page -->
                <div class="page">
                    <div class="modal-body row">            
                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Creating Account<span class="text-danger">*</span> </label>
                            <select name="creating_account" required class="form-control" >
                                <option value ="" >Select Option</option>
                                <option value="self" {{ isset($data->id) && $data->creating_account == 'self' ? 'selected' : Null }} > {{ ucfirst('self') }} </option>
                                <option value="brother" {{ isset($data->id) && $data->creating_account == 'brother' ? 'selected' : Null }} > {{ ucfirst('brother') }} </option>
                                <option value="sister" {{ isset($data->id) && $data->creating_account == 'sister' ? 'selected' : Null }} > {{ ucfirst('sister') }} </option>
                                <option value="friend" {{ isset($data->id) && $data->creating_account == 'friend' ? 'selected' : Null }} > {{ ucfirst('friend') }} </option>
                                <option value="relatives" {{ isset($data->id) && $data->creating_account == 'relatives' ? 'selected' : Null }} > {{ ucfirst('relatives') }} </option>
                                <option value="father" {{ isset($data->id) && $data->creating_account == 'father' ? 'selected' : Null }} > {{ ucfirst('father') }} </option>
                                <option value="mother" {{ isset($data->id) && $data->creating_account == 'mother' ? 'selected' : Null }} > {{ ucfirst('mother') }} </option>
                            </select>
                            @error('creating_account')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label for="edit-name">Email <span class="text-danger" >*</span></label>
                            <input type="email" name="email" id="email" size="60" maxlength="60" class="form-control" required placeholder="something@gmail.com">
                        </div>

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label for="edit-name">Phone <span class="text-danger">*</span></label>
                            <input type="number" name="phone" value="{{ old('phone') }}"  size="20" maxlength="20" class="form-text" placeholder="01*********"  required >
                            @error('phone')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Marital Status<span class="text-danger">*</span> </label>                                                        
                            <select name="marital_status" required class="form-control">
                                <option value="">Select Option</option>
                                @foreach($maritalStatus as $mstatus)
                                    <option value="{{ $mstatus->name }}" > {{ ucfirst($mstatus->name ) }} </option>
                                @endforeach                               
                            </select>
                            @error('marital_status')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Gardian Contact Name -->
                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Gardian Contact Number <span class="form-required text-danger">*</span></label>
                            <input type="number" name="gardian_contact_no" class="form-control" value="{{ old('gardian_contact_no') }}" required placeholder="01*********">
                        </div>

                        <!-- Education Level -->                    
                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Education Lavel <span class="text-danger">*</span> </label>                          
                            <select name="education_level_id" class="form-control" required >
                                <option value="">Select Education</option>
                                @foreach($educations as $education)
                                    <option value="{{ $education->id }}" {{ isset($data->id) && $education->id == $data->education_level_id ? 'selected' : Null }} >{{ ucfirst($education->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-item form-type-password form-item-pass col-sm-6">
                            <label for="edit-pass">Password <span class="form-required text-danger" title="This field is required.">*</span></label>
                            <input type="password" name="password" id="password" size="60" maxlength="128" class="form-text" required placeholder="Your Password" autocomplete="off">
                            @error('password')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-item form-type-password form-item-pass col-sm-6">
                            <label for="edit-pass">Confirm Password <span class="form-required text-danger" title="This field is required.">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" placeholder="Retype your Password">
                        </div>

                        <!-- Looking For -->
                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label for="edit-name">Looking For <span class="form-required text-danger" >*</span></label><br>
                            <label>
                                <input type="radio" name="looking_for" value="bride" > <i class="fa fa-female fa-2x color-female"></i> 
                            </label>
                            <label>
                                <input type="radio" name="looking_for" value="groom"> <i class="fa fa-male fa-2x color-male"></i> 
                            </label> &nbsp; 
                            
                            @error('looking_for')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Gender-->
                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label for="edit-name">Gender <span class="form-required text-danger" >*</span></label><br>
                            <label>
                                <input type="radio" name="gender" value="M" > <i class="fa fa-male fa-2x color-male"></i> 
                            </label> &nbsp; 
                            <label>
                                <input type="radio" name="gender" value="F"> <i class="fa fa-female fa-2x color-female"></i> 
                            </label>
                            @error('gender')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary page-next">Next</button>
                    </div>
                </div>

                <!-- Page end-->
                <div class="page hidden">
                    <div class="modal-body row">
                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label for="edit-name">First Name <span class="form-required text-danger" title="This field is required.">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"  size="60" maxlength="60" class="form-text" placeholder="First Name" required>
                            @error('first_name')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label for="edit-name">Last Name </label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" size="60" maxlength="60" class="form-text" placeholder="Last Name">
                            @error('last_name')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Date Of Birth <span class="form-required text-danger">*</span></label><br>
                            <select name="day" required class="input-group-addon form-control" style="width: 30%; margin-right:2%;">
                                <option value="">Day</option>
                                @for($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" >{{$i}}</option>
                                @endfor
                            </select>
                            <select name="month" required class="input-group-addon form-control" style="width: 30%; margin-right:2%">
                                <option value="">Month</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" >{{ Carbon\Carbon::parse('2020-'.$i.'-01')->format('F') }}</option>
                                @endfor
                            </select>
                            <select name="year" required class="input-group-addon form-control" style="width: 30%">
                                <option value="">Year</option>
                                @for($i = Carbon\Carbon::now()->subYears(18)->format('Y'); $i >= 1950; $i--)
                                    <option value="{{ $i }}" >{{ $i }}</option>
                                @endfor
                            </select>
                            
                        </div>                        

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Country <span class="form-required text-danger">*</span></label>
                            <select name="location_country" class="form-control select2" required >
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->country}}">{{$country->country}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Religion <span class="form-required text-danger">*</span></label>
                            <select name="religious_id" class="form-control religion-select" required >
                                <option value="">Select Religion</option>
                                @foreach($religious as $religion)
                                <option value="{{$religion->id}}">{{$religion->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Religion Cast</label>
                            <select name="religious_cast_id" class="form-control religion-cast" >
                                <option value="">Select Religious Cast</option>                                
                            </select>
                        </div>

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Working Profession</label>                              
                            <select name="career_working_profession_id" class="form-control" >
                                <option value="">Select Profession</option>
                                @foreach($professions as $profession)
                                <option value="{{ $profession->id }}" {{ isset($data->id) && $profession->id == $data->career_working_profession_id ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-item form-type-textfield form-item-name col-sm-6">
                            <label>Organisation Name </label>
                            <input type="text" name="organisation" class="form-control" value="{{ old('organisation') }}" placeholder="working Organisation Name" >
                        </div>

                        <input type="hidden" id="partner_min_age" name="partner_min_age" >
                        <input type="hidden" id="partner_max_age" name="partner_max_age" >
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary page-perv">Previous</button>
                        <button type="submit" class="btn btn-info">Sign up</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $('.page-next').click(function(){
        if( $('select[name="creating_account"]').val() == "" ){
            alert('Creating Account Field Required');
            $('select[name="creating_account"]').addClass('is-invalid');
            $('select[name="creating_account"]').focus();
        }
        else if( $('#email').val() == "" ){
            alert('Email Field Required');
            $('#email').addClass('is-invalid');
            $('#email').focus();
        }
        else if( $('input[name="phone"]').val() == "" ){
            alert('Phone Number Field Required');
            $('input[name="phone"]').addClass('is-invalid');
            $('input[name="phone"]').focus();
        }
        else if( $('select[name="marital_status"]').val() == "" ){
            alert('Marital status Field Required');
            $('select[name="marital_status"]').addClass('is-invalid');
            $('select[name="marital_status"]').focus();
        }
        else if( $('input[name="gardian_contact_no"]').val() == "" ){
            alert('Gardian contact Field Required');
            $('input[name="gardian_contact_no"]').addClass('is-invalid');
            $('input[name="gardian_contact_no"]').focus();
        }
        else if( $('#password').val() == "" ){
            alert('Password is Required');
            $('#password').addClass('is-invalid');
            $('#password').focus();
        }
        else if( $('#password').val() != $('#password_confirmation').val() ){
            console.log($('#password').val(), $('#password_confirmation').val());
            alert('Password is Not Match');
            $('#password').addClass('is-invalid');
            $('#password_confirmation').addClass('is-invalid');
            $('#password').focus();
        }
        else if( !$("input[name='looking_for']").is(":checked") ){
            alert('Looking For Field Required');
        }
        else if( !$("input[name='gender']").is(":checked") ){
            alert('Gender Field Required');
        }        
        else{
            $(this).parents('.page').addClass('hidden');
            $(this).parents('.page').next().removeClass('hidden');
        }
    });
    $('.page-perv').click(function(){
        $(this).parents('.page').addClass('hidden');
        $(this).parents('.page').prev().removeClass('hidden');
    });

    $('.religion-select').on('change', function(){
        let id = $(this).val();
        let old_val = $('.religion-cast').val();
        $.ajax({
            url : "{{ route('religious.cast.get')}}",
            data : { id : id},
            success : function(output){
                let option = `<option value="">Select Option</option>`;
                output.forEach( function(index){           
                    option += `<option value = "`+index.id+`"`;
                    option += index.id == old_val ? `selected` : ``;
                    option += `>` + index.name +`</option>`;
                });
                $('.religion-cast').html(option);
            },error : function(output){
                // console.log(output);
            }
        });
    });

    $('#email').on('change',function(){
        let url = "{{ url('check/unique-email') }}";
        $.ajax({
            url : url,
            data : { email : $('#email').val() },
            success : function(output){
                if( !output.status){
                    alert(output.message);
                    $('#email').addClass('is-invalid');
                    $('#email').focus();
                }else{
                    $('#email').removeClass('is-invalid');
                    $('#email').addClass('is-valid');
                }
            }
        });
    });

    $('.select2').select2({
        dropdownParent: $('.modal'),
    });
    
</script>
