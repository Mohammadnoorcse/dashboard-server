<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;

class ShippingController extends Controller
{
      // ✅ Get all shipping options
    public function index()
    {
        return response()->json(Shipping::all());
    }

    // ✅ Store new shipping
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:0,1',
        ]);

        $shipping = Shipping::create($validated);
        return response()->json($shipping, 201);
    }

    // ✅ Get single shipping
    public function show($id)
    {
        $shipping = Shipping::findOrFail($id);
        return response()->json($shipping);
    }

    // ✅ Update shipping
    public function update(Request $request, $id)
    {
        $shipping = Shipping::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:0,1',
        ]);

        $shipping->update($validated);
        return response()->json($shipping);
    }

    // ✅ Delete shipping
    public function destroy($id)
    {
        $shipping = Shipping::findOrFail($id);
        $shipping->delete();

        return response()->json(['message' => 'Shipping deleted successfully']);
    }
}
