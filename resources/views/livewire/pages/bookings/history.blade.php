@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8 lg:py-12">
        <!-- Header with modern styling -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-start gap-4 mb-8">
            <!-- Title side with improved typography -->
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center mb-2">
                    My Booking History
                </h1>
                <p class="text-gray-500">View and manage your past and upcoming reservations</p>
            </div>

            <!-- Search side with better styling -->
            <div class="relative w-full md:w-auto">
                <div class="relative flex items-center">
                    <i class="fas fa-search absolute left-4 text-gray-400"></i>
                    <input
                        type="text"
                        placeholder="Search bookings..."
                        class="pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 w-full md:w-64 shadow-sm transition-all duration-200"
                    />
                </div>
            </div>
        </div>


        {{-- Desktop view with modern styling --}}
        <div class="hidden md:block bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-hotel mr-1 text-blue-500"></i> Hotel
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-bed mr-1 text-blue-500"></i> Room
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-calendar-alt mr-1 text-blue-500"></i> Dates
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-info-circle mr-1 text-blue-500"></i> Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="px-6 py-5 text-sm text-gray-900 font-medium">#{{ $booking->id }}</td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-building mr-2 text-blue-500"></i>{{ $booking->branch->team->name }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">{{ $booking->branch->name }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm text-gray-900 flex items-center">
                                    <i class="fas fa-door-open mr-2 text-blue-500"></i>{{ $booking->bookingDetail->room->roomType->name ?? 'Room' }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">#{{ $booking->bookingDetail->room->room_number }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm text-gray-900 flex items-center">
                                    <i class="fas fa-clock mr-2 text-blue-500"></i>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} nights</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full
                                    {{ match($booking->status->value) {
                                        'confirmed' => 'bg-green-100 text-green-800 border border-green-200',
                                        'cancelled' => 'bg-red-100 text-red-800 border border-red-200',
                                        default => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                    } }}">
                                    <i class="{{ match($booking->status->value) {
                                        'confirmed' => 'fas fa-check-circle mr-1',
                                        'cancelled' => 'fas fa-times-circle mr-1',
                                        default => 'fas fa-clock mr-1',
                                    } }}"></i>
                                    {{ ucfirst($booking->status->value) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('booking.detail', $booking->bookingDetail->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-500 hover:text-white transition-all duration-200">
                                        <i class="fas fa-eye mr-2"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-50 p-6 rounded-full mb-4">
                                        <i class="fas fa-calendar-xmark text-gray-300 text-5xl"></i>
                                    </div>
                                    <p class="text-gray-500 text-lg mb-4">You have no booking history yet</p>
                                    <a href="{{ route('hotels') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm">
                                        <i class="fas fa-search mr-2"></i> Browse Hotels
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-600 order-2 md:order-1">
                    Showing <span class="font-medium">{{ $bookings->firstItem() ?? 0 }}</span> to
                    <span class="font-medium">{{ $bookings->lastItem() ?? 0 }}</span> of
                    <span class="font-medium">{{ $bookings->total() }}</span> bookings
                </div>
                <div class="order-1 md:order-2 w-full md:w-auto">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>

        {{-- Mobile view with modern cards --}}
        <div class="md:hidden space-y-4">
            @forelse($bookings as $booking)
                <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 flex items-center">
                                <i class="fas fa-hashtag mr-1"></i>#{{ $booking->id }}
                            </span>
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center mt-1">
                                <i class="fas fa-hotel mr-2 text-blue-500"></i>{{ $booking->branch->team->name }}
                            </h3>
                            <p class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $booking->branch->name }}
                            </p>
                        </div>
                        <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full
                            {{ match($booking->status->value) {
                                'confirmed' => 'bg-green-100 text-green-800 border border-green-200',
                                'cancelled' => 'bg-red-100 text-red-800 border border-red-200',
                                default => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                            } }}">
                            <i class="{{ match($booking->status->value) {
                                'confirmed' => 'fas fa-check-circle mr-1',
                                'cancelled' => 'fas fa-times-circle mr-1',
                                default => 'fas fa-clock mr-1',
                            } }}"></i> {{ ucfirst($booking->status->value) }}
                        </span>
                    </div>

                    <div class="my-4 h-px bg-gray-100"></div>

                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                        <div class="flex items-start">
                            <i class="fas fa-door-open mt-1 mr-2 text-blue-500"></i>
                            <div>
                                <span class="block font-medium text-gray-800">{{ $booking->bookingDetail->room->roomType->name ?? 'Room' }}</span>
                                <span class="text-gray-500">#{{ $booking->bookingDetail->room->room_number }}</span>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-calendar-alt mt-1 mr-2 text-blue-500"></i>
                            <div>
                                <span class="block font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</span>
                                <span class="text-gray-500">{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} nights</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex justify-end space-x-2">
                        <a href="{{ route('booking.detail', $booking->bookingDetail->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-500 hover:text-white transition-all duration-200 flex-grow text-center justify-center shadow-sm">
                            <i class="fas fa-eye mr-2"></i> View Details
                        </a>
                        @if($booking->status->value !== 'cancelled')
                            <button class="inline-flex items-center p-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                                <i class="fas fa-ellipsis-v text-gray-600"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-xl shadow-md text-center border border-gray-100">
                    <div class="bg-gray-50 w-20 h-20 flex items-center justify-center rounded-full mx-auto mb-4">
                        <i class="fas fa-calendar-xmark text-gray-300 text-4xl"></i>
                    </div>
                    <p class="text-gray-500 text-lg mb-5">You have no booking history yet</p>
                    <a href="{{ route('hotels') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-search mr-2"></i> Browse Hotels
                    </a>
                </div>
            @endforelse

            @if($bookings->count() > 0)
                <div class="py-5 flex justify-center">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
