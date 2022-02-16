@extends('backEnd.masterPage')
@section('mainPart')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                SEO Section
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'post','route'=>'seo','class'=>'ajax-form']) !!}
                        <input type="hidden" name="id" value="{{isset($data->id)?$data->id:'0'}}">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">  
                                    <textarea name="seo" class="form-control" placeholder="Write your SEO Tags Here( html Raw Code )"  style="height:250px;border-radius:5px;">{{isset($data->id)?$data->seo:''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        
                            <button type="submit" name="btn" class="btn btn-primary form-control">Save Information </button>
                        </div>

                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection

