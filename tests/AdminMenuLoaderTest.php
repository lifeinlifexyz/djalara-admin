<?php

namespace Reddevs\DjaLaraAdmin\Tests;

use App\User;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use Reddevs\DjaLaraAdmin\Admin;
use Reddevs\DjaLaraAdmin\AdminSite;
use Reddevs\DjaLaraAdmin\Menu\AdminMenuLoader;
use Reddevs\DjaLaraAdmin\Menu\Repository;
use Reddevs\DjaLaraAdmin\Model\Factory;

class AdminModelMock extends \Reddevs\DjaLaraAdmin\Model\Admin
{
    protected $menuHeader = 'Members';

}

class AdminMenuLoaderTest extends TestCase
{

    public function testLoadAdminMenus()
    {
        $app = new Application();
        $factory = new Factory($app);
        $admin = (new AdminSite($factory))->register(User::class, AdminModelMock::class, 'User');
        $app->instance('AdminSite', $admin);
        $app->register(\Illuminate\Translation\TranslationServiceProvider::class);

        $translatorMock = $this
            ->getMockBuilder(\Illuminate\Translation\Translator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $translatorMock->method('getFromJson')->willReturnArgument(0);
        $app->instance('translator', $translatorMock);

        $configMock = $this->getMockBuilder(\Illuminate\Config\Repository::class)->getMock();
        $configMock->method('get')
            ->with($this->equalTo('djadmin.url'))
            ->will($this->returnValue('admin'));

        $app->instance('config', $configMock);

        $repo = new Repository();
        $menuLoader = new AdminMenuLoader($app);
        $menuLoader->load($repo);
        $menuHeaderHash = md5('Members');
        $this->assertEquals(true, count($repo->getMenuByName('admin-menu')) > 0);
        $this->assertEquals(true, isset($repo->getMenuByName('admin-menu')[$menuHeaderHash]));
        $membersMenu = $repo->getMenuByName('admin-menu')[$menuHeaderHash];
        $this->assertEquals('Members', $membersMenu['name']);
        $this->assertEquals(true, $membersMenu['is_header']);
        $this->assertEquals('User', $membersMenu[0]['name']);
        $this->assertEquals('/admin/user/', $membersMenu[0]['url']);
    }
}