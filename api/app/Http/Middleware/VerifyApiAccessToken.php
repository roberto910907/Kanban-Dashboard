<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class VerifyApiAccessToken
{
    /**
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (! $request->has('access_token')) {
            return response(['Unauthorized: The access token is missing.'], 403);
        }

        $accessToken = $request->get('access_token');

        if ($accessToken !== config('auth.secret_token')) {
            return response(['Unauthorized: The access token is wrong.'], 403);
        }

        return $next($request);
    }
}
