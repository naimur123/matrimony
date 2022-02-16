@extends('frontEnd.masterPage')
@section('title')
    Search ||
@stop
@section('style')
    <style>
        .box-effect{border:1px solid #ddd; border-radius: 5px; padding: 10px 15px;margin:0px;}
        .box-effect:hover{ background: rgb(250, 235, 204);cursor: pointer;}
        .mt-20{margin-top: 20px;}
        .time-stamp{font-size: 12px; color:#aaa;}
        .btn{border-radius: 0px;}
        .input-range{width: 46%; float: left; margin-right: 2%;}
    </style>
@stop
@section('mainPart')

<!-- Available Subscription Packages -->
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">Advance Search</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row mt-20">
            <div class=" col-md-9">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 mt-20" style="border:1px solid #eee;">
                        {!! Form::open(['url' => 'advance-search','method'=> 'post','class'=>'advance-search']) !!}
                            <div class="form-group">                                        
                                <label>Partner Min Age</label>
                                <input type="number" class="form-control" name="partner_min_age" step="1" min="15" max="80" value="18">
                            </div>
                            <div class="form-group">
                                <label>Partner Max Age</label>
                                <input type="number" class="form-control" name="partner_max_age" step="1" min="15" max="80" value="80">
                            </div>
                            <div class="form-group">
                                <label>Partnet Max. Height <span class="text-danger">*</span></label><br>
                                <div class="row" style="margin: 0px;">
                                    <select class="form-control" style="width:47%;float:left" required name="part_min_feet" >
                                        <option value="3" >3 Feet</option>
                                        <option value="4" >4 Feet</option>
                                        <option value="5" >5 Feet</option>
                                        <option value="6" >6 Feet</option>
                                        <option value="7" >7 Feet</option>
                                        <option value="8" >8 Feet</option>
                                    </select>
                                    <select class="form-control" style="width:47%;float:left; margin-left:2%;" required name="part_min_inch" >
                                        <option value="0" >0 Inch </option>
                                        <option value="1" >1 Inch </option>
                                        <option value="2" >2 Inch </option>
                                        <option value="3" >3 Inch </option>
                                        <option value="4" >4 Inch </option>
                                        <option value="5" >5 Inch </option>
                                        <option value="6" >6 Inch </option>
                                        <option value="7" >7 Inch </option>
                                        <option value="8" >8 Inch </option>
                                        <option value="9" >9 Inch </option>
                                        <option value="10" >10 Inch </option>
                                        <option value="11" >11 Inch </option>
                                        <option value="12" >12 Inch </option>
                                    </select>
                                </div>                                        
                            </div>
                            <div class="form-group">
                                <label>Partnet Max. Height <span class="text-danger">*</span></label><br>
                                <div class="row" style="margin: 0px;">
                                    <select class="form-control" style="width:47%;float:left" required name="part_max_feet" >
                                        <option value="3"  >3 Feet</option>
                                        <option value="4"  >4 Feet</option>
                                        <option value="5"  >5 Feet</option>
                                        <option value="6" >6 Feet</option>
                                        <option value="7"  >7 Feet</option>
                                        <option value="8" selected >8 Feet</option>
                                    </select>
                                    <select class="form-control" style="width:47%;float:left; margin-left:2%;" required name="part_max_inch" >
                                        <option value="0" >0 Inch </option>
                                        <option value="1" >1 Inch </option>
                                        <option value="2" >2 Inch </option>
                                        <option value="3" >3 Inch </option>
                                        <option value="4" >4 Inch </option>
                                        <option value="5" >5 Inch </option>
                                        <option value="6" >6 Inch </option>
                                        <option value="7" >7 Inch </option>
                                        <option value="8" >8 Inch </option>
                                        <option value="9" >9 Inch </option>
                                        <option value="10" >10 Inch </option>
                                        <option value="11" >11 Inch </option>
                                        <option value="12" >12 Inch </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Profession</label>
                                <select name="profession_id[]" class="form-control select2" multiple placeholder="Select Profession" >
                                    @foreach($professions as $profession)
                                        <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                    @endforeach
                                </select>
                            </div>   
                            <div class="form-group">
                                <label>Education</label>
                                <select name="education_id[]" class="form-control select2" multiple placeholder="Select Profession" >
                                    <option value="">Select from list</option>
                                    @foreach($educations as $education)
                                        <option value="{{ $education->id }}">{{ $education->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Religion</label>
                                <select name="religious_id[]" class="form-control select2" multiple>
                                    <option value="">Select from list</option>
                                    @foreach($religious as $religion)
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country[]" class="form-control select2" multiple>
                                    <option value="">Select from list</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->country }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <select name="city[]" class="form-control select2" multiple>
                                    <option value="">Select from list</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->city }}">{{ $city->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label> &nbsp; </label>
                                <button type="submit" class="btn btn-info form-control">Find Match</button>
                            </div>   
                        {!! Form::close() !!}
                    </div>

                    <div class="col-xs-12 col-sm-8 mt-20 search-result"></div>
                </div>
            </div>
            <div class="col-md-3 mt-20 chatting-section" style="padding: 0px 0px 0px 30px;">
                <h3> Online </h3>
                <hr/>
                @include('frontEnd.chatting.chat')
            </div>
        </div>      
    </div>
</div>
@stop
@section('script')
    <script>
        var data_load_url = "";
        $(document).ready(function(){
            $('.advance-search').submit();
        });

        $('input, select').change(function(){
            $('.advance-search').submit();
        });

        $(document).on('submit','.advance-search', function(e){
            e.preventDefault();
            let form = $(this);
            let method = form.attr('method'); 
            let button = form.find('button[type=submit]');
            let buttonText = "Find Match";
            button.text('Loading...');
            button.attr('disabled',true);        
            let data = new FormData($(this)[0]); 
            if(data_load_url == ""){
                data_load_url = form.attr("action");
            }
            $.ajax({
                type: method,
                url: data_load_url,
                data: data,
                contentType: false,
                cache: false,
                processData:false,
                success:function(output){                    
                    if(output.status){
                        $('.search-result').html(output.data)
                    }else{
                        errorMessage(output.message)
                    }                                    
                    button.html(buttonText);
                    button.removeAttr('disabled');
                },
                error : function(response){
                    errorMessage(getError(response));
                }
            });
        });

        $(document).on('click', '.sent-invitation', function(e){
            e.preventDefault();
            let self = $(this);
            if(self[0].dataset.is_sent == 1){
                alert('You already Sent the proposal');
                return false;
            }

            let buttonText = self.html();            
            self.html('Sending...');
            $.ajax({
                url : $(this).attr('href'),
                method : 'GET',
                success : function(output){
                    if(output.status){
                        self.html('Invitation Sent')
                        successMessage(output.message, output.button);                
                    }else{
                        self.html(buttonText);
                        errorMessage(output.message)
                    }
                },
                error : function (response){
                    self.html(buttonText)
                    errorMessage(getError(response));
                }
            });
        });
        
        $(document).on('click', '.cancel-invitation', function(e){
            e.preventDefault();
            let self = $(this);
            if(self[0].dataset.is_cancel == 1){
                alert('you don\'t sent any proposal to this Person');
                return false;
            }

            let buttonText = self.html();            
            self.html('canceling...');
            $.ajax({
                url : $(this).attr('href'),
                method : 'GET',
                success : function(output){
                    if(output.status){
                        self.html('canceled')
                        successMessage(output.message, output.button);                
                    }else{
                        self.html(buttonText);
                        errorMessage(output.message)
                    }
                },
                error : function (response){
                    self.html(buttonText)
                    errorMessage(getError(response));
                }
            });
        });

        $(document).on('click','.pagination .page-link', function(e){
            e.preventDefault();
            data_load_url = $(this).attr('href');
            $('.advance-search').submit();
        });

    </script>
@endsection