<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    // Get all
    public function index()
    {
        return response()->json(Size::all());
    }

    // Create
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
        ]);

        $Size = Size::create($request->all());

        return response()->json(['message' => 'Size created', 'data' => $Size]);
    }

    // Show single
    public function show($id)
    {
        $Size = Size::find($id);
        if (!$Size) return response()->json(['message' => 'Not found'], 404);
        return response()->json($Size);
    }

    // Update
    public function update(Request $request, $id)
    {
        $Size = Size::find($id);
        if (!$Size) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'name' => 'nullable|string',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
        ]);

        $Size->update($request->all());

        return response()->json(['message' => 'Size updated', 'data' => $Size]);
    }

    // Delete
    public function destroy($id)
    {
        $Size = Size::find($id);
        if (!$Size) return response()->json(['message' => 'Not found'], 404);
        $Size->delete();
        return response()->json(['message' => 'Size deleted']);
    }
}
