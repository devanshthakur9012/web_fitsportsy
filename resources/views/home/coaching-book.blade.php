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
/* 
    #shareButton {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #shareButton:hover {
        background-color: #0056b3;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    } */
</style>
    
        
    
    {{-- <style>
        .btn-success, .default-btn {  
            animation: glowing 800ms infinite;
        }

        @keyframes  glowing {
        0% {  box-shadow: 0 0 3px #fff; }
        50% {  box-shadow: 0 0 8px #fff; }
        100% {  box-shadow: 0 0 3px #fff; }
        }

    </style> --}}
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
            background: #6e6e6e;
            color: #ffffff;
            border-radius: 20px;
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
            background: #0a0a0a !important;
            padding: 20px;
            text-align: left;
            color: #ffffff;
            font-weight: 500;
            display: flex;
            border-radius: 3px;
            margin-bottom: 20px;
        }

        .alert_info span{
            color:#6e6e6e;
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
            background: #2e335a45;
            padding: 12px;
            border-radius: 20px;
            border: 1px dashed;
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

    /* .highlighter{
        color: #ffffff !important;
        margin-bottom: 15px !important;
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        border-bottom: 1px solid #0dc1e3;
        font-size: 18px !important;
        box-shadow: 1px 1px 7px #fff;
        font-weight: 600 !important;
    } */

    .bgFilter{
        /* background: #111635;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px !important; */
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

    /* .highlighter:before {
        content: " ";
        display: block;
        height: 90%;
        width: 100%;
        margin-left: -3px;
        margin-right: -3px;
        position: absolute;
        background: #0cc2e6;
        transform: rotate(2deg);
        top: -1px;
        left: -1px;
        border-radius: 20% 25% 20% 24%;
        padding: 10px 3px 3px 10px;
    } */
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
    </style>
@endpush
@section('content')
<section class="section-area single-detail-area py-3">
    <div class="container">
        @if (isset($tournament_detail) && count($tournament_detail['event_cover_img']))
            @if (count($tournament_detail['event_cover_img']) > 1)
                <div class="pt-3 pb-3 shadow-sm home-slider">
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
                <div class="pt-3 pb-3 shadow-sm home-slider" id="blurImg">
                    @foreach ($tournament_detail['event_cover_img'] as $item)
                        <img src="{{ env('BACKEND_BASE_URL') }}/{{$item}}" class="img-fluid rounded" alt="...">
                    @endforeach
                </div>
            @endif
        @endif

        <div class="row mt-5">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>{{ $tournament_detail['event_title'] }}</h4>
                </div>
                <div class="dark-gap text-white" style="margin-bottom: 0;">
                    <p class="dark-gap">Sport Catgeory : {{$tournament_detail['category']}}</p>
                    <div class="row">
                        <div class="col-lg-6 mbsm">
                            {{-- Timing --}}
                            <div class="d-flex align-items-center">
                                <div class="icon_box calendar_icon">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div class="text_box">
                                    <p class="mb-0">{{ $tournament_detail['event_sdate'] }}</p>
                                    <small class="text_muted">{{ $tournament_detail['event_time_day'] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            {{-- Tickets --}}
                            <div class="d-flex align-items-center ">
                                <div class="icon_box ticket_icon">
                                    <i class="fas fa-ticket-alt"></i>
                                </div>
                                <div class="text_box">
                                    <p class="mb-0">Package Price : {{ $tournament_detail['ticket_price'] }}</p>
                                    <small class="text_muted">{{ $tournament_detail['total_ticket'] }} Spots Left</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Address --}}
                    <div class="d-flex align-items-center mb-3 mt-2">
                        <div class="icon_box location_icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="text_box">
                            <!-- Using the provided latitude and longitude to open Google Maps -->
                            <p class="text_muted"></p><a class="text-white" href="{{ $tournament_detail['map_url'] }}" target="_blank">
                                {{ $tournament_detail['event_address'] }}
                            </a></p>
                        </div>
                    </div>
                    {{-- <p class="mr-3">👨‍👩‍👧‍👦 Age group: {{ $coachData->age_group }}</p>
                    <p class="mr-3">🏸 BYOE: {{ $coachData->bring_own_equipment }}</p>
                    <p>🎟️ Free Demo session: {{ $coachData->free_demo_session }}</p> --}}
                </div>
                <div class="row align-items-center mb-4">
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
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($tournament_detail['event_title']) }}%0A%0A
                            {{ strip_tags(stripslashes($tournament_detail['event_about'])) }}%0A%0A
                            📅 Date: {{ $tournament_detail['event_sdate'] }}%0A🕒 Time: {{ $tournament_detail['event_time_day'] }}%0A%0A
                            📍 Location: {{ $tournament_detail['event_address'] }}%0A%0A
                            🔗 Register here: {{ url()->current() }}"
                            target="_blank" class="social-button whatsapp">
                            <i class="fab fa-whatsapp text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-white bgFilter"> 
                    <h4 class="mb-1 highlighter">About Tournament</h4>
                    <div class="fs-3 grayText">{!! stripslashes($tournament_detail['event_about']) !!}</div>
                </div>
                {{-- <div class="bgFilter text-white"> 
                    <h4 class="mb-1 highlighter">Rules & Regulations</h4>
                    <div class="fs-3 grayText">{!! stripslashes($tournament_detail['event_disclaimer']) !!}</div>
                </div> --}}
                @if(!empty($tournament_detail['prize_reward']))
                    @php 
                        $collection = json_decode($tournament_detail['prize_reward'], true) ?? []; 
                    @endphp
                    @if(is_array($collection) && count($collection) > 0 && !empty($collection[0]))
                        <div class="bgFilter text-white">
                            <h4 class="highlighter mb-1">Overview of Session</h4>
                            @foreach ($collection as $item)
                                <div class="fs-3 grayText">🏆 {!! mb_convert_encoding($item, 'UTF-8', 'auto') !!}</div>
                            @endforeach
                        </div>
                    @endif
                @endif
                @if(count($tournament_Artist))
                <div class="text-white bgFilter2"> 
                    <h4 class="highlighter">Coaching Organizing Team & Coach</h4>
                    <div class="row">
                        @foreach ($tournament_Artist as $sport)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="mt-2 text-center refree">
                                    <div class="">
                                        <!-- Artist Image -->
                                        <img class="rounded-circle p-1 border" 
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
                <div class="countdown text-left event-ticket card shadow-sm mb-3">
                    <div class="card-body" id="countdown">
                        <p class="mb-0">Loading countdown...</p>
                    </div>
                </div>
                <div class="text-left event-ticket card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="products-reviews text-center">
                            @isset($qrCodePath)
                                <h5 class="mb-3">📲 Scan to register instantly!</h5>
                                <div class="qr-code-container mb-3" style="display: inline-block; padding: 10px; border: 2px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
                                    <img src="{{ $qrCodePath }}" alt="QR Code">
                                </div>
                                <br>
                                <!-- Download Button with Icon -->
                                <a href="{{ $qrCodePath }}" download="coaching-booking.png" class="btn btn-primary btn-sm mt-2" style="display: inline-flex; align-items: center; gap: 5px;">
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
                            <div>Contactless Ticketing & Fast-track Entry with M-ticket. <span class="text-default" data-toggle="modal" data-target="#exampleModal">Learn How ></span></div>
                        </div>
                        <div class="single-ticket">
                            @if($tournament_detail['total_ticket'] <= 0)
                                <a href="javascript:void(0)" class="btn default-btn w-100">Sold Out</a>
                            @else
                                <a href="{{ $packageLink }}" class="btn default-btn w-100">Continue To Book {{ $tournament_detail['category'] }}</a>
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
                {{-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                </div> --}}
                <div class="modal-body position-relative">
                    <button type="button" class="close modalClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <img src="{{asset('/images/contactlessm Ticket.png')}}" width="100%" alt="">
                </div>
                {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
            </div>
        </div>
              
        @if(count($tournament_Facility))
        <div class="text-white bgFilter2"> 
            <h4 class="highlighter">Tournament Facility</h4>
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
        <!-- Progress Section -->
        {{-- <div class="progress-section mb-4 mt-4">
            <h4>Overview {{ $coachData->category->category_name }} Session</h4>
            <div class="dark-progress-container mb-3">
                <div class="progress-label">Begin</div>
                <div class="dark-progress-bar-wrapper">
                    <div class="dark-progress">
                        @php
                            $activityDurationD = $sessionDurationData['activities'];
                            $lastKey = array_key_last($activityDurationD);
                        @endphp
                        @foreach ($activityDurationD as $key => $activity)
                            @php
                                $perc = ceil(($activity['activity_duration'] / $sessionDurationData['session_duration']) * 100)
                            @endphp
                            <div class="dark-progress-bar {{ $key==0 ? 'rounded-left' : ($key == $lastKey ? 'rounded-right' : '')}}" style="background:{!! Common::sessionColors($key) !!};width:{{ $perc }}%;"></div>
                        @endforeach
                    </div>
                </div>
                <div class="progress-label">{{ $sessionDurationData['session_duration'] }} Min</div>
            </div>

            <div class=" p-3 bg-dark-theme mb-3">
                @foreach ($activityDurationD as $k => $act)
                <div class="dark-session-item mb-3">
                    <div class="dark-icon-box" style="background: {!! Common::sessionColors($k) !!};"></div>
                    <div class="ml-3 d-flex flex-grow-1 justify-content-start">
                        <span style="width:50px;">{{ $act['activity_duration'] }} Mins</span>
                        <span class="text-muted ml-5">{{ $act['activity'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div> --}}

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
                                    <small>{{$tour['event_sdate']}}</small>
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
                                        @if(strtotime($tour['event_sdate']) < strtotime(date('Y-m-d')))
                                            <a href="javascript:void(0);" class="mt-1 btn default2-btn btn-sm mb-1 w-100">Completed</a>
                                        @else
                                            <a href="{{route('coaching-detail', [Str::slug($tour['event_title']),$tour['event_id']])}}" class="mt-1 btn btn-success btn-sm mb-1 w-100">Book Coaching</a>
                                        @endif
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
{{-- <script>
    document.getElementById("shareButton").addEventListener("click", async () => {
        const shareData = {
            title: "{{ $tournament_detail['event_title'] }}",
            text: "{{ $tournament_detail['event_about'] }}",
            url: "{{ url()->current() }}",
        };

        if (navigator.share) {
            try {
                await navigator.share(shareData);
                // alert("Thanks for sharing!");
            } catch (err) {
                console.error("Sharing failed", err);
            }
        } else {
            // Fallback for browsers without Web Share API
            const encodedURL = encodeURIComponent(shareData.url);
            const shareOptions = `
                <div>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=${encodedURL}" target="_blank">Share on Facebook</a><br>
                    <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent(shareData.text)}&url=${encodedURL}" target="_blank">Share on Twitter</a><br>
                    <a href="https://www.linkedin.com/shareArticle?url=${encodedURL}&title=${encodeURIComponent(shareData.title)}" target="_blank">Share on LinkedIn</a>
                </div>
            `;
            document.body.insertAdjacentHTML("beforeend", shareOptions);
        }
    });
</script> --}}
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
    // Get the event date and time from PHP
    const eventDateTime = "{{ $event_datetime }}"; // Example: "26 January, 2025 9:00 AM"

    // Parse the date and time into a JavaScript Date object
    const eventDate = new Date(eventDateTime).getTime();

    // Update the countdown every second
    // const countdownInterval = setInterval(() => {
        const now = new Date().getTime();
        const timeLeft = eventDate - now;

        if (timeLeft >= 0) {
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = `
                <h5 class="mb-3">⏳ Starts In</h5>
                <div class="timeCounter">
                    <div class="days">
                        <span>${days < 10 ? "0" + days : days}</span>
                        <div>days</div>
                    </div>
                    <div class="separator">:</div>
                    <div class="days">
                        <span>${hours < 10 ? "0" + hours : hours}</span>
                        <div>hours</div>
                    </div>
                    <div class="separator">:</div>
                    <div class="days">
                        <span>${minutes < 10 ? "0" + minutes : minutes}</span>
                        <div>minutes</div>
                    </div>
                    <div class="separator">:</div>
                    <div class="days">
                        <span>${seconds < 10 ? "0" + seconds : seconds}</span>
                        <div>seconds</div>
                    </div>
                </div>
            `;
        } else {
            clearInterval(countdownInterval);
            document.getElementById("countdown").innerHTML = "<p class='mb-0'>Event has started!</p>";
        }
    // }, 1000);
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

@endpush