<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    public function index() {
        return response()->json(Section::all());
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string']);
        $section = Section::create([
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ]);
        return response()->json(['message' => 'Section created', 'data' => $section]);
    }

    public function update(Request $request, $id) {
        $section = Section::find($id);
        if (!$section) return response()->json(['message' => 'Section not found'], 404);
        $section->update($request->only(['name', 'status']));
        return response()->json(['message' => 'Section updated', 'data' => $section]);
    }

    public function destroy($id) {
        $section = Section::find($id);
        if (!$section) return response()->json(['message' => 'Section not found'], 404);
        $section->delete();
        return response()->json(['message' => 'Section deleted']);
    }
}
