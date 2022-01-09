<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [Auth\LoginController::class,'home']);
Route::get('/home', [HomepageController::class,'show']);
Route::get('/dashboard', [DashboardController::class,'show']);
Route::get('/profile/{id}', [UsersController::class,'showProfile']);
Route::post('api/projectsSearch', [HomepageController::class,'searchProjects']);

//Admin
Route::get('admin', [AdminController::class,'show']);
Route::get('admin/reportsInformations', [AdminController::class,'showReports']);
Route::get('admin/manageUsers', [AdminController::class,'showUsersManagement']);
Route::get('admin/projects', [AdminController::class,'showProjects']);
Route::get('admin/project/{id}', [AdminController::class,'showProjects']);
Route::get('admin/profile/{id}', [AdminController::class,'showProfile']);
Route::get('admin/users', [AdminController::class,'showUsers']);
Route::post('admin/searchUsers', [AdminController::class,'searchUsers']);
Route::get('admin/createUser', [AdminController::class,'showUsersForm']);
Route::post('admin/createUser', [AdminController::class,'createUser']);
Route::post('admin/profile/{id}/delete', [AdminController::class,'deleteUser']);

// API
Route::post('/profile/{id}/update', [UsersController::class,'update']);
Route::post('/profile/{id}/update-password', [UsersController::class,'updatePassword']);
Route::post('/profile/{id}/delete', [UsersController::class,'deleteUser']);


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
Route::post('api/myProjectsSearch', [ProjectsController::class,'searchMyProjects']);

Route::get('/project/{id}', [ProjectController::class,'showProject']);
Route::get('/project/{id}/add-fav', [ProjectController::class,'addFavorite']);
Route::get('/project/{id}/remove-fav', [ProjectController::class,'removeFavorite']);
Route::post('/project/{id}/update', [ProjectController::class,'updateProject']);
Route::get('/project/{id}/leave', [ProjectController::class,'leaveProject']);

Route::get('project/{id}/files', [ProjectController::class,'showProjectFiles']);
Route::post('project/{id}/files/upload-files', [ProjectController::class,'uploadFiles']);
Route::get('project/{id}/files/{file_id}/download', [ProjectController::class,'downloadFile']);
Route::get('project/{id}/files/{file_id}/delete', [ProjectController::class,'deleteFile']);
Route::post('project/{id}/files/upload-folder', [ProjectController::class,'uploadFolder']);
Route::get('project/{id}/files/downloadZIP', [ProjectController::class,'downloadZIP']);

Route::get('project/{id}/tasks', [TasksController::class,'showTasks']);
Route::get('project/{id}/forum', [ProjectForumController::class,'show']);
Route::post('project/{id}/forum/send', [ProjectForumController::class,'sendMessage']);

Route::get('project/{id}/members', [ProjectUsersController::class,'showProjectUsers']);
Route::post('project/{id}/members/{user_id}/update', [ProjectUsersController::class,'updateUserRole']);
Route::post('project/{id}/members/{user_id}/remove', [ProjectUsersController::class,'removeUserRole']);
Route::get('/project/{id}/members/invitation', [InvitationsController::class,'showInvitationForm']);
Route::post('/project/{id}/members/invitation', [InvitationsController::class,'create']);

//Invitations
Route::get('/invitation/{id}', [InvitationsController::class,'showInvite']);
Route::post('/invitation/{id}/deal', [InvitationsController::class,'dealWithInvite']);

//Task
Route::get('project/{id}/tasksCreate', [TasksController::class,'showTaskForm']);
Route::post('tasksCreate', [TasksController::class,'create']);
Route::get('/project/{id}/task/{task_id}', [TasksController::class,'showTask']);
Route::post('/project/{id}/task/{task_id}/update', [TasksController::class,'updateTask']);
Route::post('api/project/{id}/tasks-search', [TasksController::class,'searchProjectTasks']);

//Reports
Route::get('reportsCreate', [ReportsController::class,'showReportForm']);
Route::post('reportsCreate', [ReportsController::class,'create']);
