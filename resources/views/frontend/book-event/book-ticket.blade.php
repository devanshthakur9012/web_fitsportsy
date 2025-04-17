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
        background-color: #f9f9f9;
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
</style>
<section class="section-area checkout-event-area">
    <div class="container">
        <form action="{{route('store-payment-detail')}}" id="payment-form" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8 ">
                    <div class="card checkout-card shadow-sm">
                        <div class="card-body">
                            @isset($packageDetails)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="payment-details">
                                            <div class="row g-4">
                                                <div class="col-lg-12 mb-4">
                                                    <h4 class="mb-0" style="font-size: 20px">{{$packageDetails['event_title']}}</h4>
                                                    <p class="mb-0">{{$packageDetails['event_address_title']}}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="qr-code-container text-center">
                                                        <p class="mb-3"><strong class="text-dark">Scan QR Code to Pay</strong></p>
                                                        <img src="{{ $packageDetails['qr_code'] }}" alt="QR Code">
                                                        <div class="mt-3">
                                                            <p class="text-dark mb-0"><strong class="text-dark">UPI ID:</strong> {{ $packageDetails['upi_id'] }}</p>
                                                            <p class="text-dark mb-0"><strong class="text-dark">Organizer Name:</strong> {{ $packageDetails['event_title'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="formBox mt-4">
                                               <div class="row px-2">
                                                    <div class="col-lg-12 transaction-id-input mb-3">
                                                        <label for="transaction_id" class="form-label">Last 4 Digit of Transaction ID/Reference Number <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter last 4 digits of transaction ID" maxlength="4" required>
                                                        <small class="text-muted">Please enter the last 4 digit of transaction reference number from your payment</small>
                                                    </div>
                                               </div>
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
                                                                    <input type="text" class="form-control" name="player_contact_{{ $i }}" id="player_contact_{{ $i }}" placeholder="Student Contact Number" required>
                                                                </div>
                                                                
                                                                @if(in_array('age', $packageDetails['fields']))
                                                                <div class="mb-3 col-lg-6">
                                                                    <label for="age_{{ $i }}" class="form-label">Age <span class="text-danger">*</span></label>
                                                                    <input type="number" placeholder="Enter Age" class="form-control" name="player_age_{{ $i }}" id="age_{{ $i }}" required>
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
                                            
                                            <div class="terms-conditions">
                                                <h5>Terms & Conditions:</h5>
                                                <ul>
                                                    <li>This is a UPI-based direct payment to the organizer. FitSportsy is not responsible for payment disputes or refunds.</li>
                                                    <li>Please confirm the amount and organizer UPI ID before making the payment.</li>
                                                    <li>Ensure the last 4 digits of the UPI Transaction ID are accurate for ticket confirmation.</li>
                                                    <li>Entry without a valid ticket or incorrect payment details may be denied.</li>
                                                    <li>For any support, contact support@fitsportsy.in / +91 9686314018</li>
                                                </ul>
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
                            <h4 class=" mb-3">
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
                            <p>Present the QR code on your mobile ticket at the coaching entrance for seamless entry. By proceeding, I confirm my consent to complete this transaction.</p>
                            @if (Common::isUserLogin())
                                <button type="submit" class="btn default-btn btn-block" id="submitPayment">Complete Booking</button>
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
</section>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script>
$(document).ready(function() {
    // Form validation
    function validateForm() {
        let isValid = true;
        
        // Validate transaction ID (exactly 4 digits)
        let txnId = $('#transaction_id').val().trim();
        if (!txnId || txnId.length !== 4 || !/^\d+$/.test(txnId)) {
            $('#transaction_id').addClass('is-invalid');
            isValid = false;
        } else {
            $('#transaction_id').removeClass('is-invalid');
        }
        
        // Validate player information
        @for($i = 1; $i <= $bookingData['quantity']; $i++)
            // Player name validation
            if (!$('#player_name_{{ $i }}').val().trim()) {
                $('#player_name_{{ $i }}').addClass('is-invalid');
                isValid = false;
            } else {
                $('#player_name_{{ $i }}').removeClass('is-invalid');
            }
            
            // Player contact validation (10 digits)
            let contact = $('#player_contact_{{ $i }}').val().trim();
            if (!contact || !/^\d{10}$/.test(contact)) {
                $('#player_contact_{{ $i }}').addClass('is-invalid');
                isValid = false;
            } else {
                $('#player_contact_{{ $i }}').removeClass('is-invalid');
            }
            
            @if(in_array('age', $packageDetails['fields']))
            // Age validation
            if (!$('#age_{{ $i }}').val().trim()) {
                $('#age_{{ $i }}').addClass('is-invalid');
                isValid = false;
            } else {
                $('#age_{{ $i }}').removeClass('is-invalid');
            }
            @endif
            
            @if(in_array('shirt_size', $packageDetails['fields']))
            // Shirt size validation
            if (!$('#shirt_size_{{ $i }}').val()) {
                $('#shirt_size_{{ $i }}').addClass('is-invalid');
                isValid = false;
            } else {
                $('#shirt_size_{{ $i }}').removeClass('is-invalid');
            }
            @endif
        @endfor
        
        // For new users, validate registration fields
        @if (!Common::isUserLogin())
            if (!$('#username').val().trim()) {
                $('#username').addClass('is-invalid');
                isValid = false;
            } else {
                $('#username').removeClass('is-invalid');
            }
            
            let email = $('#email').val().trim();
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                $('#email').addClass('is-invalid');
                isValid = false;
            } else {
                $('#email').removeClass('is-invalid');
            }
            
            if (!$('#password').val().trim() || $('#password').val().length < 6) {
                $('#password').addClass('is-invalid');
                isValid = false;
            } else {
                $('#password').removeClass('is-invalid');
            }
        @endif
        
        return isValid;
    }
    
    // Handle form submission
    $('#payment-form').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            iziToast.error({
                title: 'Error',
                position: 'topRight',
                message: 'Please fill all required fields correctly before submitting.',
            });
            return false;
        }
        
        // For new users, check if email exists
        @if (!Common::isUserLogin())
            let email = $('#email').val().trim();
            $.ajax({
                url: "{{route('verifyEmail')}}",
                type: "POST",
                async: false,
                data: { 
                    email: email, 
                    _token: "{{ csrf_token() }}" 
                },
                success: function(data) {
                    if (data.Result === "false") {
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: data.ResponseMsg || 'Email already exists. Please use another email.',
                        });
                        $('#email').addClass('is-invalid');
                        isValid = false;
                    }
                }
            });
            
            if (!isValid) return false;
        @endif
        
        // Show loading state
        $('#submitPayment').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        
        // Submit the form
        this.submit();
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
@endpush