<?php

use App\Http\Controllers\Admin\MainCategoriesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectIfAuthenticated;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// PAGINATION COUNT
define(
    'PAGINATION_COUNT',     // PAGINATION CONSTANT
    10                       // PAGINATION VLAUE
);

/* Route::get('/', function () {
    return view('welcome');
}); */

/* 
** PREFIX: "admin" IS PREDEFINED INSIDE "RouteServiceProvider"
** WHICH IS IMPLEMENTED BEFORE THE WHOLE ADMIN ROUTES
*/

Route::group(   // AUTHORIZED ADMIN ROUTES GROUP
    [
        'middleware' => 'auth:admin',   // AUTHORIZED ADMIN GUARD MIDDLEWARE
        'namespace' => 'Admin'          // ADMIN CONTROLLERS NAMESPACE
    ],
    function () {

        // DASHBOARD ROUTE
        Route::get(
            '/',
            'DashboardController@index'
        )->name('admin.dashboard');

        ####################################### START LANGUAGES ROUTES #######################################
            Route::group(   // LANGUAGES ROUTES GROUP
                [
                    'prefix' => 'languages'     // URL PREFIX
                ],
                function () {

                    // MAIN TABLE ROUTE
                    Route::get(
                        '/',
                        'LanguagesController@index'
                    )->name('admin.languages');

                    // CREATE FORM ROUTE
                    Route::get(
                        'create',
                        'LanguagesController@create'
                    )->name('admin.language.create');
                    // SAVE FORM ROUTE
                    Route::post(
                        'save',
                        'LanguagesController@save'
                    )->name('admin.language.save');

                    // EDIT FORM ROUTE
                    Route::get(
                        'edit/{lang_id}',
                        'LanguagesController@edit'
                    )->name('admin.language.edit');
                    // UPDATE FORM ROUTE
                    Route::post(
                        'update/{lang_id}',
                        'LanguagesController@update'
                    )->name('admin.language.update');

                    // DELETE ROUTE
                    Route::get(
                        'delete/{lang_id}',
                        'LanguagesController@destroy'
                    )->name('admin.language.delete');

                }
            );
        ####################################### END LANGUAGES ROUTES #######################################

        ####################################### START MAIN CATEGORIES ROUTES #######################################
        Route::group(   // MAIN CATEGORIES ROUTES GROUP
            [
                'prefix' => 'main-categories'       // URL PREFIX
            ],
            function () {

                // MAIN TABLE ROUTE
                Route::get(
                    '/',
                    'MainCategoriesController@index'
                )->name('admin.main.cates');

                // CREATE FORM ROUTE
                Route::get(
                    'create',
                    'MainCategoriesController@create'
                )->name('admin.main.cate.create');
                // SAVE FORM ROUTE
                Route::post(
                    'save',
                    'MainCategoriesController@save'
                )->name('admin.main.cate.save');

                // EDIT FORM ROUTE
                Route::get(
                    'edit/{cate_id}',
                    'MainCategoriesController@edit'
                )->name('admin.main.cate.edit');
                // UPDATE FORM ROUTE
                Route::post(
                    'update/{cate_id}',
                    'MainCategoriesController@update'
                )->name('admin.main.cate.update');

                // DELETE ROUTE
                Route::get(
                    'delete/{cate_id}',
                    'MainCategoriesController@destroy'
                )->name('admin.main.cate.delete');
                
                // STATUS ROUTE
                Route::get(
                    'status/{cate_id}',
                    'MainCategoriesController@changeStatus'
                )->name('admin.main.cate.status');

            }
        );
        ####################################### END MAIN CATEGORIES ROUTES #######################################

        ####################################### START VENDORS ROUTES #######################################
        Route::group(   // VENDORS ROUTES GROUP
            [
                'prefix' => 'vendors'       // URL PREFIX
            ],
            function () {

                // MAIN TABLE ROUTE
                Route::get(
                    '/',
                    'VendorsController@index'
                )->name('admin.vendors');

                // CREATE FORM ROUTE
                Route::get(
                    'create',
                    'VendorsController@create'
                )->name('admin.vendor.create');
                // SAVE FORM ROUTE
                Route::post(
                    'save',
                    'VendorsController@save'
                )->name('admin.vendor.save');

                // EDIT FORM ROUTE
                Route::get(
                    'edit/{vendor_id}',
                    'VendorsController@edit'
                )->name('admin.vendor.edit');
                // UPDATE FORM ROUTE
                Route::post(
                    'update/{vendor_id}',
                    'VendorsController@update'
                )->name('admin.vendor.update');

                // DELETE ROUTE
                Route::get(
                    'delete/{vendor_id}',
                    'VendorsController@destroy'
                )->name('admin.vendor.delete');

            }
        );
        ####################################### END VENDORS ROUTES #######################################

    }
);

Route::group(   // GUEST ADMIN ROUTES GROUP
    [
        'middleware' => 'guest:admin',      // GUEST ADMIN GUARD MIDDLEWARE
        'namespace' => 'Admin'              // ADMIN CONTROLLERS NAMESPACE
    ],
    function () {

        // LOGIN FROM ROUTE
        Route::get(
            'login',
            'LoginsController@showLogin'
        )->name('get.admin.login');
        // LOGIN ATTEMPT ROUTE
        Route::post(
            'login',
            'LoginsController@login'
        )->name('post.admin.login');
    }
);

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
