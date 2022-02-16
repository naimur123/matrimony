@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8" style="margin-top:2%;margin-bottom: 2%;">                
                @if(phpversion() >= 7.2)
                <div class="card" style="background: #999;opacity:.9; color:#fff;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6"> Install </div>
                            <div class="col-6 text-right"> <a href="{{route('login')}}" class="btn btn-sm btn-info">Admin Dashboard</a> </div>
                        </div> 
                    </div>
                    <div class="card-body">
                        <form action="{{ route('install') }}" method="POST" class="ajax-form" enctype="multipart/form-data">
                            <div class="form-group row">
                                <!-- First Row && First Column -->
                                <div class="col-md-6">
                                    <label for="applicationName">Application Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('applicationName') ? ' is-invalid' : '' }}" name="applicationName" value="{{ old('applicationName') }}" placeholder="Your Application / website Name" required autofocus>
                                    @if ($errors->has('applicationName'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('applicationName') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <!-- First Row && Second Column -->
                                <div class="col-md-6">
                                    <label for="titleName">Application Title Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('titleName') ? ' is-invalid' : '' }}" name="titleName" value="{{ old('titleName') }}" required placeholder="Your Website's title name">
                                    @if ($errors->has('titleName'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('titleName') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- Second Row && First Column -->     
                                <div class="col-md-6">
                                        <label for="phoneNo">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('phoneNo') ? ' is-invalid' : '' }}" name="phoneNo" value="{{ old('phoneNo') }}" required placeholder="Phone Number">
                                    @if ($errors->has('phoneNo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phoneNo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <!-- Second Row && Second Column -->                            
                                <div class="col-md-6">
                                    <label for="email" title="This email will be default email of your website">Email(Show in website) <span class="text-danger">*</span> </label>
                                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value=" {{ old('email') }}" required placeholder="Email (This email will be default email of your website)">
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">                            
                                <div class="col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city') }}"  placeholder="City">                                
                                </div>
                                <div class="col-md-6">
                                    <label for="zipCode">zip /Postal Code</label>
                                    <input type="text" class="form-control" name="zipCode" value="{{ old('zipCode') }}"  placeholder="zip /Postal Code">                                
                                </div>
                            </div>
                            <div class="form-group row">                            
                                <div class="col-md-6">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Address" value="{{ old('address') }}" >                                                             
                                </div>
                                <div class="col-md-6">
                                    <label for="country">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{ old('country') }}" required placeholder="Country">
                                    @if ($errors->has('country'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" name="state" placeholder="State" value="{{ old('state') }}" >          
                                </div>                        
                                <div class="col-md-6">
                                    <label for="dateFormat">Date Format <span class="text-danger">*</span> </label>
                                    <select name="dateFormat" required class="form-control">
                                        <option value="d/m/Y"> 16/03/2019 (DD/MM/Year) </option>
                                        <option value="d-m-Y"> 16-03-2019 (DD-MM-Year) </option>
                                        <option value="Y/m/d"> 2019/03/16 (Year/MM/DD) </option>
                                        <option value="Y-m-d"> 2019-03-16 (Year-MM-DD) </option>
                                        <option value="m/d/Y"> 03/16/2019 (MM/DD/Year) </option>
                                        <option value="m-d-Y"> 03-16-2019 (MM-DD-Year) </option>
                                        <option value="d-M,y"> 16-March,2019 (DD-MM,Year) </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6 col-sm-4">
                                    <label for="logo" >Logo</label><br>
                                    <input type="file" name="logo" accept="image/png,image/jpeg">
                                    @if ($errors->has('logo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Only .jpeg .png, .jpg are allow</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="col-6 col-sm-4">
                                    <label for="favicon">Favicon Logo</label><br>
                                    <input type="file" name="favicon" accept="image/png,image/jpeg">
                                    @if ($errors->has('favicon'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-sm-4 col-12 mt-10">
                                    <br>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active text-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            0%
                                        </div>
                                    </div>
                                </div>
                            </div>                                               
                            <div class="form-group text-right">
                                <button class="btn btn-primary " type="submit" id ="submit" >Install</button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                    <div class="alert alert-danger">
                        To Install this Application you have required php version 7.2.19 or higher. Your current php version is <b>{{ phpversion() }}</b>  .
                        <br>Please install php version <b>7.2.19</b> or higher and try again.
                    </div>
                @endif                
            </div>     
        </div>
    </div>
@endsection
