@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        {{-- Header --}}
        <div class="flex flex-row items-center justify-between mb-8 gap-4 animate-fade-in">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Booking Details</h1>
                <p class="text-gray-500 mt-1">View and manage your booking information</p>
            </div>
            <a href="{{ route('bookings.history') }}" class="flex items-center text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Booking History
            </a>
        </div>


        {{-- Booking Card --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 animate-fade-in delay-100">
            <div class="gradient-bg p-6 text-white">
                <div class="gradient-bg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <!-- Phần trái -->
                        <div>
                            <h2 class="text-2xl font-bold">Booking #BDML{{ $bookingDetail->id }}</h2>
                            <p class="text-white/90 mt-1">
                                Created on {{ $bookingDetail->created_at->format('d F, Y - h:i A') }}
                            </p>
                        </div>
                        <!-- Phần trạng thái -->
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold shadow-sm
                            {{ match($bookingDetail->booking->status->value) {
                                'confirmed' => 'bg-green-100 text-green-800 border border-green-200',
                                'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                'cancelled' => 'bg-red-100 text-red-800 border border-red-200',
                                'refunded' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                default => 'bg-white text-blue-600 border border-blue-200'
                            } }}">
                            <i class="{{ match($bookingDetail->booking->status->value) {
                                'confirmed' => 'fas fa-check-circle text-green-600',
                                'pending' => 'fas fa-clock text-yellow-600',
                                'cancelled' => 'fas fa-times-circle text-red-600',
                                'refunded' => 'fas fa-flag-checkered text-blue-600',
                                default => 'fas fa-info-circle text-blue-600'
                            } }} mr-2"></i>
                            {{ ucfirst($bookingDetail->booking->status->value) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Customer Info --}}
                <div class="info-card bg-gray-50 p-4 rounded-lg border border-gray-100 animate-fade-in delay-200">
                    <div class="flex items-center mb-4 text-blue-600">
                        <i class="fas fa-user mr-2"></i>
                        <h3 class="text-lg font-semibold">Customer Information</h3>
                    </div>
                    <div class="space-y-3 pl-8 text-gray-700">
                        <x-display-item label="Name" :value="$bookingDetail->booking->customer->name" />
                        <x-display-item label="Email" :value="$bookingDetail->booking->customer->email" />
                        <x-display-item label="Phone" :value="$bookingDetail->booking->customer->phone" />
                    </div>
                </div>

                {{-- Hotel Info --}}
                <div class="info-card bg-gray-50 p-4 rounded-lg border border-gray-100 animate-fade-in delay-200">
                    <div class="flex items-center mb-4 text-blue-600">
                        <i class="fas fa-hotel mr-2"></i>
                        <h3 class="text-lg font-semibold">Hotel Information</h3>
                    </div>
                    <div class="space-y-3 pl-8 text-gray-700">
                        <x-display-item label="Hotel" :value="$bookingDetail->booking->branch->team->name" />
                        <x-display-item label="Branch" :value="$bookingDetail->booking->branch->name" />
                        <x-display-item label="Address" :value="$bookingDetail->booking->branch->address" />
                        <x-display-item label="Room Type" :value="$bookingDetail->room->roomType->name . ' (Room ' . $bookingDetail->room->room_number . ')'" />
                    </div>
                </div>

                {{-- Booking Dates --}}
                <div class="info-card bg-gray-50 p-4 rounded-lg border border-gray-100 animate-fade-in delay-300">
                    <div class="flex items-center mb-4 text-blue-600">
                        <i class="fas fa-calendar-days mr-2"></i>
                        <h3 class="text-lg font-semibold">Booking Dates</h3>
                    </div>
                    <div class="space-y-3 pl-8 text-gray-700">
                        <x-display-item label="Check-in" :value="\Carbon\Carbon::parse($bookingDetail->booking->check_in_date)->format('d/m/Y')" />
                        <x-display-item label="Check-out" :value="\Carbon\Carbon::parse($bookingDetail->booking->check_out_date)->format('d/m/Y')" />
                        <x-display-item label="Duration" :value="\Carbon\Carbon::parse($bookingDetail->booking->check_in_date)->diffInDays($bookingDetail->booking->check_out_date) . ' nights'" />
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="info-card bg-gray-50 p-4 rounded-lg border border-gray-100 animate-fade-in delay-300">
                    <div class="flex items-center mb-4 text-blue-600">
                        <i class="fas fa-credit-card mr-2"></i>
                        <h3 class="text-lg font-semibold">Payment Information</h3>
                    </div>
                    <div class="space-y-3 pl-8 text-gray-700">
                        <x-display-item label="Total" :value="'$' . number_format($bookingDetail->price)" />
                        <x-display-item label="Payment Method" :value="strtoupper($bookingDetail->booking->payment->payment_method ?? 'Unknown')" />
                        <x-display-item label="Status" :value="ucfirst($bookingDetail->booking->payment->status->value ?? 'Unpaid')" />
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="border-t border-gray-200 p-6 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4 animate-fade-in delay-400">
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    @if ($bookingDetail->booking->status->value !== 'cancelled')
                        <form action="{{ route('bookings.cancel', $bookingDetail->booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                            @csrf @method('DELETE')
                            <button class="flex items-center px-4 py-2 rounded border border-red-300 text-red-600 hover:bg-red-50 hover:border-red-400 transition">
                                <i class="fas fa-times-circle mr-2"></i> Cancel Booking
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('bookings.checkin', $bookingDetail->booking->id) }}">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-2 rounded border border-green-300 text-green-600 hover:bg-green-50 hover:border-green-400 transition">
                            <i class="fas fa-sign-in-alt mr-2"></i> Check-in
                        </button>
                    </form>

                    <form method="POST" action="{{ route('bookings.checkout', $bookingDetail->booking->id) }}">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-2 rounded border border-purple-300 text-purple-600 hover:bg-purple-50 hover:border-purple-400 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Check-out
                        </button>
                    </form>
                </div>

                <div class="flex flex-wrap gap-2 w-full sm:w-auto mt-4 sm:mt-0">
                    <a href="{{ route('bookings.invoice.pdf', $bookingDetail->booking->id) }}" class="flex items-center px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 text-sm text-gray-700">
                        <i class="fas fa-file-pdf mr-2 text-blue-600"></i> Download Invoice (PDF)
                    </a>
                    <form action="{{ route('bookings.sendConfirmation', ['booking' => $bookingDetail->booking->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                            <i class="fas fa-envelope mr-2"></i> Send Confirmation
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Additional Info --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden animate-fade-in delay-400">
            <div class="border-b border-gray-200 p-6 flex items-center text-blue-600">
                <i class="fas fa-info-circle mr-2"></i>
                <h3 class="text-xl font-semibold">Additional Information</h3>
            </div>
            <div class="p-6 text-sm text-gray-700 space-y-4">
                <p>Your booking has been confirmed. We look forward to welcoming you to our hotel. Please don't hesitate to contact us if you have any special requests or questions.</p>
                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 flex items-start gap-3 rounded">
                    <i class="fas fa-exclamation-triangle text-blue-600 mt-1"></i>
                    <span>Check-in time is from 2:00 PM. Early check-in may be available upon request and subject to availability.</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Animation & Styling --}}
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
            .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
            .delay-400 { animation-delay: 0.4s; }
            .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
            .info-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); }
        </style>
    @endpush
@endsection
