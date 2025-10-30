<?php

namespace App\Http\Controllers;
use App\Models\WebFooterLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebFooterLogoController extends Controller
{
    // List all footer images
    public function index()
    {
        return response()->json(WebFooterLogo::latest()->get());
    }

    // Store new footer image
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        // Save image to storage/public/footer-images
        $path = $request->file('image')->store('footer-images', 'public');

        $logo = WebFooterLogo::create([
            'filename' => $request->file('image')->getClientOriginalName(),
            'image' => $path,
            'width' => $request->width,
            'height' => $request->height,
            'status' => $request->status,
        ]);

        return response()->json($logo, 201);
    }

    // Update footer image
    public function update(Request $request, $id)
    {
        $logo = WebFooterLogo::findOrFail($id);

        $request->validate([
            'width' => 'integer',
            'height' => 'integer',
            'status' => 'in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($logo->image && Storage::disk('public')->exists($logo->image)) {
                Storage::disk('public')->delete($logo->image);
            }
            $path = $request->file('image')->store('footer-images', 'public');
            $logo->filename = $request->file('image')->getClientOriginalName();
            $logo->image = $path;
        }

        $logo->update([
            'width' => $request->width ?? $logo->width,
            'height' => $request->height ?? $logo->height,
            'status' => $request->status ?? $logo->status,
        ]);

        return response()->json($logo);
    }

    // Delete footer image
    public function destroy($id)
    {
        $logo = WebFooterLogo::findOrFail($id);

        if ($logo->image && Storage::disk('public')->exists($logo->image)) {
            Storage::disk('public')->delete($logo->image);
        }

        $logo->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
