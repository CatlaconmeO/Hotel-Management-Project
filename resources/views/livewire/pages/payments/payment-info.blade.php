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
                        <span class="status-badge px-3 py-1 rounded-full text-sm font-medium
                          {{ $booking->status->value === 'confirmed'    ? 'bg-green-100 text-green-800'  : '' }}
                          {{ $booking->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800': '' }}
                          {{ $booking->status->value === 'failed'  ? 'bg-red-100 text-red-800'      : '' }}">
                          {{ ucfirst($booking->status->value) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-[30px] mb-[30px]">
                        <!-- Guest Info -->
                        <div class="bg-gray-50 p-5 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="p-2 rounded-full bg-indigo-100 text-indigo-600 mr-3">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800">Guest Information</h3>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <i class="fas fa-user-circle text-gray-400 mr-2 w-5"></i>
                                    <span class="text-gray-700">{{ $booking->bookingDetail->name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-2 w-5"></i>
                                    <span class="text-gray-700">{{ $booking->bookingDetail->email }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-2 w-5"></i>
                                    <span class="text-gray-700">{{ $booking->bookingDetail->phone }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stay Details -->
                        <div class="bg-gray-50 p-5 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="p-2 rounded-full bg-blue-100 text-blue-600 mr-3">
                                    <i class="fas fa-calendar-alt text-sm"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800">Stay Details</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <i class="fas fa-sign-in-alt text-gray-400 mr-2 w-5"></i>
                                        <span class="text-gray-600">Check-in</span>
                                    </div>
                                    <span
                                        class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <i class="fas fa-sign-out-alt text-gray-400 mr-2 w-5"></i>
                                        <span class="text-gray-600">Check-out</span>
                                    </div>
                                    <span
                                        class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <i class="fas fa-moon text-gray-400 mr-2 w-5"></i>
                                        <span class="text-gray-600">Nights</span>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $booking->getNightsAttribute() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Voucher Section -->
                    @if($booking->status === App\Enums\BookingStatusEnum::Pending)
                        <div class="border-t border-gray-200 pt-6 mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-tag text-indigo-500 mr-2"></i>
                                Voucher Code
                            </h3>

                            @if(!$booking->voucher_id)
                                <!-- Apply Voucher Form -->
                                <form action="{{ route('payments.apply-voucher', $booking) }}" method="POST"
                                      class="voucher-form mb-4 flex gap-3">
                                    @csrf
                                    <input
                                        type="text"
                                        name="code"
                                        id="voucher-code"
                                        class="voucher-input flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                        placeholder="Enter voucher code"
                                        value="{{ old('code') }}"
                                    >
                                    <button
                                        type="submit"
                                        class="apply-btn px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition whitespace-nowrap"
                                        onclick="applyVoucher()"
                                    >
                                        <i class="fas fa-tag mr-2"></i>Apply
                                    </button>
                                </form>
                            @else
                                <!-- Voucher Applied Display -->
                                <div
                                    class="voucher-applied flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-full bg-green-100 text-green-600">
                                            <i class="fas fa-check-circle text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-green-800 font-medium">Voucher
                                                Applied: {{ $booking->voucher->code }}</p>
                                            <p class="text-green-600 text-sm">Discount:
                                                -{{ number_format($booking->getDiscountAmount(), 0, ',', '.') }} ₫</p>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('payments.remove-voucher', $booking) }}"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition"
                                            onclick="removeVoucher()"
                                        >
                                            <i class="fas fa-times mr-1"></i>Remove
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Price Breakdown --}}
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-receipt text-indigo-500 mr-2"></i>
                            Price Breakdown
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span
                                    class="text-gray-600">Room Price{{ ' (' . $booking->getNightsAttribute() . ' nights)' }}</span>
                                <span class="font-medium text-gray-800">{{ number_format($booking->bookingDetail->price, 0, ',', '.') }} ₫</span>
                            </div>

                            @if($booking->voucher_id && $booking->getDiscountAmount() > 0)
                                <div class="flex justify-between items-center text-green-600">
                                    <span>Discount ({{ $booking->voucher->code }})</span>
                                    <span class="font-medium">-{{ number_format($booking->getDiscountAmount(), 0, ',', '.') }} ₫</span>
                                </div>
                            @endif

                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-800">Total Amount</span>
                                    <span class="text-2xl font-bold text-indigo-600">{{ number_format($booking->bookingDetail->price - $booking->getDiscountAmount(), 0, ',', '.') }} ₫</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="space-y-4">
                @if($booking->status === App\Enums\BookingStatusEnum::Pending)
                    <form action="{{ route('payments.process', $booking) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-blue-700 transition-all shadow-md hover:shadow-lg pulse-animation"
                        >
                            <i class="fas fa-credit-card"></i>
                            Proceed to Payment ({{ number_format($finalAmount, 0, ',', '.') }} ₫)
                        </button>
                    </form>
                @else
                    <a
                        href="{{ route('dashboard') }}"
                        class="w-full block text-center px-6 py-4 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-900 transition-all shadow-md"
                    >
                        <i class="fas fa-home mr-2"></i>
                        Return to Homepage
                    </a>
                @endif

                {{-- Support Link --}}
                <div class="text-center mt-8">
                    <p class="text-sm text-gray-500">
                        Need help?
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline">Contact
                            our support team</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Animation for the payment button
        document.querySelectorAll('.pulse-animation').forEach(btn => {
            btn.addEventListener('mouseenter', function () {
                this.classList.remove('pulse-animation');
            });
            btn.addEventListener('mouseleave', function () {
                this.classList.add('pulse-animation');
            });
        });

        function applyVoucher() {
            const voucherInput = document.getElementById('voucher-code');
            if (voucherInput && voucherInput.value.trim() !== '') {
                // Let Blade handle server-side
            }
        }

        function removeVoucher() {
            document.querySelector('.voucher-applied').classList.add('hidden');
            document.querySelector('.apply-btn').classList.remove('hidden');
            document.querySelector('.voucher-form').classList.remove('hidden');
        }
    </script>
@endsection
