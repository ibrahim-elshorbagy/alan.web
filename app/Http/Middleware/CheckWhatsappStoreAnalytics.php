<?php

namespace App\Http\Middleware;

use App\Models\WhatsappStore;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWhatsappStoreAnalytics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $whatsappStore = WhatsappStore::with(['tenant.user', 'template'])->where('tenant_id',
                    getLogInTenantId())->pluck('id')->toArray();
        if (in_array($request->whatsappStore->id, $whatsappStore)) {
            return $next($request);
        } else {
            abort('404');
        }
    }
}