<?php
namespace Reddevs\DjaLaraAdmin;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;
use Reddevs\DjaLaraAdmin\Commands\Install;
use Reddevs\DjaLaraAdmin\Contracts\Menu\RepositoryInterface;
use Reddevs\DjaLaraAdmin\Contracts\Model\FactoryInterface;
use Reddevs\DjaLaraAdmin\Menu\AdminMenuLoader;
use Reddevs\DjaLaraAdmin\Menu\Manager;
use Reddevs\DjaLaraAdmin\Menu\Repository;
use Reddevs\DjaLaraAdmin\Model\Factory;

class AdminServiceProvider extends ServiceProvider
{

    protected $commands = [
        Install::class
    ];

    public function boot()
    {

        $this->publishes([__DIR__ . '/../config/' => config_path() . '/']);
        $this->publishes([__DIR__ . '/../Modules/' => config('modules.paths.modules') . '/']);

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'djalara-admin');

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    public function register()
    {
        $this->registerModuleMacros();
        $this->registerAdmin();
        $this->registerMenu();
    }

    protected function registerModuleMacros()
    {
        $files = $this->app['files'];
        Module::macro('loadAdmin', function () use ($files) {
           $modules = Module::enabled();
            foreach($modules as &$module) {
                $path = $module->getExtraPath('admin.php');
                if ($files->exists($path)) {
                    $files->requireOnce($path);
                }
            }
        });
    }

    protected function registerAdmin()
    {
        $this->app->singleton(FactoryInterface::class, Factory::class);
        $this->app->singleton('AdminSite', AdminSite::class);
    }

    protected function registerMenu()
    {
        $this->app->singleton(RepositoryInterface::class, Repository::class);
        $this->app->singleton('AdminMenuLoader', AdminMenuLoader::class);
        $this->app->singleton('DjalaraMenu', function($app) {
            return (new Manager($app->make(RepositoryInterface::class)))->addLoader($app->make('AdminMenuLoader'));
        });
    }
}