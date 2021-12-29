<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [Auth\LoginController::class,'home']);
Route::get('/home', [HomepageController::class,'show']);
Route::get('/dashboard', [DashboardController::class,'show']);
Route::get('/profile/{id}', [UsersController::class,'showProfile']);
Route::post('projectsSearch', [HomepageController::class,'searchProjects']);

//Admin
Route::get('admin',[AdminController::class,'show']);

// API
Route::post('/profile/{id}/update', [UsersController::class,'update']);
Route::post('/profile/{id}/update-password', [UsersController::class,'updatePassword']);

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Projects
Route::get('projects', [ProjectsController::class,'showProjects']);
Route::get('projectsCreate', [ProjectController::class,'showProjectForm']);
Route::post('projectsCreate', [ProjectController::class,'create']);
Route::post('publicProjectsSearch', [ProjectsController::class,'projectsSearch']);
Route::post('myProjectsSearch', [ProjectsController::class,'searchMyProjects']);

Route::get('project/{id}', [ProjectController::class,'showProject']);
Route::get('project/{id}/files', [ProjectController::class,'showProject']);
Route::get('project/{id}/tasks', [ProjectController::class,'showProject']);
Route::get('project/{id}/forum', [ProjectController::class,'showProject']);
Route::get('project/{id}/members', [ProjectController::class,'showProject']);
