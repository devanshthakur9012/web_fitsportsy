<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $favicon = Common::siteGeneralSettingsApi();
        $catData = Common::allEventCategoriesByApi();
        $locationData = Common::fetchLocation();
    @endphp
    <meta charset="utf-8">

    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <link rel="manifest" href="{{ asset('/organizer_manifest.json') }}">
    <link
        href="{{ $favicon['favicon'] ? env('BACKEND_BASE_URL') . "/" . $favicon['favicon'] : "https://app.playoffz.in/images/favicon.png" }}"
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
    </style>
</head>

<body>
    <div class="sigma_preloader">
        @if (isset($favicon['loader']))
            @php $url = env('BACKEND_BASE_URL') . "/" . $favicon['loader'];  @endphp
        @else
            @php $url = asset('images/FitSportsy_logo_No_BG.png');  @endphp
        @endif
        <img src="{{$url}}" alt="preloader">
    </div>
    <header class="site-header sticky-top">
        <nav class="navbar navbar-expand navbar-dark topbar static-top shadow-sm bg-dark osahan-nav-top">
            <div class="container">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <a class="navbar-brand" href="/"><img
                            src="{{ $favicon['favicon'] ? env('BACKEND_BASE_URL') . "/" . $favicon['logo'] : "https://app.playoffz.in/images/website/1733339125.png" }}"
                            class="img-fluid" alt="Playoffz"></a>
                    <div class="d-none d-sm-inline-block form-inline mr-auto my-2 my-md-0 mw-100 ml-3 navbar-search">
                        <div class="input-group searchinput">
                            <input type="text" class="form-control border-0 small head-search-box"
                                placeholder="Search for coaching..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="list-group list-group-flush searchlist scrollbar search-result">
                            </div>
                            <div class="input-group-append">
                                <button class="btn bg-light" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow-sm animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <div class="form-inline mx-auto w-100 navbar-search">
                                    <div class="input-group searchinput">
                                        <input type="text"
                                            class="form-control bg-light text-dark border-0 small head-search-box"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="list-group list-group-flush searchlist scrollbar search-result">

                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item no-arrow mx-1 desk-seva-ticket">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="modal"
                                data-target="#locationModal">
                                <i class="fas fa-map-marker-alt"></i>
                                <span
                                    class="pl-2">{{Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'Popular Locations'}}</span>
                            </a>
                        </li>
                        {{-- <li>
                            <button class="mx-3 btn default-btn py-2" data-toggle="modal" data-target="#socialPlay">Play</button>
                        </li> --}}
                        <li>
                            <a href="{{env('BACKEND_BASE_URL')}}/add_event.php" class="mx-3 loginbtn "><img src="{{asset('/images/org_btn.png')}}" alt="Organizer" style="height:55px"></a>
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
                                            <img class="img-profile rounded-circle"
                                                src="{{env('BACKEND_BASE_URL')."/".$userData['pro_pic']}}" alt="{{$userData['name']}}">
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
                                        <a class="dropdown-item" href="{{route('my-social-play')}}">
                                            <i class="fas fa-play-circle fa-sm fa-fw mr-2 text-gray-600"></i>
                                            My Social Play
                                        </a>
                                        <a class="dropdown-item" href="{{route('my-activity')}}">
                                            <i class="fas fa-at fa-sm fa-fw mr-2 text-gray-600"></i>
                                            My Activity
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
                            <li class="nav-item no-arrow align-self-center mx-2 position-relative">
                                <a class="position-relative dropdown-toggle text-light" href="#" role="button"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle fa-lg"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ url('user-login') }}"><i
                                            class="fas fa-sign-in-alt"></i> Login</a>
                                    <a class="dropdown-item" href="{{ url('user-register') }}"><i
                                            class="fas fa-user-plus"></i> Register</a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark osahan-nav-mid">
            <div class="container-fluid position-relative">
                <a class="mobile-seva-ticket text-white" href="javascript:void(0);" data-toggle="modal"
                    data-target="#locationModal">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'Location'}}</span>
                </a>
                <button class="navbar-toggler navbar-toggler-right btn btn-danger btn-sm " type="button"
                    data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> Menu
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav w-100 justify-content-center">
                        @foreach ($catData as $cat)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('coaching', [Str::slug($cat['slug'])]) }}">
                                    <span class="menu_item"><img src="{{env('BACKEND_BASE_URL')}}/{{$cat['cat_img']}}"
                                            class="mr-1" width="20px" alt="{{$cat['title']}}">{{$cat['title']}}</span></a>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link shopBar" style="color:#6e6e6e !important;padding:10px !important;" href="https://shop.playoffz.in">Shop</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
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
                        <p>PlayOffz is the ultimate platform for sports enthusiasts, connecting players to exciting
                            coaching nearby. Easily book packages online and stay updated with match schedules,
                            fixtures, live scoring, and results. For organizers, PlayOffz offers seamless tools to
                            manage and promote coaching effortlessly. Join us to elevate your sports experience!</p>
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

    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="locationModalLabel"><i class="fas fa-map-marker-alt"></i>
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

    {{-- Social Play --}}
    <div class="modal fade" id="socialPlay" tabindex="-1" role="dialog" aria-labelledby="socialPlayLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="socialPlayLabel">Social Play</h5>
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
                                    <label for="cat_id" class="form-label">Sport Type <span class="text-danger">*</span></label>
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
                                    <label for="title" class="form-label">Play Title <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Eg: Looking for players to join for a thrilling game of badminton!" class="form-control" id="title" name="title" maxlength="225" required>
                                </div>
                    
                                <div class="mb-3 col-lg-6">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                    
                                <div class="mb-3 col-lg-6">
                                    <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                </div>
                    
                                <div class="mb-3 col-lg-6">
                                    <label for="venue" class="form-label">Venue <span class="text-danger">*</span></label>
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
                    
                                <div class="mb-3 col-lg-6" id="price-container">
                                    <label for="price" class="form-label">Price Per Slot <span class="text-danger">*</span></label>
                                    <input type="number" placeholder="Enter Price Per Slot" step="0.01" class="form-control" id="price" name="price" required>
                                </div>
                    
                                <div class="mb-3 col-lg-6">
                                    <label for="upi_id" class="form-label">UPI ID/ Mobile No.</label>
                                    <input type="text" placeholder="Eg: shiva@okaxis/9686889977" class="form-control" id="upi_id" name="upi_id" maxlength="225">
                                </div>
                    
                                <div class="mb-3 col-lg-6">
                                    <label for="type" class="form-label">Play Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="public" selected>Public</option>
                                        <option value="group">Group</option>
                                    </select>
                                </div>
                    
                                <div class="mb-3 col-lg-12">
                                    <label for="skill_level" class="form-label">Skill Level <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="skill_level" name="skill_level[]" multiple required>
                                        <option value="">Select Level</option>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Experienced">Experienced</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Master">Master</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-12">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control" placeholder="Enter Note" id="note" name="note" maxlength="500" style="height: 115px;">1.Mavis 350 or RSL Supreme Shuttlecocks will be used for all matches.                                                      2.Participants are requested to adhere to the venue's rules and regulations.                                                      3.Kindly specify the game format while creating Social Play.                                                                      4.Payments can be made conveniently via UPI.</textarea>
                                </div>
                                <div class="mb-3 col-lg-12">
                                    <label for="pay_join" class="form-label">Pay Join <span class="text-danger">*</span></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="pay_join" role="switch" id="pay_join" checked>
                                        <label class="form-check-label" for="pay_join">Yes</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    @if (Common::isUserLogin())
                                        <button type="submit" class="text-center btn default-btn w-100">Submit</button>
                                    @else
                                        <a href="{{route('userLogin')}}" type="button" class="text-center btn default-btn w-100">Login to continue.</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('f-vendor/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('f-vendor/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('f-vendor/slick/slick.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>    
    <script>
        $(document).ready(function () {
            $('#skill_level').select2({
                placeholder: "Select Skill Levels",
                allowClear: true
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
                    start_date: { required: true, date: true,greaterThanToday: true },
                    start_time: { required: true,greaterThanNow: true },
                    "skill_level[]": { required: true },
                    venue: { required: true, maxlength: 225 },
                    location: { required: true, maxlength: 225 },
                    slots: { required: true, number: true, min: 1 },
                    price: { required: true, number: true, min: 0 },
                    type: { required: true }
                },
                messages: {
                    cat_id: { required: "Please select a play type." },
                    title: { required: "Please enter a title.", maxlength: "Title cannot exceed 225 characters." },
                    start_date: { required: "Please select a start date.",
                    greaterThanToday: "Start date must be in the future." },
                    start_time: { required: "Please select a start time.",
                    greaterThanNow: "Start time must be in the future." },
                    "skill_level[]": { required: "Please select at least one skill level." },
                    venue: { required: "Please enter a venue.", maxlength: "Venue cannot exceed 225 characters." },
                    location: { required: "Please select a location.", maxlength: "Venue cannot exceed 225 characters." },
                    slots: { required: "Please enter the number of slots.", number: "Please enter a valid number.", min: "Slots must be at least 1." },
                    price: { required: "Please enter a price per slot.", number: "Please enter a valid price.", min: "Price must be at least 0." },
                    type: { required: "Please select a play type." }
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
                const inputDate = new Date(value);
                return this.optional(element) || inputDate > today;
            });

            // Custom method for validating time is in the future
            $.validator.addMethod("greaterThanNow", function (value, element) {
                const today = new Date();
                const inputDate = new Date($("#start_date").val());
                const inputTime = value.split(":");
                inputDate.setHours(inputTime[0], inputTime[1], 0, 0);
                return this.optional(element) || inputDate > today;
            });
    
            // Optional: Dynamically hide/show fields if needed
            $("#pay_join").change(function () {
                if ($(this).is(":checked")) {
                    $("#price-container").show();
                } else {
                    $("#price-container").hide();
                    $("#price").val("");
                }
            }).trigger("change");
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

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function () {
                navigator.serviceWorker
                    .register("/sw.js")
                    .then(res => console.log("service worker registered"))
                    .catch(err => console.log("service worker not registered", err))
            })
        }
    </script>
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