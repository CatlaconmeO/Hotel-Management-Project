<?php
namespace App\Http\Controllers;

use App\Models\Team;

class HomeController extends Controller
{
    public function index(){
        $hotels = Team::with(['branches.rooms.roomType'])->get();
        return view('dashboard', compact('hotels'));
    }
}
