<?php

namespace App\Http\Controllers;

class UsedCouponCodeController extends Controller
{
    public function index()
    {
        return view('sadmin.used_coupon_code.index');
    }
}
