<?php
namespace Centauri\CMS\Middleware;

use Closure;

class DomainMiddleware
{
    public function handle($request, Closure $next) 
    {
        dd("HALLOOO");

        $route = $request->route();
        $domain = $route->parameter("domain");
        $tld = $route->parameter("tld");

        $route->forgetParameter("domain");
        $route->forgetParameter("tld");

        return $next($request);
    }
}
