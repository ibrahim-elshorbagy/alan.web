<?php

namespace App\Http\Controllers;

use App\Models\RedirectLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientRedirectLinkController extends Controller
{
  public function index()
  {
    return view('client.redirect_links.index');
  }

  public function edit($id)
  {
    $redirectLink = RedirectLink::where('user_id', auth()->id())->findOrFail($id);

    return view('client.redirect_links.edit', compact('redirectLink'));
  }

  public function update(Request $request, $id)
  {
    $redirectLink = RedirectLink::where('user_id', auth()->id())->findOrFail($id);

    $validator = Validator::make($request->all(), [
      'redirect_link' => 'nullable|url',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $redirectLink->update($request->only(['redirect_link']));

    return redirect()->route('client.redirect-links.index')->with('success', __('messages.redirect_links.updated'));
  }
}