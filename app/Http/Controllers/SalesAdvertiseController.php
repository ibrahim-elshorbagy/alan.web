<?php

namespace App\Http\Controllers;

use App\Models\SalesAdvertiseSetting;
use App\Models\RedirectLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;

class SalesAdvertiseController extends Controller
{
  // ─────────────────────────────────────────────
  //  Update ad settings for a redirect link
  //  Called from both client (admin user) and super_admin
  // ─────────────────────────────────────────────

  /**
   * Save/update ad settings for a specific redirect link.
   * - Normal user (admin): can toggle is_enabled, duration, images on their own links
   * - Super_admin: can do the same on any link
   */
  public function updateForRedirectLink(Request $request, int $redirectLinkId): RedirectResponse
  {
    $user = Auth::user();

    // Find the redirect link
    if ($user->hasRole('super_admin')) {
      $redirectLink = RedirectLink::findOrFail($redirectLinkId);
    } else {
      // Normal user can only edit their own
      $redirectLink = RedirectLink::where('user_id', $user->id)->findOrFail($redirectLinkId);
    }

    $request->validate([
      'ad_is_enabled' => 'required|in:0,1',
      'ad_duration'   => 'required|integer|min:1|max:5',
      'ad_images.*'   => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240',
    ], [], [
      'ad_is_enabled' => __('messages.sales_advertise.enable_advertise'),
      'ad_duration'   => __('messages.sales_advertise.duration_label'),
      'ad_images.*'   => __('messages.sales_advertise.ad_image'),
      'ad_images.0'   => __('messages.sales_advertise.ad_image'),
      'ad_images.1'   => __('messages.sales_advertise.ad_image'),
      'ad_images.2'   => __('messages.sales_advertise.ad_image'),
      'ad_images.3'   => __('messages.sales_advertise.ad_image'),
      'ad_images.4'   => __('messages.sales_advertise.ad_image'),
    ]);

    $setting = SalesAdvertiseSetting::firstOrNew(['redirect_link_id' => $redirectLinkId]);
    $setting->redirect_link_id = $redirectLinkId;
    $setting->is_enabled = (bool) $request->input('ad_is_enabled');
    $setting->duration   = (int) $request->input('ad_duration', 3);

    // Handle image uploads
    $existingImages = $setting->images ?? [];
    $impressions = $setting->impressions ?? [];

    // Handle deletions
    $deleteIndexes = $request->input('ad_delete_images', []);
    foreach ($deleteIndexes as $idx) {
      if (isset($existingImages[$idx])) {
        $path = $existingImages[$idx];
        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
          File::delete($fullPath);
        }
        unset($existingImages[$idx]);
        unset($impressions[$path]);
      }
    }
    $existingImages = array_values($existingImages);

    // Handle new uploads
    if ($request->hasFile('ad_images')) {
      $uploadDir = public_path('uploads/sales_advertise/link_' . $redirectLinkId);
      if (!File::isDirectory($uploadDir)) {
        File::makeDirectory($uploadDir, 0755, true);
      }

      foreach ($request->file('ad_images') as $file) {
        if (count($existingImages) >= 5) {
          break; // max 5 images
        }

        $img = Image::make($file);

        // Resize & crop to portrait reel format (1080×1920 / 9:16) with center-crop
        $img->fit(1080, 1920, function ($constraint) {
          $constraint->upsize();
        });

        $filename = time() . '_' . uniqid() . '.jpg';
        $img->save($uploadDir . '/' . $filename, 80);

        $existingImages[] = 'uploads/sales_advertise/link_' . $redirectLinkId . '/' . $filename;
      }
    }

    $setting->images = $existingImages;
    $setting->impressions = $impressions;
    $setting->save();

    Flash::success(__('messages.sales_advertise.updated_successfully'));

    return redirect()->back();
  }

  // ─────────────────────────────────────────────
  //  Public: serve interstitial ad before redirect
  // ─────────────────────────────────────────────

  /**
   * Check if a redirect link has active ads and return an interstitial ad view.
   * Returns null if no ad should be shown (feature disabled, no images, etc.).
   *
   * Round-robin cycling: next image index = sum(all impressions) % count(images)
   * Impression for that image is incremented immediately (on page serve).
   *
   * @param  int    $redirectLinkId   The redirect link id
   * @param  string $destinationUrl   The final URL to redirect to after the ad
   * @return \Illuminate\View\View|null
   */
  public function showAdBeforeRedirect(int $redirectLinkId, string $destinationUrl): ?\Illuminate\View\View
  {
    $setting = SalesAdvertiseSetting::where('redirect_link_id', $redirectLinkId)->first();

    // Guard: feature disabled or no images
    if (!$setting || !$setting->is_enabled) {
      return null;
    }

    $images = $setting->images ?? [];
    if (empty($images)) {
      return null;
    }

    // Determine which image to show (round-robin, keyed by image path)
    $rawImpressions = $setting->impressions ?? [];

    // Build a path-keyed impression map for only the current images
    $pathCounts = [];
    foreach ($images as $path) {
      $pathCounts[$path] = $rawImpressions[$path] ?? 0;
    }

    $totalShown = array_sum($pathCounts);
    $imageCount = count($images);
    $nextIndex  = $totalShown % $imageCount;
    $imagePath  = $images[$nextIndex];

    // Increment impression for this image path
    $pathCounts[$imagePath] = ($pathCounts[$imagePath] ?? 0) + 1;
    $setting->impressions   = $pathCounts;
    $setting->save();

    $imageUrl   = asset($imagePath);
    $duration   = max(1, (int) $setting->duration);

    return view('sales_advertise.ad_display', compact('imageUrl', 'duration', 'destinationUrl'));
  }
}
