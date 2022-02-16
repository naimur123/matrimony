@extends('frontEnd.masterPage')
@section('title')
    Contact us ||
@stop
@section('style')
    <style>
        .table > thead > tr > th{border: none;}
        .table .table-borderless tr td{border: none;}
    </style>
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">Contact</li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3>Contact Information</h3> <hr>
                <table class="table table-responsive table-borderless">
                    <thead class="table-borderless">
                        <tr>
                            <th>Email</th>
                            <th>:</th>
                            <td> {{ isset($system->id) && !is_null($system->email) ? $system->email : 'N/A'}} </td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <th>:</th>
                            <td> {{ isset($system->id) && !is_null($system->phone) ? $system->phone : 'N/A'}} </td>
                        </tr>
                        <tr>
                            <th>Whatsapp Number</th>
                            <th>:</th>
                            <td> {{ isset($system->id) && !is_null($system->phone) ? $system->phone : 'N/A'}} </td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <th>:</th>
                            <td> {{ isset($system->id) && !is_null($system->address) ? $system->address : 'N/A'}} </td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <th>:</th>
                            <td> {{ isset($system->id) && !is_null($system->city) ? $system->city : 'N/A'}} </td>
                        </tr>
                        
                        <tr>
                            <th>Country</th>
                            <th>:</th>
                            <td> {{ isset($system->id) ? $system->country : 'N/A'}} </td>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-6">
                {!! Form::open(['url' => 'contact','method' => 'post', 'class' => 'form-horizontal ajax-form']) !!}
                    <div class="form-group row">
                        <div class="col-12"> <h3>Get In Touch</h3> <hr> </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Name <span class="text-danger">*<span></label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name Here" required >
                        </div>
                        <div class="col-sm-6">
                            <label>Email <span class="text-danger">*<span></label>
                            <input type="email" name="email" class="form-control" placeholder="Example: something@gmail.com">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Subject <span class="text-danger">*<span></label>
                            <input type="text" name="subject" class="form-control" placeholder="Summary of your Openion" required >
                        </div>
                        <div class="col-sm-6">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Your cell phone number">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Message <span class="text-danger">*<span></label>
                            <textarea class="form-control" name="message" placeholder="Write your valueable Openion"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-info">Send Message</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection