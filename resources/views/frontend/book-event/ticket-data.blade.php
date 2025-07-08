@extends('frontend.master', ['activePage' => 'ticket'])
@section('title', __('Ticket Details'))

@push('styles')
<style>
    .ticket-details {
        background-color: #121212;
        color: #fff;
    }
    
    .ticket-card {
        background: #030303;
        border: 1px solid #2f2f2f;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .ticket-header {
        background-color: #030303;
        padding: 0px;
        border-bottom: 1px solid #2f2f2f;
    }
    
    .ticket-body {
        padding: 25px;
    }
    
    .detail-card {
        border: 1px solid #2f2f2f;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .detail-title {
        color: #efb507;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }
    
    .detail-item {
        margin-bottom: 10px;
    }
    
    .detail-label {
        font-weight: 600;
        color: #fff;
    }
    
    .detail-value {
        color: #ccc;
    }
    
    .ticket-table {
        color: #fff;
        border-radius: 10px;
    }
    
    .ticket-table thead th {
        color: #efb507;
        font-weight: 600;
        padding: 12px;
        border:1px solid  #2f2f2f !important;
    }
    
    .ticket-table tbody td {
        padding: 12px;
        border:1px solid  #2f2f2f !important;
        vertical-align: middle;
    }
    
    .qr-container {
        color:#fff;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }
    
    .qr-container p {
        color: #000;
        margin-top: 10px;
        font-size: 0.9rem;
    }
    
    .payment-card {
        border: 1px solid #2f2f2f;
        border-radius: 8px;
        padding: 0;
        overflow: hidden;
    }
    
    .payment-header {
        background-color: #efb507;
        color: #121212;
        padding: 15px;
        font-weight: 600;
    }
    
    .payment-body {
        padding: 10px 20px;
    }
    
    .payment-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #2f2f2f;
    }
    
    .payment-item:last-child {
        border-bottom: none;
    }
    
    .info-card {
        border: 1px solid #2f2f2f;
        border-radius: 8px;
        padding: 20px;
        text-align:left;
        background:transparent;
    }

    .info-card .info-list{
        list-style:none !important;
        padding: 0px;
    }
    
    .info-list li {
        margin-bottom: 15px;
        padding-left: 25px;
        position: relative;
        color: #ccc;
    }
    
    .info-list li::before {
        content: "\f00c";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #28a745;
        position: absolute;
        left: 0;
    }
    
    .thank-you {
        background-color: #28a745;
        color: #fff;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin-top: 20px;
    }
    
    .big-text {
        font-size: 3.5rem;
        font-weight: 900;
        color: #efb507;
        line-height: 1;
        margin-bottom: 10px;
    }
    
    /* Print specific styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .print-content, .print-content * {
            visibility: visible;
        }
        .print-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .ticket-card {
            background-color: #fff !important;
            color: #000 !important;
            box-shadow: none !important;
            border: none;
        }
        .detail-card, .ticket-table, .payment-card, .info-card {
            color: #000 !important;
            border: 1px solid #ddd !important;
        }
        .detail-title, .detail-label {
            color: #000 !important;
        }
        .detail-value {
            color: #333 !important;
        }
        .ticket-table thead th {
            background-color: #f8f9fa !important;
            color: #000 !important;
        }
        .payment-header {
            background-color: #ffc107 !important;
            color: #000 !important;
        }
        .btn {
            display: none;
        }
        .print_box {
            display: none;
        }
        footer {
            display: none !important;
        }
        .big-text {
            color: #000 !important;
        }
    }
</style>
@endpush

@section('content')
<section class="ticket-details py-5 print-content">
    <div class="container d-flex justify-content-center">
        <div class="col-lg-10">
            <div class="ticket-card shadow-lg">
                <!-- Header -->
                <div class="ticket-header">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <div class="logo-box">
                                <img src="{{asset('images/invoice-logo.png')}}" class="img-fluid" alt="logo">
                            </div>
                        </div>
                        <div class="col-md-8 pt-5">
                            <h1 class="big-text">BOOKING INFO</h1>
                            <p class="text-muted" style="font-size:17px;">Your booking with FitSportsy is confirmed! We connect sports enthusiasts with expert coaches and training facilities across India. Your selected coaching session has been reserved, and the organizer will verify your payment shortly.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="ticket-body">
                    <div class="row">
                        <!-- Customer Information -->
                        <div class="col-md-6 mb-4">
                            <div class="detail-card">
                                <h3 class="detail-title"><i class="fas fa-user-circle mr-2"></i> Customer Details</h3>
                                <div class="detail-item">
                                    <span class="detail-label">Name:</span>
                                    <span class="detail-value">{{$ticketData['ticket_username']}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Booking Date:</span>
                                    <span class="detail-value">{{$ticketData['ticket_book_time']}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Booking No.:</span>
                                    <span class="detail-value">{{$ticketData['unique_code']}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Mobile No.:</span>
                                    <span class="detail-value">{{$ticketData['ticket_mobile']}}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Partner Information -->
                        <div class="col-md-6 mb-4">
                            <div class="detail-card">
                                <h3 class="detail-title"><i class="fas fa-store-alt mr-2"></i> Partner Details</h3>
                                <div class="detail-item">
                                    <span class="detail-label">Name:</span>
                                    <span class="detail-value">{{$ticketData['sponsore_title']}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Address:</span>
                                    <span class="detail-value">{{$ticketData['event_address']}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Mobile No.:</span>
                                    <span class="detail-value">{{$ticketData['sponsore_mobile']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ticket Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table ticket-table">
                                    <thead>
                                        <tr>
                                            <th>Package Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>{{ $ticketData['ticket_title'] }}</b></td>
                                            <td>Rs. {{ $ticketData['ticket_subtotal'] }}</td>
                                            <td>{{ $ticketData['total_ticket'] }}</td>
                                            <td>Rs. {{ $ticketData['ticket_total_amt'] }}</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3" class="text-center">
                                                <div class="qr-container">
                                                    <img src="{{ $ticketData['qrcode'] }}" alt="QR Code" class="img-fluid" style="max-width: 120px;">
                                                    <p class="mb-0 text-white">Show this QR invoice at the venue for entry. Partner will scan and verify payment.</p>
                                                </div>
                                            </td>
                                            <td colspan="2"><strong>Total Amount</strong></td>
                                            <td>Rs. {{$ticketData['ticket_total_amt']}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><strong>Fee</strong></td>
                                            <td>Rs. {{ $ticketData['ticket_tax'] }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><strong>Final Amount</strong></td>
                                            <td>Rs. {{ $ticketData['ticket_total_amt'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="payment-card">
                                <div class="payment-header">
                                    <i class="fas fa-qrcode mr-2"></i>QR Code Payment Information
                                </div>
                                <div class="payment-body">
                                    <div class="payment-item">
                                        <span class="detail-label">Amount:</span>
                                        <span class="text-success">Rs. {{ $ticketData['ticket_total_amt'] }}/-</span>
                                    </div>
                                    <div class="payment-item">
                                        <span class="detail-label">UPI TXN ID:</span>
                                        <span>****{{ $ticketData['ticket_transaction_id'] }}</span>
                                    </div>
                                    <div class="payment-item">
                                        <span class="detail-label">Payment Date:</span>
                                        <span>{{ $ticketData['ticket_book_time'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Info -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="info-card">
                                <h4 class="detail-title"><i class="fas fa-calendar-check mr-2"></i>Booking Info & Processing</h4>
                                
                                <ul class="info-list">
                                    <li>Your payment details have been submitted and are pending verification by the organiser.</li>
                                    <li>The organiser will review and confirm your payment.</li>
                                    <li>Once verified, you will receive a confirmation via Email and WhatsApp.</li>
                                    <li>Your payment is secure and processed directly to the organiser via UPI.</li>
                                    <li>Please keep this booking ID handy and present it at the venue if requested.</li>
                                    <li>For any support, contact: <a href="mailto:support@fitsportsy.in" class="text-success">support@fitsportsy.in</a> / <a href="tel:+919686314018" class="text-success">+91 96863 14018</a></li>
                                </ul>
                                
                                <div class="thank-you mt-4">
                                    <h4 class="mb-2"><i class="fas fa-heart mr-2"></i>Thank you for booking with FitSportsy!</h4>
                                    <p class="mb-0">Stay active, Stay fit!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Print Button -->
                    <div class="row mt-1 print_box">
                        <div class="col-12 text-center">
                            <a href="{{route('ticket-pdf',$tid)}}" id="print_ticket" class="btn btn-success btn-sm w-50">
                                <i class="fas fa-print mr-2"></i> Print Ticket
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $("#print_ticket").click(function () {
        $(this).prop('disabled', true);
        $(this).html('<i class="fas fa-spinner fa-spin mr-2"></i> Downloading...');
        return false;
    });
</script>
@endpush