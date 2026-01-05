<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'events');
Route::view('/login', 'login');
Route::view('/forgot-password', 'forgot-password');
Route::view('/reset-password', 'reset-password');
Route::view('/helpdesk', 'helpdesk');
