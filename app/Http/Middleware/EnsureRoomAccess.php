<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRoomAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roomId = $request->route('room');
        $userId = Auth::id();
        $auth = \App\Models\Room::where('id', $roomId)->where(function($query) use ($userId) {
            $query->where('owner_id', $userId)->orWhere('asked_id', $userId);
        })->first();

        if(!$auth) return redirect()->to(route('profile.index'));;
        return $next($request);
    }
}
