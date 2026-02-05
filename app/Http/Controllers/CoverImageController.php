<?php

namespace App\Http\Controllers;

use App\Models\CoverImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;

class CoverImageController extends AppBaseController
{
  public function index()
  {
    $coverImages = CoverImage::all();

    return view('settings.cover_images', compact('coverImages'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120', // 5MB max
    ]);

    $image = $request->file('image');
    $path = $image->store('cover_images', 'public');

    CoverImage::create([
      'name' => $request->name,
      'path' => basename($path),
    ]);

    Flash::success(__('messages.cover_image.cover_image_created'));

    return redirect()->back();
  }

  public function update(Request $request, CoverImage $coverImage)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
    ]);

    if ($request->hasFile('image')) {
      // Delete old image
      Storage::disk('public')->delete('cover_images/' . $coverImage->path);

      $image = $request->file('image');
      $path = $image->store('cover_images', 'public');
      $coverImage->path = basename($path);
    }

    $coverImage->name = $request->name;
    $coverImage->save();

    Flash::success(__('messages.cover_image.cover_image_updated'));

    return redirect()->back();
  }

  public function destroy(CoverImage $coverImage)
  {
    Storage::disk('public')->delete('cover_images/' . $coverImage->path);
    $coverImage->delete();

    Flash::success(__('messages.cover_image.cover_image_deleted'));

    return redirect()->back();
  }

  public function updateStatus(CoverImage $coverImage)
  {
    $coverImage->status = !$coverImage->status;
    $coverImage->save();

    return response()->json(['success' => true]);
  }
}
