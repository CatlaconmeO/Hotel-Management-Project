@extends('layouts.app')

@section('content')
    {{-- Custom styles for this view --}}
    <style>
        :root {
            --primary-color: #3B82F6;
            --secondary-color: #1E40AF;
        }
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-position: center;
            background-size: cover;
        }
        .amenity-icon {
            @apply w-12 h-12 flex items-center justify-center rounded-full bg-blue-50 dark:bg-gray-800 text-[var(--primary-color)] shadow-sm;
        }
        .date-input {
            @apply w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: 200px 200px;
            gap: 1rem;
        }
        .gallery-grid > div:first-child {
            grid-column: span 2;
            grid-row: span 2;
        }
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(3, 200px);
            }
            .gallery-grid > div:first-child {
                grid-column: span 1;
                grid-row: span 1;
            }
        }
        .room-image {
            @apply rounded-xl object-cover w-full h-full transition-all duration-300 hover:scale-[1.03] shadow-md;
        }
        .section-title {
            @apply text-m font-semibold mb-6 text-[var(--primary-color)] border-b pb-3 border-gray-200 dark:border-gray-700;
        }
        .feature-tag {
            @apply px-3 py-1 bg-blue-50 text-[var(--primary-color)] rounded-full text-sm font-medium;
        }
        .booking-card {
            @apply bg-white dark:bg-gray-800 rounded-2xl shadow-lg sticky top-20 p-6 border border-gray-100 dark:border-gray-700;
        }
    </style>

    {{-- Hero Section with Parallax Effect --}}
    <section class="hero-bg bg-fixed h-96 md:h-[500px] flex items-center relative">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center text-white">
            @if(isset($room))
                <span class="inline-block bg-[var(--primary-color)] text-white px-4 py-2 rounded-full text-sm mb-4">Available Now</span>
                <h1 class="text-4xl md:text-5xl font-bold mb-3 text-white">{{ $room->roomType->name }} — {{ $room->room_number }}</h1>
                <p class="text-lg md:text-xl opacity-90 text-gray-200">{{ $room->branch->team->name }} › {{ $room->branch->name }}</p>
            @else
                <h1 class="text-4xl md:text-5xl font-bold mb-3 text-white">{{ $title ?? 'Welcome' }}</h1>
                <p class="text-lg md:text-xl opacity-90 text-gray-200">{{ $subtitle ?? '' }}</p>
            @endif
        </div>
    </section>

    {{-- Main Content with Sidebar Layout --}}
    <main class="py-12 md:py-16 lg:py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8 xl:gap-12">
            {{-- Left Column: Room Details --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Price & Basic Info --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <div class="flex flex-wrap items-center justify-between mb-6">
                        <div>
                            <span class="text-3xl font-bold text-[var(--primary-color)]">{{ number_format($room->roomType->price) }}đ</span>
                            <span class="text-gray-500 dark:text-gray-400 ml-2">/ night</span>
                        </div>
                        <div class="flex gap-2 mt-2 sm:mt-0">
                            <span class="feature-tag"><i class="fas fa-user-friends mr-1"></i> {{ $room->roomType->bed_count*2 }} Persons</span>
                            <span class="feature-tag"><i class="fas fa-star mr-1"></i>{{ $room->averageRating() }}/5</span> ({{ $room->reviews->count('rating') }} reviews)
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">{{ $room->roomType->name }}</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! nl2br(e($room->roomType->description)) !!}
                    </p>
                </div>

                {{-- Gallery --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <h3 class="section-title">Gallery</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @if($room->image)
                            <div class="overflow-hidden rounded-xl aspect-video">
                                <img src="{{ $room->image }}" alt="{{ $room->name }}" class="room-image">
                            </div>
                        @else
                            <div class="flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-xl aspect-video">
                                <p class="text-gray-500 dark:text-gray-400">No room image</p>
                            </div>
                        @endif

                        @if($room->roomType->image)
                            <div class="overflow-hidden rounded-xl aspect-video">
                                <img src="{{ $room->roomType->image }}" alt="{{ $room->roomType->name }}" class="room-image">
                            </div>
                        @else
                            <div class="flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-xl aspect-video">
                                <p class="text-gray-500 dark:text-gray-400">No room type image</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Amenities --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <h3 class="section-title">Amenities & Features</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($room->roomType->amenities as $amenity)
                            <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg transition-transform hover:scale-[1.02]">
                                @if(isset($amenity->icon) && $amenity->icon)
                                    <div class="amenity-icon">
                                        <img src="{{ $amenity->icon }}" alt="{{ $amenity->name }}" class="w-6 h-6 object-cover">
                                    </div>
                                @else
                                    <div class="amenity-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                @endif
                                <span class="text-gray-800 dark:text-gray-100 font-medium">{{ $amenity->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Guest Reviews --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <h3 class="section-title">Guest Reviews</h3>
                    @livewire('room-review', ['room' => $room])
                </div>
            </div>

            {{-- Right Column: Sidebar Booking Form --}}
            <aside class="lg:col-span-1">
                <div class="booking-card">
                    <h3 class="text-xl font-bold mb-6 text-center text-gray-800 dark:text-white border-b pb-4 border-gray-100 dark:border-gray-700">Book Your Stay</h3>

                    @auth
                        <form id="bookingForm" action="{{ route('bookings.store', $room) }}" method="POST" x-data="bookingComponent()">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">

                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]" required>
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]" required>
                                </div>
                                <div>
                                    <label for="phone" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]" required>
                                </div>

                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="checkIn" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Check-in</label>
                                        <div class="relative">
                                            <input type="date" id="checkIn" name="check_in_date" x-model="checkIn" class="date-input" min="{{ now()->toDateString() }}" required>
                                            <div class="absolute right-3 top-3 text-gray-500"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="checkOut" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Check-out</label>
                                        <div class="relative">
                                            <input type="date" id="checkOut" name="check_out_date" x-model="checkOut" class="date-input" :min="checkIn || '{{ now()->toDateString() }}'" required>
                                            <div class="absolute right-3 top-3 text-gray-500"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Price Summary --}}
                            <div class="mt-6 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <span>Base price</span>
                                    <span>{{ number_format($room->roomType->price) }}đ / night</span>
                                </div>
                                <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <span>Nights</span>
                                    <span x-text="nights"></span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4 flex justify-between font-bold">
                                    <span class="text-gray-800 dark:text-gray-200">Total Price</span>
                                    <span class="text-[var(--primary-color)]" x-text="formattedTotal"></span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <button type="submit" class="bg-[var(--primary-color)] hover:bg-[var(--secondary-color)] text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center">
                                    <i class="fas fa-calendar-check mr-2"></i> Book Now
                                </button>

                                <button type="button"
                                        @click="addToCart()"
                                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center">
                                    <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                </button>
                            </div>

                        </form>

                        <form id="add-to-cart-form" action="{{ route('carts.addItem', $room) }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="check_in_date" id="cart_check_in_date">
                            <input type="hidden" name="check_out_date" id="cart_check_out_date">
                        </form>

                    @else
                        <div class="bg-blue-50 dark:bg-gray-700 p-6 rounded-xl text-center">
                            <div class="text-5xl text-[var(--primary-color)] mb-4"><i class="fas fa-user-lock"></i></div>
                            <p class="mb-4 text-gray-700 dark:text-gray-300">Please login to continue with your booking</p>
                            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-[var(--primary-color)] text-white rounded-lg font-medium hover:bg-[var(--secondary-color)] transition">Login</a>
                        </div>
                    @endauth

                    {{-- Need Help --}}
                    <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-xl p-5">
                        <h4 class="font-bold mb-3 text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-headset mr-2 text-[var(--primary-color)]"></i> Need help?
                        </h4>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 text-sm">Our customer service team is available 24/7 to assist you with your booking</p>
                        <a href="tel:+18001234567" class="flex items-center text-[var(--primary-color)] font-medium hover:underline">
                            <i class="fas fa-phone-alt mr-2"></i> +1 (800) 123-4567
                        </a>
                    </div>
                </div>
            </aside>
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
                        const amount = this.nights > 0 ? this.total : 0;
                        return `${amount.toLocaleString('vi-VN')}đ`;
                    },

                    addToCart() {
                        if (!this.checkIn || !this.checkOut) {
                            alert('Please select check-in and check-out dates');
                            return;
                        }

                        document.getElementById('cart_check_in_date').value = this.checkIn;
                        document.getElementById('cart_check_out_date').value = this.checkOut;
                        document.getElementById('add-to-cart-form').submit();
                    }
                }
            }
        </script>
    </main>
@endsection
