<?php
    namespace FeIron\Fe_Login;
    use Illuminate\Support\ServiceProvider;

    class Fe_LoginServiceProvider extends ServiceProvider{
        public function boot(){
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->loadViewsFrom(__DIR__ . '/resources/views', 'Fe_Login');
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        }

        public function register(){

        }
    }
?>