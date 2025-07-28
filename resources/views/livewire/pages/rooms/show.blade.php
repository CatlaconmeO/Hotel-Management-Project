@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <div class="relative bg-[url('{{ asset('images/pages/header_bg.webp') }}')] bg-cover bg-center h-[500px] flex items-center">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="container mx-auto relative z-10 text-center text-white px-4">
            @if(isset($room))
                <h1 class="text-5xl font-extrabold drop-shadow-lg">{{ $room->roomType->name }} — {{ $room->room_number }}</h1>
                <p class="mt-3 text-lg opacity-75">{{ $room->branch->team->name }} &rsaquo; {{ $room->branch->name }}</p>
            @else
                <h1 class="text-5xl font-extrabold drop-shadow-lg">{{ $title ?? 'Welcome' }}</h1>
                <p class="mt-3 text-lg opacity-75">{{ $subtitle ?? '' }}</p>
            @endif
        </div>
    </div>

    {{-- Main Content --}}
    <div class="relative p-[100px_0] lg:p-[120px_0]">
        <div class="container">
            <div class="flex justify-between gap-[30px] flex-wrap lg:flex-nowrap">

                {{-- Left: room details --}}
                <div class="details__content max-w-[820px]">
                    <span class="block h4 heading text-primary leading-none">{{ number_format($room->roomType->price) }}đ</span>
                    <h2 class="heading text-heading mt-[15px]">{{ $room->roomType->name }}</h2>
                    <div class="flex gap-[20px] items-center mt-2 mb-3 text-[24px] font-glida">
                        <span class="flex gap-2"><i class="flaticon-construction"></i>{{ $room->roomType->size }} sqm</span>
                        <span class="flex gap-2"><i class="flaticon-user"></i>{{ $room->roomType->capacity }} Person</span>
                    </div>
                    <p class="text-sm">
                        {!! nl2br(e($room->roomType->description)) !!}
                    </p>
                    <div class="flex max-w-max gap-[30px] mt-[50px] mb-[50px] flex-wrap md:flex-nowrap">
                        <div><img class="rounded-[6px]" src="assets/images/pages/room/r-d-1.webp" alt=""></div>
                        <div><img class="rounded-[6px]" src="assets/images/pages/room/r-d-2.webp" alt=""></div>
                    </div>

                    <span class="h4 block mb-[25px] text-heading">Room Amenities</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px] mb-[20px] pb-[20px] border-b-[0.5px] border-[rgba(101,103,107,0.3)] text-[20px]">
{{--                        @foreach($room->roomType->amenities->chunk(3) as $chunk)--}}
{{--                            @foreach($chunk as $amenity)--}}
{{--                                <div class="flex gap-[30px] items-center text-heading font-glida">--}}
{{--                                    <img src="{{ asset('assets/images/icon/' . $amenity->icon) }}" height="30" width="36" alt="">--}}
{{--                                    <span>{{ $amenity->name }}</span>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        @endforeach--}}
                    </div>

                    <span class="h4 block text-heading mb-[40px]">Room Features</span>
                    <img class="rounded-[6px] h-[revert-layer]" src="assets/images/pages/room/r-d-3.webp" height="520" alt="">
                    <div class="group-row mt-[50px] mb-[20px]">
                        <ul class="grid list-none grid-cols-1 md:grid-cols-2 lg:grid-cols-3 text-[20px] text-heading font-glida">
{{--                            @foreach($room->roomType->features as $feature)--}}
{{--                                <li class="relative pl-[30px] mb-[20px] before:absolute before:content-[''] before:top-[50%] before:left-0 before:w-[10px] before:h-[10px] before:rounded-[50%] before:bg-primary before:translate-y-[-50%]">--}}
{{--                                    {{ $feature }}--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
                        </ul>
                    </div>
                </div>

            {{-- Right: booking form --}}
            <aside class="sidebar__content lg:max-w-[420px] lg:min-w-[420px] w-full">
                @auth
                    <div class="bg-gray dark:bg-[#1B1B1B] dark:text-white p-[30px] rounded-[10px] relative z-10 dark:shadow-none">
                        <h5 class="heading text-heading text-center mb-[30px] mt-[5px]">Book Your Stay</h5>

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <ul class="list-disc list-inside text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('bookings.store', $room) }}" method="POST" x-data="bookingComponent()">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <input type="hidden" name="total_amount" :value="totalAmount">

                            <div class="grid gap-[30px]">
                                {{-- Name --}}
                                <div class="flex justify-between relative w-full p-[14px_20px] bg-white dark:bg-[#1B1B1B] rounded-[6px]">
                                    <label for="name" class="block text-[20px] font-glida text-heading dark:text-white">Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Your Name"
                                           class="relative z-10 w-[100%] ml-[20px] bg-white dark:bg-[#1B1B1B] p-[0_5px] outline-none @error('name') border-red-500 @enderror" required>
                                </div>

                                {{-- Email --}}
                                <div class="flex justify-between relative w-full p-[14px_20px] bg-white dark:bg-[#1B1B1B] rounded-[6px]">
                                    <label for="email" class="block text-[20px] font-glida text-heading dark:text-white">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                                           class="relative z-10 w-[100%] ml-[20px] bg-white dark:bg-[#1B1B1B] p-[0_5px] outline-none @error('email') border-red-500 @enderror" required>
                                </div>

                                {{-- Phone --}}
                                <div class="flex justify-between relative w-full p-[14px_20px] bg-white dark:bg-[#1B1B1B] rounded-[6px]">
                                    <label for="phone" class="block text-[20px] font-glida text-heading dark:text-white">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+123 456 7890"
                                           class="relative z-10 w-[100%] ml-[20px] bg-white dark:bg-[#1B1B1B] p-[0_5px] outline-none @error('phone') border-red-500 @enderror" required>
                                </div>

                                {{-- Check In --}}
                                <div class="flex justify-between relative w-full p-[14px_20px] bg-white dark:bg-[#1B1B1B] rounded-[6px]">
                                    <label for="check_in_date" class="block text-[20px] font-glida text-heading dark:text-white">Check In</label>
                                    <div class="relative min-w-[160px] max-w-[160px]">
                                        <input x-model="checkIn" type="date" id="check_in_date" name="check_in_date"
                                               class="relative z-10 w-[100%] ml-[20px] bg-white dark:bg-[#1B1B1B] p-[0_5px] outline-none @error('check_in_date') border-red-500 @enderror" required>
                                        <div class="absolute w-[100%] left-0 top-[2px] before:absolute before:content-['\f122'] before:font-flaticon before:right-[20px] before:top-0 before:bottom-0 dark:text-white text-heading z-1">
                                            <i class="flaticon-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- Check Out --}}
                                <div class="flex justify-between relative w-full p-[14px_20px] bg-white dark:bg-[#1B1B1B] rounded-[6px]">
                                    <label for="check_out_date" class="block text-[20px] font-glida text-heading dark:text-white">Check Out</label>
                                    <div class="relative min-w-[160px] max-w-[160px]">
                                        <input x-model="checkOut" type="date" id="check_out_date" name="check_out_date"
                                               class="relative z-10 w-[100%] ml-[20px] bg-white dark:bg-[#1B1B1B] p-[0_5px] outline-none @error('check_out_date') border-red-500 @enderror" required>
                                        <div class="absolute w-[100%] left-0 top-[2px] before:absolute before:content-['\f122'] before:font-flaticon before:right-[20px] before:top-0 before:bottom-0 dark:text-white text-heading z-1">
                                            <i class="flaticon-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Price --}}
                            <div class="total__price flex justify-between border-t-[1px] border-[#e5e5e5] pt-[20px] mt-[20px]">
                                <span class="total h6 mb-0 text-heading">Total Price</span>
                                <span class="price h6 m-0 text-heading" x-text="formattedTotal">₫0</span>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="theme-btn btn-style fill no-border search__btn !py-3 rounded-[6px] w-full mt-[20px]" data-wow-delay=".6s">
                                <span>Process to Payment</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                        <p class="mb-4">Please login to continue</p>
                        <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary-dark transition">
                            Login
                        </a>
                    </div>
                @endauth
            </aside>
        </div>
    </div>

    <script>
        function bookingComponent() {
            return {
                checkIn: null,
                checkOut: null,
                basePrice: {{ intval($room->roomType->price) }},

                get nights() {
                    if (!this.checkIn || !this.checkOut) return 0;
                    const inD  = new Date(this.checkIn);
                    const outD = new Date(this.checkOut);
                    const diff = (outD - inD) / (1000 * 60 * 60 * 24);
                    return diff > 0 ? Math.ceil(diff) : 0;
                },

                get total() {
                    return this.nights * this.basePrice;
                },

                get formattedTotal() {
                    const amount = this.nights > 0 ? this.total : this.basePrice;
                    return `${amount.toLocaleString('vi-VN')}đ`;
                }
            }
        }
    </script>
@endsection
