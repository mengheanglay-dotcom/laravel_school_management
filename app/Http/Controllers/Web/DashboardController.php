<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', ['stats' => [
            ['label' => 'Buildings', 'value' => Building::count(), 'icon' => '▦', 'href' => route('buildings.index')],
            ['label' => 'Floors', 'value' => Floor::count(), 'icon' => '▤', 'href' => route('floors.index')],
            ['label' => 'Classrooms', 'value' => Room::count(), 'icon' => '▣', 'href' => route('rooms.index')],
            ['label' => 'Teachers', 'value' => Teacher::count(), 'icon' => '♙', 'href' => route('teachers.index')],
        ], 'recentBuildings' => Building::withCount(['floors'])->latest()->take(5)->get(), 'recentTeachers' => Teacher::latest()->take(4)->get()]);
    }
}
