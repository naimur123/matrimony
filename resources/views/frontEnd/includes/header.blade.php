<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <title> @yield('title') {{ $system->title_name ?? ucfirst( str_replace('_',' ', env('APP_NAME'))) }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="en-us">
        @if( isset($seo->seo) )
         {!! $seo->seo !!}
        @endif
        @yield('seo')
        @if( isset($system))        
            <!-- Favicon icon -->
            <link rel="icon" href="{{asset($system->favicon)}}" type="image/x-icon">        
        @endif

        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <link href="{{ asset('frontEnd/css/bootstrap-3.1.1.min.css') }}" rel="stylesheet" type="text/css" />
        
        <!-- Custom Theme files -->
        <link rel='stylesheet' type='text/css' href="{{ asset('frontEnd/css/style.css') }}?v=0.3"  />
        <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Oswald:300,400,700'  >
        <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' >
        <!----font-Awesome----->
        <link href="{{ asset('frontEnd/css/font-awesome.css') }}" rel="stylesheet"> 
        <!----font-Awesome----->

        <script src="{{ asset('frontEnd/js/jquery.min.js') }}?v=01"></script>
        <script src="{{ asset('frontEnd/js/bootstrap.min.js') }}?v=01"></script>
        <script>
        $(document).ready(function(){
            $(".dropdown").hover(            
                function() {
                    $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
                    $(this).toggleClass('open');        
                },
                function() {
                    $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
                    $(this).toggleClass('open');       
                }
            );
        });
        </script>
        @yield('style')     
    </head>

    <body>