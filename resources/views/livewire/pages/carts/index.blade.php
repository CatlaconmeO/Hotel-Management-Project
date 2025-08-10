@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-10 md:py-12">
        {{-- Header --}}
        <div class="mb-8 text-center animate-fade-in-up">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">Your cart</h1>
            <p class="mt-2 text-gray-600">Reviews your cart before payment</p>
        </div>

        @if($cart->items->count() > 0)
            <div class="grid lg:grid-cols-3 gap-6 animate-fade-in-up delay-200">
                {{-- Left: Items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart->items as $item)
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 hover:shadow-md transition-all overflow-hidden">
                            <div class="flex flex-col md:flex-row gap-5 p-5">
                                {{-- Image --}}
                                <div class="md:w-48 w-full">
                                    <div class="relative h-48 md:h-36 rounded-xl overflow-hidden group">
                                        <img
                                            src="{{ asset($item->room->image) }}"
                                            alt="Ảnh phòng {{ $item->room->name }}"
                                            class="w-full h-full object-cover transform group-hover:scale-105 duration-500"
                                            loading="lazy"
                                            referrerpolicy="no-referrer"
                                        >
                                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                                        <span class="text-white text-xs font-medium px-2 py-0.5 rounded-full bg-white/10 backdrop-blur">
                                            {{ $item->room->roomType->name ?? 'Standard Room' }}
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->room->name }}</h3>
                                            <span class="inline-flex items-center self-start sm:self-auto bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                            <i class="fa-solid fa-location-dot mr-1.5"></i>
                                            {{ $item->room->branch->name ?? 'Main Branch' }}
                                        </span>
                                        </div>

                                        <p class="mt-2 text-sm leading-6 text-gray-600">
                                            {{ Str::limit($item->room->description ?? 'Phòng ấm cúng, đủ tiện nghi cho kỳ lưu trú thoải mái.', 140) }}
                                        </p>

                                        {{-- Amenities --}}
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            @if(isset($item->room->roomType->amenities) && $item->room->roomType->amenities->count() > 0)
                                                @foreach($item->room->roomType->amenities as $amenity)
                                                    <span class="inline-flex items-center text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">
                                                    <i class="fa-solid fa-check text-green-500 mr-1.5"></i>{{ $amenity->name }}
                                                </span>
                                                @endforeach
                                            @else
                                                <span class="inline-flex items-center text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">
                                                <i class="fa-solid fa-wifi mr-1.5"></i>Wi‑Fi
                                            </span>
                                                <span class="inline-flex items-center text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">
                                                <i class="fa-regular fa-snowflake mr-1.5"></i>Điều hòa
                                            </span>
                                                <span class="inline-flex items-center text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">
                                                <i class="fa-solid fa-tv mr-1.5"></i>TV
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Stay info --}}
                                    <div class="mt-4 flex flex-wrap gap-3">
                                        <div class="flex items-center gap-2 bg-indigo-50 px-3 py-2 rounded-lg">
                                            <i class="fa-regular fa-calendar-check text-indigo-500"></i>
                                            <div>
                                                <div class="text-[11px] uppercase tracking-wide text-indigo-600 font-medium">Check‑in</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->check_in_date->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 bg-indigo-50 px-3 py-2 rounded-lg">
                                            <i class="fa-regular fa-calendar-xmark text-indigo-500"></i>
                                            <div>
                                                <div class="text-[11px] uppercase tracking-wide text-indigo-600 font-medium">Check‑out</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->check_out_date->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 bg-indigo-50 px-3 py-2 rounded-lg">
                                            <i class="fa-regular fa-moon text-indigo-500"></i>
                                            <div>
                                                <div class="text-[11px] uppercase tracking-wide text-indigo-600 font-medium">Nights</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->nights }} night(s)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pricing + Remove --}}
                                <div class="md:w-56 border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-5 flex flex-col justify-between">
                                    <div>
                                        <div>
                                            <p class="text-xs text-gray-500">Price per nights</p>
                                            <p class="text-lg font-bold text-gray-900">{{ number_format($item->price, 0) }}₫</p>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-500">Total price ({{ $item->nights }} nights)</p>
                                            <p class="text-xl font-bold text-indigo-600">{{ number_format($item->total_price, 0) }}₫</p>
                                        </div>
                                    </div>

                                    <form action="{{ route('carts.remove', $item->id) }}" method="POST" class="mt-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 text-sm font-medium text-red-600 hover:text-red-700 border border-red-200 hover:border-red-300 rounded-lg py-2 px-3 transition focus:outline-none focus:ring-2 focus:ring-red-200"
                                                aria-label="Delete {{ $item->room->name }} from cart">
                                            <i class="fa-solid fa-trash-can"></i>
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Right: Summary --}}
                <aside class="lg:col-span-1">
                    <div class="lg:sticky lg:top-6 space-y-4">
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6">
                            <h4 class="text-base font-semibold text-gray-900 mb-4">Billing Information</h4>

                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-700">Total Price</span>
                                <span class="text-lg font-semibold">{{ number_format($cart->total, 0) }}₫</span>
                            </div>

                            <div class="my-4 border-t border-gray-100"></div>

                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">Tổng cộng</span>
                                <span class="text-2xl font-extrabold text-indigo-600">
                                {{ number_format($cart->total, 0) }}₫
                            </span>
                            </div>

                            {{-- Actions --}}
                            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <a href="{{ route('hotels.index') }}"
                                   class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-gray-200">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    Find Booking
                                </a>

                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-medium py-3 px-4 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-amber-300">
                                        <i class="fa-solid fa-trash"></i>
                                        Clear Cart
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </aside>
            </div>
        @else
            {{-- Empty state --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-12 text-center animate-fade-in-up delay-200">
                <div class="mx-auto w-20 h-20 rounded-full bg-indigo-50 flex items-center justify-center mb-6">
                    <i class="fa-solid fa-cart-shopping text-3xl text-indigo-400"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900">Your cart is empty</h3>
                <p class="mt-2 text-gray-600 max-w-md mx-auto">
                    Explore and enjoy your holiday with us.
                </p>
                <a href="{{ route('hotels.index') }}"
                   class="mt-6 inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 text-white font-medium py-3 px-6 rounded-xl transition focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <i class="fa-solid fa-compass"></i>
                    Explore our hotels
                </a>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp .5s ease-out both; }
        .delay-100 { animation-delay: .1s }
        .delay-200 { animation-delay: .2s }
    </style>
@endpush
