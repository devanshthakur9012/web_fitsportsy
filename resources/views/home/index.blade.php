@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Discover Sports coachings in Bangalore'))
@section('og_data')
    <meta name="title" content="Discover Sports coachings in Bangalore | fitsportsy" />
    <meta name="description" content="Find cricket, tennis, and badminton coachings in Bangalore, Chennai, and Hyderabad. Book top courts and play sports with ease on fitsportsy!" />
    <meta name="keywords" content="fitsportsy tournament bangalore, cricket tournament in chennai, tennis tournament chennai, tennis coachings in bangalore, badminton court in chennai, badminton courts bangalore, badminton courts hyderabad, play tournament in bangalore, play tournament in chennai, play tennis in bangalore" />

    <meta property="og:title" content=Discover Sports coachings in Bangalore | fitsportsy>
    <meta property="og:site_name" content=fitsportsy>
    <meta property="og:url" content=https://www.fitsportsy.in/>
    <meta property="og:description" content=Find cricket, tennis, and badminton coachings in Bangalore, Chennai, and Hyderabad. Book top courts and play sports with ease on fitsportsy!>
    <meta property="og:type" content=business.business>
    <meta property="og:image" content=https://app.fitsportsy.in/images/event/1734716694.png><meta property="og:image" content=https://app.fitsportsy.in/images/event/1734716783.png><meta property="og:image" content=https://app.fitsportsy.in/images/event/1734716795.png><meta property="og:image" content=https://app.fitsportsy.in/images/event/1734716807.png><meta property="og:image" content=https://app.fitsportsy.in/images/event/1734716818.png>

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Discover Sports coachings in Bangalore | fitsportsy">
    <meta name="twitter:site" content="@fitsportsy">
    <meta name="twitter:description" content="Find cricket, tennis, and badminton coachings in Bangalore, Chennai, and Hyderabad. Book top courts and play sports with ease on fitsportsy!">
    <meta name="twitter:image" content="https://app.fitsportsy.in/images/event/1734716738.png">
    <meta name="twitter:image:alt" content="fitsportsy coachings ">

@endsection
@section('content')
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
<style>
.section-title {
    position: relative;
    padding-bottom: 15px;
}

.section-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, #6b46c1, #9f7aea);
}

.category-card {
    transition: all 0.4s ease;
    border-radius: 12px;
    overflow: hidden;
    border: none;
    /* background: #ffffff; */
    position: relative;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    border-color: transparent;
}

.category-card .card-img-top {
    position: relative;
    overflow: hidden;
}

.category-card img.category-img {
    transition: transform 0.5s ease, filter 0.5s ease;
    filter: brightness(0.85);
    height: 220px;
    object-fit: cover;
}

.category-card:hover img.category-img {
    transform: scale(1.08);
    filter: brightness(1);
}

.img-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.65));
    z-index: 1;
}

.category-card .card-body {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 20px;
    z-index: 2;
    text-align: center;
}

.category-card .card-title {
    color: #fff;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.category-card .explore-link {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
    display: inline-block;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 6px 12px;
    border-radius: 20px;
    background-color: rgba(255, 255, 255, 0.15);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.4);
    text-decoration: none;
    cursor: pointer;
}

.category-card:hover .explore-link {
    opacity: 1;
    transform: translateY(0);
}

.hover-effect {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
</style>
<div class="pt-3 pb-3 shadow-sm home-slider">
    <div class="osahan-slider">
        @if (isset($tournament) && count($tournament['banner_img']))
            @foreach ($tournament['banner_img'] as $item)
                <div class="osahan-slider-item">
                    {{-- <a @if($item->redirect_link != null) href="{{$item->redirect_link}}" @endisset > --}}
                        <img src="{{env('BACKEND_BASE_URL')}}/{{$item}}" class="img-fluid rounded" alt="">
                    {{-- </a> --}}
                </div>
            @endforeach
        @endif
    </div>
</div>
<div class="container mt-5">
    <div class="hawan_section">
        <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
            <div class="h4 mb-0 float-left">
                <h1 class="h4 mb-0 float-left mr-2 gradient-text">Group Sessions</h1>
                <!-- <img width="180px" src="{{asset('/images/coach-therapist.png')}}" alt="Group Sessions">  -->
                <button class="btn social-btn py-2" data-toggle="modal" data-target="#socialPlay">Create</button>
            </div>
            <a href="{{route('group-sessions')}}" class="d-sm-inline-block text-xs float-right "> See All </a>
        </div>
        @if (isset($tournament) && count($tournament['social_play']))
        <div class="event-block-slider">
            @foreach ($tournament['social_play'] as $play)
                <div class="card m-card shadow-sm border-0 listcard">
                    <div>
                        <div class="card-body position-relative">
                            <div class="d-flex gap-1 align-items-start mb-3">
                                <div class="socialImgBox">
                                    <img src="{{env('BACKEND_BASE_URL')."/".$play['user_img']}}" class="profile-img" alt="{{$play['user_name']}}">
                                    @if (isset($play['joinedUsers']) && count($play['joinedUsers']) > 0)
                                        @php
                                            $lastUser = $play['joinedUsers'][count($play['joinedUsers']) - 1];
                                        @endphp
                                        <img src="{{ env('BACKEND_BASE_URL') . '/' . $lastUser['user_img'] }}" class="smallImg" alt="{{ $lastUser['user_name'] }}">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="card-title mb-0 text-capitalize social-title">{{$play['play_title']}}</h4>
                                    <small>{{$play['user_name']}} | @if (isset($play['joinedUsers']) && count($play['joinedUsers']))<span class="text-success">{{count($play['joinedUsers'])}}</span>/@endif{{$play['play_slots']}} slots</small>
                                </div>
                            </div>
                            <div class="my-2">
                                @isset($play['category_name'])
                                    <a href="{{route('coaching',['category'=>Str::slug($play['category_name'])])}}" class="d-inline-flex justify-content-center align-items-center badge badge-default fw-normal"><img src="{{env('BACKEND_BASE_URL')."/".$play['category_img']}}" class="mr-1 catIcon" alt="{{$play['category_name']}}"><small>{{$play['category_name']}}</small></a>
                                @endisset
                                <!-- @if(isset($play['pay_join']) && $play['pay_join'] == 1)
                                    <a href="javascript:void(0)" class="d-inline-flex justify-content-center align-items-center badge badge-success fw-normal"><img src="{{asset('frontend/images/pay-join-icon.png')}}" class="mr-1 catIcon" alt="Price Tag"><small>INR {{$play['play_price']}}</small></a>
                                @endif -->
                                @if(isset($play['play_type']))
                                    <a href="javascript:void(0)" class="d-inline-flex justify-content-center align-items-center badge fw-normal" style="background:#723ac6;"><img src="{{asset('images/address.png')}}" class="mr-1 border catIcon" alt="Price Tag"><small class="text-capitalize text-white"> {{$play['play_type']}}</small></a>
                                @endif
                                @if(isset($play['play_gender']))
                                    <a href="javascript:void(0)" class="d-inline-flex justify-content-center align-items-center badge badge-primary fw-normal"><img src="{{asset('frontend/images/gender-icon.png')}}" class="mr-1 rounded-0 catIcon" alt="Price Tag"><small class="text-capitalize text-white"> {{$play['play_gender']}}</small></a>
                                @endif
                            </div>
                            <p class="card-text mb-2">
                                <small class="text-dark text-capitalize" title="{{$play['play_place_location']}}"><i class="fas fa-map-marker-alt pr-1"></i>
                                {{ Str::lower(strlen($play['play_place_location']) > 40 ? substr($play['play_place_location'], 0, 40) . '...' : $play['play_place_location']) }}
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
                                <button class="mt-1 btn btn-outline-white btn-sm mb-1"><i class="far fa-calendar-alt pr-2"></i> <small>{{$play['play_sdate']}}</small> </button>
                                <a href="{{route('play', $play['play_uuid'])}}" class="mt-1 btn default2-btn btn-sm mb-1 w-100">Join Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>

    @if (isset($tournament) && count($tournament['catgeory_data']))
        @foreach ($tournament['catgeory_data'] as $data)
            @php $locName = "adv_image_".$loop->index +1; @endphp
            @if (isset($tournament['location_images']) && isset($tournament['location_images'][$locName]))
                <div class="row my-5">
                    <div class="col-lg-12">
                        <a class="small_banner" target="_blank">
                            <img src="{{env('BACKEND_BASE_URL')}}/{{$tournament['location_images'][$locName]}}" alt="">
                        </a>
                    </div>
                </div>
            @endif
            <div class="hawan_section">
                <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
                    <h1 class="h4 mb-0 float-left">{{$data['category_name']}}</h1>
                    <a href="{{ route('coaching', [Str::slug($data['category_name'])]) }}" class="d-sm-inline-block text-xs float-right "> See All </a>
                </div>
                <div class="event-block-slider">
                    @foreach ($data['events'] as $tours)
                        <div class="card m-card shadow-sm border-0 listcard">
                            <div>
                                <div class="m-card-cover  position-relative">
                                    <img src="{{env('BACKEND_BASE_URL')}}/{{$tours['event_img']}}" class="card-img-top" alt="{{$tours['event_title']}}">
                                    @isset($tours['cid'])
                                        <a href="{{route('coaching',['category'=>Str::slug($tours['category'])])}}" class="my-2"><small class="category">{{$tours['category']}}</small></a>
                                    @endisset
                                </div>
                                <div class="card-body position-relative">
                                    <h5 class="card-title mb-2"><u>{{$tours['event_title']}}</u></h5>
                                    <p class="my-2"><small class="location"><i class="fas fa-map-marker-alt pr-1"></i>{{$tours['event_place_name']}}</small></p>
                                    <p class="card-text mb-0">
                                        <small class="text-dark" title="{{$tours['event_place_address']}}"><i class="fas fa-map pr-1"></i>
                                        {{ strlen($tours['event_place_address']) > 50 ? substr($tours['event_place_address'], 0, 50) . '...' : $tours['event_place_address'] }}
                                        </small>
                                    </p>
                                    @php
                                        // Ensure ticket_types exists and is an array
                                        if (isset($tours['ticket_types']) && is_array($tours['ticket_types'])) {
                                            // Sort the array by extracting numeric and alphabetic parts
                                            uksort($tours['ticket_types'], function ($a, $b) {
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
                                    @isset($tours['ticket_types'])
                                        @foreach ($tours['ticket_types'] as $key => $item)
                                            <span class="badge badge-primary m-1 type_cat" data-toggle="tooltip" data-placement="top" title="{{ $key }}">{{ $item }}</span>
                                        @endforeach
                                    @endisset
                                    <div class="mt-2">
                                        <button class="mt-1 btn btn-outline-white btn-sm mb-1">Package Price : {{$tours['event_ticket_price']}}</button>

                                       <div class="d-flex mt-1 mb-1">
                                            @if($tours['play_free_trial'])
                                                @php
                                                    $inputObj = new stdClass();
                                                    $inputObj->params = 'id='.$tours['event_id'];
                                                    $inputObj->url = route('free-trail');
                                                    $encLink = Common::encryptLink($inputObj);

                                                    $ticket_type_keys = array_keys($tours['ticket_types']);
                                                    $data_slots = json_encode(array_keys($tours['ticket_types']));
                                                @endphp
                                                <button class="btn btn-primary btn-sm mr-1 w-50 free_trail_btn" data-url="{{$encLink}}" data-title="{{$tours['event_title']}}" data-slots="{{$data_slots}}" style="background:#28a745 !important;" data-toggle="modal" data-target="#freeTrailModal">Free Trial</button>
                                                <a href="{{ route('coaching-detail', [Str::slug($tours['event_title']), $tours['event_id']]) }}" class="btn btn-success btn-sm w-50">Book Coaching</a>
                                            @else
                                                <a href="{{ route('coaching-detail', [Str::slug($tours['event_title']), $tours['event_id']]) }}" class="btn btn-success btn-sm w-100">Book Coaching</a>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif

    {{-- @if (isset($tournament['location_images']) && isset($tournament['location_images']['adv_image_1']))
        <div class="row my-5">
            <div class="col-lg-12">
                <a class="small_banner" target="_blank">
                    <img src="{{env('BACKEND_BASE_URL')}}/{{$tournament['location_images']['adv_image_1']}}" alt="">
                </a>
            </div>
        </div>
    @endif
    @if (isset($tournament) && count($tournament['nearby_event']))
        <div class="hawan_section">
            <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
                <h2 class="h4 mb-0 float-left">Nearby Coaching</h2>
                <a href="{{route('coaching-type',['type'=>'nearby'])}}" class="d-sm-inline-block text-xs float-right "> See All </a>
            </div>
            <div class="event-block-slider">
                @foreach ($tournament['nearby_event'] as $tour)
                    <div class="card m-card shadow-sm border-0 listcard">
                        <div>
                            <div class="m-card-cover position-relative">
                                <img src="{{env('BACKEND_BASE_URL')}}/{{$tour['event_img']}}" class="card-img-top" alt="{{$tour['event_title']}}">
                                @isset($tour['cid'])
                                    <a href="{{route('coaching',['category'=>Str::slug($tour['category'])])}}" class="my-2"><small class="category">{{$tour['category']}}</small></a>
                                @endisset
                            </div>
                            <div class="card-body  position-relative">
                                <h5 class="card-title mb-2"><u>{{$tour['event_title']}}</u></h5>
                                <small>{{$tour['event_sdate']}}</small>
                                <p class="my-2"><small class="location"><i class="fas fa-map-marker-alt pr-1"></i>{{$tour['event_place_name']}}</small></p>
                                <p class="card-text mb-0">
                                    <small class="text-dark" title="{{$tour['event_place_address']}}"><i class="fas fa-map-marker-alt pr-1"></i>
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
                                    @foreach ($tour['ticket_types'] as $key =>  $item)
                                        <span class="badge badge-primary m-1 type_cat" data-toggle="tooltip" data-placement="top" title="{{ $key }}">{{ $item }}</span>
                                    @endforeach
                                @endisset
                                <div class="mt-2"> 
                                    <button class="mt-1 btn btn-outline-white btn-sm mb-1">Package Price : {{$tour['event_ticket_price']}}</button>
                                    @if(strtotime($tour['event_sdate']) < strtotime(date('Y-m-d')))
                                        <a href="javascript:void(0);" class="mt-1 btn default2-btn btn-sm mb-1 w-100">Completed</a>
                                    @else
                                        <a href="{{route('coaching-detail', [Str::slug($tour['event_title']),$tour['event_id']])}}" class="mt-1 btn btn-success btn-sm mb-1 w-100 ">Book Coaching</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @if (isset($tournament['location_images']) && isset($tournament['location_images']['adv_image_2']))
        <div class="row my-5">
            <div class="col-lg-12">
                <a class="small_banner" target="_blank">
                    <img src="{{env('BACKEND_BASE_URL')}}/{{$tournament['location_images']['adv_image_2']}}" alt="">
                </a>
            </div>
        </div>
    @endif
    @if (isset($tournament) && count($tournament['this_month_event']))
        <div class="hawan_section">
            <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
                <h2 class="h4 mb-0 float-left">Monthly Coaching</h2>
                <a href="{{route('coaching-type',['type'=>'monthly'])}}" class="d-sm-inline-block text-xs float-right "> See All </a>
            </div>
            <div class="event-block-slider">
                @foreach ($tournament['this_month_event'] as $tour)
                    <div class="card m-card shadow-sm border-0 listcard">
                        <div>
                            <div class="m-card-cover position-relative">
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
                                    <small class="text-dark" title="{{$tour['event_place_address']}}"><i class="fas fa-map-marker-alt pr-1"></i>
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
                                    @foreach ($tour['ticket_types'] as $key =>  $item)
                                        <span class="badge badge-primary m-1 type_cat" data-toggle="tooltip" data-placement="top" title="{{ $key }}">{{ $item }}</span>
                                    @endforeach
                                @endisset
                                <div class="mt-2"> 
                                    <button class="mt-1 btn btn-outline-white btn-sm mb-1">Package Price : {{$tour['event_ticket_price']}}</button>
                                    @if(strtotime($tour['event_sdate']) < strtotime(date('Y-m-d')))
                                        <a href="javascript:void(0);" class="mt-1 btn default2-btn btn-sm mb-1 w-100">Completed</a>
                                    @else
                                        <a href="{{route('coaching-detail', [Str::slug($tour['event_title']),$tour['event_id']])}}" class="mt-1 btn btn-success btn-sm mb-1 w-100 ">Book Coaching</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @if (isset($tournament['location_images']) && isset($tournament['location_images']['adv_image_3']))
        <div class="row my-5">
            <div class="col-lg-12">
                <a class="small_banner" target="_blank">
                    <img src="{{env('BACKEND_BASE_URL')}}/{{$tournament['location_images']['adv_image_3']}}" alt="">
                </a>
            </div>
        </div>
    @endif
    @if (isset($tournament) && count($tournament['upcoming_event']))
        <div class="hawan_section">
            <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
                <h2 class="h4 mb-0 float-left">Upcoming Coaching</h2>
                <a href="{{route('coaching-type',['type'=>'upcoming'])}}" class="d-sm-inline-block text-xs float-right "> See All </a>
            </div>
            <div class="event-block-slider">
                @foreach ($tournament['upcoming_event'] as $tour)
                    <div class="card m-card shadow-sm border-0 listcard ">
                        <div>
                            <div class="m-card-cover position-relative">
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
                                    <small class="text-dark" title="{{$tour['event_place_address']}}"><i class="fas fa-map-marker-alt pr-1"></i>
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
                                        <a href="{{route('coaching-detail', [Str::slug($tour['event_title']),$tour['event_id']])}}" class="mt-1 btn btn-success btn-sm mb-1 w-100 ">Book Coaching</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif --}}
    <!-- <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-3 overflow-hidden">
        <h2 class="h4 mb-0 float-left">Categories</h2>
    </div>
    <div class="all-category mb-5">
        @foreach (Common::allEventCategoriesByApi() as $cat)
            <div class="category-card">
                <a href="{{ route('coaching', [Str::slug($cat['title'])]) }}">
                    <img src="{{env('BACKEND_BASE_URL')}}/{{$cat['cover_img']}}" class="category-img" alt="...">
                    <div class="cat-content">
                        <p class="cat-title text-truncate">{{$cat['title']}}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div> -->
    <!-- <div class="categories-section py-5">
        <div class="container">
            <div class="section-header mb-5 text-center">
                <h2 class="section-title display-5 fw-bold">Explore Our Coaching Categories</h2>
                <p class="section-subtitle text-muted">Find the perfect coaching program for your needs</p>
            </div>
            
            <div class="row g-4">
                @foreach (Common::allEventCategoriesByApi() as $cat)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="category-card card border-0 shadow-sm h-100 overflow-hidden hover-effect">
                        <a href="{{ route('coaching', [Str::slug($cat['title'])]) }}" class="text-decoration-none">
                            <div class="card-img-top position-relative overflow-hidden">
                                <img src="{{env('BACKEND_BASE_URL')}}/{{$cat['cover_img']}}" 
                                    class="img-fluid w-100 category-img" 
                                    alt="{{$cat['title']}}"
                                    style="height: 200px; object-fit: cover;">
                                <div class="img-overlay"></div>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="h5 card-title fw-bold text-white mb-0">{{$cat['title']}}</h3>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div> -->

   <div class="categories-section py-5">
        <div class="container">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h2 class="h4 mb-0">Explore Our Categories</h2>
            </div>
            <div class="row g-4">
                @foreach (Common::allEventCategoriesByApi() as $cat)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="category-card card border-0 shadow-sm h-100 overflow-hidden hover-effect">
                        <a href="{{ route('coaching', [Str::slug($cat['title'])]) }}" class="text-decoration-none d-block h-100 position-relative">
                            <div class="card-img-top position-relative overflow-hidden">
                                <img src="{{env('BACKEND_BASE_URL')}}/{{$cat['cover_img']}}" 
                                    class="img-fluid w-100 category-img" 
                                    alt="{{$cat['title']}}">
                                <div class="img-overlay"></div>
                            </div>
                            <div class="card-body text-center d-flex flex-column justify-content-end">
                                <h3 class="h5 card-title fw-bold text-white mb-2">{{$cat['title']}}</h3>
                                <span class="explore-link">Explore Category</span>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@if (isset($tournament['location_images']) && isset($tournament['location_images']['popup_image']))
    <div class="modal fade" id="Location" tabindex="-1" role="dialog" aria-labelledby="LocationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered animate-zoom-in" role="document">
            <div class="modal-content">
                <div class="modal-body p-1" id="model_body">
                    <button type="button" class="btn-close" id="cancel_edit"><i class="fas fa-times"></i></button>
                    <img class="img-fluid" src="{{env('BACKEND_BASE_URL')}}/{{$tournament['location_images']['popup_image']}}" alt="">
                </div>
            </div>
        </div>
    </div>
@endif


{{-- Model End --}}
@include('alert-messages')
@endsection
@push('scripts')
<script type="text/javascript">
    $(window).on('load', function() {
        // Delay the modal show by 3 seconds (3000 milliseconds)
        setTimeout(function() {
            $('#Location').modal('show');
        }, 3000);
    });

    // Hide the modal when the cancel button is clicked
    $("#cancel_edit").click(function() {
        $('#Location').modal('hide');
    });
</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script type="application/ld+json">
    {
      "@context": "https://schema.org/", 
      "@type": "BreadcrumbList", 
      "itemListElement": [{
        "@type": "ListItem", 
        "position": 1, 
        "name": "Home page",
        "item": "https://fitsportsy.in/"  
      },{
        "@type": "ListItem", 
        "position": 2, 
        "name": "Coaching in bangalore",
        "item": "https://fitsportsy.in/coachings-in-bengaluru"  
      },{
        "@type": "ListItem", 
        "position": 3, 
        "name": "Coaching in Ahmedabaad",
        "item": "https://fitsportsy.in/coachings-in-ahmedabad"  
      },{
        "@type": "ListItem", 
        "position": 4, 
        "name": "coaching in bealgavi",
        "item": "https://fitsportsy.in/coachings-in-belagavi"  
      },{
        "@type": "ListItem", 
        "position": 5, 
        "name": "coaching in chandigarh",
        "item": "https://fitsportsy.in/coachings-in-chandigarh"  
      },{
        "@type": "ListItem", 
        "position": 6, 
        "name": "coaching in chennai",
        "item": "https://fitsportsy.in/coachings-in-chennai"  
      },{
        "@type": "ListItem", 
        "position": 7, 
        "name": "coaching in coimbatore",
        "item": "https://fitsportsy.in/coachings-in-coimbatore"  
      },{
        "@type": "ListItem", 
        "position": 8, 
        "name": "coaching in delhi",
        "item": "https://fitsportsy.in/coachings-in-delhi"  
      },{
        "@type": "ListItem", 
        "position": 9, 
        "name": "coaching in Goa",
        "item": "https://fitsportsy.in/coachings-in-goa"  
      },{
        "@type": "ListItem", 
        "position": 10, 
        "name": "coaching in Gurugram",
        "item": "https://fitsportsy.in/coachings-in-gurugram"  
      },{
        "@type": "ListItem", 
        "position": 11, 
        "name": "coaching in Hyderabaad",
        "item": "https://fitsportsy.in/coachings-in-hyderabad"  
      },{
        "@type": "ListItem", 
        "position": 12, 
        "name": "coaching in Jaipur",
        "item": "https://fitsportsy.in/coachings-in-jaipur"  
      },{
        "@type": "ListItem", 
        "position": 13, 
        "name": "coaching in Kochi",
        "item": "https://fitsportsy.in/coachings-in-kochi"  
      },{
        "@type": "ListItem", 
        "position": 14, 
        "name": "coaching in Kolkata",
        "item": "https://fitsportsy.in/coachings-in-kolkata"  
      },{
        "@type": "ListItem", 
        "position": 15, 
        "name": "coaching in Lucknow",
        "item": "https://fitsportsy.in/coachings-in-lucknow"  
      },{
        "@type": "ListItem", 
        "position": 16, 
        "name": "coaching in Madurai",
        "item": "https://fitsportsy.in/coachings-in-madurai"  
      },{
        "@type": "ListItem", 
        "position": 17, 
        "name": "coaching in Mumbai",
        "item": "https://fitsportsy.in/coachings-in-madurai"  
      },{
        "@type": "ListItem", 
        "position": 18, 
        "name": "coaching in Mysuru",
        "item": "https://fitsportsy.in/coachings-in-mysuru"  
      },{
        "@type": "ListItem", 
        "position": 19, 
        "name": "coaching in Nagpur",
        "item": "https://fitsportsy.in/coachings-in-nagpur"  
      },{
        "@type": "ListItem", 
        "position": 20, 
        "name": "coaching in Pondicherry",
        "item": "https://fitsportsy.in/coachings-in-pondicherry"  
      },{
        "@type": "ListItem", 
        "position": 21, 
        "name": "coaching in Pune",
        "item": "https://fitsportsy.in/coachings-in-pune"  
      },{
        "@type": "ListItem", 
        "position": 22, 
        "name": "coaching in Salem",
        "item": "https://fitsportsy.in/coachings-in-salem"  
      },{
        "@type": "ListItem", 
        "position": 23, 
        "name": "coaching in thanjavur",
        "item": "https://fitsportsy.in/coachings-in-thanjavur"  
      },{
        "@type": "ListItem", 
        "position": 24, 
        "name": "coaching in tiruchirappalli",
        "item": "https://fitsportsy.in/coachings-in-tiruchirappalli"  
      },{
        "@type": "ListItem", 
        "position": 25, 
        "name": "coaching in Tiruppur",
        "item": "https://fitsportsy.in/coachings-in-tiruppur"  
      },{
        "@type": "ListItem", 
        "position": 26, 
        "name": "coaching in vellore",
        "item": "https://fitsportsy.in/coachings-in-vellore"  
      },{
        "@type": "ListItem", 
        "position": 27, 
        "name": "coaching in Vijayawada",
        "item": "https://fitsportsy.in/coachings-in-vijayawada"  
      },{
        "@type": "ListItem", 
        "position": 28, 
        "name": "coaching in visakhapatnam",
        "item": "https://fitsportsy.in/coachings-in-visakhapatnam"  
      },{
        "@type": "ListItem", 
        "position": 29, 
        "name": "Badminton",
        "item": "https://fitsportsy.in/badminton-coaching"  
      },{
        "@type": "ListItem", 
        "position": 30, 
        "name": "cricket",
        "item": "https://fitsportsy.in/cricket-coaching"  
      },{
        "@type": "ListItem", 
        "position": 31, 
        "name": "Skating",
        "item": "https://fitsportsy.in/skating-coaching"  
      },{
        "@type": "ListItem", 
        "position": 32, 
        "name": "Chess",
        "item": "https://fitsportsy.in/chess-coaching"  
      },{
        "@type": "ListItem", 
        "position": 33, 
        "name": "Football",
        "item": "https://fitsportsy.in/football-coaching"  
      },{
        "@type": "ListItem", 
        "position": 34, 
        "name": "Swimming",
        "item": "https://fitsportsy.in/swimming-coaching"  
      },{
        "@type": "ListItem", 
        "position": 35, 
        "name": "Tennis",
        "item": "https://fitsportsy.in/tennis-coaching"  
      },{
        "@type": "ListItem", 
        "position": 36, 
        "name": "Volleyball",
        "item": "https://fitsportsy.in/tennis-coaching"  
      },{
        "@type": "ListItem", 
        "position": 37, 
        "name": "Running",
        "item": "https://fitsportsy.in/running-coaching"  
      },{
        "@type": "ListItem", 
        "position": 38, 
        "name": "Pickleball",
        "item": "https://fitsportsy.in/pickleball-coaching"  
      }]
    }
    </script>
    
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SportsOrganization",
      "name": "fitsportsy",
      "url": "https://fitsportsy.in/",
      "logo": "https://app.fitsportsy.in/images/website/1734759709.png",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+919686314018",
        "contactType": "reservations",
        "contactOption": "HearingImpairedSupported",
        "areaServed": "IN",
        "availableLanguage": ["en","Hindi"]
      },
      "sameAs": [
        "https://www.facebook.com/fitsportsyOfficial",
        "https://www.instagram.com/fitsportsyofficial/",
        "https://www.linkedin.com/company/105291760/admin/dashboard/"
      ]
    }
    </script>
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "fitsportsy",
      "image": "https://app.fitsportsy.in/images/website/1734759709.png",
      "@id": "",
      "url": "https://www.fitsportsy.in/",
      "telephone": "+919686314018",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Geeks Life Technology Solutions PVT LTD, CV Raman Nagar",
        "addressLocality": "Bangalore",
        "postalCode": "560093",
        "addressCountry": "IN"
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
          "Sunday"
        ],
        "opens": "00:00",
        "closes": "23:59"
      },
      "sameAs": [
        "https://www.instagram.com/fitsportsyofficial/",
        "https://www.facebook.com/fitsportsyOfficial",
        "https://www.linkedin.com/company/105291760/admin/dashboard/"
      ] 
    }
    </script>
    
@endpush