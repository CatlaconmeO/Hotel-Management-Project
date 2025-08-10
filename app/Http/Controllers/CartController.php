<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getOrCreateCart();
        return view('livewire.pages.carts.index', compact('cart'));
    }

    public function addItem(Request $request, Room $room)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        try {
            $cart = $this->cartService->addItem(
                $room,
                $validated['check_in_date'],
                $validated['check_out_date'],
            );

            return redirect()->route('carts.index')->with('success', 'Room added to your cart.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function removeItem(CartItem $cartItem)
    {
        $cart = $this->cartService->getOrCreateCart();

        if ($cartItem->cart_id != $cart->id) {
            return redirect()->route('carts.index')->with('error', 'Invalid cart item.');
        }

        $this->cartService->removeItem($cartItem->id);
        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $this->cartService->clearCart();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    public function updateDates(Request $request, CartItem $cartItem)
    {
        $cart = $this->cartService->getOrCreateCart();

        // Check if the item belongs to the current cart
        if ($cartItem->cart_id != $cart->id) {
            return redirect()->route('livewire.pages.carts.index')->with('error', 'Invalid cart item.');
        }

        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        try {
            $this->cartService->updateDates(
                $cartItem->id,
                $validated['check_in_date'],
                $validated['check_out_date']
            );

            return redirect()->route('livewire.pages.carts.index')->with('success', 'Booking dates updated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
