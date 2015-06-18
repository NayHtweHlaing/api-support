<?php

namespace Hexcores\Api\Http\Middleware;

use Closure;

class VerifyApiRequestHeader
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
    public function handle($request, Closure $next)
    {
    	$appKey = env('API_APP_KEY', '');
    	$appSecret = env('API_APP_SECRET', '');
    }
}