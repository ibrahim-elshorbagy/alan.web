<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/admin/razorpay-payment-success',
        '/admin/razorpay-payment-failed',
        '/admin/nfc-razorpay-payment-success',
        '/admin/nfc-razorpay-payment-failed',
        '/product-razorpay-payment-success',
        '/product-razorpay-payment-failed',
        '/phonepe-nfcorder-response',
        '/razorpay-appointment-success',
        '/admin/iyzico-payment-success',
        '/admin/nfc-iyzico-success',
        '/appointment-iyzico-success',
        '/product-iyzico-success',
        // 'sslcommerz/success',
        // 'sslcommerz/failure',
        // 'sslcommerz/cancel',
        // 'sslcommerz/ipn',
        'subscription-iyzico-success',
    ];
}
