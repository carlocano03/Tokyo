<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/logout', [LoginController::class, 'logout']);

// Auth::routes('/admin');
Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('admin', [
    'as' => 'admin',
    'uses' => 'Auth\LoginController@showLoginForm'
  ]);


Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

Route::get('/options', [HomeController::class, 'getCampuses']);

//GET
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login/get_beneficiary', [HomeController::class, 'get_beneficiary'])->name('getBeneficiary');
Route::post('/login/delete_beneficiary', [HomeController::class, 'delete_beneficiary'])->name('remove_benefeciaries');
Route::post('/login/add_benefeciaries', [HomeController::class, 'add_benefeciaries'])->name('add_benefeciaries');
//POST

Route::post('/login/add_member', [HomeController::class, 'add_member'])->name('add_member');
Route::post('/login/add_member_con', [HomeController::class, 'add_member_p2'])->name('add_member_con');
Route::post('/login/add_member_details', [HomeController::class, 'add_member_p3'])->name('add_member_details');
Route::post('/login/add_member_con_up', [HomeController::class, 'add_member_up_p2'])->name('add_member_con_up');
Route::post('/login/add_member_update', [HomeController::class, 'add_member_update1'])->name('add_member_update');
Route::post('/login/add_proxy', [HomeController::class, 'add_proxy'])->name('add_proxyForm');


Route::post('/login/add_benefeciaries', [HomeController::class, 'add_benefeciaries'])->name('add_benefeciaries');


//admin
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/members/records', [AdminController::class, 'members_records'])->name('admin.members_records');
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.dashboard');
// Route::get('/admin/dashboard', 'AdminController@index');

//admin
// Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

//member
Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
Route::get('/member/settings', [MemberController::class, 'settings'])->name('member.settings');
Route::get('/member/loan', [MemberController::class, 'loan'])->name('member.loan');
Route::get('/member/transaction', [MemberController::class, 'transaction'])->name('member.transaction');
Route::get('/member/member', [MemberController::class, 'member'])->name('member.member');
Route::get('/member/equity', [MemberController::class, 'equity'])->name('member.equity');

//member-profile
Route::get('/member/update-password', [MemberController::class, 'updatepassword'])->name('member.updatepassword');


//PDF Generation
Route::get('/generateCocolife', [PDFController::class, 'generateCocolife'])->name('generateCocolife');
Route::get('/generateProxyForm/{id}', [PDFController::class, 'generateProxyForm']);
Route::get('/downloadFormProxy', [PDFController::class, 'downloadForm'])->name('download_form');

Route::get('/memberform/{id}', [PDFController::class, 'memberform'])->name('memberform');
Route::get('/proxyForm', [PDFController::class, 'proxyForm'])->name('proxyForm');


// check status trail
Route::post('/login/status_trail', [HomeController::class, 'search_app_trail'])->name('status_trail');
Route::post('/login/continued_trail', [HomeController::class, 'continued_trail_status'])->name('continued_trail');

// slarygrade bracket
Route::post('/login/check_sg', [HomeController::class, 'check_sg_bracket'])->name('check_sg');
