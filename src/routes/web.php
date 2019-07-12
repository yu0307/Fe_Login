<?php
    Route::group(['namespace' => 'FeIron\Fe_Login\Http\Controllers', 'middleware' => ['web']], function () {
        Route::get('login', 'FeLoginController@RenderLoginWindow')->name('Fe_LoginWindow');
        Route::get('login/{AuthType?}', 'FeLoginController@TryLogin')->name('Fe_LoginControl');
        Route::get('login/{AuthType?}/callback', 'FeLoginController@handleProviderCallback');
        Route::get('register', 'FeLoginController@register')->name('Fe_SignUp');
        Route::get('passreset', 'FeLoginController@reset')->name('Fe_PasswordReset');
        Route::get('logout', 'FeLoginController@logout')->name('Fe_Logout');
    });
?>