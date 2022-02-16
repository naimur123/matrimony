
@extends('frontEnd.masterPage')
@section('title')
  Payment Options !!
@stop
@section('style')
  <style type="text/css">
      .card {
          position: relative;
          display: flex;
          flex-direction: column;
          background-color: #fff;
          background-clip: border-box;
          border: 1px solid rgba(0,0,0,.125);
          border-radius: .25rem;
        }
        .card-title {
            margin-bottom: .75rem;
        }
        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }
        .card-text {
            margin-top: 0;
            margin-bottom: 1rem;
        }
  </style>
@stop
@section('mainPart')
  <div class="container-fluid grid_3">
    <br/>
    <div class="row" >
      <div class="col-md-12 col-sm-12 col-xs-12 text-center" >
        <h1 style=""><b>Payment Information</b></h1>
      </div>
    </div>
    <br/>

    <div class="row">			   
			  <div class="col-md-2 col-sm-12 col-xs-12"></div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="card" style="width:400px;height:350px;">
            <img class="card-img-top" src="{{ asset('img/dbbl.png') }}" alt="Dutch Bangla Bank Account Number Marriage Maker BD" style="width:395px;height:100px;padding-top:20px;">
            <div class="card-body">
              <h4 class="card-title"> Dutch Bangla Bank Limited </h4>
              <p class="card-text"> A/C Title: Marriagematchbd.com </p>
              <p class="card-text"> A/C No: 178.110.0023184 </p>
              <p class="card-text"> Rampura Branch </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="card" style="width:400px;height:350px;">
            <img class="card-img-top" src="{{ asset('img/bkash.png') }}" alt="bKash Account Marriage Maker BD" style="width:395px;height:150px;">
            <div class="card-body">
              <h4 class="card-title">bKash </h4>
              <p class="card-text">Marchent Account: +8801722063276 </p>
            <p class="card-text">Personal Account: +8801976908420 </p>
            </div>
          </div>
        </div>

				<div class="col-md-2 col-sm-12 col-xs-12"></div>

			</div>

      <br/>

		<div class="row" >
		
		<div class="col-md-2 col-sm-12 col-xs-12"></div>
		
<div class="col-md-4 col-sm-12 col-xs-12">

<div class="card" style="width:400px;height:250px;">
  <img class="card-img-top" src="{{ asset('img/nagad.png') }}" alt="Nagad Account Marriage Maker BD" style="width:395px;height:150px;">
  <div class="card-body">
    <h4 class="card-title">Nagad</h4>
    <p class="card-text">Account No: +8801915567354 </p>
  </div>
</div>

</div>


<div class="col-md-4 col-sm-12 col-xs-12">

<div class="card" style="width:400px;height:250px;">
  <img class="card-img-top" src="{{ asset('img/rocket.png') }}" alt="Rocket Account Marriage Maker BD" style="width:400px;height:150px;">
  <div class="card-body">
    <h4 class="card-title">Rocket</h4>
    <p class="card-text">Account No: +88019155673547 </p>

  </div>
</div>

</div>

		<div class="col-md-2 col-sm-12 col-xs-12"></div>
			
		</div>

</div>
@endsection