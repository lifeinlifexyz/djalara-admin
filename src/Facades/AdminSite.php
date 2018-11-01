<?php
namespace Reddevs\DjaLaraAdmin\Facades;

use Illuminate\Support\Facades\Facade;

class AdminSite extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AdminSite';
    }
}