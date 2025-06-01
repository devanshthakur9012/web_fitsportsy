@extends('frontend.master', ['activePage' => 'Confirm Ticket Booking'])
@section('title', __('Book Event Tickets'))
@section('content')
@php
$superShowFee = 0;
$gateWayFee = 0;
$playFormFee = 0;
$totalAmntTC = 0;
$orgComm = 0;
@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* General Styles */
    @media (max-width: 576px) {
        .mbsm {
            margin-top: 15px;
        }
        .mbsm h4 {
            font-size: 18px !important;
        }
    }

    .ticketHeading {
        background: #6e6e6e;
        color: #ffffff;
        padding: 6px;
    }

    .playerHead {
        color: #fff;
        background: #0a0a0a;
        display: inline-block;
        padding: 4px 10px;
        border-radius: 3px;
        font-weight: 300;
    }

    .playerForm {
        padding: 0px 10px;
    }

    .payment-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 30px;
    }
    
    .payment-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .payment-header img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }
    
    .payment-header-text h4 {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .payment-header-text p {
        margin-bottom: 0;
        color: #6c757d;
    }
    
    .payment-method-container {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .payment-details {
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .qr-code-container {
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .qr-code-container img {
        max-width: 100%;
        height: auto;
        max-height: 200px;
    }
    
    .upi-details {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    
    .upi-details p {
        margin-bottom: 5px;
    }
    
    .upi-details strong {
        font-weight: 600;
    }
    
    .terms-conditions {
        background: #fff8e1;
        border-left: 4px solid #ffc107;
        padding: 15px;
        margin-top: 20px;
        font-size: 14px;
    }
    
    .terms-conditions h5 {
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }
    
    .terms-conditions ul {
        padding-left: 20px;
        margin-bottom: 0;
        color:#000;
    }
    
    .terms-conditions li {
        margin-bottom: 5px;
    }
    
    .transaction-id-input {
        margin-top: 20px;
    }
    
    .transaction-id-input label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }
    
    .amount-to-pay {
        background: #002c68;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 15px;
    }

    .qr-code-container, .upi-details {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .qr-code-container img {
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
        background-color: white;
    }

    .qr-code-container p, .upi-details p {
        margin-bottom: 10px;
    }

    .upi-details strong {
        color: #333;
    }

    @media (max-width: 767px) {
        .qr-code-container, .upi-details {
            margin-bottom: 20px;
        }
    }

    /* Modal specific styles */
    #qrPaymentModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    #qrPaymentModal .modal-header {
        background-color: #3f3f3f !important;
        color: white;
        border-bottom: none;
    }

    #qrPaymentModal .modal-body {
        padding: 2rem;
    }

    #qrPaymentModal .amount-display {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    #qrPaymentModal .qr-code-container {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1rem 0;
    }

    #qrPaymentModal .btn-close {
        filter: invert(1);
    }

    .small_card {
        background: #212121;
        padding: 10px 15px;
        border-radius: 10px;
        border: 3px solid #f7bd0f;
    }

    .textBox-postion {
        position: absolute;
        top: -12px;
        left: 0;
        width: 100%;
    }

    .modal-cstm{
        max-width: 1000px !important;
    }
    
    .textBox-postion small {
        background: #f7bd0f;
        padding: 6px 15px;
        font-weight: 900;
        color: #000;
        border-radius: 10px;
        font-size: 15px !important;
    }
    
    .payment_details_div {
        background-color:#000;
    }
    
    .qr_container_div {
        background-image: url(images/2.png);
        background-position: bottom right;
        background-repeat: no-repeat;
    }
    
    .qr_container_div .main_qr {
        border: 3px solid #f7bd0f;
    }
    
    .trans_box {
        background: #090909;
        padding: 9px;
        border-radius: 10px;
    }
    
    .trans_input {
        width: 40px;
        height: 40px;
        text-align: center;
        font-size: 18px;
        margin: 0 5px;
    }
    
    .modal-footer-btn {
        font-weight: 700;
        font-size: 20px;
        font-family: sans-serif;
        border-radius: 0;
    }

    /* Container for the blurred background effect */
    #blurImg {
        position: relative;
        width: 100%;
        height: 300px; /* Adjust height as needed */
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    /* Blurred background pseudo-element */
    #blurImg::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("{{ env('BACKEND_BASE_URL') }}/{{ $packageDetails['event_img'] }}");
        background-size: cover;
        background-position: center;
        filter: blur(10px);
        z-index: 1;
        opacity: 0.8; /* Slightly transparent for better contrast */
    }

    /* Actual image on top of blurred background */
    #blurImg img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 90%;
        max-height: 90%;
        z-index: 2;
        border-radius: 4px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #blurImg {
            height: 250px;
        }
    }

    @media (max-width: 576px) {
        #blurImg {
            height: 200px;
        }
        
        #blurImg img {
            max-width: 95%;
            max-height: 95%;
        }
    }

    /* SweetAlert customization */
    .swal2-popup {
        font-size: 1.3rem !important;
    }

    .swal2-modal .swal2-title{
        padding:0px !important;
    }
    .swal2-modal .swal2-html-container{
        padding:5px 0px !important;
        font-size:20px;
    }
    .swal2-actions{
        margin:0px !important;
    }
    .small-text{
        font-size:18px !important;
    }
    .swal2-confirm{
        padding: 10px 15px;
        font-size: 17px;
        background: #000;
    }
</style>
<section class="section-area checkout-event-area">
    <div class="container">
        <form action="{{route('store-payment-detail')}}" id="payment-form" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card checkout-card shadow-sm">
                        <div class="card-body">
                            @isset($packageDetails)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="payment-details">
                                            <div class="formBox">
                                               <div class="row px-2 mb-2">
                                                    <div class="col-lg-12">
                                                        <h4 class="mb-3 event-title">{{$packageDetails['event_title']}} <span class="badge badge-primary">{{$packageDetails['event_address_title']}}</span></h4>
                                                    </div>
                                                    @if (isset($packageDetails['event_img']))
                                                        <div class="pt-3 pb-3 shadow-sm" id="blurImg">
                                                            <img src="{{ env('BACKEND_BASE_URL') }}/{{ $packageDetails['event_img'] }}" class="img-fluid rounded" alt="{{ $packageDetails['event_title'] }}">
                                                        </div>
                                                    @endif
                                               </div>
                                                @php $userData = Common::fetchUserDetails(); @endphp
                                                @if(Common::isUserLogin())
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
                                                @endif
                                                <!-- Player Information Fields -->
                                                @for($i = 1; $i <= $bookingData['quantity']; $i++)
                                                    <div class="playerGroup">
                                                        @if ($bookingData['quantity'] > 1)
                                                            <h4 class="mb-3 text-center ticketHeading">Ticket {{ $i }}</h4>
                                                        @endif
                                                        
                                                        <div class="playerForm">
                                                            <div class="row">
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="player_name_{{ $i }}" class="form-label">Name <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="player_name_{{ $i }}" id="player_name_{{ $i }}" placeholder="Student Name" required>
                                                                </div>
                                                                
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="player_contact_{{ $i }}" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="player_contact_{{ $i }}" id="player_contact_{{ $i }}" placeholder="Student Contact Number" required maxlength="10" minlength="10">
                                                                </div>
                                                                
                                                                @if(in_array('age', $packageDetails['fields']))
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="age_{{ $i }}" class="form-label">Age <span class="text-danger">*</span></label>
                                                                    <input type="number" placeholder="Enter Age" class="form-control" name="player_age_{{ $i }}" id="age_{{ $i }}" required min="1" max="100">
                                                                </div>
                                                                @endif
                                                                
                                                                @if(in_array('shirt_size', $packageDetails['fields']))
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="shirt_size_{{ $i }}" class="form-label">T-Shirt Size <span class="text-danger">*</span></label>
                                                                    <select class="form-select form-control" name="player_shirt_size_{{ $i }}" id="shirt_size_{{ $i }}" required>
                                                                        <option value="">Choose Size</option>
                                                                        <option value="S">Small</option>
                                                                        <option value="M">Medium</option>
                                                                        <option value="L">Large</option>
                                                                        <option value="XL">Extra Large</option>
                                                                    </select>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>  
                                        </div>
                                    </div>
                                </div>                                                          
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mbsm mb-4">
                    <div class="card checkout-card shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-3">
                                <span class="text-white">Order Summary</span>
                            </h4>
                            <p class="text-danger m-0" id="coupon_err"></p>
                            @if (isset($couponList) && count($couponList) > 0)
                                <div class="input-group mb-3">
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
                                    <strong id="total_amount">{{$settingDetails['currency']}}{{$packageDetails['ticket']*$bookingData['quantity'] + $settingDetails['tax']}}</strong>
                                </li>
                            </ul>
                            <p>Present the QR Code Invoice during your first visit to the venue. By proceeding, I confirm my consent to complete the transaction and agree to the Terms & Conditions.</p>

                            
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="accept_term" id="accept_term">
                                    <label class="form-check-label text-white" for="accept_term">
                                        I accept the <a href="{{route('terms-conditions')}}" target="_blank" class="text-warning">Terms & Conditions</a>
                                    </label>
                                </div>
                            </div>

                            @if (Common::isUserLogin())
                                <button type="button" class="btn default-btn btn-block" id="submitPayment">Continue To Checkout</button>
                            @else
                                @php
                                    session(['redirect_url' => url()->current()]);
                                @endphp
                                <a href="{{ route('userLogin') }}" class="btn default-btn btn-block">Login To Continue</a>
                            @endif

                            <!-- <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-toggle="modal" data-target="#qrPaymentModal">
                                <i class="fas fa-qrcode mr-2"></i>View Payment Options
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
            
            @php
                $EventName = $packageDetails['event_title'] ?? 'Event';
                $EventId = $packageDetails['event_id'];
                $totalTax = $settingDetails['tax'] ?? 0;
                $ticketAmount = $packageDetails['ticket'] * $bookingData['quantity'];
                $totalAmountPayable = $ticketAmount + $totalTax;
                $feeToken = Common::randomMerchantId(1);
                $txnid = time() . rand(1, 99999);
                $ticket_id = $packageDetails['ticket_id'];
                $type = $packageDetails['type'];
                $ticket_price = $packageDetails['ticket'];
                $total_ticket = $bookingData['quantity'];
                $user_limit = $packageDetails['tlimit'];
                $sponser_id = $packageDetails['sponser_id'];
            @endphp
            
            <input type="hidden" name="merchant_order_id" value="{{ $feeToken }}" />
            <input type="hidden" name="merchant_trans_id" value="{{ $txnid }}" />
            <input type="hidden" name="total_amount_pay" value="{{ round($totalAmountPayable, 2) }}" />
            <input type="hidden" name="sponser_id" value="{{$sponser_id}}" />
            <input type="hidden" name="limit_user" value="{{$user_limit}}" />
            <input type="hidden" name="coupon_amt" id="coupon_amt" value="0" />
            <input type="hidden" name="tax" value="{{ $totalTax }}" />
            <input type="hidden" name="type" value="{{ $type }}" />
            <input type="hidden" name="ticket_id" value="{{ $ticket_id }}" />
            <input type="hidden" name="event_id" value="{{ $EventId }}" />
            <input type="hidden" name="ticket_price" value="{{ $ticket_price }}" />
            <input type="hidden" name="total_ticket" value="{{ $total_ticket }}" />
        </form>
    </div>

    <!-- MODAL START -->
    <div class="modal fade" id="qrPaymentModal" tabindex="-1" role="dialog" aria-labelledby="qrPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-cstm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="qrPaymentModalLabel">
                        <i class="fas fa-qrcode mr-2"></i>Pay via UPI QR Code <span class="text-warning small-text">( You are saving up to 15% on payment gateway, internet, and platform fees. )</span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-md-4 payment_details_div">
                            <div class="px-4 pt-4">
                                <div class="small_card mb-3">
                                    <small class="mb-3">Paying directly to:</small>
                                    <h5 class="text-warning mt-1 mb-0">{{ $packageDetails['short_name'] }}</h5>
                                </div>
                                <div class="small_card mb-3">
                                    <small class="mb-3">Total Payable Amount</small>
                                    <h5 class="text-warning mt-1 mb-0">Rs. {{ $packageDetails['ticket'] * $bookingData['quantity'] + $settingDetails['tax'] }}</h5>
                                </div>
                                <div class="small_card mb-3">
                                    <small class="mb-3">Using as:</small>
                                    <h5 class="text-warning mt-1 mb-0">{{ $userData['mobile'] }}</h5>
                                </div>
                            </div>
                            <div class="girl_img">
                                <img src="{{asset('images/girl_image.png')}}" class="img-fluid w-auto" alt="girl-bg">
                            </div>
                        </div>
                        <div class="col-md-8 d-flex justify-content-center align-items-center qr_container_div flex-column">
                            <div class="col-5 text-center px-4 py-2">
                                <div class="rounded p-2 position-relative main_qr d-flex justify-content-center">
                                    <div class="textBox-postion">
                                        <small class="mb-2 fw-bold">SCAN ME</small>
                                    </div>
                                    <img src="{{ $packageDetails['qr_code'] }}" alt="QR Code" class="img-fluid mt-3 rounded" style="max-width: 200px;">
                                </div>
                                <div class="mt-3">
                                    <h6 class="mb-1">Partner UP ID : <span class="text-warning">{{ $packageDetails['upi_id'] }}</span></h6>
                                    <h6 class="mb-1">Partner Mobile No. : <span class="text-warning">{{ $packageDetails['payment_number'] }}</span></h6>
                                </div>
                            </div>
                            <div class="trans_box">
                                <div class="form-group mb-0">
                                    <label for="trans_recept" class="mb-2 text-white">Enter the last 4 digits of your UPI Txn ID.</label>
                                    <div class="d-flex justify-content-center">
                                        <input type="text" maxlength="1" class="form-control trans_input" name="trans_recept_1" id="trans_recept_1" oninput="moveToNext(this, 'trans_recept_2')" onkeydown="handleBackspace(this, '')">
                                        <input type="text" maxlength="1" class="form-control trans_input" name="trans_recept_2" id="trans_recept_2" oninput="moveToNext(this, 'trans_recept_3')" onkeydown="handleBackspace(this, 'trans_recept_1')">
                                        <input type="text" maxlength="1" class="form-control trans_input" name="trans_recept_3" id="trans_recept_3" oninput="moveToNext(this, 'trans_recept_4')" onkeydown="handleBackspace(this, 'trans_recept_2')">
                                        <input type="text" maxlength="1" class="form-control trans_input" name="trans_recept_4" id="trans_recept_4" onkeydown="handleBackspace(this, 'trans_recept_3')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-0">
                    <button type="button" class="btn btn-warning w-100 py-3 modal-footer-btn" id="modalSubmitBtn" disabled>
                        Submit Now
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL END -->
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Function to move to next input field
    function moveToNext(current, nextFieldId) {
        if (current.value.length === current.maxLength) {
            document.getElementById(nextFieldId).focus();
        }
    }

    // Function to handle backspace
    function handleBackspace(current, prevFieldId) {
        if (event.key === 'Backspace' && current.value.length === 0 && prevFieldId) {
            document.getElementById(prevFieldId).focus();
        }
    }

    // Check if user is logged in and handle form interactions
    @if (!Common::isUserLogin())
    document.addEventListener('DOMContentLoaded', () => {
        let alertShown = false;
        document.querySelectorAll('#payment-form input, #payment-form select, #payment-form textarea').forEach(el => {
            el.addEventListener('focus', e => {
                if (!alertShown) {
                    alertShown = true;
                    Swal.fire({
                        title: 'Login Required',
                        text: 'Please login to continue',
                        confirmButtonText: 'Login Now',
                        background: '#414141',
                        color: 'white',
                        width: '500px', // Smaller width
                        padding: '1.2rem', // Reduced padding
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'small-swal' // Optional: Add custom CSS class
                        }
                    }).then(r => {
                        if (r.isConfirmed) window.location.href = "{{route('userLogin')}}";
                        alertShown = false;
                    });
                }
                e.preventDefault();
                e.target.blur();
            });
        });
    });
    @endif

    $(document).ready(function() {
        // Form validation function
        // function validateForm() {
        //     let isValid = true;

            
        //     const termsChecked = $('#accept_term').is(':checked');
        //     if(!termsChecked){
        //         isValid = false;
        //     }
            
        //     // Validate player information
        //     @for($i = 1; $i <= $bookingData['quantity']; $i++)
        //         // Player name validation
        //         if (!$('#player_name_{{ $i }}').val().trim()) {
        //             $('#player_name_{{ $i }}').addClass('is-invalid');
        //             isValid = false;
        //         } else {
        //             $('#player_name_{{ $i }}').removeClass('is-invalid');
        //         }
                
        //         // Player contact validation (10 digits)
        //         let contact = $('#player_contact_{{ $i }}').val().trim();
        //         if (!contact || !/^\d{10}$/.test(contact)) {
        //             $('#player_contact_{{ $i }}').addClass('is-invalid');
        //             isValid = false;
        //         } else {
        //             $('#player_contact_{{ $i }}').removeClass('is-invalid');
        //         }
                
        //         @if(in_array('age', $packageDetails['fields']))
        //         // Age validation
        //         if (!$('#age_{{ $i }}').val().trim()) {
        //             $('#age_{{ $i }}').addClass('is-invalid');
        //             isValid = false;
        //         } else {
        //             $('#age_{{ $i }}').removeClass('is-invalid');
        //         }
        //         @endif
                
        //         @if(in_array('shirt_size', $packageDetails['fields']))
        //         // Shirt size validation
        //         if (!$('#shirt_size_{{ $i }}').val()) {
        //             $('#shirt_size_{{ $i }}').addClass('is-invalid');
        //             isValid = false;
        //         } else {
        //             $('#shirt_size_{{ $i }}').removeClass('is-invalid');
        //         }
        //         @endif
        //     @endfor
            
        //     // For new users, validate registration fields
        //     @if (!Common::isUserLogin())
        //         if (!$('#username').val().trim()) {
        //             $('#username').addClass('is-invalid');
        //             isValid = false;
        //         } else {
        //             $('#username').removeClass('is-invalid');
        //         }
                
        //         let email = $('#email').val().trim();
        //         if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        //             $('#email').addClass('is-invalid');
        //             isValid = false;
        //         } else {
        //             $('#email').removeClass('is-invalid');
        //         }
                
        //         if (!$('#password').val().trim() || $('#password').val().length < 6) {
        //             $('#password').addClass('is-invalid');
        //             isValid = false;
        //         } else {
        //             $('#password').removeClass('is-invalid');
        //         }
        //     @endif
            
        //     return isValid;
        // }

        // Form validation function with specific error messages
        function validateForm() {
            let isValid = true;
            let errorMessages = [];

            // Reset all invalid classes first
            $('.is-invalid').removeClass('is-invalid');

            // Check terms and conditions
            const termsChecked = $('#accept_term').is(':checked');
            if (!termsChecked) {
                errorMessages.push('Please accept the Terms & Conditions to proceed');
                isValid = false;
            }
            
            // Validate player information
            @for($i = 1; $i <= $bookingData['quantity']; $i++)
                // Player name validation
                if (!$('#player_name_{{ $i }}').val().trim()) {
                    errorMessages.push('Please enter name');
                    $('#player_name_{{ $i }}').addClass('is-invalid');
                    isValid = false;
                }
                
                // Player contact validation (10 digits)
                let contact = $('#player_contact_{{ $i }}').val().trim();
                if (!contact) {
                    errorMessages.push('Please enter contact number');
                    $('#player_contact_{{ $i }}').addClass('is-invalid');
                    isValid = false;
                } else if (!/^\d{10}$/.test(contact)) {
                    errorMessages.push('Please enter a valid 10-digit contact number');
                    $('#player_contact_{{ $i }}').addClass('is-invalid');
                    isValid = false;
                }
                
                @if(in_array('age', $packageDetails['fields']))
                // Age validation
                let age = $('#age_{{ $i }}').val().trim();
                if (!age) {
                    errorMessages.push('Please enter age');
                    $('#age_{{ $i }}').addClass('is-invalid');
                    isValid = false;
                } else if (age < 1 || age > 100) {
                    errorMessages.push('Please enter a valid age (1-100)');
                    $('#age_{{ $i }}').addClass('is-invalid');
                    isValid = false;
                }
                @endif
                
                @if(in_array('shirt_size', $packageDetails['fields']))
                // Shirt size validation
                if (!$('#shirt_size_{{ $i }}').val()) {
                    errorMessages.push('Please select t-shirt size');
                    $('#shirt_size_{{ $i }}').addClass('is-invalid');
                    isValid = false;
                }
                @endif
            @endfor
            
            // For new users, validate registration fields
            @if (!Common::isUserLogin())
                if (!$('#username').val().trim()) {
                    errorMessages.push('Please enter a username');
                    $('#username').addClass('is-invalid');
                    isValid = false;
                }
                
                let email = $('#email').val().trim();
                if (!email) {
                    errorMessages.push('Please enter your email address');
                    $('#email').addClass('is-invalid');
                    isValid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    errorMessages.push('Please enter a valid email address');
                    $('#email').addClass('is-invalid');
                    isValid = false;
                }
                
                let password = $('#password').val().trim();
                if (!password) {
                    errorMessages.push('Please enter a password');
                    $('#password').addClass('is-invalid');
                    isValid = false;
                } else if (password.length < 6) {
                    errorMessages.push('Password must be at least 6 characters long');
                    $('#password').addClass('is-invalid');
                    isValid = false;
                }
            @endif
            
            // Show all error messages if validation fails
            if (!isValid) {
                // Create a formatted error message with bullet points
                let formattedMessage = '<div><ul>';
                errorMessages.forEach(msg => {
                    formattedMessage += `<li>${msg}</li>`;
                });
                formattedMessage += '</ul></div>';
                
                // Remove any existing error toasts
                iziToast.destroy();
                
                iziToast.error({
                    title: 'Validation Error',
                    position: 'topRight',
                    message: formattedMessage,
                    timeout: 10000, // Show for 10 seconds
                    displayMode: 2, // Persistent until dismissed
                    close: false,
                    buttons: [
                        ['<button>OK</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }]
                    ]
                });
                
                // Scroll to the first error field
                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 100
                }, 500);
            }
            
            return isValid;
        }
        
        // Handle Continue to Checkout button click
        $('#submitPayment').on('click', function(e) {
            e.preventDefault();
            
            // First validate the form
            if (!validateForm()) {
                // iziToast.error({
                //     title: 'Error',
                //     position: 'topRight',
                //     message: 'Please fill all required fields correctly before proceeding.',
                // });
                return false;
            }
            
            // If form is valid, open the payment modal
            $('#qrPaymentModal').modal('show');
        });
        
        // Validate modal fields and enable/disable submit button
        function validateModal() {
            // Check transaction ID
            let txnId = $('#trans_recept_1').val() + $('#trans_recept_2').val() + 
                        $('#trans_recept_3').val() + $('#trans_recept_4').val();
            
            // Check terms checkbox
            const termsChecked = $('#accept_term').is(':checked');
            
            // Enable/disable submit button based on validation
            if (txnId.length === 4 && termsChecked) {
                $('#modalSubmitBtn').prop('disabled', false);
                return true;
            } else {
                $('#modalSubmitBtn').prop('disabled', true);
                return false;
            }
        }
        
        // Validate modal fields on any change
        $('.trans_input, #accept_term').on('input change', function() {
            validateModal();
        });
        
        // Handle the modal's submit button
        $('#modalSubmitBtn').on('click', function() {
            if (!validateModal()) {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: 'Please complete all payment details and accept terms',
                });
                return false;
            }
            
            // Get transaction ID
            let txnId = $('#trans_recept_1').val() + $('#trans_recept_2').val() + 
                        $('#trans_recept_3').val() + $('#trans_recept_4').val();
            
            // Add transaction ID to form
            $('#payment-form').append('<input type="hidden" name="transaction_id" value="'+txnId+'">');
            
            // Submit the form
            $('#payment-form').submit();
        });
        
        // Coupon code application
        $("#apply_btn").on('click', function() {
            var txt = $("#promo_text").val();
            if (txt != '') {
                $("#apply_btn").text('Processing...').attr('disabled', 'disabled');
                
                $.get('{{url("get-promo-discount")}}?code=' + txt + '&amount={{$ticketAmount+$settingDetails["tax"]}}' + '&sid={{$packageDetails["sponser_id"]}}', function(data) {
                    if (data.s == 1) {
                        iziToast.success({
                            title: 'Success',
                            position: 'topRight',
                            message: 'Coupon applied successfully!',
                        });
                        
                        $("#coupon_err").text("");
                        $('#couponBox').removeClass('d-none').addClass('d-flex');
                        $('#coupon_amt').val(data.coupon);
                        $("#coupon_disc").text('-{{$settingDetails["currency"]}}' + data.coupon);
                        
                        // Update total amount
                        let newTotal = parseFloat({{$ticketAmount + $settingDetails['tax']}}) - parseFloat(data.coupon);
                        $("#total_amount").text('{{$settingDetails["currency"]}}' + newTotal.toFixed(2));
                        $("input[name='total_amount_pay']").val(newTotal.toFixed(2));
                    } else {
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: data.message || 'Invalid coupon code or coupon is expired',
                        });
                        $("#coupon_err").text(data.message || 'Invalid coupon code or coupon is expired');
                    }
                    
                    $("#apply_btn").text('Apply').removeAttr('disabled');
                });
            }
        });
    });
</script>

<script>
    // Dynamically set the background image (optional - can be done with inline CSS as shown above)
    document.addEventListener('DOMContentLoaded', function() {
        const blurContainer = document.getElementById('blurImg');
        if (blurContainer) {
            const imgUrl = "{{ env('BACKEND_BASE_URL') }}/{{ $packageDetails['event_img'] }}";
            const style = document.createElement('style');
            style.innerHTML = `
                #blurImg::before {
                    background-image: url('${imgUrl}');
                }
            `;
            document.head.appendChild(style);
        }
    });
</script>
@endpush