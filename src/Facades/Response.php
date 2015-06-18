<?php

namespace Hexcores\Api\Facades;

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
        return 'Hexcores\Api\Response';
    }
}
