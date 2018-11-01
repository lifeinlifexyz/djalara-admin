<?php
namespace Reddevs\DjaLaraAdmin\Contracts\Model;

interface FactoryInterface
{
    public function make($adminClass, $modelClass);
}