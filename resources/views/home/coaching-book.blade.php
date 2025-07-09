@extends('frontend.master', ['activePage' => 'home'])
@section('og_data')
<head>
    <meta charset="UTF-8">
    <meta property="og:title" content="{{ $tournament_detail['event_title'] }}" />
    <meta property="og:description" content="Organizer : {{ $tournament_detail['sponsore_name'] }}" />
    <meta property="og:image" content="{{ env('BACKEND_BASE_URL') }}/{{$tournament_detail['event_cover_img'][0]}}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Your Site Name" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:updated_time" content="{{ now()->toAtomString() }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $tournament_detail['event_title'] }}" />
    <meta name="twitter:description" content="Organizer : {{ $tournament_detail['sponsore_name'] }}" />
    <meta name="twitter:image" content="{{ env('BACKEND_BASE_URL') }}/{{$tournament_detail['event_cover_img'][0]}}" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:site" content="@YourTwitterHandle" />

    <meta name="description" content="Organizer : {{ $tournament_detail['sponsore_name'] }}" />
    <meta name="keywords" content="{{ implode(',', $tournament_detail['event_tags']) }}" />
</head>
@endsection

@section('title', $tournament_detail['event_title'])
@push('styles')
<style>
    /* Overall Dark Theme */
    .text-muted {
        color: #888 !important;
    }

    .dark-gap {
        margin-right: 1.5rem;
    }

    /* Custom positioning for overlay content in dark theme */
    .dark-absolute {
        position: absolute;
        top: 15px;
        left: 20px;
        right: 16px;
    }

    @media (min-width: 768px) {
        .dark-absolute {
            top: 60px;
            left: 130px;
            right: 8px;
        }
    }

    @media (min-width: 992px) {
        .dark-absolute {
            top: 80px;
            left: 140px;
            right: 16px;
        }
    }

    /* Intensity Bar */
    .dark-intensity-bar {
        display: flex;
        width: 100%;
        max-width: 24rem;
        height: 0.5rem;
        background-color: #333;
        border-radius: 9999px;
        gap: 4px;
    }

    .dark-bar-section {
        flex: 1;
        height: 100%;
    }

    .rounded-left {
        border-top-left-radius: 9999px;
        border-bottom-left-radius: 9999px;
    }

    .rounded-right {
        border-top-right-radius: 9999px;
        border-bottom-right-radius: 9999px;
    }

    /* Custom Progress Bar */
    .dark-progress {
        display: flex;
        width: 100%;
        max-width: 100%;
        height: 8px;
        background-color: #444;
        border-radius: 9999px;
    }

    .dark-progress-bar {
        height: 100%;
    }

    .dark-progress-bar:first-child {
        width: 15%;
    }

    .dark-progress-bar:nth-child(2) {
        width: 20%;
    }

    .dark-progress-bar:nth-child(3) {
        width: 50%;
    }

    .dark-progress-bar:last-child {
        width: 15%;
    }

    /* Utility Classes */


    .dark-coach-image {
        width: 100px;
        height: 120px;
    }

    .dark-icon-box {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .border-dark-theme {
        border-color: #444 !important;
    }

    .bg-dark-theme {
        background-color: #1a1b2e;
        border-radius: 10px;
    }

    /* Responsive Design Enhancements */


    .single-detail-area h2,
    .single-detail-area h3,
    .single-detail-area h4 {
        font-weight: bold;
        color: #e0e0e0;
    }

    .single-detail-area p {
        font-size: 16px;
        line-height: 1.6;
        color: #ffffff;
    }

    @media (min-width: 768px) {
        .single-detail-area p {
            font-size:  16px;
        }

        .dark-gap {
            margin-right: 2rem;
        }
    }

    /* Card layout for available sports */
    .available-sports {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 0px;
    }

    .available-sport-card {
        /* padding: 10px; */
        /* border: 1px solid #444; */
        border-radius: 8px;
        width: auto;
        text-align: center;
        color: #fff;
        white-space: nowrap;
        min-width: 110px;
    }

    .available-sport-card span {
        font-size: 1.8rem;
    }

    /* Buttons */
    .btn-dark-theme {
        background-color: #444;
        color: #fff;
        border: 1px solid #555;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
    }

    .btn-dark-theme:hover {
        background-color: #555;
        border-color: #666;
    }

    /* Dark Progress Section */
    .progress-section {
        margin-top: 20px;
    }

    .dark-progress-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .progress-label {
        color: #b0b0b0;
    }

    .dark-progress-bar-wrapper {
        flex-grow: 1;
    }

    /* Icon Box for Sessions */
    .dark-icon-box {
        background-color: #444;
        width: 32px;
        height: 12px;
        border-radius: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #e0e0e0;
    }

    .dark-session-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border-bottom: 1px solid #36384a;
    }

    /* Coaches Hover Effects */
    .coach-card {
        padding: 15px;
        height: 100%;
    }


    .coach-image {
        width: 100px;
        height: 100px;
        transition: transform 0.3s ease;
    }

    .coach-details {
        margin-top: 10px;
    }

    @media (max-width: 576px) {


        .coach-image {
            width: 80px;
            height: 80px;
        }

        .mbsm{
            margin-bottom: 12px;
        }
    }

    .amenity_round{
        border-radius: 100%;
        height: 80px;
        width: 80px;
    }

    .amenity_round img{
        margin-top: 5px;
    }
</style>
    <style>
        .icon_box{
            /* background: #f8f9fa; */
            /* color: gold; */
            padding: 23px;
            border-radius: 32px;
            margin-right: 15px;
            height: 30px;
            width: 30px;
            justify-content: center;
            align-items: center;
            display: flex;
            /* border: 1px solid #6e6e6e; */
            color: initial; /* Default styling */
            border: 1px solid transparent; /* Default border */
        }
        .icon_box i{
            font-size: 20px;
        }
        
        /* Calendar Icon */
        .calendar_icon {
            color: #4A90E2; /* Vibrant blue */
            border: 2px solid #4A90E2;
        }

        /* Ticket Icon */
        .ticket_icon {
            color: #FF8C42; /* Bold orange */
            border: 2px solid #FF8C42;
        }

        .ticket_icon2 {
            color: #17a2b8; /* Bold orange */
            border: 2px solid #17a2b8;
        }

        .ticket_icon3 {
            color: #da21ff; /* Bold orange */
            border: 2px solid #da21ff;
        }

        .ticket_icon4 {
            color: #ffc107; /* Bold orange */
            border: 2px solid #ffc107;
        }

        /* Location Icon */
        .location_icon {
            color: #3AB795; /* Deep green */
            border: 2px solid #3AB795;
        }

        .profile-img {
            width: 40px;       /* Set the width of the image (adjust as necessary) */
            height: 40px;      /* Set the height of the image (adjust as necessary) */
            border-radius: 50%; /* Makes the image circular */
            object-fit: cover;  /* Ensures the image fills the circle without distorting */
            border:none !important; /* Optional: adds a border around the image */
            margin-right: 15px;
        }
        .tags{
            background: #353535;
            color: #ffffff;
            border-radius: 10px;
            padding: 3px 10px;
        }

        /* Container for the slider */
        #blurImg {
            position: relative;
            width: 100%;
            height: 400px; /* Adjust height as per your requirement */
            overflow: hidden; /* Prevent the blurred background from overflowing */
        }

        /* Pseudo-element for the blurred background */
        #blurImg::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            filter: blur(10px); /* Apply blur effect to the background */
            z-index: 1; /* Ensure the blurred background stays behind the image */
        }

        /* Image on top of the blurred background */
        #blurImg img {
            position: absolute;
            top: 50%; /* Position image at the center vertically */
            left: 50%; /* Position image at the center horizontally */
            transform: translate(-50%, -50%); /* Adjust to make sure it's exactly centered */
            max-width: 100%; /* Prevent the image from stretching beyond the container */
            max-height: 100%; /* Prevent the image from stretching beyond the container */
            z-index: 2; /* Ensure the image is on top of the background */
        }

        .alert_info{
            background: linear-gradient(to right, #121212, #161616) !important;
            padding: 20px;
            text-align: left;
            color: #ffffff;
            font-weight: 500;
            display: flex;
            border-radius: 3px;
            margin-bottom: 20px;
            border: 1px solid #2f2f2f;
        }

        .alert_info span{
            color: #ffc107;
            cursor: pointer;
        }

        .alert_info .iconBox{
            margin-right: 13px;
            font-size: 23px;
            color: #ffffff;
        }

        .social-share-buttons {
            display: flex;
            gap: 15px;
            /* margin-top: 20px; */
        }
        .social-button img {
            transition: transform 0.3s ease;
        }
        .social-button img:hover {
            transform: scale(1.1);
        }
        .facebook {
            background-color: #3b5998;
            padding: 10px;
            border-radius: 50%;
            color: #fff;
            width: 35px;
            height: 35px;
            text-align: center;
            font-size: 17px;
            line-height: 18px;
        }
        .instagram {
            background-color: #E4405F;
            padding: 10px;
            border-radius: 50%;
            color: #fff;
            width: 35px;
            height: 35px;
            text-align: center;
            font-size: 17px;
            line-height: 18px;
        }
        .linkedin {
            background-color: #0077b5;
            padding: 10px;
            color: #fff;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            text-align: center;
            font-size: 17px;
            line-height: 18px;
        }
        .whatsapp{
            background-color: #25D366;
            padding: 10px;
            color: #fff;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            text-align: center;
            font-size: 17px;
            line-height: 18px;
        }
        .instagram i:hover{
            color: #fff;
        }
        .linkedin i:hover{
            color: #fff;
        }
        .facebook i:hover{
            color: #fff;
        }

        h4 {
            font-weight: bold;
            color: #ffffff;
            font-size: 20px !important;
            margin-bottom: 8px !important;
        }

        .grayText{
            padding-left: .5rem !important;
        }

        .grayText p{
            font-size: 16px !important;
            font-weight: 400;
            color: #e7e7e7 !important;
            margin:0px;
        }

        .type_cat{
            padding: 4px 8px !important;
            background: #6e6e6e;
            color: #ffffff;
            font-size: 12px !important;
            font-weight: 400;
        }

        .refree{
            background: linear-gradient(to right, #121212, #161616) !important;
            padding: 22px 10px 22px;
            border-radius: 10px;
            border: 1px solid #2f2f2f;
        }

        .grayText * {
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            color: inherit !important;
            background: inherit !important;
        }

        .btn-white{
        background-color: #fff;
        border-radius: 4px;
        color: #000;
    }
.type_cat{
    padding: 4px 10px !important;
    background: #ffd700;
    color: #000;
    font-size: 14px !important;
    font-weight: 500;
}
.location{
    background: #6e6e6e;
    color: #fff;
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 11px !important;
    position: absolute;
    top: -12px;
    right: 10px;
}
.category{
    background: #ffd700;
    color: #000000;
    border-radius: 20px;
    padding: 4px 10px !important;
    font-size: 14px !important;
    position: absolute;
    top: 10px;
    left: 7px;
}


    .bgFilter{
        margin-bottom: 20px
    }

    .highlighter{
        position: relative;
        display: inline-block;
        padding: 9px 20px;
        font-weight: 400 !important;
        background: #0a0a0a;
        margin-bottom: 14px !important;
        font-size: 18px !important;
        color: #ffffff !important;
        border-radius: 2px;
        border-radius: 20px;
        box-shadow: 0px 0px 6px #6e6e6e;
    }

    .bgFilter2{
        margin-bottom: 20px !important;
    }

    .bgFilter2 .highlighter{
        color: #ffffff !important;
        border-radius: 20px;
        box-shadow: 0px 0px 6px #6e6e6e;
    }

     .img-thumbnail{
        background-color: #a7a7a7 !important;
     }

     .modalClose span{
        background: #ffffff;
        border-radius: 50%;
        height: 25px;
        width: 25px;
        position: absolute;
        font-size: 22px;
        line-height: 20px;
        top: -10px;
        right: -10px;
        color: #1a1b2e;
     }

     .timeCounter{
        display: flex;
        justify-content: space-around;
        align-items: center;
        text-align: center;
        text-transform: capitalize;
        background: #6e6e6e;
        padding: 10px;
        border-radius: 4px;
     }
    .default2-btn{
        background-color: #ff2f31 !important;
        border-color: #ff2f31 !important;
        padding: 7px 10px;
        color:#fff !important;
    }
    .tableDesign{
        background: #151515;
        color: #fff;
        border: 1px solid #202020;
    }
    .tableDesign th{
        border: 1px solid #202020 !important;
        background: #353535;
    }
    .tableDesign td{
        border: 1px solid #202020 !important;
    }
    .slick-prev{
        left: 10px !important;
    }
    .slick-next{
        right: 10px !important;
    }
    </style>
@endpush
@section('content')
<section class="section-area single-detail-area p-0">
    <div class="container-fluid p-0">
        @if (isset($tournament_detail) && count($tournament_detail['event_cover_img']))
            @if (count($tournament_detail['event_cover_img']) > 1)
                <div class="pt-3 pb-3 shadow-sm position-relative">
                    <div class="osahan-slider">
                        @foreach ($tournament_detail['event_cover_img'] as $item)
                            <div class="osahan-slider-item">
                                {{-- <a @if($item->redirect_link != null) href="{{$item->redirect_link}}" @endisset > --}}
                                    <img src="{{env('BACKEND_BASE_URL')}}/{{$item}}" class="img-fluid rounded" alt="...">
                                {{-- </a> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-3 shadow-sm home-slider" id="blurImg">
                    @foreach ($tournament_detail['event_cover_img'] as $item)
                        <img src="{{ env('BACKEND_BASE_URL') }}/{{$item}}" class="img-fluid rounded" alt="...">
                    @endforeach
                </div>
            @endif
        @endif
    </div>
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>{{ $tournament_detail['event_title'] }}</h4>
                </div>
                <div class="dark-gap text-white" style="margin-bottom: 0;">
                    <p class="dark-gap">Sport Catgeory : {{$tournament_detail['category']}}</p>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            {{-- Tickets --}}
                            <div class="d-flex align-items-center ">
                                <div class="icon_box ticket_icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="text_box">
                                    <p class="mb-0">Class Type : 1-on-1,Group,Online</p>
                                    {{-- <small class="text_muted">{{ $tournament_detail['total_ticket'] }} Spots Left</small> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon_box ticket_icon2">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="text_box ms-3">
                                    <p class="mb-0 fw-bold">Mon,Tue,Wed,Thu,Fri,Sat,Sun</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Age Group Filter -->
                        <div class="col-lg-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon_box ticket_icon3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="text_box ms-3">
                                    <p class="mb-0 fw-bold">Age Group : Adults,Kids</p>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Class Type Filter -->
                        <div class="col-lg-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon_box ticket_icon4">
                                    <i class="fas fa-ticket-alt"></i>
                                </div>
                                <div class="text_box ms-3">
                                    <p class="mb-0 fw-bold">Package Price : {{ $tournament_detail['ticket_price'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            {{-- Address --}}
                            <div class="d-flex align-items-center">
                                <div class="icon_box location_icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="text_box"><a class="text-white" href="{{ $tournament_detail['map_url'] }}" target="_blank">
                                        {{ $tournament_detail['event_address'] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center my-4">
                    <div class="col-lg-6 mbsm">
                        <div class="text-white">
                            <h4 class="mb-3">Organized By</h4>
                            <div class="d-flex align-items-center">
                                <img class="img-thumbnail profile-img" src="{{ env('BACKEND_BASE_URL').'/'.$tournament_detail['sponsore_img'] }}" alt="{{$tournament_detail['sponsore_name']}}">
                                <p class="mb-0 fs-2">{{$tournament_detail['sponsore_name']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="mb-3">Share : </h4>
                        <div class="social-share-buttons">
                            @php
                                $url = env('BACKEND_BASE_URL').'/'.urlencode($tournament_detail['event_cover_img'][0]);
                            @endphp
                            <!-- Facebook Share Button -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&picture={{ $url }}" target="_blank" class="social-button facebook">
                                <i class="fab fa-facebook-f text-white"></i>
                            </a>
                            <!-- Instagram Share Button (Manual Image Upload Required) -->
                            <a href="https://www.instagram.com/" target="_blank" class="social-button instagram" title="Share on Instagram">
                                <i class="fab fa-instagram text-white"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($tournament_detail['event_title']) }}&summary={{ urlencode($tournament_detail['event_address']) }}" target="_blank" class="social-button linkedin">
                                <i class="fab fa-linkedin-in text-white"></i>
                            </a>
                            {{-- <a href="https://api.whatsapp.com/send?text={{ urlencode($tournament_detail['event_title']) }}%0A%0A
                            {{ strip_tags(stripslashes($tournament_detail['event_about'])) }}%0A%0A
                            📅 Date: {{ $tournament_detail['event_sdate'] }}%0A🕒 Time: {{ $tournament_detail['event_time_day'] }}%0A%0A
                            📍 Location: {{ $tournament_detail['event_address'] }}%0A%0A
                            🔗 Register here: {{ url()->current() }}"
                            target="_blank" class="social-button whatsapp">
                            <i class="fab fa-whatsapp text-white"></i>
                            </a> --}}
                            <a href="javascript:void(0)" onclick="shareOnWhatsApp()" class="social-button whatsapp">
                                <i class="fab fa-whatsapp text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-white bgFilter"> 
                    <h4 class="mb-1 highlighter">About Coaching</h4>
                    <div class="fs-3 grayText">{!! stripslashes($tournament_detail['event_about']) !!}</div>
                </div>
                @if(!empty($tournament_detail['session_overview']))
                    @php 
                        $collection = json_decode($tournament_detail['session_overview'], true) ?? []; 
                    @endphp
                    @if(is_array($collection) && count($collection) > 0 && !empty($collection['schedule']))
                        <div class="mt-2">
                            <h4 class="mb-1 highlighter">Overview of Session</h4>
                            <!-- Duration & Calories -->
                            <div class="d-flex justify-content-between mb-1 mt-2">
                                <h6 class="mb-0">⏳ Duration: <span class="fw-bold">{{ $collection['duration'] }}</span></h6>
                                <h6 class="mb-0">🔥 Calories: <span class="fw-bold">{{ $collection['calories'] }} kcal</span></h6>
                            </div>
                            <!-- Single Animated Progress Bar -->
                            <div id="animatedProgressContainer">
                                <small class="fw-bold text-muted">Progress</small>
                                <div class="progress">
                                    <div id="activityProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                        role="progressbar" 
                                        style="width: 0%;" 
                                        aria-valuenow="0" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            <div id="stackedProgressContainer" style="display: none;">
                                <small class="fw-bold text-muted">Session Breakdown</small>
                                <div class="progress" id="stackedProgress"></div>
                            </div>
                            <h6 class="mb-2 mt-3"><i class="⏳"></i> Overview</h6>
                            <div class="d-flex flex-wrap">
                                <table class="table tableDesign">
                                    <thead>
                                        <tr>
                                            <th>Duration</th>
                                            <th>Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($collection['schedule']))
                                            @foreach ($collection['schedule'] as $item)
                                                <tr>
                                                    <td>{{ $item['time'] }}</td>
                                                    <td>{{ $item['activity'] }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>                                
                            </div>
                            <h6 class="mb-2 mt-3"><i class="⏳"></i> Benefits</h6>
                            <div class="d-flex flex-wrap">
                                @foreach ($collection['benefits'] as $benefit)
                                    <span class="badge badge-primary rounded-pill text-white m-1 px-3 py-2" style="background:#353535;">{{ $benefit }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                @if(count($tournament_Artist))
                <div class="text-white bgFilter2 mt-5"> 
                    <h4 class="highlighter">Coaching Organizing Team & Coach</h4>
                    <div class="row mt-3">
                        @foreach ($tournament_Artist as $sport)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="mt-2 text-center refree">
                                    <div class="">
                                        <!-- Artist Image -->
                                        <img class="rounded-circle p-1" style="border:1px solid #222222 !important;"
                                            src="{{ env('BACKEND_BASE_URL').'/'.$sport['artist_img'] }}" 
                                            alt="{{ $sport['artist_title'] }}" 
                                            width="90px" height="90px">
                                        <!-- Artist Title -->
                                        <p class="mt-2 mb-0">{{ $sport['artist_title'] }}</p>
                                        <!-- Artist Role -->
                                        <span class="badge badge-primary m-1 type_cat">{{ $sport['artist_role'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="text-left event-ticket card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="products-reviews text-center">
                            @isset($tournament_detail['event_qr'])
                                <h5 class="mb-3">📲 Scan to register instantly!</h5>
                                <div class="qr-code-container mb-0">
                                    <img src="{{ $tournament_detail['event_qr'] }}" alt="QR Code">
                                </div>
                                <br>
                                <!-- Download Button with Icon -->
                                <a href="{{ $tournament_detail['event_qr'] }}" download="coaching-booking.png" class="btn btn-success btn-sm w-50">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            @endisset 
                        </div>
                    </div>
                </div>
                <div class="event-ticket card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="alert_info" style="background: #FFF3D2" role="alert">
                            <div class="iconBox"><i class="fas fa-ticket-alt"></i></div>
                            <div>Seamless Check-ins & Contactless Attendance with QR Scan! <br/><span class="text-default" data-toggle="modal" data-target="#exampleModal">Learn How ></span></div>
                        </div>
                        <div class="single-ticket">
                            @if($tournament_detail['total_ticket'] <= 0)
                                <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 py-2" style="padding:12px 20px !important;">Sold Out</a>
                            @else
                                <a href="{{ $packageLink }}" class="btn btn-success btn-sm w-100 py-2" style="background:#28a745 !important;color:#fff !important;padding:12px 20px !important;">Continue To Book {{ $tournament_detail['category'] }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-left event-ticket card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="products-reviews">
                            <h4>{{$tournament_detail['event_address_title']}}</h4>
                            <span class="d-block" style="font-size: 12px;">{{ $tournament_detail['event_address'] }}</span>
                            @isset($tournament_detail['map_url'])
                                <div class="progress-section mb-0 mt-3" style="position: relative;">
                                    <!-- Embed Google Map -->
                                    <iframe 
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30766738.48171446!2d60.96917638629971!3d19.72516357822192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791%3A0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sus!4v1734715250824!5m2!1sen!2sus" 
                                        width="100%" 
                                        height="100%" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                
                                    <!-- Overlay that redirects on click -->
                                    <a href="{{ $tournament_detail['map_url'] }}" target="_blank" 
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0); z-index: 10;">
                                    </a>
                                </div>    
                            @endisset      
                            @isset($qrCode)
                            {!! $qrCode !!}
                            @endisset                 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body position-relative">
                    <button type="button" class="close modalClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <img src="{{asset('/images/qr-attandance.png')}}" width="100%" alt="">
                </div>
            </div>
            </div>
        </div>
              
        @if(count($tournament_Facility))
        <div class="text-white bgFilter2 mt-4"> 
            <h4 class="highlighter">Coaching Facility</h4>
            <div class="available-sports">
                @foreach ($tournament_Facility as $sport)
                    <div class="available-sport-card">
                        <img class="rounded-circle p-1" src="{{ env('BACKEND_BASE_URL').'/'.$sport['facility_img'] }}" alt="$sport['facility_title']" >
                        <p class="mb-0 mt-1" style="font-size:12px; ">{{ $sport['facility_title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        @if(count($tournament_Restriction))
        <div class="text-white bgFilter2"> 
            <h4 class="highlighter">Coaching Prohibited</h4>
            <div class="available-sports">
                @foreach ($tournament_Restriction as $sport)
                    <div class="available-sport-card">
                        <img class="rounded-circle p-1" src="{{ env('BACKEND_BASE_URL').'/'.$sport['restriction_img'] }}" alt="$sport['restriction_title']" >
                        <p class="mb-0 mt-1" style="font-size:12px; ">{{ $sport['restriction_title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif  
        @if(count($tournament_gallery))
            <h4 class="highlighter bgFilter2">Coaching Gallery</h4>
            <div class="tournament-gallery">
                <div class="row gap-3">
                    @foreach ($tournament_gallery as $sport)
                        <div class="gallery-item col-lg-3">
                            <img class="gallery-image p-1" src="{{ env('BACKEND_BASE_URL').'/'.$sport }}" alt="Tournament Gallery Image" width="100%">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    
        
        @if(count($tournament_detail['event_tags']))
            <div class="text-white bgFilter2"> 
                <h4 class="highlighter ">Tags</h4>
                <div class="available-sports mb-4 gap-2">
                    @foreach ($tournament_detail['event_tags'] as $tags)
                        <span class="tags text-capitalize">{{ $tags }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        @if (isset($related_tournament) && count($related_tournament))
            <div class="hawan_section">
                <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
                    <h1 class="h4 mb-0 float-left">Related Coaching</h1>
                </div>
                <div class="event-block-slider">
                    @foreach ($related_tournament as $tour)
                        <div class="card m-card shadow-sm border-0 listcard">
                            <div>
                                <div class="m-card-cover  position-relative">
                                    <img src="{{env('BACKEND_BASE_URL')}}/{{$tour['event_img']}}" class="card-img-top" alt="{{$tour['event_title']}}">
                                    @isset($tour['cid'])
                                    
                                        <a href="{{route('coaching',['category'=>Str::slug($tour['category'])])}}" class="my-2"><small class="category">{{$tour['category']}}</small></a>
                                    @endisset
                                </div>
                                <div class="card-body position-relative">
                                    <h5 class="card-title mb-2"><u>{{$tour['event_title']}}</u></h5>
                                    {{-- <small>{{$tour['event_sdate']}}</small> --}}
                                    <p class="my-2"><small class="location"><i class="fas fa-map-marker-alt pr-1"></i>{{$tour['event_place_name']}}</small></p>
                                    <p class="card-text mb-0">
                                        <small class="text-dark" title="{{$tour['event_place_address']}}"><i class="fas fa-map pr-1"></i>
                                        {{ strlen($tour['event_place_address']) > 50 ? substr($tour['event_place_address'], 0, 50) . '...' : $tour['event_place_address'] }}
                                        </small>
                                    </p>
                                    @php
                                        // Ensure ticket_types exists and is an array
                                        if (isset($tour['ticket_types']) && is_array($tour['ticket_types'])) {
                                            // Sort the array by extracting numeric and alphabetic parts
                                            uksort($tour['ticket_types'], function ($a, $b) {
                                                // Extract the numeric part of the keys
                                                $numA = (int) preg_replace('/\D/', '', $a); // Get numbers only
                                                $numB = (int) preg_replace('/\D/', '', $b); // Get numbers only
                                    
                                                // Compare numeric parts first
                                                if ($numA !== $numB) {
                                                    return $numA <=> $numB;
                                                }
                                    
                                                // If numeric parts are the same, compare alphabetically (B vs G)
                                                return strcmp($a, $b);
                                            });
                                        }
                                    @endphp
                                    @isset($tour['ticket_types'])
                                        @foreach ($tour['ticket_types'] as $key => $item)
                                            <span class="badge badge-primary m-1 type_cat" data-toggle="tooltip" data-placement="top" title="{{ $key }}">{{ $item }}</span>
                                        @endforeach
                                    @endisset
                                    <div class="mt-2">
                                        <button class="mt-1 btn btn-outline-white btn-sm mb-1">Package Price : {{$tour['event_ticket_price']}}</button>
                                        <!-- <a href="{{route('coaching-detail', [Str::slug($tour['event_title']),$tour['event_id']])}}" class="mt-1 btn btn-success btn-sm mb-1 w-100">Book Coaching</a> -->

                                        <div class="d-flex mt-1 mb-1">
                                            @if($tour['play_free_trial'])
                                                @php
                                                    $inputObj = new stdClass();
                                                    $inputObj->params = 'id='.$tour['event_id'];
                                                    $inputObj->url = route('free-trail');
                                                    $encLink = Common::encryptLink($inputObj);

                                                    $ticket_type_keys = array_keys($tour['ticket_types']);
                                                    $data_slots = json_encode(array_keys($tour['ticket_types']));
                                                @endphp
                                                <button class="btn btn-primary btn-sm mr-1 w-50 free_trail_btn" data-url="{{$encLink}}" data-title="{{$tour['event_title']}}" data-group-location='@json($tour["group_location"])' data-group-short_name='@json($tour["group_short_name"])' data-slots="{{$data_slots}}" style="background:#28a745 !important;" data-toggle="modal" data-target="#freeTrailModal">Try For Free</button>
                                                <a href="{{ route('coaching-detail', [Str::slug($tour['event_title']), $tour['event_id']]) }}" class="btn btn-success btn-sm w-50">Book Coaching</a>
                                            @else
                                                <a href="{{ route('coaching-detail', [Str::slug($tour['event_title']), $tour['event_id']]) }}" class="btn btn-success btn-sm w-100">Book Coaching</a>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <br>
    </div>
</section>
<script>
        window.onload = function() {
            // Get the dynamic background image URL
            const backgroundImage = "{{ env('BACKEND_BASE_URL') . '/' . $tournament_detail['event_cover_img'][0] }}";

            // Add the background-image dynamically to the pseudo-element using JavaScript
            const style = document.createElement('style');
            style.innerHTML = `
                #blurImg::before {
                    background-image: url(${backgroundImage});
                }
            `;
            document.head.appendChild(style);
        };
</script>
@php
    $date = $tournament_detail['event_sdate']; // Example: "26 January, 2025"
    $time = $tournament_detail['event_time_day']; // Example: "Sunday, 9:00 AM TO 7:00 PM"

    // Split the time string to get the start time
    $time_parts = explode(', ', $time);
    $start_time = isset($time_parts[1]) ? explode(' TO ', $time_parts[1])[0] : ''; // Extract "9:00 AM"

    // Combine date and start time into a single datetime string
    $event_datetime = "$date $start_time"; // Example: "26 January, 2025 9:00 AM"
@endphp


@endsection
@include('alert-messages')

@push('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script>
    document.getElementById('shareBtn').addEventListener('click', function() {
        // Get data attributes from the button
        var title = this.getAttribute('data-title');
        var eventDate = this.getAttribute('data-sdate');
        var eventTime = this.getAttribute('data-time');
        var ticketPrice = this.getAttribute('data-ticket');
        var totalSpots = this.getAttribute('data-total');
        var tournamentLink = this.getAttribute('data-link');
        var imageUrl = this.getAttribute('data-img');  // Get the image URL

        // Create the WhatsApp message with the image URL included directly in the message text
        var message = `Hey! Check out this coaching: 
        \nTitle: ${title}
        \nDate: ${eventDate}
        \nTime: ${eventTime}
        \nTicket Price: ${ticketPrice}
        \nRemaining Spots: ${totalSpots}
        \n\nMore details: ${tournamentLink}`;  // WhatsApp will recognize this as an image URL for preview

        // Encode the message for URL
        var encodedMessage = encodeURIComponent(message);

        // Open WhatsApp with the pre-filled message (image preview will automatically be handled by WhatsApp)
        var whatsappURL = `https://wa.me/?text=${encodedMessage}`;
        window.open(whatsappURL, '_blank');
    });
</script>
<!-- @if(isset($collection['schedule'])) -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    let activities = @json($collection['schedule']);
    let progressBar = document.getElementById("activityProgressBar");
    let animatedProgressContainer = document.getElementById("animatedProgressContainer");
    let stackedProgressContainer = document.getElementById("stackedProgressContainer");
    let stackedProgress = document.getElementById("stackedProgress");

    let colors = ["bg-primary", "bg-success", "bg-warning", "bg-danger", "bg-info"];
    
    // First, calculate total minutes
    let totalMinutes = 0;
    activities.forEach(activity => {
        let timeStr = activity.time;
        let minutes = parseInt(timeStr); // This works for "5 mins", "15 mins", etc.
        totalMinutes += minutes;
    });

    let currentIndex = 0;
    let progress = 0;
    let stackedHtml = "";

    function updateProgress() {
        if (currentIndex < activities.length) {
            let activity = activities[currentIndex];
            let timeStr = activity.time;
            let minutes = parseInt(timeStr);
            let percentage = Math.round((minutes / totalMinutes) * 100);
            
            progress += percentage;
            progressBar.style.width = progress + "%";
            progressBar.textContent = activity.activity; // Show name inside bar

            // Smooth transition effect
            progressBar.style.transition = "width 1.5s ease-in-out";

            // Change color dynamically
            progressBar.className = "progress-bar progress-bar-striped progress-bar-animated " + colors[currentIndex % colors.length];

            // Store for final stacked progress (without text)
            stackedHtml += `<div class="progress-bar ${colors[currentIndex % colors.length]}" role="progressbar" style="width: ${percentage}%" 
                            aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" title="${activity.activity} (${activity.time})">
                        </div>`;

            currentIndex++;
            
            // Adjust timeout based on activity duration (shorter activities animate faster)
            let timeoutDuration = 1000 + (minutes * 50); // Base 1s + 50ms per minute
            setTimeout(updateProgress, timeoutDuration);
        } else {
            // After last step, replace single progress with stacked (without text)
            setTimeout(() => {
                animatedProgressContainer.style.display = "none";
                stackedProgressContainer.style.display = "block";
                stackedProgress.innerHTML = stackedHtml;

                // Reinitialize Bootstrap Tooltip for New Elements
                let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });

            }, 2000);
        }
    }

    updateProgress(); // Start progress animation
});
    </script>

<!-- @endif -->
   <script>
    function shareOnWhatsApp() {
        // Text content
        const title = "{{ $tournament_detail['event_title'] }}";
        const about = "{{ strip_tags($tournament_detail['event_about']) }}";
        const date = "{{ $tournament_detail['event_sdate'] }}";
        const time = "{{ $tournament_detail['event_time_day'] }}";
        const location = "{{ $tournament_detail['event_address'] }}";
        const url = "{{ url()->current() }}";
        
        // Image URL (must be publicly accessible)
        const imageUrl = "{{ env('BACKEND_BASE_URL') }}/{{ $tournament_detail['event_cover_img'][0] }}";
        
        // Construct message with proper spacing
        const message = `*${title}*\n\n📅 *Date:* ${date}\n🕒 *Time:* ${time}\n📍 *Location:* ${location}\n\n🔗 Register here: ${url}`;
        
        // Encode for URL
        const encodedMessage = encodeURIComponent(message);
        const encodedImage = encodeURIComponent(imageUrl);
        
        // WhatsApp share URL (with fallback)
        const whatsappUrl = `https://api.whatsapp.com/send?text=${encodedMessage}`;
        
        window.open(whatsappUrl, '_blank');
    }
    </script>
@endpush