@extends('layouts.app')

@section('content')
    <div class="container py-[80px] lg:py-[120px]">
        <div class="mb-[40px] flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-heading capitalize text-[32px] font-semibold">Our Hotels</h2>

            {{-- Search form --}}
            <form method="GET" action="{{ route('hotels.index') }}" class="w-full md:w-1/2">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Tìm theo tên, địa chỉ, email, số điện thoại..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    <button
                        type="submit"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        @if($hotels->count() > 0)
            {{-- Thông báo --}}
            <div class="mb-6">
                @if($search == '')
                    <p class="text-gray-600">
                        Hiện tại có {{ $hotels->count() }} khách sạn được liệt kê.
                        Bạn có thể tìm kiếm theo tên, địa chỉ, email hoặc số điện thoại để tìm khách sạn phù hợp.
                    </p>
                @else
                    <p class="text-gray-600">
                        Hiện tại có {{ $hotels->count() }} khách sạn phù hợp với từ khóa tìm kiếm của bạn.
                    </p>
                @endif
            </div>

            {{-- Grid danh sách khách sạn --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-[30px]">
                @foreach($hotels as $hotel)
                    <div class="bg-white rounded-[10px] border border-[#F1F1F1] overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        <div class="h-[200px] overflow-hidden">
                            <img src="{{ asset($hotel->logo) }}"
                                 alt="{{ $hotel->name }}"
                                 class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-[30px]">
                            <h3 class="text-heading text-[20px] font-jost mb-2">
                                {{ $hotel->name }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-[15px]">
                                {{ Str::limit($hotel->description, 100) }}
                            </p>
                            <ul class="text-[14px] space-y-1 mb-[20px]">
                                <li class="flex items-center">
                                    <i class="flaticon-phone-flip mr-2 text-primary"></i>
                                    {{ $hotel->phone }}
                                </li>
                                <li class="flex items-center">
                                    <i class="flaticon-envelope mr-2 text-primary"></i>
                                    {{ $hotel->email }}
                                </li>
                                <li class="flex items-center">
                                    <i class="flaticon-marker mr-2 text-primary"></i>
                                    {{ $hotel->address }}
                                </li>
                            </ul>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('hotels.show', $hotel) }}"
                                   class="text-[16px] text-primary font-medium border-b border-[#ab8a62] hover:text-heading">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Không tìm thấy --}}
            <div class="text-center py-10">
                <div class="text-gray-500 mb-4">
                    Không tìm thấy khách sạn nào phù hợp với từ khóa "{{ $search }}"
                </div>
                <button
                    onclick="document.querySelector('input[name=search]').value = ''"
                    class="text-blue-600 hover:underline"
                >
                    Thử tìm kiếm với từ khóa khác
                </button>
            </div>
        @endif
    </div>
@endsection
