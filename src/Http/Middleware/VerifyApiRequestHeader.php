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
        $appKey = $request->header('X-API-KEY');
        $appSecret = $request->header('X-API-SECRET');

        if ( ! $this->validAppKey($appKey))
        {
            return response_unauthorized();
        }

        if ( ! $this->validAppSecret($appSecret))
        {
            return response_unauthorized();
        }
        
        return $next($request);
    }

    /**
     * Check API APP KEY is valid key or not.
     *
     * @param  string $key
     * @return boolean
     */
    protected function validAppKey($key)
    {
        $lists = $this->getKeyListsFromEnvVariable('API_APP_KEY');

        // Return true if key lists is not set in '.env' file.
        if ( empty($lists)) return true;

        return in_array($key, $lists);
    }

     /**
     * Check API APP SECRET is valid key or not.
     *
     * @param  string $key
     * @return boolean
     */
    protected function validAppSecret($key)
    {
        $lists = $this->getKeyListsFromEnvVariable('API_APP_SECRET');

        // Return true if key lists is not set in '.env' file.
        if ( empty($lists)) return true;

        return in_array($key, $lists);
    }

    /**
     * Get key lists from environment variable.
     *
     * @param  string $envVarName
     * @return array
     */
    protected function getKeyListsFromEnvVariable($envVarName)
    {
        $values = env($envVarName, '');

        $array = ($values === '') ? [] : explode(',', $values);

        return array_map('rtrim', $array);
    }
}