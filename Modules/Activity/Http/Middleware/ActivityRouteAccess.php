<?php

namespace Modules\Activity\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Activity\Entities\ActivityLog;

class ActivityRouteAccess {

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // só continua se usuário autenticado e rota tiver nome
        if (!auth()->check() || !$request->route()?->getName()) {
            return $response;
        }

        $routeName = $request->route()->getName();

        $ignored = config('activity.ignored_routes', []);

        if (in_array($routeName, $ignored, TRUE)) {
            return $response;
        }

        // aqui grava normalmente
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'event'      => 'route',
            'target'     => $routeName,
            'url'        => $request->fullUrl(),
            'action'     => $request->method(),
            'ip'         => $request->ip(),
        ]);

        return $response;
    }

}