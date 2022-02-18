@extends('frontEnd.masterPage')
@section('style')

  <style>
    .circle-box{height: 100px;width:100px; border-radius: 150px;margin:0px auto;}
    .text-white{ color:#fff;} .padding-no{padding: 0px;}
    .pricing-table-grid li{padding: 10px 0; display: block; text-decoration: none; font-size: 0.85em; color: #555;}
    .pricing-table {padding-left: 0;background: #fff; box-shadow: 2px 4px 15px #999; border-radius: 5px; border:1px solid transparent;margin-top:15px;}
    .pricing-table-grid, .pricing-table-grid:hover{ border: none;}
    .pricing-table:hover{border:1px solid #428bca;}
    .pricing-heading{background: #ffa417; padding-top: 12px !important; padding-bottom: 12px !important ; width: 100%;color:#fff !important;}
    #home-form{background:#ecf0f1; opacity: 0.9; padding:15px 0px; border-top-left-radius:5px;border-top-right-radius:5px; border-bottom-left-radius:5px;border-bottom-right-radius:5px; }
    #home-form ul li{list-style-type:none;display: inline; float left;padding:0px 3px;}
    .looking-for img{cursor: pointer; height: 45px;}
    #home-form .btn{padding: 6px 20px;height: 35px;background: #ff512f;}
    #home-form .active{background: #dd2476;}
    .selected{ border:1px solid #428bca; padding: 5px;}
    .home-religion .btn-default:hover, .home-religion .btn-default:focus, .home-religion .btn-default:active, .home-religion .btn-default.active{ background: #DD2476; color:#fff;}
    @media (min-width:1200px){
      #home-form{width:62%;margin:0px auto;}
    }
    @media (max-width:584px){
        #home-form .btn{padding: 6px 8px;}
    }
    @media( min-width:585px) and (max-width:767px){
      .looking-for{width:33% !important;}
      .religion{width:67% !important;}
      .age-limit{width:65% !important;}
      .find-match-btn-div{width:35% !important;}
      .find-match-btn-div .col-sm-12{text-align: left !important;}

      .looking-for img{cursor: pointer; height: 32px;}
      #home-form .btn{padding: 6px 12px;}
    }
  </style>
@stop
@section('mainPart')
  <div class="banner" style="background : url('{{ asset(isset($banners->image_path) ? $banners->image_path : Null) }}') no-repeat center top;background-size:cover;">
  </div>

  <!--Register Helper Form -->
  <div class="container" style="margin: -135px auto;">

    <form id="home-form" class="row" >
      <!-- Looking for -->
      <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 looking-for" style="margin:5px 0px; ">
        <div class="row">
          <ul>
            {{-- <li>
              <input type="hidden" value="bride" id="home-looking-for" >I'm Looking For
            </li> --}}
            {{-- <li><img src="{{ asset('female.png') }}" data-looking_for="bride" class="img-responsive img-thumbnail selected"></li>
            <li><img src="{{ asset('male.png') }}" data-looking_for="groom" class="img-responsive img-thumbnail"></li> --}}
            <label style="margin-left: 1em">I'm Looking For</label>
            <select style="margin-left: 1em; width: 41% !important;">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
          </ul>
        </div>
      </div>
       <!-- Age Limit -->
       <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 age-limit" style="margin:5px 0px;">
        <div class="row">
           <div >Aged</div>
           <br>
           <div>
             <input class="form-control" id="home-min_age" placeholder="From:" style="width: 30%; height:1.5em; margin-left: -1em; margin-top: -1em; float: left;" type="text" value="18">
             <input type="text" readonly class="form-control text-center padding-no" style="width: 20%; margin-top: -1.5em; float: left; border: none; background: transparent;" type="text" value="to">
             <input class="form-control" id="home-max_age" placeholder="To:" style="width: 30%; height:1.5em; margin-left: 0em; margin-top:-1em;  float: left;" type="text" value="25">
           </div>
        </div>
   </div>

      <!-- Religion -->
      <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 religion " style="margin:5px 0px;">
        <div class="row">
        <ul>
        <div style="margin-left: -1em;">Religion</div>
        <select style="margin-left: -1.5em; margin-top:0.5em; width: 22% !important;">
          <option value="">Select</option>
          @foreach($religious as $religion)
              <option value="{{ $religion->id }}" > {{ $religion->name }} </option>
          @endforeach
        </select>
        </ul>

          {{-- <ul>
            <li><input type="hidden" id="home-religion" >Religion</li>
            <li class="home-religion">
              <div class="btn-group" data-toggle="buttons">
                @foreach($religious as $religion)
                <label class="btn btn-default">
                    <input type="radio" value="{{$religion->id}}" > {{ $religion->name }}
                </label>
                @endforeach
              </div>
            </li>
          </ul> --}}
        </div>
      </div>

      <!--Living In-->
      <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 " style="margin:5px 0px;">
        <div class="row">
          <ul>
        <div style="margin-left: 6em; margin-top: -4em;">Living In</div>
        <select style="margin-left: 8em; margin-top: 0.5em; width: 22% !important;">
          <option value="">Select</option>
          @foreach($countries as $country)
              <option value="{{ $country->id }}" > {{ $country->country }} </option>
          @endforeach
        </select>
        </ul>

          {{-- <ul>
            <li><input type="hidden" id="home-religion" >Religion</li>
            <li class="home-religion">
              <div class="btn-group" data-toggle="buttons">
                @foreach($religious as $religion)
                <label class="btn btn-default">
                    <input type="radio" value="{{$religion->id}}" > {{ $religion->name }}
                </label>
                @endforeach
              </div>
            </li>
          </ul> --}}
        </div>
      </div>


      <div class="col-xs-12 col-sm-6 col-md-12 find-match-btn-div" style="margin:10px 0px 0px 0px;">
        <div class="row">
          <div style="margin-left: 35em; margin-top: -3.5em;">
            <button type="submit" class="btn btn-primary" style="padding: 0px 24px; border-radius: -5px;">Find Match</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- Find SomeOne -->
  <div class="grid_2" style="margin-top: 30px;">
    <div class="container">
      <div class="row">
        <div class="col-sm-12" style="margin-top: 45px;"><h2 class="text-center"  style="color:#c21038">Find your Special Someone</h2></div>
      </div>
      <div class="row" style="margin-top: 30px;">
        <div class="col-sm-4 text-center">
            <div class="circle-box" >
              <a href="{{ url('/register') }}"  class="user-auth text-info">
                <img src="{{ asset('Image-01.png') }}" class="img-responsive  img-circle" >
              </a>
            </div>
            <br>
            <a href="{{ url('/register') }}"  class="user-auth fa-2x" style="color:#c21038"> Sign Up </a>
            <p>Register for free & put up your Profile</p>
        </div>

        <div class="col-sm-4 text-center">
          <div class="circle-box" >
            <a href="{{ url('/register') }}"  class="user-auth text-info" >
              <img src="{{ asset('Image-02.png') }}" class="img-responsive img-circle" >
            </a>
          </div>
          <br>
          <a href="{{ url('/register') }}"  class="user-auth fa-2x" style="color:#c21038"> Connect </a>
          <p>Select & Connect with Matches you like</p>
        </div>

        <div class="col-sm-4 text-center">
          <div class="circle-box" >
            <a href="{{ url('/register') }}"  class="user-auth text-info" >
              <img src="{{ asset('Image-03.png') }}" class="img-responsive img-circle" >
            </a>
          </div>
          <br>
          <a href="{{ url('/register') }}"  class="user-auth fa-2x" style="color:#c21038"> Interact </a>
          <p>Become a Premium Member & Start a Conversation</p>
        </div>

      </div>
    </div>
  </div>

  <!-- Member find Love -->
  <div class="grid_2" style="margin-top: 30px; background: #eee; padding: 30px 0px 15px 0px;">
    <div class="container">
      <div class="row" >
        {{-- <div class="col-sm-12"><h2 class="text-center">Member Who Have Found Love</h2></div> --}}
        <div class="col-sm-12"><h2 class="text-center" style="color:#c21038; letter-spacing: 0.41px;"> We Service with Millions of Success Stories</h2></div>
      </div>
      <div class="row" style="margin-top: 30px;margin-bottom: 30px;">
        @foreach($success_stories as $story)
          <div class="col-sm-3 text-center">
              <div style="margin-top: 10px;" >
                  <a href="{{ url('/success-story/view-story/'.$story->slug) }}" target="_blank">
                      <img width="120" src="{{ asset($story->image_path) }}" class="text-info img-circle" style="height:150px;" />
                  </a>
              </div>
              <br>
              <h4><b>{{ $story->title }}</b></h4>
              <p> {!! substr($story->description, 0, 250) !!} <p>
          </div>
        @endforeach
          <div class="col-xs-12 text-center" style="margin-top: 20px;">
              <a href="{{ url('success-story/view-all/') }}" target="_blank" class="btn btn-info"> Read Success Story</a>
          </div>
      </div>
    </div>
  </div>
  <div class="grid_2" style="margin-top: -78px; background: #c21038; padding: 30px 0px 15px 0px; text-align: center;">
    <p style="font: italic normal normal 27px/32px Lucida Bright; color: #FFFFFF;">Your Story is wating to happen! <a class="btn btn-light" href="{{ url('/register') }}" role="button" style="color:#fff;">Get Started</a></p>
  </div>

  <!-- Testimonial  -->
  <div class="grid_2" style="margin-top: 30px; margin-bottom:2em; background: #fff; padding: 30px 0px px 0px;">
    <div class="container">
      <div class="row" >
        <div class="col-sm-12"><h2 class="text-center">Testimonial</h2></div>
      </div>
      <div class="row" style="margin-top: 30px;margin-bottom: 30px;">
        @foreach($testimonials as $testimonial)
          <div class="col-sm-3 text-center">
              <div style="margin-top: 10px;" >
                  <a href="{{ url('testimonial/view-testimonial/'.$testimonial->slug) }}" >
                      <img width="120" src="{{ asset($testimonial->image_path) }}" class="text-info img-circle" style="height:150px;" />
                  </a>
              </div>
              <br>
              <h4><b>{{ $testimonial->title }}</b></h4>
              <p> {!! substr($testimonial->description, 0, 250) !!} <p>
          </div>
        @endforeach
          <div class="col-xs-12 text-center" style="margin-top: 20px;">
              <a href="{{ url('testimonial/view-all/') }}" target="_blank" class="btn btn-info"> Read Testimonial</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Our Package -->
  <div class="grid_2" style="background: #eee; padding-top:30px;padding-bottom: 30px;">
    <div class="container">
      <div class="row" >
        <div class="col-sm-12"><h2 class="text-center">Our Packages</h2></div>
      </div>
      <div class="row" style="padding-top: 30px;">
        @foreach($packages as $package)
          <div class="col-sm-3 text-center">
            <div class="pricing-table">
              <div class="pricing-table-grid">
                  <h3 class="pricing-heading bg-primary">{{ $package->title }}</h3>
                  <h3><span class="dollar">{{ $system->currency}}.</span> {{number_format($package->current_fee)}}<br></h3>
                  <ul>
                      <li> <img src="{{ file_exists($package->image_path) ? asset($package->image_path) : asset('image-not-found.png') }}" class="img-responsive" style="height:200px;"> </li>
                      <li><i class="fa fa-check-square icon_3"></i> Duration ({{ $package->duration }} {{ ucfirst($package->duration_type.'s') }})</li>
                      <li> <i class="fa fa-eye icon_3"></i> Profile View (Unlimited) </li>
                      <li> <i class="fa fa-envelope icon_3"></i>Send Unlimited Message</li>
                      <li> <i class="fas fa-location-arrow"></i> Total Proposal ({{ $package->total_proposal }}) </li>
                      <li> <i class="fas fa-reply-all"></i> Total Daily Proposal ({{ $package->daily_proposal }}) </li>
                      <li> <i class="fa fa-user icon_3"></i> View Contact Details ({{ $package->profile_view }}) </li>

                    {{-- <li> <i class="fa fa-download icon_3"></i>Download Biodata (Unlimited)</li> --}}
                  </ul>
              </div>
            </div>
          </div>
        @endforeach
        <div class="col-xs-12 text-center" style="margin-top: 20px;">
            <a href="{{ url('/packages') }}" target="_blank" class="btn btn-info"> Show All Package</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Our Services -->
  <div class="grid_2" style=" background: #fff; padding: 30px 0px 15px 0px;">
    <div class="container">
      <div class="row">
        <div class="col-sm-12"><h2 class="text-center">Our Services</h2></div>
      </div>
      <div class="row" style="margin-top: 30px;">
        @foreach($our_services as $service)
          <div class="col-sm-4 text-center">
              <div class="circle-box" >
                <a href="javascript:;" class="text-info" >
                  <img src="{{ asset('service'.$loop->iteration.'.png') }}" class="img-responsive img-thumbnail img-circle" >
                </a>
              </div>
              <br>
              <a href="javascript:;" class="fa-2x text-info"> {{ $service->title }} </a>
              <p>{!! substr($service->description, 0, 150) !!}</p>
          </div>
        @endforeach
        <div class="col-xs-12 text-center" style="margin-top: 20px;">
          <a href="{{ url('/our-service') }}" target="_blank" class="btn btn-info"> Read Our Sercives</a>
        </div>
      </div>
    </div>
  </div>


@stop
@section('script')
    <script>
      $(document).on('submit', '#home-form', function(e){
        e.preventDefault();
        if($('#home-religion').val() == ""){
          alert('Select Religion First');
          return false;
        }
        let button = $(this).find('button[type=submit]');
        let buttonText = button.html();
        button.html('loading...');
        $.ajax({
            url : "{{ url('/register') }}",
            success : function(output){
                $('.auth-modal').html(output);
                $('.auth-modal').modal('show');
                $("select[name='religious_id']").val($('#home-religion').val());
                $("select[name='religious_id']").change();
                $("input[name=looking_for][value=" + $('#home-looking-for').val() + "]").prop('checked', true);
                $('#partner_min_age').val( $('#home-min_age').val());
                $('#partner_max_age').val( $('#home-max_age').val());
                button.html(buttonText);
            },
            error : function (response){
                self.html(buttonText)
                errorMessage(getError(response));
                modal.modal('hide');
            }
        });

      });

      $(document).on('click', '.looking-for img', function(){
        $('.looking-for img').removeClass('selected');
        $(this).addClass('selected');
        $('#home-looking-for').val($(this)[0].dataset.looking_for);
      });

      $(document).on('change','.home-religion input', function(){
        $('#home-religion').val( $(this).val() );
      })

      @if( isset($_GET['signup']) )
        $(document).ready(function(){
          $('.user-register').click();
        });
      @endif
    </script>


@endsection
