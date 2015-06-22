<?php

namespace Hexcores\Api\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hexcores\Api\Response
 */
class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Hexcores\Api\Http\Response';
    }
}
