<?php

namespace App\Http\Controllers;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
     // List all colors
    public function index()
    {
        return response()->json(Color::all());
    }

    // Create new color
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'nullable|numeric',
        ]);

        $color = Color::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return response()->json([
            'message' => 'Color created successfully',
            'data' => $color
        ], 201);
    }

    // Show single color
    public function show($id)
    {
        $color = Color::find($id);
        if (!$color) return response()->json(['message' => 'Color not found'], 404);

        return response()->json($color);
    }

    // Update color
    public function update(Request $request, $id)
    {
        $color = Color::find($id);
        if (!$color) return response()->json(['message' => 'Color not found'], 404);

        $request->validate([
            'name' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        $color->name = $request->name ?? $color->name;
        $color->price = $request->price ?? $color->price;
        $color->save();

        return response()->json([
            'message' => 'Color updated successfully',
            'data' => $color
        ]);
    }

    // Delete color
    public function destroy($id)
    {
        $color = Color::find($id);
        if (!$color) return response()->json(['message' => 'Color not found'], 404);

        $color->delete();

        return response()->json(['message' => 'Color deleted successfully']);
    }
}
