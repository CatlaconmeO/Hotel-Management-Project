<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query  = Team::query();

        if ($search = $request->input('search')) {
            $searchTerm = '%' . $search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', $searchTerm)
                    ->orWhere('email', 'ILIKE', $searchTerm)
                    ->orWhere('address', 'ILIKE', $searchTerm);
            });
            $results = $query->get();
            //dd($query->toSql(), $search, $searchTerm,   $query->getBindings(), $results);
        }

        $hotels = $query->latest()->paginate(9)->withQueryString();
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

