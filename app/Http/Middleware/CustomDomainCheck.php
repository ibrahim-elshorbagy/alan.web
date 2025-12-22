<?php

namespace App\Http\Middleware;

use App\Models\CustomDomain;
use App\Models\Vcard;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomDomainCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $domain = request()->getHttpHost();
        $appDomain = !empty(config('app.domain')) ? config('app.domain') : parse_url(config('app.url'), PHP_URL_HOST);
        $requestAlias = request()->getRequestUri();
        $requestAlias = str_replace("/", "", $requestAlias);

        if ($appDomain != $domain) { // if not matched it means custom domain

            $customDomain = CustomDomain::where('domain', $domain)->where('is_active', 1)->first();
            if (!$customDomain) {
                abort(404);
            }

            $user = $customDomain->user;

            if (empty($requestAlias)) {
                $firstVcard = Vcard::where('tenant_id', $user->tenant_id)->firstOrFail();
                $vcardAlias = $firstVcard->url_alias;

                return redirect(url("/$vcardAlias"));
            }

            $aliasExistsForSameUser = Vcard::where('url_alias', $requestAlias)->where('tenant_id', $user->tenant_id)->exists();
            if (!$aliasExistsForSameUser) {
                abort(404);
            }
        }

        return $next($request);
    }
}
