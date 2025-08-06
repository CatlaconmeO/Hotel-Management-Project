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
                <div class="flex flex-wrap gap-2 mt-4 px-2">
                    <span class="text-xs text-gray-500">Popular searches:</span>
                    @foreach(['Beachfront','Luxury','Family-friendly','City center'] as $tag)
                        <button type="button" class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full transition">{{ $tag }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="mb-8 flex flex-wrap gap-4 justify-center animate-fade-in-up delay-200">
            @foreach([
                ['label'=>'All Locations','options'=>['Hanoi','Ho Chi Minh','Da Nang','Nha Trang']],
                ['label'=>'Any Price','options'=>['$0 - $50','$50 - $100','$100 - $200','$200+']],
                ['label'=>'Any Rating','options'=>['5 Stars','4 Stars','3 Stars']],
            ] as $filter)
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                        <option>{{ $filter['label'] }}</option>
                        @foreach($filter['options'] as $opt)
                            <option>{{ $opt }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
            @endforeach
            <button class="bg-white border border-gray-300 rounded-lg px-4 py-2 hover:bg-gray-50 transition flex items-center animate-pulse-slow">
                <i class="fas fa-sliders-h mr-2 text-gray-600"></i>
                <span>More Filters</span>
            </button>
        </div>

        {{-- Content --}}
        @if(!$search)
            <div class="text-center py-16 animate-fade-in-up delay-300">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-search text-blue-500 text-3xl animate-bounce"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">Find Your Perfect Stay</h3>
                    <p class="text-gray-600 mb-6">Search for hotels by name, location, or amenities to discover our wide selection of accommodations.</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach([['icon'=>'fa-umbrella-beach','label'=>'Beach Resorts'],['icon'=>'fa-city','label'=>'City Hotels'],['icon'=>'fa-mountain','label'=>'Mountain Lodges'],['icon'=>'fa-spa','label'=>'Spa Retreats']] as $cat)
                            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer flex flex-col items-center">
                                <i class="fas {{ $cat['icon'] }} text-blue-500 text-2xl mb-2"></i>
                                <p class="text-sm font-medium">{{ $cat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
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
                        <div class="hotel-card group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform group-hover:scale-105 transition duration-500">
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ asset($hotel->logo) }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute top-3 right-3 bg-white/80 rounded-full w-10 h-10 flex items-center justify-center shadow-md">
                                    <i class="fas fa-heart text-gray-600 hover:text-red-500 transition"></i>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $hotel->name }}</h3>
                                    <p class="text-gray-500 text-sm flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1 text-indigo-500"></i>
                                        {{ $hotel->address }}
                                    </p>
                                </div>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($hotel->description, 120) }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('hotels.show', $hotel) }}" class="bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-semibold py-2 px-5 rounded-lg transition transform hover:-translate-y-1">
                                        View Details
                                    </a>
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
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-3xl animate-shake"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-3">No Results Found</h3>
                        <p class="text-gray-600 mb-6">We couldn't find any hotels matching your search. Try adjusting your filters or search for something different.</p>
                        <button onclick="document.querySelector('input[name=search]').value=''; document.querySelector('form').submit();" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition transform hover:-translate-y-0.5">
                            Clear Search
                        </button>
                    </div>
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
