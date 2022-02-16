@extends('backEnd.masterPage')
@section('mainPart')
    <div class=" container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class=" card-header">Send Message</div>
                    {!! Form::open(['url' => 'subscribe/send-email','method' => 'post','id' => 'ajax-form','class' => 'form-horizontal']) !!}
                    <div class="card-body row">                        
                        <div class="col-12 col-sm-6 form-group">
                            <label><b>Email Subject</b></label>
                            <input type="text" name="subject" class="form-control" required placeholder="Subject Here">
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <div style="height:200px;width:100%;overflow:auto;padding:10px 15px; border:1px solid #eee;">
                                <label><b>Select Emails</b></label><br>
                                @foreach($lists as $list)
                                    <label><input type="checkBox" value="{{$list->email}}" name="email_list[{{$loop->iteration}}]"> {{$list->email}}</label><br>
                                @endforeach                
                            </div>
                        </div>
                        <div class="col-12 form-group">
                            <textarea name="message" id="editor" class="form-control" required placeholder="Write a message Here"></textarea>
                        </div> 
                        <div class="col-12 form-group">
                            <button type="submit" id="submit" class="btn btn-primary"> Send Email Now</button>
                        </div>                       
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection