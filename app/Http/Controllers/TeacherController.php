<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::latest()->get();

        return response()->json([
            'message' => 'Get all teachers',
            'teachers' => $teachers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'age' => 'nullable|integer',
            'subject' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);

        // Upload image if provided
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('teachers', 'public');
            $validated['image'] = $path;
        }

        $teacher = Teacher::create($validated);

        return response()->json([
            'message' => 'Teacher created successfully',
            'teacher' => $teacher,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return response()->json([
            'message' => 'Get teacher successfully',
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'age' => 'nullable|integer',
            'subject' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
                Storage::disk('public')->delete($teacher->image);
            }

            // Store new image and update validated array
            $validated['image'] = $request->file('image')->store('teachers', 'public');
        }

        $teacher->update($validated);

        return response()->json([
            'message' => 'Teacher updated successfully',
            'teacher' => $teacher->fresh(), // Send updated instance
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        // Delete image from storage
        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->delete();

        return response()->json([
            'message' => 'Teacher deleted successfully',
        ]);
    }
}
