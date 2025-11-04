<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

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
                $path = $file->store('uploads/products', 'public');
                $data['images'][] = $path;
            }
        }

        // JSON fields are automatically casted in model
        $product = Product::create($data);

        return response()->json($product, 201);
    }

    //  // Update product
    //     public function update(Request $request, $id)
    //     {
    //         $product = Product::findOrFail($id);
    //         $data = $request->all();

    //         // Handle new images if uploaded
    //         if ($request->hasFile('images')) {
    //             $newImages = [];
    //             foreach ($request->file('images') as $file) {
    //                 $path = $file->store('uploads/products', 'public');
    //                 $newImages[] = $path;
    //             }

    //             // Merge with existing images
    //             $existingImages = $product->images ?? [];
    //             $data['images'] = array_merge($existingImages, $newImages);
    //         }

    //         // Update product
    //         $product->update($data);

    //         return response()->json($product);
    //     }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->all();

        // Decode existing images (those kept in frontend)
        $existingImages = json_decode($request->input('existingImages', '[]'), true);

        // Get all current images in DB
        $currentImages = $product->images ?? [];

        // Determine which images were removed (delete from storage)
        $removedImages = array_diff($currentImages, $existingImages);
        foreach ($removedImages as $img) {
            if (Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        // Handle new uploaded images (from React formData)
        $newImages = [];
        if ($request->hasFile('newImages')) {
            foreach ($request->file('newImages') as $file) {
                $path = $file->store('uploads/products', 'public');
                $newImages[] = $path;
            }
        }

        // Merge kept + new images
        $data['images'] = array_merge($existingImages, $newImages);

        // Update product
        $product->update($data);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }











    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete images from storage
        if ($product->images && is_array($product->images)) {
            foreach ($product->images as $img) {
                if (\Storage::disk('public')->exists($img)) {
                    \Storage::disk('public')->delete($img);
                }
            }
        }

        $product->delete();
        return response()->json(['success' => true, 'message' => 'Product deleted']);
    }
}
