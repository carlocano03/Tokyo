<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
// use App\Http\Controllers\Member_registration;
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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes('/admin');
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('admin', [
    'as' => 'admin',
    // 'uses' => 'Auth\LoginController@showLoginForm'
  ]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/login/add_member', [HomeController::class, 'add_member'])->name('add_member');

