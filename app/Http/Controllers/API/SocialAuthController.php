<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use App\Models\MultiTenant;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Google\Service\ApigeeRegistry\Api;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AppBaseController;

class SocialAuthController extends AppBaseController
{
    public function googleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);
        $input = $request->all();

        $existingUser = User::whereEmail($input['email'])->first();

        if ($existingUser) {
            $token = $existingUser->createToken('token')->plainTextToken;

            if ($existingUser->hasRole(Role::ROLE_SUPER_ADMIN)) {
                $data = [
                    'token' => $token,
                    'user_id' => $existingUser->id,
                    'role' => 'Super Admin',
                ];
            } elseif ($existingUser->hasRole(Role::ROLE_ADMIN)) {
                $data = [
                    'token' => $token,
                    'user_id' => $existingUser->id,
                    'role' => 'Admin',
                ];
            } elseif ($existingUser->hasRole(Role::ROLE_USER)) {
                $data = [
                    'token' => $token,
                    'user_id' => $existingUser->id,
                    'role' => 'User',
                ];
            }
            return $this->sendResponse($data, __('Logged in successfully.'));
        }

        $tenant = MultiTenant::create(['tenant_username' => $input['name']]);
        $userDefaultLanguage = Setting::where('key', 'user_default_language')->first()->value ?? 'en';

        $user = User::create([
            'first_name' => $input['name'],
            'last_name' => $input['last_name'] ?? '',
            'email' => $input['email'],
            'language' => $userDefaultLanguage,
            'tenant_id' => $tenant->id,
            'affiliate_code' => generateUniqueAffiliateCode(),
        ])->assignRole(Role::ROLE_ADMIN);

        $plan = Plan::whereIsDefault(true)->first();

        Subscription::create([
            'plan_id' => $plan->id,
            'plan_amount' => $plan->price,
            'plan_frequency' => Plan::MONTHLY,
            'starts_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addDays($plan->trial_days),
            'trial_ends_at' => Carbon::now()->addDays($plan->trial_days),
            'status' => Subscription::ACTIVE,
            'tenant_id' => $tenant->id,
            'no_of_vcards' => $plan->no_of_vcards,
        ]);

        $user->assignRole(Role::ROLE_ADMIN);

        $token = $user->createToken('token')->plainTextToken;

        $data = [
            'token' => $token,
            'user_id' => $user->id,
            'role' => Role::ROLE_ADMIN,
        ];

        return $this->sendResponse($data, __('Logged in successfully.'));
    }
}
