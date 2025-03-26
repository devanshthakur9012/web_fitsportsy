<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .ticket-container {
            border: 2px solid #e74c3c;
            border-radius: 10px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #e74c3c;
            margin: 0;
        }
        .ticket-info {
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .player-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .player-table th, .player-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .player-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <h1>Booking Confirmation</h1>
            <p>Ticket ID: {{ $ticketId }}</p>
        </div>

        <div class="ticket-info">
            <h2>Event Details</h2>
            <div class="info-row">
                <div class="info-label">Event:</div>
                <div>{{ $eventDetails['event_title'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date:</div>
                <div>{{ $eventDetails['event_sdate'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Time:</div>
                <div>{{ $eventDetails['event_time_day'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Location:</div>
                <div>{{ $eventDetails['event_address'] }}</div>
            </div>
        </div>

        <div class="ticket-info">
            <h2>Booking Details</h2>
            <div class="info-row">
                <div class="info-label">Ticket Type:</div>
                <div>{{ $eventDetails['type'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Quantity:</div>
                <div>{{ $bookingData['quantity'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Price per Ticket:</div>
                <div>₹{{ number_format($eventDetails['ticket'], 2) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Subtotal:</div>
                <div>₹{{ number_format($bookingData['quantity'] * $eventDetails['ticket'], 2) }}</div>
            </div>
            @if($bookingData['cou_amt'] > 0)
            <div class="info-row">
                <div class="info-label">Coupon Discount:</div>
                <div>- ₹{{ number_format($bookingData['cou_amt'], 2) }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Total Amount:</div>
                <div>₹{{ number_format($bookingData['total_amt'], 2) }}</div>
            </div>
        </div>

        @if(!empty($bookingData['user_info']))
        <div class="ticket-info">
            <h2>Player Information</h2>
            @foreach($bookingData['user_info'] as $group)
                <h3>Group {{ $group['group'] }}</h3>
                <table class="player-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Gender</th>
                            <th>Club</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group['players'] as $player)
                        <tr>
                            <td>{{ $player['name'] ?? '-' }}</td>
                            <td>{{ $player['contact'] ?? '-' }}</td>
                            <td>{{ $player['gender'] ?? '-' }}</td>
                            <td>{{ $player['club_name'] ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
        @endif

        <div class="qr-code">
            <p>Scan this QR code at the venue for check-in:</p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('ticket-verify', ['id' => $ticketId])) }}" alt="QR Code">
        </div>

        <div class="footer">
            <p>Thank you for your booking!</p>
            <p>For any queries, please contact support@example.com</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>