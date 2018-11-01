<?php
namespace Reddevs\DjaLaraAdmin;

use Reddevs\DjaLaraAdmin\Contracts\AdminSiteInterface;
use Reddevs\DjaLaraAdmin\Contracts\Model\FactoryInterface;
use Reddevs\DjaLaraAdmin\Exceptions\DoesNotRegistered;
use Reddevs\DjaLaraAdmin\Model\Admin;

class AdminSite implements AdminSiteInterface
{

    protected $registry = [];

    /**
     * @var FactoryInterface
     */
    protected $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $adminClass admin model class name
     * @param string $modelClass eloquent model class name
     * @param string $modelAlias eloquent model alias name
     * @return self
     */
    public function register($modelClass, $adminClass = null, $modelAlias = null)
    {
        if (is_null($adminClass)) {
            $adminClass = Admin::class;
        }
        if (is_null($modelAlias)) {
            $modelAlias = $modelClass;
        }
        $this->registry[$modelAlias] = $this->factory->make($adminClass, $modelClass);
        return $this;
    }

    public function unregister($model)
    {
        if ($this->isRegistered($model)) {
            unset($this->registry[$model]);
        }
        return $this;
    }

    public function isRegistered($model)
    {
        return isset($this->registry[$model]);
    }

    public function all()
    {
        return $this->registry;
    }

    public function get($model)
    {
        if (!$this->isRegistered($model)) {
            throw new DoesNotRegistered($model . ' is not registered in admin site');
        }
        return $this->registry[$model];
    }
}