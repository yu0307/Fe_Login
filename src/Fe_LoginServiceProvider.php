<?php
    namespace FeIron\Fe_Login;
    use Illuminate\Support\ServiceProvider;

    class Fe_LoginServiceProvider extends ServiceProvider{
        public function boot(){
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->loadViewsFrom(__DIR__ . '/resources/views', 'Fe_Login');
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

            $this->publishes([
                __DIR__ . '/config' => config_path('Fe_Login'),
            ],'fe_login_config');
            
            $this->publishes([
                __DIR__ . '/assets' => public_path('FeIron/Fe_Login'),
            ], 'fe_login_public');
        
        }

        public function register(){
            $this->mergeConfigFrom(
                __DIR__ . '/config/appconfig.php',
                'fe_login_appconfig'
            );
        }
    }
?>