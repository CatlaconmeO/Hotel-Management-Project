@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-12">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            {{-- Header --}}
            <div class="bg-primary px-6 py-4">
                <h2 class="text-2xl font-semibold text-white">
                    My Booking History
                </h2>
            </div>

            {{-- Table --}}
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full table-auto divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-600 uppercase text-xs">#</th>
                        <th class="px-4 py-3 text-left text-gray-600 uppercase text-xs">Hotel</th>
                        <th class="px-4 py-3 text-left text-gray-600 uppercase text-xs">Branch</th>
                        <th class="px-4 py-3 text-left text-gray-600 uppercase text-xs">Room</th>
                        <th class="px-4 py-3 text-left text-gray-600 uppercase text-xs">Check-in</th>
                        <th class="px-4 py-3 text-left text-gray-600 uppercase text-xs">Check-out</th>
                        <th class="px-4 py-3 text-left text-gray-600 uppercase text-xs">Status</th>
                        <th class="px-4 py-3 text-center text-gray-600 uppercase text-xs">Action</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-gray-700">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $loop->iteration + ($bookings->currentPage()-1)*$bookings->perPage() }}</td>
                            <td class="px-4 py-3">{{ $booking->branch->team->name }}</td>
                            <td class="px-4 py-3">{{ $booking->branch->name }}</td>
                            <td class="px-4 py-3">{{ $booking->bookingDetail->room->room_number }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-700' : ($booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-800') }}">
                  {{ ucfirst($booking->status) }}
                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('booking.detail', $booking->bookingDetail->id) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm text-white bg-primary hover:bg-primary/90 rounded-md transition">
                                    View Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-400 italic">
                                You have no booking history.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
