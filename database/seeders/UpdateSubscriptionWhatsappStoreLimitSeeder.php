<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\Plan;

class UpdateSubscriptionWhatsappStoreLimitSeeder extends Seeder
{
    public function run(): void
    {
        Subscription::chunk(100, function ($subscriptions) {
            foreach ($subscriptions as $subscription) {
                $plan = Plan::find($subscription->plan_id);

                if ($plan && isset($plan->no_of_whatsapp_store)) {
                    $subscription->no_of_whatsapp_store = $plan->no_of_whatsapp_store;
                    $subscription->save();
                }
            }
        });

        $this->command->info('Updated no_of_whatsapp_store in subscriptions table.');
    }
}
