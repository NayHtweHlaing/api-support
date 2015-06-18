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

    	$headerKey = $request->header('X-API-KEY');
    	$headerSecret = $request->header('X-API-SECRET');

    	if ($appKey !== $headerKey)
    	{
    		return response_unauthorized();
    	}

    	if ($appSecret !== $headerSecret)
    	{
    		return response_unauthorized();
    	}

    	
    	return $next($request);
    }
}