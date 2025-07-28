@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">My Booking History
        </h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hotel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Branch</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check in</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration + ($bookings->currentPage()-1)*$bookings->perPage() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $booking->branch->team->name    }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $booking->branch->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $booking->bookingDetail->rooms->room_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            There is no history.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
