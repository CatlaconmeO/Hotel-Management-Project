{{-- resources/views/hotels/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <!-- Hotel & Branch Details -->
    <div class="container mx-auto py-[100px] lg:py-[120px]">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Main Details --}}
            <div class="flex-1">
                <h2 class="text-3xl font-bold mb-2">{{ $hotel->name }} - {{ optional($currentBranch)->name }}</h2>

                @if($currentBranch)
                    <div class="flex flex-wrap gap-4 text-lg mb-6">
                        @if($currentBranch->address)
                            <span class="flex items-center gap-2">
                                <i class="flaticon-marker"></i>
                                {{ $currentBranch->address }}
                            </span>
                        @endif
                        @if($currentBranch->phone)
                            <span class="flex items-center gap-2">
                                <i class="flaticon-phone-flip"></i>
                                {{ $currentBranch->phone }}
                            </span>
                        @endif
                        @if(isset($currentBranch->email))
                            <span class="flex items-center gap-2">
                                <i class="flaticon-envelope"></i>
                                {{ $currentBranch->email }}
                            </span>
                        @endif
                    </div>
                @endif

                <p class="text-gray-700 mb-8">{{ $hotel->description }}</p>

                {{-- Logo / Gallery --}}
                <div class="flex gap-6 mb-12">
                    @if($hotel->logo)
                        <img
                            src="{{ asset('storage/' . $hotel->logo) }}"
                            alt="{{ $hotel->name }}"
                            class="w-1/3 rounded-md object-cover"
                        />
                    @endif
                </div>

                {{-- Branch Navigation --}}
                <ul class="flex flex-wrap mb-6">
                    @foreach($hotel->branches as $branch)
                        <li class="mr-6 mb-2">
                            <a
                                href="{{ route('hotels.show', ['hotel' => $hotel->id, 'branch' => $branch->id]) }}"
                                class="font-medium px-4 py-2 {{ $branch->id == $branchId ? 'pb-2 border-b-2 border-primary text-primary' : 'text-gray-600 hover:text-primary transition' }}"
                            >
                                {{ $branch->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- Room Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @forelse($rooms as $room)
                        <div
                            class="bg-white border rounded-lg shadow hover:shadow-lg transition duration-300 overflow-hidden flex flex-col">
                            {{-- Room Image --}}
                            <div class="relative h-40">
                                <img
                                    src="{{ $room->image ? asset('storage/' . $room->image) : asset('images/default-room.jpg') }}"
                                    alt="{{ $room->name }}"
                                    class="w-full h-full object-cover"
                                />
                            </div>

                            {{-- Room Details --}}
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold mb-1">{{ $room->roomType->name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        {{ $room->roomType->bed_count ?? '-' }} beds
                                        &bull; {{ ($room->roomType->bed_count * 2) ?? '-' }} person
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold mb-4">{{ number_format($room->roomType->price, 0, ',', '.') }}
                                        ₫/24h</p>
                                    <a
                                        href="{{ route('rooms.show', ['hotel' => $hotel, 'branch' => $currentBranch, 'room' => $room]) }}"
                                        class="w-full inline-block bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition duration-300 text-center"
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
                @if($rooms instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="mb-12">
                        {{ $rooms->appends(['branch' => $branchId])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
