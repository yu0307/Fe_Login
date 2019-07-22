<?php
    Route::group(['namespace' => 'FeIron\Fe_Login\Http\Controllers', 'middleware' => ['web']], function () {

        //Authenticaiton
        Route::get('login/', 'FeLoginController@RenderLoginWindow')->name('Fe_LoginWindow');
        Route::get('login/{AuthType?}', 'FeLoginController@TryLogin')->name('Fe_LoginControl');
        Route::post('login/{AuthType?}', 'FeLoginController@TryLogin')->name('Fe_LoginControl');
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
            return view('Fe_Login::testview');
        });
    });
?>