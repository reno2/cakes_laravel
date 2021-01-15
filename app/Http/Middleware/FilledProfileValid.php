<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Auth;

class FilledProfileValid
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure                 $next
     * @param ProfileRepository        $profileRepository
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!(new ProfileRepository())->checkIfCanAddAds(Auth::user())) {
            return redirect()->route('profile.edit')->with('danger', 'Необходимо заполнить поля адреса и контактов');
        }
        return $next($request);
    }

}
