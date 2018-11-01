<?php
namespace Reddevs\DjaLaraAdmin\Model;


use Illuminate\Contracts\Foundation\Application;
use Reddevs\DjaLaraAdmin\Contracts\Model\AdminInterface;
use Reddevs\DjaLaraAdmin\Contracts\Model\FactoryInterface;
use Reddevs\DjaLaraAdmin\Exceptions\Model\CreateException;

class Factory implements FactoryInterface
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param  Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    /**
     * @param $adminClass
     * @param $modelClass
     * @return AdminInterface
     * @throws CreateException
     */
    public function make($adminClass, $modelClass)
    {
        $modelAdmin = $this->app->make($adminClass);
        if (!($modelAdmin instanceof AdminInterface)) {
            throw new CreateException(
                '"' . $modelClass . '"' . ' is not instance of "' . AdminInterface::class . '"' );
        }
        $modelAdmin->setModelClass($modelClass);
        return $modelAdmin;
    }
}