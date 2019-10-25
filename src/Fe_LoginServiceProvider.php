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

             app()->UserManagementOutlet->bindOutlet('UserManageOutlet', new \feiron\fe_login\lib\outlet\feOutlet([
                'view'=> 'fe_login::outletViews.userMetaInfo',
                'myName'=> 'Additional Info'
            ]));

            if (app()->resolved('frameOutlet')) {
                app()->frameOutlet->bindOutlet('Fe_FrameOutlet', new \feiron\felaraframe\lib\outlet\feOutlet([
                    'view'=> 'fe_login::LoginOutletUsrManager',
                    'myName'=>'User Management',
                    'reousrce'=>[
                        asset('/feiron/fe_login/js/Fe_Login_usrManager_ui.js'),
                        asset('/feiron/fe_login/js/Fe_Login_usrOutlet.js'),
                        asset('/feiron/fe_login/css/Fe_Login_usrManager_Outlet.css')
                    ]
                ]));
                app()->frameOutlet->bindOutlet('Fe_FrameProfileOutlet', new \feiron\felaraframe\lib\outlet\feOutlet([
                    'view'=> 'fe_login::LoginOutletUserProfDetails',
                    'myName'=> 'User Details',
                    'reousrce'=>[ 
                        asset('/feiron/fe_login/js/Fe_Login_UsrDetail.js'),
                        asset('/feiron/fe_login/css/Fe_Login_UsrDetail.css')
                    ]
                ]));
                app()->frameOutlet->bindOutlet('Fe_FrameProfileOutlet', new \feiron\felaraframe\lib\outlet\feOutlet([
                    'view'=> 'fe_login::LoginOutletUserProfSecurity',
                    'myName'=> 'Security',
                    'reousrce'=>[asset('/feiron/fe_login/js/Fe_Login_UsrSecurity.js') ]
                ]));
            }
        }

        public function register(){
            $this->app->register( '\feiron\fe_login\lib\UserManagementServiceProvider');
            $this->app->register( '\feiron\fe_login\lib\UserManagementOutletProvider');
            //providing available outlet hooks
            resolve('UserManagementOutlet')->registerOutlet('UserManageOutlet');
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