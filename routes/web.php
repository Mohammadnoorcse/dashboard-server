<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/link', function () {
    Artisan::call('storage:link');
});


