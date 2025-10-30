<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeaturesLogo;
use Illuminate\Support\Facades\Storage;

class FeaturesLogoController extends Controller
{
    public function index()
    {
        return FeaturesLogo::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
        ]);

        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $path = $file->store('header_images', 'public'); 

        $item = FeaturesLogo::create([
            'filename' => $filename,
            'image_path' => $path,
            'width' => $request->width,
            'height' => $request->height,
        ]);

        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = FeaturesLogo::findOrFail($id);

        $data = $request->only(['width', 'height', 'filename']);

        if ($request->hasFile('image')) {
            // delete old file if exists
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }

            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->store('header_images', 'public');

            $data['filename'] = $filename;
            $data['image_path'] = $path;
        }

        $item->update($data);

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = FeaturesLogo::findOrFail($id);

        if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
