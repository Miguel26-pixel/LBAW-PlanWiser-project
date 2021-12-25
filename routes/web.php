<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
// Home


Route::get('/', [Auth\LoginController::class,'home']);
Route::get('/dashboard', [DashboardController::class,'show']);
Route::get('/homepage', [HomepageController::class,'show']);
Route::get('/profile/{id}', [UsersController::class,'showProfile']);

// API
Route::post('/profile/{id}/update', [UsersController::class,'update']);

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


//Projects
Route::get('projectsCreate', [ProjectsController::class,'showProjectsForm']);
Route::post('projectsCreate', [ProjectsController::class,'create']);