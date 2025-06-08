<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fitsportsy - Ticket Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 5px;
            line-height: 1.2;
            font-size: 11px;
        }
        
        .container {
            width: 100%;
            margin: 0 auto;
        }
        
        .card {
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            padding: 8px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin: 0 0 8px 0;
            color: #000;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 2px;
        }
        
        .detail-label {
            font-weight: bold;
            width: 100px;
        }
        
        .qr-code {
            text-align: center;
            padding: 3px;
        }
        
        .qr-code img {
            max-width: 70px;
            height: auto;
        }
        
        .qr-code p {
            font-size: 9px;
            margin-top: 2px;
        }
        
        .payment-details {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        
        .info-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .info-list li {
            margin-bottom: 6px;
            display: flex;
            align-items: flex-start;
        }
        
        .info-list li:before {
            content: "✓";
            color: #28a745;
            margin-right: 6px;
        }
        
        .thank-you {
            padding: 8px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 11px;
        }
        
        .logo {
            width: 100px;
            height: 100px;
        }
        
        .compact {
            font-size: 10px;
        }
        
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            
            .container {
                padding: 3px;
            }
            
            .card {
                border: none;
                padding: 3px;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Header with logo and title -->
            <table width="100%" style="border:none; margin-bottom:10px;">
                <tr>
                    <td style="width:100px; border:none; vertical-align:middle;">
                        <img src="https://fitsportsy.in/images/invoice-logo.png" alt="FitSportsy Logo" class="logo">
                    </td>
                    <td style="border:none; vertical-align:middle;">
                        <h1 style="font-size:20px; margin-bottom:0; color:#000;">BOOKING INFO</h1>
                        <p style="margin-top:5px;">Your booking with FitSportsy is confirmed! We connect sports enthusiasts with expert coaches and training facilities across India. Your selected coaching session has been reserved, and the organizer will verify your payment shortly.</p>
                    </td>
                </tr>
            </table>
            <p style="border-top:1px solid #dddddd;height:1;"></p>
            <!-- Customer and Partner Details -->
            <table width="100%" style="border:none; margin-bottom:10px;">
                <tr>
                    <td style="width:50%; border:none; vertical-align:top; padding-right:5px;">
                        <div class="section-title">Customer Details</div>
                        <table style="border:none;">
                            <tr>
                                <td style="border:none; width:90px;" class="detail-label">Name:</td>
                                <td style="border:none;">{{$ticketData['ticket_username']}}</td>
                            </tr>
                            <tr>
                                <td style="border:none;" class="detail-label">Booking Date:</td>
                                <td style="border:none;">{{$ticketData['ticket_book_time']}}</td>
                            </tr>
                            <tr>
                                <td style="border:none;" class="detail-label">Booking No.:</td>
                                <td style="border:none;">{{$ticketData['unique_code']}}</td>
                            </tr>
                            <tr>
                                <td style="border:none;" class="detail-label">Mobile No.:</td>
                                <td style="border:none;">{{$ticketData['ticket_mobile']}}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:50%; border:none; vertical-align:top; padding-left:5px;">
                        <div class="section-title">Partner Details</div>
                        <table style="border:none;">
                            <tr>
                                <td style="border:none; width:90px;" class="detail-label">Name:</td>
                                <td style="border:none;">{{$ticketData['sponsore_title']}}</td>
                            </tr>
                            <tr>
                                <td style="border:none;" class="detail-label">Address:</td>
                                <td style="border:none;">{{$ticketData['event_address']}}</td>
                            </tr>
                            <tr>
                                <td style="border:none;" class="detail-label">Mobile No.:</td>
                                <td style="border:none;">{{$ticketData['sponsore_mobile']}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Package and Payment Details -->
            <table>
                <thead>
                    <tr>
                        <th>Package Name</th>
                        <th style="width:60px;">Price</th>
                        <th style="width:40px;">Qty</th>
                        <th style="width:70px;">Subtotal</th>
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
                        <td rowspan="3" class="qr-code">
                            <img src="{{ $ticketData['qrcode'] }}" alt="QR Code">
                            <p>Show this QR invoice at the venue for entry.</p>
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
            
            <!-- Payment Information -->
            <div class="payment-details">
                <div class="section-title">Payment Information</div>
                <div class="payment-row">
                    <span><strong>Amount:</strong></span>
                    <span>Rs. {{ $ticketData['ticket_total_amt'] }}/-</span>
                </div>
                <div class="payment-row">
                    <span><strong>UPI TXN ID:</strong></span>
                    <span>****{{ $ticketData['ticket_transaction_id'] }}</span>
                </div>
                <div class="payment-row">
                    <span><strong>Payment Date:</strong></span>
                    <span>{{ $ticketData['ticket_book_time'] }}</span>
                </div>
            </div>
            
            <!-- Booking Info -->
            <div>
                <div class="section-title">Booking Info & Processing</div>
                <ul class="info-list compact">
                    <li>Your payment details have been submitted and are pending verification by the organiser.</li>
                    <li>The organiser will review and confirm your payment.</li>
                    <li>Once verified, you will receive a confirmation via Email and WhatsApp.</li>
                    <li>Your payment is secure and processed directly to the organiser via UPI.</li>
                    <li>Please keep this booking ID handy and present it at the venue if requested.</li>
                    <li>For any support, contact: support@fitsportsy.in / +91 96863 14018</li>
                </ul>
            </div>
            
            <!-- Thank You -->
            <div class="thank-you">
                <div><strong>Thank you for booking with FitSportsy!</strong></div>
                <div>Stay active, Stay fit!</div>
            </div>
        </div>
    </div>
</body>
</html>