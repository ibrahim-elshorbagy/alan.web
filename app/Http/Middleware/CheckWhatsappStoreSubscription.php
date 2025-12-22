<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Vcard;
use App\Models\WhatsappStore;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

//use Route;

class CheckWhatsappStoreSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $request = $next($request);

        $urlAlias = Route::current()->parameters['alias'];
        $wpStore = WhatsappStore::select(['id', 'tenant_id'])->whereUrlAlias($urlAlias)->firstOrFail();

        /** @var User $user */
        $user = User::whereTenantId($wpStore->tenant_id)->with('subscription')->first();

        if ($user->subscription->ends_at > Carbon::now()->format('Y-m-d H:i:s')) {
            return $request;
        }

        return abort(404);
    }
}
