<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['admin_email' => config('admin.email')]);
    return ['Laravel' => app()->version()];
});

Route::get('/provider/login', [LoginController::class, 'providerLogin'])->name('providerLogin');
Route::get('/provider/callback', [LoginController::class, 'callback'])->name('callback');


