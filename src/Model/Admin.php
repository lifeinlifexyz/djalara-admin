<?php
namespace Reddevs\DjaLaraAdmin\Model;

use Reddevs\DjaLaraAdmin\Contracts\Model\AdminInterface;

class Admin implements AdminInterface
{
    protected $menuHeader = null;
    protected $modelName = null;
    protected $modelClass = null;

    public function setModelClass($className)
    {
        $this->modelClass = $className;
        return $this;
    }

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function getMenuHeader()
    {
        if (!is_null($this->menuHeader)) {
            return $this->menuHeader;
        }
        return $this->getModuleName();
    }

    public function setMenuHeader($header)
    {
        $this->menuHeader = $header;
        return $this;
    }

    private function getModuleName()
    {
        $class = get_called_class();
        $result = $class;
        $parts = explode('\\', $class);
        if (isset($parts[1])) {
            $result = $parts[1];
        }
        return $result;
    }
}