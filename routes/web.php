<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/auth')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login.submit', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    // Password reset routes
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});


// no need to use "AdminCheck middleware" if we are using  "$this->middleware('auth:admin');" in each Controller
// Route::prefix('/api/v1/')->middleware([AdminCheck::class])->group(function () {

Route::prefix('/api/v1/')->group(function () {
    //Resources API
    Route::get('resources','Admin\ResourceController@getResources');
    Route::post('resource','Admin\ResourceController@createResource');
    Route::put('resource/{id}','Admin\ResourceController@updateResource');
    Route::delete('resource/{id}','Admin\ResourceController@deleteResource');

    // Roles API
    Route::get('roles','Admin\RoleController@getRoles');
    Route::post('role','Admin\RoleController@createRole');
    Route::put('role/{id}','Admin\RoleController@updateRole');
    Route::delete('role/{id}','Admin\RoleController@deleteRole');

    //Teams API
    Route::get('teams','Admin\TeamController@getTeams');
    Route::post('team','Admin\TeamController@createTeam');
    Route::put('team/{id}', 'Admin\TeamController@updateTeam');
    Route::put('permission/resource/{id}','Admin\TeamController@updateResourcePermisison');
    Route::delete('team/{id}', 'Admin\TeamController@deleteTeam');

    // default API
    Route::get('default/roles','Admin\TeamController@getAllRoles');
    Route::get('default/permissions','Admin\AdminController@getPermissions');
    Route::get('default/resources','Admin\AdminController@getResources');

    // User API
    Route::get('users','Admin\UserController@getUsers');

    //Dashboard Chart API
    Route::get('admin/chart','Admin\DashboardController@getAdminCountChart');
});

Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
Route::any('/{slug}', 'Admin\AdminController@index');