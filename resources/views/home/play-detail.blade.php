@extends('frontend.master', ['activePage' => 'home'])
@section('title', $play['play_title'])
@section('content')
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

        /* Location Icon */
        .location_icon {
            color: #3AB795; /* Deep green */
            border: 2px solid #3AB795;
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

        .cardBox h4 {
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

    .cardBox{
        background: #2e335a45;
        border-radius: 20px;
        border: none !important;
        padding: 30px 40px;
    }

    .playerBox{
        border-bottom: 1px solid #fff;
        padding:12px 0px !important;
    }

    .playerBox .playerImg{
        border-radius: 50%;
        height: 40px;
        width: 40px;
        background-color: transparent !important;
        border: 2px solid #fff !important;
    }
    </style>
    <style>
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
    #cancel_edit{
        position: absolute;
        right: -10px;
        top: -10px;
        border-radius: 50%;
        background: #1a1b2e;
        border: none;
        width: 25px;
        height: 25px;
        color: #ffff;
    }
    /* Zoom-in animation */
    @keyframes zoomIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* Apply animation to the modal */
    .modal-dialog.animate-zoom-in {
        animation: zoomIn 0.5s ease-out;
    }
    .modal-backdrop {
        backdrop-filter: blur(5px);
    }
    .catIcon{
        width: 20px !important;
        height: 20px !important;
    }
    .default2-btn{
        background-color: #ff2f31 !important;
        border-color: #ff2f31 !important;
        padding: 7px 10px;
        color:#fff !important;
    }
    .badge-default{
        color: #fff;
        background-color: #6e6e6e;
        padding: 4px 8px;
    }
    .badge-default:hover{
        color: #fff;
        background-color: #06408d;
    }
    .badge-success{
        padding: 3px 8px !important;
    }
    </style>
@endpush
<section class="section-area single-detail-area py-3">
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="cardBox">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-1">{{$play['play_title']}}</h4>
                            <small class="dark-gap mb-1">Hosted by {{$play['user_name']}}</small>
                        </div>
                        <div>
                            <img class="img-thumbnail profile-img" src="{{env('BACKEND_BASE_URL')."/".$play['user_img']}}">
                        </div>
                    </div>
                    <div class="dark-gap text-white mt-3 m-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon_box calendar_icon">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="text_box">
                                        <p class="mb-0">Play Date</p>
                                        <small class="mb-0">{{$play['play_sdate']}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center ">
                                    <div class="icon_box ticket_icon">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <div class="text_box">
                                        @if ($play['pay_join'] == 1)
                                            <p class="mb-0">Price : {{$play['play_price']}}</p>
                                        @endif
                                        <small class="text_muted">{{$play['play_slots']}} Spots Left</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <div class="d-flex align-items-center mb-3 mt-2">
                                    <div class="icon_box location_icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="text_box">
                                        <p class="mb-0">Location</p>
                                        <small class="text_muted">{{$play['play_place_name']}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                @isset($play['play_note'])
                                    <div class="mb-2">
                                        <h6 class="mb-1">Notes</h6>
                                        <p>{{$play['play_note']}}</p>
                                    </div>
                                @endisset
                                <div class="d-flex justify-content-between align-items-end mb-3">
                                    @isset($play['play_skill_level'])
                                        @if (is_array($play['play_skill_level']) && count($play['play_skill_level']))
                                            <div class="">
                                                <h6 class="mb-1">Skills</h6>
                                                @foreach ($play['play_skill_level'] as $item)
                                                    <span class="badge badge-default">{{$item}}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endisset
                                    @if(isset($play['play_upi']) && !empty($play['play_upi']))
                                    <div class="">
                                        <small>UPI ID / Mobile No. : {{$play['play_upi']}}</small>
                                    </div>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    @if (Common::isUserLogin())
                                        <button class="text-center btn default-btn w-100"  data-toggle="modal"
                                        data-target="#joinModal">Join Now</button>
                                    @else
                                        @php session(['redirect_url' => url()->current()]); @endphp
                                        <a href="{{ route('userLogin') }}" class="btn default-btn btn-block w-100">Login To Join</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cardBox">
                    <h4 class="mb-1">Players ({{ count($joinedUsers) }})</h4>
                    @if(count($joinedUsers) > 0)
                        @foreach($joinedUsers as $index => $user)
                            @if($index < 2) <!-- Show first two players -->
                                <div class="playerBox d-flex align-items-center">
                                    <img class="img-thumbnail playerImg" 
                                         src="{{ $user['user_img'] ? env('BACKEND_BASE_URL').'/'.$user['user_img'] : 'https://via.placeholder.com/150' }}">
                                    <div class="text_box ml-3">
                                        <h6 class="text_muted mb-0">{{ $user['user_name'] }}</h6>
                                        <span class="mb-0">{{ $user['status'] }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
            
                        <!-- Show "..." if there are more than 2 players -->
                        @if(count($joinedUsers) > 3)
                            <div class="playerBox d-flex align-items-center">
                                <span class="ml-3">...</span>
                            </div>
                        @endif
            
                        <!-- Show the last player if there are more than 2 players -->
                        @if(count($joinedUsers) > 2)
                            <div class="playerBox d-flex align-items-center">
                                <img class="img-thumbnail playerImg" 
                                     src="{{ $joinedUsers[count($joinedUsers)-1]['user_img'] ? env('BACKEND_BASE_URL').'/'.$joinedUsers[count($joinedUsers)-1]['user_img'] : 'https://via.placeholder.com/150' }}">
                                <div class="text_box ml-3">
                                    <h6 class="text_muted mb-0">{{ $joinedUsers[count($joinedUsers)-1]['user_name'] }}</h6>
                                    <span class="mb-0">{{ $joinedUsers[count($joinedUsers)-1]['status'] }}</span>
                                </div>
                            </div>
                        @endif
                    @else
                        <p>No players joined yet.</p>
                    @endif
                </div>
            </div>            
            @if (isset($relatedPlay) && count($relatedPlay))
                <div class="hawan_section col-12">
                    <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
                        <h2 class="h4 mb-0 float-left">Related Play</h2>
                    </div>
                    <div class="event-block-slider">
                        @foreach ($relatedPlay as $plays)
                            <div class="card m-card shadow-sm border-0 listcard">
                                <div>
                                    <div class="card-body position-relative">
                                        <div class="d-flex gap-1 align-items-start mb-3">
                                            <div class="socialImgBox">
                                                <img src="{{env('BACKEND_BASE_URL')."/".$play['user_img']}}" class="profile-img" alt="{{$play['user_name']}}">
                                                @if (isset($plays['joinedUserData']) && count($plays['joinedUserData']) > 0)
                                                    @php
                                                        $lastUser = $plays['joinedUserData'][count($plays['joinedUserData']) - 1];
                                                    @endphp
                                                    <img src="{{ env('BACKEND_BASE_URL') . '/' . $lastUser['user_img'] }}" class="smallImg" alt="{{ $lastUser['user_name'] }}">
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="card-title mb-0 text-capitalize social-title">{{$plays['play_title']}}</h4>
                                                <small>{{$plays['user_name']}} | @if (isset($plays['joinedUserData']) && count($plays['joinedUserData']))<span class="text-success">{{count($plays['joinedUserData'])}}</span>/@endif{{$plays['play_slots']}} slots</small>
                                            </div>
                                        </div>
                                        <div class="my-2">
                                            @isset($plays['category_name'])
                                                <a href="{{route('coaching',['category'=>Str::slug($plays['category_name'])])}}" class="d-inline-flex justify-content-center align-items-center badge badge-default fw-normal"><img src="{{env('BACKEND_BASE_URL')."/".$plays['category_img']}}" class="mr-1 catIcon" alt="{{$plays['category_name']}}"><small>{{$plays['category_name']}}</small></a>
                                            @endisset
                                            @if(isset($plays['pay_join']) && $plays['pay_join'] == 1)
                                                <a href="javascript:void(0)" class="d-inline-flex justify-content-center align-items-center badge badge-success fw-normal"><img src="{{asset('frontend/images/pay-join-icon.png')}}" class="mr-1 catIcon" alt="Price Tag"><small>INR {{$plays['play_price']}}</small></a>
                                            @endif
                                        </div>
                                        <p class="card-text mb-2">
                                            <small class="text-dark text-capitalize" title="{{$plays['play_place_location']}}"><i class="fas fa-map-marker-alt pr-1"></i>
                                            {{ Str::lower(strlen($plays['play_place_location']) > 40 ? substr($plays['play_place_location'], 0, 40) . '...' : $plays['play_place_location']) }}
                                            </small>
                                        </p>
                                        @isset($play['play_skill_level'])
                                            @if (is_array($play['play_skill_level']) && count($play['play_skill_level']))
                                                @foreach ($play['play_skill_level'] as $item)
                                                    <span class="badge badge-default">{{$item}}</span>
                                                @endforeach
                                            @endif
                                        @endisset
                                        <div class="mt-2">
                                            <button class="mt-1 btn btn-outline-white btn-sm mb-1"><i class="far fa-calendar-alt pr-2"></i> <small>{{$plays['play_sdate']}}</small> </button>
                                            <a href="{{route('play', $plays['play_uuid'])}}" class="mt-1 btn default2-btn btn-sm mb-1 w-100">Join Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- MODAL --}}
        <div class="modal fade" id="joinModal" tabindex="-1" role="dialog" aria-labelledby="joinModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="joinModalLabel">{{$play['play_title']}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center mb-3">Fill below details and join</h6>
                        @php
                            $inputObj = new stdClass();
                            $inputObj->params = 'id='.$play['play_id'];
                            $inputObj->url = url('join-play');
                            $encLink = Common::encryptLink($inputObj);
                        @endphp
                        <form id="joinForm" method="POST" action="{{$encLink}}">
                            @csrf
                            <div class="form-group">
                                <label for="txt_number">Transaction Number</label>
                                <input type="text" class="form-control" id="txt_number" name="txt_number" placeholder="Enter transaction Number">
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter a message (optional)"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn default-btn w-100">Join</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</section>
@include('alert-messages')
@endsection