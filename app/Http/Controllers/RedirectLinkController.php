<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedirectLink;
use App\Models\User;
use App\Models\Nfc;
use Illuminate\Support\Facades\Validator;

class RedirectLinkController extends Controller
{
  public function index()
  {
    return view('admin.redirect_links.index');
  }

  public function edit($id)
  {
    $redirectLink = RedirectLink::findOrFail($id);
    $users = User::whereDoesntHave('roles', function ($q) {
      $q->where('name', 'super_admin');
    })->get();
    $nfcs = Nfc::all();

    return view('admin.redirect_links.edit', compact('redirectLink', 'users', 'nfcs'));
  }

  public function update(Request $request, $id)
  {
    $redirectLink = RedirectLink::findOrFail($id);

    $validator = Validator::make($request->all(), [
      'user_id' => 'nullable|exists:users,id',
      'redeem_code' => 'nullable|string|max:16',
      'uri' => 'required|string|unique:redirect_links,uri,' . $id,
      'redirect_link' => 'required|url',
      'redirect_link_type' => 'required|integer|min:1|max:9',
      'status' => 'required|integer|in:0,1',
      'nfcs_id' => 'required|exists:nfcs,id',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $redirectLink->update($request->all());

    return redirect()->route('redirect-links.index')->with('success', __('messages.redirect_links.updated'));
  }

  public function redirectLink(RedirectLink $uri)
  {
    if ($uri->status != RedirectLink::STATUS_REDEEMED) {
      abort(404);
    }

    if (!filter_var($uri->redirect_link, FILTER_VALIDATE_URL)) {
      abort(404);
    }

    return redirect()->away($uri->redirect_link);
  }
}
