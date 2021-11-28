<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineStatusUpdater
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(Auth::id());
        if($user) {
            $user->setLastActivity(now()->format('Y-m-d H:i:s'));
        }
        return $next($request);
    }
}
