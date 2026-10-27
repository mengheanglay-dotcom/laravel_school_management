<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Room::query()->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255',
            'floor_id' => 'required|integer|exists:floors,id',
        ]);

        if (Room::where('floor_id', $validatedData['floor_id'])->where('room_number', $validatedData['room_number'])->exists()) {
            return response()->json(['message' => 'This room already exists on that floor.'], 422);
        }

        $room = Room::create($validatedData);

        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255',
            'floor_id' => 'required|integer|exists:floors,id',
        ]);

        if (Room::where('floor_id', $validatedData['floor_id'])->where('room_number', $validatedData['room_number'])->where('id', '!=', $room->id)->exists()) {
            return response()->json(['message' => 'This room already exists on that floor.'], 422);
        }

        $room->update($validatedData);

        return response()->json($room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'message' => 'Room deleted successfully'
        ]);
    }
}
