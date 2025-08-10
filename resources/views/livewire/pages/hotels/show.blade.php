@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-12 lg:py-16 font-sans">
        {{-- Breadcrumbs --}}
        <nav class="flex mb-8 text-sm">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-indigo-600">Home</a></li>
                <li><span class="mx-2 text-gray-400">/</span></li>
                <li><a href="{{ route('hotels.index') }}" class="text-gray-500 hover:text-indigo-600">Hotels</a></li>
                <li><span class="mx-2 text-gray-400">/</span></li>
                <li class="text-indigo-600 font-medium">{{ $hotel->name }}</li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Main Content --}}
            <div class="flex-1">
                {{-- Hotel Header --}}
                <div class="mb-8">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                            {{ $hotel->name }}
                            @if(optional($currentBranch))
                                <span class="text-xl text-indigo-600">• {{ $currentBranch->name }}</span>
                            @endif
                        </h1>

                        <div class="flex items-center gap-2">
                            <button class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-700">
                                <i class="far fa-heart"></i>
                                <span>Save</span>
                            </button>
                            <button class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-700">
                                <i class="fas fa-share-alt"></i>
                                <span>Share</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 text-gray-600 mb-6">
                        @if(optional($currentBranch)->address)
                            <span class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-indigo-500"></i>
                                {{ $currentBranch->address }}
                            </span>
                        @endif
                        @if(optional($currentBranch)->phone)
                            <span class="flex items-center gap-2">
                                <i class="fas fa-phone-alt text-indigo-500"></i>
                                {{ $currentBranch->phone }}
                            </span>
                        @endif
                        @if(optional($currentBranch)->email)
                            <span class="flex items-center gap-2">
                                <i class="fas fa-envelope text-indigo-500"></i>
                                {{ $currentBranch->email }}
                            </span>
                        @endif
                    </div>

                    @php
                        $reviews = $hotel->reviews()->exists() ? $hotel->reviews : collect();
                        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;
                        $formattedRating = number_format($averageRating, 1);
                    @endphp

                    <div class="flex items-center mb-6">
                        <div class="flex text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($averageRating >= $i)
                                    <i class="fas fa-star"></i>
                                @elseif($averageRating > $i - 1)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600">
                            {{ $formattedRating }} ({{ $reviews->count() }} reviews)
                        </span>
                    </div>

                    {{-- Tags/Amenities --}}
                    @if($hotel->amenities && $hotel->amenities->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($hotel->amenities as $amenity)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs rounded-full">
                                    {{ $amenity->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">About This Hotel</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $hotel->description }}
                        </p>
                    </div>
                </div>

                {{-- Image Gallery --}}
                <div class="mb-12">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Hotel Gallery</h3>
                    <div class="relative h-80 md:h-96 rounded-xl overflow-hidden mb-4 shadow-lg">
                        <img
                            id="main-image"
                            src="{{ $hotel->image }}"
                            alt="{{ $hotel->name }}"
                            class="w-full h-full object-cover transition duration-500"
                        >
                    </div>

{{--                    <div class="grid grid-cols-4">--}}
{{--                        --}}{{-- Show main image as first thumbnail --}}
{{--                        <div--}}
{{--                            class="gallery-thumbnail cursor-pointer active ring-2 ring-indigo-500"--}}
{{--                            onclick="changeMainImage('{{ asset($hotel->image) }}')"--}}
{{--                        >--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                {{-- Branch Navigation --}}
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Our Branches</h3>
                    <div class="flex flex-wrap border-b border-gray-200 mb-6">
                        @foreach($hotel->branches as $branch)
                            <a
                                href="{{ route('hotels.show', ['hotel' => $hotel, 'branch' => $branch->id]) }}"
                                class="branch-tab px-4 py-2 font-medium mr-4 transition duration-200
                                    {{ $branch->id == $branchId ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}"
                            >
                                {{ $branch->name }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Branch Info --}}
                    @if($currentBranch)
                        <div class="bg-white rounded-xl p-6 border border-gray-200 mb-8">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-building text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium">{{ $currentBranch->name }} </h4>
                                    <p class="text-sm text-gray-600">{{ $currentBranch->address }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-2 items-center">
                                        <i class="fas fa-phone text-indigo-500"></i>
                                        <span>{{ $currentBranch->phone ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <i class="fas fa-envelope text-indigo-500"></i>
                                        <span>{{ $currentBranch->email ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-2 items-center">
                                        <i class="fas fa-clock text-indigo-500"></i>
                                        <span>Check-in: 2:00 PM - Check-out: 12:00 PM</span>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <i class="fas fa-info-circle text-indigo-500"></i>
                                        <span>{{ $currentBranch->rooms->where('status', 'available')->count() }} rooms available</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Room Grid --}}
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Available Rooms</h3>
                        <div class="text-sm text-indigo-600">
                            Showing {{ $rooms->where('status', 'available')->count() }} of {{ $currentBranch->rooms->where('status', 'available')->count() }} rooms available
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($rooms->where('status', 'available') as $room)
                            <div class="room-card bg-white rounded-xl shadow-md overflow-hidden transition duration-300 hover:shadow-lg border border-gray-100">
                                <div class="relative h-48">
                                    <img
                                        src="{{ $room->image ? asset($room->image) : asset('images/default-room.jpg') }}"
                                        alt="{{ $room->roomType->name ?? 'Room' }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    >
                                    @if($room->roomType)
                                        <div class="absolute top-3 right-3 bg-indigo-600 text-white text-xs font-medium px-3 py-1 rounded-full shadow-lg">
                                            {{ number_format($room->roomType->price, 0, ',', '.') }}₫/night
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold mb-2">{{ $room->roomType->name ?? 'Standard Room' }}</h4>

                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @if(isset($room->roomType->bed_count))
                                                <span class="text-xs bg-gray-100 px-2 py-1 rounded-full flex items-center">
                                                    <i class="fas fa-bed text-gray-500 mr-1"></i>
                                                    {{ $room->roomType->bed_count }} beds
                                                </span>
                                            @endif

                                            @if(isset($room->roomType->bed_count))
                                                <span class="text-xs bg-gray-100 px-2 py-1 rounded-full flex items-center">
                                                    <i class="fas fa-user text-gray-500 mr-1"></i>
                                                    {{ ($room->roomType->bed_count * 2) }} persons
                                                </span>
                                            @endif

                                            @if($room->roomType && $room->roomType->amenities && $room->roomType->amenities->isNotEmpty())
                                                <span class="text-xs bg-gray-100 px-2 py-1 rounded-full flex items-center">
                                                    <i class="fas fa-wifi text-gray-500 mr-1"></i>
                                                    {{ $room->roomType->amenities->first()->name }}
                                                </span>
                                            @endif
                                        </div>

                                        @if($room->description)
                                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                                {{ Str::limit($room->description, 42) }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        @if($room->roomType)
                                            <div>
                                                <p class="text-xl font-bold text-indigo-600">
                                                    {{ number_format($room->roomType->price, 0, ',', '.') }}₫
                                                </p>
                                                <p class="text-xs text-gray-500">Per night • Includes taxes</p>
                                            </div>
                                        @endif

                                        <a
                                            href="{{ route('rooms.show', ['hotel' => $hotel, 'branch' => $currentBranch, 'room' => $room]) }}"
                                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 text-sm font-medium"
                                        >
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-gray-50 rounded-xl p-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-bed text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-medium text-gray-800 mb-2">No rooms available</h3>
                                <p class="text-gray-600">Please check back later or try another branch</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if( $currentBranch->rooms->where('status', 'available')->count() > 6  && $rooms->lastPage() > 1)
                        <div class="mt-12">
                            <nav class="flex items-center justify-center">
                                <ul class="flex items-center gap-1">
                                    {{-- Previous Page --}}
                                    @if($rooms->onFirstPage())
                                        <li>
                                            <span class="px-3 py-2 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                                                <i class="fas fa-chevron-left text-sm"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $rooms->appends(['branch' => $branchId])->previousPageUrl() }}"
                                               class="px-3 py-2 rounded border border-gray-200 text-gray-600 hover:bg-gray-50">
                                                <i class="fas fa-chevron-left text-sm"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @php
                                        $startPage = max($rooms->currentPage() - 2, 1);
                                        $endPage = min($rooms->currentPage() + 2, $rooms->lastPage());
                                    @endphp

                                    @if($startPage > 1)
                                        <li>
                                            <a href="{{ $rooms->appends(['branch' => $branchId])->url(1) }}"
                                               class="px-3 py-2 rounded border border-gray-200 text-gray-600 hover:bg-gray-50">
                                                1
                                            </a>
                                        </li>
                                        @if($startPage > 2)
                                            <li><span class="px-2 text-gray-400">...</span></li>
                                        @endif
                                    @endif

                                    @for($i = $startPage; $i <= $endPage; $i++)
                                        <li>
                                            @if($i == $rooms->currentPage())
                                                <span class="px-3 py-2 rounded bg-indigo-600 text-white">
                                                    {{ $i }}
                                                </span>
                                            @else
                                                <a href="{{ $rooms->appends(['branch' => $branchId])->url($i) }}"
                                                   class="px-3 py-2 rounded border border-gray-200 text-gray-600 hover:bg-gray-50">
                                                    {{ $i }}
                                                </a>
                                            @endif
                                        </li>
                                    @endfor

                                    @if($endPage < $rooms->lastPage())
                                        @if($endPage < $rooms->lastPage() - 1)
                                            <li><span class="px-2 text-gray-400">...</span></li>
                                        @endif
                                        <li>
                                            <a href="{{ $rooms->appends(['branch' => $branchId])->url($rooms->lastPage()) }}"
                                               class="px-3 py-2 rounded border border-gray-200 text-gray-600 hover:bg-gray-50">
                                                {{ $rooms->lastPage() }}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Next Page --}}
                                    @if($rooms->hasMorePages())
                                        <li>
                                            <a href="{{ $rooms->appends(['branch' => $branchId])->nextPageUrl() }}"
                                               class="px-3 py-2 rounded border border-gray-200 text-gray-600 hover:bg-gray-50">
                                                <i class="fas fa-chevron-right text-sm"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span class="px-3 py-2 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                                                <i class="fas fa-chevron-right text-sm"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        .gallery-thumbnail.active {
            @apply ring-2 ring-indigo-500;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function changeMainImage(src) {
            document.getElementById('main-image').src = src;
            document.querySelectorAll('.gallery-thumbnail').forEach(thumb => {
                thumb.classList.remove('active', 'ring-2', 'ring-indigo-500');
                if (thumb.querySelector('img').src === src) {
                    thumb.classList.add('active', 'ring-2', 'ring-indigo-500');
                }
            });
        }
    </script>
@endpush
