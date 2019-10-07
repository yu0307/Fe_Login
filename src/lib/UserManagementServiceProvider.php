<?php

namespace feiron\fe_login\lib;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use \feiron\fe_login\lib\UserManagement;

class UserManagementServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('UserManagement', function ($app) {
            return new UserManagement();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('IncludeOutlet', function ($OutLets) {
            return '
                    <?php  
                        foreach(('.$OutLets.') as $view){
                            if ($__env->exists($view->Name(),$view->getData())){
                                 echo $__env->make($view->Name(),$view->getData(), \Illuminate\Support\Arr::except(get_defined_vars(), ["__data", "__path"]))->render(); 
                            }
                        }
                    ?>
                ';
        });
    }

    public function provides()
    {
        return [UserManagement::class];
    }
}
