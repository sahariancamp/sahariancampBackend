<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

Route::get('/seed-one', function (Request $request) {
    $seeder = $request->input('seeder');
    Artisan::call('db:seed --class=' . $seeder . ' --force');
    return $seeder . ' seeded successfully';
}); 


Route::get('/storage-link', function () {
    Artisan::call('storage:link', ['--force' => true]);
    return 'Storage link created successfully';
});

Route::get('queue-work', function () {
    Artisan::call('queue:work', ['--force' => true]);
    return 'Queue work started successfully';
});


Route::get('/test-queue', function () {
    dispatch(function () {
        \Log::info('✅ Queue is working perfectly at ' . now());
    });
    
    return 'تم إرسال المهمة، تحقق من ملف الـ log';
});




