<?php
    Route::group(['namespace' => 'feiron\fe_login\http\controllers', 'middleware' => ['web']], function () {

        //Authenticaiton
        Route::get('login/', 'FeLoginController@RenderLoginWindow')->name('fe_loginWindow');
        Route::get('login/{AuthType?}', 'FeLoginController@TryLogin')->name('fe_loginControl');
        Route::post('login/{AuthType?}', 'FeLoginController@TryLogin')->name('fe_loginControl');
        Route::get('login/{AuthType?}/callback', 'FeLoginController@handleProviderCallback');

        //Registration
        Route::get('register', 'FeSignupController@showRegistrationForm')->name('Fe_SignUpWin');
        Route::post('register', 'FeSignupController@register')->name('Fe_SignUp');

        //Password reset
        Route::get('reset/{token}/{email}', 'FePasswordReset@showWindow')->name('password.reset');
        Route::post('passreset', 'FePasswordReset@passreset')->name('Fe_PasswordReset');

        //email reset link
        Route::get('forgetPass', 'FePasswordRetrieval@showResetForm')->name('Fe_Passwordwindow');
        Route::post('emailresetlink', 'FePasswordRetrieval@sendResetLinkEmail')->name('Fe_PasswordResetEmail');

        //Email Verification
        Route::get('emailverify', 'FeEmailVerification@verify')->name('verification.verify');
                
        Route::get('logout', 'FeLoginController@logout')->name('Fe_Logout');



        Route::get('test',function(){
            return view('fe_login::testview');
        });
    });
?>