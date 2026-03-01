<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\RedirectLink;
use App\Models\SalesAdvertiseSetting;
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
      'ad_duration'   => 'required|integer|min:1|max:10',
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

    // Contest data — find the enabled contest for this redirect link
    $contest = null;
    $enabledContest = Contest::where('redirect_link_id', $redirectLinkId)
      ->where('is_enabled', true)
      ->first();

    if ($enabledContest && $enabledContest->draw_date && $enabledContest->draw_date->isFuture()) {
      $contest = [
        'title'     => $enabledContest->title,
        'text'      => $enabledContest->text,
        'draw_date' => $enabledContest->draw_date->toIso8601String(),
        'join_url'  => route('contest.join', $enabledContest->id),
      ];
    }

    return view('sales_advertise.ad_display', compact('imageUrl', 'duration', 'destinationUrl', 'contest'));
  }

  // ─────────────────────────────────────────────
  //  Contest CRUD
  // ─────────────────────────────────────────────

  /**
   * Show the create contest form page.
   */
  public function createContestForm(Request $request, int $redirectLinkId)
  {
    $user = Auth::user();
    $redirectLink = $this->resolveRedirectLink($user, $redirectLinkId);
    return view('admin.contests.create', compact('redirectLink'));
  }

  /**
   * Show the edit contest form page.
   */
  public function editContestForm(Request $request, int $contestId)
  {
    $user = Auth::user();
    $contest = Contest::findOrFail($contestId);
    $this->resolveRedirectLink($user, $contest->redirect_link_id);
    return view('admin.contests.edit', compact('contest'));
  }

  /**
   * Store a new contest for a redirect link.
   */
  public function storeContest(Request $request, int $redirectLinkId)
  {
    $user = Auth::user();
    $redirectLink = $this->resolveRedirectLink($user, $redirectLinkId);

    $request->validate([
      'title'       => 'required|string|max:255',
      'text'        => 'nullable|string|max:2000',
      'draw_date'   => 'required|date|after:now',
      'num_winners' => 'required|integer|min:1',
    ]);

    Contest::create([
      'redirect_link_id' => $redirectLink->id,
      'title'            => $request->input('title'),
      'text'             => $request->input('text'),
      'draw_date'        => $request->input('draw_date'),
      'is_enabled'       => false,
      'num_winners'      => $request->input('num_winners'),
    ]);

    if ($request->ajax()) {
      return response()->json(['success' => true, 'message' => __('messages.contest.created_successfully')]);
    }

    Flash::success(__('messages.contest.created_successfully'));
    $editRoute = $user->hasRole('super_admin') ? 'redirect-links.edit' : 'client.redirect-links.edit';
    return redirect()->route($editRoute, $redirectLink->id);
  }

  /**
   * Update an existing contest.
   */
  public function updateContest(Request $request, int $contestId)
  {
    $user = Auth::user();
    $contest = Contest::findOrFail($contestId);
    $this->resolveRedirectLink($user, $contest->redirect_link_id);

    $request->validate([
      'title'       => 'required|string|max:255',
      'text'        => 'nullable|string|max:2000',
      'draw_date'   => 'required|date',
      'num_winners' => 'required|integer|min:1',
    ]);

    $contest->update([
      'title'       => $request->input('title'),
      'text'        => $request->input('text'),
      'draw_date'   => $request->input('draw_date'),
      'num_winners' => $request->input('num_winners'),
    ]);

    if ($request->ajax()) {
      return response()->json(['success' => true, 'message' => __('messages.contest.updated_successfully')]);
    }

    Flash::success(__('messages.contest.updated_successfully'));
    $editRoute = $user->hasRole('super_admin') ? 'redirect-links.edit' : 'client.redirect-links.edit';
    return redirect()->route($editRoute, $contest->redirect_link_id);
  }

  /**
   * Delete a contest and its participants.
   */
  public function destroyContest(Request $request, int $contestId)
  {
    $user = Auth::user();
    $contest = Contest::findOrFail($contestId);
    $this->resolveRedirectLink($user, $contest->redirect_link_id);

    $contest->delete();

    if ($request->ajax()) {
      return response()->json(['success' => true]);
    }

    Flash::success(__('messages.contest.deleted_successfully'));
    return redirect()->back();
  }

  /**
   * Toggle a contest's enabled state.
   * Only one contest can be enabled per redirect link at a time.
   */
  public function toggleContest(Request $request, int $contestId)
  {
    $user = Auth::user();
    $contest = Contest::findOrFail($contestId);
    $this->resolveRedirectLink($user, $contest->redirect_link_id);

    if ($contest->is_enabled) {
      $contest->update(['is_enabled' => false]);
      $label = __('messages.contest.disabled');
      Flash::success(__('messages.contest.disabled_successfully'));
    } else {
      $disabledIds = Contest::where('redirect_link_id', $contest->redirect_link_id)
        ->where('id', '!=', $contest->id)
        ->where('is_enabled', true)
        ->pluck('id')->toArray();
      Contest::where('redirect_link_id', $contest->redirect_link_id)
        ->where('id', '!=', $contest->id)
        ->update(['is_enabled' => false]);
      $contest->update(['is_enabled' => true]);
      $label = __('messages.contest.enabled');
      Flash::success(__('messages.contest.enabled_successfully'));
    }

    if ($request->ajax()) {
      return response()->json([
        'success'        => true,
        'is_enabled'     => $contest->is_enabled,
        'label'          => $label,
        'disabled_ids'   => $disabledIds ?? [],
        'disabled_label' => __('messages.contest.disabled'),
        'message'        => $contest->is_enabled ? __('messages.contest.enabled_successfully') : __('messages.contest.disabled_successfully'),
      ]);
    }

    return redirect()->back();
  }

  /**
   * Randomly select winners for a contest.
   * Replaces any previously selected winners.
   */
  public function selectWinners(int $contestId): RedirectResponse
  {
    $user = Auth::user();
    $contest = Contest::findOrFail($contestId);
    $this->resolveRedirectLink($user, $contest->redirect_link_id);

    $numWinners = $contest->num_winners;
    $totalParticipants = $contest->participants()->count();

    if ($totalParticipants === 0) {
      Flash::error(__('messages.contest.no_participants_to_draw'));
      return redirect()->back();
    }

    // Clear previous winners
    $contest->participants()->update(['winner_rank' => null, 'won_at' => null]);

    // Randomly pick winners
    $winners = $contest->participants()
      ->inRandomOrder()
      ->limit(min($numWinners, $totalParticipants))
      ->get();

    $now = now();
    foreach ($winners as $index => $winner) {
      $winner->update([
        'winner_rank' => $index + 1,
        'won_at'      => $now,
      ]);
    }

    Flash::success(__('messages.contest.winners_selected', ['count' => $winners->count()]));
    return redirect()->back();
  }

  // ─────────────────────────────────────────────
  //  Public: Contest join page + store participant
  // ─────────────────────────────────────────────

  /**
   * Show the contest join form.
   */
  public function showContestJoinForm(int $contestId)
  {
    $contest = Contest::with('redirectLink')->findOrFail($contestId);

    if (!$contest->is_enabled || !$contest->draw_date || $contest->draw_date->isPast()) {
      abort(404);
    }

    return view('sales_advertise.contest_join', [
      'contest' => $contest,
    ]);
  }

  /**
   * Store a new contest participant.
   */
  public function storeContestParticipant(Request $request, int $contestId)
  {
    $contest = Contest::findOrFail($contestId);

    if (!$contest->is_enabled || !$contest->draw_date || $contest->draw_date->isPast()) {
      abort(404);
    }

    $request->validate([
      'name'  => 'required|string|max:255',
      'phone' => ['required', 'string', 'regex:/^(0?7[789]\d{7}|9627[789]\d{7})$/'],
    ], [
      'phone.regex' => __('messages.contest.invalid_jordan_phone'),
    ], [
      'name'  => __('messages.contest.participant_name'),
      'phone' => __('messages.contest.participant_phone'),
    ]);

    // Normalize phone: 07X -> 962 7X
    $phone = $request->input('phone');
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (preg_match('/^0(7[789]\d{7})$/', $phone, $m)) {
      $phone = '962' . $m[1];
    }

    $phone = normalizePhoneNumber($phone);

    // Check if phone already joined this contest
    $exists = ContestParticipant::where('contest_id', $contestId)
      ->where('phone', $phone)
      ->exists();

    if ($exists) {
      return redirect()->back()->with('error', __('messages.contest.already_joined'));
    }

    ContestParticipant::create([
      'contest_id' => $contestId,
      'name'       => $request->input('name'),
      'phone'      => $phone,
    ]);

    return redirect()->back()->with('success', __('messages.contest.joined_successfully'));
  }

  // ─────────────────────────────────────────────
  //  Admin: Contest participants list
  // ─────────────────────────────────────────────

  /**
   * Show participants for a specific contest.
   */
  public function contestParticipants(Request $request, int $contestId)
  {
    $user = Auth::user();
    $contest = Contest::findOrFail($contestId);
    $redirectLink = $this->resolveRedirectLink($user, $contest->redirect_link_id);

    $query = ContestParticipant::where('contest_id', $contestId);

    // Search filter
    if ($request->filled('search')) {
      $search = $request->input('search');
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')
          ->orWhere('phone', 'like', '%' . $search . '%');
      });
    }

    if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->input('date_from'));
    }

    if ($request->filled('date_to')) {
      $query->whereDate('created_at', '<=', $request->input('date_to'));
    }

    $participants = $query->orderBy('created_at', 'desc')->paginate(25)->withQueryString();
    $totalCount = ContestParticipant::where('contest_id', $contestId)->count();
    $winners = ContestParticipant::where('contest_id', $contestId)->whereNotNull('winner_rank')->orderBy('winner_rank')->get();

    return view('sales_advertise.contest_participants', compact('redirectLink', 'contest', 'participants', 'totalCount', 'winners'));
  }

  // ─────────────────────────────────────────────
  //  Helper: resolve redirect link by role
  // ─────────────────────────────────────────────

  private function resolveRedirectLink($user, int $redirectLinkId): RedirectLink
  {
    if ($user->hasRole('super_admin')) {
      return RedirectLink::findOrFail($redirectLinkId);
    }
    return RedirectLink::where('user_id', $user->id)->findOrFail($redirectLinkId);
  }
}
