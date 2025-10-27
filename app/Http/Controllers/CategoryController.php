<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
     // All Categories
    public function index()
    {
        return response()->json(Category::all());
    }

    // Create New Category with Image Upload
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
            $image->move(public_path('uploads/categories'), $filename);
        }

        $category = Category::create([
            'name' => $request->name,
            'image' => $filename ? 'uploads/categories/' . $filename : null,
            'status' => $request->status ?? 1,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }

    // Show Single Category
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    // Update Category with Image Upload
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories'), $filename);
            $category->image = 'uploads/categories/' . $filename;
        }

        $category->name = $request->name ?? $category->name;
        $category->status = $request->status ?? $category->status;
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    // Delete Category
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        if ($category->image && File::exists(public_path($category->image))) {
            File::delete(public_path($category->image));
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
