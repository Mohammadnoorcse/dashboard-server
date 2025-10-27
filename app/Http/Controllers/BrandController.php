<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    // List all brands
    public function index()
    {
        return response()->json(Brand::all());
    }

    // Create new brand
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|integer'
        ]);

        $filename = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/brands'), $filename);
        }

        $brand = Brand::create([
            'name' => $request->name,
            'image' => $filename ? 'uploads/brands/' . $filename : null,
            'status' => $request->status ?? 1,
        ]);

        return response()->json([
            'message' => 'Brand created successfully',
            'data' => $brand
        ], 201);
    }

    // Show single brand
    public function show($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        return response()->json($brand);
    }

    // Update brand
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $request->validate([
            'name' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image && File::exists(public_path($brand->image))) {
                File::delete(public_path($brand->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/brands'), $filename);
            $brand->image = 'uploads/brands/' . $filename;
        }

        $brand->name = $request->name ?? $brand->name;
        $brand->status = $request->status ?? $brand->status;
        $brand->save();

        return response()->json([
            'message' => 'Brand updated successfully',
            'data' => $brand
        ]);
    }

    // Delete brand
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        // Delete image if exists
        if ($brand->image && File::exists(public_path($brand->image))) {
            File::delete(public_path($brand->image));
        }

        $brand->delete();

        return response()->json([
            'message' => 'Brand deleted successfully'
        ]);
    }
}
