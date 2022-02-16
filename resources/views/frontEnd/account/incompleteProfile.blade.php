@extends('frontEnd.masterPage')
@section('style')
    <style>
        .input-range{width: 46%; float: left; margin-right: 2%;}
        .round-profile-img{width:200px; height:200px; overflow: hidden; border-radius: 150%; position: relative; margin: 0px auto; border: 1px solid #000;padding: 0px;}
        .round-profile-img img{display: inline; margin: 0px auto; height: 100%; width: auto;}
    </style>
@stop
@section('mainPart')
    <div class="grid_3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <h3>Missing Profile Information</h3>
                    <div class="progress-step">
                        <div class="line {{ $incomplete_step >= 1 ? 'complete' : Null }}" >
                            <div class="progress-line"></div>
                            <div class="node">Step 1</div>
                        </div>                        
                        <div class="line {{ $incomplete_step >= 2 ? 'complete' : Null }}" >
                            <div class="progress-line"></div>
                            <div class="node">Step 2</div>
                        </div>                        
                        <div class="line {{ $incomplete_step >= 3 ? 'complete' : Null }}" >
                            <div class="progress-line"></div>
                            <div class="node">Step 3</div>
                        </div>
                        <div class="line {{ $incomplete_step >= 4 ? 'complete' : Null }}">
                            <div class="progress-line"></div>
                            <div class="node">Step 4</div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    {!! Form::open(['url' => 'profile/incomplete', 'method' => 'post', 'class' => "row", 'files' => true]) !!}
                        @if($incomplete_step == 1)
                            <div class="col-sm-12 mt-4">
                                <h3 class="bg-primary text-white" style="padding:5px">Required Document</h3>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>NID</label>
                                    <input type="text" name="nid" class="form-control" value="{{ $profile->nid }}" placeholder="Your NID Number">
                                </div>
                            </div>                        

                            <!-- Passport -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Passport</label>
                                    <input type="text" name="passport" class="form-control" value="{{ $profile->passport }}" placeholder="Your Passport Number">
                                </div>
                            </div>

                            <!-- Files -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Profile Picture <span class="text-danger">*</span></label>
                                    <p style="font-weight: bold;color:red;"> Upload only .jpg or .png Image. For good quality image, upload 300 x 300 size image.</p>
                                    <input type="file" name="image_path" accept="image/png,image/jpeg">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label>Image Preview</label><br>
                                    <div class="round-profile-img col-12 col-sm-6">
                                        <img src="{{ asset('dummy_user.jpg') }}" style="width:200px;">                                        
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <img src="{{ asset('img/img-instruction.png') }}" class="img-fluid img-thumbnail">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Bio Data</label>
                                    <input type="file" name="user_bio_data_path" >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>NID Image</label>
                                    <input type="file" name="nid_image" accept="image/png,image/jpeg">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Passport Image</label>
                                    <input type="file" name="passport_image" accept="image/png,image/jpeg">
                                </div>
                            </div> 
                            
                            
                        
                        <!-- Step 2 Personal & Family Information -->
                        @elseif($incomplete_step == 2)

                            <div class="col-sm-12 mt-4">
                                <h3 class="bg-primary text-white" style="padding:5px">Basic Profile Information missing</h3>
                            </div>

                            <!-- mother_tongue -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Mother tongue <span class="text-danger">*</span> </label>
                                    <select name="mother_tongue" class="form-control select2" required >
                                        <option value="">Select Mother tongue</option>
                                        <option value="Arabic" {{ $profile->mother_tongue == 'Arabic' ? 'selected' : Null }} >Arabic</option>
                                        <option value="Bengali" {{ $profile->mother_tongue =='Bengali' ? 'selected' : Null }} >Bengali</option>
                                        <option value="Chinise" {{ $profile->mother_tongue =='Chinise' ? 'selected' : Null }} >Chinise</option>
                                        <option value="English" {{ $profile->mother_tongue =='English' ? 'selected' : Null }}>English</option>
                                        <option value="French" {{ $profile->mother_tongue =='French' ? 'selected' : Null }}>French</option>
                                        <option value="German" {{ $profile->mother_tongue =='German' ? 'selected' : Null }}>German</option>
                                        <option value="Hindi" {{ $profile->mother_tongue =='Hindi' ? 'selected' : Null }}>Hindi</option>
                                        <option value="Indonesion" {{ $profile->mother_tongue =='Indonesion' ? 'selected' : Null }}>Indonesion</option>
                                        <option value="Italian" {{ $profile->mother_tongue =='Italian' ? 'selected' : Null }}>Italian</option>
                                        <option value="Japanese" {{ $profile->mother_tongue =='Japanese' ? 'selected' : Null }}>Japanese</option>
                                        <option value="Korean" {{ $profile->mother_tongue =='Korean' ? 'selected' : Null }}>Korean</option>
                                        <option value="Nepali" {{ $profile->mother_tongue =='Nepali' ? 'selected' : Null }}>Nepali</option>
                                        <option value="Punjabi" {{ $profile->mother_tongue =='Punjabi' ? 'selected' : Null }}>Punjabi</option>
                                        <option value="Russian" {{ $profile->mother_tongue =='Russian' ? 'selected' : Null }}>Russian</option>
                                        <option value="Spanish" {{ $profile->mother_tongue =='Spanish' ? 'selected' : Null }}>Spanish</option>
                                        <option value="Swedish" {{ $profile->mother_tongue =='Swedish' ? 'selected' : Null }}>Swedish</option>
                                        <option value="Tamil" {{ $profile->mother_tongue =='Tamil' ? 'selected' : Null }}>Tamil</option>
                                        <option value="Telugu" {{ $profile->mother_tongue =='Telugu' ? 'selected' : Null }}>Telugu</option>
                                        <option value="Turkish" {{ $profile->mother_tongue =='Turkish' ? 'selected' : Null }}>Turkish</option>
                                        <option value="Urdu" {{ $profile->mother_tongue =='Urdu' ? 'selected' : Null }}>Urdu</option>
                                    </select>
                                </div>
                            </div> 

                            <!-- Height -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    @php
                                        $height_arr = explode('.', $profile->user_height);
                                    @endphp
                                    <label>Height <span class="text-danger">*</span></label>
                                    <div class="row" style="margin: 0px;">
                                        <select class="form-control" style="width:47%;float:left" required name="feet" >
                                            <option value="3" {{ $height_arr[0] == 3 ? 'selected' : Null }} >3 Feet</option>
                                            <option value="4" {{ $height_arr[0] == 4 ? 'selected' : Null }} >4 Feet</option>
                                            <option value="5" {{ $height_arr[0] == 5 ? 'selected' : Null }}>5 Feet</option>
                                            <option value="6" {{ $height_arr[0] == 6 ? 'selected' : Null }}>6 Feet</option>
                                            <option value="7" {{ $height_arr[0] == 7 ? 'selected' : Null }}>7 Feet</option>
                                            <option value="8" {{ $height_arr[0] == 8 ? 'selected' : Null }}>8 Feet</option>
                                        </select>
                                        <select class="form-control" style="width:47%;float:left;margin-left:2%;" required name="inch" >
                                            <option value="0" {{ isset($height_arr[1]) && $height_arr[1] == 0 ? 'selected' : Null }} >0 Inch </option>
                                            <option value="1" {{ isset($height_arr[1]) &&  $height_arr[1] == 1 ? 'selected' : Null }} >1 Inch </option>
                                            <option value="2" {{ isset($height_arr[1]) &&  $height_arr[1] == 2 ? 'selected' : Null }}>2 Inch </option>
                                            <option value="3" {{ isset($height_arr[1]) &&  $height_arr[1] == 3 ? 'selected' : Null }}>3 Inch </option>
                                            <option value="4" {{ isset($height_arr[1]) &&  $height_arr[1] == 4 ? 'selected' : Null }}>4 Inch </option>
                                            <option value="5" {{ isset($height_arr[1]) &&  $height_arr[1] == 5 ? 'selected' : Null }}>5 Inch </option>
                                            <option value="6" {{ isset($height_arr[1]) &&  $height_arr[1] == 6 ? 'selected' : Null }}>6 Inch </option>
                                            <option value="7" {{ isset($height_arr[1]) &&  $height_arr[1] == 7 ? 'selected' : Null }}>7 Inch </option>
                                            <option value="8" {{ isset($height_arr[1]) &&  $height_arr[1] == 8 ? 'selected' : Null }}>8 Inch </option>
                                            <option value="9" {{ isset($height_arr[1]) &&  $height_arr[1] == 9 ? 'selected' : Null }}>9 Inch </option>
                                            <option value="10" {{ isset($height_arr[1]) &&  $height_arr[1] == 10 ? 'selected' : Null }}>10 Inch </option>
                                            <option value="11" {{ isset($height_arr[1]) &&  $height_arr[1] == 11 ? 'selected' : Null }}>11 Inch </option>
                                            <option value="12" {{ isset($height_arr[1]) &&  $height_arr[1] == 12 ? 'selected' : Null }}>12 Inch </option>
                                        </select>
                                    </div>                                    
                                </div>
                            </div>

                            <!-- user_body_weight -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Body Type <span class="text-danger">*</span></label>   
                                    <select name="user_body_weight" class="form-control" required >
                                        <option value="" >Select Body Type</option>
                                        <option value="skinny" {{ $profile->user_body_weight == 'skinny' ? 'selected' : Null }}>Skinny</option>
                                        <option value="healthy" {{ $profile->user_body_weight == 'healthy' ? 'selected' : Null }}>Healthy</option>
                                        <option value="moderate" {{ $profile->user_body_weight == 'moderate' ? 'selected' : Null }}>Moderate</option>
                                        <option value="fatty" {{ $profile->user_body_weight == 'fatty' ? 'selected' : Null }}>Fatty</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- user_body_color -->                    
                            <div class="col-sm-4 hidden">
                                <div class="form-group">
                                    <label>Body color</label>                          
                                    <input type="text" placeholder="Body color" name="user_body_color" value="{{ $profile->user_body_color }}" class="form-control"  >                        
                                </div>
                            </div>

                            <!-- Blood Group -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Blood Group</label> 
                                    <select name="user_blood_group" class="form-control select2" >
                                        <option value="A+" {{ $profile->user_blood_group == "A+" ? 'selected' : Null }} >A+</option>
                                        <option value="A-" {{ $profile->user_blood_group == "A-" ? 'selected' : Null }} >A-</option>
                                        <option value="B+" {{ $profile->user_blood_group == "B+" ? 'selected' : Null }} >B+</option>
                                        <option value="B-" {{ $profile->user_blood_group == "B-" ? 'selected' : Null }} >B-</option>
                                        <option value="AB+" {{ $profile->user_blood_group == "AB+" ? 'selected' : Null }} >AB+</option>
                                        <option value="AB-" {{ $profile->user_blood_group == "AB-" ? 'selected' : Null }} >AB-</option>
                                        <option value="O+" {{ $profile->user_blood_group == "O+" ? 'selected' : Null }} >O+</option>
                                        <option value="O-" {{ $profile->user_blood_group == "O-" ? 'selected' : Null }} >O-</option>
                                    </select>                         
                                </div>
                            </div>
                            
                            <!-- user_fitness_disabilities -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Fitness Disabilities <span class="text-danger">*</span> </label>                          
                                    <select name="user_fitness_disabilities" class="form-control" required>
                                        <option value="N" {{ $profile->user_fitness_disabilities == "N" ? 'selected': Null }} >No</option>
                                        <option value="Y" {{ $profile->user_fitness_disabilities == "Y" ? 'selected': Null }} >Yes</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Eye Color -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Eye color </label> 
                                    <select name="eye_color" class="form-control">
                                        <option value="Amber" {{ $profile->eye_color == 'Amber' ? 'selected' : Null }} >Amber</option>
                                        <option value="Black" {{ $profile->eye_color == 'Black' ? 'selected' : Null }} >Black</option>
                                        <option value="Blue" {{ $profile->eye_color == 'Blue' ? 'selected' : Null }} >Blue</option>
                                        <option value="Brown" {{ $profile->eye_color == 'Brown' ? 'selected' : Null }} >Brown</option>
                                        <option value="Gray" {{ $profile->eye_color == 'Gray' ? 'selected' : Null }} >Gray</option>
                                        <option value="Green" {{ $profile->eye_color == 'Green' ? 'selected' : Null }} >Green</option>
                                        <option value="Red" {{ $profile->eye_color == 'Red' ? 'selected' : Null }} >Red</option>
                                    </select>
                                </div>
                            </div>

                            <!-- hair color -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Hair color </label>
                                    <select class="form-control" name="hair_color">
                                        <option value="" >Select Hair color</option>
                                        <option value="Black" {{ $profile->hair_color == "Black" ? 'selected' : Null }} >Black</option>
                                        <option value="Brown" {{ $profile->hair_color == "Brown" ? 'selected' : Null }} >Brown</option>
                                        <option value="Blonde" {{ $profile->hair_color == "Blonde" ? 'selected' : Null }} >Blonde</option>
                                        <option value="Auburn" {{ $profile->hair_color == "Auburn" ? 'selected' : Null }} >Auburn</option>
                                        <option value="Red" {{ $profile->hair_color == "Red" ? 'selected' : Null }} >Red</option>
                                        <option value="Gray & white" {{ $profile->hair_color == "Gray & white" ? 'selected' : Null }} >Gray & white</option>
                                    </select>
                                </div>
                            </div>

                            <!-- complexion -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Complexion </label> 
                                    <select name="complexion" class="form-control" required >
                                        <option value="">Select Complexion</option>
                                        <option value="Light skin" {{ $profile->complexion == 'Light skin' ? 'selected' : Null }} >Light skin</option>
                                        <option value="Fair skin" {{ $profile->complexion == 'Fair skin' ? 'selected' : Null }} >Fair skin</option>
                                        <option value="Medium skin" {{ $profile->complexion == 'Medium skin' ? 'selected' : Null }} >Medium skin</option>
                                        <option value="Olive skin" {{ $profile->complexion == 'Olive skin' ? 'selected' : Null }} >Olive skin</option>
                                        <option value="Dark skin" {{ $profile->complexion == 'Dark skin' ? 'selected' : Null }} >Dark skin</option>
                                        <option value="Tan brown skin" {{ $profile->complexion == 'Tan brown skin' ? 'selected' : Null }} >Tan brown skin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- diet -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Diet </label>                          
                                    <select name="diet" class="form-control" required >
                                        <option value="">Select Diet</option>
                                        <option value="Vegetarian " {{ $profile->diet == 'Vegetarian' ? 'selected' : Null }} >Vegetarian</option>
                                        <option value="Non vegetarian" {{ $profile->diet == 'Non vegetarian' ? 'selected' : Null }} >Non vegetarian</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Life Style</label>
                                    <select name="lifestyle_id" class="form-control" >
                                        <option value="">Select life Style</option>   
                                        @foreach($lifeStyles as $style)
                                            <option value="{{ $style->id }}" {{ $profile->lifestyle_id == $style->id ? 'selected' : Null }} >{{ $style->name }}</option> 
                                        @endforeach                            
                                    </select>                                    
                                </div>
                            </div>

                            <!-- Smoke -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Smoke </label>                          
                                    <select name="smoke" class="form-control" >
                                        <option value="No" {{ $profile->smoke == "No" ? 'selected': Null }} >No</option>
                                        <option value="Yes" {{ $profile->smoke == "Yes" ? 'selected': Null }} >Yes</option>                                        
                                        <option value="Occasionally" {{ $profile->smoke == "Occasionally" ? 'selected': Null }} >Occasionally</option>                                        
                                        <option value="Moderate" {{ $profile->smoke == "Moderate" ? 'selected': Null }} >Moderate</option>                                        
                                    </select>
                                </div>
                            </div>

                            <!-- Drink -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Drink </label>                          
                                    <select name="drink" class="form-control" >
                                        <option value="No" {{ $profile->smoke == "No" ? 'selected': Null }} >No</option>
                                        <option value="Yes" {{ $profile->smoke == "Yes" ? 'selected': Null }} >Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Have child </label>  
                                    <select name="no_children" class="form-control">
                                        <option value="No" {{ $profile->no_children == 'No' ? 'selected' : Null }}>No</option>
                                        <option value="Yes" {{ $profile->no_children == 'Yes' ? 'selected' : Null }}>Yes</option>
                                    </select> 
                                </div>
                            </div>
                            

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>About Myself <span class="text-danger">*</span></label>                                     
                                    <textarea name="user_bio_myself" class="form-control" required >{{ $profile->user_bio_myself }}</textarea>                                  
                                </div>
                            </div>

                            <!-- Family Information -->
                            <div class="col-sm-12 mt-4">
                                <h3 class="bg-primary text-white" style="padding:5px">Family Information</h3>
                            </div>

                            <!-- Father Name -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Father's name <span class="text-danger">*</span></label>                          
                                    <input type="text" placeholder="Father name" name="father_name" value="{{ $profile->father_name }}" class="form-control" required > 
                                </div>
                            </div>
                            
                            <!-- Mother Name -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Mother's name <span class="text-danger">*</span> </label>                          
                                    <input type="text" placeholder="Mother name" name="mother_name" value="{{ $profile->mother_name }}" class="form-control" required > 
                                </div>
                            </div>

                            <!-- gardian_contact_no -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Gardian contact <span class="text-danger">*</span></label>                          
                                    <input type="text" placeholder="Gardian contact Number" name="gardian_contact_no" value="{{ $profile->gardian_contact_no }}" class="form-control" required > 
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Father occupation </label>  
                                    <select name="father_occupation" class="form-control">
                                        <option value="">Select Profession</option>
                                        @foreach($professions as $profession)
                                            <option value="{{ $profession->name }}" {{ $profession->name == $profile->father_occupation ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Mother occupation</label>
                                    <select name="mother_occupation" class="form-control">
                                        <option value="">Select Profession</option>
                                        @foreach($professions as $profession)
                                            <option value="{{ $profession->name }}" {{ $profession->name == $profile->mother_occupation ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Number of Brother -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Number Of Brother <span class="text-danger">*</span> </label>                          
                                    <select name="no_of_brother" class="form-control" >
                                        <option value="0" {{ $profile->no_of_brother == "0" ? 'selected': Null }} >0</option>                                        
                                        <option value="1" {{ $profile->no_of_brother == "1" ? 'selected': Null }} >1</option>                                        
                                        <option value="2" {{ $profile->no_of_brother == "2" ? 'selected': Null }} >2</option>                                        
                                        <option value="3" {{ $profile->no_of_brother == "3" ? 'selected': Null }} >3</option>                                        
                                        <option value="4" {{ $profile->no_of_brother == "4" ? 'selected': Null }} >4</option>                                        
                                        <option value="5" {{ $profile->no_of_brother == "5" ? 'selected': Null }} >5</option>                                        
                                        <option value="6" {{ $profile->no_of_brother == "6" ? 'selected': Null }} >6</option>                                        
                                        <option value="7" {{ $profile->no_of_brother == "7" ? 'selected': Null }} >7</option>                                        
                                        <option value="8" {{ $profile->no_of_brother == "8" ? 'selected': Null }} >8</option>                                        
                                    </select>
                                </div>
                            </div>
                            <!-- Number of Sister -->                    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Number Of Sister <span class="text-danger">*</span> </label>                          
                                    <select name="no_of_sister" class="form-control" >
                                        <option value="0" {{ $profile->no_of_sister == "0" ? 'selected': Null }} >0</option>                                        
                                        <option value="1" {{ $profile->no_of_sister == "1" ? 'selected': Null }} >1</option>                                        
                                        <option value="2" {{ $profile->no_of_sister == "2" ? 'selected': Null }} >2</option>                                        
                                        <option value="3" {{ $profile->no_of_sister == "3" ? 'selected': Null }} >3</option>                                        
                                        <option value="4" {{ $profile->no_of_sister == "4" ? 'selected': Null }} >4</option>                                        
                                        <option value="5" {{ $profile->no_of_sister == "5" ? 'selected': Null }} >5</option>                                        
                                        <option value="6" {{ $profile->no_of_sister == "6" ? 'selected': Null }} >6</option>                                        
                                        <option value="7" {{ $profile->no_of_sister == "7" ? 'selected': Null }} >7</option>                                        
                                        <option value="8" {{ $profile->no_of_sister == "8" ? 'selected': Null }} >8</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Family Value</label>                                     
                                    <select class="form-control" name="family_values">
                                        <option>Select Family Value</option>
                                        <option value="moderate" {{ $profile->family_values == 'moderate' ? 'selected' : Null }}>Moderate</option>
                                        <option value="open minded" {{ $profile->family_values == 'open minded' ? 'selected' : Null }} >Open minded</option>
                                        <option value="religious" {{ $profile->family_values == 'religious' ? 'selected' : Null }} >Religious</option>
                                        <option value="not applicable" {{ $profile->family_values == 'not applicable' ? 'selected' : Null }} >Not applicable</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Family details</label>                                     
                                    <textarea name="family_details" class="form-control" >{{ $profile->family_details }}</textarea>                                  
                                </div>
                            </div>

                            <div class="col-sm-12 mt-4">
                                <h3 class="bg-primary text-white" style="padding:5px">Address</h3>
                            </div>

                            <!-- Present Address -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Present Address <span class="text-danger">*</span></label>                              
                                    <input type="text" placeholder="Your Present Address" name="user_present_address" value="{{ $profile->user_present_address }}" class="form-control" required >                        
                                </div>
                            </div>

                            <!-- Division -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Division </label>                              
                                    <select class="form-control division" name="division_id"  >
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ $division->id ==$profile->division_id ? 'selected' : Null }} >{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- District -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>District </label>                              
                                    <select class="form-control district" name="district_id" >
                                        <option value="">Select District</option>                                                
                                    </select>
                                </div>
                            </div>

                             <!-- Upazila -->
                             <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Upazila </label>                              
                                    <select class="form-control upazila" name="upozila_id" >
                                        <option value="">Select Upazila</option>                                                
                                    </select>
                                </div>
                            </div>

                            <!-- Present City -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Present City <span class="text-danger">*</span></label>                              
                                    <input type="text" placeholder="Your Present City" name="user_present_city" value="{{ $profile->user_present_city }}" class="form-control" required >                        
                                </div>
                            </div>
                            <!-- user_present_country -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Present Country <span class="text-danger">*</span> </label>                              
                                    <select name="user_present_country" class="form-control select2" >
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->country }}" {{ $country->country == $profile->user_present_country ? 'selected' : Null }} >{{ ucfirst($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Permanent Address -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Permanent Address</label>                              
                                    <input type="text" placeholder="Your Permanent Address" name="user_permanent_address" value="{{ $profile->user_permanent_address }}" class="form-control"  >                        
                                </div>
                            </div>
                            <!-- Permanent City -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Permanent City</label>                              
                                    <input type="text" placeholder="Your Permanent City" name="user_permanent_city" value="{{ $profile->user_permanent_city }}" class="form-control"  >                        
                                </div>
                            </div>
                            <!-- user_permanent_country -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Permanent Country</label>                              
                                    <select name="user_permanent_country" class="form-control select2" >
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->country }}" {{ $country->country == $profile->user_permanent_country ? 'selected' : Null }} >{{ ucfirst($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                        <!-- step 3 Education or Career Information Meesing-->
                        @elseif($incomplete_step == 3)
                            <div class="col-sm-12 mt-4">
                                <h3 class="bg-primary text-white" style="padding:5px">Education & Career</h3>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Institute Name <span class="text-danger">*</span></label>                          
                                    <input type="text" placeholder="Institute Name" name="edu_institute_name" value="{{ $profile->edu_institute_name }}" class="form-control"  required >                        
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Major subject <span class="text-danger">*</span></label>                          
                                    <input type="text" placeholder="major subject" name="major_subject" value="{{ $profile->major_subject }}" class="form-control" required >                        
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Working Profession </label>                              
                                    <select name="career_working_profession_id" class="form-control"  >
                                        <option value="">Select Profession</option>
                                        @foreach($professions as $profession)
                                        <option value="{{ $profession->id }}" {{ $profession->id == $profile->career_working_profession_id ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- career_working_name -->   
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Designation / Post </label>                              
                                    <input type="text" placeholder="Designation / Post" name="career_working_name" value="{{ $profile->career_working_name }}" class="form-control" >                        
                                </div>
                            </div>
                            <!-- career_working_name -->   
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Organisation Name</label>                              
                                    <input type="text" placeholder="Organisation Name" name="organisation" value="{{ $profile->organisation }}" class="form-control" >                        
                                </div>
                            </div>

                            <!-- Yearly Income -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Yearly Income </label>                              
                                    <select name="career_monthly_income_id" class="form-control"  >
                                        <option value="">Select Income Range</option>
                                        @foreach($incomes as $income)
                                        <option value="{{ $income->id }}" {{ $income->id == $profile->career_monthly_income_id ? 'selected' : Null }} >{{ ucfirst($income->range) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        <!-- Step 4 || Paetner Information -->
                        @elseif($incomplete_step == 4)
                            <div class="col-sm-12 mt-4">
                                <h3 class="bg-primary text-white" style="padding:5px">Life Partner</h3>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">                                    
                                    <label>Partner Min Age <span class="text-danger">*</span></label>                                        
                                    <input type="number" class="form-control" name="partner_min_age" min="15" max="80" step="1" value="18" required>                                                                      
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Partner Max Age <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="partner_max_age" min="15" max="80" step="1" value="24" required>
                                </div>
                            </div>
                            
                            <!--partner Mother taungh -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Partner Mother tongue</label>
                                    <select name="partner_mother_tongue[]" class="form-control select2" multiple >
                                        <option value="Arabic" {{ is_array($profile->partner_mother_tongue) && in_array('Arabic', $profile->partner_mother_tongue) ? 'selected' : Null }} >Arabic</option>
                                        <option value="Bengali" {{ is_array($profile->partner_mother_tongue) && in_array('Bengali', $profile->partner_mother_tongue) ? 'selected' : Null }} >Bengali</option>
                                        <option value="Chinise" {{ is_array($profile->partner_mother_tongue) && in_array('Chinise', $profile->partner_mother_tongue) ? 'selected' : Null }} >Chinise</option>
                                        <option value="English" {{ is_array($profile->partner_mother_tongue) && in_array('English', $profile->partner_mother_tongue) ? 'selected' : Null }}>English</option>
                                        <option value="French" {{ is_array($profile->partner_mother_tongue) && in_array('French', $profile->partner_mother_tongue) ? 'selected' : Null }}>French</option>
                                        <option value="German" {{ is_array($profile->partner_mother_tongue) && in_array('German', $profile->partner_mother_tongue) ? 'selected' : Null }}>German</option>
                                        <option value="Hindi" {{ is_array($profile->partner_mother_tongue) && in_array('Hindi', $profile->partner_mother_tongue) ? 'selected' : Null }}>Hindi</option>
                                        <option value="Indonesion" {{ is_array($profile->partner_mother_tongue) && in_array('Indonesion', $profile->partner_mother_tongue) ? 'selected' : Null }}>Indonesion</option>
                                        <option value="Italian" {{ is_array($profile->partner_mother_tongue) && in_array('Italian', $profile->partner_mother_tongue) ? 'selected' : Null }}>Italian</option>
                                        <option value="Japanese" {{ is_array($profile->partner_mother_tongue) && in_array('Japanese', $profile->partner_mother_tongue) ? 'selected' : Null }}>Japanese</option>
                                        <option value="Korean" {{ is_array($profile->partner_mother_tongue) && in_array('Korean', $profile->partner_mother_tongue) ? 'selected' : Null }}>Korean</option>
                                        <option value="Nepali" {{ is_array($profile->partner_mother_tongue) && in_array('Nepali', $profile->partner_mother_tongue) ? 'selected' : Null }}>Nepali</option>
                                        <option value="Punjabi" {{ is_array($profile->partner_mother_tongue) && in_array('Punjabi', $profile->partner_mother_tongue) ? 'selected' : Null }}>Punjabi</option>
                                        <option value="Russian" {{ is_array($profile->partner_mother_tongue) && in_array('Russian', $profile->partner_mother_tongue) ? 'selected' : Null }}>Russian</option>
                                        <option value="Spanish" {{ is_array($profile->partner_mother_tongue) && in_array('Spanish', $profile->partner_mother_tongue) ? 'selected' : Null }}>Spanish</option>
                                        <option value="Swedish" {{ is_array($profile->partner_mother_tongue) && in_array('Swedish', $profile->partner_mother_tongue) ? 'selected' : Null }}>Swedish</option>
                                        <option value="Tamil" {{ is_array($profile->partner_mother_tongue) && in_array('Tamil', $profile->partner_mother_tongue) ? 'selected' : Null }}>Tamil</option>
                                        <option value="Telugu" {{ is_array($profile->partner_mother_tongue) && in_array('Telugu', $profile->partner_mother_tongue) ? 'selected' : Null }}>Telugu</option>
                                        <option value="Turkish" {{ is_array($profile->partner_mother_tongue) && in_array('Turkish', $profile->partner_mother_tongue) ? 'selected' : Null }}>Turkish</option>
                                        <option value="Urdu" {{ is_array($profile->partner_mother_tongue) && in_array('Urdu', $profile->partner_mother_tongue) ? 'selected' : Null }}>Urdu</option>
                                    </select>
                                </div>
                            </div>

                            <!-- MIn Height -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    @php
                                        $min_height_arr = explode('.', $profile->partner_min_height);
                                    @endphp
                                    <label>Partnet Min. Height <span class="text-danger">*</span></label><br>
                                    <div class="row" style="margin: 0px;">
                                        <select class="form-control" style="width:47%;float:left" required name="part_min_feet" >
                                            <option value="3" {{ $min_height_arr[0] == 3 ? 'selected' : Null }} >3 Feet</option>
                                            <option value="4" {{ $min_height_arr[0] == 4 ? 'selected' : Null }} >4 Feet</option>
                                            <option value="5" {{ $min_height_arr[0] == 5 ? 'selected' : Null }}>5 Feet</option>
                                            <option value="6" {{ $min_height_arr[0] == 6 ? 'selected' : Null }}>6 Feet</option>
                                            <option value="7" {{ $min_height_arr[0] == 7 ? 'selected' : Null }}>7 Feet</option>
                                            <option value="8" {{ $min_height_arr[0] == 8 ? 'selected' : Null }}>8 Feet</option>
                                        </select>
                                        <select class="form-control" style="width:47%;float:left;margin-left:2%;" required name="part_min_inch" >
                                            <option value="0" {{ isset($min_height_arr[1]) && $min_height_arr[1] == 0 ? 'selected' : Null }} >0 Inch </option>
                                            <option value="1" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 1 ? 'selected' : Null }} >1 Inch </option>
                                            <option value="2" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 2 ? 'selected' : Null }}>2 Inch </option>
                                            <option value="3" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 3 ? 'selected' : Null }}>3 Inch </option>
                                            <option value="4" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 4 ? 'selected' : Null }}>4 Inch </option>
                                            <option value="5" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 5 ? 'selected' : Null }}>5 Inch </option>
                                            <option value="6" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 6 ? 'selected' : Null }}>6 Inch </option>
                                            <option value="7" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 7 ? 'selected' : Null }}>7 Inch </option>
                                            <option value="8" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 8 ? 'selected' : Null }}>8 Inch </option>
                                            <option value="9" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 9 ? 'selected' : Null }}>9 Inch </option>
                                            <option value="10" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 10 ? 'selected' : Null }}>10 Inch </option>
                                            <option value="11" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 11 ? 'selected' : Null }}>11 Inch </option>
                                            <option value="12" {{ isset($min_height_arr[1]) &&  $min_height_arr[1] == 12 ? 'selected' : Null }}>12 Inch </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Max height-->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    @php
                                        $max_height_arr = explode('.', $profile->partner_max_height);
                                    @endphp
                                    <label>Partnet Max. Height <span class="text-danger">*</span></label><br>
                                    <div class="row" style="margin: 0px;">
                                        <select class="form-control" style="width:47%;float:left" required name="part_max_feet" >
                                            <option value="3" {{ $max_height_arr[0] == 3 ? 'selected' : Null }} >3 Feet</option>
                                            <option value="4" {{ $max_height_arr[0] == 4 ? 'selected' : Null }} >4 Feet</option>
                                            <option value="5" {{ $max_height_arr[0] == 5 ? 'selected' : Null }}>5 Feet</option>
                                            <option value="6" {{ $max_height_arr[0] == 6 ? 'selected' : Null }}>6 Feet</option>
                                            <option value="7" {{ $max_height_arr[0] == 7 ? 'selected' : Null }}>7 Feet</option>
                                            <option value="8" {{ $max_height_arr[0] == 8 ? 'selected' : Null }}>8 Feet</option>
                                        </select>
                                        <select class="form-control" style="width:47%;float:left; margin-left:2%; float:clear" required name="part_max_inch" >
                                            <option value="0" {{ isset($max_height_arr[1]) && $max_height_arr[1] == 0 ? 'selected' : Null }} >0 Inch </option>
                                            <option value="1" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 1 ? 'selected' : Null }} >1 Inch </option>
                                            <option value="2" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 2 ? 'selected' : Null }}>2 Inch </option>
                                            <option value="3" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 3 ? 'selected' : Null }}>3 Inch </option>
                                            <option value="4" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 4 ? 'selected' : Null }}>4 Inch </option>
                                            <option value="5" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 5 ? 'selected' : Null }}>5 Inch </option>
                                            <option value="6" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 6 ? 'selected' : Null }}>6 Inch </option>
                                            <option value="7" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 7 ? 'selected' : Null }}>7 Inch </option>
                                            <option value="8" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 8 ? 'selected' : Null }}>8 Inch </option>
                                            <option value="9" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 9 ? 'selected' : Null }}>9 Inch </option>
                                            <option value="10" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 10 ? 'selected' : Null }}>10 Inch </option>
                                            <option value="11" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 11 ? 'selected' : Null }}>11 Inch </option>
                                            <option value="12" {{ isset($max_height_arr[1]) &&  $max_height_arr[1] == 12 ? 'selected' : Null }}>12 Inch </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- partner body color Hidden -->
                            <div class="col-sm-4 hidden">
                                <div class="form-group">
                                    <label>Partner body color</label>
                                    <input type="text" name="partner_body_color" value="{{ $profile->partner_body_color }}" class="form-control" placeholder="Body Color">
                                </div>                                
                            </div>

                            <!-- partner_eye_color -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Partner eye color</label>
                                    <select name="partner_eye_color[]" class="form-control select2" multiple>
                                        <option value="Amber" {{ is_array($profile->partner_eye_color) && in_array('Amber', $profile->partner_eye_color) ? 'selected' : Null }} >Amber</option>
                                        <option value="Black" {{ is_array($profile->partner_eye_color) && in_array('Black', $profile->partner_eye_color) ? 'selected' : Null }} >Black</option>
                                        <option value="Blue" {{ is_array($profile->partner_eye_color) && in_array('Blue', $profile->partner_eye_color) ? 'selected' : Null }} >Blue</option>
                                        <option value="Brown" {{ is_array($profile->partner_eye_color) && in_array('Brown', $profile->partner_eye_color) ? 'selected' : Null }} >Brown</option>
                                        <option value="Gray" {{ is_array($profile->partner_eye_color) && in_array('Gray', $profile->partner_eye_color) ? 'selected' : Null }} >Gray</option>
                                        <option value="Green" {{ is_array($profile->partner_eye_color) && in_array('Green', $profile->partner_eye_color) ? 'selected' : Null }} >Green</option>
                                        <option value="Red" {{ is_array($profile->partner_eye_color) && in_array('Red', $profile->partner_eye_color) ? 'selected' : Null }} >Red</option>
                                    </select>                                    
                                </div>
                            </div>

                            <!-- partner_complexion -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Partner complexion</label>                                    
                                    <select name="partner_complexion[]" class="form-control select2" multiple>
                                        <option value="">Select Complexion</option>
                                        <option value="Light skin" {{ is_array($profile->partner_complexion) && in_array('Light skin', $profile->partner_complexion) }} >Light skin</option>
                                        <option value="Fair skin" {{ is_array($profile->partner_complexion) && in_array('Fair skin', $profile->partner_complexion) }} >Fair skin</option>
                                        <option value="Medium skin" {{ is_array($profile->partner_complexion) && in_array('Medium skin', $profile->partner_complexion) }} >Medium skin</option>
                                        <option value="Olive skin" {{ is_array($profile->partner_complexion) && in_array('Olive skin', $profile->partner_complexion) }} >Olive skin</option>
                                        <option value="Dark skin" {{ is_array($profile->partner_complexion) && in_array('Dark skin', $profile->partner_complexion) }} >Dark skin</option>
                                        <option value="Tan brown skin" {{ is_array($profile->partner_complexion) && in_array('Tan brown skin', $profile->partner_complexion) }} >Tan brown skin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- partner_dite -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Diet </label>                          
                                    <select name="partner_dite[]" class="form-control select2" multiple >
                                        <option value="">Select Diet</option>
                                        <option value="Vegetarian" {{ is_array($profile->partner_dite) && in_array('Vegetarian' ,$profile->partner_dite) ? 'selected' : Null }} >Vegetarian</option>
                                        <option value="Non vegetarian" {{ is_array($profile->partner_dite) && in_array('Non vegetarian', $profile->partner_dite) ? 'selected' : Null  }} >Non vegetarian</option>
                                    </select>
                                </div>
                            </div>

                             <!-- partner_father_occupation -->
                             <div class="col-sm-4 hidden">
                                <div class="form-group">
                                    <label>Partner Father's occupation</label>
                                    <select name="partner_father_occupation" class="form-control">
                                        <option value="">Select Profession</option>
                                        @foreach($professions as $profession)
                                            <option value="{{ $profession->name }}" {{ $profession->name == $profile->partner_father_occupation ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            
                            <!-- partner_father_occupation -->
                            <div class="col-sm-4 hidden">
                                <div class="form-group">
                                    <label>Partner Mother occupation</label>
                                    <select name="partner_mother_occupation" class="form-control">
                                        <option value="">Select Profession</option>
                                        @foreach($professions as $profession)
                                            <option value="{{ $profession->name }}" {{ $profession->name == $profile->partner_mother_occupation ? 'selected' : Null }} >{{ ucfirst($profession->name) }}</option>
                                        @endforeach
                                    </select>                                   
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Partner Religion <span class="text-danger">*</span></label>
                                    <select name="partner_religion" class="religion-select form-control" required >
                                        <option value="">Select Religion</option>
                                        @foreach($religious as $religion)
                                            <option value="{{ $religion->id }}" > {{ $religion->name }} </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>

                            <!-- Religion Cast -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Partner Religion Cast</label>
                                    <select name="partner_religion_cast[]" class="religion-cast select2" multiple >
                                        
                                    </select>                                    
                                </div>
                            </div>

                            <div class="col-sm-6 hidden">
                                <div class="form-group">
                                    <label>Partner city</label>
                                    <input type="text" name="partner_city" value="{{ $profile->partner_city }}" class="form-control" >                                  
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Partner Marital Status <span class="text-danger">*</span> </label>
                                    <select name="partner_marital_status[]" class="select2" multiple required>
                                        @foreach($maritalStatus as $mstatus)
                                            <option value="{{ $mstatus->name }}" > {{ ucfirst($mstatus->name ) }} </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            
                            <!-- Country -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Country <span class="text-danger">*</span></label>
                                    <select name="partner_country[]" class="select2" multiple required>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->country }}"> {{ $country->country }} </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            
                            <!-- Education -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Partner Education <span class="text-danger">*</span></label>
                                    <select name="partner_education[]" class="select2 form-control" required multiple>
                                        @foreach($educations as $education)
                                            <option value="{{ $education->name }}" > {{ $education->name }} </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Partner Profession </label>
                                    <select name="partner_profession[]" class="select2 form-control" multiple>
                                        <option value="">Select Profession</option>
                                        @foreach($professions as $profession)
                                            <option value="{{ $profession->name }}" > {{ $profession->name }} </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>

                            <!-- Partner Blood Group -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Blood Group</label> 
                                    <select name="partner_blood_group[]" class="form-control select2" multiple >
                                        <option value="A+" {{ is_array($profile->partner_blood_group) && in_array('A+', $profile->partner_blood_group) ? 'selected' : Null }} >A+</option>
                                        <option value="A-" {{ is_array($profile->partner_blood_group) && in_array('A-', $profile->partner_blood_group) ? 'selected' : Null }} >A-</option>
                                        <option value="B+" {{ is_array($profile->partner_blood_group) && in_array('B+', $profile->partner_blood_group) ? 'selected' : Null }} >B+</option>
                                        <option value="B-" {{ is_array($profile->partner_blood_group) && in_array('B-', $profile->partner_blood_group) ? 'selected' : Null }} >B-</option>
                                        <option value="AB+" {{ is_array($profile->partner_blood_group) && in_array('AB+', $profile->partner_blood_group) ? 'selected' : Null }} >AB+</option>
                                        <option value="AB-" {{ is_array($profile->partner_blood_group) && in_array('AB-', $profile->partner_blood_group) ? 'selected' : Null }} >AB-</option>
                                        <option value="O+" {{ is_array($profile->partner_blood_group) && in_array('O+', $profile->partner_blood_group) ? 'selected' : Null }} >O+</option>
                                        <option value="O-" {{ is_array($profile->partner_blood_group) && in_array('O-', $profile->partner_blood_group) ? 'selected' : Null }} >O-</option>
                                    </select>                         
                                </div>
                            </div>
                            
                        @else

                        @endif
                        <div class="col-sm-12 mt-2 text-right">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Next Step</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')

<script>

    $(document).ready(function(){
        $('.division').change(); 
    });

    $(document).on('change', '.religion-select', function(){
        let id = $(this).val();
        let old_val = $('.religion-cast').val();
        $.ajax({
            url : "{{ route('religious.cast.get')}}",
            data : { id : id},
            success : function(output){
                let option = `<option value="">Select Option</option>`;
                $.each(output, function(index, value){           
                    option += `<option value = "`+value.name+`"`;
                    option += value.id == old_val ? `selected` : ``;
                    option += `>` + value.name +`</option>`;
                });
                $('.religion-cast').html(option);
            },error : function(output){
                // console.log(output);
            }
            });
    });

    $('.division').change(function(){
        $.ajax({
            url : '{{ route('get.district') }}',
            data : { division_id : $('.division').val() },
            success : function(option){
                $('.district').html(option);
                $('.district').change();
            }
        });
    });

    $('.district').change(function(){
        $.ajax({
            url : '{{ route('get.upazila') }}',
            data : { district_id : $('.district').val() },
            success : function(option){
                $('.upazila').html(option);
            }
        });
    });
    
    $('input[name="image_path"]').change(function(){
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.round-profile-img img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    
</script>
@endsection