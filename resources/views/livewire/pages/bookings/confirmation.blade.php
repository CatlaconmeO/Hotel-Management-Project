<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #1B4965; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f8f9fa; }
        .panel { background-color: #ffffff; border-left: 4px solid #1B4965; padding: 15px; margin-bottom: 20px; }
        .button { display: inline-block; background-color: #1B4965; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; }
        .footer { font-size: 12px; color: #6c757d; text-align: center; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Booking Confirmation</h1>
    </div>

    <div class="content">
        <p>Dear {{ $booking->customer->name }},</p>

        <p>Thank you for choosing <strong>{{ $booking->branch->team->name }}</strong>. Your reservation has been confirmed.</p>

        <div class="panel">
            <h2>Booking Details (#{{ $booking->id }})</h2>
            <p><strong>Hotel:</strong> {{ $booking->branch->team->name }}</p>
            <p><strong>Branch:</strong> {{ $booking->branch->name }}</p>
            <p><strong>Room Type:</strong> {{ $booking->bookingDetail->room->roomType->name }}</p>
            <p><strong>Room Number:</strong> {{ $booking->bookingDetail->room->room_number }}</p>
            <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('l, F d, Y') }}</p>
            <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('l, F d, Y') }}</p>
            <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} nights</p>
        </div>

        <table>
            <tr>
                <th colspan="2">Payment Information</th>
            </tr>
            <tr>
                <td><strong>Total Amount</strong></td>
                <td>${{ number_format($booking->total_price, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Payment Method</strong></td>
                <td>{{ strtoupper($booking->payment->payment_method ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>{{ ucfirst($booking->payment->status ?? 'Pending') }}</td>
            </tr>
        </table>

        <div class="panel">
            <h3>Important Information</h3>
            <ul>
                <li>Check-in time: 2:00 PM</li>
                <li>Check-out time: 12:00 PM</li>
                <li>Please bring a valid ID for check-in</li>
                <li>Free Wi-Fi is available throughout the hotel</li>
            </ul>
        </div>

        <p style="text-align: center;">
            <a href="{{ route('booking.detail', $booking->bookingDetail->id) }}" class="button">View Booking Details</a>
        </p>

        <p>If you need to modify your reservation or have any questions, please contact us at {{ config('mail.from.address') }}.</p>

        <p>We look forward to welcoming you!</p>

        <p>Warm regards,<br>The {{ $booking->branch->team->name }} Team</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ $booking->branch->team->name }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
