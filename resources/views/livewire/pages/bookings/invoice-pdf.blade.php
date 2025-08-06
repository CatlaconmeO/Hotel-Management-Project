<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $booking->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #1B4965;
            padding: 30px;
        }
        h1 { font-size: 24px; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; width: 150px; display: inline-block; }
        .value { display: inline-block; }
        .total { font-size: 18px; font-weight: bold; text-align: right; margin-top: 30px; }
        .border { border-top: 1px solid #ccc; margin: 20px 0; }
    </style>
</head>
<body>
<h1>Invoice #{{ $booking->id }}</h1>

<div class="section">
    <p><span class="label">Date:</span> {{ now()->format('d/m/Y') }}</p>
    <p><span class="label">Customer:</span> {{ $booking->customer->name }}</p>
    <p><span class="label">Email:</span> {{ $booking->customer->email }}</p>
</div>

<div class="border"></div>

<div class="section">
    <p><span class="label">Hotel:</span> {{ $booking->branch->team->name }}</p>
    <p><span class="label">Branch:</span> {{ $booking->branch->name }}</p>
    <p><span class="label">Room:</span> {{ $booking->room->roomType->name ?? 'N/A' }} ({{ $booking->bookingDetail->room->room_number ?? '' }})</p>
    <p><span class="label">Check-in:</span> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</p>
    <p><span class="label">Check-out:</span> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</p>
    <p><span class="label">Nights:</span> {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }}</p>
</div>

<div class="border"></div>

<div class="total">
    Total: ${{ number_format($booking->bookingDetail->price) }}
</div>
</body>
</html>
