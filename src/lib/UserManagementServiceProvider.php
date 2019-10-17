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
    
    public function provides()
    {
        return [UserManagement::class];
    }
}
