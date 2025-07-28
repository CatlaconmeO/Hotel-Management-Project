<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Team;
use App\Enums\RoomStatusEnum;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function show(Request $request, Team $hotel)
    {
        $branchId = $request->get('branch', optional($hotel->branches->first())->id);
        $currentBranch = $hotel->branches->firstWhere('id', $branchId);

        $roomsQuery = Room::with('roomType')
            ->when($currentBranch, fn($q) => $q->where('branch_id', $currentBranch->id));

        $rooms = $roomsQuery
            ->paginate(6)
            ->appends($request->only(['branch', 'search', 'sort']));

        return view('hotels.show', compact(
            'hotel',
            'currentBranch',
            'rooms',
            'branchId'
        ));
    }

    public function store(Request $request, Room $room)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date'
        ]);

        if (!$room->isAvailable($data['check_in_date'], $data['check_out_date'])) {
            return back()->withErrors(['message' => 'This room is not available now. Please try again later.']);
        }

        $customer = auth()->user();
        if (!$customer) {
            return redirect()->route('login')
                ->with('error', 'Please login to book rooms');
        }

        $nights = Carbon::parse($data['check_in_date'])
            ->diffInDays(Carbon::parse($data['check_out_date']));

        $totalPrice = intval($room->roomType->price * $nights);

        try {
            $booking = DB::transaction(function() use ($room, $data, $totalPrice, $customer) {
                $booking = Booking::create([
                    'customer_id' => $customer->id,
                    'branch_id' => $room->branch_id,
                    'check_in_date' => $data['check_in_date'],
                    'check_out_date' => $data['check_out_date'],
                    'status' => 'pending',
                    'total_price' => $totalPrice,
                ]);

                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'room_id' => $room->id,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'price' => $booking->total_price,
                ]);

                $room->updateStatus(RoomStatusEnum::Pending);

                return $booking;
            });

            return redirect()->route('payments.process', compact('booking', 'totalPrice', 'nights'));

        } catch (\Throwable $e) {
            \Log::error($e);
            return back()
                ->withInput()
                ->withErrors(['general' => 'Error. Try again later.']);
        }
    }

    public function history()
    {
        $bookings = auth()->user()
            ->bookings()
            ->with(['branch', 'branch.rooms', 'branch.team'])
            ->latest()
            ->paginate(10);
        return view('livewire.pages.bookings.history', compact('bookings'));
    }

}
