<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeaturesTopNavbar;

class FeaturesTopNavbarController extends Controller
{
    // Get all cards
    public function index()
    {
        return response()->json(FeaturesTopNavbar::all());
    }

    // Store new card
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'text_color' => 'nullable|string',
            'bg_color' => 'nullable|string',
            'icon_bg_color' => 'nullable|string',
        ]);

        $card = FeaturesTopNavbar::create($request->all());
        return response()->json($card, 201);
    }

    // Update existing card
    public function update(Request $request, $id)
    {
        $card = FeaturesTopNavbar::findOrFail($id);
        $card->update($request->all());
        return response()->json($card);
    }

    // Delete card
    public function destroy($id)
    {
        FeaturesTopNavbar::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
