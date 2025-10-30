<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeaturesSidebar;
class FeaturesSidebarController extends Controller
{
     // GET all
    public function index()
    {
        return response()->json(FeaturesSidebar::all());
    }

    // POST create
    public function store(Request $request)
    {
        $request->validate([
            'bg_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
            'hover_color' => 'nullable|string|max:50',
            'active_color' => 'nullable|string|max:50',
            'border_color' => 'nullable|string|max:50',
        ]);

        $color = FeaturesSidebar::create($request->all());
        return response()->json($color, 201);
    }

    // PUT update
    public function update(Request $request, $id)
    {
        $color = FeaturesSidebar::findOrFail($id);
        $color->update($request->all());
        return response()->json($color);
    }

    // DELETE remove
    public function destroy($id)
    {
        FeaturesSidebar::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
