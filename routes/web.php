<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/provider/login', [LoginController::class, 'providerLogin'])->name('providerLogin');
Route::get('/provider/callback', [LoginController::class, 'callback'])->name('callback');

require __DIR__.'/auth.php';
