@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Book Packages for Sports coachings'))
@section('og_data')
    <meta name="description" content="Secure your spot in thrilling sports coachings. Book packages for cricket, tennis, and badminton coachings in Bangalore, Chennai, and Hyderabad now!" />
    <meta name="keywords" content="Book your coaching, Secure Booking" />
@endsection
@push('styles')
<style>
    /* Modern Dark Theme */
    .subscription-section {
        color: #ffffff;
        padding: 50px 0;
        font-family: 'Poppins', sans-serif;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
        background: linear-gradient(90deg, #ff6b6b, #feca57);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
    }

    .section-title:after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #ff6b6b, #feca57);
        margin: 10px auto 0;
        border-radius: 2px;
    }

    .subscription-card {
        background: linear-gradient(to right, #121212, #161616);
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        margin-bottom: 25px;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #2f2f2f;
    }

    .subscription-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .subscription-card-header {
        padding: 20px;
        text-align: center;
        position: relative;
        background: linear-gradient(135deg, #1e1e1e, #232323);
        border-radius: 10px 10px 0px 0px;
    }

    .ticket-type {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .subscription-card-body {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .price-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .price {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        background: linear-gradient(90deg, #8b8b8b, #ffffff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .price-period {
        font-size: 0.9rem;
        color: #b0b0b0;
        margin-top: 5px;
    }

    .features-list {
        list-style: none;
        padding: 0;
        margin: 0 0 20px;
    }

    .features-list li {
        padding: 8px 0;
        border-bottom: 1px solid #2a2d45;
        display: flex;
        align-items: center;
    }

    .features-list li:last-child {
        border-bottom: none;
    }

    .features-list li i {
        margin-right: 10px;
        color: #797979;
        font-size: 1.1rem;
    }

    .slots-badge {
        display: inline-block;
        background: rgb(31 31 31);
        color: #ffffff;
        padding: 5px 15px;
        border-radius: 20px;
        margin-bottom: 20px;
        align-self: center;
    }

    .book-btn {
        display: block;
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .book-btn:hover {
        transform: translateY(-2px);
        color:#ffc107 !important;
        /* box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); */
        /* background: linear-gradient(90deg, #ff6b6b, #feca57); */
        transition: all 0.3s ease;
    }

    .category-badge {
        position: absolute;
        top: -18px;
        right: -12px;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Different category colors */
    .badge-premium {
        background: linear-gradient(90deg, #feca57, #ff9f43);
        color: #1a1c2e;
    }

    .badge-standard {
        background: linear-gradient(90deg, #54a0ff, #2e86de);
        color: white;
    }

    .badge-women {
        background: linear-gradient(90deg, #ff9ff3, #f368e0);
        color: white;
    }

    .badge-youth {
        background: linear-gradient(90deg, #1dd1a1, #10ac84);
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
        }
        
        .price {
            font-size: 2rem;
        }
    }

    /* Quantity selector styles */
    .quantity-selector {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px 0;
    }

    .quantity-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: #2a2d45;
        color: #fff;
        font-size: 1.2rem;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .quantity-btn:hover {
        background: #3a3d5a;
    }

    .quantity-input {
        width: 60px;
        height: 40px;
        text-align: center;
        margin: 0 10px;
        border: 1px solid #2a2d45;
        background: #1a1c2e;
        color: #fff;
        font-size: 1.1rem;
        border-radius: 6px;
    }
    .main_card{
        margin-top:50px;
    }

    .original-price {
        display: flex;
        align-items: center;
        justify-content:center;
        gap: 10px;
        margin-bottom: 5px;
    }

    .strikethrough {
        text-decoration: line-through;
        color: #999;
        font-size: 16px;
    }

    .discount-badge {
        background-color: #ff4757;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
    }

    .current-price {
        color: #2ecc71;
        font-size: 24px;
        font-weight: bold;
        margin: 5px 0;
    }

    .you-save {
        color: #7f8c8d;
        font-size: 14px;
        font-style: italic;
    }

    .offerText{
        color: #feca57;
        text-align: center;
        padding: 7px 4px;
        border-radius: 4px;
        border: 1px solid;
    }
</style>
@endpush

@section('content')
<section class="section-area single-detail-area py-3">
    <div class="container">
        <section class="subscription-section">
            <div class="container d-flex align-items-center justify-content-center">
                <div class="col-lg-11">
                    <div class="d-flex align-items-center justify-content-center">
                        <h1 class="h2 mb-0 ml-2 category-h1">Available Packages</h1>
                    </div>
                    <div class="row justify-content-center main_card">
                        @foreach ($tour_plans as $package)
                            <div class="col-md-4 col-sm-6 mb-5">
                                <div class="subscription-card">
                                    <div class="subscription-card-header">
                                        <h3 class="ticket-type">{{ $package['category'] }}</h3>
                                    </div>
                                    <div class="subscription-card-body">
                                        <div class="price-container">
                                            @if($package['discount'] > 0)
                                                <div class="original-price">
                                                    <span class="strikethrough">₹{{ number_format($package['actual_price']) }}</span>
                                                    <span class="discount-badge">{{ $package['discount'] }}% OFF</span>
                                                </div>
                                            @endif
                                            <h2 class="price">₹{{ number_format($package['ticket_price']) }}</h2>
                                            @if($package['discount'] > 0)
                                                <p class="you-save mb-0">You save ₹{{ number_format($package['actual_price'] - $package['ticket_price']) }}</p>
                                            @endif
                                        </div>
                                        
                                        <span class="slots-badge">{{ $package['TotalTicket'] }} Available Batch Slots</span>
                                        
                                        <ul class="features-list mb-0">
                                            <li><i class="fas fa-calendar-check"></i> {{ $package['description'] }}</li>
                                            @php
                                                $validityMap = [
                                                    'monthly' => 'Monthly',
                                                    'qtrly' => 'Quarterly',
                                                    'quarterly' => 'Quarterly',
                                                    'halfyearly' => 'Half-Yearly',
                                                    'half-yearly' => 'Half-Yearly',
                                                    'yearly' => 'Yearly',
                                                ];

                                                $key = strtolower(trim($package['price_validity']));
                                                $validityLabel = $validityMap[$key] ?? ucfirst($key);
                                            @endphp

                                            <li><i class="fas fa-check-circle"></i> {{ $validityLabel }} Package</li>
                                            <li><i class="fas fa-clock"></i> {{ $package['ticket_type'] }}</li>
                                            @if($package['comp_classes'] > 0)
                                                <li><i class="fas fa-undo-alt"></i> {{ $package['comp_classes'] }} Compensation Classes</li>
                                            @endif

                                            @if($package['pause_weeks'] > 0)
                                                <li><i class="fas fa-pause-circle"></i> {{ $package['pause_weeks'] }} Pause Week{{ $package['pause_weeks'] > 1 ? 's' : '' }}</li>
                                            @endif

                                            @if($package['weekly_session'] > 0)
                                                <li><i class="fas fa-calendar-alt"></i> {{ $package['weekly_session'] }} Session{{ $package['weekly_session'] > 1 ? 's' : '' }} per week</li>
                                            @endif
                                        </ul>
                                        @if($package['offer'])
                                            <p class="mt-3 mb-0 offerText">{{ $package['offer'] }}</p>
                                        @endif
                                        <button class="btn btn-success btn-sm book-btn" 
                                            data-tour="{{ $coaching_id }}" 
                                            data-ticket="{{ $package['typeid'] }}">
                                            Book Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
$(document).ready(function() {
    // Quantity selector functionality
    $('.quantity-btn.minus').click(function() {
        const packageId = $(this).data('package');
        const input = $('#quantity_' + packageId);
        let value = parseInt(input.val());
        if (value > 1) {
            input.val(value - 1);
        }
    });

    $('.quantity-btn.plus').click(function() {
        const packageId = $(this).data('package');
        const input = $('#quantity_' + packageId);
        const max = parseInt(input.attr('max'));
        let value = parseInt(input.val());
        if (value < max) {
            input.val(value + 1);
        } else {
            iziToast.warning({
                title: 'Limit Reached',
                message: 'You cannot book more than the available slots',
                position: 'topRight'
            });
        }
    });

    // Book Now button functionality
    $('.book-btn').click(function() {
        const button = $(this);
        const tourId = button.data('tour');
        const ticketId = button.data('ticket');
        const quantity = $('#quantity_' + ticketId).val();

        // Validate quantity
        if (parseInt(quantity) < 1) {
            iziToast.error({
                title: 'Error',
                message: 'Please select at least 1 slot to book',
                position: 'topRight'
            });
            return false;
        }

        // Show loading state
        button.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        button.prop('disabled', true);

        // AJAX request
        $.ajax({
            url: "{{ route('purchase-coaching') }}",
            type: 'POST',
            data: {
                tour_id: tourId,
                ticket_id: ticketId,
                quantity: quantity,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                    window.location.href = response.redirect_url;
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: response.message,
                        position: 'topRight'
                    });
                    button.html('Book Now');
                    button.prop('disabled', false);
                }
            },
            error: function(xhr) {
                iziToast.error({
                    title: 'Error',
                    message: xhr.responseJSON?.message || 'An error occurred. Please try again.',
                    position: 'topRight'
                });
                button.html('Book Now');
                button.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush