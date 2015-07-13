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
        $response = app('Hexcores\Api\Http\Response');

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
        $response = app('Hexcores\Api\Http\Response');
        
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
        $response = app('Hexcores\Api\Http\Response');
        
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
        $response = app('Hexcores\Api\Http\Response');
        
        return $response->unauthorized($message, $headers);
    }
}

if (! function_exists('timestamp')) {
    /**
     * Change date time to api ready timestamp
     * 
     * @param  mixed $value Your date time
     * @return int
     */
    function timestamp($value)
    {
        // If this value is an integer,
        // we will assume it is a UNIX timestamp's value
        // and return this value
        if ( is_numeric($value)) {
            return $value;
        }

        // If this value is instance of MongoDate
        // we will return 'sec' value from this instance.
        if ($value instanceof MongoDate) {
            return $value->sec;
        }

        // Convert from year, month, day format (Y-m-d)
        // to Carbon instance
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value)) {
            $value = Carbon\Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        }

        if ( $value instanceof DateTime ) {
            return $value->getTimestamp();
        }

        return $value;
    }
}
