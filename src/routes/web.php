<?php
    Route::group(['namespace' => 'FeIron\Fe_Login\Http\Controllers', 'middleware' => ['web']], function () {
        //Authenticaiton
        Route::get('login/', 'FeLoginController@RenderLoginWindow')->name('Fe_LoginWindow');
        Route::get('login/{AuthType?}', 'FeLoginController@TryLogin')->name('Fe_LoginControl');
        Route::post('login/{AuthType?}', 'FeLoginController@TryLogin')->name('Fe_LoginControl');
        Route::get('login/{AuthType?}/callback', 'FeLoginController@handleProviderCallback');
        //Registration
        Route::get('register', 'FeSignupController@register')->name('Fe_SignUp');
        //Password reset
        Route::get('sentResetEmail', 'FePasswordRetrieval@sendResetLinkEmail')->name('Fe_PasswordResetEmail');
        Route::get('passreset', 'FePasswordRetrieval@passreset')->name('Fe_PasswordReset');
        Route::get('login/?target=reset&token={token}', 'FePasswordReset@ResetPassword')->name('password.reset');
        
        Route::get('logout', 'FeLoginController@logout')->name('Fe_Logout');
    });
?>