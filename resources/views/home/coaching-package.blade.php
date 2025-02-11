@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Book Packages for Sports coachings'))
@section('og_data')
    <meta name="description" content="Secure your spot in thrilling sports coachings. Book packages for cricket, tennis, and badminton coachings in Bangalore, Chennai, and Hyderabad now!" />
    <meta name="keywords" content="Book your coaching, Secure Booking" />
@endsection
@push('styles')
    
<style>
    /* Dark Theme Styling */
    .subscription-section {
        background: #0a0a0a;
        color: #ffffff;
        padding: 40px 0;
    }

    
    .subscription-section h1{
        font-size: 30px;
    }

    .subscription-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: #1a1b2e;
        color: #ffffff;
        border-radius: 10px;
        /* padding: 25px; */
        transition: transform 0.2s, background 0.3s;
        /* box-shadow: 0 4px 10px rgb(255 255 255 / 20%); */
        /* margin-bottom: 20px; */
        overflow: hidden;
    }

    .subscription-card:hover {
        transform: translateY(-4px);
        background: #1b1b37;
    }

    .subscription-card-header {
        font-size: 1.5rem;
        font-weight: bold;
        padding: 15px;
        border-radius: 10px 10px 0 0;
        text-align: left;
    }

    .subscription-card-body {
        padding: 25px 20px 20px;
        background: #2e335a45 !important;
        position: relative;
    }

    .subscription-card-title {
        font-size: 2rem;
        margin: 10px 0;
        text-align: left;
        margin-top:0px;
        margin-bottom:0px;
    }

    .price-text-muted {
        color: #b0b0b0;
        font-size: 0.9rem;
    }

    .button-primary, .button-success, .button-premium {
        display: inline-block;
        padding: 10px 25px;
        width: 100%;  /* Full width button */
        color: #ffffff;
        font-size: 1rem;
        text-align: center;
        border-radius: 5px;
        text-decoration: none;
        border-radius: 0px;
        transition: background 0.3s, transform 0.2s;
        /* margin-top: 20px; */
        border: none !important;
    }

    .button-primary {
        /* background: linear-gradient(90deg, #6e6e6e, #e74c3c); */
        background: #6e6e6e;
    }

    .bg-girl{
        background: #e74c3c !important;
    }

    .bg-boy{
        background: #6e6e6e !important;
    }


    /* .button-primary:hover {
        background: linear-gradient(90deg, #e74c3c, #6e6e6e);
        transform: translateY(-2px);
        color: #fff;
    } */

    .button-success {
        background: linear-gradient(90deg, #28a745, #34d058);
    }

    .button-success:hover {
        background: linear-gradient(90deg, #34d058, #28a745);
        transform: translateY(-2px);
        color: #fff;

    }

    .button-premium {
        background: linear-gradient(90deg, #f39c12, #e67e22);
    }

    .button-premium:hover {
        background: linear-gradient(90deg, #e67e22, #f39c12);
        transform: translateY(-2px);
        color: #fff;

    }

    .discount-badge {
        background-color: #ff9800;
        color: #121212;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .price-list {
        list-style: none;
        padding: 0;
        margin: 10px 0 0;
    }

    .price-list li {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }

    .price-list li i {
        color: #28a745;
        margin-right: 8px;
    }



    @media (min-width: 768px) {
        .subscription-card {
            height: 100%;
        }
    }

    .shop_single_page_sidebar{
        background: #414362;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
    }

    .shop_single_page_sidebar2{
        border: 1px solid #414362 !important;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        width: 50%;
        text-align: center;
        background: #1a1b2e;
    }

    .slotBadge{
        position: absolute;
        top: -10px;
        right: 7px;
        background: #ffe14f !important;
        color: #000000 !important;
        font-size: 11px;
        padding: 6px !important;
        font-weight: 500;
    }
    .col-md-3{
        padding: 5px !important;
    }
    .quantity-block{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }
</style>
@endpush
@section('content')
<section class="section-area single-detail-area py-3">
    <div class="container">
        <section class="subscription-section">
            <div class="container">
                <h1 class="text-center">Avaliable Ticket Types</h1>
                {{-- <h2>{{$coachData->coaching_title.' ('. $coachData->category->category_name .')'}} Packages</h2> --}}
                {{-- <h5 class="mt-0 mb-3 text-center">WHAT TICKETS WOULD YOU LIKE??</h5> --}}
                <div class="row mt-4">
                    {{-- @foreach ($packageData as $package)
                        @php
                            $realPrice = $package->package_price;
                            $afterDiscountPrice = 0;
                            $showDiscount = 0;
                            if($package->discount_percent > 0 && $package->discount_percent <= 100){
                                $perc = ($realPrice * $package->discount_percent) / 100;
                                $afterDiscountPrice = round($realPrice - $perc, 2);
                                $showDiscount = 1;
                            }
                            $type = explode(" ",$package->package_duration);
                            $type = $type[0].' '.trim($type[1],'s');
                        @endphp
                        <div class="col-md-4 d-flex mb-4">
                            <div class="subscription-card flex-grow-1 d-flex flex-column position-relative">
                                <div class="subscription-card-header" style="background-color: #007bff;">
                                    <h4><i class="fas fa-gem" style="font-size: 1rem;"></i> {{ $package->package_name }}</h4>
                                    @if($showDiscount)
                                        <span class="discount-badge">{{ $package->discount_percent }}% Off</span>
                                    @endif
                                </div>
                                <div class="subscription-card-body">
                                    @if($showDiscount)
                                        <h3 class="subscription-card-title">₹{{ $afterDiscountPrice }} <small class="price-text-muted">/ {{$type}}</small></h3>
                                        <p><small class="price-text-muted">Normally ₹{{ $realPrice + 0 }} / {{$type}}</small></p>
                                    @else
                                        <h3 class="subscription-card-title">₹{{$realPrice + 0}} <small class="price-text-muted">/ {{$type}}</small></h3>
                                    @endif
                                    

                                    <ul class="price-list">
                                        <li><i class="fas fa-check"></i> Batch Size -  {{ $package->batch_size }}</li>
                                        <li><i class="fas fa-check"></i> <div>{!! $package->description !!}</div></li>
                                    </ul>
                                    @php
                                           $inputObj = new stdClass();
                                           $inputObj->params = 'id='.$package->id;
                                           $inputObj->url = url('book-coaching-package');
                                           $encLink = Common::encryptLink($inputObj);
                                    @endphp
                                    <a href="{{$encLink}}" class="button-primary">Book Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach --}}

                    @foreach ($tour_plans as $package)
                        <div class="col-md-3 d-flex mb-4">
                            <div class="subscription-card flex-grow-1 d-flex flex-column position-relative">
                                <div class="subscription-card-header" style="background-color: #6e6e6e;" data-ticket-type="{{ $package['ticket_type'] }}">
                                    <h4 class="mb-0 text-center" style="font-size: 18px;"><i class="fas fa-gem" style="font-size: 18px;"></i> {{ $package['ticket_type'] }}</h4>
                                </div>
                                <div class="subscription-card-body">
                                    <h3 class="subscription-card-title text-center">₹{{$package['ticket_price']}}<small class="price-text-muted">/ Slot</small></h3>
                                    <div class="price-list">
                                        <p><span class="badge badge-danger p-2 mb-0 slotBadge">{{$package['TotalTicket']}} Slot Left</span></p>
                                        <p class="text-center"><i class="fas fa-trophy mr-2"></i>{{$package['description']}}</p>
                                    </div>
                                    <h6 class="mt-2 mb-0"><small>Quantity :</small></h6>
                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                        <div class="quantity-block home_page_sidebar" data-package-id="{{ $package['typeid'] }}">
                                            <button type="button" class="quantity-arrow-minus2 shop_single_page_sidebar">-</button>
                                            <input class="quantity-num2 shop_single_page_sidebar2" id="quantity_{{ $package['typeid'] }}" data-min="0" data-max="{{$package['TotalTicket']}}" type="number" value="0" readonly="">
                                            <button type="button" class="quantity-arrow-plus2 shop_single_page_sidebar">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="subscription-card-footer">
                                    <button type="button" data-tour="{{$coaching_id}}" data-ticket="{{$package['typeid']}}" class="button-primary btn-buy ">Book Now</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
@include('alert-messages')
@push('scripts')
<script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
<script>
$(document).ready(function () {
    // Handle click on the minus button
    $('.quantity-arrow-minus2').click(function () {
        var quantityInput = $(this).siblings('.quantity-num2');
        var currentVal = parseInt(quantityInput.val());

        if (currentVal > 0) {
            quantityInput.val(currentVal - 1);
        }
        resetOtherQuantities(quantityInput);
    });

    // Handle click on the plus button
    $('.quantity-arrow-plus2').click(function () {
        var quantityInput = $(this).siblings('.quantity-num2');
        var currentVal = parseInt(quantityInput.val());
        var maxVal = parseInt(quantityInput.attr('data-max'));

        if (currentVal < maxVal) {
            quantityInput.val(currentVal + 1);
        }
        resetOtherQuantities(quantityInput);
    });

    // Function to reset other quantities to zero
    function resetOtherQuantities(changedInput) {
        $('.quantity-num2').each(function () {
            var currentInput = $(this);

            // If this input is not the one being modified, set it to 0
            if (currentInput[0] !== changedInput[0] && parseInt(currentInput.val()) > 0) {
                currentInput.val(0);
            }
        });
    }

    // Ensure only one quantity input is non-zero at a time (optional)
    $('.quantity-num2').on('change', function () {
        resetOtherQuantities($(this));
    });

    // Add click event listener for "Book Now" button
    $('.button-primary').click(function (e) {
        e.preventDefault();

        var button = $(this);
        var packageCard = button.closest('.subscription-card'); // Get the closest subscription card
        var quantityInput = packageCard.find('.quantity-num2'); // Find the quantity input within the card
        var quantityVal = parseInt(quantityInput.val());

        // Extract tour_id and ticket_id from button's data attributes
        var tourId = button.data('tour');
        var ticketId = button.data('ticket');

        // Check if quantity is at least 1
        if (quantityVal < 1) {
            iziToast.error({
                title: 'Error',
                position: 'topRight',
                message: "Please select a quantity of at least 1 to proceed with booking.",
            });
            return false;
        }

        // Perform AJAX request to process booking
        $.ajax({
            url: "{{ route('purchase-coaching') }}", // Laravel route for handling the purchase
            type: 'POST',
            data: {
                tour_id: tourId,
                ticket_id: ticketId,
                quantity: quantityVal,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for security
            },
            success: function (response) {
                if (response.status === 'success') {
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight',
                        message: response.message,
                    });
                    // Redirect to the returned URL
                    window.location.href = response.redirect_url;
                } else {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: response.message,
                    });
                }
            },
            error: function () {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: 'An error occurred. Please try again later.',
                });
            }
        });
    });
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get all the headers and buttons
        const ticketHeaders = document.querySelectorAll('.subscription-card-header');
        
        // Loop through each header
        ticketHeaders.forEach(function (ticketHeader) {
            const textContent = ticketHeader.textContent.toLowerCase();
            
            // Check if it contains "girl" or "women"
            if (textContent.includes("girl") || textContent.includes("women")) {
                ticketHeader.style.backgroundColor = "#db207b"; // Change header background color
                
                // Find the associated buy button and change its background color
                const btnBuy = ticketHeader
                    .closest('.subscription-card') // Find the parent card
                    .querySelector('.btn-buy'); // Find the buy button inside the card
                
                if (btnBuy) {
                    btnBuy.style.backgroundColor = "#db207b";
                }
            }
        });
    });
</script>
@endpush