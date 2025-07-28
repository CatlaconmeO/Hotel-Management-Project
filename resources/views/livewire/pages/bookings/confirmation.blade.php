@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-16 px-4">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
            <h2 class="text-3xl font-semibold mb-6 text-center">Booking Confirmation</h2>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <ul class="space-y-4 text-gray-700">
                <li><strong>Booking ID:</strong> {{ $booking->id }}</li>
                <li><strong>Customer:</strong> {{ $booking->customer->name }} ({{ $booking->customer->email }})</li>
                <li><strong>Hotel:</strong> {{ $booking->branch->team->name }}</li>
                <li><strong>Branch:</strong> {{ $booking->branch->name }}</li>
                @php $detail = $booking->details->first(); @endphp
                <li><strong>Room:</strong>
                    {{ $detail->room->roomType->name }} — {{ $detail->room->room_number }}
                </li>
                <li>
                    <strong>Check In:</strong>
                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                </li>
                <li>
                    <strong>Check Out:</strong>
                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}
                </li>
                <li><strong>Total Price:</strong> {{ number_format($booking->total_price) }}₫</li>
            </ul>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}"
                   class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
@endsection
