<?php
namespace Reddevs\DjaLaraAdmin\Contracts\Model;

interface AdminInterface
{
    public function setModelClass($modelClass);
    public function getModelClass();
    public function getMenuHeader();
}