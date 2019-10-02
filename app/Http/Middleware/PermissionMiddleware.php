<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        return $next($request);
        if ($request->user()->hasRole('system-admin')) {
            return $next($request);
        }

        $permissions = auth()->user()->permissions;

        if ($permissions && auth()->user()->permissions->pluck('name')->contains($permission)){
            return $next($request);
        }

        foreach (auth()->user()->roles ?? [] as $role){
            if ($role->permissions->pluck('name')->contains($permission)){
                return $next($request);
            }
        }

        return back()->with('error', 'Your are not permitted to this action !');
    }
}
