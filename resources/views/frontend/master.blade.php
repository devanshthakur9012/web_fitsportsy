<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $favicon = Common::siteGeneralSettingsApi();
        $catData = Common::allEventCategoriesByApi();
        $locationData = Common::fetchLocation();
    @endphp
    <meta charset="utf-8">

    <!-- <link rel="manifest" href="{{ asset('/manifest.json') }}"> -->
    <!-- <link rel="manifest" href="{{ asset('/organizer_manifest.json') }}"> -->
    <link
        href="{{ $favicon['favicon'] ? env('BACKEND_BASE_URL') . "/" . $favicon['favicon'] : "https://app.fitsportsy.in/images/favicon.png" }}"
        rel="icon" type="image/png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $favicon['app_name'] }} | @yield('title')</title>
    @yield('og_data')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light only">
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <link href="{{ asset('f-vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('f-vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('f-vendor/slick/slick.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('f-vendor/slick/slick-theme.min.css') }}" />
    <link href="{{ asset('f-css/main.css') }}" rel="stylesheet">
    <link href="{{asset('css/select2.css')}}" rel="stylesheet">
    <link href="{{asset('f-css\iziToast.min.css')}}" rel="stylesheet">

    @stack('styles')
    <style>
        .menu_item {
            border-radius: 20px;
            padding: 5px 10px;
            color: #ffffff;
            line-height: 20px;
        }

        .socialFooter {
            gap: 10px;
        }

        .socialFooter i {
            border: 1px solid #fff;
            padding: 10px;
            border-radius: 50%;
        }
        ::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
        .shopBar{
            background: #fff;
            color: #6e6e6e !important;
            font-weight: 400;
            padding: 10px !important;
        }

        /*new header*/
        .new-topbar{
            background: #000000;
        }
        .new-logo{
            background: #000000;
        }
        .new-logo{
            position: relative;
            min-height: 100%;
        }
        .new-logo::after {
            content: '';
            position: absolute;
            top: 0;
            right: 100%;
            height: 100%;
            width: 3000px;
            background: #000000;
            z-index: -1;
        }
        .new-menu{

        }

        .menu-curve{
            position: absolute;
            left: 0;
            top: -6px;
        }
        .new-navbar {
            background: #6e6e6e;
            z-index: -2;
            position: relative;
        }

        .new-topbar-ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .new-topbar-ul li {
            display: inline-block;
        }
        .new-topbar-ul li > a{
            color: #fff;
        }
        .new-header {
            position: relative;
            z-index: 1;
            padding-bottom: 10px;
            background: #6e6e6e;
        }
        .osahan-nav-mid {
            background: #6e6e6e !important;
            margin-top: 11px;
            position: relative;
            left: 43px;
            border: none;
        }

        .menu_item {
            /*color: #000 !important;*/
        }
        .osahan-nav-mid .navbar-toggler {
            margin-left: 60px;
            color: #fff;
        }

        .home-slider{
            z-index: 0;
        }

        @media (max-width: 992px) {
            .menu-curve{
                width: 40px;
            }
            .osahan-nav-mid .navbar-toggler {

            }
        }
        .profileBar{
            width: 30px !important;
            height: 30px !important;
            border: 1px solid #fff !important;
        }
        .text-danger{
            color:#ff0000 !important;
        }
        
        .gradient-text {
            background: linear-gradient(to right, #00f0ff, #00ff94, #a6ff00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }
    </style>
    
    <style>
        /* Modal Container */
        #freeTrailModal .modal-content {
            background: #282828;
            border-radius: 20px;
            overflow: hidden;
            /* box-shadow: 0 10px 30px rgba(106, 13, 173, 0.3); */
            border: 1px solid #6e6e6e;
        }

        /* Modal Header */
        #freeTrailModal .modal-header {
            /* background: linear-gradient(135deg, #6e6e6e 0%, #6e6e6e 100%); */
            background: #282828;
            border: none;
            /* padding: 0;
            position: relative;
            height: 65px; */
            text-align:center;
        }

        #freeTrailModal .header-content {
            position: absolute !important;
            bottom: 20px;
            left: 0;
            z-index: 2;
        }

        #freeTrailModal .modal-title {
            /* font-weight: 700; */
            /* font-size: 1.8rem; */
            color: white;
            /* text-shadow: 0 2px 4px rgba(0,0,0,0.2); */
        }

        #freeTrailModal .close {
            position: absolute;
            right: 20px;
            top: 10px;
            color: white;
            opacity: 0.8;
            z-index: 3;
            text-shadow: none;
            font-size: 1.5rem;
        }

        #freeTrailModal .close:hover {
            opacity: 1;
            color: #f3e5ff;
        }

        /* Curved Design Element */
        #freeTrailModal .modal-curve {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 10px;
            background: #282828;
            border-radius: 20px 20px 0 0;
        }

        /* Modal Body */
        #freeTrailModal .modal-body {
            padding: 18px 30px;
            background: #282828;
            color: #e0e0e0;
        }

        /* Form Elements */
        #freeTrailModal .floating-label {
            position: relative;
            margin-bottom: 25px;
        }

        #freeTrailModal .form-control {
            background: transparent;
            border: none;
            border-bottom: 1px solid #6e6e6e;
            border-radius: 0;
            color: white;
            padding: 0;
            height: 40px;
        }

        #freeTrailModal .form-control:focus {
            box-shadow: none;
            border-color: #6e6e6e;
        }

        #freeTrailModal .floating-label label {
            position: absolute;
            top: 15px;
            left: 0;
            color: #6e6e6e;
            transition: all 0.3s;
            pointer-events: none;
        }

        #freeTrailModal .floating-label input:focus + label,
        #freeTrailModal .floating-label input:not(:placeholder-shown) + label {
            top: -15px;
            font-size: 12px;
            color: #6e6e6e;
        }

        #freeTrailModal .underline {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            width: 0;
            background: #6e6e6e;
            transition: width 0.4s;
        }

        #freeTrailModal .form-control:focus ~ .underline {
            width: 100%;
        }

        /* Date Carousel */
        #freeTrailModal .date-carousel {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 15px;
            scrollbar-width: thin;
            scrollbar-color: #6e6e6e #0a0a0a;
        }

        #freeTrailModal .date-carousel::-webkit-scrollbar {
            height: 6px;
        }

        #freeTrailModal .date-carousel::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        #freeTrailModal .date-carousel::-webkit-scrollbar-thumb {
            background-color: #6e6e6e;
            border-radius: 3px;
        }

        #freeTrailModal .date-option {
            flex: 0 0 70px;
            padding: 8px 5px;
            border-radius: 12px;
            background: #3a3a5c;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            /* border: 1px solid #2a2a4a; */
            position: relative;
            overflow: hidden;
        }

        #freeTrailMLodal .date-option:hover {
            transform: translateY(-3px);
            /* box-shadow: 0 5px 15px rgba(106, 13, 173, 0.3); */
            border-color: #6e6e6e;
        }

        #freeTrailModal .date-option.selected {
            background: linear-gradient(135deg, #6e6e6e 0%, #6e6e6e 100%);
            color: white;
            border-color: #6e6e6e;
            /* transform: translateY(-3px); */
            /* box-shadow: 0 5px 20px rgba(106, 13, 173, 0.4); */
        }

        #freeTrailModal .date-option.weekend {
            opacity: 0.5;
            background: #0a0a0a;
            cursor: not-allowed;
        }

        #freeTrailModal .day-name {
            /* font-weight: 600; */
            font-size: 12px;
            color:rgb(255, 255, 255);
            margin-bottom: 5px;
        }

        #freeTrailModal .date-option.selected .day-name {
            color: white;
        }

        #freeTrailModal .date-num {
            font-size: 16px;
            /* font-weight: 700; */
            margin: 5px 0;
            color: white;
        }

        #freeTrailModal .month-name {
            font-size: 0.7rem;
            color:rgb(255, 255, 255);
            text-transform: uppercase;
        }

        #freeTrailModal .date-option.selected .month-name {
            color: rgba(255,255,255,0.8);
        }

        /* Time Grid */
        #freeTrailModal .time-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
        }

        #freeTrailModal .time-option {
            padding: 12px 5px;
            border-radius: 8px;
            background: #3a3a5c;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            /* border: 1px solid #2a2a4a; */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #freeTrailModal .time-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(106, 13, 173, 0.3);
            border-color: #6e6e6e;
        }

        #freeTrailModal .time-option.selected {
            background: linear-gradient(135deg, #6e6e6e 0%, #6e6e6e 100%);
            color: white;
            /* border-color: #6e6e6e; */
            transform: translateY(-3px);
            /* box-shadow: 0 5px 20px rgba(106, 13, 173, 0.4); */
        }

        /* Section Titles */
        #freeTrailModal .section-title {
            /* font-weight: 600; */
            color:rgb(255, 255, 255);
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        /* Submit Button */
        #freeTrailModal .btn-glow {
            background: linear-gradient(135deg, #6e6e6e 0%, #6e6e6e 100%);
            border: none;
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 15px;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            /* box-shadow: 0 4px 15px rgba(156, 39, 176, 0.3); */
        }

        #freeTrailModal .btn-glow:hover {
            transform: translateY(-2px);
            /* box-shadow: 0 7px 25px rgba(156, 39, 176, 0.4); */
        }

        #freeTrailModal .btn-glow:active {
            transform: translateY(0);
        }

        #freeTrailModal .btn-glow:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s;
        }

        #freeTrailModal .btn-glow:hover:before {
            opacity: 1;
        }

        /* Loader */
        #freeTrailModal .spinner-grow.text-purple {
            color: #6e6e6e;
            width: 3rem;
            height: 3rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            #freeTrailModal .date-carousel {
                gap: 8px;
            }
            
            #freeTrailModal .date-option {
                flex: 0 0 70px;
                padding: 12px 3px;
            }
            
            #freeTrailModal .time-grid {
                grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            }
        }

        /* Radio Button Styles */
        #freeTrailModal .btn-radio {
            background: #3a3a5c;
            color: #6e6e6e;
            border: none;
            border-radius: 8px !important;
            padding: 7px 20px;
            transition: all 0.3s;
            margin-right: 10px;
        }

        #freeTrailModal .btn-radio:last-child {
            margin-right: 0;
        }

        #freeTrailModal .btn-radio:hover {
            background: #3a3a5a;
            color: #d1b3ff;
        }

        #freeTrailModal .btn-radio.active {
            background: linear-gradient(135deg, #6e6e6e 0%, #6e6e6e 100%) !important;
            color: white;
            /* box-shadow: 0 4px 15px rgba(106, 13, 173, 0.3); */
            border-color: #6e6e6e;
            background
        }

        #freeTrailModal .btn-group-toggle {
            display: flex;
            gap: 10px;
        }

        #freeTrailModal .btn-group-toggle label {
            flex: 1;
            text-align: center;
            cursor: pointer;
        }

        /* Adjust spacing for the new field */
        #freeTrailModal .floating-label {
            margin-top: 20px;
        }

        .cat-small-img{
            width: 43px;
            border: 1px dashed #fff;
            border-radius: 50%;
            background: #171717;
            padding: 5px;
        }
    </style>

    <!-- LOGIN MODAL -->
    <style>
        .login-modal-content {
            background-color:#000;
            box-shadow: rgba(0, 0, 0, 0.22) 0px 13px 24px 0px;
            border-radius: 10px;
            animation: animation-ngigez 0.3s ease 0s 1 normal none;
            width: 80%;
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding:25px;
        }

        .login-modal-content .input-group-text{
            background-color:#000000 !important;
            color:#fff !important;
        }

        .login-modal-content .form-control{
            border-radius: .25rem;
            font-size: 15px;
            color: #ffffff;
            height: 45px;
            background-color: #000000;
            border: 1px solid #ffffff;
        }
        .login-modal-content .btn-primary:hover{
            color: rgb(255, 255, 255) !important;
            background-color: rgb(110, 110, 110) !important;
            border-color: rgb(110, 110, 110) !important;
        }

        @keyframes animation-ngigez {
            0% {
                opacity: 0;
                transform: translate3d(0px, -10%, 0px);
            }
            100% {
                opacity: 1;
                transform: translate3d(0px, 0px, 0px);
            }
        }
        .close:focus{
            border:none;
            outline:none;
            box-shadow:none;
        }
        .border-remove{
            border: none !important;
            border-bottom: 1px solid #fff !important;
            border-radius: 0px !important;
        }
        .loginOption{
            background: transparent;
            color: #fff;
            border: none;
        }
        .loginOption:focus{
            outline:none;
        }
    </style>
</head>

<body>
    <div class="sigma_preloader">
        @if (isset($favicon['loader']))
            @php $url = env('BACKEND_BASE_URL') . "/" . $favicon['loader'];  @endphp
        @else
            @php $url = asset('images/FitSportsy_logo_No_BG.png');  @endphp
        @endif
        <!-- <img src="{{asset('/images/loader-animation.mp4')}}" alt="preloader"> -->
        <!-- <video autoplay muted loop style="width: 100px; height: auto;">
            <source src="{{ asset('/images/loader-animation.gif') }}" type="video/mp4">
        </video> -->
    </div>

    <div class="new-header stickey-top">
        <div class="new-topbar">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <ul class="new-topbar-ul text-right d-flex justify-content-end align-items-center">
                            <li class="nav-item no-arrow mx-1 desk-seva-ticket">
                                <a class="nav-link" href="javascript:void(0);" data-toggle="modal"
                                   data-target="#locationModal">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="pl-2">{{Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'Popular Locations'}}</span>
                                </a>
                            </li>
                            {{-- <li>
                                <button class="mx-3 btn default-btn py-2" data-toggle="modal" data-target="#socialPlay">Play</button>
                            </li> --}}
                            <li>
                                <a href="{{env('BACKEND_BASE_URL')}}/add_event.php" class="mx-3 loginbtn "><img src="{{asset('/images/Partner.png')}}" alt="Organizer" style="height:50px"></a>
                            </li>
                            @isset($favicon['appUrl'])
                                <li>
                                    <a href="{{$favicon['appUrl']}}" class="mx-3 btn default-btn py-2">Get App</a>
                                </li>
                            @endisset
                            @if (Common::isUserLogin())
                                <li class="nav-item dropdown no-arrow ">
                                    @if (Common::isUserLogin())
                                        @php $userData = Common::fetchUserDetails(); @endphp
                                        <a class="nav-link dropdown-toggle pr-0" href="#" id="userDropdown" role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @if (isset($userData['pro_pic']) && $userData['pro_pic'] != null)
                                                <img class="img-thumbnail profile-img profileBar" src="{{env('BACKEND_BASE_URL')."/".$userData['pro_pic']}}" alt="{{$userData['name']}}" width="25px" height="25px">
                                            @else
                                                <i class="fas fa-user-circle fa-lg"></i>
                                            @endif
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow-sm animated--grow-in"
                                             aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="{{ url('user/my-profile') }}">
                                                <i class="fas fa-user-circle fa-sm fa-fw mr-2 text-gray-600"></i>
                                                Profile
                                            </a>
                                            <a class="dropdown-item" href="{{ route('my-booking', ['type' => 'Active']) }}">
                                                <i class="fas fa-ticket-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                                                My Booking
                                            </a>
                                            <a class="dropdown-item" href="{{route('help-center')}}">
                                                <i class="fas fa-question fa-sm fa-fw mr-2 text-gray-600"></i>
                                                Help Center
                                            </a>
                                            <a class="dropdown-item" href="{{route('my-activity')}}">
                                                <i class="fas fa-at fa-sm fa-fw mr-2 text-gray-600"></i>
                                                My Group Sessions
                                            </a>
                                            <a class="dropdown-item" href="{{route('my-attendence')}}">
                                                <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-600"></i>
                                                My Attendence
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="{{ url('logout-user') }}">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 "></i>
                                                Logout
                                            </a>
                                        </div>
                                    @endif
                                </li>
                            @else
                                <li class="nav-item no-arrow  mx-2 position-relative">
                                    <button data-toggle="modal" data-target="#loginOtpModal" class="loginOption" type="button" style="background: transparent;color: #fff;border: none;">
                                         <!-- class="position-relative dropdown-toggle text-light" href="#" role="button"
                                       data-toggle="dropdown" aria-expanded="false" -->
                                        <i class="fas fa-user-circle fa-lg"></i>
                                    </button>
                                    <!-- <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                                        <button data-toggle="modal" data-target="#loginOtpModal" type="button" class="dropdown-item" href="{{ url('user-login') }}"><i
                                                class="fas fa-sign-in-alt"></i> Login</button>
                                        <a class="dropdown-item" href="{{ url('user-register') }}"><i
                                                class="fas fa-user-plus"></i> Register</a>
                                    </div> -->
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="new-navbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-5 col-sm-2 pr-0">
                       <div class="new-logo">
                           <a href="/"><img src="{{ $favicon['favicon'] ? env('BACKEND_BASE_URL') . "/" . $favicon['logo'] : "https://app.fitsportsy.in/images/website/1733339125.png" }}"
                                   class="img-fluid" alt="fitsportsy"></a>
                       </div>
                    </div>
                    <div class="col-7 col-sm-10 pl-0">
                        <div class="new-menu">
                            <img class="menu-curve" src="{{asset('frontend/images/menucurves2.png')}}" alt="img">
                            <nav class="navbar navbar-expand-lg navbar-light osahan-nav-mid">
                                <div class="container-fluid position-relative">
                                    <button class="navbar-toggler navbar-toggler-right btn btn-danger btn-sm " type="button"
                                            data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                                            aria-expanded="false" aria-label="Toggle navigation">
                                        Menu  <i class="fas fa-bars"></i>
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarResponsive">
                                        <ul class="navbar-nav w-100 justify-content-start">
                                            @foreach ($catData as $cat)
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('coaching', [Str::slug($cat['slug'])]) }}">
                                    <span class="menu_item"><img src="{{env('BACKEND_BASE_URL')}}/{{$cat['cat_img']}}"
                                                                 class="mr-1" width="20px" alt="{{$cat['title']}}">{{$cat['title']}}</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
    <address class="bottom-location">
        <div class="container">
            <div>
                <h5 class="text-white mb-2">Categories</h5>
                <ul class="list-unstyled ">
                    @foreach ($catData as $cat)
                        <li>
                            <a href="{{ route('coaching', ['category' => $cat['slug']]) }}">
                                {{ $cat['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h5 class="text-white mb-2">Locations</h5>
                <ul class="list-unstyled ">
                    @foreach ($locationData as $item)
                        <li> <a href="{{ route('location-coaching', ['location' => Str::slug($item['city'])]) }}">
                                {{ $item['city'] }}
                            </a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </address>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 mt-4 col-lg-4 col-6 ">
                    <div class="resources">
                        <h6 class="footer-heading text-uppercase text-white fw-bold">About Us</h6>
                        <p>FitSportsy is the ultimate platform for sports and fitness coaching, covering all disciplines like badminton, cricket, football, yoga, Zumba, CrossFit, and more. Whether you're a beginner or an advanced athlete, find expert coaches and training programs tailored to your needs. Explore curated coaching packages, track attendance with QR-based check-ins, and book a coach or therapist effortlessly. Elevate your fitness journey with FitSportsy!</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mt-4 col-lg-4 col-6 ">
                    <div class="resources">
                        <h6 class="footer-heading text-uppercase text-white fw-bold">Quick Links</h6>
                        <ul class="list-unstyled footer-link mt-4">
                            <li class=""><a href="{{route('help-center')}}"
                                    class="text-white text-decoration-none ">Help Center</a></li>
                            @if(Common::pageListData() && count(Common::pageListData()))
                                @foreach (Common::pageListData() as $item)
                                    <li class="mb-1"><a href="{{ url('/pages/' . $item['slug']) }}"
                                            class="text-white text-decoration-none">{{ $item['title'] }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 mt-4 col-lg-4 col-12">
                    <div class="contact">
                        <h6 class="footer-heading text-uppercase text-white fw-bold">Contact Us</h6>
                        <a href="" class="mt-4 text-white mb-2"><i class="fas fa-map-marker-alt"></i>
                            {{ $favicon['address'] }}</a>
                        <a href="tel:{{ $favicon['mobile'] }}"
                            class="text-white mb-1 mt-1 text-decoration-none d-block "><i class="fas fa-phone-alt"></i>
                            {{ $favicon['mobile'] }}</a>
                        <a href="mailto:{{$favicon['email']}}" class="text-white mb-1 text-decoration-none d-block "><i
                                class="fas fa-envelope"></i>
                            {{ $favicon['email'] }}</a>
                        <ul class="mt-2 d-flex gap-2 socialFooter">
                            @isset($favicon['Facebook'])
                                <li class=""><a href="{{ $favicon['Facebook'] }}" target="_blank" class="text-white mb-2"><i class="fab fa-facebook"></i></a></li>
                            @endisset
                            @isset($favicon['Instagram'])
                                <li class=""><a href="{{ $favicon['Instagram'] }}" target="_blank" class="text-white mb-2"><i class="fab fa-instagram"></i></a></li>
                            @endisset
                            @isset($favicon['Twitter'])
                                <li class=""><a href="{{ $favicon['Twitter'] }}" target="_blank" class="text-white mb-2"><i class="fab fa-twitter"></i></a></li>
                            @endisset
                            @isset($favicon['Linkedin'])
                                <li class=""><a href="{{ $favicon['Linkedin'] }}" target="_blank" class="text-white mb-2"><i class="fab fa-linkedin"></i></a></li>
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center bg-dark mt-4 p-2" style="color: #b5b5b5">
            <div class="container">
                <p class="m-0 small text-center">{{ $favicon['footer_copyright'] }}</p>
            </div>
        </div>
    </footer>

    <!-- Add this inside your <body> -->
    <div id="qrPopup" class="card shadow-lg p-2" style="position: fixed; bottom: 20px; right: 20px; width: 180px; z-index: 1050;    box-shadow: 0px 0px 10px #444444 !important;background:#0a0a0a !important;color:#fff;">
        <div class="card-body text-center p-2">
            <p class="mb-3" style="font-size: 14px;">For better experience,<br> use Fitsportsy App</p>
            <img src="{{asset('/images/qr-fitsportsy.png')}}" alt="QR Code" class="img-fluid border border-white rounded" style="width: 100%;">
        </div>
    </div>


    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="locationModalLabel"><i class="fas fa-map-marker-alt"></i>
                        Locations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="popular-location">
                        <h6 class="text-center mb-3">Popular Cites</h6>
                        <div class="d-flex flex-wrap justify-content-center" style="gap: 10px;">
                            @foreach ($locationData as $item)
                                <div class="w-auto">
                                    <a href="{{ url('event-city?city=' . $item['city'] . '&redirect=' . request()->fullUrl()) }}"
                                        class="btn text-center btn-outline-light btn-sm">
                                        @if(isset($item['image']) && $item['image'] != null)
                                            <img class="img-fluid d-block m-auto" style="width: 50px; height: 50px; object-fit: contain;" src="{{ env('BACKEND_BASE_URL') }}/{{$item['image']}}" alt="{{$item['city']}}">
                                        @endif
                                        {{$item['city']}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Group Sessions --}}
    <div class="modal fade" id="socialPlay" tabindex="-1" role="dialog" aria-labelledby="socialPlayLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="socialPlayLabel">Group Sessions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="popular-location">
                        <div class="w-auto" style="gap: 10px;">
                            <form id="socialPlayForm" action="{{route('create-play')}}" autocomplete="off" class="row" method="POST">
                                <div class="mb-3 col-lg-6">
                                    @csrf
                                    <label for="cat_id" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="cat_id" name="cat_id" required>
                                        @isset($catData)
                                            <option value="" selected disabled>Select Type</option>
                                            @foreach ($catData as $item)
                                                <option value="{{$item['id']}}">{{$item['title']}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="title" class="form-label">Session Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Eg: Therapeutic Yoga" class="form-control" id="title" name="title" maxlength="225" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>

                                <div class="mb-3 col-lg-12">
                                    <label class="form-label">Select Days <span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Mon" id="dayMon">
                                            <label class="form-check-label" for="dayMon">Mon</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Tue" id="dayTue">
                                            <label class="form-check-label" for="dayTue">Tue</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Wed" id="dayWed">
                                            <label class="form-check-label" for="dayWed">Wed</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Thu" id="dayThu">
                                            <label class="form-check-label" for="dayThu">Thu</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Fri" id="dayFri">
                                            <label class="form-check-label" for="dayFri">Fri</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Sat" id="daySat">
                                            <label class="form-check-label" for="daySat">Sat</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Sun" id="daySun">
                                            <label class="form-check-label" for="daySun">Sun</label>
                                        </div>
                                   </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="start_time" class="form-label">Session Time Slots <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="venue" class="form-label">Venue Details <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="venue" name="venue" placeholder="Eg: ABC Sports Venue, 1st Cross, Indira Nagar Bangalore-560038" maxlength="225" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="location" class="form-label">Select Location <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="location" name="location" required>
                                        @isset($locationData)
                                            <option value="" selected disabled>Choose Location</option>
                                            @foreach ($locationData as $item)
                                                <option value="{{$item['city']}}">{{$item['city']}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="slots" class="form-label">Slots <span class="text-danger">*</span></label>
                                    <input type="number" placeholder="Enter no. of slots" class="form-control" id="slots" name="slots" required>
                                </div>
                                <div class="mb-3 col-lg-6">
                                    <label for="type" class="form-label">Session Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="online" selected>Online</option>
                                        <option value="offline">Offline</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Level</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Any">Any</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-12">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control" placeholder="Enter Note" id="note" name="note" maxlength="500" style="height: 115px;">1.Mavis 350 or RSL Supreme Shuttlecocks will be used for all matches.                                                      2.Participants are requested to adhere to the venue's rules and regulations.                                                      3.Kindly specify the game format while creating Group Sessions.                                                                      4.Payments can be made conveniently via UPI.</textarea>
                                </div>
                                <div class="mb-3 col-lg-12">
                                    <!-- <label for="pay_join" class="form-label">Pay Join <span class="text-danger">*</span></label> -->
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="pay_join" role="switch" id="pay_join" checked>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#">Terms and Conditions</a> <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    @if (Common::isUserLogin())
                                        <button type="submit" class="text-center btn default-btn w-100">Submit</button>
                                    @else
                                        <button data-toggle="modal" data-target="#loginOtpModal" type="button" class="text-center btn default-btn w-100">Login to continue.</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Try For Free MODAL -->
    <div class="modal fade" id="freeTrailModal" tabindex="-1" role="dialog" aria-labelledby="freeTrailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <div class="w-100">
                        <h4 class="h5 w-100 mb-1" id="freeTrailModalLabel">
                            <i class="fas fa-magic mr-2"></i> Try For Free
                        </h4>
                        <p class="p-0 m-0 text-end" id="sponserName"></p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- <div class="modal-curve"></div> -->
                </div>
                <div class="modal-body pt-1">
                    <div id="loader" class="text-center py-5">
                        <div class="spinner-grow text-purple" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-3 text-light">Preparing your magical experience...</p>
                    </div>
                    
                    <form id="freeTrialForm" style="display:none;">
                        @csrf
                        <input type="hidden" name="date" id="selectedDate">
                        <input type="hidden" name="slot" id="selectedTime">
                        
                        <!-- Radio Button Selection -->
                        <div class="form-group mb-0">
                            <div class="section-title mb-3">
                                <i class="far fa-user mr-2"></i> Trial for
                            </div>
                            <!-- <label class="d-block mb-2 font-weight-bold">Who is this trial for?</label> -->
                            <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                <label class="btn btn-radio text-white active">
                                    <input type="radio" name="trial_for" value="yourself" checked> 
                                    <i class="fas fa-user mr-2"></i> Yourself
                                </label>
                                <label class="btn btn-radio text-white">
                                    <input type="radio" name="trial_for" value="child"> 
                                    <i class="fas fa-child mr-2"></i> My Child
                                </label>
                            </div>
                        </div>
                        <div class="form-group floating-label mt-4">
                            <div class="section-title">
                                <i class="far fa-user mr-2"></i> Name
                            </div>
                            <input type="text" class="form-control" id="name" name="name" value="@if(isset($userData['name']) && ! empty($userData['name'])){{$userData['name']}}@endif" required>
                        </div>

                        <div class="section-title mt-4 mb-3">
                            <i class="far fa-calendar mr-2"></i> Select Date
                        </div>
                        <div id="dateContainer" class="date-carousel">
                            <!-- Dates will be generated here -->
                        </div>

                        <div class="section-title mt-3 mb-3">
                            <i class="far fa-clock mr-2"></i> Available Time Slots
                        </div>
                        <div id="timeContainer" class="time-grid">
                            <!-- Time slots will be generated here -->
                        </div>

                        <div class="mt-4">
                            @if (Common::isUserLogin())
                                <button type="submit" class="btn btn-block btn-glow" id="submitBtn">
                                    <i class="fas fa-check-circle mr-2"></i> Confirm Your Trial
                                </button>
                            @else
                                <button data-toggle="modal" data-target="#loginOtpModal" type="button" class="btn btn-block btn-glow">Login to continue.</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- LOGIN MODAL -->
     
    <div class="modal fade" id="loginOtpModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
            <div class="modal-content login-modal-content shadow">
            <div class="modal-header border-0 p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="loginOtpForm">
                        @csrf
                       <div class="text-center my-3">
                           <a href="/"><img src="{{asset('images/login-logo-1.png')}}"
                                   class="img-fluid" style="width:200px;" alt="fitsportsy"></a>
                       </div>
                        
                        <div id="mobileInputSection">
                            <div class="form-group">
                                <!-- <label class="mb-1">Mobile Number</label> -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-remove">+91</span>
                                    </div>
                                    <input type="tel" maxlength="10" class="form-control border-remove" id="loginMobileInput" name="number" placeholder="Enter your mobile number" required>
                                </div>
                                <small class="form-text text-muted mt-2" style="font-size:12px !important;">An OTP will be sent to your mobile number for verification.</small>
                            </div>
                            
                            <button type="button" id="sendOtpBtn" class="btn btn-primary btn-block my-4">
                                CONTINUE
                            </button>

                            <p style="
                                margin-top: 10px;
                                font-size: 11px;
                                text-align: center;
                            ">"BY CONTINUE YOU AGREE TO THE <span style="color:#29f3e2;">TERMS OF SERVICES</span> AND <span style="color:#ff0095;">PRIVACY POLICY OF FITSPORTSY"</span></p>
                        </div>
                        
                        <div id="otpInputSection" class="d-none">
                            <div class="text-center mb-3">
                                <p>Enter the 4-digit OTP sent to <span id="displayMobileNumber" class="font-weight-bold">+91 XXXXXXXXXX</span></p>
                            </div>
                            
                            <div class="form-group">
                                <div class="d-flex justify-content-between otp-input-group" style="gap:15px;">
                                    <input type="text" class="form-control otp-box text-center" maxlength="1" pattern="\d*" inputmode="numeric" />
                                    <input type="text" class="form-control otp-box text-center" maxlength="1" pattern="\d*" inputmode="numeric" />
                                    <input type="text" class="form-control otp-box text-center" maxlength="1" pattern="\d*" inputmode="numeric" />
                                    <input type="text" class="form-control otp-box text-center" maxlength="1" pattern="\d*" inputmode="numeric" />
                                </div>
                                <input type="hidden" id="combinedOtp" name="otp">
                            </div>
                            
                            <button type="button" id="verifyOtpBtn" class="btn btn-primary btn-block mt-2">
                                Verify OTP
                            </button>
                            
                            <div class="resend-otp mt-3">
                                Didn't receive OTP? <a id="resendOtpBtn">Resend OTP</a>
                            </div>
                        </div>
                        
                        <div class="footer-links text-right mt-2 text-muted">
                            <a href="{{url('user-register')}}" class="text-muted">Create Account</a> | 
                            <a href="{{url('user/resetPassword')}}" class="text-muted">Forgot Password?</a>
                        </div>
                    </form>
            </div>
            </div>
        </div>
    </div>

    @php 
        $redirectUrl = session('redirect_url', '/'); 
    @endphp
    <script src="{{ asset('f-vendor/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('f-vendor/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('f-vendor/slick/slick.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="{{ asset('f-js\iziToast.min.js') }}" type="text/javascript"></script>
    
    <!-- LOGIN SCRIPT START -->
    <script>
        $(document).ready(function () {
            
            // Handle OTP input boxes
            $('.otp-box').on('input', function() {
                $(this).next('.otp-box').focus();
                updateCombinedOtp();
            });
            
            // Handle backspace in OTP boxes
            $('.otp-box').on('keydown', function(e) {
                if(e.key === "Backspace" && $(this).val() === '') {
                    $(this).prev('.otp-box').focus();
                }
                updateCombinedOtp();
            });
            
            function updateCombinedOtp() {
                let otp = '';
                $('.otp-box').each(function() {
                    otp += $(this).val();
                });
                $('#combinedOtp').val(otp);
            }
            
            // Send OTP
            $('#sendOtpBtn').on('click', function() {
                const mobile = $('#loginMobileInput').val();
                const ccode = "+91";
                
                if (!mobile || mobile.length !== 10 || isNaN(mobile)) {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Please enter a valid 10-digit mobile number.'
                    });
                    return;
                }
                
                // Show loading state
                $(this).addClass('btn-loading').prop('disabled', true).html('Sending OTP...');
                
                $.ajax({
                    url: "{{ route('verify-mobile-number') }}",
                    type: 'POST',
                    data: {
                        mobile: mobile,
                        ccode: ccode,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#sendOtpBtn').removeClass('btn-loading').prop('disabled', false).html('Continue');
                        
                        if (response.status === 'success') {
                            // Show OTP section
                            $('#mobileInputSection').addClass('d-none');
                            $('#otpInputSection').removeClass('d-none').addClass('otp-section-animate');
                            $('#displayMobileNumber').text('+91 ' + mobile);
                            
                            // Focus first OTP box
                            $('.otp-box').first().focus();
                            
                            iziToast.success({
                                title: 'Success',
                                position: 'topRight',
                                message: 'OTP sent successfully!'
                            });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                position: 'topRight',
                                message: response.message
                            });
                        }
                    },
                    error: function() {
                        $('#sendOtpBtn').removeClass('btn-loading').prop('disabled', false).html('Continue');
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: 'Failed to send OTP. Please try again.'
                        });
                    }
                });
            });
            
            // Verify OTP
            $('#verifyOtpBtn').on('click', function() {
                const otp = $('#combinedOtp').val();
                
                if (!otp || otp.length !== 4 || isNaN(otp)) {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Please enter a valid 4-digit OTP.'
                    });
                    return;
                }
                
                // Show loading state
                $(this).addClass('btn-loading').prop('disabled', true).html('Verifying...');
                
                $.ajax({
                    url: "{{ route('verify-login-otp') }}",
                    type: 'POST',
                    data: {
                        otp: otp,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        
                        if (response.status === 'success') {
                            iziToast.success({
                                title: 'Success',
                                position: 'topRight',
                                message: response.message
                            });
                            
                            setTimeout(() => {
                                window.location.href = "{{$redirectUrl}}";
                            }, 1000);
                        } else {
                            $('#verifyOtpBtn').removeClass('btn-loading').prop('disabled', false).html('Verify OTP');

                            iziToast.error({
                                title: 'Error',
                                position: 'topRight',
                                message: response.message
                            });
                        }
                    },
                    error: function() {
                        $('#verifyOtpBtn').removeClass('btn-loading').prop('disabled', false).html('Verify OTP');
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: 'Failed to verify OTP. Please try again.'
                        });
                    }
                });
            });
            
            // Resend OTP
            $('#resendOtpBtn').on('click', function() {
                const mobile = $('#loginMobileInput').val();
                const ccode = "+91";
                
                // Show loading state
                $(this).html('Sending...');
                
                $.ajax({
                    url: "{{ route('verify-mobile-number') }}",
                    type: 'POST',
                    data: {
                        mobile: mobile,
                        ccode: ccode,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#resendOtpBtn').html('Resend OTP');
                        
                        if (response.status === 'success') {
                            iziToast.success({
                                title: 'Success',
                                position: 'topRight',
                                message: 'New OTP sent successfully!'
                            });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                position: 'topRight',
                                message: response.message
                            });
                        }
                    },
                    error: function() {
                        $('#resendOtpBtn').html('Resend OTP');
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: 'Failed to resend OTP. Please try again.'
                        });
                    }
                });
            });
        });
    </script>
    <!-- LOGIN SCRIPT END -->
    <script>
        $(document).ready(function() {
            let submitUrl = '';

            $(document).on('click','.free_trail_btn', function() {
                const title = $(this).data('title');
                const sname = $(this).data('sponser_name');
                submitUrl = $(this).data('url');
                const slots = $(this).data('slots');
                
                $('#freeTrailModalLabel').text(title);
                $('#sponserName').text(sname);
                $('#loader').show();
                $('#freeTrialForm').hide();
                
                // Generate calendar dates
                const today = new Date();
                const dateContainer = $('#dateContainer');
                dateContainer.empty();
                
                // Add 7 upcoming days (Monday-Friday)
                let daysAdded = 0;
                let dayOffset = 1; // Start from tomorrow
                
                while (daysAdded < 7) {
                    const date = new Date(today);
                    date.setDate(today.getDate() + dayOffset);
                    const dayOfWeek = date.getDay();
                    
                    // Only show weekdays (1-5 = Monday-Friday)
                    if (dayOfWeek >= 1 && dayOfWeek <= 6) {
                        const dayName = date.toLocaleDateString('en-US', { weekday: 'short' }).toUpperCase();
                        const dateNum = date.getDate();
                        const monthName = date.toLocaleDateString('en-US', { month: 'short' });
                        const dateValue = date.toISOString().split('T')[0];
                        const isWeekend = (dayOfWeek === 0);
                        
                        dateContainer.append(`
                            <div class="date-option ${isWeekend ? 'weekend' : ''}" data-date="${dateValue}">
                                <div class="day-name">${dayName}</div>
                                <div class="date-num">${dateNum}</div>
                                <div class="month-name">${monthName}</div>
                            </div>
                        `);
                        daysAdded++;
                    }
                    dayOffset++;
                }
                
                // Generate time slots
                const timeContainer = $('#timeContainer');
                timeContainer.empty();

                if (Array.isArray(slots)) {
                    slots.forEach(slot => {
                        // Check if ' to ' exists in the slot
                        if (slot.includes(' to ')) {
                            // Split slot at ' to ' and take the first part (start time)
                            const startTime = slot.split(' to ')[0].trim();

                            timeContainer.append(`
                                <div class="time-option" data-time="${startTime}">
                                    <i class="far fa-clock mr-2"></i>${startTime}
                                </div>
                            `);
                        }
                    });
                }
                
                setTimeout(() => {
                    $('#loader').hide();
                    $('#freeTrialForm').show();
                    
                    // Initialize selection
                    $('.date-option:not(.weekend)').first().addClass('selected');
                    $('.time-option').first().addClass('selected');
                    
                    // Update hidden inputs
                    $('#selectedDate').val($('.date-option.selected').data('date'));
                    $('#selectedTime').val($('.time-option.selected').data('time'));
                }, 500);
            });
            
            // Date selection
            $(document).on('click', '.date-option:not(.weekend)', function() {
                $('.date-option').removeClass('selected');
                $(this).addClass('selected');
                $('#selectedDate').val($(this).data('date'));
            });
            
            // Time selection
            $(document).on('click', '.time-option', function() {
                $('.time-option').removeClass('selected');
                $(this).addClass('selected');
                $('#selectedTime').val($(this).data('time'));
            });

            $("#freeTrialForm").validate({
                rules: {
                    name: "required"
                },
                messages: {
                    name: "Please enter your name"
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    element.closest(".form-group").append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                },
                submitHandler: function(form) {
                    const $btn = $('#submitBtn');
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Booking...');

                    $.ajax({
                        url: submitUrl,
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            
                            iziToast.success({
                                title: 'success',
                                message: response.message || 'Your free trial has been scheduled!',
                                position: 'topRight'
                            });

                            $('#freeTrailModal').modal('hide');
                            form.reset();
                        },
                        error: function(xhr) {
                            let errorMsg = 'Something went wrong!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }

                            iziToast.error({
                                title: 'Error',
                                message: errorMsg,
                                position: 'topRight'
                            });
                        },
                        complete: function() {
                            $btn.prop('disabled', false).html('<i class="fas fa-check-circle mr-2"></i> Confirm Your Trial');
                        }
                    });
                    return false;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Initialize jQuery validation
            $("#socialPlayForm").validate({
                rules: {
                    cat_id: { required: true },
                    title: { required: true, maxlength: 225 },
                    start_date: { required: true, date: true, greaterThanToday: true },
                    end_date: { required: true, date: true, greaterThanStartDate: true },
                    "days[]": { required: true },
                    start_time: { required: true },
                    venue: { required: true, maxlength: 225 },
                    location: { required: true, maxlength: 225 },
                    slots: { required: true, number: true, min: 1 },
                    type: { required: true },
                    gender: { required: true },
                    pay_join: { required: true }
                },
                messages: {
                    cat_id: { required: "Please select a play type." },
                    title: { required: "Please enter a session name.", maxlength: "Session name cannot exceed 225 characters." },
                    start_date: { 
                        required: "Please select a start date.",
                        greaterThanToday: "Start date must be in the future." 
                    },
                    end_date: { 
                        required: "Please select an end date.",
                        greaterThanStartDate: "End date must be after start date." 
                    },
                    "days[]": { required: "Please select at least one day." },
                    start_time: { required: "Please select a start time." },
                    venue: { required: "Please enter venue details.", maxlength: "Venue details cannot exceed 225 characters." },
                    location: { required: "Please select a location.", maxlength: "Location cannot exceed 225 characters." },
                    slots: { 
                        required: "Please enter the number of slots.", 
                        number: "Please enter a valid number.", 
                        min: "Slots must be at least 1." 
                    },
                    type: { required: "Please select a session type." },
                    gender: { required: "Please select a gender preference." },
                    pay_join: { required: "You must agree to the terms and conditions." }
                },
                errorElement: "span",
                errorClass: "text-danger",
                highlight: function (element, errorClass) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element, errorClass) {
                    $(element).removeClass("is-invalid");
                },
                submitHandler: function (form) {
                    // Show the processing indicator
                    const submitButton = $("#submit-btn");
                    submitButton.prop("disabled", true).text("Processing...");

                    // Submit the form
                    form.submit();
                }
            });

            // Custom method for validating date is in the future
            $.validator.addMethod("greaterThanToday", function (value, element) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const inputDate = new Date(value);
                return this.optional(element) || inputDate >= today;
            });

            // Custom method for validating end date is after start date
            $.validator.addMethod("greaterThanStartDate", function (value, element) {
                const startDate = new Date($("#start_date").val());
                const endDate = new Date(value);
                return this.optional(element) || endDate >= startDate;
            });

            // Validate checkboxes for days
            $.validator.addClassRules("days-checkbox", {
                required: true
            });

            // Custom error placement for checkboxes
            $("#socialPlayForm").validate({
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "days[]") {
                        error.insertAfter(element.closest(".d-flex"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            // Toggle for terms and conditions
            $("#pay_join").change(function() {
                if ($(this).is(":checked")) {
                    $(this).valid();
                }
            });
        });
    </script>
    @stack('scripts')
    <script>
        var timeout = null;
        $(".head-search-box").on('input click', function (e) {
            var val = $(this).val().split(' ').join('_');

            if (e.which == 13 && val != '') {
                //
            }
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                $.get('{{ url('search-all-events') }}?search_str=' + val, function (data) {
                    $(".search-result").html(data);
                })
            }, 200);

        })
    </script>
    <script src="{{ asset('frontend/js/site_custom.js') }}" type="text/javascript"></script>
    <script>
        $(document).on('click', function (event) {
            if (!$(event.target).closest(".searchinput").length) {
                $(".search-result").html('')
            }

        })
    </script>

    {{-- <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function () {
                navigator.serviceWorker
                    .register("/sw.js")
                    .then(res => console.log("service worker registered"))
                    .catch(err => console.log("service worker not registered", err))
            })
        }
    </script> --}}
    <script src="{{ asset('frontend/js/site_custom.js') }}" type="text/javascript"></script>
    <script>
        $(document).on('click', function (event) {
            if (!$(event.target).closest(".searchinput").length) {
                $(".search-result").html('')
            }

        })

        $(window).on('scroll', function () {
            var scrolled = $(window).scrollTop();
            if (scrolled > 600) $('.go-top').addClass('active');
            if (scrolled < 600) $('.go-top').removeClass('active');
        });
        $('.go-top').on('click', function () {
            $("html, body").animate({ scrollTop: "0" }, 500);
        });
    </script>
    @if(!Session::has('CURR_CITY'))
        <script>
            setTimeout(() => {
                $('#locationModal').modal('show');
            }, 3000)
        </script>

        <script>
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getpos);
            } else {
            }
            function getpos(position) {
                latx = position.coords.latitude;
                lonx = position.coords.longitude;
                $.post('{{url("set-u-location")}}', { '_token': "{{csrf_token()}}", "latx": latx, "lonx": lonx }, function (data) {
                    if (data.s == 1) {
                        if (localStorage.getItem("u_curr_location") === null) {
                            localStorage.setItem("u_curr_location", data.name)
                            window.location.reload();
                        }

                    } else {
                        localStorage.removeItem("u_curr_location");
                    }
                })
            }
        </script>
    @endif
</body>

</html>
