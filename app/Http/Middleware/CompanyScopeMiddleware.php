<?php

namespace App\Http\Middleware;

use App\Models\Scopes\CompanyScope;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyScopeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        CompanyScope::set($request->user()?->company_id);

        return $next($request);
    }
}
