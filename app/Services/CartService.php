<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getOrCreateCart()
    {
        if (!Auth::check()) {
            throw new \Exception('You must be logged in to access the cart.');
        }

        return Cart::firstOrCreate([
            'customer_id' => Auth::id(),
            'team_id' => '1'
        ]);
    }

    public function addItem(Room $room, $checkInDate, $checkOutDate)
    {
        $cart = $this->getOrCreateCart();

        if (!$room->isAvailable($checkInDate, $checkOutDate)) {
            throw new \Exception('Room is not available for the selected dates');
        }

        $checkIn = new \DateTime($checkInDate);
        $checkOut = new \DateTime($checkOutDate);
        $nights = $checkIn->diff($checkOut)->days;

        // Calculate price
        $totalPrice = $room->roomType->price * $nights;

        // Create cart item
        $cart->items()->create([
            'room_id' => $room->id,
            'price' => $room->roomType->price,
            'total_price' => $totalPrice,
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
            'nights' => $nights,
        ]);

        return $cart;
    }

    public function removeItem($cartItemId)
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->where('id', $cartItemId)->delete();
        return $cart;
    }
    public function clearCart()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();
        return $cart;
    }
}
