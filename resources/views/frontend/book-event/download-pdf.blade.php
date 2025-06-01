<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fitsportsy - Ticket Information</title>
    <style>
        /* Simplified, PDF-friendly styles */
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        
        .container {
            width: 100%;
            /* max-width: 800px; */
            margin: 0 auto;
            /* padding: 20px; */
        }
        
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            padding: 20px;
            box-shadow: none;
        }
        
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .logo_box {
            width: 100px;
        }
        
        .logo_box img {
            max-width: 100%;
            height: auto;
        }
        
        .header-text {
            margin-left: 10px;
        }
        
        .header-text h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #000;
        }
        
        .header-text p {
            font-size: 14px;
            margin: 0;
            color: #333;
        }
        
        .details-section {
            display: flex;
            margin-bottom: 20px;
        }
        
        .details-column {
            flex: 1;
            padding: 10px;
        }
        
        .details-column h2 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 15px 0;
            color: #000;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 5px;
        }
        
        .detail-item {
            margin-bottom: 10px;
        }
        
        .detail-item h5 {
            font-size: 14px;
            margin: 0;
            color: #000;
        }
        
        .detail-item h5 span {
            font-weight: normal;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .qr-code {
            text-align: center;
            padding: 10px;
        }
        
        .qr-code img {
            max-width: 120px;
            height: auto;
        }
        
        .qr-code p {
            font-size: 12px;
            margin-top: 5px;
        }
        
        .payment-section {
            margin-bottom: 20px;
        }
        
        .payment-section h2 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 15px 0;
            color: #000;
        }
        
        .payment-details {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .payment-row:last-child {
            margin-bottom: 0;
        }
        
        .booking-info {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .booking-info h4 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 15px 0;
            color: #000;
        }
        
        .info-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .info-list li {
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
        }
        
        .info-list li:last-child {
            margin-bottom: 0;
        }
        
        .info-list li i {
            color: #28a745;
            margin-right: 10px;
            margin-top: 3px;
        }
        
        .thank-you {
            padding: 15px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .thank-you h3 {
            font-size: 18px;
            margin: 0 0 10px 0;
        }
        
        .thank-you p {
            font-size: 14px;
            margin: 0;
            font-style: italic;
        }
        
        /* Print-specific styles */
        @media print {
            body {
                padding: 0;
                margin: 0;
                background: #fff;
                color: #000;
            }
            
            .container {
                padding: 0;
                max-width: 100%;
            }
            
            .card {
                border: none;
                padding: 0;
                box-shadow: none;
            }
            
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="logo_box">
                    <img src="https://fitsportsy.in/images/invoice-logo.png" alt="FitSportsy Logo">
                </div>
                <div class="header-text">
                    <h1>BOOKING INFO</h1>
                    <!-- <p>Your booking with FitSportsy is confirmed! We connect sports enthusiasts with expert coaches and training facilities across India. Your selected coaching session has been reserved, and the organizer will verify your payment shortly.</p> -->
                </div>
            </div>
            
            <div class="details-section">
                <div class="details-column">
                    <h2><i class="fas fa-user-circle"></i> Customer Details</h2>
                    <div class="detail-item">
                        <h5>Name : <span>{{$ticketData['ticket_username']}}</span></h5>
                    </div>
                    <div class="detail-item">
                        <h5>Booking Date : <span>{{$ticketData['ticket_book_time']}}</span></h5>
                    </div>
                    <div class="detail-item">
                        <h5>Booking No. : <span>{{$ticketData['unique_code']}}</span></h5>
                    </div>
                    <div class="detail-item">
                        <h5>Mobile No. : <span>{{$ticketData['ticket_mobile']}}</span></h5>
                    </div>
                </div>
                
                <div class="details-column">
                    <h2><i class="fas fa-store-alt"></i> Partner Details</h2>
                    <div class="detail-item">
                        <h5>Name : <span>{{$ticketData['sponsore_title']}}</span></h5>
                    </div>
                    <div class="detail-item">
                        <h5>Address : <span>{{$ticketData['event_address']}}</span></h5>
                    </div>
                    <div class="detail-item">
                        <h5>Mobile No. : <span>{{$ticketData['sponsore_mobile']}}</span></h5>
                    </div>
                </div>
            </div>
            
            <table>
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
                        <td rowspan="4" class="qr-code">
                            <img src="{{ $ticketData['qrcode'] }}" alt="QR Code">
                            <p>Show this QR invoice at the venue for entry. Partner will scan and verify payment.</p>
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
            
            <div class="payment-section">
                <h2><i class="fas fa-qrcode"></i> QR Code Payment Information</h2>
                <div class="payment-details">
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
            </div>
            
            <div class="booking-info">
                <h4><i class="fas fa-calendar-check"></i> Booking Info & Processing</h4>
                
                <ul class="info-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Your payment details have been submitted and are pending verification by the organiser.</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>The organiser will review and confirm your payment.</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Once verified, you will receive a confirmation via Email and WhatsApp.</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Your payment is secure and processed directly to the organiser via UPI.</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Please keep this booking ID handy and present it at the venue if requested.</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>For any support, contact: support@fitsportsy.in / +91 96863 14018</span>
                    </li>
                </ul>
                
                <div class="thank-you">
                    <h3><i class="fas fa-heart"></i> Thank you for booking with FitSportsy!</h3>
                    <p>Stay active, Stay fit!</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>