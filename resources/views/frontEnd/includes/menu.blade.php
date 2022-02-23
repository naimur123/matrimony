@if( !Auth::user() && isset($index_page) )
	<style>
		.navbar-default{background-color: transparent !important; background-image: none;}
		.banner{margin-top: -125px;}
		.navbar-brand img{height: 100px;width:65px}
		.navbar-default .navbar-nav > li > a{ color:#fff; font-size: 15px;display: inline !important; float: right;}
		.nav > li > a:hover, .nav > li > a:focus{background: none !important;}
		.navbar-nav{ position: absolute; right: 80px; top: 30px; }

		@media (max-width:767px){
			.navbar-nav{ position: absolute; right: 50px; top: 20px; }
            .fa-user-circle{font-size: 0.5em;}
            .fa-edit{font-size: 0.5em;}
			.navbar-default .navbar-nav > li > a{ color:#fff; font-size: 5px;display: inline !important; float: right; padding: 10px}
		}
	</style>
@else
<style>
	/* .navbar-brand img{height:100px; weight: 105px; } */
	.banner-form{padding-top:30%;padding-bottom:50px;}
</style>
@endif
<!-- ============================  Navigation Start =========================== -->
<nav class="navbar navbar-default {{ !Auth::user() && isset($index_page) ? Null : 'navbar-fixed-top' }}">
	<div class="container-fluid">
	  <!-- Brand and toggle get grouped for better mobile display -->
	  <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed {{ !Auth::user() && isset($index_page) ? 'hidden-xs' : Null}}" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="{{ url('/')}}">
			<img src="{{ isset($system->logo) ? asset($system->logo) : Null }}" alt="{{env('APP_NAME')}}" style="height: 110px; width: 100px;" >
		</a>

	  </div>

	  <!-- Collect the nav links, forms, and other content for toggling -->
	  <div class="{{ !Auth::user() && isset($index_page) ? Null : 'collapse navbar-collapse' }}" id="bs-example-navbar-collapse-1">



		<ul class="nav navbar-nav">
			@guest
				{{-- <li><a href="{{ url('/register) }}" ><i class="fa fa-edit"></i> Register</a></li> --}}
				@if( !isset($index_page) )
					<li><a href="{{ url('/')}}">Home</a></li>
					<li><a href="{{ url('/blog')}}">Blog</a></li>
					<li><a href="{{ url('/packages')}}">Packages</a></li>
					<li><a href="{{ url('/our-service')}}">Our service</a></li>
					<li><a href="{{ url('/login') }}" class="user-auth" ><i class="fas fa-user-circle"></i> Login <i class="fas fa-angle-down"></i> </a></li>
					<li><a href="{{ url('/register') }}" class="user-auth user-register" ><i class="fas fa-edit"></i> Register </a></li>
				@else
					<li>
					    {{-- <a style="font-size:22px;color:white;font-weight: bold;margin-bottom: -60px;margin-top: -30px;"> [ Hotline: +8801722063276 ]</a> <br/> --}}
						<a style="font-size:22px;" href="{{ url('/login') }}" class="user-auth" ><i class="fas fa-user-circle"></i> Login <i class="fas fa-angle-down"></i> </a>
						<a style="font-size:22px;" href="{{ url('/register') }}" class="user-auth user-register" ><i class="fas fa-edit"></i> Register </a>
					</li>
				@endif
			@else
				<li><a href="{{ url('/home')}}">Home</a></li>
				<li><a href="{{ url('/packages')}}">Packages</a></li>
				<li><a href="{{ url('/advance-search') }}">Advance Search</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Messages <span class="badge">{{ $new_message }}</span> <span class="caret"></span></a>
					<ul class="dropdown-menu menu-message-list" role="menu">
						@foreach($chatMessages as $message)
							@if( $message->from_id == Auth::user()->id )
								<li>
									<a class="list-group-item chat-list" href=":javascript;" data-name="MMBD-{{$message->toUser->id}}" data-to_id="{{$message->toUser->id}}"  title="MMBD-{{ $message->toUser->id }}">
										<img src="{{ isset($message->toUser->profilePic) && file_exists($message->toUser->profilePic->image_path) ? asset($message->toUser->profilePic->image_path) : asset('dummy-user.png') }}" width="25" class="img-circle"> &nbsp;
											MMBD-{{ $message->toUser->id }}
										<div class="online-signal"></div>
										<div class="clearfix"></div>
									</a>
								</li>
							@else
								<li>
									<a class="list-group-item chat-list" href=":javascript;" data-name="MMBD-{{$message->fromUser->id}}" data-to_id="{{$message->fromUser->id}}"  title="MMBD-{{ $message->fromUser->id }}">
										<img src="{{ isset($message->fromUser->profilePic) && file_exists($message->fromUser->profilePic->image_path) ? asset($message->fromUser->profilePic->image_path) : asset('dummy-user.png') }}" width="25" class="img-circle"> &nbsp;
											MMBD-{{ $message->fromUser->id }}
										<div class="online-signal"></div>
										<div class="clearfix"></div>
									</a>
								</li>
							@endif

						@endforeach
					</ul>
				</li>
				<li><a href="{{ url('/notification/list')}}">Notification <span class="badge">{{ count(Auth::user()->newNotification) }}</span></a></li>
				<li><a href="{{ url('/profile')}}"><i class="fa fa-user"></i> Profile</a></li>
				<li><a href="{{ url('/connected')}}">Connected</a></li>
				<li class="last"><a href="{{ url('/contact')}}">Contacts</a></li>
				<li><a href="{{ url('/logout')}}"><i class="fa fa-sign-out"></i> Logout</a></li>
			@endguest
		</ul>
	  </div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
  </nav>

<!-- ============================  Navigation End ============================ -->

@guest
	<div class="modal auth-modal fade" keyboard="false" data-backdrop="static" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header text-center" style="border:none;">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<img src="{{ isset($system->logo) ? asset($system->logo) : Null }}">
				</div>
			</div>
		</div>
	</div>
@endguest
