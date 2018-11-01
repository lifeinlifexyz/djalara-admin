<?php
namespace Reddevs\DjaLaraAdmin\Tests;

use Orchestra\Testbench\TestCase;
use Reddevs\DjaLaraAdmin\Model\Admin;
use Reddevs\DjaLaraAdmin\Model\Factory;

class ModelAdminTest extends TestCase
{
    public function testGetMenuHeader()
    {
        $model = new Admin();
        $model->setMenuHeader('testHeader');
        $this->assertEquals('testHeader', $model->getMenuHeader());
        $model->setMenuHeader(null);
        $this->assertEquals('DjaLaraAdmin', $model->getMenuHeader());
    }
}