<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FloorController extends Controller
{
    public function index(Request $r)
    {
        $data = ['title' => 'Floors', 'subtitle' => 'Organize floors inside each campus building.', 'records' => Floor::with('building')->withCount('rooms')->when($r->search, fn($x, $s) => $x->where('floor_number', 'like', "%$s%")->orWhereHas('building', fn($b) => $b->where('name', 'like', "%$s%")))->latest()->paginate(10)->withQueryString(), 'type' => 'floors'];
        return $r->expectsJson() ? response()->json(['html' => view('records._results', $data)->render()]) : view('records.index', $data);
    }
    private function fields($record = null)
    {
        return [['name' => 'floor_number', 'label' => 'Floor number / label', 'required' => true], ['name' => 'building_id', 'label' => 'Building', 'required' => true, 'options' => Building::orderBy('name')->pluck('name', 'id'), 'selected' => $record?->building_id]];
    }
    public function create()
    {
        return view('records.form', ['title' => 'Add floor', 'type' => 'floors', 'record' => new Floor, 'fields' => $this->fields()]);
    }
    public function store(Request $r)
    {
        $d = $r->validate(['floor_number' => 'required|string|max:50', 'building_id' => 'required|exists:buildings,id']);
        if (Floor::where('building_id', $d['building_id'])->where('floor_number', $d['floor_number'])->exists()) return $r->expectsJson() ? response()->json(['message' => 'This floor already exists in that building.', 'errors' => ['floor_number' => ['This floor already exists in that building.']]], 422) : back()->withErrors(['floor_number' => 'This floor already exists in that building.'])->withInput();
        Floor::create($d);
        return $r->expectsJson() ? response()->json(['message' => 'Floor created successfully.', 'redirect' => route('floors.index')]) : redirect()->route('floors.index')->with('success', 'Floor created successfully.');
    }
    public function edit(Floor $floor)
    {
        return view('records.form', ['title' => 'Edit floor', 'type' => 'floors', 'record' => $floor, 'fields' => $this->fields($floor)]);
    }
    public function update(Request $r, Floor $floor)
    {
        $d = $r->validate(['floor_number' => 'required|string|max:50', 'building_id' => 'required|exists:buildings,id']);
        if (Floor::where('building_id', $d['building_id'])->where('floor_number', $d['floor_number'])->where('id', '!=', $floor->id)->exists()) return $r->expectsJson() ? response()->json(['message' => 'This floor already exists in that building.', 'errors' => ['floor_number' => ['This floor already exists in that building.']]], 422) : back()->withErrors(['floor_number' => 'This floor already exists in that building.'])->withInput();
        $floor->update($d);
        return $r->expectsJson() ? response()->json(['message' => 'Floor updated successfully.', 'redirect' => route('floors.index')]) : redirect()->route('floors.index')->with('success', 'Floor updated successfully.');
    }
    public function destroy(Request $r, Floor $floor)
    {
        if ($floor->rooms()->exists()) return $r->expectsJson() ? response()->json(['message' => 'Delete or move this floor’s rooms before deleting it.'], 422) : back()->with('error', 'Delete or move this floor’s rooms before deleting it.');
        $floor->delete();
        return $r->expectsJson() ? response()->json(['message' => 'Floor deleted successfully.']) : back()->with('success', 'Floor deleted successfully.');
    }
}
