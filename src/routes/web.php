<?php
    Route::group(['namespace' => 'feiron\fe_login\http\controllers', 'middleware' => ['web']], function () {

        //Authenticaiton
        Route::get('login/', 'FeLoginController@RenderLoginWindow')->name('fe_loginWindow');
        Route::get('UserLogin/', 'FeLoginController@RenderLoginWindow')->name('login');
        Route::get('login/{AuthType?}', 'FeLoginController@TryLogin')->name('fe_loginControl');
        Route::post('login/{AuthType?}', 'FeLoginController@TryLogin')->name('fe_loginControl');
        Route::get('login/{AuthType?}/callback', 'FeLoginController@handleProviderCallback');
        Route::get('login_SSO/', 'FeLoginController@login_SSO')->name('fe_SSOLogin');
        Route::get('login_SSO/callback', 'FeLoginController@handleSSOCallback')->name('fe_SSOLoginCallback');

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

        Route::post('userUpdate', 'FeUsrManagement@UpdateUser')->name('Fe_userUpdate');
        Route::post('uploadUsrProfileImg', 'FeProfileController@UploadProfImg')->name('FeLogin_ProfImgUpload');
        Route::post('uploadUsrProfileImg/remove', 'FeProfileController@removeProfImg')->name('FeLogin_ProfImgRemove');

        Route::post('usermeta', 'FeUsrMetaManagement@saveMeta')->name('Fe_UserMetaManagement');
        Route::post('usermeta/list', 'FeUsrMetaManagement@listMetaFields')->name('Fe_UserMetalist');
        Route::post('usermeta/delete/{MID}', 'FeUsrMetaManagement@removeMetaFields')->name('Fe_UserMetaRemove');
        Route::post('usermeta/load/{MID}', 'FeUsrMetaManagement@load')->name('Fe_UserMetaload');
    });
?>