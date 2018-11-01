<?php

namespace Reddevs\DjaLaraAdmin\Tests;

use Orchestra\Testbench\TestCase;
use Reddevs\DjaLaraAdmin\Menu\Repository;

class MenuRepositoryTest extends TestCase
{

    public function testRepo()
    {
        $repo = new Repository();
        $repo->push('test', 'test_value');
        $this->assertEquals('test_value', $repo->pull()['test']);
        $this->assertEquals('test_value', $repo->getMenuByName('test'));
    }
}