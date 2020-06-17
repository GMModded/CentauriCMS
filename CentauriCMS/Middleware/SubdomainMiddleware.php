<?php
namespace Centauri\CMS\Middleware;

use Closure;

class SubdomainMiddleware
{
    public function handle($request, Closure $next) 
    {
        dd("HALLOOO");
        $route = $request->route();
        $domain = $route->parameter('domain');
        $tld = $route->parameter('tld');

        // do something with your params

        $route->forgetParameter('domain');
        $route->forgetParameter('tld');

        return $next($request);
    }
}
