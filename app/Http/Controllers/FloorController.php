<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $floors = Floor::all();
        return response()->json([
            'floors' => $floors,
            'message' => 'Floors retrieved successfully',
            'status' => 'success'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'floor_number' => 'required|string|max:50',
            'building_id' => 'required|integer|exists:buildings,id',

        ]);

        if (Floor::where('building_id', $validated['building_id'])->where('floor_number', $validated['floor_number'])->exists()) {
            return response()->json(['message' => 'This floor already exists in that building.'], 422);
        }

        $floor = Floor::create($validated);
        return response()->json([
            'floor' => $floor,
            'message' => 'Floor created successfully',
            'status' => 'success'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Floor $floor)
    {
        return response()->json([
            'floor' => $floor,
            'message' => 'Floor retrieved by ID successfully',
            'status' => 'success'
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Floor $floor)
    {
        //
        $validated = $request->validate([
            'floor_number' => 'required|string|max:50',
            'building_id' => 'required|integer|exists:buildings,id',
        ]);

        if (Floor::where('building_id', $validated['building_id'])->where('floor_number', $validated['floor_number'])->where('id', '!=', $floor->id)->exists()) {
            return response()->json(['message' => 'This floor already exists in that building.'], 422);
        }

        $floor->update($validated);
        return response()->json([
            'floor' => $floor,
            'message' => 'Floor updated successfully',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Floor $floor)
    {
        //
        $floor->delete();
        return response()->json([
            'message' => 'Floor deleted successfully',
            'status' => 'success'
        ]);
    }
}
