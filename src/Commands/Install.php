<?php
namespace Reddevs\DjaLaraAdmin\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Nwidart\Modules\LaravelModulesServiceProvider;
use Reddevs\DjaLaraAdmin\AdminServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionServiceProvider;

class Install extends Command
{
    protected $signature = 'djalara-admin:install';

    protected $description = 'Install reddevs\\djalara-admin package';

    public function handle()
    {
        $this->publish();
        $this->migrate();
        $this->seed();
    }

    private function seed()
    {
        //create admin user
        $this->info('Create admin user');
        Role::findOrCreate('admin', 'web');
        $email = 'admin@admin.com';
        $pass = 'admin';
        try {
            $admin = User::firstOrCreate([
                'email' => $email,
                'name' => 'admin',
                'password' => Hash::make($pass),
            ]);
            $admin->save();
            $admin->assignRole('admin');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $this->warn('Admin user has already created');
            } else {
                throw $e;
            }
        }
        $this->info('admin email: ' . $email);
        $this->info('admin password: ' . $pass);

    }

    private function hasFile($path)
    {
        foreach(glob($path) as $p) {
            return true;
        }
        return false;
    }

    private function publish()
    {
        $this->info('Start publish vendors');

        Artisan::call('vendor:publish', [
            '--provider' => AdminServiceProvider::class
        ]);

        $permMigrations = $this->laravel->databasePath() . '/migrations/*_create_permission_tables.php';

        if (!$this->hasFile($permMigrations)) {
            Artisan::call('vendor:publish', [
                '--provider' => PermissionServiceProvider::class,
                '--tag' => 'migrations'
            ]);
        }

        Artisan::call('vendor:publish', [
            '--provider' => LaravelModulesServiceProvider::class,
            '--tag' => 'migrations'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => 'JeroenNoten\LaravelAdminLte\ServiceProvider',
            '--tag' => 'assets'
        ]);

        Artisan::call('make:adminlte', ['--force' => true]);
        $this->info('Finish publish vendors');
    }

    private function migrate()
    {
    }
}