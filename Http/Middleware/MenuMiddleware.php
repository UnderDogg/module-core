<?php

namespace App\Modules\Core\Http\Middleware;

use Closure;
use App\Modules\Core\Services\MenuService;

class MenuMiddleware
{
    public function handle($request, Closure $next)
    {
        app(MenuService::class)->boot();

        return $next($request);
    }
}
