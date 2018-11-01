<?php

namespace Reddevs\DjaLaraAdmin\Tests;

use Orchestra\Testbench\TestCase;
use Reddevs\DjaLaraAdmin\Contracts\Menu\LoaderInterface;
use Reddevs\DjaLaraAdmin\Menu\Manager;
use Reddevs\DjaLaraAdmin\Menu\Repository;

class MenuManagerTest extends TestCase
{

    public function testGetMenu()
    {
        $repo = new Repository();
        $repo->push('test', 'test_value');
        $manager = new Manager($repo);
        $this->assertEquals('test_value', $manager->get('test'));
    }

    public function testLoad()
    {
        $repo = new Repository();
        $loader = $this->getMockBuilder(LoaderInterface::class)->getMock();
        $loader->method('load')->willReturnCallback(function() use ($repo) {
            $repo->push('test', 'test_value');
        });
        $manager = new Manager($repo);
        $this->assertEquals($manager, $manager->addLoader($loader));
        $this->assertEquals($manager, $manager->load());
        $this->assertEquals('test_value', $manager->get('test'));

    }
}