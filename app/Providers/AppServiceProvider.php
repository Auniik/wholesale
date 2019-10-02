<?php

namespace App\Providers;

use App\Models\Permission;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2); ?>";
        });

        if(!$this->app->runningInConsole()){
            foreach (Permission::where('name', '<>', '0')->get() as $permission){
                Gate::define($permission->name, function (User $user) use($permission){
                    foreach ($user->role->permissions as $p){
                        if($p->name == $permission->name){
                            return true;
                        }
                    }
                    return false;
                });
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
