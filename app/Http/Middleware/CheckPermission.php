<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->hasPermissions($request->route()->getName())) {
			if(request()->expectsJson()) {
				return response()->json([
					"status" => false,
					"message" => __("Unauthorized"),
				], 401);
			} else {
				return redirect()->route('unauthorized');
			}
		}
		return $next($request);
    }
}
