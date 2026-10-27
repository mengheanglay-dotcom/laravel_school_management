<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Building::query()->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $building = Building::create($validatedData);

        return response()->json([
            'building' => $building,
            'status' => 'success',
            'message' => 'Building created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        return response()->json([
            'building' => $building,
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $building->update($validatedData);

        return response()->json([
            'building' => $building,
            'status' => 'success',
            'message' => 'Building updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();

        return response()->json([
            'message' => 'Building deleted successfully',
            'status' => 'success'
        ]);
    }
}
