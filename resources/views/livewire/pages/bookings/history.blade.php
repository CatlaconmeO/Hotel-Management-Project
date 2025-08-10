@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .booking-card {
            transition: all 0.2s ease-in-out;
        }
        .booking-card:hover {
            transform: translateY(-2px);
        }
        .status-badge {
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .empty-state {
            background: radial-gradient(circle at top, #f9fafb 0%, #f3f4f6 100%);
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8 lg:py-12">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-left gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center mb-2">
                    Booking History
                </h1>
                <p class="text-gray-500 text-sm md:text-base">View and manage your past and upcoming reservations</p>
            </div>
        </div>

        {{-- Desktop view with modern styling --}}
        <div class="hidden md:block bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-hotel mr-1 text-blue-500"></i> Hotel & Branch
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-bed mr-1 text-blue-500"></i> Room Details
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-calendar-alt mr-1 text-blue-500"></i> Stay Period
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                            <i class="fas fa-info-circle mr-1 text-blue-500"></i> Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-blue-50 transition-all duration-200 booking-card">
                            <td class="px-6 py-5 text-sm text-gray-900 font-medium">#{{ $booking->id }}</td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-medium text-gray-900 flex items-center">
                                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 mr-3">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    {{ $booking->branch->team->name }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1 ml-11">
                                    <i class="fas fa-map-marker-alt mr-1 opacity-70"></i>{{ $booking->branch->name }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $booking->bookingDetail->room->roomType->name ?? 'Room' }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1 flex items-center">
                                    <i class="fas fa-door-open mr-1 opacity-70"></i>#{{ $booking->bookingDetail->room->room_number }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1 flex items-center">
                                    <i class="fas fa-moon mr-1 opacity-70"></i>{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} nights
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full status-badge
                                    {{ match($booking->status->value) {
                                        'confirmed' => 'bg-green-100 text-green-800 border border-green-200',
                                        'cancelled' => 'bg-red-100 text-red-800 border border-red-200',
                                        'completed' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                        default => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                    } }}">
                                    <i class="{{ match($booking->status->value) {
                                        'confirmed' => 'fas fa-check-circle mr-1',
                                        'cancelled' => 'fas fa-times-circle mr-1',
                                        'completed' => 'fas fa-flag-checkered mr-1',
                                        default => 'fas fa-clock mr-1',
                                    } }}"></i>
                                    {{ ucfirst($booking->status->value) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('booking.detail', $booking->bookingDetail->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-white border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-500 hover:text-white transition-all duration-200">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    @if($booking->status->value === 'confirmed')
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-all duration-200">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center empty-state p-8 rounded-xl max-w-md mx-auto">
                                    <div class="bg-white p-6 rounded-full mb-4 shadow-sm border border-gray-100">
                                        <i class="fas fa-calendar-xmark text-gray-300 text-5xl"></i>
                                    </div>
                                    <h3 class="text-gray-800 font-medium text-lg mb-2">No bookings found</h3>
                                    <p class="text-gray-500 mb-6 text-center">You haven't made any reservations yet. Start exploring our hotels to book your first stay!</p>
                                    <a href="{{ route('hotels.index') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm">
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
                <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100 booking-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-md flex items-center w-fit">
                                <i class="fas fa-hashtag mr-1"></i>#{{ $booking->id }}
                            </span>
                            <h3 class="text-lg font-semibold text-gray-800 mt-2">
                                {{ $booking->branch->team->name }}
                            </h3>
                            <p class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $booking->branch->name }}
                            </p>
                        </div>
                        <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full status-badge
                            {{ match($booking->status->value) {
                                'confirmed' => 'bg-green-100 text-green-800 border border-green-200',
                                'cancelled' => 'bg-red-100 text-red-800 border border-red-200',
                                'completed' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                default => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                            } }}">
                            <i class="{{ match($booking->status->value) {
                                'confirmed' => 'fas fa-check-circle mr-1',
                                'cancelled' => 'fas fa-times-circle mr-1',
                                'completed' => 'fas fa-flag-checkered mr-1',
                                default => 'fas fa-clock mr-1',
                            } }}"></i> {{ ucfirst($booking->status->value) }}
                        </span>
                    </div>

                    <div class="my-4 h-px bg-gray-100"></div>

                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-xs text-gray-500 mb-1">ROOM</div>
                            <div class="font-medium text-gray-800">
                                {{ $booking->bookingDetail->room->roomType->name ?? 'Room' }}
                            </div>
                            <div class="text-gray-500 text-xs mt-1">
                                #{{ $booking->bookingDetail->room->room_number }}
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-xs text-gray-500 mb-1">DATES</div>
                            <div class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M') }}
                            </div>
                            <div class="text-gray-500 text-xs mt-1">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} nights
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex justify-end space-x-2">
                        <a href="{{ route('booking.detail', $booking->bookingDetail->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-500 hover:text-white transition-all duration-200 flex-grow text-center justify-center shadow-sm">
                            <i class="fas fa-eye mr-2"></i> View Details
                        </a>
                        @if($booking->status->value === 'confirmed')
                            <div class="relative">
                                <button class="inline-flex items-center p-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                                    <i class="fas fa-ellipsis-v text-gray-600"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-xl shadow-sm text-center border border-gray-100 empty-state">
                    <div class="bg-white w-20 h-20 flex items-center justify-center rounded-full mx-auto mb-4 shadow-sm border border-gray-100">
                        <i class="fas fa-calendar-xmark text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-gray-800 font-medium text-lg mb-2">No bookings found</h3>
                    <p class="text-gray-500 mb-6">You haven't made any reservations yet.</p>
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
