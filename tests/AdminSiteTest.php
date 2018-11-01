<?php
namespace Reddevs\DjaLaraAdmin\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Reddevs\DjaLaraAdmin\AdminSite;
use Reddevs\DjaLaraAdmin\Contracts\Model\AdminInterface;
use Reddevs\DjaLaraAdmin\Model\Admin as ModelAdmin;
use Orchestra\Testbench\TestCase;
use Reddevs\DjaLaraAdmin\Exceptions\Model\CreateException;
use Reddevs\DjaLaraAdmin\Model\Factory;

class AdminSiteTest extends TestCase
{
    /**
     * @var $admin AdminSite
     */
    protected $admin;
    public function setUp()
    {
        $factory = $this->createMock(Factory::class);
        $this->admin =  new AdminSite($factory);
        parent::setUp();
    }

    public function testLoadAdmin()
    {
        $this->assertEquals($this->admin, $this->admin->register('testAdminClass', 'testElModel'));
    }

    public function testExceptionIterate()
    {
        $this->expectException(CreateException::class);
        $factory = new Factory(new Application());
        $admin = new AdminSite($factory);
        $admin->register('Auth', 'Auth');
        foreach($admin as $adminModel) {}
    }
}