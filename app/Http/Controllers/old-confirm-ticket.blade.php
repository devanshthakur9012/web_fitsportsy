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
                                        {{-- <div>
                                            <input type="radio"  id="payment-{{ $item['id'] }}" 
                                                name="payment_type" value="{{ $item['id'] }}"
                                                @if($item['title'] === 'Razorpay') checked @endif>
                                            <label for="payment-{{ $item['id'] }}">
                                                <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" style="width: 50px; height: auto;">
                                                {{ $item['title'] }} - {{ $item['subtitle'] }}
                                            </label>
                                        </div> --}}
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
                                <li class="list-group-item d-none justify-content-between" id="couponBox">
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
                            <p>Show the ticket content QR Code on your mobile to enter the event place. By Proceeding, I express my consent to complete this Transaction.</p>
                            @if (Common::isUserLogin())
                                <button type="button" class="btn default-btn btn-block" id="payBookAmount">Continue To
                                    Checkout</button>
                            @else
                                <a href="{{route('userLogin')}}" class="btn default-btn btn-block">Login To Continue</a>
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script>
    $("#payBookAmount").on('click', function() {
        $name = $('#card_holder_name').val();
        $number = $('#number').val();
        $email = $('#email').val();
        if ($name != "" && $number != "" && $email != "") {
            $("#payBookAmount").attr('disabled', 'disabled').text('Processing Payment...');
            $.post('', {
                '_token': '{{csrf_token()}}',
                'coupon': $("#promo_text").val(),
                'donation': $('#donate_checked').val(),
            }, function(data) {
                if ($('input[name="payment_method"]:checked').val() == 2) {
                    $("#payment_type").val('2');
                    setTimeout(() => {
                        document.getElementById('razorpay-form').submit();
                    }, 2000);
                } else {
                    console.log(data);
                    razorpaySubmit(data.amount);
                }
            })
        } else {
            $('#errors').html('Please Fill Required Details');
        }
    })
</script>
<script>
    function razorpaySubmit(amount) {
        let totalAmount = amount * 100; // Razorpay expects amount in paise
        document.getElementById('merchant_total').value = Math.round(totalAmount);
        // Razorpay payment options
        var razorpayOptions = {
            key: "{{ $key_id }}", // Razorpay key from settings
            amount: Math.round(totalAmount), // Amount in paise
            name: "PlayOffz",
            description: "Order #{{ $feeToken }}", // Dynamic order ID
            currency: "{{ $currency }}",
            prefill: {
                name: $('#card_holder_name').val(),
                email: $('#email').val(),
                contact: $('#number').val()
            },
            handler: function(response) {
                // Capture Razorpay payment ID and submit form
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay-form').submit();
            },
            modal: {
                ondismiss: function() {
                    // alert('Payment canceled by the user.');
                    location.reload();
                }
            }
        };
        // Open Razorpay payment gateway
        var razorpayInstance = new Razorpay(razorpayOptions);
        razorpayInstance.open();
    }

    // On button click, initiate Razorpay payment
    $("#payBookAmount").on('click', function() {
        let totalAmount = {{ round($totalAmountPayable, 2) }};
        razorpaySubmit(totalAmount);
    });
</script>
<script>
    $("#apply_btn").on('click', function() {
        var txt = $("#promo_text").val();
        if (txt != '') {
            $("#apply_btn").text('Processing...').attr('disabled', 'disabled');
            $.get('{{url("get-promo-discount")}}?code=' + txt + '&amount={{$ticketAmount+$charges}}' + '&sid={{$packageDetails['sponser_id']}}', function(
                data) {
                if (data.s == 1) {
                    $("#coupon_err").text("");
                    $("#coupon_disc").text('-₹' + data.amount)
                    $("#total_amount").text('₹' + data.famount)
                    $("#coupon_id").val(data.id)
                    $("#coupon_discount").val(data.amount)
                    $("#pretotalAmount").val(data.famount)
                } else {
                    $("#coupon_err").text('Invalid coupon code or coupon is expired');
                }
                $("#apply_btn").text('Apply').removeAttr('disabled');
            })
        }
    })
</script>
@endpush