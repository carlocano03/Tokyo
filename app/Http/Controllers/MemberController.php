<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\LoanTransaction;
use App\Models\MemApp;

use Hash;

use PDF;
use Excel;
use DataTables;
use App\Models\Election;
use App\Models\Loans;
use App\Models\OLDMembers;
use App\Models\OLDBeneficiaries;

use App\Models\ContributionTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\processMail;
use GrahamCampbell\ResultType\Success;
use Mockery\Undefined;

class MemberController extends Controller
{

  // public function __construct()
  // {
  //   $this->middleware('auth');
  // }
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
        'login' => $lastLogin,
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
      return view('member.dashboard')->with($data);
    } else {
      return redirect('/login');
    }
  }

  public function settings()
  {
    if (Auth::check()) {
      return view('member.settings');
    } else {
      return redirect('/login');
    }
  }

  public function transaction()
  {
    if (Auth::check()) {
      return view('member.transaction');
    } else {
      return redirect('/login');
    }
  }
  public function loan()
  {
    if (Auth::check()) {
      return view('member.loan_application.index');
    } else {
      return redirect('/login');
    }
  }

  public function new_loan()
  {
    if (Auth::check()) {
      return view('member.loan_application.new_loan');
    } else {
      return redirect('/login');
    }
  }

  public function member()
  {
    if (Auth::check()) {
      return view('member.member');
    } else {
      return redirect('/login');
    }
  }

  public function equity()
  {
    if (Auth::check()) {
      return view('member.equity');
    } else {
      return redirect('/login');
    }
  }

  public function updatepassword()
  {
    if (Auth::check()) {
      return view('member.updatepassword');
    } else {
      return redirect('/login');
    }
  }

  public function application()
  {
    if (Auth::check()) {
      //logged in
      $user_id = Auth::user()->id;
      $member_details = DB::table('member')
        ->where('member.user_id', '=',  $user_id)
        ->join('old_campus', "old_campus.id", "=", "member.campus_id")
        ->join("users", "member.user_id", "=", "users.id")
        ->select('member.*', 'users.*', 'old_campus.name as campus_name')
        ->get()->first();

      //1 PEL, 2 BL, 3 EML, 4 CBL, 5 BTL

      //pel
      $pelBalance = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
        ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.member_id', '=', $member_details->member_no)
        ->where('loan.type_id', '=', 1)
        ->groupBy('loan_type.name')
        ->get();

      $totalPelBalance = 0;
      foreach ($pelBalance as $loan) {
        $totalPelBalance += $loan->balance;
      }

      //BL
      $blBalance = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
        ->leftjoin(
          'loan',
          'loan_transaction.loan_id',
          'loan.id'
        )
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.member_id', '=', $member_details->member_no)
        ->where('loan.type_id', '=', 2)
        ->groupBy('loan_type.name')
        ->get();

      $totalBlBalance = 0;
      foreach ($blBalance as $loan) {
        $totalBlBalance += $loan->balance;
      }



      //EML
      $EMLBalance = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
        ->leftjoin(
          'loan',
          'loan_transaction.loan_id',
          'loan.id'
        )
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.member_id', '=', $member_details->member_no)
        ->where('loan.type_id', '=', 3)
        ->groupBy('loan_type.name')
        ->get();

      $totalEMLBalance = 0;
      foreach ($EMLBalance as $loan) {
        $totalEMLBalance += $loan->balance;
      }

      //CBL
      $CBLBalance = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
        ->leftjoin(
          'loan',
          'loan_transaction.loan_id',
          'loan.id'
        )
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.member_id', '=', $member_details->member_no)
        ->where('loan.type_id', '=', 4)
        ->groupBy('loan_type.name')
        ->get();

      $totalCBLBalance = 0;
      foreach ($CBLBalance as $loan) {
        $totalCBLBalance += $loan->balance;
      }

      // BTL
      $BTLBalance = LoanTransaction::select('loan_type.name as type', DB::raw('SUM(amount) as balance'))
        ->leftjoin(
          'loan',
          'loan_transaction.loan_id',
          'loan.id'
        )
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.member_id', '=', $member_details->member_no)
        ->where('loan.type_id', '=', 5)
        ->groupBy('loan_type.name')
        ->get();

      $totalBTLBalance = 0;
      foreach ($BTLBalance as $loan) {
        $totalBTLBalance += $loan->balance;
      }

      $loan_details = DB::table('candidates_tbl')
        ->where('candidates_tbl.election_id', '=',  $user_id)
        ->where('candidates_tbl.sg_category', '=',  '16-33')
        ->join("personal_details", "candidates_tbl.personal_id", "=", "personal_details.personal_id")
        ->join("campus", "candidates_tbl.campus_id", "=", "campus.id")
        ->join("membership_id", "candidates_tbl.membership_id", "=", "membership_id.mem_id")
        ->join("employee_details", "membership_id.employee_no", "=", "employee_details.employee_no")
        ->select('candidates_tbl.*', 'personal_details.*', 'campus.name as campus_name', 'membership_id.*', 'employee_details.*')
        ->get();


      return view('member.loan_application.calculator', compact(
        'member_details',
        'loan_details',
        'totalPelBalance',
        'totalBlBalance',
        'totalEMLBalance',
        'totalCBLBalance',
        'totalBTLBalance',


      ));
    } else {
      return redirect('/login');
    }
  }

  public function add_new_pel_loan(Request $request)
  {
    $current_year = date('Y');
    $control = DB::table('loan_app_series')->where('loan_type', 1)->first();
    if ($control->year == $current_year) {
      $current_counter = $control->current_counter + 1;
      $counter_digits = str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
      $control_number = $control->loan_type_code . '-' . $control->year . '-' . date('m') . '-' . $counter_digits;
      DB::table('loan_app_series')
        ->where('loan_type', 1)
        ->update(['current_last' => $control_number, 'current_counter' => $current_counter]);
    } else {
      $year = $current_year;
      $current_counter = 0 + 1;
      $counter_digits = str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
      $control_number = $control->loan_type_code . '-' . $year . '-' . date('m') . '-' . $counter_digits;
      DB::table('loan_app_series')
        ->where('loan_type', 1)
        ->update(['year' => $year, 'current_last' => $control_number, 'current_counter' => $current_counter]);
    }


    $loanapp_id = DB::table('loan_applications')->insertGetId(
      [
        'member_no' => $request->input('member_no'),
        'loan_type' => 1,
        'control_number' => $control_number,
        'active_email' => $request->input('active_email'),
        'active_number' => $request->input('active_number'),
        'status' => 'PROCESSING'
      ]
    );

    $loandet_id = DB::table('loan_applications_peb')->insertGetId(
      [
        // 'bank' => $request->bank,
        'bank' => 'Union Bank',
        'loan_app_id' => $loanapp_id,
        'account_number' => $request->account_number,
        'account_name' => $request->account_name,
        'type' => 'NEW',
        'amount' => $request->loan_amount
      ]
    );
  }

  public function schedule()
  {
    if (Auth::check()) {
      return view('member.loan_application.schedule');
    } else {
      return redirect('/login');
    }
  }

  public function submission()
  {
    if (Auth::check()) { //logged in


      return view('member.loan_application.submission');
    } else {
      return redirect('/login');
    }
  }

  public function view()
  {
    if (Auth::check()) {
      return view('member.loan_application.view');
    } else {
      return redirect('/login');
    }
  }

  public function changePassword(Request $request)
  {
    $this->validate($request, [
      'current_password' => 'required',
      'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
      return response()->json(['message' => 'Current password is incorrect'], 401);
    }
    $hashedPassword = Hash::make($request->new_password);

    DB::table('users')->where('id', $user->id)->update(['password' => $hashedPassword]);

    return response()->json(['message' => 'Password changed successfully']);
  }

  //add old beneficiaries
  public function addMemberBeneficiaries(Request $request)
  {

    $added_by = Auth::user()->id;

    $member = DB::table('member')->where('user_id', Auth::user()->id)->get();

    $payload = array(
      'member_no' => $member[0]->member_no,
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
}
