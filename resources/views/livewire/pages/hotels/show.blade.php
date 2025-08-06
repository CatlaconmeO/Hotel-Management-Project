{{-- resources/views/hotels/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-12 lg:py-16 font-sans">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Main Content --}}
            <div class="flex-1">
                {{-- Hotel Header --}}
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                        {{ $hotel->name }}@if(optional($currentBranch))-> {{ $currentBranch->name }}@endif
                    </h1>
                    <div class="flex flex-wrap gap-4 text-gray-600 mb-4">
                        @if(optional($currentBranch)->address)
                            <span class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-blue-500"></i>
                                {{ $currentBranch->address }}
                            </span>
                        @endif
                        @if(optional($currentBranch)->phone)
                            <span class="flex items-center gap-2">
                                <i class="fas fa-phone-alt text-blue-500"></i>
                                {{ $currentBranch->phone }}
                            </span>
                        @endif
                        @if(optional($currentBranch)->email)
                            <span class="flex items-center gap-2">
                                <i class="fas fa-envelope text-blue-500"></i>
                                {{ $currentBranch->email }}
                            </span>
                        @endif
                    </div>
                    @if($hotel->rating)
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($hotel->rating >= $i)
                                        <i class="fas fa-star"></i>
                                    @elseif($hotel->rating > $i - 1)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-gray-600">
                                {{ number_format($hotel->rating, 1) }} ({{ $hotel->reviews_count ?? 0 }} reviews)
                            </span>
                        </div>
                    @endif
                    <p class="text-gray-700 leading-relaxed mb-6">
                        {{ $hotel->description }}
                    </p>
                </div>

                {{-- Image Gallery --}}
                @if($hotel->gallery && $hotel->gallery->count())
                    <div class="mb-12">
                        <div class="relative h-64 md:h-80 lg:h-96 rounded-xl overflow-hidden mb-4">
                            <img
                                id="main-image"
                                src="{{ asset('storage/' . $hotel->gallery->first()->path) }}"
                                alt="Gallery Image"
                                class="w-full h-full object-cover transition duration-500"
                            >
                            <button class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                                <i class="fas fa-heart text-gray-600 hover:text-red-500"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($hotel->gallery as $image)
                                <div
                                    class="gallery-thumbnail cursor-pointer"
                                    onclick="changeMainImage('{{ asset('storage/' . $image->path) }}')"
                                >
                                    <img
                                        src="{{ asset('storage/' . $image->path) }}"
                                        alt="Thumbnail"
                                        class="w-full h-20 object-cover rounded-lg"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Branch Navigation --}}
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Our Branches</h3>
                    <div class="flex flex-wrap border-b border-gray-200">
                        @foreach($hotel->branches as $branch)
                            <button
                                class="branch-tab px-4 py-2 font-medium mr-4 transition duration-200 {{ $branch->id == $branchId ? 'active text-blue-600 pb-2 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }}"
                            >
                                {{ $branch->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Room Grid --}}
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Available Rooms</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($rooms as $room)
                            <div class="room-card bg-white rounded-xl shadow-md overflow-hidden transition duration-300 hover:shadow-lg">
                                <div class="relative h-48">
                                    <img
                                        src="{{ $room->image ? asset('storage/' . $room->image) : asset('images/default-room.jpg') }}"
                                        alt="{{ $room->roomType->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold mb-1">{{ $room->roomType->name }}</h4>
                                        <p class="text-sm text-gray-600 mb-3">
                                            {{ $room->roomType->bed_count ?? 0 }} beds • {{ ($room->roomType->bed_count * 2) ?? 0 }} persons
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xl font-bold text-blue-600">
                                                {{ number_format($room->roomType->price, 0, ',', '.') }} ₫/24h
                                            </p>
                                            <p class="text-xs text-gray-500">+ taxes & fees</p>
                                        </div>
                                        <a
                                            href="{{ route('rooms.show', ['hotel' => $hotel, 'branch' => $currentBranch, 'room' => $room]) }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300"
                                        >
                                            Room Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-500 py-8">No rooms available.</p>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($rooms instanceof Illuminate\Contracts\Pagination\Paginator && $rooms->lastPage() > 1)
                        <div class="mt-12 flex justify-center">
                            <nav class="flex items-center space-x-2">
                                {{-- Previous Page --}}
                                @if($rooms->onFirstPage())
                                    <button class="px-3 py-1 rounded border border-gray-300 text-gray-400" disabled>
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                @else
                                    <a href="{{ $rooms->appends(['branch' => $branchId])->previousPageUrl() }}">
                                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                    </a>
                                @endif

                                {{-- Page Number Links --}}
                                @foreach(range(1, $rooms->lastPage()) as $page)
                                    @if($page == $rooms->currentPage())
                                        <button class="px-3 py-1 rounded bg-blue-600 text-white">{{ $page }}</button>
                                    @elseif($page == 1 || $page == $rooms->lastPage() || ($page >= $rooms->currentPage() - 2 && $page <= $rooms->currentPage() + 2))
                                        <a href="{{ $rooms->appends(['branch' => $branchId])->url($page) }}">
                                            <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">{{ $page }}</button>
                                        </a>
                                    @elseif($page == $rooms->currentPage() - 3 || $page == $rooms->currentPage() + 3)
                                        <span class="px-2">&hellip;</span>
                                    @endif
                                @endforeach

                                {{-- Next Page --}}
                                @if($rooms->hasMorePages())
                                    <a href="{{ $rooms->appends(['branch' => $branchId])->nextPageUrl() }}">
                                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </a>
                                @else
                                    <button class="px-3 py-1 rounded border border-gray-300 text-gray-400" disabled>
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                @endif
                            </nav>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Change main gallery image
        function changeMainImage(src) {
            document.getElementById('main-image').src = src;
            document.querySelectorAll('.gallery-thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
                if (thumb.querySelector('img').src === src) {
                    thumb.classList.add('active');
                }
            });
        }

        // Branch tab switching (AJAX placeholder)
        document.querySelectorAll('.branch-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.branch-tab').forEach(t => t.classList.remove('active', 'text-blue-600'));
                tab.classList.add('active', 'text-blue-600');
                // TODO: Load branch-specific content via AJAX
                alert(`Loading ${tab.textContent} branch details...`);
            });
        });

        // Initialize first thumbnail
        document.querySelectorAll('.gallery-thumbnail')[0]?.classList.add('active');
    </script>
@endpush
