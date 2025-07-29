@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-[#1B4965]">Booking Details</h1>
            <a href="{{ route('bookings.history')}}" class="flex items-center text-[#1B4965] hover:underline text-sm font-medium">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Back to Booking History
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Booking Meta -->
            <div class="bg-gradient-to-r from-[#1B4965] to-[#5FA8D3] p-6 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">Booking #BD{{ $bookingDetail->id }}</h2>
                        <p class="text-blue-100 mt-1">Created on {{ $bookingDetail->created_at->format('d F, Y') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-white text-[#1B4965]">
                        <x-heroicon-o-check-circle class="w-4 h-4 mr-2" />
                        {{ ucfirst($bookingDetail->booking->status) }}
                    </span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Customer Info -->
                <div>
                    <div class="flex items-center mb-4 text-[#1B4965]">
                        <x-heroicon-o-user class="w-5 h-5 mr-2 text-[#5FA8D3]" />
                        <h3 class="text-xl font-semibold">Customer Information</h3>
                    </div>
                    <div class="space-y-2 pl-8">
                        <p><strong>Name:</strong> {{ $bookingDetail->booking->customer->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $bookingDetail->booking->customer->email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $bookingDetail->booking->customer->phone ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Hotel Info -->
                <div>
                    <div class="flex items-center mb-4 text-[#1B4965]">
                        <x-heroicon-o-building-office class="w-5 h-5 mr-2 text-[#5FA8D3]" />
                        <h3 class="text-xl font-semibold">Hotel Information</h3>
                    </div>
                    <div class="space-y-2 pl-8">
                        <p><strong>Hotel:</strong> {{ $bookingDetail->booking->branch->team->name ?? 'N/A' }}</p>
                        <p><strong>Branch:</strong> {{ $bookingDetail->booking->branch->name ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $bookingDetail->booking->branch->address ?? 'N/A' }}</p>
                        <p><strong>Room Type:</strong> {{ $bookingDetail->room->roomType->name ?? 'N/A' }} (Room {{ $bookingDetail->room->room_number ?? 'N/A' }})</p>
                    </div>
                </div>

                <!-- Booking Dates -->
                <div>
                    <div class="flex items-center mb-4 text-[#1B4965]">
                        <x-heroicon-o-calendar-days class="w-5 h-5 mr-2 text-[#5FA8D3]" />
                        <h3 class="text-xl font-semibold">Booking Dates</h3>
                    </div>
                    <div class="space-y-2 pl-8">
                        <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($bookingDetail->booking->check_in_date)->format('d/m/Y') }}</p>
                        <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($bookingDetail->booking->check_out_date)->format('d/m/Y') }}</p>
                        <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($bookingDetail->booking->check_in_date)->diffInDays($bookingDetail->booking->check_out_date) }} nights</p>
                    </div>
                </div>

                <!-- Payment Info -->
                <div>
                    <div class="flex items-center mb-4 text-[#1B4965]">
                        <x-heroicon-o-credit-card class="w-5 h-5 mr-2 text-[#5FA8D3]" />
                        <h3 class="text-xl font-semibold">Payment Information</h3>
                    </div>
                    <div class="space-y-2 pl-8">
                        <p><strong>Total:</strong> ${{ number_format($bookingDetail->booking->total_price, 2) }}</p>
                        <p><strong>Payment:</strong> {{ strtoupper($bookingDetail->booking->payment->payment_method ?? 'Unknown') }}</p>
                        <p><strong>Status:</strong> <span class="text-green-600">{{ ucfirst($bookingDetail->booking->payment->status ?? 'Unpaid') }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-gray-200 p-6 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex gap-2">
                    <!-- Cancel -->
                    <form method="POST" action="{{ route('bookings.cancel', $bookingDetail->booking->id) }}"
                          onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center px-4 py-2 rounded border border-red-300 text-red-600 hover:bg-red-50 transition">
                            <x-heroicon-o-x-circle class="w-5 h-5 mr-2" />
                            Cancel Booking
                        </button>
                    </form>
                    @if ($bookingDetail->booking->status !== 'completed' && $bookingDetail->booking->status !== 'cancelled')
                        <form action="{{ route('bookings.cancel', $bookingDetail->booking->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                            @csrf
                            @method('DELETE')
                            <button class="flex items-center px-4 py-2 rounded border border-red-300 text-red-600 hover:bg-red-50 transition">
                                <x-heroicon-o-x-circle class="w-5 h-5 mr-2" />
                                Cancel Booking
                            </button>
                        </form>
                    @endif

                    <!-- Check-in -->
                    <form method="POST" action="{{ route('bookings.checkin', $bookingDetail->booking->id) }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center px-4 py-2 rounded border border-green-300 text-green-600 hover:bg-green-50 transition">
                            <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-2" />
                            Check-in
                        </button>
                    </form>
                </div>

                <div class="flex gap-2">
                    <!-- Print -->
{{--                    <button onclick="window.print()"--}}
{{--                            class="flex items-center px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100 transition">--}}
{{--                        <x-heroicon-o-printer class="w-5 h-5 mr-2" />--}}
{{--                        Print Receipt--}}
{{--                    </button>--}}
                    <a href="{{ route('bookings.invoice.pdf', $bookingDetail->booking->id) }}"
                       class="flex items-center px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 text-sm">
                        <x-heroicon-o-document-arrow-down class="w-5 h-5 mr-2" />
                        Download Invoice (PDF)
                    </a>

                    <!-- Send -->
                    <form action="{{ route('bookings.sendConfirmation', ['booking' => $bookingDetail->booking->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-2 rounded bg-[#1B4965] text-white hover:bg-[#163f56] transition">
                            <x-heroicon-o-envelope class="w-5 h-5 mr-2" />
                            Send Confirmation
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-8 bg-white rounded-xl shadow-md">
            <div class="border-b border-gray-200 p-6 flex items-center text-[#1B4965]">
                <x-heroicon-o-information-circle class="w-5 h-5 mr-2 text-[#5FA8D3]" />
                <h3 class="text-xl font-semibold">Additional Information</h3>
            </div>
            <div class="p-6 text-sm text-gray-600 space-y-4">
                <p>Your booking has been confirmed. We look forward to welcoming you to our hotel. Please don’t hesitate to contact us if you have any special requests or questions.</p>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 flex items-start gap-3">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-blue-500" />
                    <span>Check-in time is from 2:00 PM. Early check-in may be available upon request and subject to availability.</span>
                </div>
            </div>
        </div>
    </div>
@endsection
