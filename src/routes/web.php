<?php
    Route::group(['namespace' => 'feiron\fe_login\http\controllers', 'middleware' => ['web']], function () {

        //Authenticaiton
        Route::get('login/', 'FeLoginController@RenderLoginWindow')->name('fe_loginWindow');
        Route::get('login/', 'FeLoginController@RenderLoginWindow')->name('login');
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

        Route::get('usermanagement', 'FeUsrManagement@show')->name('Fe_UserManagementUI');
        Route::post('usermanagement', 'FeUsrManagement@SaveUser')->name('Fe_UserManagement_save');
        Route::post('usermanagement/load', 'FeUsrManagement@loadList')->name('Fe_UserManagement_load');
        Route::get('usermanagement/{UID}', 'FeUsrManagement@GetUser')->name('Fe_UserManagement_get');
        Route::post('usermanagement/rm/{UID}', 'FeUsrManagement@RemoveUser')->name('Fe_UserManagement_delete');
    });
?>