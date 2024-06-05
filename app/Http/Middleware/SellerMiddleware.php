<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role_id == User::SELLER_ROLE_ID) {
            return $next($request);
        } else {
            return redirect()->route('home');
        }
    }
}


// public function handle(Request $request, Closure $next): Response
// {
//     if (Auth::check() && Auth::user()->role_id == User::ADMIN_ROLE_ID) {
//         return $next($request); // allows access
//     } else {
//         return redirect()->route('home');
//     }
// }