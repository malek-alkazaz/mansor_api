<?php

namespace App\Http\Middleware;

use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use ResponseAPI;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    // Add new method
    protected function unauthenticated($request, array $guards)
    {
        abort($this->un_authenticat());
    }
}
