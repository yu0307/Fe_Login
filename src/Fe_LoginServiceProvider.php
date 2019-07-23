<?php
    namespace FeIron\Fe_Login;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Blade;

    class Fe_LoginServiceProvider extends ServiceProvider{
        public function boot(){
            //locading package route files
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            //location package view files
            $this->loadViewsFrom(__DIR__ . '/resources/views', 'Fe_Login');
            //loading migration scripts
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

            //registering blade components 
            // Blade::component('Fe_Login::LoginForm', 'Fe_LoginForm');
            Blade::include('Fe_Login::LoginForm', 'Fe_LoginForm');

            $this->app['router']->aliasMiddleware('Fe_Guest', middleware\FeRedirectIfAuthenticated::class);
            $this->app['router']->aliasMiddleware('FeAuthenticate', middleware\FeAuthenticate::class);

            //set the publishing target path for config files. Run only during update and installation of the package. see composer.json of the package.
            $this->publishes([
                __DIR__ . '/config' => config_path('Fe_Login'),
            ],'fe_login_config');
            //set the publishing target path for asset files. Run only during update and installation of the package. see composer.json of the package.
            $this->publishes([
                __DIR__ . '/assets' => public_path('FeIron/Fe_Login'),
            ], 'fe_login_public');
        }

        public function register(){
            //append package config files to global pool for users to customize
            $this->mergeConfigFrom(
                __DIR__ . '/config/appconfig.php',
                'fe_login_appconfig'
            );
        }
    }
?>