@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-12 md:py-20">
        {{-- Header --}}
        <div class="mb-12 text-center animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Discover Our Hotels</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Find your perfect stay with our curated collection of premium accommodations
            </p>
        </div>

        {{-- Search Section --}}
        <div class="mb-12 animate-fade-in-up delay-100">
            <div class="max-w-4xl mx-auto bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden p-6 md:p-8">
                <form method="GET" action="{{ route('hotels.index') }}" class="flex flex-row items-center gap-4">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search by hotel name, location, amenities..."
                            class="w-full py-4 pl-12 pr-4 text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        />
                    </div>
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-4 px-6 rounded-lg transition transform hover:scale-105 flex items-center justify-center"
                    >
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                </form>
{{--                <div class="flex flex-wrap gap-2 mt-4 px-2">--}}
{{--                    <span class="text-xs text-gray-500">Popular searches:</span>--}}
{{--                    @foreach(['Beachfront','Luxury','Family-friendly','City center'] as $tag)--}}
{{--                        <button type="button" class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full transition">{{ $tag }}</button>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
            </div>
        </div>

        {{-- Content --}}
        @if(!$search)
            {{-- Show all hotels when no search term --}}
            <div class="mb-6 animate-fade-in-up delay-300">
                <p class="text-gray-600">
                    Showing all available hotels ({{ $hotels->count() }} results)
                </p>
            </div>

            {{-- Hotel Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-fade-in-up delay-400" id="hotelGrid">
                @foreach($hotels as $hotel)
                    <div class="hotel-card group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 flex flex-col h-full">
                        <!-- Image Container -->
                        <div class="relative h-56 overflow-hidden">
                            <img
                                src="{{ asset($hotel->image) }}"
                                alt="{{ $hotel->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                            <!-- Price Badge -->
                            @if($hotel->roomTypes && $hotel->roomTypes->count() > 0)
                                <div class="absolute top-3 right-3">
                        <span class="bg-indigo-600 text-white text-xs font-medium px-3 py-1 rounded-full shadow-lg">
                            From {{ number_format($hotel->roomTypes->min('price'), 0, ',', '.') }}₫
                        </span>
                                </div>
                            @endif

                            <!-- Location Badge -->
                            <div class="absolute bottom-3 left-3">
                    <span class="bg-black/50 text-white text-xs px-2 py-1 rounded-md backdrop-blur-sm flex items-center">
                        <i class="fas fa-map-marker-alt mr-1 text-indigo-300"></i>
                        {{ $hotel->address }}
                    </span>
                            </div>
                        </div>

                        <!-- Content Container -->
                        <div class="p-5 flex flex-col flex-grow">
                            <!-- Hotel Name and Rating -->
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $hotel->name }}</h3>
                                <div class="flex items-center">
                                    @php
                                        $reviews = $hotel->reviews()->exists() ? $hotel->reviews : collect();
                                        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;
                                        $formattedRating = number_format($averageRating, 1);
                                    @endphp
                                    <span class="text-amber-500 text-sm font-medium">{{ $formattedRating }}</span>
                                    <i class="fas fa-star ml-1 text-amber-400 text-sm"></i>
                                    <span class="text-gray-500 text-xs ml-2">({{ $reviews->count() }})</span>
                                </div>
                            </div>

                            <!-- Features/Amenities -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($hotel->branches as $branch)
                                    <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                            {{ $branch->name }}
                        </span>
                                @endforeach

                                @if($hotel->amenities && $hotel->amenities->count() > 0)
                                    @foreach($hotel->amenities->take(2) as $amenity)
                                        <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                {{ $amenity->name }}
                            </span>
                                    @endforeach
                                    @if($hotel->amenities->count() > 2)
                                        <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                +{{ $hotel->amenities->count() - 2 }}
                            </span>
                                    @endif
                                @endif
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-grow">
                                {{ Str::limit($hotel->description, 120) }}
                            </p>

                            <!-- Room Availability -->
                            @if($hotel->rooms && $hotel->rooms->count() > 0)
                                <div class="mb-4 text-xs text-green-600 flex items-center">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ $hotel->rooms->count() }} rooms available
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                <a href="{{ route('hotels.show', $hotel) }}"
                                   class="bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-semibold py-2 px-5 rounded-lg transition">
                                    View Details
                                </a>
                                <button class="p-2 text-gray-500 hover:text-red-500 transition">
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($hotels->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $hotels->withQueryString()->links() }}
                </div>
            @endif
        @else
            @if($hotels->count() > 0)
                <div class="mb-6 animate-fade-in-up delay-300">
                    <p class="text-gray-600">
                        Search results for "<span class="font-semibold">{{ $search }}</span>"
                        ({{ $hotels->count() }} results)
                    </p>
                </div>

                {{-- Hotel Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-fade-in-up delay-400" id="hotelGrid">
                    @foreach($hotels as $hotel)
                        <div class="hotel-card group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 flex flex-col h-full">
                            <!-- Image Container -->
                            <div class="relative h-56 overflow-hidden">
                                <img
                                    src="{{ asset($hotel->image) }}"
                                    alt="{{ $hotel->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                                <!-- Price Badge -->
                                @if($hotel->roomTypes && $hotel->roomTypes->count() > 0)
                                    <div class="absolute top-3 right-3">
                        <span class="bg-indigo-600 text-white text-xs font-medium px-3 py-1 rounded-full shadow-lg">
                            From {{ number_format($hotel->roomTypes->min('price'), 0, ',', '.') }}₫
                        </span>
                                    </div>
                                @endif

                                <!-- Location Badge -->
                                <div class="absolute bottom-3 left-3">
                    <span class="bg-black/50 text-white text-xs px-2 py-1 rounded-md backdrop-blur-sm flex items-center">
                        <i class="fas fa-map-marker-alt mr-1 text-indigo-300"></i>
                        {{ $hotel->address }}
                    </span>
                                </div>
                            </div>

                            <!-- Content Container -->
                            <div class="p-5 flex flex-col flex-grow">
                                <!-- Hotel Name and Rating -->
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $hotel->name }}</h3>
                                    <div class="flex items-center">
                                        @php
                                            $reviews = $hotel->reviews()->exists() ? $hotel->reviews : collect();
                                            $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;
                                            $formattedRating = number_format($averageRating, 1);
                                        @endphp
                                        <span class="text-amber-500 text-sm font-medium">{{ $formattedRating }}</span>
                                        <i class="fas fa-star ml-1 text-amber-400 text-sm"></i>
                                        <span class="text-gray-500 text-xs ml-2">({{ $reviews->count() }})</span>
                                    </div>
                                </div>

                                <!-- Features/Amenities -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($hotel->branches as $branch)
                                        <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                            {{ $branch->name }}
                        </span>
                                    @endforeach

                                    @if($hotel->amenities && $hotel->amenities->count() > 0)
                                        @foreach($hotel->amenities->take(2) as $amenity)
                                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                {{ $amenity->name }}
                            </span>
                                        @endforeach
                                        @if($hotel->amenities->count() > 2)
                                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                +{{ $hotel->amenities->count() - 2 }}
                            </span>
                                        @endif
                                    @endif
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-grow">
                                    {{ Str::limit($hotel->description, 120) }}
                                </p>

                                <!-- Room Availability -->
                                @if($hotel->rooms && $hotel->rooms->count() > 0)
                                    <div class="mb-4 text-xs text-green-600 flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        {{ $hotel->rooms->count() }} rooms available
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                    <a href="{{ route('hotels.show', $hotel) }}"
                                       class="bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-semibold py-2 px-5 rounded-lg transition">
                                        View Details
                                    </a>
                                    <button class="p-2 text-gray-500 hover:text-red-500 transition">
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($hotels->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $hotels->withQueryString()->links() }}
                    </div>
                @endif
            @else
                {{-- No Results --}}
                <div class="text-center py-16 animate-fade-in-up delay-300">
                    <!-- Existing no results content -->
                </div>
            @endif
        @endif
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        /* Animations */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        @keyframes pulseSlow { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        .animate-pulse-slow { animation: pulseSlow 3s ease-in-out infinite; }
        @keyframes shake { 0%,100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
        .animate-shake { animation: shake 0.5s ease-in-out infinite; }
    </style>
@endpush
