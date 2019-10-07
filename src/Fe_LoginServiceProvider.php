<?php
    namespace feiron\fe_login;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Blade;

    class Fe_LoginServiceProvider extends ServiceProvider{
        public function boot(){
            //locading package route files
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            //location package view files
            $this->loadViewsFrom(__DIR__ . '/resources/views', 'fe_login');
            //loading migration scripts
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

            //registering blade components 
            Blade::include('fe_login::LoginForm', 'fe_loginForm');
            Blade::component('fe_login::LoginUsrManager', 'fe_UserManager');

            $this->app['router']->aliasMiddleware('Fe_Guest', middleware\FeRedirectIfAuthenticated::class);
            $this->app['router']->aliasMiddleware('FeAuthenticate', middleware\FeAuthenticate::class);

            //set the publishing target path for config files. Run only during update and installation of the package. see composer.json of the package.
            $this->publishes([
                __DIR__ . '/config' => config_path('fe_login'),
            ],'fe_login_config');
            //set the publishing target path for asset files. Run only during update and installation of the package. see composer.json of the package.
            $this->publishes([
                __DIR__ . '/assets' => public_path('feiron/fe_login'),
            ], 'fe_login_public');
        }

        public function register(){
            $this->app->register( '\feiron\fe_login\lib\UserManagementServiceProvider');

            // instruct the system to use fe_users when authenticating.
            config(['auth.guards.web.provider' => 'fe_users']);
            config([
                'auth.providers.fe_users' => [
                    'driver' => 'eloquent',
                    'model' => \feiron\fe_login\models\fe_users::class,
                ]
            ]);
            //instruct the system to use password_resets as reset table
            config(['auth.passwords.users' => ['provider'=>'fe_users','table'=> 'password_resets', 'expire'=>120]]);
            //append package config files to global pool for users to customize
            $this->mergeConfigFrom(
                __DIR__ . '/config/appconfig.php',
                'fe_login_appconfig'
            );
        }
    }
?>