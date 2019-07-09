<?php
    Route::group(['namespace' => 'FeI\Fe_Login\Http\Controllers', 'middleware' => ['web']], function () {
        Route::get('login', 'FeLoginController@RenderLoginWindow')->name('LoginWindow');
    });
?>