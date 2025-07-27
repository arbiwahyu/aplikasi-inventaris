<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Ambil semua log, urutkan dari yang terbaru, dan gunakan pagination
        $activities = Activity::latest()->paginate(20);

        return view('admin.activity-log.index', compact('activities'));
    }
}