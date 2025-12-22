<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Vcard;
use App\Models\Analytic;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Models\WhatsappStore;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

//use Route;

class Analytics
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uri = str_replace($request->root(), '', $request->url()) ?: '/';
        $urlAlias = Route::current()->parameters['alias'];
        $vcardId = Vcard::select('id')->where('url_alias', $urlAlias)->pluck('id')->toArray();
        $whatsappStoreId = WhatsappStore::select('id')->where('url_alias', $urlAlias)->pluck('id')->toArray();
        if (! $vcardId && ! $whatsappStoreId) {
            return abort('404');
        }

        $agent = new Agent();
        if (! $agent->isRobot()) {
            $agent->setUserAgent($request->headers->get('user-agent'));
            $agent->setHttpHeaders($request->headers);
            $sessionExists = Analytic::where('session', $request->session()->getId())
                ->when($vcardId, fn($q) => $q->where('vcard_id', $vcardId[0]))
                ->when($whatsappStoreId, fn($q) => $q->where('whatsapp_store_id', $whatsappStoreId[0]))
                ->exists();
            if ($sessionExists) {
                return $next($request);
            }

            $items = implode($agent->languages());
            $lang = substr($items, 0, 2);
            $ip = Location::get($request->ip());
            $country = $ip ? $ip->countryName : '';
            Analytic::create([
                'session' => $request->session()->getId(),
                'vcard_id' => $vcardId[0] ?? null,
                'whatsapp_store_id' => $whatsappStoreId[0] ?? null,
                'uri' => $uri,
                'source' => $request->headers->get('referer'),
                'country' => $country,
                'browser' => $agent->browser() ?? null,
                'device' => $agent->deviceType(),
                'operating_system' => $agent->platform(),
                'ip' => $request->ip(),
                'language' => $lang,
                'meta' => json_encode(Location::get($request->ip())),
            ]);

            return $next($request);
        }

        return $next($request);
    }
}
