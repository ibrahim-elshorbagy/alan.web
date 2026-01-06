<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectLinkController extends Controller
{
  public function index()
  {
    return view('admin.redirect_links.index');
  }

  public function redirectLink(\App\Models\RedirectLink $uri)
  {
    if ($uri->status != \App\Models\RedirectLink::STATUS_REDEEMED) {
      abort(404);
    }

    if (!filter_var($uri->redirect_link, FILTER_VALIDATE_URL)) {
      abort(404);
    }

    return redirect()->away($uri->redirect_link);
  }
}
