<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RefundCancellationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $refundCancellationExist = Setting::where('key', 'refund_cancellation')->exists();
        $shippingDeliveryExist = Setting::where('key', 'shipping_delivery')->exists();
     
        if (! $refundCancellationExist) {
            $refundCancellationHtml = view('settings.terms_conditions.refund_cancellation_policy')->render();
            Setting::create(['key' => 'refund_cancellation', 'value' => $refundCancellationHtml]);
        }

        if (! $shippingDeliveryExist) {
            $shippingDeliveryHtml = view('settings.terms_conditions.shipping_delivery_policy')->render();
            Setting::create(['key' => 'shipping_delivery', 'value' => $shippingDeliveryHtml]);
        }
    }
}
