<?php

namespace App\Http\Controllers;

use App\Models\MemApp;
use Auth;
use Hash;
use DB;
use PDF;
use Excel;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\processMail;

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
    $campus = DB::table('campus')->get();
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
        'status_remarks' => "AA - Review Validation",
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

  public function hrdo_view_record($id)
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
    return view('admin.members.view.hrdovalidation')->with($data);
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
    $cfmCluster = DB::table('user_prev')
      ->join('users', 'user_prev.users_id', '=', 'users.id')
      ->select('user_prev.cfm_cluster')
      ->where('users.id', '=', $userId)
      ->value('cfm_cluster');
    $aa_1 = '';
    $aa_2 = '';
    $aa_3 = '';

    // Total records
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->where('mem_app.app_no', 'like', '%' . $search . '%')
      ->where('mem_app.app_status', $aa_1)
      ->where('mem_app.app_status', $aa_2);
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
    if ($users == 'AA') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AA VERIFIED';
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
          ->orWhere('mem_app.validator_remarks', '=', 'FOR CORRECTION');
      });
    } else if ($users == 'HRDO') {
      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->orWhere('mem_app.validator_remarks', $approved);
    } else if ($users == 'CFM') {
      $cfm = 'AA VERIFIED';
      $records->where('mem_app.app_status', $cfm);
    }else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($process, $approved) {
        $query->where('mem_app.validator_remarks', $process)
          ->orWhere('mem_app.app_status', $approved);
      });
    }
    $totalRecords = $records->count();

    // Total records with filter
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->where('mem_app.app_no', 'like', '%' . $search . '%');
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
    if ($users == 'AA') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AA VERIFIED';
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
          ->orWhere('mem_app.validator_remarks', '=', 'FOR CORRECTION');
      });
    } else if ($users == 'HRDO') {
      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->orWhere('mem_app.validator_remarks', $approved);
    } else if ($users == 'CFM') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AA VERIFIED';
      $process = 'PROCESSING';
      $records->where(function ($query) use ($aa_1, $cfm, $process) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR CORRECTION');
      });
    }else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($process, $approved) {
        $query->where('mem_app.validator_remarks', $process)
          ->orWhere('mem_app.app_status', $approved);
      });
    }

    $totalRecordswithFilter = $records->count();

    // Fetch records
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->where('mem_app.app_no', 'like', '%' . $search . '%');
    if ($cfmCluster > 0) {
      $records->where('campus.cluster_id', $cfmCluster);
    }
    if ($users == 'AA') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AA VERIFIED';
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
          ->orWhere('mem_app.validator_remarks', '=', 'FOR CORRECTION');
      });
    } else if ($users == 'HRDO') {
      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->where('mem_app.app_status', $approved);
      $records->orWhere('mem_app.validator_remarks', $approved);
      $records->orWhere('mem_app.validator_remarks', 'FORWARDED TO FM');
    } else if ($users == 'CFM') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AA VERIFIED';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR CORRECTION');
      });
    }else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($process, $approved) {
        $query->where('mem_app.validator_remarks', $process)
          ->orWhere('mem_app.app_status', $approved);
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
    } else if($users == 'AA') {
      $href = '/admin/members/records/view/aa/';
    } else if($users == 'FM') {
      $href = '';
    }

    $posts = $records->skip($start)
      ->take($rowperpage)
      ->get();
    $data = array();
    if ($posts) {
      foreach ($posts as $r) {
        $start++;
        $row = array();
        if ($users == 'AA') {
          $checkbox_users = $r->validator_remarks == 'AA VERIFIED' ? '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item"></span>'
            : '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item" disabled></span>';
        } else if ($users == 'HRDO') {
          $checkbox_users = $r->validator_remarks == 'APPROVED APPLICATION' ? '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item"></span>'
            : '<span style="width: 100%; display: flex; flex-direction:row; align-items: center; justify-content: center"><input type="checkbox" name="check[]" class="select_item" id="select_item" disabled></span>';
        }else{
          $checkbox_users = '';
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
  public function createElection()
  {
    return view('admin.election.create-election');
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
}
