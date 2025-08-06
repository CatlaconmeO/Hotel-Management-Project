<?php

namespace App\Livewire;

use App\Models\Review;
use App\Models\Room;
use Livewire\Component;

class RoomReview extends Component
{
    public Room $room;
    public $rating = 0;
    public $comment = '';

    public function mount()
    {
        $existingReview = $this->getExistingReview();
        if ($existingReview) {
            $this->rating = $existingReview->rating;
            $this->comment = $existingReview->comment;
        }
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function submit()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'customer_id' => auth()->id(),
                'room_id' => $this->room->id
            ],
            [
                'rating' => $this->rating,
                'comment' => $this->comment,
                'team_id' => $this->room->branch->team_id
            ]
        );

        session()->flash('message', 'Đánh giá phòng đã được lưu!');
        $this->dispatch('reviewSubmitted');
        return redirect()->back()->with('success', 'Your rating saved successfully.');
    }

    public function getExistingReview()
    {
        if (!auth()->check()) return null;

        return Review::where('customer_id', auth()->id())
            ->where('room_id', $this->room->id)
            ->first();
    }

    public function render()
    {
        $reviews = $this->room->reviews()->with('customer')->latest()->get();
        $averageRating = $reviews->avg('rating') ?? 0;

        return view('livewire.pages.rooms.review', [
            'existingReview' => $this->getExistingReview(),
            'reviews' => $reviews,
            'averageRating' => round($averageRating, 1)
        ]);
    }
}
