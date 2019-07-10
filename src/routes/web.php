<?php
    Route::group(['namespace' => 'FeIron\Fe_Login\Http\Controllers', 'middleware' => ['web']], function () {
        Route::get('login', 'FeLoginController@RenderLoginWindow')->name('LoginWindow');
    });
?>