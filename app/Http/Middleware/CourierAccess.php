<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CourierAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('courier')->guest()) {
            return redirect('/courier/login');
        }
        
        if (Auth::guard('customer')->check()) {
            return redirect('/');
        }
    
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/myprofile');
        }
        
        return $next($request);
    }
}
