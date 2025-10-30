<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    // 📥 List all videos
    public function index()
    {
        return response()->json(Video::orderBy('id', 'desc')->get());
    }

    // 📤 Store new video
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimetypes:video/mp4,video/ogg,video/webm|max:51200', // max 50MB
            'status' => 'required|in:active,inactive',
        ]);

        // store video
        $path = $request->file('video')->store('videos', 'public');

        $video = Video::create([
            'title' => $request->title,
            'path' => $path,
            'status' => $request->status,
        ]);

        return response()->json($video, 201);
    }

    // ✏️ Update video
 public function update(Request $request, $id)
{
    $video = Video::findOrFail($id);

    $request->validate([
        'title' => 'sometimes|string|max:255',
        'status' => 'sometimes|in:active,inactive',
        'video' => 'sometimes|file|mimetypes:video/mp4,video/ogg,video/webm|max:51200',
    ]);

    if ($request->hasFile('video')) {
        if ($video->path && Storage::disk('public')->exists($video->path)) {
            Storage::disk('public')->delete($video->path);
        }
        $video->path = $request->file('video')->store('videos', 'public');
    }

    if ($request->has('title')) {
        $video->title = $request->title;
    }

    if ($request->has('status')) {
        $video->status = $request->status;
    }

    $video->save();

    return response()->json($video);
}



    // 🗑 Delete video
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        if ($video->path && Storage::disk('public')->exists($video->path)) {
            Storage::disk('public')->delete($video->path);
        }
        $video->delete();

        return response()->json(['message' => 'Video deleted successfully']);
    }
}
