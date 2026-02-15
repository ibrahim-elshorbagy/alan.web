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
      'name' => 'nullable|string|max:255',
      'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120', // 5MB max
    ]);

    $image = $request->file('image');
    $filename = $image->hashName();
    $image->move(public_path('uploads/cover_images'), $filename);

    // If name is not provided, use the original filename without extension
    $name = $request->name;
    if (empty($name)) {
      $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
    }

    CoverImage::create([
      'name' => $name,
      'path' => $filename,
    ]);

    Flash::success(__('messages.cover_image.cover_image_created'));

    return redirect()->back();
  }

  public function update(Request $request, CoverImage $coverImage)
  {
    $request->validate([
      'name' => 'nullable|string|max:255',
      'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
    ]);

    if ($request->hasFile('image')) {
      // Delete old image
      $oldImagePath = public_path('uploads/cover_images/' . $coverImage->path);
      if (file_exists($oldImagePath)) {
        unlink($oldImagePath);
      }

      $image = $request->file('image');
      $filename = $image->hashName();
      $image->move(public_path('uploads/cover_images'), $filename);
      $coverImage->path = $filename;

      // If name is not provided when uploading new image, use the filename
      if (empty($request->name)) {
        $coverImage->name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
      } else {
        $coverImage->name = $request->name;
      }
    } else {
      // If no new image, only update name if provided
      if (!empty($request->name)) {
        $coverImage->name = $request->name;
      }
    }

    $coverImage->save();

    Flash::success(__('messages.cover_image.cover_image_updated'));

    return redirect()->back();
  }

  public function destroy(CoverImage $coverImage)
  {
    $imagePath = public_path('uploads/cover_images/' . $coverImage->path);
    if (file_exists($imagePath)) {
      unlink($imagePath);
    }
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
