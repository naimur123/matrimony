        <div class="footer">
            <div class="container">
                <div class="col-md-3 col_2">
                    <h4>Useful Links</h4>
                    <ul class="footer_links">
                        <li><a href="{{ url('/packages') }}">Packages</a></li>
                        <li><a href="{{ url('/our-service') }}">Services</a></li>
                        <li><a href="{{ url('/success-story/view-all') }}">Success Story</a></li>
                        <li><a href="{{ url('/blog') }}">Blog</a></li>
                        <li><a href="{{ url('/testimonial/view-all') }}">Testimonial</a></li>
                        <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                        <li><a href="{{ url('/news') }}">News</a></li>
                        
                    </ul>
                </div>                
                <div class="col-md-3 col_2">
                    <h4>Address</h4>
                    <ul class="footer_links">
                        <li><i class="fas fa-map-marker-alt"></i>  {{ isset($system->id) ? ($system->address .' '.$system->city .' '. $system->country) : 'N/A'}} </li>
                        <li><i class="far fa-envelope"></i>  {{ isset($system->id) && !is_null($system->email) ? $system->email : 'N/A'}}</li>
                        <li><i class="fas fa-phone-alt"></i>  {{ isset($system->id) && !is_null($system->phone) ? $system->phone : 'N/A'}}</li>
                        <li style="color:red;"><i class="fas fa-phone-alt"></i>  01722063276 (Hot Line). </li>
                    </ul>
                </div>
                <div class="col-md-3 col_2">
                    <h4>Support</h4>
                    <ul class="footer_links">
                        <li><a href="{{ url('/user-manual') }}">User Manual</a></li>
                        <li><a href="{{ url('/about-us') }}">About us</a></li>
                        <li><a href="{{ url('/privacy-policies') }}">Privacy Policies</a></li>
                        <li><a href="{{ url('/terms-regulations') }}">Terms and Conditions</a></li>
                        <li><a href="{{ url('payment-options') }}">Payment Option</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col_2">
                    <h4>Social</h4>
                    <ul class="footer_social">
                        @foreach($social_icons as $icon)
                            <li><a href="{{ $icon->link }}"><i class="{!! $icon->icon !!} fa1"> </i></a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-10 col-md-11 text-center">
                            <img src="{{ asset('payment.png') }}" class="img-responsive">
                        </div>
                        <div class="col-sm-2 col-md-1 text-center">
                            <img src="{{ asset('ssl.png') }}" class="img-responsive" style="height: 30px; visible:false;display: none;">
                        </div>
                    </div>
                </div>

                <div class="clearfix"> </div>
                <div class="copy">
                    <p>Copyright © {{ date('Y') }} {{ isset($system->id) ? $system->application_name : env('APP_NAME') }} . All Rights Reserved. Developed by <a href="https://lamptechs.com" target="_blank">lamptechs.com</a>.   </p>
                </div>
            </div>
        </div>

        <!-- Sweet Alert -->
        <script type="text/javascript" src="{{asset('backEnd/js/form.js')}}?v=03"></script> 
        <script type="text/javascript" src="{{asset('frontEnd/js/location.js')}}?v=03"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <!-- Select 2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="https://kit.fontawesome.com/44b3c46ddf.js" crossorigin="anonymous"></script>

        @yield('script') 
        @php
            if(Session::has('output')){
                $output = Session::get('output');
                
                if($output['status']){
                    echo "<script> successMessage('".$output['message'] ."',".$output['button']." ); </script>";   
                }else{
                    echo '<script> errorMessage("'. $output['message'] .'"); </script>';
                }
                
            }
        @endphp
        <style>
            .swal2-popup{width: 25em; padding:0px 0px 10px 0px; font-size: .8rem;}
        </style>

        <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        document.addEventListener('contextmenu', event => event.preventDefault());
        @if( !Auth::user() )
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/5eeb06579e5f69442290ccaa/default';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        @endif
    </script>


    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1328084590856617');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1328084590856617&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179600660-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-179600660-1');
    </script>
            
            </body>
        </html>	