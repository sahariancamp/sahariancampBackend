<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/init-db', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Database initialized successfully';

});

Route::get('/seed-db', function () {
    Artisan::call('db:seed', ['--force' => true]);
    return 'Database seeded successfully';
});

