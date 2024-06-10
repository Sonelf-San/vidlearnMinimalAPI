<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'PageController@index')->name('index');


/*========================================================
    Admin Routes
  ======================================================== */


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {

    Route::group(['namespace' => 'Auth'], function() {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login')->name('login.submit');

        Route::get('/forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/forgot-password', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        Route::get('/reset-password/{token}', 'ResetPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('/reset-password/{token}', 'ResetPasswordController@reset')->name('password.update');
    });

    Route::group(['middleware' => ['admin']], function () {

        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        })->name('index');
        Route::get('/dashboard', 'DashboardController@getDashboard')->name('dashboard');

        Route::resource('team_members', 'TeamController');
        Route::get('/user-update-status/{id}', 'TeamController@updateStatus')->name('team_members.status_update');
        Route::post('/team_members/update-rank', 'TeamController@updateRank')->name('team_members.rank_update');

        Route::resource('articles', 'CourseController');

        Route::resource('pages', 'PageController');

        // Setting
        Route::get('/settings', 'SettingController@index')->name('settings');
        Route::post('/settings', 'SettingController@store')->name('settings.store');

        Route::resource('categories', 'CategoryController');

        Route::resource('positions', 'PositionController');

        Route::resource('logos', 'LogoController');

        Route::resource('partners', 'PartnerController');

        Route::resource('administrator', 'AdminController');

        // PROFILE
        Route::get('/profile', 'ProfileController@getProfile')->name('profile');
        Route::post('/profile/edit', 'ProfileController@editProfile')->name('profile.edit');
        Route::post('/profile/change-password', 'ProfileController@changePassword')->name('profile.password');

        Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    });
});
