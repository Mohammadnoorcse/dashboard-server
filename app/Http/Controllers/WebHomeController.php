<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebHome;

class WebHomeController extends Controller
{
    // Get all colors
    public function index()
    {
        return response()->json(WebHome::all());
    }

    // Store new color
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bgColor' => 'nullable|string',
            'textColor' => 'nullable|string',
            'hoverColor' => 'nullable|string',
            'activeColor' => 'nullable|string',
            'borderColor' => 'nullable|string',
        ]);

        $color = WebHome::create($validated);
        return response()->json($color, 201);
    }

    // Update color
    public function update(Request $request, $id)
    {
        $color = WebHome::findOrFail($id);
        $color->update($request->all());
        return response()->json($color);
    }

    // Delete color
    public function destroy($id)
    {
        $color = WebHome::findOrFail($id);
        $color->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
