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
Route::get('admin', [AdminController::class,'show']);
Route::get('admin/reportsInformations', [AdminController::class,'showReports']);
Route::get('admin/manageUsers', [AdminController::class,'showUsersManagement']);
Route::get('admin/projects', [AdminController::class,'showProjects']);
Route::get('admin/profile/{id}', [AdminController::class,'showProfile']);

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

Route::get('/project/{id}', [ProjectController::class,'showProject']);
Route::post('/project/{id}/update', [ProjectController::class,'updateProject']);
Route::get('project/{id}/files', [ProjectController::class,'showProject']);
Route::get('project/{id}/tasks', [TasksController::class,'showTasks']);
Route::get('project/{id}/forum', [ProjectController::class,'showProject']);
Route::get('project/{id}/members', [ProjectUsersController::class,'showProjectUsers']);

Route::get('/project/{id}/members/invitation', [InvitationsController::class,'showInvitationForm']);
Route::post('/project/{id}/members/invitation', [InvitationsController::class,'create']);

//Tasks
Route::get('project/{id}/tasksCreate', [TasksController::class,'showTaskForm']);
Route::post('tasksCreate', [TasksController::class,'create']);
Route::get('/project/{id}/task/{task_id}', [TasksController::class,'showTask']);
Route::post('/project/{id}/task/{task_id}/update', [TasksController::class,'updateTask']);

//Reports
Route::get('reportsCreate', [ReportsController::class,'showReportForm']);
Route::post('reportsCreate', [ReportsController::class,'create']);
