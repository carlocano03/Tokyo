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
use App\Models\Loans;
use App\Models\OLDMembers;
use App\Models\OLDBeneficiaries;
use App\Models\LoanTransaction;
use App\Models\ContributionTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\processMail;
use GrahamCampbell\ResultType\Success;
use Mockery\Undefined;
use Carbon\Carbon;

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
    if (Auth::check()) {
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
    } else {
      return redirect('/admin');
    }
  }

  public function memberlist()
  {
    if (!Auth::check()) {
      return redirect('/admin');
    }
    $data['department'] = DB::table('old_department')->get();

    $data['campuses'] = DB::table('old_campus')->get();

    return view('admin.memberlist.memberlist')->with($data);
  }






  //member master list details

  public function getMemberMasterList(Request $request)
  {
    $columns = [
      0 => 'member.user_id',
      1 => 'member_no',
      2 => 'member_no',
      3 => 'full_name',
      4 => 'member_no',
      5 => 'member_no',
      6 => 'member_no',
      7 => 'member_no',
      8 => 'member_no',
    ];
    $totalData = OLDMembers::count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $searchValue =  $request->input('search.value');

    $campuses_select = $request->input('campuses_select');
    $department_select = $request->input('department_select');

    $date_from_select  = $request->get('date_from_select');
    $date_to_select  = $request->get('date_to_select');


    //filter codes
    if (!empty($searchValue)) {
      $records = OLDMembers::select('users.*', DB::raw('CONCAT(users.first_name," ",users.last_name) AS full_name'), 'member.member_no as member_no', 'member.position_id', 'old_campus.name as campus', 'old_department.name as department', 'member.membership_date as memdate')
        ->leftjoin('users', 'member.user_id', 'users.id')
        ->leftjoin('old_campus', 'member.campus_id', 'old_campus.id')
        ->leftjoin('old_department', 'member.department_id', 'old_department.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->where('member.member_no', 'like', '%' . $searchValue . '%')
        ->orWhere('users.last_name', 'like', '%' . $searchValue . '%')
        ->orWhere('users.first_name', 'like', '%' . $searchValue . '%')
        ->orWhere('users.middle_name', 'like', '%' . $searchValue . '%')
        ->get();
    } else {
      $records = OLDMembers::select('users.*', DB::raw('CONCAT(users.first_name," ",users.last_name) AS full_name'), 'member.member_no as member_no', 'member.position_id', 'old_campus.name as campus', 'old_department.name as department', 'member.membership_date as memdate')
        ->leftjoin('users', 'member.user_id', 'users.id')
        ->leftjoin('old_campus', 'member.campus_id', 'old_campus.id')
        ->leftjoin('old_department', 'member.department_id', 'old_department.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($campuses_select)) {
      $records = OLDMembers::select('users.*', DB::raw('CONCAT(users.first_name," ",users.last_name) AS full_name'), 'member.member_no as member_no', 'member.position_id', 'old_campus.name as campus', 'old_department.name as department', 'member.membership_date as memdate')
        ->leftjoin('users', 'member.user_id', 'users.id')
        ->leftjoin('old_campus', 'member.campus_id', 'old_campus.id')
        ->leftjoin('old_department', 'member.department_id', 'old_department.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)

        ->Where('member.campus_id', '=', $campuses_select)
        ->orWhere('member.department_id', '=', $department_select)

        ->get();
    }
    if (!empty($department_select)) {
      $records = OLDMembers::select('users.*', DB::raw('CONCAT(users.first_name," ",users.last_name) AS full_name'), 'member.member_no as member_no', 'member.position_id', 'old_campus.name as campus', 'old_department.name as department', 'member.membership_date as memdate')
        ->leftjoin('users', 'member.user_id', 'users.id')
        ->leftjoin('old_campus', 'member.campus_id', 'old_campus.id')
        ->leftjoin('old_department', 'member.department_id', 'old_department.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)

        ->where('member.department_id', '=', $department_select)
        ->orWhere('member.campus_id', '=', $campuses_select)
        ->get();
    }
    if (!empty($date_from_select) && !empty($date_to_select)) {
      $records = OLDMembers::select('users.*', DB::raw('CONCAT(users.first_name," ",users.last_name) AS full_name'), 'member.member_no as member_no', 'member.position_id', 'old_campus.name as campus', 'old_department.name as department', 'member.membership_date as memdate')
        ->leftjoin('users', 'member.user_id', 'users.id')
        ->leftjoin('old_campus', 'member.campus_id', 'old_campus.id')
        ->leftjoin('old_department', 'member.department_id', 'old_department.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->whereBetween('member.membership_date', [$date_from_select, $date_to_select])

        ->get();
    }


    $totalFiltered = OLDMembers::when($searchValue, function ($query) use ($searchValue) {
      // $query->where('id', 'like', "%{$searchValue}%")->orWhere('status', 'like', "%{$searchValue}%");
    })
      ->count();

    foreach ($records as $row) {
      $nestedData['date_created'] = $row->member_no;
      $nestedData['member_no'] = $row->member_no;
      $nestedData['memdate'] = $row->memdate;
      $nestedData['full_name'] = $row->full_name;
      $nestedData['campus'] = $row->campus;
      $nestedData['class'] = $row->department;
      $nestedData['department'] = $row->department;
      $nestedData['positions'] = $row->position_id;

      $nestedData['checkbox'] = ' <span style="display: flex; justify-content: center;" > 
                                    <input   type="checkbox" name="check[]" value="'  . $row->id .  '" class="select_item" id="select_item">
                                 </span>
         ';

      if (!empty($row)) {
        $nestedData['action'] = '
      
             <a href="/admin/members/member-details/' . $row->id . '" data-md-tooltip="View Member" id="member_load" class="view_member md-tooltip--right view-member" style="cursor: pointer">
                                                            <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                                        </a>
         ';
      }
      $data[] = $nestedData;
    }

    if (empty($data)) {
      $json_data = [
        "draw" => intval($request->input('draw')),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => [],
      ];
    } else {
      $json_data = [
        "draw" => intval($request->input('draw')),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data,
      ];
    }





    return response()->json($json_data);
  }
  public function memberDetails($id)
  {
    $member = User::where('users.id', $id)
      ->select('*', 'member.id as member_id', 'member_detail.*', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('member_detail', 'member_detail.member_no', '=', 'member.member_no')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')

      ->first();


    $recentcontributions = ContributionTransaction::select('*')
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->leftjoin('contribution_account', 'contribution_transaction.account_id', 'contribution_account.id')
      ->where('contribution.member_id', '=', $member->member_id)
      ->Where('contribution_transaction.amount', '<>', 0.00)
      ->orderBy('contribution.date', 'desc')
      ->orderBy('contribution.reference_no', 'desc')

      ->limit(3)
      ->get();

    $contributions = array();

    $membercontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 2)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['membercontribution'] = $membercontribution->total;


    $upcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 1)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['upcontribution'] = $upcontribution->total;


    $eupcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 3)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['eupcontribution'] = $eupcontribution->total;


    $emcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 4)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['emcontribution'] = $emcontribution->total;


    $totalcontributions = array_sum($contributions);



    $recentloans = LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date order by date desc) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('member', 'loan.member_id', 'member.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where('loan.member_id', '=', $member->member_id)
      ->Where('loan_transaction.amount', '<>', 0.00)
      ->groupBy('loan_id')
      ->orderBy('date', 'desc')
      ->limit(3)
      ->get();


    $outstandingloans = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where('loan.member_id', '=', $member->member_id)
      ->groupBy('loan_type.name')
      ->get();

    $totalloanbalance = 0;
    foreach ($outstandingloans as $loan) {
      $totalloanbalance += $loan->balance;
    }

    return view('admin.memberlist.member-details', array('member' => $member, 'recentcontributions' => $recentcontributions, 'recentloans' => $recentloans, 'contributions' => $contributions, 'totalcontributions' => $totalcontributions, 'outstandingloans' => $outstandingloans, 'totalloanbalance' => $totalloanbalance));
  }

  //update member status
  public function updateMemberStatus(Request $request)
  {
    $member_id  = $request->get('member_id');
    $status  = $request->get('status');

    $update_member_status = DB::table('member')
      ->where('member_no', $member_id)
      ->update([
        'membership_status' => $status,
      ]);

    if (!empty($update_member_status)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }

  //update member details
  public function updateMemberDetails(Request $request)
  {
    $member_no  = $request->get('member_no');
    $user_id  = $request->get('user_id');

    $update_member = DB::table('member')
      ->where('member_no', $member_no)
      ->update([
        'position_id' => $request->get('position_id'),
        'membership_date' => $request->get('membership_date'),
      ]);

    $update_member_details = DB::table('member_detail')
      ->where('member_no', $member_no)
      ->update([
        'landline' => $request->get('landline'),
        'gender' => $request->get('gender'),
        'employee_no' => $request->get('employee_no'),
        'appointment_status' => $request->get('appointment_status'),
        'permanent_address' => $request->get('permanent_address'),
        'current_address' => $request->get('current_address'),
        'tin' => $request->get('tin'),
        'birth_date' => $request->get('birth_date'),
        'monthly_salary' => $request->get('monthly_salary'),
      ]);


    $update_user_details = DB::table('users')
      ->where('id', $user_id)
      ->update([
        'first_name' => $request->get('first_name'),
        'middle_name' => $request->get('middle_name'),
        'last_name' => $request->get('last_name'),
        'contact_no' => $request->get('contact_no'),
        'email' => $request->get('email'),
      ]);
    if (!empty($update_member_details) || !empty($update_user_details) || !empty($$update_member)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }

  //update other member details
  public function updateMemberOtherDetails(Request $request)
  {
    $member_no  = $request->get('member_no');
    $update_other_member = DB::table('member_detail')
      ->where('member_no', $member_no)
      ->update([
        'contribution_type' => $request->get('contribution_type'),
        'contribution' =>  intval($request->get('contribution')),
        'with_cocolife_form' => intval($request->get('with_cocolife_form')),
      ]);

    if (!empty($update_other_member)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }

  //get old member beneficiaries
  public function getMemberBeneficiaries(Request $request)
  {
    if ($request->ajax()) {
      $member_no = $request->get('member_no');
      $data = OLDBeneficiaries::where('member_no', $member_no)->select('*');
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
          $btn = '<button  class="delete_btn btn btn-primary btn-sm delete"  id="delete_beneficiaries" value=' . $row->id . '>
          <i class="fa fa-trash-o" aria-hidden="true"></i>
          </button>';
          return $btn;
        })


        ->rawColumns(['action'])
        ->make(true);
    }
  }

  //add old beneficiaries
  public function addOldMemberBeneficiaries(Request $request)
  {

    $added_by = Auth::user()->id;

    $payload = array(
      'member_no' => $request->get('member_no'),
      'beni_name' => $request->get('beni_name'),
      'relationship' =>  $request->get('relationship'),
      'birth_date' => $request->get('birth_date'),
      'added_by' => $added_by,
    );
    $insertOldBeneficiaries = DB::table('old_beneficiaries')->insert($payload);

    if (!empty($insertOldBeneficiaries)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }

  //delete old beneficiaries
  public function deleteOldMemberBeneficiaries(Request $request)
  {
    $deleteOldBeneficiaries = DB::table('old_beneficiaries')->where('id', $request->get('beneficiary_id'))->delete();

    if (!empty($deleteOldBeneficiaries)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }

  //reset password
  public function resetPassword(Request $request)
  {
    $id =  $request->get('user_id');

    $tempass_length = 10;
    $tempass = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $tempass_length);
    $hashedpass = Hash::make($tempass);

    $password_reset =  DB::table('users')->where('id', $id)
      ->update(['password' => $hashedpass, 'password_set' => 0]);

    $member = DB::table('users')->select('*')
      ->where('id', '=', $id)
      ->first();
    // dd($member);

    if (!empty($password_reset)) {
      return response()->json([
        'success' => true,
        'password' => $tempass,
        'member' => $member,
      ]);
    } else {
      return response()->json(['success' => false]);
    }
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
    $data['payroll_no'] = "UPPFI" . rand(1000, 5000);
    return view('admin.members.payroll')->with($data);
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


  //delete candidate 
  public function delete_candidate(Request $request)
  {
    $candidate_id = request()->get('candidate_id');
    $delete = DB::table('candidates_tbl')->where('candidate_id', '=', $candidate_id)->delete();

    if ($delete) {
      return response()->json(['success' => true]);
    }
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

  //admin transaction backend
  public function transaction()
  {
    return view('admin.transaction.transaction');
  }

  public function loanPayments()
  {
    $campus_details = DB::table('old_campus')->get();
    $loan_types = DB::table('loan_type')->get();
    return view('admin.transaction.loan-payment', compact('campus_details', 'loan_types'));
  }


  public function loanPaymentsDetails($id, $id2)
  {
    $user_details = DB::table('member')->select('users.*', 'users.id as user_id', 'member.*')
      ->join('users', 'member.user_id', '=', 'users.id')
      ->where('users.id', $id)
      ->get()->first();

    $loan_id =   $id2;

    return view('admin.transaction.loan-payment-details', compact('user_details', 'loan_id'));
  }

  public function getLoanPaymentDetails(Request $request)
  {
    if ($request->ajax()) {
      // $data = Beneficiaries::select('*');
      $loan_id = $request->get('loan_id');
      $data  = LoanTransaction::select('loan_transaction.id as loans_id', 'member.*', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date order by date desc) as balance'))
        ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
        ->leftjoin('member', 'loan.member_id', 'member.id')
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.id', '=', $loan_id)
        ->Where('loan_transaction.amount', '<>', 0.00)
        ->orderBy('loan.type_id', 'ASC')
        ->orderBy('date', 'desc')->get();
      $date = "";
      $loan_data = [];
      foreach ($data as $loan) {
        $samedate = true;
        if ($date == date("m/d/Y", strtotime($loan->date))) {
          $samedate = false;
        } else {
          $samedate = true;
        }

        $date = date("m/d/Y", strtotime($loan->date));
        $amortization = $loan->amortization == 0 ? '' : 'PHP ' . number_format($loan->amortization, 2);
        $interest = $loan->interest == 0 ? '' : 'PHP ' . number_format($loan->interest, 2);
        $bal = !$samedate ? '' : 'PHP ' . number_format($loan->balance, 2);

        $nestedData['date'] =   date("m/d/Y", strtotime($loan->date));
        $nestedData['reference_no'] = $loan->reference_no;
        $nestedData['name'] =  $loan->name;
        $nestedData['amortization'] = $amortization;
        $nestedData['interest'] = $interest;
        $nestedData['amount'] = 'PHP ' . number_format($loan->amount, 2);
        $nestedData['balance'] = $bal;


        $loan_data[] = $nestedData;
      }

      return Datatables::of($loan_data)
        ->make(true);
    }
  }


  //solo generate
  public function generateloanspertype($id)
  {
    $loans = LoanTransaction::select('loan_transaction.id as id', 'member.*', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date order by date desc) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('member', 'loan.member_id', 'member.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where('loan.id', '=', $id)
      ->Where('loan_transaction.amount', '<>', 0.00)
      ->orderBy('loan.type_id', 'ASC')
      ->orderBy('date', 'desc')
      ->get();

    $member = User::where('users.id', $loans[0]->user_id)
      ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();

    $data['loans'] = $loans;
    $data['member'] = $member;



    $pdf = PDF::loadView('pdf.loans', $data);
    return $pdf->setPaper('a4', 'landscape')->stream('loan.pdf');
  }

  public function transactionAnalytics()
  {
    return view('admin.transaction.transaction-analytics');
  }



  //admin loan backend
  public function loanMatrix()
  {
    return view('admin.loan.loan-matrix');
  }

  public function loanApplication()
  {
    $campus_details = DB::table('old_campus')->get();
    return view('admin.loan.loan-application', compact('campus_details'));
  }

  //count election details 
  public function countLoans()
  {
    if (request()->has('view')) {
      $total_cancelled = DB::table('loan_applications')->where('status', 'CANCELLED')->count();
      $total_done = DB::table('loan_applications')->where('status', 'DONE')->count();
      $total_confirmed = DB::table('loan_applications')->where('status', 'CONFIRMED')->count();
      $total_processing = DB::table('loan_applications')->where('status', 'PROCESSING')->count();
    }

    $data = array(
      'total_cancelled' => $total_cancelled,
      'total_done' => $total_done,
      'total_processing' => $total_processing,
      'total_confirmed' => $total_confirmed,
    );

    echo json_encode($data);
  }

  public function getLoanApplications(Request $request)
  {
    $columns = [
      0 => 'loan_applications.id',
      1 => 'date_created',
      2 => 'member_no',
      3 => 'control_number',
      4 => 'full_name',
      5 => 'campus',
      6 => 'loan_type',
      7 => 'application_type',
      8 => 'status',
    ];
    $totalData = Loans::count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $searchValue =  $request->input('search.value');
    $campus = $request->input('campus_filter');
    $status_select = $request->input('status_filter');
    $application_type = $request->input('application_filter');
    $loan_type = $request->input('loan_filter');
    $date_applied_from  = $request->get('date_applied_from');
    $date_applied_to  = $request->get('date_applied_to');


    //filter codes
    if (!empty($searchValue)) {

      $loan_applicaton = DB::table('loan_applications')
        ->select(
          'users.*',
          'loan_applications.*',
          'loan_applications.id as loan_app_id',
          'member.*',
          'old_campus.*',
          'old_campus.name as campus_name',
          'loan_type.name as loan_type_name',
          'loan_applications_peb.*',
          'loan_applications_peb.type as loan_application_type'
        )
        ->where('loan_type.name', 'like', "%{$searchValue}%")
        ->orWhere('loan_applications.member_no', 'like', "%{$searchValue}%")
        ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
        ->join('users', 'member.user_id', '=', 'users.id')
        ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
        ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
        ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
        ->orderBy('loan_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    } else {
      $loan_applicaton = DB::table('loan_applications')
        ->select(
          'users.*',
          'loan_applications.*',
          'loan_applications.id as loan_app_id',
          'member.*',
          'old_campus.*',
          'old_campus.name as campus_name',
          'loan_type.name as loan_type_name',
          'loan_applications_peb.*',
          'loan_applications_peb.type as loan_application_type'
        )
        ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
        ->join('users', 'member.user_id', '=', 'users.id')
        ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
        ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
        ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
        ->orderBy('loan_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($status_select)) {
      $loan_applicaton = DB::table('loan_applications')
        ->select(
          'users.*',
          'loan_applications.*',
          'loan_applications.id as loan_app_id',
          'member.*',
          'old_campus.*',
          'old_campus.name as campus_name',
          'loan_type.name as loan_type_name',
          'loan_applications_peb.*',
          'loan_applications_peb.type as loan_application_type'
        )
        ->where('loan_applications.status', '=', $status_select)
        ->orWhere('member.campus_id', '=', $campus)

        ->orWhere('loan_applications_peb.type', '=', $application_type)
        ->orWhere('loan_type.name', '=', $loan_type)

        ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
        ->join('users', 'member.user_id', '=', 'users.id')
        ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
        ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
        ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
        ->orderBy('loan_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    //campus
    if (!empty($campus)) {
      $loan_applicaton = DB::table('loan_applications')
        ->select(
          'users.*',
          'loan_applications.*',
          'loan_applications.id as loan_app_id',
          'member.*',
          'old_campus.*',
          'old_campus.name as campus_name',
          'loan_type.name as loan_type_name',
          'loan_applications_peb.*',
          'loan_applications_peb.type as loan_application_type'
        )
        ->where('member.campus_id', '=', $campus)
        ->orWhere('loan_applications.status', '=', $status_select)
        ->orWhere('loan_applications_peb.type', '=', $application_type)
        ->orWhere('loan_type.name', '=', $loan_type)

        ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
        ->join('users', 'member.user_id', '=', 'users.id')
        ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
        ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
        ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
        ->orderBy('loan_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($application_type)) {
      $loan_applicaton = DB::table('loan_applications')
        ->select(
          'users.*',
          'loan_applications.*',
          'loan_applications.id as loan_app_id',
          'member.*',
          'old_campus.*',
          'old_campus.name as campus_name',
          'loan_type.name as loan_type_name',
          'loan_applications_peb.*',
          'loan_applications_peb.type as loan_application_type'
        )
        ->where('loan_applications_peb.type', '=', $application_type)
        ->orWhere('member.campus_id', '=', $campus)
        ->orWhere('loan_applications.status', '=', $status_select)
        ->orWhere('loan_type.name', '=', $loan_type)

        ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
        ->join('users', 'member.user_id', '=', 'users.id')
        ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
        ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
        ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
        ->orderBy('loan_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($loan_type)) {
      $loan_applicaton = DB::table('loan_applications')
        ->select(
          'users.*',
          'loan_applications.*',
          'loan_applications.id as loan_app_id',
          'member.*',
          'old_campus.*',
          'old_campus.name as campus_name',
          'loan_type.name as loan_type_name',
          'loan_applications_peb.*',
          'loan_applications_peb.type as loan_application_type'
        )
        ->where('loan_type.name', '=', $loan_type)
        ->orWhere('member.campus_id', '=', $campus)
        ->orWhere('loan_applications.status', '=', $status_select)
        ->orWhere('loan_applications_peb.type', '=', $application_type)

        ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
        ->join('users', 'member.user_id', '=', 'users.id')
        ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
        ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
        ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
        ->orderBy('loan_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($date_applied_from) && !empty($date_applied_to)) {
      $loan_applicaton = DB::table('loan_applications')
        ->select(
          'users.*',
          'loan_applications.*',
          'loan_applications.id as loan_app_id',
          'member.*',
          'old_campus.*',
          'old_campus.name as campus_name',
          'loan_type.name as loan_type_name',
          'loan_applications_peb.*',
          'loan_applications_peb.type as loan_application_type'
        )
        ->orWhere('member.campus_id', '=', $campus)
        ->orWhere('loan_applications.status', '=', $status_select)
        ->orWhere('loan_applications_peb.type', '=', $application_type)
        ->orWhere('loan_type.name', '=', $loan_type)
        ->where('loan_applications.date_created', '>=',  $date_applied_from)
        ->orWhere('loan_applications.date_created', '<=',  $date_applied_to)
        ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
        ->join('users', 'member.user_id', '=', 'users.id')
        ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
        ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
        ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
        // ->orderBy($order, $dir)
        ->orderBy('loan_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }



    $totalFiltered = Loans::when($searchValue, function ($query) use ($searchValue) {
      $query->where('id', 'like', "%{$searchValue}%")->orWhere('status', 'like', "%{$searchValue}%");
    })
      ->count();

    $data = [];
    foreach ($loan_applicaton as $row) {
      $nestedData['date_created'] = $row->date_created;
      $nestedData['member_no'] = $row->member_no;
      $nestedData['control_number'] = $row->control_number;
      $nestedData['full_name'] = $row->last_name . "," . $row->first_name . " " . $row->middle_name;
      $nestedData['campus'] = $row->campus_name;
      $nestedData['loan_type'] = $row->loan_type_name;
      $nestedData['application_type'] = $row->loan_application_type;
      $nestedData['status'] = $row->status;
      $nestedData['action'] = '
      <a href="/admin/loan/loan-application/details/' . $row->loan_app_id .  '" target="_blank" data-md-tooltip="View Loan Details" class="view_member md-tooltip--top view-member" style="cursor: pointer">
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


  public function loanApplicationDetails($id)
  {
    $check_loan_application = DB::table('loan_applications')
      ->select(
        'users.*',
        'loan_applications.*',
        'member.*',
        'old_campus.*',
        'old_campus.name as campus_name',
        'loan_type.name as loan_type_name',
        'loan_applications_peb.*',
        'loan_applications_peb.p_id as valid_id',
        // 'loan_applications_peb.*',
        // 'loan_applications_peb.*',
        'loan_applications_peb.type as loan_application_type',
        'users.email as user_email'
      )
      ->where('loan_applications.id', '=', $id)

      ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
      ->join('users', 'member.user_id', '=', 'users.id')
      ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
      ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
      ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
      ->first();

    if ($check_loan_application->status == 'NEW APPLICATION') {
      $loan_application_status = DB::table('loan_applications')
        ->where('id', $id)
        ->update([
          'status' => "PROCESSING",
        ]);
    }
    $loan_application = DB::table('loan_applications')
      ->select(
        'users.*',
        'loan_applications.*',
        'member.*',
        'old_campus.*',
        'old_campus.name as campus_name',
        'loan_type.name as loan_type_name',
        'loan_applications_peb.*',
        'loan_applications_peb.p_id as valid_id',
        // 'loan_applications_peb.*',
        // 'loan_applications_peb.*',
        'loan_applications_peb.type as loan_application_type',
        'users.email as user_email'
      )
      ->where('loan_applications.id', '=', $id)

      ->join('member', 'member.member_no', '=', 'loan_applications.member_no')
      ->join('users', 'member.user_id', '=', 'users.id')
      ->join('old_campus', 'member.campus_id', '=', 'old_campus.id')
      ->join('loan_type', 'loan_applications.loan_type', '=', 'loan_type.id')
      ->join('loan_applications_peb', 'loan_applications.id', '=', 'loan_applications_peb.loan_app_id')
      ->first();
    // $campus_details = DB::table('old_campus')->get();
    if (!empty($loan_application)) {
      return view('admin.loan.loan-attachment', compact('loan_application'));
    } else {
      return redirect('/admin/loan/loan-application/');
    }
  }

  //admin view loan codes
  public function admin_view_loan($id)
  {
    if (Auth::check()) {
      $loan_app_id = $id;
      $check_loan_details = DB::table('loan_applications')
        ->select("loan_applications.*", "loan_applications_peb.*", "loan_applications.id as loan_app_id", "loan_applications_peb.id as loan_peb_id", "loan_applications.control_number as control_number")
        ->join("loan_applications_peb", "loan_applications_peb.loan_app_id", "=", "loan_applications.id")
        ->where('loan_applications.id', $loan_app_id)
        ->get()
        ->first();

      if ($check_loan_details->status == 'NEW APPLICATION') {
        $loan_application_status = DB::table('loan_applications')
          ->where('id', $id)
          ->update([
            'status' => "PROCESSING",
          ]);
      }

      $loan_details = DB::table('loan_applications')
        ->select("loan_applications.*", "loan_applications_peb.*", "loan_applications.id as loan_app_id", "loan_applications_peb.id as loan_peb_id", "loan_applications.control_number as control_number")
        ->join("loan_applications_peb", "loan_applications_peb.loan_app_id", "=", "loan_applications.id")
        ->where('loan_applications.id', $loan_app_id)
        ->get()
        ->first();


      $member = User::where('member.member_no', $loan_details->member_no)
        ->select('*', 'member.id as member_id', 'member_detail.*', 'users.id as user_id', 'old_campus.name as campus_name')
        ->leftjoin('member', 'users.id', '=', 'member.user_id')
        ->leftjoin('member_detail', 'member_detail.member_no', '=', 'member.member_no')
        ->leftjoin('old_campus', 'member.campus_id', '=', 'old_campus.id')
        ->first();


      $outstandingloans = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
        ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.member_id', '=', $member->member_id)
        ->groupBy('loan_type.name')
        ->get();

      $totalloanbalance = 0;
      foreach ($outstandingloans as $loan) {
        $totalloanbalance += $loan->balance;
      }
      $membercontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
        ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
        ->where('contribution_transaction.account_id', '=', 2)
        ->where('contribution.member_id', '=', $member->member_id)
        ->first();
      $contributions['membercontribution'] = $membercontribution->total;


      $upcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
        ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
        ->where('contribution_transaction.account_id', '=', 1)
        ->where('contribution.member_id', '=', $member->member_id)
        ->first();
      $contributions['upcontribution'] = $upcontribution->total;


      $eupcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
        ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
        ->where('contribution_transaction.account_id', '=', 3)
        ->where('contribution.member_id', '=', $member->member_id)
        ->first();
      $contributions['eupcontribution'] = $eupcontribution->total;


      $emcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
        ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
        ->where('contribution_transaction.account_id', '=', 4)
        ->where('contribution.member_id', '=', $member->member_id)
        ->first();
      $contributions['emcontribution'] = $emcontribution->total;


      $totalcontributions = array_sum($contributions);

      $campuses = DB::table('campus')->get();
      $department = DB::table('department')->where('campus_id', $member->campus_id)->get();
      $membership = DB::table('mem_app')->where('employee_no', $member->employee_no)->get();
      $beneficiaries = DB::table('old_beneficiaries')->where('member_no', $member->member_no)->get();


      $years = OLDMembers::select(DB::raw("YEAR(original_appointment_date) - YEAR(CURDATE()) - (DATE_FORMAT(original_appointment_date,'%m%d') < DATE_FORMAT(CURDATE(),'%m%d')) as years"))
        ->where('user_Id', '=', $member->user_id)->get();

      $draft_details = DB::table('loan_applications')
        ->select("loan_applications.*", "loan_applications_peb.*", "loan_applications.id as loan_app_id", "loan_applications_peb.id as loan_peb_id", "loan_applications.control_number as control_number")
        ->join("loan_applications_peb", "loan_applications_peb.loan_app_id", "=", "loan_applications.id")
        ->where('loan_applications.id', $id)
        ->get()
        ->first();

      $data = array(

        'member' => $member,
        'campuses' => $campuses,
        'department' => $department,
        'membership' => $membership,
        'beneficiaries' => $beneficiaries,
        'loan_details' => $loan_details,
        'outstandingloans' => $outstandingloans,
        'totalloanbalance' => $totalloanbalance,
        'totalcontributions' => $totalcontributions,
        'years' => abs($years[0]->years),
        'loan_application_details' => $draft_details


      );
      return view('admin.loan.loan-application-details')->with($data);;
    } else {
      return redirect('/login');
    }
  }

  public function cancelLoanApplication(Request $request)
  {
    $loan_app_id  = $request->get('loan_app_id');
    $cancellation_remarks  = $request->get('cancellation_remarks');

    $cancel_loan = DB::table('loan_applications')
      ->where('id', $loan_app_id)
      ->update([
        'cancellation_reason' => $cancellation_remarks,
        'status' => 'CANCELLED',
      ]);

    if (!empty($cancel_loan)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }


  public function saveLoanApplication(Request $request)
  {
    $loan_app_id  = $request->get('loan_app_id');
    $net_proceeds = $request->get('net_proceeds');
    $approved_amount = $request->get('approved_amount');
    $monthly_amort = $request->get('monthly_amort');
    $year_terms = $request->get('year_terms');
    $active_email = $request->get('active_email');
    $active_number = $request->get('active_number');
    $collect_from = $request->get('collect_from');
    $status = $request->get('status');


    //add year based on collect from
    $calculate_date = Carbon::parse('2020-10-17 03:05:03');
    $collect_to = $calculate_date->addYear(intval($year_terms));

    $save_loan = DB::table('loan_applications')
      ->where('id', $loan_app_id)
      ->update([
        'net_proceeds' => $net_proceeds,
        'approved_amount' => $approved_amount,
        'monthly_amort' => $monthly_amort,
        'year_terms' => $year_terms,
        'active_email' => $active_email,
        'active_number' => $active_number,
        'approved_amount' => $approved_amount,
        'collect_from' => $collect_from,
        'collect_to' => $collect_to,
        'status' => $status,

      ]);

    if (!empty($save_loan)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }


  public function getLoanTransactions(Request $request)
  {
    $columns = [
      0 => 'id',
      1 => 'loan.id',
      2 => 'loan.id',
      3 => 'loan.id',
      4 => 'loan.id',
      5 => 'loan.id',
      6 => 'loan.id',
      7 => 'loan.id',
      8 => 'loan.id',
    ];
    $totalData = LoanTransaction::groupBy('loan_id')->pluck('loan_id')->count();
    $totalFiltered = LoanTransaction::groupBy('loan_id')->pluck('loan_id')->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $searchValue =  $request->input('search.value');

    $campus = $request->input('campuses_select');
    $amortization_date = $request->input('amortization_date');
    $loan_select = $request->input('loan_select');
    $transaction_date_from = $request->input('transaction_date_from');
    $transaction_date_to  = $request->get('transaction_date_to');



    //filter codes
    if (!empty($searchValue)) {

      $loan_transactions   = LoanTransaction::select(
        'loan.id as id',
        'loan_type.name as type',
        'member.member_no as memberNo',
        'users.first_name as firstname',
        'users.middle_name as middlename',
        'users.last_name as lastname',
        DB::raw('MAX(date) as lastTransactionDate'),
        DB::raw('SUM(amount) AS balance'),
        DB::raw('MAX(start_amort_date) AS startAmortDate'),
        DB::raw('MAX(end_amort_date) AS endAmortDate')
      )
        ->leftjoin('loan', 'loan_transaction.loan_id', '=', 'loan.id')
        ->leftjoin('loan_type', 'loan.type_id', '=', 'loan_type.id')
        ->leftjoin('member', 'loan.member_id', '=', 'member.id')
        ->leftjoin('users', 'member.user_id', '=', 'users.id')
        ->where('loan.member_id', 'like', "%{$searchValue}%")
        ->orWhere('users.first_name', 'like', "%{$searchValue}%")
        ->orWhere('users.middle_name', 'like', "%{$searchValue}%")
        ->orWhere('users.last_name', 'like', "%{$searchValue}%")
        ->groupBy('loan.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    } else {

      $loan_transactions   = LoanTransaction::select(
        'loan.id as id',
        'loan_type.name as type',
        'member.member_no as memberNo',
        'users.id as  user_id',
        'users.first_name as firstname',
        'users.middle_name as middlename',
        'users.last_name as lastname',
        DB::raw('MAX(date) as lastTransactionDate'),
        DB::raw('SUM(amount) AS balance'),
        DB::raw('MAX(start_amort_date) AS startAmortDate'),
        DB::raw('MAX(end_amort_date) AS endAmortDate')
      )
        ->leftjoin('loan', 'loan_transaction.loan_id', '=', 'loan.id')
        ->leftjoin('loan_type', 'loan.type_id', '=', 'loan_type.id')
        ->leftjoin('member', 'loan.member_id', '=', 'member.id')
        ->leftjoin('users', 'member.user_id', '=', 'users.id')
        ->groupBy('loan.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }


    if (!empty($campus)) {
      $loan_transactions   = LoanTransaction::select(
        'loan.id as id',
        'loan_type.name as type',
        'member.member_no as memberNo',
        'users.id as  user_id',
        'users.first_name as firstname',
        'users.middle_name as middlename',
        'users.last_name as lastname',
        'member.campus_id',
        DB::raw('MAX(date) as lastTransactionDate'),
        DB::raw('SUM(amount) AS balance'),
        DB::raw('MAX(start_amort_date) AS startAmortDate'),
        DB::raw('MAX(end_amort_date) AS endAmortDate')
      )
        ->leftjoin('loan', 'loan_transaction.loan_id', '=', 'loan.id')
        ->leftjoin('loan_type', 'loan.type_id', '=', 'loan_type.id')
        ->leftjoin('member', 'loan.member_id', '=', 'member.id')
        ->leftjoin('users', 'member.user_id', '=', 'users.id')
        ->where('member.campus_id', '=', $campus)
        ->groupBy('loan.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }

    if (!empty($loan_select)) {
      $loan_transactions   = LoanTransaction::select(
        'loan.id as id',
        'loan_type.name as type',
        'member.member_no as memberNo',
        'users.id as  user_id',
        'users.first_name as firstname',
        'users.middle_name as middlename',
        'users.last_name as lastname',
        'member.campus_id',
        DB::raw('MAX(date) as lastTransactionDate'),
        DB::raw('SUM(amount) AS balance'),
        DB::raw('MAX(start_amort_date) AS startAmortDate'),
        DB::raw('MAX(end_amort_date) AS endAmortDate')
      )
        ->leftjoin('loan', 'loan_transaction.loan_id', '=', 'loan.id')
        ->leftjoin('loan_type', 'loan.type_id', '=', 'loan_type.id')
        ->leftjoin('member', 'loan.member_id', '=', 'member.id')
        ->leftjoin('users', 'member.user_id', '=', 'users.id')
        ->where('loan.type_id', '=', $loan_select)
        ->groupBy('loan.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($transaction_date_from) && !empty($transaction_date_to)) {
      $loan_transactions   = LoanTransaction::select(
        'loan.id as id',
        'loan_type.name as type',
        'member.member_no as memberNo',
        'users.id as  user_id',
        'users.first_name as firstname',
        'users.middle_name as middlename',
        'users.last_name as lastname',
        'member.campus_id',
        DB::raw('MAX(date) as lastTransactionDate'),
        DB::raw('SUM(amount) AS balance'),
        DB::raw('MAX(start_amort_date) AS startAmortDate'),
        DB::raw('MAX(end_amort_date) AS endAmortDate')
      )
        ->leftjoin('loan', 'loan_transaction.loan_id', '=', 'loan.id')
        ->leftjoin('loan_type', 'loan.type_id', '=', 'loan_type.id')
        ->leftjoin('member', 'loan.member_id', '=', 'member.id')
        ->leftjoin('users', 'member.user_id', '=', 'users.id')
        ->where('date', '>=', $transaction_date_from)
        ->where('date', '<=', $transaction_date_to)
        ->groupBy('loan.id')
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }


    $data = [];
    foreach ($loan_transactions as $row) {
      $nestedData['type'] = $row->type;
      $nestedData['memberNo'] = $row->memberNo;
      $nestedData['full_name'] = $row->lastname . ', ' . $row->firstname . ' ' . $row->middlename;

      $nestedData['lastTransactionDate'] =  $row->lastTransactionDate == null ? '' : date('m/d/Y', strtotime($row->lastTransactionDate));
      $nestedData['balance'] = 'PHP ' . number_format($row->balance, 2);
      $nestedData['loan_type'] = $row->loan_type_name;
      $nestedData['startAmortDate'] = $row->startAmortDate == null ? '' : date('m/d/Y', strtotime($row->startAmortDate));
      $nestedData['endAmortDate'] = $row->endAmortDate == null ? '' : date('m/d/Y', strtotime($row->endAmortDate));

      $nestedData['action'] = '
      <a href="/admin/transaction/loan-payment-details/' . $row->user_id .  '/' . $row->id .  '" target="_blank" data-md-tooltip="View Loan Details" class="view_member md-tooltip--top view-member" style="cursor: pointer">
                 <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
               </a>
          
         ';
      $nestedData['checkbox'] = ' <span style="display: flex; justify-content: center;" > 
                                    <input   type="checkbox" name="check[]" value="/admin/generate/loanspertype/'  . $row->id .  '" class="select_item" id="select_item">
                                 </span>
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


  public function generatesoa($id)
  {
    $member = User::where('users.id', $id)
      ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();

    $contributions = array();

    $membercontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 2)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['membercontribution'] = $membercontribution->total;


    $upcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 1)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['upcontribution'] = $upcontribution->total;


    $eupcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 3)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['eupcontribution'] = $eupcontribution->total;


    $emcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 4)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['emcontribution'] = $emcontribution->total;


    $totalcontributions = array_sum($contributions);



    $outstandingloans = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where('loan.member_id', '=', $member->member_id)
      ->groupBy('loan_type.name')
      ->get();

    $totalloanbalance = 0;
    foreach ($outstandingloans as $loan) {
      $totalloanbalance += $loan->balance;
    }

    $data['totalloanbalance'] = $totalloanbalance;
    $data['outstandingloans'] = $outstandingloans;
    $data['totalcontributions'] = $totalcontributions;
    $data['emcontribution'] = $emcontribution->total;
    $data['eupcontribution'] = $eupcontribution->total;
    $data['upcontribution'] = $upcontribution->total;
    $data['membercontribution'] = $membercontribution->total;
    $data['member'] = $member;

    $fullname = $member->last_name . ' , ' . $member->first_name . $member->middle_name;
    $pdf = PDF::loadView('pdf.soa', $data);
    return $pdf->stream('' . $fullname .  '-soa.pdf');
  }

  //member ledger pdf 
  public function member_ledger($id)
  {
    $member = User::where('users.id', $id)
      ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();

    $recentcontributions = ContributionTransaction::select('*')
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->leftjoin('contribution_account', 'contribution_transaction.account_id', 'contribution_account.id')
      ->where('contribution.member_id', '=', $member->member_id)
      ->Where('contribution_transaction.amount', '<>', 0.00)
      ->orderBy('contribution.date', 'desc')
      ->orderBy('contribution.reference_no', 'desc')
      // ->limit(3)
      ->get();

    $contributions = array();

    $membercontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 2)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['membercontribution'] = $membercontribution->total;


    $upcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 1)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['upcontribution'] = $upcontribution->total;


    $eupcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 3)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['eupcontribution'] = $eupcontribution->total;


    $emcontribution = ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->where('contribution_transaction.account_id', '=', 4)
      ->where('contribution.member_id', '=', $member->member_id)
      ->first();
    $contributions['emcontribution'] = $emcontribution->total;


    $totalcontributions = array_sum($contributions);



    $recentloans = LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date order by date desc) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('member', 'loan.member_id', 'member.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where(
        'loan.member_id',
        '=',
        $member->member_id
      )
      ->Where('loan_transaction.amount', '<>', 0.00)
      ->orderBy('date', 'desc')
      // ->limit(3)
      ->get();


    $outstandingloans = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where(
        'loan.member_id',
        '=',
        $member->member_id
      )
      ->groupBy('loan_type.name')
      ->get();

    $totalloanbalance = 0;
    foreach ($outstandingloans as $loan) {
      $totalloanbalance += $loan->balance;
    }


    $data['member'] = $member;
    $data['recentcontributions'] = $recentcontributions;
    $data['recentloans'] = $recentloans;
    $data['contributions'] = $contributions;
    $data['totalcontributions'] = $totalcontributions;
    $data['outstandingloans'] = $outstandingloans;
    $data['totalloanbalance'] = $totalloanbalance;
    $data['membercontribution'] = $membercontribution->total;
    $data['emcontribution'] = $emcontribution->total;
    $data['eupcontribution'] = $eupcontribution->total;
    $data['upcontribution'] = $upcontribution->total;
    $fullname = $member->last_name . ' , ' . $member->first_name . $member->middle_name;


    $pdf = PDF::loadView('pdf.ledger', $data);
    return $pdf->stream('' . $fullname .  '-ledger.pdf');
  }

  public function loanAnalytics()
  {
    return view('admin.loan.loan-analytics');
  }

  //benifit backend
  public function benefitMatrix()
  {
    return view('admin.benefit.benefit-matrix');
  }

  public function benefitList()
  {
    return view('admin.benefit.benefit-list');
  }

  public function benefitAnalytics()
  {
    return view('admin.benefit.benefit-analytics');
  }

  public function benefitView()
  {
    $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'member_detail.*', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('member_detail', 'member_detail.member_no', '=', 'member.member_no')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')

      ->first();
    $campuses = DB::table('campus')->get();
    $department = DB::table('department')->where('campus_id', $member->campus_id)->get();
    $membership = DB::table('mem_app')->where('employee_no', $member->employee_no)->get();
    $beneficiaries = DB::table('old_beneficiaries')->where('member_no', $member->member_no)->get();;
    $data = array(
      'member' => $member,
      'campuses' => $campuses,
      'department' => $department,
      'membership' => $membership,
      'beneficiaries' => $beneficiaries,
      // 'user_privileges' => DB::table('users')
      // ->join('user_prev', 'users.id', '=', 'user_prev.users_id')
      // ->where('users.id', $user->id)
      // ->get()
    );
    return view('admin.benefit.benefit-view')->with($data);
  }
}
