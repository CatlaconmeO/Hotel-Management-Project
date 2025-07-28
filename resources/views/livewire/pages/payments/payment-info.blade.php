{{-- resources/views/payments/info.blade.php --}}
@extends('layouts.app')

@section('content')

    {{-- Main Section --}}
    <section class="relative p-[60px_0] lg:p-[80px_0] bg-gray-50">
        <div class="container mx-auto">
            {{-- Booking Card --}}
            <div class="bg-white rounded-[10px] shadow-lg overflow-hidden booking-card mb-[60px]">
                <div class="p-[30px] lg:p-[40px]">
                    <div class="flex justify-between items-start mb-[30px]">
                        <div>
                            <h2 class="text-2xl font-semibold text-heading mb-1">Booking #{{ $booking->id }}</h2>
                            <p class="text-sm text-body">{{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y') }}</p>
                        </div>
                        <span class="status-badge
              {{ $booking->status === 'paid'    ? 'bg-green-100 text-green-800'  : '' }}
              {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800': '' }}
              {{ $booking->status === 'failed'  ? 'bg-red-100 text-red-800'      : '' }}">
              {{ ucfirst($booking->status) }}
            </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-[30px] mb-[30px]">
                        {{-- Guest Info --}}
                        <div>
                            <h3 class="text-sm font-medium text-body mb-3">Guest Information</h3>
                            <p class="text-base text-heading">{{ $booking->bookingDetail->name }}</p>
                            <p class="text-sm text-body">{{ $booking->bookingDetail->email }}</p>
                            <p class="text-sm text-body">{{ $booking->bookingDetail->phone }}</p>
                        </div>
                        {{-- Stay Details --}}
                        <div>
                            <h3 class="text-sm font-medium text-body mb-3">Stay Details</h3>
                            <div class="space-y-2 text-base text-heading">
                                <div class="flex justify-between">
                                    <span class="text-body">Check-in</span>
                                    <span>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-body">Check-out</span>
                                    <span>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-body">Nights</span>
                                    <span>{{ $booking->getNightsAttribute() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-[#E5E5E5] pt-[30px]">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-heading">Total Amount</span>
                            <span class="text-3xl font-bold text-primary">
                {{ number_format($booking->total_price * 1000, 0, ',', '.') }} ₫
              </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="space-y-[20px]">
                @if($booking->status === 'pending')
                    <form action="{{ route('payments.process', $booking) }}" method="POST" class="w-full">
                        @csrf
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white rounded-[6px] font-medium hover:bg-primary-dark transition"
                        >
                            <i class="fas fa-credit-card"></i>
                            Proceed to Payment
                        </button>
                    </form>
                @else
                    <a
                        href="{{ route('home') }}"
                        class="w-full block text-center px-6 py-3 bg-heading text-white rounded-[6px] font-medium hover:bg-gray-800 transition"
                    >
                        <i class="fas fa-home mr-2"></i>
                        Return to Homepage
                    </a>
                @endif
            </div>

            {{-- Support --}}
            <p class="mt-[40px] text-center text-sm text-body">
                Need help?
                <a href="#" class="text-primary hover:underline">Contact our support team</a>
            </p>
        </div>
    </section>
@endsection
