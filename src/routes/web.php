<?php
    Route::group(['namespace' => 'FeIron\Fe_Login\Http\Controllers', 'middleware' => ['web']], function () {
        Route::get('login', 'FeLoginController@RenderLoginWindow')->name('Fe_LoginWindow');
        Route::get('login/{AuthType?}', 'FeLoginController@TryLogin')->name('Fe_LoginControl');
    });
?>