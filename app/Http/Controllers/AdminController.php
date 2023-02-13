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
      $forApproval = DB::table('mem_app')->where('app_status', 'SUBMITTED')->count();
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
  public function saveAgreement(Request $request) {
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
    return view('admin.settings-config.department-management',compact('campus') , compact('college_unit'));
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
    $total_new = DB::table('mem_app')->count();
    $forApproval = DB::table('mem_app')->where('app_status', 'SUBMITTED')->count();
    $draft = DB::table('mem_app')->where('app_status', 'APPROVED')->count();
    $rejected = DB::table('mem_app')->where('app_status', 'REJECTED')->count();

    $campuses = DB::table('campus')->get();
    $data = array(
      'new_app' => $total_new,
      'forApproval' => $forApproval,
      'approved' => $draft,
      'rejected' => $rejected,
      'campuses' => $campuses,
    );
    return view('admin.members.records')->with($data);
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
    $search  = $request->get('searchValue');

    // Total records
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->where('mem_app.app_no', 'like', '%' . $search . '%');

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
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(mem_app.app_date)'), array($dt_from, $dt_to));
    }
    $totalRecords = $records->count();

    // Total records with filter
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->where('mem_app.app_no', 'like', '%' . $search . '%');

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
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(mem_app.app_date)'), array($dt_from, $dt_to));
    }
    $totalRecordswithFilter = $records->count();

    // Fetch records
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->where('mem_app.app_no', 'like', '%' . $search . '%');

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
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(mem_app.app_date)'), array($dt_from, $dt_to));
    }

    $posts = $records->skip($start)
      ->take($rowperpage)
      ->get();
    $data = array();
    if ($posts) {
      foreach ($posts as $r) {
        $start++;
        $row = array();
        $row[] = $r->app_status == 'SUBMITTED' ? '<input type="checkbox" name="check[]" id="select_item">':'<input type="checkbox" name="check[]" id="select_item" disabled>';
        $row[] = "<a data-md-tooltip='Review Application' class='view_member md-tooltip--right view-member' id='" . $r->app_no . "' style='cursor: pointer'>
                    <i class='mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large'></i>
                  </a>";
        $row[] = $r->app_no;
        $row[] = date("D M j, Y", strtotime($r->app_date));
        $row[] = '<span class="mp-text-fw-heavy">' . $r->lastname . ', ' . $r->firstname . ' ' . $r->middlename . '</span>';
        $row[] = $r->employee_no;
        $row[] = $r->classification;
        $row[] = $r->rank_position;
        $row[] = '';
        $row[] = $r->app_status;
        $row[] = $r->app_status;

        $data[] = $row;
      }
    }
    $json_data = array(
      "draw" => intval($draw),
      "recordsTotal" => intval($totalRecords),
      "recordsFiltered" => intval($totalRecordswithFilter),
      "data" => $data
    );
    echo json_encode($json_data);
  }
}
