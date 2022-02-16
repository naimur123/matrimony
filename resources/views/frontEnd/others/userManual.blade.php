
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <title>User manual | marriagematchbd.com</title>
</head>


<body>

@extends('frontEnd.masterPage')
@section('title')
      User manual
@stop
@section('mainPart')


<!-- Page Content -->
<div class="container grid_3">

  <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0" ><b> How to Registration </b></h1>
  
  <h4 class="font-weight-light text-center text-lg-left mt-4 mb-0"  style="color:red;">Please fill up all mandatory fields while registration. After successful registration you will get successful email notification. Free members need to wait for admin approval then they will use as per as their free subscription package. Paid members can visit everything but admin can decline any users due to violate privacy policy and terms & conditions.</h4>

  <hr class="mt-2 mb-5">

  <div class="row text-center text-lg-left">

    <div class="col-lg-4 col-md-4 col-6">
		  <h2>Step 1</h2>
		  <a href="#" >
            <img class="img-fluid img-thumbnail" src="{{ asset('img/firststep.png') }}" alt="">
          </a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
	<h2>Step 2</h2>
      <a href="#">
            <img class="img-fluid img-thumbnail" src="{{ asset('img/secstep.png') }}" alt="">
          </a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
	<h2>Upload Picture </h2>
      <a href="#">		
            <img class="img-fluid img-thumbnail" src="{{ asset('img/thirdstep.png')}}" alt="" width="800" height="700">
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
      <h2>Basic Profile</h2>
      <a href="#">		
            <img class="img-fluid img-thumbnail" src="{{ asset('img/basicprofile.png')}}" alt="" width="800" height="700">
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
      <h2>Family Information</h2>
      <a href="#">		
            <img class="img-fluid img-thumbnail" src="{{ asset('img/familyinfo.png') }}" alt="" width="800" height="700">
      </a>
    </div>
	<div class="col-lg-4 col-md-4 col-6">
      <h2>Address</h2>
      <a href="#">		
            <img class="img-fluid img-thumbnail" src="{{ asset('img/address.png') }}" alt="" width="800" height="700">
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
      <h2>Education & Career</h2>
      <a href="#">		
            <img class="img-fluid img-thumbnail" src="{{ asset('img/education.png') }}" alt="" width="800" height="700">
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
      <h2>Partner Information </h2>
      <a href="#">		
            <img class="img-fluid img-thumbnail" src="{{ asset('img/lifepartner.png') }}" alt="" width="800" height="700">
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
      <h2>Package Subscribe </h2>
      <a href="#">		
            <img class="img-fluid img-thumbnail" src="{{ asset('img/package.png') }}" alt="" alt="" width="800" height="700">
      </a>
    </div>
	
	<div class="col-lg-4 col-md-4 col-6">
      <h2>Instruction </h2>
      <a href="#">		
            <img class="img-fluid img-thumbnail" src="{{ asset('img/instruct.png') }}" alt="" alt="" width="800" height="700">
      </a>
    </div>

  </div>

</div>
<!-- /.container -->

@endsection