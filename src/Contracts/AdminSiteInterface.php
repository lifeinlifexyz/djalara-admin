<?php
namespace Reddevs\DjaLaraAdmin\Contracts;

interface AdminSiteInterface
{

    /**
     * @param string $adminClass admin model class name
     * @param string $modelClass eloquent model class name
     * @return self
     */
    public function register($modelClass, $adminClass = null);

}