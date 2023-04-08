<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\App_Validation;
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
Route::get('/classification', [HomeController::class, 'getClassification']);
Route::get('/college_unit', [HomeController::class, 'getcollege_unit']);
Route::get('/department', [HomeController::class, 'getdepartment']);
Route::get('/appointment', [HomeController::class, 'getappointment']);
Route::get('/options_psgc', [HomeController::class, 'getpsgc_prov']);
Route::get('/hrdo_user', [AdminController::class, 'gethrdo_user']);

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
Route::post('/login/draft_step3', [HomeController::class, 'save_draft_step3'])->name('draft_step3');

Route::post('/login/add_proxy', [HomeController::class, 'add_proxy'])->name('add_proxyForm');
Route::post('/login/addcocolife', [HomeController::class, 'addaxa_form'])->name('add_cocolife');
// Route::get('/axaform', [PDFController::class, 'axaForm'])->name('pdf.axa_form');
Route::post('/login/add_benefeciaries', [HomeController::class, 'add_benefeciaries'])->name('add_benefeciaries');


//admin
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

//admin members
Route::get('/admin/members', [AdminController::class, 'memberlist'])->name('admin.memberlist.memberlist');
Route::get('/admin/members/analytics', [AdminController::class, 'member_analytics'])->name('member_analytics');
Route::get('/admin/members/member-details', [AdminController::class, 'memberDetails'])->name('admin.memberlist.member-details');
Route::get('/admin/members/insurance-reports', [AdminController::class, 'insuranceReports'])->name('admin.memberlist.insurance-reports');
Route::get('/admin/members/summary-reports', [AdminController::class, 'summaryReports'])->name('admin.memberlist.summary-reports');
Route::get('/admin/members/view-all', [AdminController::class, 'memberlistViewAll'])->name('admin.memberlist.memberlist-viewall');
Route::get('/admin/members/multiple-view', [AdminController::class, 'multipleMemberView'])->name('admin.memberlist.multiple-view');
Route::get('/admin/members/contribution-reports', [AdminController::class, 'contributionReports'])->name('admin.memberlist.contribution-reports');

Route::get('/admin/membersData', 'AdminController@memberData')->name('dataProcessing');
Route::get('/admin/members/records', [AdminController::class, 'members_records'])->name('admin.members_records');
Route::get('/admin/members/records/payroll', [AdminController::class, 'members_payroll']);
Route::get('/admin/members/records/movement', [AdminController::class, 'members_movement']);
Route::get('/admin/members/records/analytics', [AdminController::class, 'members_analytics']);
Route::get('/admin/members/records/view/aa/{id}', [AdminController::class, 'members_view_record']);
Route::get('/admin/members/records/view/aa/personal/{id}', [AdminController::class, 'members_view_record_personal']);
Route::get('/admin/members/records/view/aa/employee/{id}', [AdminController::class, 'members_view_record_employee']);
Route::get('/admin/members/records/view/aa/membership/{id}', [AdminController::class, 'members_view_record_membership']);
Route::get('/admin/members/records/view/aa/forms/{id}', [AdminController::class, 'members_view_record_forms']);
Route::get('/admin/members/records/view/hrdo/personal/{id}', [AdminController::class, 'hrdo_view_record_personal']);
Route::get('/admin/members/records/view/hrdo/employee/{id}', [AdminController::class, 'hrdo_view_record_employee']);
Route::get('/admin/members/records/view/hrdo/membership/{id}', [AdminController::class, 'hrdo_view_record_membership']);
Route::get('/admin/members/records/view/hrdo/forms/{id}', [AdminController::class, 'hrdo_view_record_forms']);
Route::get('/admin/members/records/view/hrdo/{id}', [AdminController::class, 'hrdo_view_record'])->name('admin.hrdo_view_record');
Route::get('/admin/members/records/view/fm/{id}', [AdminController::class, 'fm_view_record'])->name('admin.fm_view_record');
Route::get('/admin/members/trail', [AdminController::class, 'members_application_trail'])->name('admin.members_application_trail');
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.dashboard');
Route::post('/admin/countApplication', [AdminController::class, 'countApplication'])->name('count_application');
Route::get('/admin/get_members', [AdminController::class, 'get_members'])->name('getMembers');
Route::get('/admin/election', [AdminController::class, 'election'])->name('admin.election.election');
Route::get('/admin/create-election', [AdminController::class, 'createElection'])->name('admin.election.create-election');
Route::get('/admin/election-record', [AdminController::class, 'electionRecord'])->name('admin.election.election-election');
Route::get('/admin/election-analytics', [AdminController::class, 'electionAnalytics'])->name('admin.election.election-analytics');

Route::post('/admin/members/employee', [AdminController::class, 'getEmployeeDetails'])->name('get_employees');
Route::post('/admin/members/update_employee_details', [HomeController::class, 'update_employee'])->name('update_employee_details');
// Route::get('/admin/members', 'AdminController@memberlist');


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
Route::get('/axaform/{id}', [PDFController::class, 'axaForm']);
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
Route::post('/settings/get_details_campus', [Settings::class, 'get_campus'])->name('get_details_campus');
Route::post('/settings/update-campus', [Settings::class, 'update_campus'])->name('update-campus');
// classification
Route::post('/settings/save-class', [Settings::class, 'save_classif'])->name('save-class');
Route::get('/settings/class_list', [Settings::class, 'classification_table'])->name('class_list');
Route::post('/settings/update_status', [Settings::class, 'up_status'])->name('update_status');
// college
Route::post('/settings/save-college', [Settings::class, 'save_college'])->name('save-college');
Route::get('/settings/college_list', [Settings::class, 'college_table'])->name('college_list');
Route::post('/settings/delete_college', [Settings::class, 'remove_college'])->name('delete_college');
Route::post('/settings/get_details_coll', [Settings::class, 'get_college'])->name('get_details_coll');
Route::post('/settings/filter_college_unit', [Settings::class, 'filter_college_unit'])->name('filter_college_unit');
Route::post('/settings/update-college', [Settings::class, 'update_college'])->name('update-college');

// department
Route::post('/settings/save-department', [Settings::class, 'save_department'])->name('save-department');
Route::get('/settings/department_list', [Settings::class, 'department_table'])->name('department_list');
Route::post('/settings/delete_department', [Settings::class, 'remove_department'])->name('delete_department');
Route::post('/settings/get_details_dept', [Settings::class, 'get_department'])->name('get_details_dept');
Route::post('/settings/update-department', [Settings::class, 'update_department'])->name('update-department');
// appointment
Route::post('/settings/save-appointment', [Settings::class, 'save_appointment'])->name('save-appointment');
Route::get('/settings/appt_list', [Settings::class, 'appointment_table'])->name('appt_list');
Route::post('/settings/update_appstatus', [Settings::class, 'up_appstatus'])->name('update_appstatus');
// salarygrade
Route::post('/settings/save-salaryg', [Settings::class, 'save_salaryg'])->name('save-salaryg');
Route::get('/settings/salaryg_list', [Settings::class, 'sg_table'])->name('salaryg_list');
Route::post('/settings/get_details_sg', [Settings::class, 'get_sg'])->name('get_details_sg');
Route::post('/settings/update-salaryg', [Settings::class, 'up_salaryg'])->name('update-salaryg');

// users settings
Route::post('/settings/add_users', [Settings::class, 'save_users'])->name('add_users');
Route::get('/settings/users_list', [Settings::class, 'users_table'])->name('users_list');
Route::post('/settings/get_details_user', [Settings::class, 'get_users'])->name('get_details_user');
Route::post('/settings/update-users', [Settings::class, 'update_users'])->name('update-users');
Route::post('/settings/delete_users', [Settings::class, 'remove_users'])->name('delete_users');

// aa validation
Route::post('/save_aa_validation', [App_Validation::class, 'aa_validation_save'])->name('save_aa_validation');
Route::post('/reject_application', [App_Validation::class, 'aa_validation_rejected'])->name('reject_application');
Route::post('/return_application', [App_Validation::class, 'returnto_application'])->name('return_application');
Route::post('/forward_application', [App_Validation::class, 'forwardto_application'])->name('forward_application');
Route::get('/returned_application/{id}', [HomeController::class, 'returned_application'])->name('returned_application');
Route::post('/validate_step', [App_Validation::class, 'validate_step_aa'])->name('validate_step');
Route::post('/validate_step_reject', [App_Validation::class, 'validate_step_reject'])->name('validate_step_reject');

// hrdo validation 
Route::post('/save_hrdo_validation', [App_Validation::class, 'hrdo_validation_save'])->name('save_hrdo_validation');
Route::post('/save_drafthrdo_validation', [App_Validation::class, 'hrdo_validation_draft'])->name('save_drafthrdo_validation');
Route::post('/return_application_aa', [App_Validation::class, 'returnto_aa_application'])->name('return_application_aa');

//FM validation
Route::post('/save_fm_validation', [App_Validation::class, 'fm_validation_save'])->name('save_fm_validation');

//Payroll Advise
Route::get('/admin/get_payroll_advise', [PayrollController::class, 'get_payroll_advise'])->name('getPayrollAdvise');

//AXA
Route::get('/admin/get_beneficiary_axa', [HomeController::class, 'get_beneficiary_axa'])->name('getBeneficiaryAxa');
Route::post('/admin/add_beneficiary_axa', [HomeController::class, 'add_beneficiary_axa'])->name('add_beneficiary_axa');
Route::post('/admin/delete_beneficiary_axa', [HomeController::class, 'delete_beneficiary_axa'])->name('delete_beneficiary_axa');