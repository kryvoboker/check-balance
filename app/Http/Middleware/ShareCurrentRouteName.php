<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareCurrentRouteName
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current_route = $request->route();
        $current_route_name = '';

        if ($current_route instanceof Route) {
            $current_route_name = $current_route->getName();
        }

        View::share(compact('current_route_name'));

        return $next($request);
    }
}
