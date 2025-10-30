<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebHeaderLogo;
use Illuminate\Support\Facades\Storage;

class WebHeaderLogoController extends Controller
{
    // Get all logos
    public function index()
    {
        return response()->json(WebHeaderLogo::all());
    }

    // Store new logo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'status' => 'required|string|in:active,inactive',
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('webheaders', $filename, 'public');

        $logo = WebHeaderLogo::create([
            'filename' => $filename,
            'image' => "/storage/" . $path,
            'width' => $validated['width'],
            'height' => $validated['height'],
            'status' => $validated['status'],
        ]);

        return response()->json($logo, 201);
    }

    // Update
    public function update(Request $request, $id)
    {
        $logo = WebHeaderLogo::findOrFail($id);

        $validated = $request->validate([
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
            'status' => 'nullable|string|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($logo->image && Storage::exists(str_replace('/storage/', 'public/', $logo->image))) {
                Storage::delete(str_replace('/storage/', 'public/', $logo->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('webheaders', $filename, 'public');
            $validated['filename'] = $filename;
            $validated['image'] = "/storage/" . $path;
        }

        $logo->update($validated);

        return response()->json($logo);
    }

    // Delete
    public function destroy($id)
    {
        $logo = WebHeaderLogo::findOrFail($id);

        if ($logo->image && Storage::exists(str_replace('/storage/', 'public/', $logo->image))) {
            Storage::delete(str_replace('/storage/', 'public/', $logo->image));
        }

        $logo->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
