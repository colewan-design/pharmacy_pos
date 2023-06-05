<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::any('/{slug}', function () {
//     return view('welcome');
// });
Route::get('/logout', 'UserController@logout');

Auth::routes();

Route::get('/', 'UserController@index');
Route::any('{slug}', 'UserController@index');

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/{path}', 'HomeController@index')->where('path', '([A-z\d/_.-]+)?');
