<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $data = ['title' => 'Buildings', 'subtitle' => 'Manage campus buildings and their locations.', 'records' => Building::withCount(['floors'])->with('floors.rooms')->when($request->search, fn($x, $s) => $x->where(fn($w) => $w->where('name', 'like', "%$s%")->orWhere('address', 'like', "%$s%")))->latest()->paginate(10)->withQueryString(), 'type' => 'buildings'];
        return $request->expectsJson() ? response()->json(['html' => view('records._results', $data)->render()]) : view('records.index', $data);
    }
    public function create()
    {
        return view('records.form', ['title' => 'Add building', 'type' => 'buildings', 'record' => new Building, 'fields' => [['name' => 'name', 'label' => 'Building name', 'required' => true], ['name' => 'address', 'label' => 'Address', 'required' => true]]]);
    }
    public function store(Request $r)
    {
        $data = $r->validate(['name' => 'required|string|max:150|unique:buildings,name', 'address' => 'required|string|max:255']);
        Building::create($data);
        return $r->expectsJson() ? response()->json(['message' => 'Building created successfully.', 'redirect' => route('buildings.index')]) : redirect()->route('buildings.index')->with('success', 'Building created successfully.');
    }
    public function edit(Building $building)
    {
        return view('records.form', ['title' => 'Edit building', 'type' => 'buildings', 'record' => $building, 'fields' => [['name' => 'name', 'label' => 'Building name', 'required' => true], ['name' => 'address', 'label' => 'Address', 'required' => true]]]);
    }
    public function update(Request $r, Building $building)
    {
        $data = $r->validate(['name' => ['required', 'string', 'max:150', Rule::unique('buildings', 'name')->ignore($building->id)], 'address' => 'required|string|max:255']);
        $building->update($data);
        return $r->expectsJson() ? response()->json(['message' => 'Building updated successfully.', 'redirect' => route('buildings.index')]) : redirect()->route('buildings.index')->with('success', 'Building updated successfully.');
    }
    public function destroy(Request $r, Building $building)
    {
        if ($building->floors()->exists()) return $r->expectsJson() ? response()->json(['message' => 'Move or remove this building’s floors before deleting it.'], 422) : back()->with('error', 'Move or remove this building’s floors before deleting it.');
        $building->delete();
        return $r->expectsJson() ? response()->json(['message' => 'Building deleted successfully.']) : back()->with('success', 'Building deleted successfully.');
    }
}
