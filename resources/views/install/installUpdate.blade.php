@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8" style="margin-top:2%;margin-bottom: 2%;">                
                @if(phpversion() >= 7.1)
                <div class="card" style="background: #999;opacity:.9; color:#fff;">
                    <div class="card-header">Install Update</div>
                    <div class="card-body">
                    {!! Form::open(['url'=>'install/update','method'=>'post']) !!}
                        <div class="form-group text-center">
                            Installed Version is : V-{{$system->version}}<br>
                            Found New Version is : V-{{config('setup.version')}}
                        </div>
                        <div class="form-group text-center">
                            <label>
                                <input type="checkbox" required=""> I Agree To Install New Updates 
                            </label>
                        </div>
                        
                    <div class="form-group text-right">
                        <button class="btn btn-primary ">Install Update</button>
                    </div>
                    {!!Form::close()!!}
                    </div>
                </div>
                @else
                    <div class="alert alert-danger">
                        To Install this Application you have required php version 7.1 or higher. Your current php version is <b>{{ phpversion() }}</b>  .
                        <br>Please install php version <b>7.1</b> or higher and try again.
                    </div>
                @endif                
            </div>     
        </div>
    </div>
@endsection
