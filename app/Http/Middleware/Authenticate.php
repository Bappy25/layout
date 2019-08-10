<?php

namespace App\Http\Middleware;

use Auth;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        \Log::info(json_encode(Auth::user()));

        if (! $request->expectsJson()) {
            if ($request->is('back/*')) {
                return route('back.login');
            }
            return route('login');
        }
    }
}
