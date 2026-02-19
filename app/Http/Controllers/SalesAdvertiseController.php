<?php

namespace App\Http\Controllers;

use App\Models\SalesAdvertiseSetting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;

class SalesAdvertiseController extends Controller
{
    // ─────────────────────────────────────────────
    //  Super-admin: edit/update a sales user's ad settings
    // ─────────────────────────────────────────────

  /**
   * Show the ad-settings edit form for a given sales user (super_admin only).
   */
  public function edit(int $userId): \Illuminate\View\View
  {
    $salesUser = User::whereHas('roles', fn($q) => $q->where('name', 'sales'))
      ->findOrFail($userId);

    $setting = SalesAdvertiseSetting::firstOrNew(['user_id' => $userId]);

    return view('sales_advertise.edit', compact('salesUser', 'setting'));
  }

  /**
   * Save ad settings (super_admin: can toggle is_enabled + duration + images).
   */
  public function update(Request $request, int $userId): RedirectResponse
  {
    $salesUser = User::whereHas('roles', fn($q) => $q->where('name', 'sales'))
      ->findOrFail($userId);

    $request->validate([
      'is_enabled'   => 'required|in:0,1',
      'duration'     => 'required|integer|min:1|max:5',
      'images.*'     => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240',
    ]);

    $setting = SalesAdvertiseSetting::firstOrNew(['user_id' => $userId]);
    $setting->user_id    = $userId;
    $setting->is_enabled = (bool) $request->input('is_enabled');
    $setting->duration   = (int) $request->input('duration', 3);

    // Handle image uploads
    $existingImages = $setting->images ?? [];
    $impressions = $setting->impressions ?? [];

    // Handle deletions
    $deleteIndexes = $request->input('delete_images', []);
    foreach ($deleteIndexes as $idx) {
      if (isset($existingImages[$idx])) {
        $path = $existingImages[$idx];
        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
          File::delete($fullPath);
        }
        unset($existingImages[$idx]);
        // Remove impression for this path
        unset($impressions[$path]);
      }
    }
    $existingImages = array_values($existingImages);

    // Handle new uploads
    if ($request->hasFile('images')) {
      $uploadDir = public_path('uploads/sales_advertise/' . $userId);
      if (!File::isDirectory($uploadDir)) {
        File::makeDirectory($uploadDir, 0755, true);
      }

      foreach ($request->file('images') as $file) {
        if (count($existingImages) >= 5) {
          break; // max 5 images
        }

        $img = Image::make($file);

        // Resize & crop to portrait reel format (1080×1920 / 9:16) with center-crop
        $img->fit(1080, 1920, function ($constraint) {
          $constraint->upsize();
        });

        $filename = time() . '_' . uniqid() . '.jpg';
        $img->save($uploadDir . '/' . $filename, 80); // 80% quality JPEG

        $existingImages[] = 'uploads/sales_advertise/' . $userId . '/' . $filename;
      }
    }

    $setting->images = $existingImages;
    $setting->save();

    Flash::success(__('messages.sales_advertise.updated_successfully'));

    return redirect()->route('sadmin.sales.advertise.edit', $userId);
  }

    // ─────────────────────────────────────────────
    //  Sales user: view/edit own ad (duration + images only)
    // ─────────────────────────────────────────────

  /**
   * Show the sales user's own ad-settings page.
   * Only accessible when is_enabled = true for this user.
   */
  public function salesEdit(): \Illuminate\View\View
  {
    $userId  = Auth::id();
    $setting = SalesAdvertiseSetting::where('user_id', $userId)->first();

    // If not enabled, deny
    if (!$setting || !$setting->is_enabled) {
      abort(403, __('messages.sales_advertise.not_enabled'));
    }

    return view('sales_advertise.sales_edit', compact('setting'));
  }

  /**
   * Sales user updates their own duration + images.
   */
  public function salesUpdate(Request $request): RedirectResponse
  {
    $userId  = Auth::id();
    $setting = SalesAdvertiseSetting::where('user_id', $userId)->first();

    if (!$setting || !$setting->is_enabled) {
      abort(403, __('messages.sales_advertise.not_enabled'));
    }

    $request->validate([
      'duration'  => 'required|integer|min:1|max:5',
      'images.*'  => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:500',
    ]);

    $setting->duration = (int) $request->input('duration', 3);

    // Handle image deletions
    $existingImages = $setting->images ?? [];
    $impressions = $setting->impressions ?? [];
    $deleteIndexes  = $request->input('delete_images', []);
    foreach ($deleteIndexes as $idx) {
      if (isset($existingImages[$idx])) {
        $path = $existingImages[$idx];
        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
          File::delete($fullPath);
        }
        unset($existingImages[$idx]);
        // Remove impression for this path
        unset($impressions[$path]);
      }
    }
    $existingImages = array_values($existingImages);

    // Handle new uploads
    if ($request->hasFile('images')) {
      $uploadDir = public_path('uploads/sales_advertise/' . $userId);
      if (!File::isDirectory($uploadDir)) {
        File::makeDirectory($uploadDir, 0755, true);
      }

      foreach ($request->file('images') as $file) {
        if (count($existingImages) >= 5) {
          break;
        }

        $img = Image::make($file);

        // Resize & crop to portrait reel format (1080×1920 / 9:16) with center-crop
        // $img->fit(1080, 1920, function ($constraint) {
        //   $constraint->upsize();
        // });

        $filename = time() . '_' . uniqid() . '.jpg';
        $img->save($uploadDir . '/' . $filename, 80);

        $existingImages[] = 'uploads/sales_advertise/' . $userId . '/' . $filename;
      }
    }

    $setting->images = $existingImages;
    $setting->save();

    Flash::success(__('messages.sales_advertise.updated_successfully'));

    return redirect()->route('sales.advertise.edit');
  }

    // ─────────────────────────────────────────────
    //  Public: serve interstitial ad before redirect
    // ─────────────────────────────────────────────

  /**
   * Check if a sales user has active ads and return an interstitial ad view.
   * Returns null if no ad should be shown (feature disabled, no images, etc.).
   *
   * Round-robin cycling: next image index = sum(all impressions) % count(images)
   * Impression for that image is incremented immediately (on page serve).
   *
   * @param  int    $assignedUserId  The sales user id (assigned_id on redirect link)
   * @param  string $destinationUrl  The final URL to redirect to after the ad
   * @return \Illuminate\View\View|null
   */
  public function showAdBeforeRedirect(int $assignedUserId, string $destinationUrl): ?\Illuminate\View\View
  {
    $setting = SalesAdvertiseSetting::where('user_id', $assignedUserId)->first();

    // Guard: feature disabled or no images
    if (!$setting || !$setting->is_enabled) {
      return null;
    }

    $images = $setting->images ?? [];
    if (empty($images)) {
      return null;
    }

    // Determine which image to show (round-robin)
    $impressions  = $setting->impressions ?? [];
    $totalShown   = array_sum($impressions);
    $imageCount   = count($images);
    $nextIndex    = $totalShown % $imageCount;

    // Increment impression for this image
    $impressions[$nextIndex] = ($impressions[$nextIndex] ?? 0) + 1;
    $setting->impressions    = $impressions;
    $setting->save();

    $imageUrl   = asset($images[$nextIndex]);
    $duration   = max(1, (int) $setting->duration);

    return view('sales_advertise.ad_display', compact('imageUrl', 'duration', 'destinationUrl'));
  }
}