<?php

namespace App\Http\Controllers;

use App\Models\MemApp;
use Auth;
use Hash;
use DB;
use PDF;
use Excel;
use DataTables;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\processMail;
use GrahamCampbell\ResultType\Success;


// use Illuminate\Support\Facades\Log;
class AdminController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function dashboard()
  {
    $lastLogin = '';
    $loginCount = DB::table('login_logs')
      ->where('user_id', Auth::user()->id)
      ->count();
    $loginNew = DB::table('login_logs')
      ->where('user_id', Auth::user()->id)
      ->orderBy('login_date', 'DESC')
      ->first();
    if ($loginCount == 1) {
      if ($loginNew) {
        $lastLogin = $loginNew->login_date;
      }
    } else {
      $login = DB::table('login_logs')
        ->where('user_id', Auth::user()->id)
        ->orderBy('login_date', 'DESC')
        ->skip(1)
        ->first();
      if ($login) {
        $lastLogin = $login->login_date;
      }
    }
    // $user = Auth::user();
    $campuses = DB::table('campus')->get();
    $data = array(
      'login' => $lastLogin,
      'campuses' => $campuses,
      // 'user_privileges' => DB::table('users')
      // ->join('user_prev', 'users.id', '=', 'user_prev.users_id')
      // ->where('users.id', $user->id)
      // ->get()
    );
    return view('admin.dashboard')->with($data);
  }

  public function memberlist()
  {
    $data['department'] = DB::table('department')->get();

    $data['campuses'] = DB::table('campus')->get();

    return view('admin.memberlist.memberlist')->with($data);
  }



  public function memberDetails()
  {

    return view('admin.memberlist.member-details');
  }

  public function multipleMemberView()
  {

    return view('admin.memberlist.multiple-view');
  }
  public function memberlistViewAll()
  {

    return view('admin.memberlist.memberlist-viewall');
  }

  public function insuranceReports()
  {
    return view('admin.memberlist.insurance-reports');
  }
  public function summaryReports()
  {
    return view('admin.memberlist.summary-reports');
  }
  public function contributionReports()
  {
    return view('admin.memberlist.contribution-reports');
  }

  public function countApplication()
  {
    if (request()->has('view')) {
      $total_new = DB::table('mem_app')->count();
      $forApproval = DB::table('mem_app')->where('app_status', 'NEW APPLICATION')->count();
      $draft = DB::table('mem_app')->where('app_status', 'DRAFT')->count();
      $rejected = DB::table('mem_app')->where('app_status', 'REJECTED')->count();
    }

    $data = array(
      'new_app' => $total_new,
      'forApproval' => $forApproval,
      'draft' => $draft,
      'rejected' => $rejected,
    );
    echo json_encode($data);
  }
  public function saveAgreement(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $inserts = array(
        'user_id' => Auth::user()->id,
        'agreed_flg' => 1,

      );
      $last_id = DB::table('cookies_tbl')->insertGetId($inserts);
      return [
        'last_id' => $last_id
      ];
    });
    return response()->json(['success' => $datadb['last_id']]);
  }
  public function manageAccount()
  {
    $campus = DB::table('campus')->get();
    return view('admin.settings-config.manage-account', compact('campus'));
  }
  public function backUpDatabase()
  {
    return view('admin.settings-config.backup-database');
  }
  public function campusManagement()
  {
    return view('admin.settings-config.campus-management');
  }
  public function collegeManagement()
  {
    $campus = DB::table('campus')->get();
    return view('admin.settings-config.college-management', compact('campus'));
  }
  public function departmentManagement()
  {
    $campus = DB::table('campus')->orderBy('name', 'asc')->get();
    $campus = DB::table('campus')->orderBy('name', 'asc')->get();
    $college_unit = DB::table('college_unit')->get();
    return view('admin.settings-config.department-management', compact('campus'), compact('college_unit'));
  }
  public function employeeClassification()
  {
    return view('admin.settings-config.employee-classification');
  }
  public function historyLogs()
  {
    return view('admin.settings-config.history-logs');
  }
  public function sgModules()
  {
    return view('admin.settings-config.sg-modules');
  }
  public function statusAppointment()
  {
    return view('admin.settings-config.status-appointment');
  }
  public function members_records()
  {
    $total_new = DB::table('mem_app')->where('app_status', 'NEW APPLICATION')->count();
    $forprocessing = DB::table('mem_app')->where('app_status', 'PROCESSING')->where('validator_remarks', '')->count();
    $Approved = DB::table('mem_app')->where('app_status', 'PROCESSING')->where('validator_remarks', 'FORWARDED TO HRDO')->count();
    $draft = DB::table('mem_app')->where('app_status', 'DRAFT APPLICATION')->count();
    $rejected = DB::table('mem_app')->where('app_status', 'REJECTED')->count();
    $userId = Auth::user()->id;
    $cfmCluster = DB::table('user_prev')
      ->join('users', 'user_prev.users_id', '=', 'users.id')
      ->select('user_prev.cfm_cluster')
      ->where('users.id', '=', $userId)
      ->value('cfm_cluster');
    $users = Auth::user()->user_level;
    if ($users == 'ADMIN') {
      $campuses = DB::table('campus')->get();
    } elseif ($users == 'HRDO') {
      $campuses = DB::table('campus')->where('id', '=', Auth::user()->campus_id)->get();
    } else {
      $campuses = DB::table('campus')->where('cluster_id', '=', $cfmCluster)->get();
    }
    $department = DB::table('department')->get();
    $data = array(
      'total_new' => $total_new,
      'forprocessing' => $forprocessing,
      'approved' => $Approved,
      'draft' => $draft,
      'rejected' => $rejected,
      'campuses' => $campuses,
      'department' => $department,
    );
    return view('admin.members.records')->with($data);
  }

  public function members_movement()
  {
    $total_new = DB::table('mem_app')->where('app_status', 'NEW APPLICATION')->count();
    $forprocessing = DB::table('mem_app')->where('app_status', 'PROCESSING')->where('validator_remarks', '')->count();
    $Approved = DB::table('mem_app')->where('app_status', 'PROCESSING')->where('validator_remarks', 'FORWARDED TO HRDO')->count();
    $draft = DB::table('mem_app')->where('app_status', 'DRAFT APPLICATION')->count();
    $rejected = DB::table('mem_app')->where('app_status', 'REJECTED')->count();
    $userId = Auth::user()->id;
    $cfmCluster = DB::table('user_prev')
      ->join('users', 'user_prev.users_id', '=', 'users.id')
      ->select('user_prev.cfm_cluster')
      ->where('users.id', '=', $userId)
      ->value('cfm_cluster');
    $users = Auth::user()->user_level;
    if ($users == 'ADMIN') {
      $campuses = DB::table('campus')->get();
    } elseif ($users == 'HRDO') {
      $campuses = DB::table('campus')->where('id', '=', Auth::user()->campus_id)->get();
    } else {
      $campuses = DB::table('campus')->where('cluster_id', '=', $cfmCluster)->get();
    }
    $department = DB::table('department')->get();
    $data = array(
      'total_new' => $total_new,
      'forprocessing' => $forprocessing,
      'approved' => $Approved,
      'draft' => $draft,
      'rejected' => $rejected,
      'campuses' => $campuses,
      'department' => $department,
    );
    return view('admin.members.movement')->with($data);
  }

  public function members_payroll()
  {
    return view('admin.members.payroll');
  }

  public function members_analytics()
  {
    $campuses = DB::table('campus')->get();
    $data = array(
      'campuses' => $campuses,
      // 'user_privileges' => DB::table('users')
      // ->join('user_prev', 'users.id', '=', 'user_prev.users_id')
      // ->where('users.id', $user->id)
      // ->get()
    );
    return view('admin.members.analytics')->with($data);
  }

  public function members_view_record($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_name',
        'pass_dob',
        'pass_gender',
        'pass_civilstatus',
        'pass_citizenship',
        'pass_currentadd',
        'pass_permaadd',
        'pass_contactnum',
        'pass_landline',
        'pass_email',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',
        'pass_monthlycontri',
        'pass_equivalent',
        'pass_membershipf',
        'pass_proxyform',
        'remarks_name',
        'remarks_dob',
        'remarks_gender',
        'remarks_civilstatus',
        'remarks_citizenship',
        'remarks_currentadd',
        'remarks_permaadd',
        'review_contactnum',
        'review_landline',
        'remarks_email',
        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'remarks_monthlycontri',
        'remarks_equivalent',
        'remarks_membershipf',
        'remarks_proxyform',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $email = DB::table('mem_app')->where('app_no', $id)->select('email_address')->value('email_address');
    $app_stat = DB::table('mem_app')->where('app_no', $id)->select('app_status')->value('app_status');
    if ($app_stat == 'NEW APPLICATION') {
      $mem_appinst = array(
        'app_status' => "PROCESSING",
      );
      $affected = DB::table('mem_app')->where('app_no', $id)
        ->update($mem_appinst);
    }


    $appcount = DB::table('app_trailing')->where('app_no', $id)->count();
    if ($appcount == 0) {
      $apptrail = array(
        'status_remarks' => "AO - Review Validation",
        'app_no' => $id,
        'updateby' => Auth::user()->id,
        'user_level' => Auth::user()->user_level,
      );
      DB::table('app_trailing')->where('app_no', $id)
        ->insert($apptrail);
    }

    if (!empty($affected)) {
      $mailData = [
        'title' => 'Member Application is for Processing',
        'body' => 'Your application are now processing and subjected for approval.',
        'app_no' => $id,
      ];
      Mail::to($email)->send(new processMail($mailData));
    }
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('time_stamp', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.aavalidation')->with($data);
  }

  // public function members_view_record($id)
  // {
  //   // DB::enableQueryLog();
  //   $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
  //     ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
  //     ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
  //     ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
  //     ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
  //     ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
  //     ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
  //     ->select(
  //       'mem_app.*',
  //       'membership_details.*',
  //       'personal_details.*',
  //       'employee_details.*',
  //       'membership_details.*',
  //       'campus.*',
  //       'college_unit.*',
  //       'department.*',
  //       'college_unit.*',
  //       'pass_name',
  //       'pass_dob',
  //       'pass_gender',
  //       'pass_civilstatus',
  //       'pass_citizenship',
  //       'pass_currentadd',
  //       'pass_permaadd',
  //       'pass_contactnum',
  //       'pass_landline',
  //       'pass_email',
  //       'pass_emp_no',
  //       'pass_campus',
  //       'pass_classification',
  //       'pass_college_unit',
  //       'pass_department',
  //       'pass_rankpos',
  //       'pass_appointment',
  //       'pass_appointdate',
  //       'pass_monthlysalary',
  //       'pass_sg',
  //       'pass_sgcat',
  //       'pass_tin_no',
  //       'pass_monthlycontri',
  //       'pass_equivalent',
  //       'pass_membershipf',
  //       'pass_proxyform',
  //       'remarks_name',
  //       'remarks_dob',
  //       'remarks_gender',
  //       'remarks_civilstatus',
  //       'remarks_citizenship',
  //       'remarks_currentadd',
  //       'remarks_permaadd',
  //       'review_contactnum',
  //       'review_landline',
  //       'remarks_email',
  //       'remarks_emp_no',
  //       'remarks_campus',
  //       'remarks_classification',
  //       'remarks_college_unit',
  //       'remarks_department',
  //       'remarks_rankpos',
  //       'remarks_appointment',
  //       'remarks_appointdate',
  //       'remarks_monthlysalary',
  //       'remarks_sg',
  //       'remarks_sgcat',
  //       'remarks_tin_no',
  //       'remarks_monthlycontri',
  //       'remarks_equivalent',
  //       'remarks_membershipf',
  //       'remarks_proxyform',
  //       'general_remarks',
  //       'evaluate_by',
  //       'date_evaluated'
  //     )
  //     ->where('mem_app.app_no', $id)->first();
  //   $email = DB::table('mem_app')->where('app_no', $id)->select('email_address')->value('email_address');
  //   $app_stat = DB::table('mem_app')->where('app_no', $id)->select('app_status')->value('app_status');
  //   if ($app_stat == 'NEW APPLICATION') {
  //     $mem_appinst = array(
  //       'app_status' => "PROCESSING",
  //     );
  //     $affected = DB::table('mem_app')->where('app_no', $id)
  //       ->update($mem_appinst);
  //   }


  //   $appcount = DB::table('app_trailing')->where('app_no', $id)->count();
  //   if ($appcount == 0) {
  //     $apptrail = array(
  //       'status_remarks' => "AA - Review Validation",
  //       'app_no' => $id,
  //       'updateby' => Auth::user()->id,
  //       'user_level' => Auth::user()->user_level,
  //     );
  //     DB::table('app_trailing')->where('app_no', $id)
  //       ->insert($apptrail);
  //   }

  //   if (!empty($affected)) {
  //     $mailData = [
  //       'title' => 'Member Application is for Processing',
  //       'body' => 'Your application are now processing and subjected for approval.',
  //       'app_no' => $id,
  //     ];
  //     Mail::to($email)->send(new processMail($mailData));
  //   }
  //   $status = DB::table('app_trailing')
  //     ->where('app_no', $id)
  //     ->orderBy('time_stamp', 'desc')
  //     ->value('status_remarks');
  //   $user_step = DB::table('app_trailing')
  //     ->where('app_no', $id)
  //     ->orderBy('app_trailing_ID', 'desc')
  //     ->value('user_level');
  //   $trailing = DB::table('app_trailing')
  //     ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
  //   $data = array(
  //     'status' => $status,
  //     'user_step' => $user_step,
  //     'rec' => $records,
  //     'trailing' => $trailing
  //   );
  //   return view('admin.members.view.aavalidation')->with($data);
  // }

  // public function members_view_record($id)
  // {
  //   // DB::enableQueryLog();
  //   $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
  //     ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
  //     ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
  //     ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
  //     ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
  //     ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
  //     ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
  //     ->select(
  //       'mem_app.*',
  //       'membership_details.*',
  //       'personal_details.*',
  //       'employee_details.*',
  //       'membership_details.*',
  //       'campus.*',
  //       'college_unit.*',
  //       'department.*',
  //       'college_unit.*',
  //       'pass_name',
  //       'pass_dob',
  //       'pass_gender',
  //       'pass_civilstatus',
  //       'pass_citizenship',
  //       'pass_currentadd',
  //       'pass_permaadd',
  //       'pass_contactnum',
  //       'pass_landline',
  //       'pass_email',
  //       'pass_emp_no',
  //       'pass_campus',
  //       'pass_classification',
  //       'pass_college_unit',
  //       'pass_department',
  //       'pass_rankpos',
  //       'pass_appointment',
  //       'pass_appointdate',
  //       'pass_monthlysalary',
  //       'pass_sg',
  //       'pass_sgcat',
  //       'pass_tin_no',
  //       'pass_monthlycontri',
  //       'pass_equivalent',
  //       'pass_membershipf',
  //       'pass_proxyform',
  //       'remarks_name',
  //       'remarks_dob',
  //       'remarks_gender',
  //       'remarks_civilstatus',
  //       'remarks_citizenship',
  //       'remarks_currentadd',
  //       'remarks_permaadd',
  //       'review_contactnum',
  //       'review_landline',
  //       'remarks_email',
  //       'remarks_emp_no',
  //       'remarks_campus',
  //       'remarks_classification',
  //       'remarks_college_unit',
  //       'remarks_department',
  //       'remarks_rankpos',
  //       'remarks_appointment',
  //       'remarks_appointdate',
  //       'remarks_monthlysalary',
  //       'remarks_sg',
  //       'remarks_sgcat',
  //       'remarks_tin_no',
  //       'remarks_monthlycontri',
  //       'remarks_equivalent',
  //       'remarks_membershipf',
  //       'remarks_proxyform',
  //       'general_remarks',
  //       'evaluate_by',
  //       'date_evaluated'
  //     )
  //     ->where('mem_app.app_no', $id)->first();
  //   $email = DB::table('mem_app')->where('app_no', $id)->select('email_address')->value('email_address');
  //   $app_stat = DB::table('mem_app')->where('app_no', $id)->select('app_status')->value('app_status');
  //   if ($app_stat == 'NEW APPLICATION') {
  //     $mem_appinst = array(
  //       'app_status' => "PROCESSING",
  //     );
  //     $affected = DB::table('mem_app')->where('app_no', $id)
  //       ->update($mem_appinst);
  //   }


  //   $appcount = DB::table('app_trailing')->where('app_no', $id)->count();
  //   if ($appcount == 0) {
  //     $apptrail = array(
  //       'status_remarks' => "AA - Review Validation",
  //       'app_no' => $id,
  //       'updateby' => Auth::user()->id,
  //       'user_level' => Auth::user()->user_level,
  //     );
  //     DB::table('app_trailing')->where('app_no', $id)
  //       ->insert($apptrail);
  //   }

  //   if (!empty($affected)) {
  //     $mailData = [
  //       'title' => 'Member Application is for Processing',
  //       'body' => 'Your application are now processing and subjected for approval.',
  //       'app_no' => $id,
  //     ];
  //     Mail::to($email)->send(new processMail($mailData));
  //   }
  //   $status = DB::table('app_trailing')
  //     ->where('app_no', $id)
  //     ->orderBy('time_stamp', 'desc')
  //     ->value('status_remarks');
  //   $user_step = DB::table('app_trailing')
  //     ->where('app_no', $id)
  //     ->orderBy('app_trailing_ID', 'desc')
  //     ->value('user_level');
  //   $trailing = DB::table('app_trailing')
  //     ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
  //   $data = array(
  //     'status' => $status,
  //     'user_step' => $user_step,
  //     'rec' => $records,
  //     'trailing' => $trailing
  //   );
  //   return view('admin.members.view.aavalidation')->with($data);
  // }


  public function members_view_record_personal($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_name',
        'pass_dob',
        'pass_gender',
        'pass_civilstatus',
        'pass_citizenship',
        'pass_currentadd',
        'pass_permaadd',
        'pass_contactnum',
        'pass_landline',
        'pass_email',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',
        'pass_monthlycontri',
        'pass_equivalent',
        'pass_membershipf',
        'pass_proxyform',
        'remarks_name',
        'remarks_dob',
        'remarks_gender',
        'remarks_civilstatus',
        'remarks_citizenship',
        'remarks_currentadd',
        'remarks_permaadd',
        'review_contactnum',
        'review_landline',
        'remarks_email',
        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'remarks_monthlycontri',
        'remarks_equivalent',
        'remarks_membershipf',
        'remarks_proxyform',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $email = DB::table('mem_app')->where('app_no', $id)->select('email_address')->value('email_address');
    $app_stat = DB::table('mem_app')->where('app_no', $id)->select('app_status')->value('app_status');
    if ($app_stat == 'NEW APPLICATION') {
      $mem_appinst = array(
        'app_status' => "PROCESSING",
      );
      $affected = DB::table('mem_app')->where('app_no', $id)
        ->update($mem_appinst);
    }


    $appcount = DB::table('app_trailing')->where('app_no', $id)->count();
    if ($appcount == 0) {
      $apptrail = array(
        'status_remarks' => "AO - Review Validation",
        'app_no' => $id,
        'updateby' => Auth::user()->id,
        'user_level' => Auth::user()->user_level,
      );
      DB::table('app_trailing')->where('app_no', $id)
        ->insert($apptrail);
    }

    if (!empty($affected)) {
      $mailData = [
        'title' => 'Member Application is for Processing',
        'body' => 'Your application are now processing and subjected for approval.',
        'app_no' => $id,
      ];
      Mail::to($email)->send(new processMail($mailData));
    }
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('time_stamp', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.aavalidation.personal-details')->with($data);
  }

  public function members_view_record_employee($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_name',
        'pass_dob',
        'pass_gender',
        'pass_civilstatus',
        'pass_citizenship',
        'pass_currentadd',
        'pass_permaadd',
        'pass_contactnum',
        'pass_landline',
        'pass_email',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',
        'pass_monthlycontri',
        'pass_equivalent',
        'pass_membershipf',
        'pass_proxyform',
        'remarks_name',
        'remarks_dob',
        'remarks_gender',
        'remarks_civilstatus',
        'remarks_citizenship',
        'remarks_currentadd',
        'remarks_permaadd',
        'review_contactnum',
        'review_landline',
        'remarks_email',
        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'remarks_monthlycontri',
        'remarks_equivalent',
        'remarks_membershipf',
        'remarks_proxyform',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $email = DB::table('mem_app')->where('app_no', $id)->select('email_address')->value('email_address');
    $app_stat = DB::table('mem_app')->where('app_no', $id)->select('app_status')->value('app_status');
    if ($app_stat == 'NEW APPLICATION') {
      $mem_appinst = array(
        'app_status' => "PROCESSING",
      );
      $affected = DB::table('mem_app')->where('app_no', $id)
        ->update($mem_appinst);
    }


    $appcount = DB::table('app_trailing')->where('app_no', $id)->count();
    if ($appcount == 0) {
      $apptrail = array(
        'status_remarks' => "AO - Review Validation",
        'app_no' => $id,
        'updateby' => Auth::user()->id,
        'user_level' => Auth::user()->user_level,
      );
      DB::table('app_trailing')->where('app_no', $id)
        ->insert($apptrail);
    }

    if (!empty($affected)) {
      $mailData = [
        'title' => 'Member Application is for Processing',
        'body' => 'Your application are now processing and subjected for approval.',
        'app_no' => $id,
      ];
      Mail::to($email)->send(new processMail($mailData));
    }
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('time_stamp', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.aavalidation.employee-details')->with($data);
  }

  public function members_view_record_membership($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_name',
        'pass_dob',
        'pass_gender',
        'pass_civilstatus',
        'pass_citizenship',
        'pass_currentadd',
        'pass_permaadd',
        'pass_contactnum',
        'pass_landline',
        'pass_email',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',
        'pass_monthlycontri',
        'pass_equivalent',
        'pass_membershipf',
        'pass_proxyform',
        'remarks_name',
        'remarks_dob',
        'remarks_gender',
        'remarks_civilstatus',
        'remarks_citizenship',
        'remarks_currentadd',
        'remarks_permaadd',
        'review_contactnum',
        'review_landline',
        'remarks_email',
        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'remarks_monthlycontri',
        'remarks_equivalent',
        'remarks_membershipf',
        'remarks_proxyform',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $email = DB::table('mem_app')->where('app_no', $id)->select('email_address')->value('email_address');
    $app_stat = DB::table('mem_app')->where('app_no', $id)->select('app_status')->value('app_status');
    if ($app_stat == 'NEW APPLICATION') {
      $mem_appinst = array(
        'app_status' => "PROCESSING",
      );
      $affected = DB::table('mem_app')->where('app_no', $id)
        ->update($mem_appinst);
    }


    $appcount = DB::table('app_trailing')->where('app_no', $id)->count();
    if ($appcount == 0) {
      $apptrail = array(
        'status_remarks' => "AO - Review Validation",
        'app_no' => $id,
        'updateby' => Auth::user()->id,
        'user_level' => Auth::user()->user_level,
      );
      DB::table('app_trailing')->where('app_no', $id)
        ->insert($apptrail);
    }

    if (!empty($affected)) {
      $mailData = [
        'title' => 'Member Application is for Processing',
        'body' => 'Your application are now processing and subjected for approval.',
        'app_no' => $id,
      ];
      Mail::to($email)->send(new processMail($mailData));
    }
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('time_stamp', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.aavalidation.membership-details')->with($data);
  }

  public function members_view_record_forms($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_name',
        'pass_dob',
        'pass_gender',
        'pass_civilstatus',
        'pass_citizenship',
        'pass_currentadd',
        'pass_permaadd',
        'pass_contactnum',
        'pass_landline',
        'pass_email',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',
        'pass_monthlycontri',
        'pass_equivalent',
        'pass_membershipf',
        'pass_proxyform',
        'remarks_name',
        'remarks_dob',
        'remarks_gender',
        'remarks_civilstatus',
        'remarks_citizenship',
        'remarks_currentadd',
        'remarks_permaadd',
        'review_contactnum',
        'review_landline',
        'remarks_email',
        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'remarks_monthlycontri',
        'remarks_equivalent',
        'remarks_membershipf',
        'remarks_proxyform',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $email = DB::table('mem_app')->where('app_no', $id)->select('email_address')->value('email_address');
    $app_stat = DB::table('mem_app')->where('app_no', $id)->select('app_status')->value('app_status');
    if ($app_stat == 'NEW APPLICATION') {
      $mem_appinst = array(
        'app_status' => "PROCESSING",
      );
      $affected = DB::table('mem_app')->where('app_no', $id)
        ->update($mem_appinst);
    }


    $appcount = DB::table('app_trailing')->where('app_no', $id)->count();
    if ($appcount == 0) {
      $apptrail = array(
        'status_remarks' => "AO - Review Validation",
        'app_no' => $id,
        'updateby' => Auth::user()->id,
        'user_level' => Auth::user()->user_level,
      );
      DB::table('app_trailing')->where('app_no', $id)
        ->insert($apptrail);
    }

    if (!empty($affected)) {
      $mailData = [
        'title' => 'Member Application is for Processing',
        'body' => 'Your application are now processing and subjected for approval.',
        'app_no' => $id,
      ];
      Mail::to($email)->send(new processMail($mailData));
    }
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('time_stamp', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.aavalidation.forms-attachment')->with($data);
  }

  public function hrdo_view_record($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      // ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->leftjoin('hrdo_validation', 'mem_app.app_no', '=', 'hrdo_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',

        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.hrdovalidation')->with($data);
  }


  public function hrdo_view_record_personal($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',

        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.hrdovalidation.personal-details')->with($data);
  }

  public function hrdo_view_record_employee($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',

        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.hrdovalidation.employee-details')->with($data);
  }

  public function hrdo_view_record_membership($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',

        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.hrdovalidation.membership-details')->with($data);
  }

  public function hrdo_view_record_forms($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('aa_validation', 'mem_app.app_no', '=', 'aa_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',

        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.hrdovalidation.forms-attachment')->with($data);
  }

  public function fm_view_record($id)
  {
    // DB::enableQueryLog();
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
      ->leftjoin('college_unit', 'employee_details.college_unit', '=', 'college_unit.cu_no')
      ->leftjoin('department', 'employee_details.department', '=', 'department.dept_no')
      ->leftjoin('hrdo_validation', 'mem_app.app_no', '=', 'hrdo_validation.app_no')
      ->select(
        'mem_app.*',
        'membership_details.*',
        'personal_details.*',
        'employee_details.*',
        'membership_details.*',
        'campus.*',
        'college_unit.*',
        'department.*',
        'college_unit.*',
        'pass_emp_no',
        'pass_campus',
        'pass_classification',
        'pass_college_unit',
        'pass_department',
        'pass_rankpos',
        'pass_appointment',
        'pass_appointdate',
        'pass_monthlysalary',
        'pass_sg',
        'pass_sgcat',
        'pass_tin_no',

        'remarks_emp_no',
        'remarks_campus',
        'remarks_classification',
        'remarks_college_unit',
        'remarks_department',
        'remarks_rankpos',
        'remarks_appointment',
        'remarks_appointdate',
        'remarks_monthlysalary',
        'remarks_sg',
        'remarks_sgcat',
        'remarks_tin_no',
        'general_remarks',
        'evaluate_by',
        'date_evaluated'
      )
      ->where('mem_app.app_no', $id)->first();
    $status = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('status_remarks');
    $user_step = DB::table('app_trailing')
      ->where('app_no', $id)
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
    $trailing = DB::table('app_trailing')
      ->where('app_no', $id)->orderBy('time_stamp', 'asc')->get();
    $data = array(
      'status' => $status,
      'user_step' => $user_step,
      'rec' => $records,
      'trailing' => $trailing
    );
    return view('admin.members.view.fmvalidation')->with($data);
  }


  public function members_application_trail()
  {
    return view('admin.members.trail');
  }


  public function get_members(Request $request)
  {
    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    // Custom search filter 
    $campus  = $request->get('campus');
    $department  = $request->get('department');
    $dt_from  = $request->get('dt_from');
    $dt_to  = $request->get('dt_to');
    $status_search  = $request->get('status');
    $validator_remarks  = $request->get('remarks');
    $search  = $request->get('searchValue');
    $users = Auth::user()->user_level;
    $userId = Auth::user()->id;
    $campus_id = Auth::user()->campus_id;
    $allowCampus = DB::table('campus')
      ->where('id', $campus_id)
      ->first();
    $cfmCluster = DB::table('user_prev')
      ->join('users', 'user_prev.users_id', '=', 'users.id')
      ->select('user_prev.cfm_cluster')
      ->where('users.id', '=', $userId)
      ->value('cfm_cluster');
    $aa_1 = '';
    $aa_2 = '';
    $aa_3 = '';

    // Total records
    // $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
    //   ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
    //   ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
    //   ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
    //   ->where('mem_app.app_no', 'like', '%' . $search . '%')
    //   ->where('mem_app.app_status', $aa_1)
    //   ->where('mem_app.app_status', $aa_2);

    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->where('mem_app.app_status', '!=', 'deleted')
      ->groupBy('mem_app.app_no');

    if ($cfmCluster > 0) {
      $records->where('campus.cluster_id', $cfmCluster);
    }
    ## Add custom filter conditions
    if (!empty($campus)) {
      $records->where('employee_details.campus', $campus);
    }
    if (!empty($department)) {
      $records->where('employee_details.department', $department);
    }
    if (!empty($search)) {
      $records->orWhere('mem_app.app_no', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.employee_no', 'like', '%' . $search . '%');
      $records->orWhere('personal_details.lastname', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.validator_remarks', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(mem_app.app_date)'), array($dt_from, $dt_to));
    }
    if (!empty($status_search)) {
      $records->where('mem_app.app_status', $status_search);
    }
    if (!empty($validator_remarks)) {
      $records->where('mem_app.validator_remarks', $validator_remarks);
    }
    if ($users == 'AO') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'HRDO') {
      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.validator_remarks', $approved);
      $records->orWhere('mem_app.validator_remarks', 'FORWARD TO FM');
    } else if ($users == 'CFM') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      // $approved = 'APPROVED APPLICATION';
      $approved = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($process, $approved, $allowCampus) {
        $query->where('mem_app.validator_remarks', $process)
          ->where('employee_details.campus', $allowCampus->campus_key)
          // ->orWhere('mem_app.app_status', $approved);
          ->orWhere('mem_app.validator_remarks', $approved);
      });
    }
    $totalRecords = $records->count();

    // Total records with filter
    DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->leftjoin('membership_id', 'mem_app.employee_no', '=', 'membership_id.employee_no')
      ->where('mem_app.app_no', 'like', '%' . $search . '%')
      ->groupBy('mem_app.app_no');
    DB::enableQueryLog();
    if ($cfmCluster > 0) {
      $records->where('campus.cluster_id', $cfmCluster);
    }
    ## Add custom filter conditions
    if (!empty($campus)) {
      $records->where('employee_details.campus', $campus);
    }
    if (!empty($department)) {
      $records->where('employee_details.department', $department);
    }
    if (!empty($search)) {
      $records->orWhere('mem_app.app_no', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.employee_no', 'like', '%' . $search . '%');
      $records->orWhere('personal_details.lastname', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.validator_remarks', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(mem_app.app_date)'), array($dt_from, $dt_to));
    }
    if (!empty($status_search)) {
      $records->where('mem_app.app_status', $status_search);
    }
    if (!empty($validator_remarks)) {
      $records->where('mem_app.validator_remarks', $validator_remarks);
    }
    if ($users == 'AO') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'HRDO') {
      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.validator_remarks', $approved);
      $records->orWhere('mem_app.validator_remarks', 'FORWARD TO FM');
    } else if ($users == 'CFM') {
      $$aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      // $approved = 'APPROVED APPLICATION';
      $approved = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($process, $approved, $allowCampus) {
        $query->where('mem_app.validator_remarks', $process)
          ->where('employee_details.campus', $allowCampus->campus_key)
          // ->orWhere('mem_app.app_status', $approved);
          ->orWhere('mem_app.validator_remarks', $approved);
      });
    }

    $totalRecordswithFilter = $records->count();

    // Fetch records
    DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->where('mem_app.app_no', 'like', '%' . $search . '%')
      ->groupBy('mem_app.app_no');
    if ($cfmCluster > 0) {
      $records->where('campus.cluster_id', $cfmCluster);
    }
    if ($users == 'AO') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'HRDO') {
      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.validator_remarks', $approved);
      $records->orWhere('mem_app.validator_remarks', 'FORWARD TO FM');
    } else if ($users == 'CFM') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      // $approved = 'APPROVED APPLICATION';
      $approved = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($process, $approved, $allowCampus) {
        $query->where('mem_app.validator_remarks', $process)
          ->where('employee_details.campus', $allowCampus->campus_key)
          // ->orWhere('mem_app.app_status', $approved);
          ->orWhere('mem_app.validator_remarks', $approved);
      });
    }
    $dd = DB::getQueryLog();
    ## Add custom filter conditions
    if (!empty($campus)) {
      $records->where('employee_details.campus', $campus);
    }
    if (!empty($department)) {
      $records->where('employee_details.department', $department);
    }
    if (!empty($search)) {
      $records->orWhere('mem_app.app_no', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.employee_no', 'like', '%' . $search . '%');
      $records->orWhere('personal_details.lastname', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.validator_remarks', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(mem_app.app_date)'), array($dt_from, $dt_to));
    }
    if (!empty($status_search)) {
      $records->where('mem_app.app_status', $status_search);
    }
    if (!empty($validator_remarks)) {
      $records->where('mem_app.validator_remarks', $validator_remarks);
    }
    if ($users == 'HRDO') {
      $href = '/admin/members/records/view/hrdo/';
    } else if ($users == 'AO') {
      $href = '/admin/members/records/view/aa/';
    } else if ($users == 'FM') {
      $href = '/admin/members/records/view/fm/';
    } else if ($users == 'CFM') {
      $href = '/admin/members/records/view/aa/';
    }

    $posts = $records->skip($start)
      ->take($rowperpage)
      ->get();
    $data = array();
    if ($posts) {
      foreach ($posts as $r) {
        $start++;
        $row = array();
        if ($users == 'AO') {
          $checkbox_users = $r->validator_remarks == 'AO VERIFIED' ? '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item"></span>'
            : '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item" disabled></span>';
        } else if ($users == 'HRDO') {
          // APPROVED APPLICATION
          $checkbox_users = $r->validator_remarks == 'FORWARD TO FM' ? '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item"></span>'
            : '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item" disabled></span>';
        } else if ($users == 'FM') {
          $checkbox_users = $r->validator_remarks == 'APPROVED APPLICATION' ? '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item"></span>'
            : '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item" disabled></span>';
        } else if ($users == 'CFM') {
          $checkbox_users = $r->validator_remarks == 'AO VERIFIED' ? '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item"></span>'
            : '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item" disabled></span>';
        }
        $row[] = $checkbox_users;
        $row[] = "<a data-md-tooltip='Review Application' class='view_member md-tooltip--right view-member' id='" . $r->app_no . "'
                    href='" . $href . "" . $r->app_no . "'
                  style='cursor: pointer'>
                    <i class='mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large'></i>
                  </a>";
        $row[] = $r->app_no;
        $row[] = date("D M j, Y", strtotime($r->app_date));
        $row[] = '<span class="mp-text-fw-heavy">' . $r->lastname . ', ' . $r->firstname . ' ' . $r->middlename . '</span>';
        $row[] = $r->employee_no;
        $row[] = $r->classification;
        $row[] = $r->rank_position;
        $row[] = $r->name;
        $row[] = $r->app_status;
        $row[] = $r->validator_remarks;

        $data[] = $row;
      }
    }

    $json_data = array(
      "draw" => intval($draw),
      "recordsTotal" => intval($totalRecords),
      "recordsFiltered" => intval($totalRecordswithFilter),
      "data" => $data,
      "dataxx" => $dd
    );
    echo json_encode($json_data);
  }

  //election

  public function election()
  {
    return view('admin.election.election');
  }

  //save election
  public function saveElection(Request $request)
  {
    function clusterNameIdentifier($id)
    {
      if ($id == 1) {
        return "Cluster 1 - DSB";
      } else if ($id == 2) {
        return "Cluster 2 - LBOU";
      } else if ($id == 3) {
        return "Cluster 3 - MLAPGH";
      } else if ($id == 4) {
        return "Cluster 4 - CVM";
      }
    }


    $validate_election_date = DB::table('election_tbl')
      ->where("election_date", "=",  $request->input('election_date'))
      ->count();

    if ($validate_election_date >= 1) {
      return response()->json(
        [
          'election_date_exist' => true,
          'success' => false
        ]
      );
    } else {
      $datadb = DB::transaction(function () use ($request) {
        $inserts_election = array(
          'election_year' => $request->input('election_year'),
          'cluster_id' => $request->input('cluster_id'),
          'cluster_name' => clusterNameIdentifier($request->input('cluster_id')),
          'election_date' => $request->input('election_date'),
          'time_open' => $request->input('user_access') == null ?  $request->input('time_open') : null,
          'time_close' => $request->input('user_access') == null ?  $request->input('time_close') : null,
          'user_access' => $request->input('user_access'),
          'status' => "DRAFT"
        );
        $last_id = DB::table('election_tbl')->insertGetId($inserts_election);
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
    }
  }


  public function saveElectionDraft(Request $request)
  {
    function clusterNameIdentifierDraft($id)
    {
      if ($id == 1) {
        return "Cluster 1 - DSB";
      } else if ($id == 2) {
        return "Cluster 2 - LBOU";
      } else if ($id == 3) {
        return "Cluster 3 - MLAPGH";
      } else if ($id == 4) {
        return "Cluster 4 - CVM";
      }
    }
    $datadb = DB::transaction(function () use ($request) {
      $inserts_election = array(
        'election_year' => $request->input('election_year'),
        'cluster_id' => $request->input('cluster_id'),
        'cluster_name' => clusterNameIdentifierDraft($request->input('cluster_id')),
        'election_date' => $request->input('election_date'),
        'time_open' => $request->input('user_access') == null ?  $request->input('time_open') : null,
        'time_close' => $request->input('user_access') == null ?  $request->input('time_close') : null,
        'user_access' => $request->input('user_access'),
        'status' => "DRAFT"
      );

      $last_id = DB::table('election_tbl')->insertGetId($inserts_election);


      return [
        'last_id' => $last_id
      ];
    });



    return response()->json([
      'success' => true,
      'last_id' => $datadb['last_id'],
    ]);
  }


  public function getElectionDetails(Request $request)
  {
    $columns = [
      0 => 'election_id',
      1 => 'election_year',
      2 => 'election_date',
      3 => 'time_open',
      4 => 'time_close',
      5 => 'user_access',
      6 => 'cluster_id',
      7 => 'status'
    ];
    $totalData = Election::count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $searchValue =  $request->input('search.value');
    $status_select = $request->input('status');
    $time_open  = $request->get('time_open');
    $time_close  = $request->get('time_close');

    $election_date  = $request->get('election_date');
    $election_year  = $request->get('election_year');
    $cluster = $request->get('cluster');

    //filter codes
    if (!empty($searchValue)) {
      $election = DB::table('election_tbl')
        ->where('election_id', 'like', "%{$searchValue}%")
        ->orWhere('election_year', 'like', "%{$searchValue}%")
        ->orWhere('status', 'like', "%{$searchValue}%")
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    } else {
      $election = DB::table('election_tbl')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($status_select)) {
      $election = DB::table('election_tbl')
        ->where('status', '=',  $status_select)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($election_date)) {
      $election = DB::table('election_tbl')
        ->where('election_date', '=',  $election_date)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($election_year)) {
      $election = DB::table('election_tbl')
        ->where('election_year', '=',  $election_year)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($cluster)) {
      $election = DB::table('election_tbl')
        ->where('cluster_id', '=',  $cluster)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($time_open) && !empty($time_close)) {
      $election = DB::table('election_tbl')
        ->where('time_open', '>=',  $time_open)
        ->where('time_close', '<=',  $time_close)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($election_year) && !empty($cluster)) {
      $election = DB::table('election_tbl')
        ->where('election_year', '=',  $election_year)
        ->where('cluster_id', '=',  $cluster)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($election_year) && !empty($cluster) && !empty($election_date)) {
      $election = DB::table('election_tbl')
        ->where('election_year', '=',  $election_year)
        ->where('cluster_id', '=',  $cluster)
        ->where('election_date', '=',  $election_date)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($election_year) && !empty($cluster) && !empty($election_date) && !empty($status_select)) {
      $election = DB::table('election_tbl')
        ->where('election_year', '=',  $election_year)
        ->where('cluster_id', '=',  $cluster)
        ->where('election_date', '=',  $election_date)
        ->where('status_select', '=',  $status_select)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }


    $totalFiltered = Election::when($searchValue, function ($query) use ($searchValue) {
      $query->where('election_id', 'like', "%{$searchValue}%")->orWhere('election_id', 'like', "%{$searchValue}%");
    })
      ->count();

    $data = [];
    foreach ($election as $row) {
      $nestedData['election_id'] = $row->election_id;
      $nestedData['election_year'] = $row->election_year;
      $nestedData['election_date'] = $row->election_date;
      $nestedData['time_open'] = $row->time_open;
      $nestedData['time_close'] = $row->time_close;
      $nestedData['user_access'] = $row->user_access;
      $nestedData['cluster_id'] = $row->cluster_name;
      $nestedData['status'] = $row->status;
      $nestedData['action'] = '
      <a href="/admin/edit-election/' . $row->election_id .  '" data-md-tooltip="Manage Election" class="view_member md-tooltip--top view-member" style="cursor: pointer">
                 <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
               </a>
          
         ';

      $data[] = $nestedData;
    }
    $json_data = [
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data,
    ];

    return response()->json($json_data);
  }


  //count election details 
  public function countElection()
  {
    if (request()->has('view')) {
      $total_ongoing = DB::table('election_tbl')->where('status', 'OPEN')->count();
      $total_close = DB::table('election_tbl')->where('status', 'CLOSE')->count();

      //inner join to employee
      $total_SG15 = DB::table('membership_id')
        ->join("employee_details", "membership_id.employee_no", "=", "employee_details.employee_no")
        ->select("membership.*", "employee_details.salary_grade")
        ->whereBetween("salary_grade", [1, 15])
        ->count();

      $total_SG16 = DB::table('membership_id')
        ->join("employee_details", "membership_id.employee_no", "=", "employee_details.employee_no")
        ->select("membership.*", "employee_details.salary_grade")
        ->whereBetween("salary_grade", [16, 30])
        ->count();
    }

    $data = array(
      'total_ongoing' => $total_ongoing,
      'total_close' => $total_close,
      'total_SG15' => $total_SG15,
      'total_SG16' => $total_SG16,
    );

    echo json_encode($data);
  }

  public function editElection($id)
  {
    $election_details = DB::table('election_tbl')
      ->where('election_id', '=',  $id)
      ->get()->first();

    $candidates_detailsSG15 = DB::table('candidates_tbl')
      ->where('candidates_tbl.election_id', '=',  $id)
      ->where('candidates_tbl.sg_category', '=',  '1-15')
      ->join("personal_details", "candidates_tbl.personal_id", "=", "personal_details.personal_id")
      ->join("campus", "candidates_tbl.campus_id", "=", "campus.id")
      ->join("membership_id", "candidates_tbl.membership_id", "=", "membership_id.mem_id")
      ->join("employee_details", "membership_id.employee_no", "=", "employee_details.employee_no")
      ->select('candidates_tbl.*', 'personal_details.*', 'campus.name as campus_name', 'membership_id.*', 'employee_details.*')
      ->get();
    $candidates_detailsSG16 = DB::table('candidates_tbl')
      ->where('candidates_tbl.election_id', '=',  $id)
      ->where('candidates_tbl.sg_category', '=',  '16-33')
      ->join("personal_details", "candidates_tbl.personal_id", "=", "personal_details.personal_id")
      ->join("campus", "candidates_tbl.campus_id", "=", "campus.id")
      ->join("membership_id", "candidates_tbl.membership_id", "=", "membership_id.mem_id")
      ->join("employee_details", "membership_id.employee_no", "=", "employee_details.employee_no")
      ->select('candidates_tbl.*', 'personal_details.*', 'campus.name as campus_name', 'membership_id.*', 'employee_details.*')
      ->get();

    $data['election_details'] = $election_details;
    $data['candidatesSG15'] = $candidates_detailsSG15;
    $data['candidatesSG16'] = $candidates_detailsSG16;
    if (!empty($election_details)) {
      return view('admin.election.edit-election', compact('election_details', 'candidates_detailsSG15', 'candidates_detailsSG16'));
    } else {
      return redirect('/admin/election-record');
    }
  }

  public function electionValidation()
  {

    $success = false;

    if (request()->has('view')) {
      $open_election = DB::table('election_tbl')
        ->where("status", "=", "OPEN")
        ->count();

      if ($open_election  <= 0) {
        $update_election = DB::table('election_tbl')
          ->where('election_id', request()->get('election_id'))
          ->update([
            'status' =>  "OPEN"
          ]);
      }
    }

    if (!empty($update_election)) {
      $success = true;
    } else if ($open_election >= 1) {
      $success = false;
    }
    $data = array(
      'open_election' => $open_election,
      'success' => $success
    );

    echo json_encode($data);
  }

  //insert candidates form
  public function addCandidates(Request $request)
  {

    if ($request->input('sg_category') == '1-15') {
      $cluster_id = $request->input('cluster_id');
      $campus_id = $request->input('campus_id');
      $election_id = $request->input('election_id');
      $membership_id = $request->input('membership_id');
      $sg_category = $request->input('sg_category');
      $personal_id = $request->input('personal_id');

      $candidate_photo = $request->file('candidate_photo');
      $candidate_attachment = $request->file('candidate_attachment');
    } else if ($request->input('sg_category') == '16-33') {
      $cluster_id = $request->input('cluster_idSG16');
      $campus_id = $request->input('campus_idSG16');
      $election_id = $request->input('election_idSG16');
      $membership_id = $request->input('membership_idSG16');
      $sg_category = $request->input('sg_category');
      $personal_id = $request->input('personal_idSG16');

      $candidate_photo = $request->file('candidate_photoSG16');
      $candidate_attachment = $request->file('candidate_attachmentSG16');
    }




    if ($request->file('candidate_photo')  != null && $request->file('candidate_photo') || $request->file('candidate_photoSG16')  != null && $request->file('candidate_photoSG16')) {

      if ($sg_category == "1-15") {
        $candidate_photo_file = $candidate_photo->getClientOriginalName();
        $file_candidate_photo = $request->input('membership_id') . '_' . $candidate_photo_file;

        $candidate_attachment_file = $candidate_attachment->getClientOriginalName();
        $file_candidate_attachment = $request->input('membership_id') . '_' . $candidate_attachment_file;

        $candidate_photo->storeAs('candidates', $file_candidate_photo, 'public');
        $candidate_attachment->storeAs('candidates', $file_candidate_attachment, 'public');
      } else if ($sg_category == "16-33") {
        $candidate_photo_file = $candidate_photo->getClientOriginalName();
        $file_candidate_photo = $request->input('membership_idSG16') . '_' . $candidate_photo_file;

        $candidate_attachment_file = $candidate_attachment->getClientOriginalName();
        $file_candidate_attachment = $request->input('membership_idSG16') . '_' . $candidate_attachment_file;

        $candidate_photo->storeAs('candidates', $file_candidate_photo, 'public');
        $candidate_attachment->storeAs('candidates', $file_candidate_attachment, 'public');
      }

      // $path = $file_candidate_photo->storeAs('candidate_filee', $file_candidate_photo, 'public');
    } else {
      $path = null;
    }


    $insertCandidates = [
      'cluster_id' => $cluster_id,
      'campus_id' => $campus_id,
      'election_id' =>  $election_id,
      'membership_id' => $membership_id,
      'sg_category' => $sg_category,
      'personal_id' => $personal_id,
      'candidate_photo' => $file_candidate_photo,
      'candidate_attachment' => $file_candidate_attachment
    ];
    DB::table('candidates_tbl')->insert($insertCandidates);

    return response()->json(['message' => 'Success']);
  }

  public function updateElectionRecord(Request $request)
  {
    function clusterNameIdentifierUpdate($id)
    {
      if ($id == 1) {
        return "Cluster 1 - DSB";
      } else if ($id == 2) {
        return "Cluster 2 - LBOU";
      } else if ($id == 3) {
        return "Cluster 3 - MLAPGH";
      } else if ($id == 4) {
        return "Cluster 4 - CVM";
      }
    }

    $election_id = $request->input('election_id');
    $election_year = $request->input('election_year');
    $cluster_id = $request->input('cluster_id');
    $cluster_name = clusterNameIdentifierUpdate($request->input('cluster_id'));
    $election_date = $request->input('election_date');
    $time_open = $request->input('user_access') == null ?  $request->input('time_open') : null;
    $time_close = $request->input('user_access') == null ?  $request->input('time_close') : null;
    $user_access = $request->input('user_access');
    $status = $request->input('status');


    $update_election = DB::table('election_tbl')
      ->where('election_id', $election_id)
      ->update([
        'election_year' => $election_year,
        'cluster_id' =>  $cluster_id,
        'cluster_name' =>  $cluster_name,
        'election_date' =>  $election_date,
        'time_open' =>  $time_open,
        'time_close' =>  $time_close,
        'user_access' =>  $user_access,
        'status' =>  $status,
      ]);

    if (!empty($update_election)) {
      return redirect('/admin/edit-election/' . $election_id);
    }
    return redirect('/admin/edit-election/' . $election_id);
  }

  //election candidate dropdown search query
  public function getCandidates(Request $request)
  {

    // $query = $request->sg_category;

    $query = request()->get('sg_category');
    if ($query == "SG15") {
      $results = DB::table('employee_details')
        ->whereRaw("employee_details.sg_category = '1-15'")
        ->whereRaw("membership_id.mem_id NOT IN (select membership_id from candidates_tbl)")
        ->join('membership_id', 'membership_id.employee_no', '=', 'employee_details.employee_no')
        ->join('mem_app', 'mem_app.employee_no', '=', 'employee_details.employee_no')
        ->join('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
        ->join('campus', 'campus.campus_key', '=', 'employee_details.campus')
        ->select('employee_details.*', 'membership_id.*', 'mem_app.*', 'personal_details.*', 'campus.name as campus_name', 'campus.id as campus_id', 'campus.cluster_id')
        ->orderBy('employee_details.employee_no', 'asc')->get();
    } else if ($query == "SG16") {
      $results = DB::table('employee_details')
        ->whereRaw("employee_details.sg_category = '16-33'")
        ->whereRaw("membership_id.mem_id NOT IN (select membership_id from candidates_tbl)")
        ->join('membership_id', 'membership_id.employee_no', '=', 'employee_details.employee_no')
        ->join('mem_app', 'mem_app.employee_no', '=', 'employee_details.employee_no')
        ->join('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
        ->join('campus', 'campus.campus_key', '=', 'employee_details.campus')
        ->select('employee_details.*', 'membership_id.*', 'mem_app.*', 'personal_details.*', 'campus.name as campus_name', 'campus.id as campus_id', 'campus.cluster_id')
        ->orderBy('employee_details.employee_no', 'asc')->get();
    };
    return response()->json($results);
  }


  public function createElection()
  {
    return view('admin.election.create-election');
  }
  public function electionRecord()
  {
    $election = DB::table('election_tbl')->get();
    return view('admin.election.election-record', compact('election'));
  }
  public function electionAnalytics()
  {
    return view('admin.election.election-analytics');
  }
  public function gethrdo_user(Request $request)
  {
    $userId = Auth::user()->id;
    $department = $request->input('department');
    $cfmCluster = DB::table('user_prev')
      ->join('users', 'user_prev.users_id', '=', 'users.id')
      ->select('user_prev.cfm_cluster')
      ->where('users.id', '=', $userId)
      ->value('cfm_cluster');
    if ($request->input('forward_action') == 'CFM') {
      $hrdouser = DB::table('users')->orderBy('users.id')
        ->select('users.id', 'first_name', 'middle_name', 'last_name')
        ->leftjoin('user_prev', 'user_prev.users_id', '=', 'users.ID')
        ->where('cfm_cluster', $cfmCluster)
        ->where('user_level', 'CFM')->get();
    } else if ($request->input('forward_action') == 'HRDO') {
      $hrdouser = DB::table('users')->orderBy('users.id')
        ->select('users.id', 'first_name', 'middle_name', 'last_name')
        ->leftjoin('campus', 'campus.id', '=', 'users.campus_id')
        ->where('name', $department)
        ->where('user_level', 'HRDO')->get();
    } else if ($request->input('forward_action') == 'FM') {
      $hrdouser = DB::table('users')->orderBy('users.id')
        ->select('users.id', 'first_name', 'middle_name', 'last_name')
        ->where('user_level', 'FM')->get();
    }
    return response()->json($hrdouser);
  }

  public function getEmployeeDetails(Request $request)
  {
    $query = $request->input('app_no');
    $results = DB::table('mem_app')->select('*')->whereRaw("mem_app.app_no = '$query'")
      // ->leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      // ->leftjoin('membership_details', 'membership_details.app_no', '=', 'mem_app.app_no')
      ->get()->first();

    return response()->json($results);
  }

  public function member_analytics(Request $request)
  {
    $query = DB::table('mem_app')
      ->leftJoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->select('mem_app.app_status', DB::raw('COUNT(*) as count'))
      ->whereIn('mem_app.app_status', ['NEW APPLICATION', 'DRAFT APPLICATION', 'PROCESSING', 'APPROVED APPLICATION', 'RETURNED APPLICATION', 'REJECTED APPLICATION']);

    if ($request->has('start_date') && $request->has('end_date')) {
      $query->whereBetween('mem_app.app_date', [$request->input('start_date'), $request->input('end_date')]);
    }

    if ($request->has('campus')) {
      $query->where('employee_details.campus', $request->input('campus'));
    }

    $appStatusCounts = $query->groupBy('mem_app.app_status')->get();

    return response()->json($appStatusCounts);
  }
}
