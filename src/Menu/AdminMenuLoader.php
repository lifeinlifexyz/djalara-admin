<?php
namespace Reddevs\DjaLaraAdmin\Menu;

use Illuminate\Foundation\Application;
use Reddevs\DjaLaraAdmin\AdminSite;
use Reddevs\DjaLaraAdmin\Model\Admin;
use Reddevs\DjaLaraAdmin\Contracts\Menu\LoaderInterface;
use Reddevs\DjaLaraAdmin\Contracts\Menu\RepositoryInterface;

class AdminMenuLoader implements LoaderInterface
{

    /**
     * @var Application
     */
    protected $app;

    protected $menus = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function load(RepositoryInterface $repo)
    {
        $repo->push('admin-menu', $this->getAdminMenu());
    }

    private function getAdminMenu()
    {
        if (empty($this->menus)) {

            /**
             * @var $admin AdminSite
             * @var $admin Admin;
             */
            $adminSite = $this->app['AdminSite'];
            $admins = $adminSite->all();
            foreach($admins as $modelAlias => $admin) {
                $this->buildMenuItem($admin, $modelAlias);
            }
        }
        return $this->menus;
    }

    private function buildMenuItem(Admin $admin, $modelAlias)
    {
        $menuHeader = $admin->getMenuHeader();
        $headerHash = md5($menuHeader);
        if (!isset($this->menus[$headerHash])) {
            $this->menus[$headerHash] = [
                'name' => __($menuHeader),
                'is_header' => true,
            ];
        }
        $this->menus[$headerHash]['items'][] = [
            'name' => __($modelAlias),
            'url' => '/' . config('djadmin.url') . '/' . strtolower(str_replace('\\', '__', $modelAlias)) . '/'
        ];

    }
}