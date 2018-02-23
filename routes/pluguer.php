<?php


use Illuminate\Support\Facades\Route;

Route::prefix(config('pluguer.backend_base_url'))
    ->namespace('\\Whyounes\\Pluguer\\Controllers\\')
    ->group(function () {
    Route::get('/api/plugins', 'PluginsController@index');
    Route::post('/api/plugins', 'PluginsController@store');
});
