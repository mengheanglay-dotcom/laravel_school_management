<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index(Request $r)
    {
        $data = ['title' => 'Teachers', 'subtitle' => 'Maintain staff profiles and teaching subjects.', 'records' => Teacher::when($r->search, fn($x, $s) => $x->where(fn($w) => $w->where('name', 'like', "%$s%")->orWhere('subject', 'like', "%$s%")))->when($r->subject, fn($x, $s) => $x->where('subject', $s))->latest()->paginate(10)->withQueryString(), 'type' => 'teachers', 'subjects' => Teacher::whereNotNull('subject')->distinct()->orderBy('subject')->pluck('subject')];
        return $r->expectsJson() ? response()->json(['html' => view('records._results', $data)->render()]) : view('records.index', $data);
    }
    private function fields()
    {
        return [['name' => 'name', 'label' => 'Full name', 'required' => true], ['name' => 'age', 'label' => 'Age', 'type' => 'number', 'required' => false], ['name' => 'subject', 'label' => 'Teaching subject', 'required' => false], ['name' => 'image', 'label' => 'Profile photo', 'type' => 'file', 'required' => false]];
    }
    public function create()
    {
        return view('records.form', ['title' => 'Add teacher', 'type' => 'teachers', 'record' => new Teacher, 'fields' => $this->fields()]);
    }
    public function store(Request $r)
    {
        $d = $r->validate(['name' => 'required|string|max:100', 'age' => 'nullable|integer|min:18|max:100', 'subject' => 'nullable|string|max:255', 'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']);
        if ($r->hasFile('image')) $d['image'] = $r->file('image')->store('teachers', 'public');
        Teacher::create($d);
        return $r->expectsJson() ? response()->json(['message' => 'Teacher profile created successfully.', 'redirect' => route('teachers.index')]) : redirect()->route('teachers.index')->with('success', 'Teacher profile created successfully.');
    }
    public function edit(Teacher $teacher)
    {
        return view('records.form', ['title' => 'Edit teacher', 'type' => 'teachers', 'record' => $teacher, 'fields' => $this->fields()]);
    }
    public function update(Request $r, Teacher $teacher)
    {
        $d = $r->validate(['name' => 'required|string|max:100', 'age' => 'nullable|integer|min:18|max:100', 'subject' => 'nullable|string|max:255', 'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']);
        if ($r->hasFile('image')) {
            if ($teacher->image) Storage::disk('public')->delete($teacher->image);
            $d['image'] = $r->file('image')->store('teachers', 'public');
        }
        $teacher->update($d);
        return $r->expectsJson() ? response()->json(['message' => 'Teacher profile updated successfully.', 'redirect' => route('teachers.index')]) : redirect()->route('teachers.index')->with('success', 'Teacher profile updated successfully.');
    }
    public function destroy(Request $r, Teacher $teacher)
    {
        if ($teacher->image) Storage::disk('public')->delete($teacher->image);
        $teacher->delete();
        return $r->expectsJson() ? response()->json(['message' => 'Teacher removed successfully.']) : back()->with('success', 'Teacher removed successfully.');
    }
}
