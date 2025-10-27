<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
     // Get all products
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Get single product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function store(Request $request)
{
    $data = $request->all();

    // Images: if uploaded, store paths
    if ($request->hasFile('images')) {
        $data['images'] = [];
        foreach ($request->file('images') as $file) {
            $path = $file->store('products', 'public');
            $data['images'][] = $path;
        }
    }

    // JSON fields are automatically casted in model
    $product = Product::create($data);

    return response()->json($product, 201);
}

 // Update product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->all();

        // Handle new images if uploaded
        if ($request->hasFile('images')) {
            $newImages = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $newImages[] = $path;
            }

            // Merge with existing images
            $existingImages = $product->images ?? [];
            $data['images'] = array_merge($existingImages, $newImages);
        }

        // Update product
        $product->update($data);

        return response()->json($product);
    }












    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Optional: Delete images from storage
        if($product->images){
            foreach(json_decode($product->images) as $img){
                \Storage::disk('public')->delete($img);
            }
        }

        $product->delete();
        return response()->json(['success'=>true,'message'=>'Product deleted']);
    }
}
