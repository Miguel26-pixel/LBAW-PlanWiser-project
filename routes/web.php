<?php
use App\Http\Controllers\DashboardController;
// Home
Route::get('/', 'Auth\LoginController@home');
Route::get('/dashboard', [DashboardController::class,'show']);
Route::get('/homepage', 'HomepageController@show');
Route::get('/profile/{id}', 'UsersController@showProfile');

// API

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
