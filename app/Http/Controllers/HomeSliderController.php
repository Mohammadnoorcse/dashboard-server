<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HomeSlider;

class HomeSliderController extends Controller
{
    // List all sliders
    public function index()
    {
        return response()->json(HomeSlider::all());
    }

    // // Store new slider
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    //         'status' => 'required|in:active,inactive',
    //     ]);

    //     // $file = $request->file('image');
    //     // $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
    //     // $file->storeAs('public/home-sliders', $filename);

    //     $file = $request->file('image');
    //     $filename = time() . '_' . $file->getClientOriginalName();
    //     $path = $file->storeAs('home-sliders', $filename, 'public');
        


    //     $slider = HomeSlider::create([
    //         'image' => '/storage/' . $filename,
    //         'status' => $request->status,
    //     ]);
       
    //     return response()->json($slider, 201);
    // }

     // Store new logo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('webheaders', $filename, 'public');

        $logo = HomeSlider::create([
            
            'image' => "/storage/" . $path,
            'status' => $validated['status'],
        ]);

        return response()->json($logo, 201);
    }

    // Show single slider
    public function show(HomeSlider $homeSlider)
    {
        return response()->json($homeSlider);
    }



      // Update
    public function update(Request $request, $id)
    {
        $logo = HomeSlider::findOrFail($id);

        $validated = $request->validate([
            
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
        
            $validated['image'] = "/storage/" . $path;
        }

        $logo->update($validated);

        return response()->json($logo);
    }

    // Delete
    public function destroy($id)
    {
        $logo = HomeSlider::findOrFail($id);

        if ($logo->image && Storage::exists(str_replace('/storage/', 'public/', $logo->image))) {
            Storage::delete(str_replace('/storage/', 'public/', $logo->image));
        }

        $logo->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
