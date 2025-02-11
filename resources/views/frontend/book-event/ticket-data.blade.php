@extends('frontend.master', ['activePage' => 'ticket'])
@section('title', __('Ticket Details'))
<style>
    .card {
        background-color: #ffffff !important;
        color: #000;
        padding: 0px !important;
    }

    /* Styling for the ticket page */
    .ticket-area {
        font-family: Arial, sans-serif;
        margin: 20px auto;
    }
    
    .ticket-area .card {
        border: none;
        box-shadow: none;
        border-radius: 10px !important;
        overflow: hidden;
        padding: 15px 20px !important;
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

    /* Print specific styles to match screen */
    @media print {
        body {
            background-color: #ffffff;
            color: #000000;
        }

        .ticket-area {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .ticket-area .card {
            background-color: #ffffff !important;
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
            display: block; /* Ensure QR code image is displayed during printing */
        }

        /* Hide interactive or unnecessary elements for print */
        .btn {
            display: none; /* Hide the print button */
        }

        /* Adjust font sizes for print clarity */
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
    }
    .textDark{
        color: #000 !important;
    }
    body{
        color: #000 !important;
    }
</style>

@section('content')
<section class="ticket-area section-area">
    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <img src="{{asset('/images/ticketbg.png')}}" class="img-fluid" alt="">
                <div class="pt-2 px-4">
                    <div class="text-center mb-4">
                        <h2 class="textDark">{{ $ticketData['ticket_title'] }}</h2>
                        <p class="textDark"><strong>Event Time:</strong> {{ $ticketData['start_time'] }}</p>
                    </div>
                    <div class="row p-2 align-items-center">
                        <!-- Event Details -->
                        <div class="col-md-9">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row">Title</th>
                                        <td>{{ $ticketData['ticket_title'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Location</th>
                                        <td>{{ $ticketData['event_address'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Organizer</th>
                                        <td>{{ $ticketData['sponsore_title'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Code</th>
                                        <td>{{ $ticketData['unique_code'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Type</th>
                                        <td>{{ $ticketData['ticket_type'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td>
                                            <span class="badge {{ $ticketData['ticket_status'] === 'Paid' ? 'badge-success' : 'badge-danger' }}">
                                                {{ ucfirst($ticketData['ticket_status']) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                        

                        <!-- Ticket and QR Details -->
                        <div class="col-md-3 text-center">
                            <img src="{{$ticketData['qrcode']}}" alt="QR Code" class="w-100 img-fluid mb-3" style="max-width: 100%; border: 1px solid #ddd; padding: 10px;">                           
                        </div>
                    </div>
                    <hr>
                    <!-- User Details -->
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="textDark"><b>User Details</b></h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>{{ $ticketData['ticket_username'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Mobile</th>
                                        <td>{{ $ticketData['ticket_mobile'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{ $ticketData['ticket_email'] }}</td>
                                    </tr>
                                </tbody>
                            </table>   
                        </div>
                        <div class="col-lg-6">
                            <h5 class="textDark"><b>Transaction Details</b></h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row">Transaction ID</th>
                                        <td>{{ $ticketData['ticket_transaction_id'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Payment Method</th>
                                        <td>{{ $ticketData['ticket_p_method'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Subtotal</th>
                                        <td>₹{{ $ticketData['ticket_subtotal'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tax</th>
                                        <td>₹{{ $ticketData['ticket_tax'] }}</td>
                                    </tr>
                                    @if(isset($ticketData['ticket_cou_amt']) && $ticketData['ticket_cou_amt'] > 0) 
                                        <tr>
                                            <th scope="row">Coupon</th>
                                            <td>-₹{{ $ticketData['ticket_cou_amt'] }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th scope="row">Total Paid</th>
                                        <td>₹{{ $ticketData['ticket_total_amt'] }}</td>
                                    </tr>
                                </tbody>
                            </table>    
                        </div>                    
                    </div>
                    <hr>
                    <div class="text-center mt-3 mb-3 print_box">
                        <button id="print_ticket" class="btn btn-primary">
                            <i class="fas fa-print"></i> Print Ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Print functionality for ticket
    $("#print_ticket").click(function () {
        window.print();
    });
</script>
@endpush
