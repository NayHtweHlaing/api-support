<?php

if (!function_exists('response_ok')) {
    /**
     * Return a new json response for the api success.
     *
     * @param  mixed  $data
     * @param  array   $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function response_ok($data = '', array $headers = [])
    {
        $response = app('Hexcores\Api\Response');

        return $response->ok($data, $headers);
    }
}

if (!function_exists('response_missing')) {
    /**
     * Return a new json response for the api data missing.
     *
     * @param  string  $message
     * @param  array   $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function response_missing($message = null, array $headers = [])
    {
        $response = app('Hexcores\Api\Response');
        
        return $response->missing($message, $headers);
    }
}

if (!function_exists('response_error')) {
    /**
     * Return a new json response for the api error.
     *
     * @param  mixed   $message
     * @param  int     $status
     * @param  array   $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function response_error($message, $status = 500, array $headers = [])
    {
        $response = app('Hexcores\Api\Response');
        
        return $response->error($message, $status, $headers);
    }
}

if (!function_exists('response_unauthorized')) {
    /**
     * Return a new json response for the api access unauthorized.
     *
     * @param  mixed   $message
     * @param  array   $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function response_unauthorized($message = null, array $headers = [])
    {
        $response = app('Hexcores\Api\Response');
        
        return $response->unauthorized($message, $headers);
    }
}