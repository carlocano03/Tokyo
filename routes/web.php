<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Settings;
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
Route::get('/options_psgc', [HomeController::class, 'getpsgc_prov']);

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
Route::post('/login/update_trail_member', [HomeController::class, 'update_trail_member_1'])->name('update_trail_member');
Route::post('/login/update_trail_member_1', [HomeController::class, 'update_trail_member_2'])->name('update_trail_member_1');

Route::post('/login/add_proxy', [HomeController::class, 'add_proxy'])->name('add_proxyForm');
Route::post('/login/addcocolife', [HomeController::class, 'addcocolife'])->name('add_cocolife');

Route::post('/login/add_benefeciaries', [HomeController::class, 'add_benefeciaries'])->name('add_benefeciaries');


//admin
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/members/records', [AdminController::class, 'members_records'])->name('admin.members_records');
Route::get('/admin/members/trail', [AdminController::class, 'members_application_trail'])->name('admin.members_application_trail');
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.dashboard');
Route::post('/admin/countApplication', [AdminController::class, 'countApplication'])->name('count_application');
Route::get('/admin/get_members', [AdminController::class, 'get_members'])->name('getMembers');

//admin settings links
Route::get('/admin/settings/manage-account', [AdminController::class, 'manageAccount'])->name('admin.settings-config.manage-account');
Route::get('/admin/settings/backup-database', [AdminController::class, 'backUpDatabase'])->name('admin.settings-config.backup-database');
Route::get('/admin/settings/campus-management', [AdminController::class, 'campusManagement'])->name('admin.settings-config.campus-management');
Route::get('/admin/settings/college-management', [AdminController::class, 'collegeManagement'])->name('admin.settings-config.college-management');
Route::get('/admin/settings/department-management', [AdminController::class, 'departmentManagement'])->name('admin.settings-config.department-management');
Route::get('/admin/settings/employee-classification', [AdminController::class, 'employeeClassification'])->name('admin.settings-config.employee-classification');
Route::get('/admin/settings/history-logs', [AdminController::class, 'historyLogs'])->name('admin.settings-config.history-logs');
Route::get('/admin/settings/sg-modules', [AdminController::class, 'sgModules'])->name('admin.settings-config.sg-modules');
Route::get('/admin/settings/status-appointment', [AdminController::class, 'statusAppointment'])->name('admin.settings-config.status-appointment');


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
Route::get('/generateCocolife/{id}', [PDFController::class, 'generateCocolife'])->name('generateCocolife');
Route::get('/generateProxyForm/{id}', [PDFController::class, 'generateProxyForm']);
Route::get('/downloadFormProxy', [PDFController::class, 'downloadForm'])->name('download_form');
Route::get('/downloadCoco', [PDFController::class, 'downloadCoco'])->name('download_coco');
Route::get('/downloadProxy', [PDFController::class, 'downloadProxy'])->name('download_proxy');



Route::get('/memberform/{id}', [PDFController::class, 'memberform'])->name('memberform');
Route::get('/proxyForm', [PDFController::class, 'proxyForm'])->name('proxyForm');


// check status trail
Route::post('/login/status_trail', [HomeController::class, 'search_app_trail'])->name('status_trail');
Route::post('/login/continued_trail', [HomeController::class, 'continued_trail_status'])->name('continued_trail');

// slarygrade bracket
Route::post('/login/check_sg', [HomeController::class, 'check_sg_bracket'])->name('check_sg');

// psgc_mun
Route::post('/login/psgc_munc', [HomeController::class, 'psgc_munc'])->name('psgc_munc');
Route::post('/login/psgc_brgy', [HomeController::class, 'psgc_brgy'])->name('psgc_brgy');

// settings
Route::post('/save-agreement', [AdminController::class, 'saveAgreement'])->name('saveAgreement');
Route::get('/settings/campus_list', [Settings::class, 'campus_list'])->name('campus_list');
Route::post('/settings/save_campus', [Settings::class, 'save_campus'])->name('add_campus');
Route::post('/settings/delete_campus', [Settings::class, 'remove_campus'])->name('delete_campus');
// classification
Route::post('/settings/save-class', [Settings::class, 'save_classif'])->name('save-class');
Route::get('/settings/class_list', [Settings::class, 'classification_table'])->name('class_list');
Route::post('/settings/update_status', [Settings::class, 'up_status'])->name('update_status');
// college
Route::post('/settings/save-college', [Settings::class, 'save_college'])->name('save-college');
Route::get('/settings/college_list', [Settings::class, 'college_table'])->name('college_list');
Route::post('/settings/delete_college', [Settings::class, 'remove_college'])->name('delete_college');
Route::post('/settings/get_details_coll', [Settings::class, 'get_college'])->name('get_details_coll');
Route::post('/settings/update-college', [Settings::class, 'update_college'])->name('update-college');


