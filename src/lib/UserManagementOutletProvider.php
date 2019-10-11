<?php

namespace feiron\fe_login\lib;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use \feiron\fe_login\lib\outlet\feOutletManager;

class UserManagementOutletProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('UserManagementOutlet', function ($app) {
            return new feOutletManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('FE_LoginIncludeOutlet', function ($params) {
            list($Manager, $section)=explode(',', $params);
            return
                '
                <?php 
                        $__env->startSection(' . $section . '); 
                        foreach(('. $Manager. '->OutletRenders('. $section . ')) as $view){
                            if ($__env->exists($view->Name(),$view->getData())){
                                 echo $__env->make($view->Name(),$view->getData(), \Illuminate\Support\Arr::except(get_defined_vars(), ["__data", "__path"]))->render(); 
                            }
                        }
                        $__env->stopSection();

                        $__env->startPush(' . $section . ');
                        foreach((' . $Manager . '->OutletResources(' . $section . ')) as $res){
                            echo $res;
                        }
                        $__env->stopPush(); 
                ?>
                ';
        });
    }

    public function provides()
    {
        return [feOutletManager::class];
    }
}
