<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(Request $r)
    {
        $data = ['title' => 'Classrooms', 'subtitle' => 'Track classroom numbers and their campus locations.', 'records' => Room::with('floor.building')->when($r->search, fn($x, $s) => $x->where('room_number', 'like', "%$s%")->orWhereHas('floor', fn($f) => $f->where('floor_number', 'like', "%$s%"))->orWhereHas('floor.building', fn($b) => $b->where('name', 'like', "%$s%")))->latest()->paginate(10)->withQueryString(), 'type' => 'rooms'];
        return $r->expectsJson() ? response()->json(['html' => view('records._results', $data)->render()]) : view('records.index', $data);
    }
    private function fields($record = null)
    {
        return [['name' => 'room_number', 'label' => 'Room number', 'required' => true], ['name' => 'floor_id', 'label' => 'Floor', 'required' => true, 'options' => Floor::with('building')->get()->mapWithKeys(fn($f) => [$f->id => $f->building->name . ' — Floor ' . $f->floor_number]), 'selected' => $record?->floor_id]];
    }
    public function create()
    {
        return view('records.form', ['title' => 'Add classroom', 'type' => 'rooms', 'record' => new Room, 'fields' => $this->fields()]);
    }
    public function store(Request $r)
    {
        $d = $r->validate(['room_number' => 'required|string|max:100', 'floor_id' => 'required|exists:floors,id']);
        if (Room::where('floor_id', $d['floor_id'])->where('room_number', $d['room_number'])->exists()) return $r->expectsJson() ? response()->json(['message' => 'This room already exists on that floor.', 'errors' => ['room_number' => ['This room already exists on that floor.']]], 422) : back()->withErrors(['room_number' => 'This room already exists on that floor.'])->withInput();
        Room::create($d);
        return $r->expectsJson() ? response()->json(['message' => 'Classroom created successfully.', 'redirect' => route('rooms.index')]) : redirect()->route('rooms.index')->with('success', 'Classroom created successfully.');
    }
    public function edit(Room $room)
    {
        return view('records.form', ['title' => 'Edit classroom', 'type' => 'rooms', 'record' => $room, 'fields' => $this->fields($room)]);
    }
    public function update(Request $r, Room $room)
    {
        $d = $r->validate(['room_number' => 'required|string|max:100', 'floor_id' => 'required|exists:floors,id']);
        if (Room::where('floor_id', $d['floor_id'])->where('room_number', $d['room_number'])->where('id', '!=', $room->id)->exists()) return $r->expectsJson() ? response()->json(['message' => 'This room already exists on that floor.', 'errors' => ['room_number' => ['This room already exists on that floor.']]], 422) : back()->withErrors(['room_number' => 'This room already exists on that floor.'])->withInput();
        $room->update($d);
        return $r->expectsJson() ? response()->json(['message' => 'Classroom updated successfully.', 'redirect' => route('rooms.index')]) : redirect()->route('rooms.index')->with('success', 'Classroom updated successfully.');
    }
    public function destroy(Request $r, Room $room)
    {
        $room->delete();
        return $r->expectsJson() ? response()->json(['message' => 'Classroom deleted successfully.']) : back()->with('success', 'Classroom deleted successfully.');
    }
}
