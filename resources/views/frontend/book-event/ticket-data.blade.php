@extends('frontend.master', ['activePage' => 'ticket'])
@section('title', __('Ticket Details'))
<style>
    .card {
        background-color: #858590 !important;
        color: #000;
        padding: 0px !important;
        font-family:sans-serif !important;
    }

    /* Styling for the ticket page */
    .ticket-area {
        margin: 20px auto;
    }
    
    .ticket-area .card {
        border: none;
        box-shadow: none;
        border-radius: 10px !important;
        overflow: hidden;
        padding: 0px !important;
    }

    .ticket-area .card-body {
        padding: 15px;
    }

    .ticket-area .text-center h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .ticket-area .text-center p {
        font-size: 16px;
        color: #555;
    }

    .ticket-area table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #000;
        font-size: 15px !important;
    }

    .ticket-area table td {
        font-size: 14px;
        padding: 8px;
        vertical-align: middle;
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
        .ticket-area .card {
            background-color: #858590 !important;
            color: #000000 !important;
            box-shadow: none !important;
            border: none;
        }
        .card-body {
            padding: 0;
            margin: 0;
        }
        .ticket-area .text-center h2 {
            font-size: 24px;
            color: #333;
        }
        .ticket-area .text-center p {
            font-size: 16px;
            color: #555;
        }
        .ticket-area table {
            width: 100%;
            border-collapse: collapse;
        }
        .ticket-area table th, .ticket-area table td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }
        .ticket-area .row {
            margin-bottom: 20px;
        }
        .ticket-area .col-md-4 {
            display: block;
        }
        .btn {
            display: none;
        }
        .ticket-area table td {
            font-size: 14px;
        }
        .ticket-area table th {
            font-size: 14px;
        }
        .col-md-9 {
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }
        .col-md-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        .ticket-area table th {
            background-color: #f8f9fa;
            font-weight: 400;
        }
        .badge-success {
            color: #fff !important;
            background-color: #28a745 !important;
            border: none !important;
        }
        .print_box{
            display: none;
        }
        .bottom-location{
            display: none !important;
        }
        footer{
            display: none !important;
        }
        .textDark{
            color: #000 !important;
        }
        body{
            color: #000 !important;
        }
        .bigText{
            font-size:70px !important;
            font-family:sans-serif !important;
            font-weight:900;
        }
        .text-black{
            color:#000 !important;
        }
        .table thead th{
            font-size:20px !important;
        }
    }
    .textDark{
        color: #000 !important;
    }
    body{
        color: #000 !important;
    }
    .bigText{
        font-size:70px !important;
        font-family:sans-serif !important;
        font-weight:900;
    }
    .text-black{
        color:#000 !important;
    }
    .table thead th{
        font-size:20px !important;
    }
</style>

@section('content')
<section class="ticket-area section-area print-content">
    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="row align-items-center justify-content-start">
                <div class="col-lg-3">
                    <div class="logo_box">
                        <img src="{{asset('images/invoice-logo.png')}}" class="img-fluid" alt="logo">
                    </div>
                </div>
                <div class="col-lg-8">
                    <h1 class="bigText">BOOKING INFO</h1>
                    <p class="text-white fs-4" style="font-size: 20px;">Your booking with FitSportsy is confirmed! We connect sports enthusiasts with expert coaches and training facilities across India. Your selected coaching session has been reserved, and the organizer will verify your payment shortly.</p>
                </div>
            </div>
            <div class="card-body p-4" style="">
                <div class="row justify-content-center">
                    <!-- Customer Information -->
                    <div class="col-lg-5 p-4 me-lg-4">
                        <h2 class="mb-0" style="font-weight: 700; color: #343a40;"><i class="fas fa-user-circle me-3" style="font-size: 2rem; color: #ffc107;"></i> Customer Details</h2>
                        
                        <div class="ps-4 mt-3">
                            <div class="mb-3">
                                <h5 class="mb-1" style="font-weight: 700; color: #fff;">Name : <span class="text-warning" style="font-weight: 400;">{{$ticketData['ticket_username']}}</span></h5>
                            </div>
                            <div class="mb-3">
                                <h5 class="mb-1" style="font-weight: 700; color: #fff;">Booking Date : <span class="text-warning" style="font-weight: 400;">{{$ticketData['ticket_book_time']}}</span></h5>
                            </div>
                            <div class="mb-3">
                                <h5 class="mb-1" style="font-weight: 700; color: #fff;">Booking No. : <span class="text-warning" style="font-weight: 400;">{{$ticketData['unique_code']}}</span></h5>
                            </div>
                            <div class="mb-3">
                                <h5 class="mb-1" style="font-weight: 700; color: #fff;">Mobile No. : <span class="text-warning" style="font-weight: 400;">{{$ticketData['ticket_mobile']}}</span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 p-4 me-lg-4">
                        <h2 class="mb-0" style="font-weight: 700; color: #343a40;"><i class="fas fa-store-alt me-3" style="font-size: 2rem; color: #ffc107;"></i> Partner Details</h2>
                        
                        <div class="ps-4 mt-3">
                            <div class="mb-3">
                                <h5 class="mb-1" style="font-weight: 700; color: #fff;">Name : <span class="text-warning" style="font-weight: 400;">{{$ticketData['sponsore_title']}}</span></h5>
                            </div>
                            <div class="mb-3">
                                <h5 class="mb-1" style="font-weight: 700; color: #fff;">Address : <span class="text-warning" style="font-weight: 400;">{{$ticketData['event_address']}}</span></h5>
                            </div>
                            <div class="mb-3">
                                <h5 class="mb-1" style="font-weight: 700; color: #fff;">Mobile No. : <span class="text-warning" style="font-weight: 400;">{{$ticketData['sponsore_mobile']}}</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div class="table-responsive rounded">
                            <table class="table mb-0 table-borderless">
                                <thead class="">
                                    <tr>
                                        <th class="fw-bold bg-warning py-3">Package Name</th>
                                        <th class="fw-bold bg-warning py-3">Price</th>
                                        <th class="fw-bold bg-warning py-3">Qty</th>
                                        <th class="fw-bold bg-warning py-3">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-light">
                                        <td class="py-3 border-bottom"><b>{{ $ticketData['ticket_title'] }}</b></td>
                                        <td class="py-3 border-bottom">Rs. {{ $ticketData['ticket_subtotal'] }}</td>
                                        <td class="py-3 border-bottom">{{ $ticketData['total_ticket'] }}</td>
                                        <td class="py-3 border-bottom">Rs. {{ $ticketData['ticket_total_amt'] }}</td>
                                    </tr>
                                    <tr class="table-light">
                                        <td rowspan="4" class="text-center align-middle bg-white">
                                            <img src="{{ $ticketData['qrcode'] }}" alt="QR Code" class="img-fluid" style="max-width: 120px;">
                                            <p class="mt-2 text-black small">Show this QR invoice at the venue for entry. Partner will scan and verify payment.</p>
                                        </td>
                                        <td colspan="2" class="py-2 border-bottom"><strong>Total Amount</strong></td>
                                        <td class="py-2 border-bottom">Rs. {{$ticketData['ticket_total_amt']}}</td>
                                    </tr>
                                    <tr class="table-light">
                                        <td colspan="2" class="py-2 border-bottom"><strong>Fee</strong></td>
                                        <td class="py-2 border-bottom">Rs. {{ $ticketData['ticket_tax'] }}</td>
                                    </tr>
                                    <tr class="table-light">
                                        <td colspan="2" class="py-2 border-bottom"><strong>Final Amount</strong></td>
                                        <td class="py-2 border-bottom">Rs. {{ $ticketData['ticket_total_amt'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="rounded my-4">
                            <h2 class="bg-warning p-3 rounded-top mb-0 font-weight-bold text-black">
                                <i class="fas fa-qrcode mr-2"></i>QR Code Payment Information
                            </h2>
                            <div class="payment-details bg-white p-4 rounded-bottom">
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="font-weight-bold">Amount:</span>
                                    <span class="text-success">Rs. {{ $ticketData['ticket_total_amt'] }}/-</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="font-weight-bold">UPI TXN ID:</span>
                                    <span class="text-monospace">****{{ $ticketData['ticket_transaction_id'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="font-weight-bold">Payment Date:</span>
                                    <span class="text-primary">{{ $ticketData['ticket_book_time'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- BOOKING INFO -->
                        <div class="booking-info bg-light p-4 rounded mb-4">
                            <h4 class="mb-4 font-weight-bold text-black"><i class="fas fa-calendar-check mr-2"></i>Booking Info & Processing</h4>
                            
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex align-items-start">
                                    <span class="text-success mr-2"><i class="fas fa-check-circle"></i></span>
                                    <span>Your payment details have been submitted and are pending verification by the organiser.</span>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <span class="text-success mr-2"><i class="fas fa-check-circle"></i></span>
                                    <span>The organiser will review and confirm your payment.</span>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <span class="text-success mr-2"><i class="fas fa-check-circle"></i></span>
                                    <span>Once verified, you will receive a confirmation via Email and WhatsApp.</span>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <span class="text-success mr-2"><i class="fas fa-check-circle"></i></span>
                                    <span>Your payment is secure and processed directly to the organiser via UPI.</span>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <span class="text-success mr-2"><i class="fas fa-check-circle"></i></span>
                                    <span>Please keep this booking ID handy and present it at the venue if requested.</span>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <span class="text-success mr-2"><i class="fas fa-check-circle"></i></span>
                                    <span>For any support, contact: <a href="mailto:support@fitsportsy.in" class="text-primary">support@fitsportsy.in</a> / <a href="tel:+919686314018" class="text-primary">+91 96863 14018</a></span>
                                </li>
                            </ul>
                            
                            <div class="thank-you mt-4 p-3 bg-success text-white rounded text-center">
                                <h3 class="mb-0"><i class="fas fa-heart mr-2"></i>Thank you for booking with FitSportsy!</h3>
                                <p class="mb-0 font-italic text-white">Stay active, Stay fit!</p>
                            </div>
                        </div>
                        <!-- PRINT BTN -->
                        <div class="text-center mt-3 mb-3 print_box">
                            <a href="{{route('ticket-pdf',$tid)}}" id="print_ticket" class="btn btn-dark">
                                <i class="fas fa-print"></i> Print Ticket
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
        $(this).html('<i class="fas fa-spinner fa-spin"></i> Downloading...');
        return false;
    });
</script>
@endpush