<?php

namespace Legalworks\LoggedValues\Facades;

use Illuminate\Support\Facades\Facade;

class LoggedValues extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'logged-values';
    }
}
