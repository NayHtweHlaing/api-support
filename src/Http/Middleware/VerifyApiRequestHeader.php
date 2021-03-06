<?php

namespace Hexcores\Api\Http\Middleware;

use Closure;

class VerifyApiRequestHeader
{

    const X_KEY = 'X-API-KEY';
    const X_SECRET = 'X-API-SECRET';

    /**
     * The URIs will be except from verify.
     *
     * @var array
     */
    protected $except = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! $this->shouldExcept($request)) {
            $appKey = $request->header(static::X_KEY);
            $appSecret = $request->header(static::X_SECRET);

            if ( ! $this->validAppKey($appKey))
            {
                return response_unauthorized();
            }

            if ( ! $this->validAppSecret($appSecret))
            {
                return response_unauthorized();
            }
        }

        return $next($request);
    }

    /**
     * Check given request's uri is except lists or not.
     *
     * @param  \Illuminate\Http\Request $request
     * @return boolean
     */
    protected function shouldExcept($request)
    {
        foreach ($this->except as $except) {
            if ( $request->is($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check API APP KEY is valid key or not.
     *
     * @param  string $key
     * @return boolean
     */
    protected function validAppKey($key)
    {
        $lists = $this->getKeyListsFromEnvVariable(static::X_KEY);

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
        $lists = $this->getKeyListsFromEnvVariable(static::X_SECRET);

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