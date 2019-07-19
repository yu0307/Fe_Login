<?php

namespace FeIron\Fe_Login\middleware;

use App\Http\Middleware\Authenticate;

class FeAuthenticate extends Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('Fe_LoginWindow');
        }
    }
}
