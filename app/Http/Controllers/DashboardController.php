<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $availableItems = Item::where('status', 'Tersedia')->count();
        $borrowedItems = Item::where('status', 'Dipinjam')->count();
        $totalUsers = User::count();

        return view('dashboard', compact(
            'totalItems',
            'availableItems',
            'borrowedItems',
            'totalUsers'
        ));
    }
}
