@extends('frontend.master', ['activePage' => 'Confirm Ticket Booking'])
@section('title', __('Book Event Tickets'))
@section('content')
@php
$superShowFee = 0;
$gateWayFee = 0;
$playFormFee = 0;
$totalAmntTC = 0;
$orgComm = 0;
$rozarKey = "";
$paymentId = "";
@endphp
<style>
    @media (max-width: 576px) {
        .mbsm{
            margin-top: 15px;
        }
        .mbsm h4{
            font-size: 18px !important;
        }
    }

    .ticketHeading{
        background: #6e6e6e;
        color: #ffffff;
        padding: 6px;
    }

    .playerHead{
        color: #fff;
        background: #0a0a0a;
        display: inline-block;
        padding: 4px 10px;
        border-radius: 3px;
        font-weight: 300;
    }

    .playerForm{
        padding: 0px 10px;
    }

    .smaller-modal .swal2-confirm{
        margin: 0px;
        border: 0px;
        background: #fff !important;
        color: #002c68 !important;
    }

    .smaller-modal .swal2-show{
        background: #002c68 !important;
        color: #fff !important;
    }
    .swal2-show{
        background: #002c68 !important;
        color: #fff !important;
    }
    button:focus{
        outline:none !important;
    }
</style>
<section class="section-area checkout-event-area">
    <div class="container">
        <form action="{{route('store-payment-detail')}}" id="razorpay-form" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8 ">
                    <div class="card checkout-card shadow-sm">
                        <div class="card-body">
                            @isset($packageDetails)
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="event-img">
                                            <img src="{{env('BACKEND_BASE_URL')}}/{{$packageDetails['event_img']}}" class="card-img-top" alt="{{$packageDetails['event_title']}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 mbsm">
                                        <h4 class="mb-3" style="font-size: 20px">{{$packageDetails['event_title']}}</h4>
                                        <p class="mb-0">{{$packageDetails['event_sdate']}}</p>
                                        <p class="mb-0">{{$packageDetails['event_address_title']}}</p>
                                    </div>
                                </div>
                                <div class="formBox mt-4">
                                    @php  $userData = Common::fetchUserDetails(); @endphp
                                    @if (empty($userData['name']) || empty($userData['email']))
                                        <div class="row px-2">
                                            <div class="mb-3 col-lg-6">
                                                <label for="username">Username <span class="text-danger">*</span></label>
                                                <input id="username" type="text" class="form-control" placeholder="Username" name="username" required>
                                            </div>
                                            <div class="mb-3 col-lg-6">
                                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                                <input id="email" type="email" class="form-control" placeholder="Enter Email" name="email" required>
                                            </div>
                                            <div class="mb-3 col-lg-6">
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $fields = $packageDetails['fields'] ?? [];
                                        $isDouble = strpos(strtolower($packageDetails['type']), 'double') !== false || strpos(strtolower($packageDetails['type']), 'doubles') !== false;
                                        $groupSize = $isDouble ? 2 : 1; // 2 players per group if double, else 1
                                        $totalGroups = ($bookingData['quantity'] ?? 1); // Number of ticket quantities
                                        $totalPlayers = $groupSize * $totalGroups; // Total number of players to render
                                    @endphp
                        
                                    @for($group = 1; $group <= $totalGroups; $group++)
                                        <div class="playerGroup">
                                            @if ($totalGroups > 1)
                                                <h4 class="mb-3 text-center ticketHeading">Ticket {{ $group }}</h4>
                                            @endif
                        
                                            @for($player = 1; $player <= $groupSize; $player++)
                                                <div class="playerForm">
                                                    @if ($groupSize > 1)
                                                    <h6 class="playerHead">Player {{ ($group - 1) * $groupSize + $player }}</h6>
                                                    @endif
                                                    <!-- Fixed fields: Name and Phone Number -->
                                                    <div class="row">
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="player_name_{{ $group }}_{{ $player }}" class="form-label">Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="player_name_{{ $group }}_{{ $player }}" id="player_name_{{ $group }}_{{ $player }}" placeholder="Player Name/Team name" required>
                                                    </div>
                        
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="player_contact_{{ $group }}_{{ $player }}" class="form-label">Contact Number</label>
                                                        <input type="text" class="form-control" name="player_contact_{{ $group }}_{{ $player }}" id="player_contact_{{ $group }}_{{ $player }}" placeholder="Player Contact Number">
                                                    </div>
                        
                                                    <!-- Optional fields based on the "fields" array -->
                                                    @foreach($fields as $field)
                                                        @switch($field)
                                                            @case('gender')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="gender_{{ $group }}_{{ $player }}" class="form-label">Gender</label>
                                                                    <select class="form-select form-control" name="player_gender_{{ $group }}_{{ $player }}" id="gender_{{ $group }}_{{ $player }}">
                                                                        <option value="">Choose Anyone</option>
                                                                        <option value="male">Male</option>
                                                                        <option value="female">Female</option>
                                                                        <option value="other">Other</option>
                                                                    </select>
                                                                </div>
                                                                @break
                        
                                                            @case('club_name')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="club_name_{{ $group }}_{{ $player }}" class="form-label">Club Name</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Club Name" name="player_club_name_{{ $group }}_{{ $player }}" id="club_name_{{ $group }}_{{ $player }}">
                                                                </div>
                                                                @break
                        
                                                            @case('academy_name')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="academy_name_{{ $group }}_{{ $player }}" class="form-label">Academy Name</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Academy Name" name="player_academy_name_{{ $group }}_{{ $player }}" id="academy_name_{{ $group }}_{{ $player }}">
                                                                </div>
                                                                @break
                        
                                                            @case('age')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="age_{{ $group }}_{{ $player }}" class="form-label">Age</label>
                                                                    <input type="number" placeholder="Enter Age"  class="form-control" name="player_age_{{ $group }}_{{ $player }}" id="age_{{ $group }}_{{ $player }}">
                                                                </div>
                                                                @break
                        
                                                            @case('shirt_size')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="shirt_size_{{ $group }}_{{ $player }}" class="form-label">T-Shirt Size</label>
                                                                    <select class="form-select form-control" name="player_shirt_size_{{ $group }}_{{ $player }}" id="shirt_size_{{ $group }}_{{ $player }}">
                                                                        <option value="">Choose Anyone</option>
                                                                        <option value="S">Small</option>
                                                                        <option value="M">Medium</option>
                                                                        <option value="L">Large</option>
                                                                        <option value="XL">Extra Large</option>
                                                                    </select>
                                                                </div>
                                                                @break
                        
                                                            @case('emergency_contact')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="emergency_contact_{{ $group }}_{{ $player }}" class="form-label">Emergency Contact No.</label>
                                                                    <input type="number" placeholder="Enter Emergency Contact No." class="form-control" name="player_emergency_contact_{{ $group }}_{{ $player }}" id="emergency_contact_{{ $group }}_{{ $player }}">
                                                                </div>
                                                                @break
                        
                                                            @case('study_class')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="study_class_{{ $group }}_{{ $player }}" class="form-label">Study Class</label>
                                                                    <input type="text" placeholder="Enter Study Class" class="form-control" name="player_study_class_{{ $group }}_{{ $player }}" id="study_class_{{ $group }}_{{ $player }}">
                                                                </div>
                                                                @break
                        
                                                            @case('section')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="section_{{ $group }}_{{ $player }}" class="form-label">Section</label>
                                                                    <input type="text" placeholder="Enter Section"  class="form-control" name="player_section_{{ $group }}_{{ $player }}" id="section_{{ $group }}_{{ $player }}">
                                                                </div>
                                                                @break
                        
                                                            @case('school_name')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="school_name_{{ $group }}_{{ $player }}" class="form-label">School Name</label>
                                                                    <input type="text"  placeholder="Enter School Name"  class="form-control" name="player_school_name_{{ $group }}_{{ $player }}" id="school_name_{{ $group }}_{{ $player }}">
                                                                </div>
                                                                @break
                        
                                                            @case('college_name')
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="college_name_{{ $group }}_{{ $player }}" class="form-label">College Name</label>
                                                                    <input type="text" placeholder="Enter College Name" class="form-control" name="player_college_name_{{ $group }}_{{ $player }}" id="college_name_{{ $group }}_{{ $player }}">
                                                                </div>
                                                                @break
                                                        @endswitch
                                                    @endforeach
                                                </div>
                                                </div>
                                            @endfor
                                        </div>
                                    @endfor
                                </div>                                                            
                            @endisset
                            @isset($payData)
                                {{-- <form> --}}
                                    @foreach ($payData as $item)
                                        @if($item['title'] === 'Razorpay') 
                                            @php 
                                                $rozarKey = $item['attributes']; 
                                                $paymentId = $item['id'];
                                            @endphp
                                        @endif
                                    @endforeach
                                {{-- </form> --}}
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mbsm mb-4">
                    <div class="card checkout-card shadow-sm">
                        <div class="card-body">
                            <h4 class=" mb-3">
                                <span class="text-white">Order Summary</span>
                            </h4>
                            <p class="text-danger m-0" id="coupon_err"></p>
                            @if (isset($couponList) && count($couponList) > 0)
                                <div class="input-group mb-3">
                                    {{-- <input type="text" class="form-control" id="promo_text" placeholder="Coupon code"> --}}
                                    <select name="promo_text" class="form-control" id="promo_text">
                                        <option value="">Select Coupon Code</option>
                                        @foreach ($couponList as $item)
                                            <option value="{{$item['coupon_code']}}">{{$item['coupon_code']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" id="apply_btn" class="btn btn-dark">Apply</button>
                                    </div>
                                </div>
                            @endif
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Total Quantity</p>
                                    </div>
                                    <span class="text-white">{{$bookingData['quantity']}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Price</p>
                                    </div>
                                    <span class="text-white">{{$settingDetails['currency']}}{{$packageDetails['ticket']}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p class="my-0">Fee</p>
                                    </div>
                                    <span class="text-white">{{$settingDetails['currency']}}{{$settingDetails['tax']}}</span>
                                </li>
                                <li class="list-group-item d-none justify-content-between lh-condensed" id="couponBox">
                                    <div class="text-white">
                                        <p class="my-0">Coupon</p>
                                    </div>
                                    <span class="text-white" id="coupon_disc">-{{$settingDetails['currency']}}0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Total Payment</strong>
                                    <strong id="total_amount">{{$settingDetails['currency']}}{{$packageDetails['ticket']*$bookingData['quantity']}}</strong>
                                </li>
                            </ul>
                            <p>Present the QR code on your mobile ticket at the coaching entrance for seamless entry. By proceeding, I confirm my consent to complete this transaction.</p>
                            @if (Common::isUserLogin())
                                <button type="button" class="btn default-btn btn-block" id="payBookAmount">Continue To
                                    Checkout</button>
                            @else
                                @php
                                    session(['redirect_url' => url()->current()]);
                                @endphp
                                <a href="{{ route('userLogin') }}" class="btn default-btn btn-block">Login To Continue</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @php
                $EventName = $packageDetails['event_title'] ?? 'Event';
                $EventId = $packageDetails['event_id'];
                $totalTax = $settingDetails['tax'] ?? 0; // Tax (dynamic from settings)
                $ticketAmount = $packageDetails['ticket'] * $bookingData['quantity']; // Ticket cost
                $charges = $settingDetails['platform_fee'] ?? 0; // Platform fee (dynamic from settings)
                $totalAmountPayable = $ticketAmount + $charges + $totalTax; // Total amount payable
                $feeToken = Common::randomMerchantId(1); // Random fee token
                $productInfo = 'Book Event - ' . $EventName;
                $txnid = time() . rand(1, 99999); // Unique transaction ID
                $surl = url('razor-event-book-payment-success'); // Success URL
                $furl = url('razor-event-book-payment-failed'); // Failure URL
                $key_id = $rozarKey; // Razorpay key from settings
                $pay_id = $paymentId;
                $ticket_id = $packageDetails['ticket_id'];
                $type = $packageDetails['type'];
                $currency = 'INR'; // Currency code
                $ticket_price = $packageDetails['ticket'];
                $total_ticket = $bookingData['quantity'];
                $user_limit = $packageDetails['tlimit'];
                $sponser_id = $packageDetails['sponser_id'];
            @endphp
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
            <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="{{ $feeToken }}" />
            <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="{{ $txnid }}" />
            <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="{{ $surl }}" />
            <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="{{ $furl }}" />
            <input type="hidden" name="merchant_total" id="merchant_total" value="{{ round($totalAmountPayable * 100) }}" />
            <input type="hidden" name="currency_code" id="currency_code" value="{{ $currency }}" />
            <input type="hidden" name="merchant_product_info" id="merchant_product_info" value="{{ $productInfo }}" />
            <input type="hidden" name="total_amount_pay" id="total_amount_pay" value="{{ round($totalAmountPayable, 2) }}" />
            <input type="hidden" name="sponser_id" id="sponser_id" value="{{$sponser_id}}" />
            <input type="hidden" name="limit_user" id="limit_user" value="{{$user_limit}}" />
            <input type="hidden" name="coupon_amt" id="coupon_amt" value="0" />
            <input type="hidden" name="tax" id="tax" value="{{ $totalTax }}" />
            <input type="hidden" name="type" id="type" value="{{ $type }}" />
            <input type="hidden" name="ticket_id" id="ticket_id" value="{{ $ticket_id }}" />
            <input type="hidden" name="event_id" id="event_id" value="{{ $EventId }}" />
            <input type="hidden" name="payment_id" id="payment_id" value="{{ $paymentId }}" />
            <input type="hidden" name="ticket_price" id="ticket_price" value="{{ $ticket_price }}" />
            <input type="hidden" name="total_ticket" id="total_ticket" value="{{ $total_ticket }}" />
        </form>
    </div>
</section>
@endsection
@push('scripts')
@include('alert-messages')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script>
    // function validateDynamicForm() {
    //     let isValid = true;

    //     // Iterate through all required fields
    //     $('#razorpay-form input[required], #razorpay-form select[required]').each(function () {
    //         const $field = $(this);
    //         if (!$field.val()) {
    //             // Highlight invalid fields
    //             $field.addClass('is-invalid');
    //             isValid = false;
    //         } else {
    //             $field.removeClass('is-invalid');
    //         }
    //     });

    //     let emailField = $('#email');
    //     if (emailField.length > 0) {  // Check if the element exists
    //         let emailExist = emailField.val().trim();
            
    //         if (emailExist !== '') {
    //             $.ajax({
    //                 url: "{{route('verifyEmail')}}",
    //                 type: "POST",
    //                 contentType: "application/json",
    //                 data: JSON.stringify({ email: emailExist }),
    //                 success: function (data) {
    //                     if (data.Result === "false") {
    //                         iziToast.error({
    //                             title: 'Error',
    //                             position: 'topRight',
    //                             message: data.ResponseMsg || 'Email already exists. Please use another email.',
    //                         });
    //                         emailField.addClass('is-invalid');
    //                         isValid = false;
    //                     } else {
    //                         emailField.removeClass('is-invalid');
    //                     }
    //                 },
    //                 error: function () {
    //                     iziToast.error({
    //                         title: 'Error',
    //                         position: 'topRight',
    //                         message: 'Failed to verify email. Please try again later.',
    //                     });
    //                     isValid = false;
    //                 }
    //             });
    //         }
    //     }

    //     // Display a message if the form is invalid
    //     if (!isValid) {
    //         iziToast.error({
    //             title: 'Error',
    //             position: 'topRight',
    //             message: 'Please fill all required fields before proceeding.',
    //         });
    //     }

    //     return isValid;
    // }

    function validateDynamicForm() {
        return new Promise((resolve, reject) => {
            let isValid = true;

            // Iterate through all required fields
            $('#razorpay-form input[required], #razorpay-form select[required]').each(function () {
                const $field = $(this);
                if (!$field.val()) {
                    $field.addClass('is-invalid');
                    isValid = false;
                } else {
                    $field.removeClass('is-invalid');
                }
            });

            let emailField = $('#email');
            if (emailField.length > 0) {  // Check if the element exists
                let emailExist = emailField.val().trim();
                
                if (emailExist !== '') {
                    $.ajax({
                        url: "{{route('verifyEmail')}}",
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({ email: emailExist }),
                        success: function (data) {
                            if (data.Result === "false") {
                                iziToast.error({
                                    title: 'Error',
                                    position: 'topRight',
                                    message: data.ResponseMsg || 'Email already exists. Please use another email.',
                                });
                                emailField.addClass('is-invalid');
                                resolve(false); // Resolve with false if email exists
                            } else {
                                emailField.removeClass('is-invalid');
                                resolve(isValid); // Resolve with true if all fields are valid
                            }
                        },
                        error: function () {
                            iziToast.error({
                                title: 'Error',
                                position: 'topRight',
                                message: 'Failed to verify email. Please try again later.',
                            });
                            resolve(false);
                        }
                    });
                } else {
                    resolve(isValid); // No email field, continue validation
                }
            } else {
                resolve(isValid);
            }
        });
    }

</script>
<script>
    // function razorpaySubmit(amount) {
    //     if (!validateDynamicForm()) {
    //         return; // Stop if the form is invalid
    //     }
    //     $.post('{{route("create-order")}}', { amount: amount }, function(response) {
    //         if (response.success) {
    //             let orderID = response.order_id;
    //             var razorpayOptions = {
    //                 key: "{{ $key_id }}", // Razorpay key from settings
    //                 amount: amount * 100, // Amount in paise
    //                 currency: "{{ $currency }}",
    //                 name: "PlayOffz",
    //                 description: "Order Payment",
    //                 order_id: orderID, // Razorpay Order ID
    //                 prefill: {
    //                     name: $('#card_holder_name').val(),
    //                     email: $('#email').val(),
    //                     contact: $('#number').val()
    //                 },
    //                 handler: function(paymentResponse) {
    //                     // Set the payment ID and submit the form
    //                     $('#razorpay_payment_id').val(paymentResponse.razorpay_payment_id);
    //                     $('#razorpay-form').submit();
    //                 },
    //                 modal: {
    //                     ondismiss: function() {
    //                         // alert("Payment canceled by user.");
    //                         window.location.reload();
    //                     }
    //                 }
    //             };

    //             var razorpayInstance = new Razorpay(razorpayOptions);
    //             razorpayInstance.open();
    //         } else {
    //             // alert("Error creating Razorpay order: " + response.message);
    //             iziToast.error({
    //                 title: 'Error',
    //                 position: 'topRight',
    //                 message: "Error creating Razorpay order: " + response.message,
    //             });
    //         }
    //     }).fail(function() {
    //         // alert("Failed to create Razorpay order. Please try again.");
    //         iziToast.error({
    //             title: 'Error',
    //             position: 'topRight',
    //             message: "Failed to create Razorpay order. Please try again.",
    //         });
    //     });
    // }

    function razorpaySubmit(amount) {
        validateDynamicForm().then(isValid => {
            if (!isValid) {
                return; // Stop if the form is invalid
            }

            $.post('{{route("create-order")}}', { amount: amount }, function(response) {
                if (response.success) {
                    let orderID = response.order_id;
                    var razorpayOptions = {
                        key: "{{ $key_id }}",
                        amount: amount * 100,
                        currency: "{{ $currency }}",
                        name: "PlayOffz",
                        description: "Order Payment",
                        order_id: orderID,
                        prefill: {
                            name: $('#card_holder_name').val(),
                            email: $('#email').val(),
                            contact: $('#number').val()
                        },
                        handler: function(paymentResponse) {
                            $('#razorpay_payment_id').val(paymentResponse.razorpay_payment_id);
                            $('#razorpay-form').submit();
                        },
                        modal: {
                            ondismiss: function() {
                                window.location.reload();
                            }
                        }
                    };

                    var razorpayInstance = new Razorpay(razorpayOptions);
                    razorpayInstance.open();
                } else {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: "Error creating Razorpay order: " + response.message,
                    });
                }
            }).fail(function() {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: "Failed to create Razorpay order. Please try again.",
                });
            });
        });
    }

    // Trigger Razorpay payment on button click
    // $("#payBookAmount").on('click', function() {
    //     let totalAmount = {{ round($totalAmountPayable, 2) }};
    //     let couponAmount = $('#coupon_amt').val();
    //     if(totalAmount > 0){
    //         razorpaySubmit(totalAmount-couponAmount)
    //     }
    //     if (!validateDynamicForm()) {
    //         return; 
    //     }else{
    //         $('#razorpay-form').submit();
    //     }
    // });

    $("#payBookAmount").on('click', function() {
        let totalAmount = {{ round($totalAmountPayable, 2) }};
        let couponAmount = $('#coupon_amt').val();

        validateDynamicForm().then(isValid => {
            if (!isValid) {
                return; // Stop if form validation fails
            }

            if (totalAmount > 0) {
                razorpaySubmit(totalAmount - couponAmount);
            } else {
                $('#razorpay-form').submit();
            }
        });
    });

</script>
<script>
    $("#apply_btn").on('click', function() {
        var txt = $("#promo_text").val(); // Get the entered/selected coupon code
        if (txt != '') {
            $("#apply_btn").text('Processing...').attr('disabled', 'disabled');
            // Make AJAX GET request to validate and apply the coupon
            $.get('{{url("get-promo-discount")}}?code=' + txt + '&amount={{$ticketAmount+$charges}}' + '&sid={{$packageDetails["sponser_id"]}}', function(data) {
                if (data.s == 1) {
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight',
                        message: 'Coupon applied successfully!!',
                    });
                    // Update UI for successful coupon application
                    $("#coupon_err").text(""); // Clear error messages
                    $('#couponBox').removeClass('d-none');
                    $('#couponBox').addClass('d-flex');
                    $('#coupon_amt').val(data.coupon);
                    $("#coupon_disc").text('-₹' + data.coupon); // Show discount
                    $("#total_amount").text('₹' + data.famount); // Update total amount
                    $("#coupon_id").val(data.id); // Save coupon ID in a hidden field
                    $("#coupon_discount").val(data.amount); // Save discount amount in a hidden field
                    $("#pretotalAmount").val(data.famount); // Save the final amount
                    $("#merchant_total").val(Math.round(data.famount * 100)); // Razorpay requires amount in paise
                } else {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: data.message || 'Invalid coupon code or coupon is expired',
                    });
                    // Handle invalid or expired coupon
                    $("#coupon_err").text(data.message || 'Invalid coupon code or coupon is expired');
                }
                // Reset Apply button
                $("#apply_btn").text('Apply').removeAttr('disabled');
            });
        }
    });
</script>
@if (!Common::isUserLogin())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
                const formElements = document.querySelectorAll('#razorpay-form input, #razorpay-form select, #razorpay-form textarea');
                let isAlertShown = false; // Prevent duplicate alerts
                let isRedirecting = false; // Prevent multiple redirects

                formElements.forEach(element => {
                    element.addEventListener('focus', (event) => {
                        if (!isAlertShown && !isRedirecting) {
                            isAlertShown = true; // Set the flag to true to show alert only once
                            Swal.fire({
                                title: 'Login Required',
                                text: 'Please log in to continue.',
                                confirmButtonText: 'Login To Continue',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                customClass: {
                                    popup: 'smaller-modal', // Add a custom class if further styling is needed
                                },
                            }).then((result) => {
                                isAlertShown = false; // Reset flag only if no redirection happens
                                if (result.isConfirmed && !isRedirecting) {
                                    isRedirecting = true; // Prevent multiple redirects
                                    window.location.href = "{{ route('userLogin') }}"; // Redirect to login page
                                }
                            });
                        }
                        event.target.blur(); // Immediately remove focus to prevent input
                    });
                });
        });
    </script>
@endif
@endpush