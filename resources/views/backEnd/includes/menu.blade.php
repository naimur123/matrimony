<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header" style="background:#404E67;color:#fff;">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="{{route('dashboard')}}">                            
                            {{ isset($system->id) ? $system->application_name : str_replace('_',' ', env('APP_NAME')) }}
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn text-white"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="if (!window.__cfRLUnblockHandlers) return false; javascript:toggleFullScreen()" data-cf-modified-0825fa4f27dc602956ba7c8c-="">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right"> 
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">                                        
                                        <img src="{{ file_exists(Auth::guard('admin')->user()->image)? asset(Auth::guard('admin')->user()->image):asset('frontEnd/dummy_user.jpg') }}" class="img-radius" alt="Image">
                                        <span>{{Auth::guard('admin')->user()->name}}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="{{ route('admin.profile',['id' => Auth::guard('admin')->user()->id])}}" class="ajax-click-page" ><i class="feather icon-user"></i> Profile</a>
                                        </li>                                        
                                        <li>
                                            <a href="{{ route('admin.logout') }} "><i class="feather icon-log-out"></i> Logout</a>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Top Navigation End -->
            
            <!-- Left Sidebar start -->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">{{ isset($system) ? $system->applicationName : Null}}</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <!-- Dashboard -->
                                <li class="{{ isset($nav) && $nav == 'dashboard' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="{{ route('dashboard') }}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                @if( Auth::guard('admin')->user()->user_type == 'super_admin' )
                                    <!-- Admin Section -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'admin' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fa fa-user"></i></span>
                                            <span class="pcoded-mtext" >Admin</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "admin.website.setting" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('admin.website.setting')}}"><i class="fas fa-cogs"></i> Website Settings </a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "admin.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('admin.list') }}"><i class="fas fa-user-cog"></i> Admin List</a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "admin.archive_list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('admin.archive_list') }}"><i class="fas fa-user-plus"></i> Archive Admins</a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "admin.monitoring" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('admin.monitoring') }}"><i class="fas fa-user-tag"></i> Admin Monitoring</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                                        
                                

                                <!-- Users -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'user' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                                        <span class="pcoded-mtext" >Users</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "user.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('user.list')}}"><i class="fas fa-align-justify"></i> Users List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "user.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('user.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li> 
                                        <li class="{{ isset($subNav) && $subNav == "user.monitor_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('user.monitor_list')}}"><i class="fas fa-user"></i> User Monitor </a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Payment -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'payments' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-money-bill-wave"></i></span>
                                        <span class="pcoded-mtext" >Payments</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "offline.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('payments.offline.list')}}"><i class="far fa-money-bill-alt"></i> Offline Payment </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "online.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('payments.online.list') }}"><i class="fas fa-money-check-alt"></i> Online Payment</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Report -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'report' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-chart-line"></i></span>
                                        <span class="pcoded-mtext" >Reports</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <!-- Today & total Register -->
                                        <li class="{{ isset($subNav) && $subNav == "user.today_register" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.user',['type'=>'today_register']) }}"><i class="fas fa-users"></i> Today Register </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "user.total_register" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.user',['type'=>'total_register'])}}"><i class="fas fa-users"></i> Total Register </a>
                                        </li>
                                        <!-- Active & deactive User -->
                                        <li class="{{ isset($subNav) && $subNav == "user.active" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.user',['type'=>'active']) }}"><i class="fas fa-user-check"></i> Active Users </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "user.deactive" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.user',['type'=>'deactive'])}}"><i class="fas fa-user-times"></i> Deactive Users </a>
                                        </li>
                                        <!-- Male & Female -->
                                        <li class="{{ isset($subNav) && $subNav == "user.male" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.user',['type'=>'male']) }}"><i class="fas fa-male"></i> Male Users </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "user.female" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.user',['type'=>'female'])}}"><i class="fas fa-female"></i> Female Users </a>
                                        </li>
                                        <!-- Verify & Unverify User -->
                                        <li class="{{ isset($subNav) && $subNav == "user.verified" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.user',['type'=>'verified']) }}"><i class="fas fa-user-check"></i> Verified Users </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "user.unverified" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.user',['type'=>'unverified'])}}"><i class="fas fa-user-times"></i> Unverified Users </a>
                                        </li>

                                         <!-- Payment Report Section Start -->
                                         <!-- Pending Payments -->
                                         <li class="{{ isset($subNav) && $subNav == "payment.today-pending-payment" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.payment',['type'=>'today-pending-payment']) }}"><i class="fas fa-money-bill-wave"></i> Today Pending Payments </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "payment.monthly-pending-payment" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.payment',['type'=>'monthly-pending-payment'])}}"><i class="fas fa-money-check-alt"></i> Monthly Pending Payments </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "payment.all-pending-payment" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.payment',['type'=>'all-pending-payment'])}}"><i class="fas fa-money-check-alt"></i> All Pending Payments </a>
                                        </li>

                                        <!-- Paid Payments -->
                                        <li class="{{ isset($subNav) && $subNav == "payment.today-paid-payment" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.payment',['type'=>'today-paid-payment']) }}"><i class="fas fa-money-bill-wave"></i> Today Paid Payments </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "payment.monthly-paid-payment" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.payment',['type'=>'monthly-paid-payment'])}}"><i class="fas fa-money-check-alt"></i> Monthly Paid Payments </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "payment.all-paid-payment" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('report.payment',['type'=>'all-paid-payment'])}}"><i class="fas fa-money-check-alt"></i> All Paid Payments </a>
                                        </li>
                                                                                
                                    </ul>
                                </li>

                               

                                <!-- Seo -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'seo' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="{{route('seo')}}">
                                        <span class="pcoded-micon"><i class="fas fa-chart-line"></i></span>
                                        <span class="pcoded-mtext">SEO</span>
                                    </a>
                                </li>

                                <!-- Banner -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'banner' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fab fa-adversal"></i></span>
                                        <span class="pcoded-mtext" >Banner</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "banner.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('banner.list')}}"><i class="fas fa-align-justify"></i> Banner List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "banner.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('banner.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>
                                
                                <!-- Galary -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'galary' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="far fa-images"></i></span>
                                        <span class="pcoded-mtext" >Gallery</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "galary.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('galary.list')}}"><i class="fas fa-align-justify"></i> Gallery List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "galary.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('galary.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Marital Status -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'marital_status' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                                        <span class="pcoded-mtext" >Marital Status</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "marital_status.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('marital_status.list')}}"><i class="fas fa-list"></i> Marital Status List </a>
                                        </li>                                                                                
                                    </ul>
                                </li>

                                <!-- News -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'news' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-tv"></i></span>
                                        <span class="pcoded-mtext" >news</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "news.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('news.list')}}"><i class="fas fa-align-justify"></i> news List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "news.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('news.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Testimonial -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'testimonial' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-award"></i></span>
                                        <span class="pcoded-mtext" >Testimonial</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "testimonial.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('testimonial.list')}}"><i class="fas fa-align-justify"></i> Testimonial List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "testimonial.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('testimonial.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Our Service -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'ourservice' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-truck"></i></span>
                                        <span class="pcoded-mtext" >Our Service</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "ourservice.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('ourservice.list')}}"><i class="fas fa-align-justify"></i> Our Service List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "ourservice.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('ourservice.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Blog -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'blog' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fab fa-bootstrap"></i></span>
                                        <span class="pcoded-mtext" >Blog</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "blog.category.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('blog.category.list')}}"><i class="fas fa-align-justify"></i> Blog Categories </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "blog.category.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('blog.category.archive_list') }}"><i class="fas fa-align-justify"></i> Categories Archive List</a>
                                        </li>                                        
                                    </ul>

                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "blog.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('blog.list')}}"><i class="fas fa-align-justify"></i> Blog Post List </a>
                                        </li>                                                                                
                                    </ul>
                                </li>

                                <!-- Success Story -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'successStory' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="far fa-check-circle"></i></span>
                                        <span class="pcoded-mtext" >Success Story</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "successStory.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('successStory.list')}}"><i class="fas fa-align-justify"></i> Success Story List</a>
                                        </li>                                                                                
                                    </ul>
                                </li>

                                <!-- Packages -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'package' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-cubes"></i></span>
                                        <span class="pcoded-mtext" >Package</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "package.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('package.list')}}"><i class="fas fa-align-justify"></i> Package List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "package.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('package.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Privacy  -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'privacy' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-user-shield"></i></span>
                                        <span class="pcoded-mtext" >privacy</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "privacy.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('privacy.list')}}"><i class="fas fa-align-justify"></i> Privacy & Policy </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "privacy.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('privacy.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Trams & Regulation  -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'tramsRegulation' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-universal-access"></i></span>
                                        <span class="pcoded-mtext" >Trams & Regulation</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "tramsRegulation.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('tramsRegulation.list')}}"><i class="fas fa-align-justify"></i> Terms & Regulation </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "tramsRegulation.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('tramsRegulation.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Education Leven  -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'education_level' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-graduation-cap"></i></span>
                                        <span class="pcoded-mtext" > Education level</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "education_level.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('education_level.list')}}"><i class="fas fa-align-justify"></i> Education Level List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "education_level.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('education_level.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Career Profession  -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'careerProfessional' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-user-tie"></i></span>
                                        <span class="pcoded-mtext" >Career Profession</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "careerProfessional.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('careerProfessional.list')}}"><i class="fas fa-align-justify"></i> Career Profession List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "careerProfessional.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('careerProfessional.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Monthly Income Range  -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'monthlyIncome' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-user-tie"></i></span>
                                        <span class="pcoded-mtext" >Monthly Income</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "monthlyIncome.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('monthlyIncome.list')}}"><i class="fas fa-align-justify"></i> Monthly Income List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "monthlyIncome.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('monthlyIncome.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Life Style -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'life_style' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-skating"></i></span>
                                        <span class="pcoded-mtext" > Life Style</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "life_style.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('life_style.list')}}"><i class="fas fa-align-justify"></i> Life Style List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "life_style.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('life_style.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>

                                <!-- Religious -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'religious' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fas fa-mosque"></i></span>
                                        <span class="pcoded-mtext" > Religious</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "religious.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('religious.list')}}"><i class="fas fa-align-justify"></i> Religious List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "religious.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('religious.archive_list') }}"><i class="fas fa-align-justify"></i> Archive List</a>
                                        </li>                                        
                                    </ul>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ isset($subNav) && $subNav == "religious.cast.list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('religious.cast.list')}}"><i class="fas fa-align-justify"></i> Religious Cast List </a>
                                        </li>
                                        <li class="{{ isset($subNav) && $subNav == "religious.cast.archive_list" ? 'active-subMenu' : 'none' }}" >
                                            <a href="{{ route('religious.cast.archive_list') }}"><i class="fas fa-align-justify"></i>Cast Archive List</a>
                                        </li>                                        
                                    </ul>
                                </li>
                                <!-- Social Media -->
                                <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'social_media' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="{{url('/social-media')}}">
                                        <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                                        <span class="pcoded-mtext">Social Media</span>
                                    </a>
                                </li>

                            </ul>                            
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-body">
                                    