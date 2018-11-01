<?php
namespace Reddevs\DjaLaraAdmin\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Reddevs\DjaLaraAdmin\Admin;
use Orchestra\Testbench\TestCase;
use Reddevs\DjaLaraAdmin\Exceptions\Model\CreateException;
use Reddevs\DjaLaraAdmin\Model\Factory;
use Reddevs\DjaLaraAdmin\Model\Admin as ModelAdmin;

class ModelFactoryTest extends TestCase
{
    /**
     * @var $admin Admin
     */
    protected $admin;



    public function testMakeException()
    {
        $this->expectException(CreateException::class);
        $factory = new Factory(new Application());
        $factory->make('Auth', 'Auth');
    }

    public function testAdminModelGetModelClass()
    {
        $app = new Application();
        $app->instance('TestModelAdmin', new ModelAdmin());
        $factory = new Factory($app);
        $adminModel = $factory->make('TestModelAdmin', Model::class);
        $this->assertEquals(Model::class, $adminModel->getModelClass());
    }
}