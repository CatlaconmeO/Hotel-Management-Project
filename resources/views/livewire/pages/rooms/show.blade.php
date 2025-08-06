@extends('layouts.app')

@section('content')
    {{-- Custom styles for this view --}}
    <style>
        :root {
             --primary-color: #3B82F6;
        }
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
        }
        .amenity-icon {
            @apply w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-[var(--primary-color)];
        }
        .date-input {
            @apply w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
        .room-image {
            @apply rounded-xl object-cover w-full h-full transition-all duration-300 hover:scale-105;
        }
    </style>

    {{-- Hero Section --}}
    <section class="hero-bg bg-cover bg-center h-96 md:h-[500px] flex items-center relative">
        <div class="container mx-auto px-4 relative z-10 text-center text-white">
            @if(isset($room))
                <h1 class="text-4xl md:text-5xl font-bold mb-3 text-[var(--primary-color)]">{{ $room->roomType->name }} — {{ $room->room_number }}</h1>
                <p class="text-lg md:text-xl opacity-90 text-[var(--primary-color)]">{{ $room->branch->team->name }} › {{ $room->branch->name }}</p>
            @else
                <h1 class="text-4xl md:text-5xl font-bold mb-3 text-[var(--primary-color)]">{{ $title ?? 'Welcome' }}</h1>
                <p class="text-lg md:text-xl opacity-90 text-[var(--primary-color)]">{{ $subtitle ?? '' }}</p>
            @endif
        </div>
    </section>

    {{-- Main Content with Sidebar Layout --}}
    <main class="py-12 md:py-16 lg:py-20">
        <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8 xl:gap-12">
            {{-- Left Column: Room Details --}}
            <div class="lg:col-span-2">
                {{-- Price & Basic Info --}}
                <div class="mb-8">
                    <span class="text-3xl font-bold text-[var(--primary-color)]">{{ number_format($room->roomType->price) }}đ</span>
                    <span class="text-[var(--primary-color)] dark:text-[var(--primary-color)] ml-2">/ night</span>
                    <h2 class="text-3xl font-bold mt-3 text-[var(--primary-color)]">{{ $room->roomType->name }}</h2>
                    <div class="flex flex-wrap gap-4 mt-4 text-gray-700 dark:text-gray-300">
                        <span class="flex items-center"><i class="fas fa-ruler-combined mr-2 text-[var(--primary-color)]"></i> {{ $room->roomType->size }} sqm</span>
                        <span class="flex items-center"><i class="fas fa-user-friends mr-2 text-[var(--primary-color)]"></i> {{ $room->roomType->capacity }} Persons</span>
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-10">
                    <h3 class="text-xl font-semibold mb-4 text-[var(--primary-color)]">Room Description</h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! nl2br(e($room->roomType->description)) !!}
                    </p>
                </div>

                {{-- Gallery --}}
                <div class="mb-10">
                    <h3 class="text-xl font-semibold mb-4 text-[var(--primary-color)]">Gallery</h3>
                    <div class="gallery-grid">
                        <div class="aspect-[4/3] overflow-hidden rounded-xl">
                            <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=2070&q=80" alt="Room interior" class="room-image">
                        </div>
                        <div class="aspect-[4/3] overflow-hidden rounded-xl">
                            <img src="https://images.unsplash.com/photo-1582719478460-973c498765d8?auto=format&fit=crop&w=2070&q=80" alt="Bathroom" class="room-image">
                        </div>
                    </div>
                </div>

                {{-- Amenities --}}
                <div class="mb-10">
                    <h3 class="text-xl font-semibold mb-6 text-[var(--primary-color)]">Amenities</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($room->roomType->amenities as $amenity)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="amenity-icon"><i class="fas fa-{{ $amenity->icon }}"></i></div>
                                <span class="text-[var(--primary-color)]">{{ $amenity->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Guest Reviews --}}
                <div>
                    <h3 class="text-xl font-semibold mb-6 text-[var(--primary-color)]">Reviews</h3>
                    @livewire('room-review', ['room' => $room])
                </div>
            </div>

            {{-- Right Column: Sidebar Booking Form --}}
            <aside class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg sticky top-20 p-6">
                    <h3 class="text-xl font-bold mb-6 text-center text-[var(--primary-color)]">Book Your Stay</h3>

                    @auth
                        <form id="bookingForm" action="{{ route('bookings.store', $room) }}" method="POST" x-data="bookingComponent()">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">

                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block mb-2 font-medium text-[var(--primary-color)]">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-[var(--primary-color)] rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]" required>
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 font-medium text-[var(--primary-color)]">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-[var(--primary-color)] rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]" required>
                                </div>
                                <div>
                                    <label for="phone" class="block mb-2 font-medium text-[var(--primary-color)]">Phone</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border border-[var(--primary-color)] rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]" required>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="checkIn" class="block mb-2 font-medium text-[var(--primary-color)]">Check-in</label>
                                        <div class="relative">
                                            <input type="date" id="checkIn" name="check_in_date" class="date-input" min="{{ now()->toDateString() }}" required>
                                            <div class="absolute right-3 top-3 text-[var(--primary-color)]"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="checkOut" class="block mb-2 font-medium text-[var(--primary-color)]">Check-out</label>
                                        <div class="relative">
                                            <input type="date" id="checkOut" name="check_out_date" class="date-input" required>
                                            <div class="absolute right-3 top-3 text-[var(--primary-color)]"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Price Summary --}}
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                                <div class="flex justify-between mb-2">
                                    <span class="total h7">Total Price</span>
                                    <span class="price h7" x-text="formattedTotal">₫0</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-[var(--primary-color)] hover:bg-opacity-90 text-white font-bold py-3 px-4 rounded-lg transition mt-6">
                                Book Now
                            </button>
                        </form>
                    @else
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                            <p class="mb-4 text-[var(--primary-color)]">Please login to continue</p>
                            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-[var(--primary-color)] text-white rounded-lg font-medium hover:bg-opacity-90 transition">Login</a>
                        </div>
                    @endauth

                    {{-- Need Help --}}
                    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <h4 class="font-bold mb-3 text-[var(--primary-color)]">Need help?</h4>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">Our customer service is available 24/7 to assist with your booking.</p>
                        <div class="flex items-center text-[var(--primary-color)] font-medium"><i class="fas fa-phone-alt mr-2"></i> +1 (800) 123-4567</div>
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
                        const amount = this.nights > 0 ? this.total : this.basePrice;
                        return `${amount.toLocaleString('vi-VN')}đ`;
                    }
                }
            }
        </script>
    </main>
@endsection
