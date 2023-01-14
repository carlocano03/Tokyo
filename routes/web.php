<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PDFController;
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


Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

//GET
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login/get_beneficiary', [HomeController::class, 'get_beneficiary'])->name('getBeneficiary');
Route::post('/login/delete_beneficiary', [HomeController::class, 'delete_beneficiary'])->name('remove_benefeciaries');
Route::post('/login/add_benefeciaries', [HomeController::class, 'add_benefeciaries'])->name('add_benefeciaries');
//POST

Route::post('/login/add_member', [HomeController::class, 'add_member'])->name('add_member');
Route::post('/login/add_member_con', [HomeController::class, 'add_member_p2'])->name('add_member_con');
Route::post('/login/add_member_con_up', [HomeController::class, 'add_member_up_p2'])->name('add_member_con_up');
Route::post('/login/add_member_update', [HomeController::class, 'add_member_update1'])->name('add_member_update');


Route::post('/login/add_benefeciaries', [HomeController::class, 'add_benefeciaries'])->name('add_benefeciaries');


//admin
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// Route::get('/admin/dashboard', 'AdminController@index');

//admin
// Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/dashboard', 'AdminController@index');


//PDF Generation
Route::get('/generateCocolife', [PDFController::class, 'generateCocolife'])->name('generateCocolife');
Route::get('/generateProxyForm', [PDFController::class, 'generateProxyForm'])->name('generateProxyForm');