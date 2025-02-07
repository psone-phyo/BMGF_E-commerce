<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return response()->json(['admin_email' => Auth::user()]);
    return ['Laravel' => app()->version()];
})->middleware('auth:sanctum');

Route::get('/provider/login', [LoginController::class, 'providerLogin'])->name('providerLogin');
Route::get('/provider/callback', [LoginController::class, 'callback'])->name('callback');


