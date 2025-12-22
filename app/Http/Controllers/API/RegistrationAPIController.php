<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use App\Mail\VerifyMail;
use App\Models\MultiTenant;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\AffiliateUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateRegisterRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RegistrationAPIController extends AppBaseController
{
    public function register(Request $request)
    {   
    
        $rules = User::$rules;
        // $rules['contact'] = 'required|numeric';
        $rules['password'] = 'required';
        // $rules['term_policy_check'] = 'required';
        // $rules['region_code'] = 'required';

    
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $referral_code = $request->input('referral-code');
        $referral_user = '';

        if ($referral_code) {
            $referral_user = User::where('affiliate_code', $referral_code)->first();
        }
        
        try {
            DB::beginTransaction();
            // Check if the user already exists
            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                // Handle case where email is already registered
                return $this->sendError("Email is already registered.");
            }

            $tenant = MultiTenant::create(['tenant_username' => $request->first_name]);
            $userDefaultLanguage = Setting::where('key', 'user_default_language')->first()->value ?? 'en';

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'language' => $userDefaultLanguage,
                'password' => Hash::make($request->password),
                'contact' => $request->contact,
                'region_code' => $request->region_code,
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

            if ($referral_user) {
                $affiliateUser = new AffiliateUser();
                $affiliateUser->affiliated_by = $referral_user->id;
                $affiliateUser->user_id = $user->id;
                $affiliateUser->amount = 0;
                $affiliateUser->save();
            }

            DB::commit();
            $token = Password::getRepository()->create($user);
            $data['url'] = config('app.url').'/verify-email/'.$user->id.'/'.$token;
            $data['user'] = $user;
            Mail::to($user->email)->send(new VerifyMail($data));

            return $this->sendSuccess("Registration successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
