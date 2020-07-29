<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectIfAuthenticated;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

/* 
** prefix: admin is predefined inside RouteServiceProvider
** which is implemented befor the whole admin routes
*/

// ADMIN DASHBOARD
Route::group(
    [
        'middleware' => 'auth:admin',
        'namespace' => 'Admin'
    ],
    function () {

        Route::get(
            '/',
            'DashboardController@index'
        )->name('admin.dashboard');
    }
);

// ADMIN LOGIN
Route::group(
    [
        'middleware' => 'guest:admin',
        'namespace' => 'Admin'
    ],
    function () {

        Route::get(
            'login',
            'LoginsController@showLogin'
        )->name('get.admin.login');

        Route::post(
            'login',
            'LoginsController@login'
        )->name('post.admin.login');
    }
);

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
