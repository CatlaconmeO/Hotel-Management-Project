<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search'));

        $hotels = Team::query()
            ->when($search, fn($query) =>
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                    ->orWhere('email', 'ILIKE', "%{$search}%")
                    ->orWhere('address', 'ILIKE', "%{$search}%");
            })
            )
            ->latest()
            ->paginate(9)
            ->withQueryString();
        return view('livewire.pages.hotels.index', compact('hotels', 'search'));
    }

    public function show(Team $hotel)
    {
        $hotel->load(['branches']);
        $branchId = request('branch') ?? optional($hotel->branches->first())->id;
        $currentBranch = $hotel->branches->firstWhere('id', $branchId);
        $rooms = $currentBranch
            ? $currentBranch->rooms()->paginate(6)
            : collect();
        return view('livewire.pages.hotels.show', compact('hotel', 'branchId', 'currentBranch', 'rooms'));
    }
}

