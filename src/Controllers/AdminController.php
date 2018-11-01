<?php
namespace Reddevs\DjaLaraAdmin\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Nwidart\Modules\Facades\Module;
use Reddevs\DjaLaraAdmin\Facades\Menu;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Module::loadAdmin();
        $menus = Menu::get('admin-menu');
        \Barryvdh\Debugbar\Facade::info($menus);
        return view('djalara-admin::index', ['menus' => $menus]);
    }
}