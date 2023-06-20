<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\LoanTransaction;
use App\Models\MemApp;

use Hash;

use Illuminate\Support\Traits\Tappable;

use PDF;
use Excel;
use DataTables;
use App\Models\Election;
use App\Models\LoanApplications;
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
      $member = User::where('users.id', Auth::user()->id)
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


      $campuses = DB::table('campus')->get();
      $department = DB::table('department')->where('campus_id', $member->campus_id)->get();
      $membership = DB::table('mem_app')->where('employee_no', $member->employee_no)->get();
      $beneficiaries = DB::table('old_beneficiaries')->where('member_no', $member->member_no)->get();

      $total_confirmed = DB::table('loan_applications')->where('status', 'CONFIRMED')->where('member_no', $member->member_no)->count();
      $total_processing = DB::table('loan_applications')->where('status', 'PROCESSING')->where('member_no', $member->member_no)->count();

      $total_for_review = DB::table('loan_applications')->where('status', 'DRAFT')->where('member_no', $member->member_no)->count();
      $total_approved = DB::table('loan_applications')->where('status', 'APPROVED')->where('member_no', $member->member_no)->count();
      $total_rejected = DB::table('loan_applications')->where('status', 'CANCELLED')->where('member_no', $member->member_no)->count();

      $data = array(
        'login' => $lastLogin,
        'member' => $member,
        'campuses' => $campuses,
        'department' => $department,
        'membership' => $membership,
        'beneficiaries' => $beneficiaries,
        'recentcontributions' => $recentcontributions,
        'recentloans' => $recentloans,
        'contributions' => $contributions,
        'totalcontributions' => $totalcontributions,
        'outstandingloans' => $outstandingloans,
        'totalloanbalance' => $totalloanbalance,

        'total_processing' => $total_processing,
        'total_confirmed' => $total_confirmed,
        'total_for_review' => $total_for_review,
        'total_approved' => $total_approved,
        'total_rejected' => $total_rejected,
      );

      return view('member.dashboard')->with($data);
    } else {
      return redirect('/login');
    }
  }


  //member generate soa 

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

  //get member loans table 
  public function getMemberLoans(Request $request)
  {

    $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'member_detail.*', 'users.id as user_id', 'campus.name as campus_name', 'member.member_no as member_no')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('member_detail', 'member_detail.member_no', '=', 'member.member_no')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();


    $columns = [
      0 => 'loan_applications.id',
      1 => 'loan_applications.date_created',
      2 => 'loan_applications.control_number',
      3 => 'loan_applications.loan_type',
      4 => 'loan_applications.status',
      5 => 'loan_applications.cancellation_reason',
      6 => 'loan_applications.approved_amount',
      7 => 'loan_applications.monthly_amort',
    ];
    $totalData = DB::table('loan_applications')->where('member_no', '=', $member->member_no)->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $searchValue =  $request->input('search.value');

    $loan_type_filter  = $request->get('loan_type_filter');
    $loan_status_filter  = $request->get('loan_status_filter');

    $appointment_date_to  = $request->get('appointment_date_to');
    $appointment_date_from  = $request->get('appointment_date_from');


    //filter codes
    if (!empty($searchValue)) {
      $loans = DB::table('loan_applications')
        ->join('loan_applications_peb', 'loan_applications_peb.loan_app_id', '=', 'loan_applications.id')
        ->join('loan_type', 'loan_type.id', '=', 'loan_applications.loan_type')
        ->select('loan_applications.*', 'loan_applications_peb.*', 'loan_type.name as loan_type_name', 'loan_applications.date_created as loan_date', 'loan_applications.id as loan_id')
        ->where('loan_applications.member_no', '=', $member->member_no)
        ->where('loan_applications.control_number', 'like', "%{$searchValue}%")
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    } else {
      $loans = DB::table('loan_applications')
        ->join('loan_applications_peb', 'loan_applications_peb.loan_app_id', '=', 'loan_applications.id')
        ->join('loan_type', 'loan_type.id', '=', 'loan_applications.loan_type')
        ->select('loan_applications.*', 'loan_applications_peb.*', 'loan_type.name as loan_type_name', 'loan_applications.date_created as loan_date', 'loan_applications.id as loan_id')
        ->where('loan_applications.member_no', '=', $member->member_no)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }

    //filter codes
    if (!empty($loan_type_filter)) {

      $loans = DB::table('loan_applications')
        ->join('loan_applications_peb', 'loan_applications_peb.loan_app_id', '=', 'loan_applications.id')
        ->join('loan_type', 'loan_type.id', '=', 'loan_applications.loan_type')
        ->select('loan_applications.*', 'loan_applications_peb.*', 'loan_type.name as loan_type_name', 'loan_applications.date_created as loan_date', 'loan_applications.id as loan_id')
        ->where('loan_applications.member_no', '=', $member->member_no)
        ->where('loan_applications.loan_type', '=', $loan_type_filter)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }


    if (!empty($loan_status_filter)) {

      $loans = DB::table('loan_applications')
        ->join('loan_applications_peb', 'loan_applications_peb.loan_app_id', '=', 'loan_applications.id')
        ->join('loan_type', 'loan_type.id', '=', 'loan_applications.loan_type')
        ->select('loan_applications.*', 'loan_applications_peb.*', 'loan_type.name as loan_type_name', 'loan_applications.date_created as loan_date', 'loan_applications.id as loan_id')
        ->where('loan_applications.member_no', '=', $member->member_no)
        ->where('loan_applications.status', '=', $loan_status_filter)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }


    if (!empty($appointment_date_from) && !empty($appointment_date_to)) {

      $loans = DB::table('loan_applications')
        ->join('loan_applications_peb', 'loan_applications_peb.loan_app_id', '=', 'loan_applications.id')
        ->join('loan_type', 'loan_type.id', '=', 'loan_applications.loan_type')
        ->select('loan_applications.*', 'loan_applications_peb.*', 'loan_type.name as loan_type_name', 'loan_applications.date_created as loan_date', 'loan_applications.id as loan_id')
        ->where('loan_applications.member_no', '=', $member->member_no)
        ->where('loan_applications.date_created', '>=', $appointment_date_from)
        ->where('loan_applications.date_created', '<=', $appointment_date_to)
        ->orderBy($order, $dir)
        ->offset($start)
        ->limit($limit)
        ->get();
    }

    $totalFiltered = DB::table('loan_applications')->where('member_no', '=', $member->member_no)->count();

    $data = [];
    foreach ($loans as $row) {
      $nestedData['control_number'] = $row->control_number;
      $nestedData['loan_date'] = $row->loan_date;
      $nestedData['loan_type_name'] = $row->loan_type_name;
      $nestedData['status'] = $row->status;
      $nestedData['remarks'] = $row->cancellation_reason;
      $nestedData['approved_amount'] = "PHP " . number_format($row->approved_amount);
      $nestedData['monthly_amort'] = "PHP " . number_format($row->monthly_amort);

      if ($row->status == 'DRAFT') {
        $nestedData['action'] = '
          
                <a href="/member/loan/pel/save-as-draft/' . $row->loan_id .  '" data-md-tooltip="View Loan" class="view_member md-tooltip--right" id="view-loan" style="cursor: pointer">
                                                            <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                                        </a>
         ';
      } else {
        $nestedData['action'] = '
          
                <a href="/member/loan/view' . $row->loan_id .  '" data-md-tooltip="View Loan" class="view_member md-tooltip--right" id="view-loan" style="cursor: pointer">
                                                            <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                                        </a>
         ';
      }


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

  //count member loan details 
  public function countMemberLoan()
  {

    $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'member_detail.*', 'users.id as user_id', 'campus.name as campus_name', 'member.member_no as member_no')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('member_detail', 'member_detail.member_no', '=', 'member.member_no')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();


    if (request()->has('view')) {

      $total_confirmed = DB::table('loan_applications')->where('status', 'CONFIRMED')->where('member_no', $member->member_no)->count();
      $total_for_review = DB::table('loan_applications')->where('status', 'DRAFT')->where('member_no', $member->member_no)->count();
      $total_approved = DB::table('loan_applications')->where('status', 'APPROVED')->where('member_no', $member->member_no)->count();
      $total_rejected = DB::table('loan_applications')->where('status', 'CANCELLED')->where('member_no', $member->member_no)->count();
      $total_processing = DB::table('loan_applications')->where('status', '=', 'PROCESSING')->where('member_no', $member->member_no)->count();
    }

    $data = array(
      'total_processing' => $total_processing,
      'total_confirmed' => $total_confirmed,
      'total_for_review' => $total_for_review,
      'total_approved' => $total_approved,
      'total_rejected' => $total_rejected,
    );

    echo json_encode($data);
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
        ->join("member_detail", "member_detail.member_no", "=", "member.member_no")
        ->select('member.*', 'users.*', 'member_detail.*', 'old_campus.name as campus_name')
        ->get()->first();

      $loan_details = DB::table('candidates_tbl')
        ->where('candidates_tbl.election_id', '=',  $user_id)
        ->where('candidates_tbl.sg_category', '=',  '16-33')
        ->join("personal_details", "candidates_tbl.personal_id", "=", "personal_details.personal_id")
        ->join("campus", "candidates_tbl.campus_id", "=", "campus.id")
        ->join("membership_id", "candidates_tbl.membership_id", "=", "membership_id.mem_id")
        ->join("employee_details", "membership_id.employee_no", "=", "employee_details.employee_no")
        ->select('candidates_tbl.*', 'personal_details.*', 'campus.name as campus_name', 'membership_id.*', 'employee_details.*')
        ->get();
      $member = User::where('users.id', $user_id)
        ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
        ->leftjoin(
          'member',
          'users.id',
          '=',
          'member.user_id'
        )
        ->leftjoin(
          'campus',
          'member.campus_id',
          '=',
          'campus.id'
        )
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


      $years = OLDMembers::select(DB::raw("YEAR(original_appointment_date) - YEAR(CURDATE()) - (DATE_FORMAT(original_appointment_date,'%m%d') < DATE_FORMAT(CURDATE(),'%m%d')) as years"))
        ->where('user_Id', '=', $member->user_id)->get();

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
      return view(
        'member.loan_application.calculator',
        array(
          'member_details' => $member_details,
          'loan_details' => $loan_details,
          'totalcontributions' => $totalcontributions,
          'years' => abs($years[0]->years),
          'outstandingloans' => $outstandingloans,
          'totalloanbalance' => $totalloanbalance
        )
      );
    } else {
      return redirect('/login');
    }
  }

  //pel loan calculator edit draft application
  public function pel_application_draft($id)
  {
    if (Auth::check()) {
      //logged in
      $user_id = Auth::user()->id;
      $member_details = DB::table('member')
        ->where('member.user_id', '=',  $user_id)
        ->join('old_campus', "old_campus.id", "=", "member.campus_id")
        ->join("users", "member.user_id", "=", "users.id")
        ->join("member_detail", "member_detail.member_no", "=", "member.member_no")
        ->select('member.*', 'users.*', 'member_detail.*', 'old_campus.name as campus_name')
        ->get()->first();

      $loan_details = DB::table('candidates_tbl')
        ->where('candidates_tbl.election_id', '=',  $user_id)
        ->where('candidates_tbl.sg_category', '=',  '16-33')
        ->join("personal_details", "candidates_tbl.personal_id", "=", "personal_details.personal_id")
        ->join(
          "campus",
          "candidates_tbl.campus_id",
          "=",
          "campus.id"
        )
        ->join("membership_id", "candidates_tbl.membership_id", "=", "membership_id.mem_id")
        ->join("employee_details", "membership_id.employee_no", "=", "employee_details.employee_no")
        ->select('candidates_tbl.*', 'personal_details.*', 'campus.name as campus_name', 'membership_id.*', 'employee_details.*')
        ->get();
      $member = User::where('users.id', $user_id)
        ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
        ->leftjoin(
          'member',
          'users.id',
          '=',
          'member.user_id'
        )
        ->leftjoin(
          'campus',
          'member.campus_id',
          '=',
          'campus.id'
        )
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


      $years = OLDMembers::select(DB::raw("YEAR(original_appointment_date) - YEAR(CURDATE()) - (DATE_FORMAT(original_appointment_date,'%m%d') < DATE_FORMAT(CURDATE(),'%m%d')) as years"))
        ->where('user_Id', '=', $member->user_id)->get();

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

      $draft_details = DB::table('loan_applications')
        ->select("loan_applications.*", "loan_applications_peb.*", "loan_applications.id as loan_app_id", "loan_applications_peb.id as loan_peb_id")
        ->join("loan_applications_peb", "loan_applications_peb.loan_app_id", "=", "loan_applications.id")
        ->where('loan_applications.id', $id)
        ->get()
        ->first();

      return view(
        'member.loan_application.pel_calculator_draft',
        array(
          'member_details' => $member_details,
          'loan_details' => $loan_details,
          'totalcontributions' => $totalcontributions,
          'years' => abs($years[0]->years),
          'outstandingloans' => $outstandingloans,
          'totalloanbalance' => $totalloanbalance,
          'loan_application_details' => $draft_details
        )
      );
    } else {
      return redirect('/login');
    }
  }

  public function addNewPelLoan(Request $request)
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
        'year_terms' => $request->input('year_terms'),
        'control_number' => $control_number,
        'net_proceeds' => $request->input('net_proceeds'),
        'active_email' => $request->input('active_email'),
        'active_number' => $request->input('active_number'),
        'status' => 'PROCESSING'
      ]
    );


    //files rename + storing code
    $valid_id =  $request->file('valid_id');

    $valid_id_file = $valid_id->getClientOriginalName();
    $valid_id_file_name = $control_number . '_' . $valid_id_file;
    $path_valid_id = $valid_id->storeAs('loan_applications', $valid_id_file_name, 'public');

    $payslip_1 =  $request->file('payslip_1');
    $payslip_1_file = $payslip_1->getClientOriginalName();
    $payslip_1_file_name = $control_number . '_' . $payslip_1_file;
    $path_payslip_1 =  $payslip_1->storeAs('loan_applications', $payslip_1_file_name, 'public');

    $payslip_2 =  $request->file('payslip_2');
    $payslip_2_file = $payslip_2->getClientOriginalName();
    $payslip_2_file_name = $control_number . '_' . $payslip_2_file;
    $path_payslip_2 = $payslip_2->storeAs('loan_applications', $payslip_2_file_name, 'public');

    $passbook =  $request->file('passbook');
    $passbook_file = $passbook->getClientOriginalName();
    $passbook_file_name = $control_number . '_' . $passbook_file;
    $path_passbook =  $passbook->storeAs('loan_applications', $passbook_file_name, 'public');
    //end file code

    $loandet_id = DB::table('loan_applications_peb')->insertGetId(
      [

        'bank' =>  $request->input('bank'),
        'loan_app_id' => $loanapp_id,
        'p_id' => $valid_id_file_name,
        'payslip_1' => $payslip_1_file_name,
        'payslip_2' => $payslip_2_file_name,
        'atm_passbook' => $passbook_file_name,
        'amount' => $request->input('approved_amount'),
        'account_name' => $request->input('account_name'),
        'account_number' => $request->input('account_number'),
        'type' => 'NEW',
        'amount' => $request->input('loan_amount')
      ]

    );
    if (!empty($loandet_id)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }

  public function addNewPelLoanDraft(Request $request)
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
        'year_terms' => $request->input('year_terms'),
        'control_number' => $control_number,
        'net_proceeds' => $request->input('net_proceeds') == '' ? null :  $request->input('net_proceeds'),
        'active_email' => $request->input('active_email')  == '' ? null : $request->input('active_email'),
        'active_number' => $request->input('active_number')  == '' ? null : $request->input('active_number'),
        'status' => 'DRAFT'
      ]
    );


    //files rename + storing code

    $valid_id =  $request->file('valid_id');
    if (!empty($valid_id)) {
      $valid_id_file = $valid_id->getClientOriginalName();
      $valid_id_file_name = $control_number . '_' . $valid_id_file;
      $path_valid_id = $valid_id->storeAs('loan_applications', $valid_id_file_name, 'public');
    } else {
      $valid_id_file_name = null;
    }

    $payslip_1 =  $request->file('payslip_1');
    if (!empty($payslip_1)) {
      $payslip_1_file = $payslip_1->getClientOriginalName();
      $payslip_1_file_name = $control_number . '_' . $payslip_1_file;
      $path_payslip_1 =  $payslip_1->storeAs('loan_applications', $payslip_1_file_name, 'public');
    } else {
      $payslip_1_file_name = null;
    }

    $payslip_2 =  $request->file('payslip_2');
    if (!empty($payslip_2)) {
      $payslip_2_file = $payslip_2->getClientOriginalName();
      $payslip_2_file_name = $control_number . '_' . $payslip_2_file;
      $path_payslip_2 = $payslip_2->storeAs('loan_applications', $payslip_2_file_name, 'public');
    } else {
      $payslip_2_file_name = null;
    }

    $passbook =  $request->file('passbook');
    if (!empty($passbook)) {
      $passbook_file = $passbook->getClientOriginalName();
      $passbook_file_name = $control_number . '_' . $passbook_file;
      $path_passbook =  $passbook->storeAs('loan_applications', $passbook_file_name, 'public');
    } else {
      $passbook_file_name = null;
    }


    //end file code
    $loandet_id = DB::table('loan_applications_peb')->insertGetId(
      [
        'bank' =>  $request->input('bank') == '' ? null : $request->input('bank'),
        'loan_app_id' => $loanapp_id,
        'p_id' => $valid_id_file_name,
        'payslip_1' => $payslip_1_file_name,
        'payslip_2' => $payslip_2_file_name,
        'atm_passbook' => $passbook_file_name,
        'amount' => $request->input('approved_amount') == '' ? null : $request->input('approved_amount'),
        'account_name' => $request->input('account_name') == '' ? null : $request->input('account_name'),
        'account_number' => $request->input('account_number') == '' ? null : $request->input('account_number'),
        'type' => 'NEW',
        'amount' => $request->input('loan_amount') == '' ? null : $request->input('loan_amount'),
      ]

    );
    if (!empty($loandet_id)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }


  public function editNewPelLoanDraft(Request $request)
  {
    $control_number = $request->input('control_number');
    $loan_app_id = $request->input('loan_app_id');


    $update_loan_application = DB::table('loan_applications')
      ->where('id', $loan_app_id)
      ->update([
        'member_no' => $request->input('member_no'),
        'loan_type' => 1,
        'year_terms' => $request->input('year_terms') == '' ? null :  $request->input('year_terms'),
        'control_number' => $control_number,
        'net_proceeds' => $request->input('net_proceeds') == '' ? null :  $request->input('net_proceeds'),
        'active_email' => $request->input('active_email')  == '' ? null : $request->input('active_email'),
        'active_number' => $request->input('active_number')  == '' ? null : $request->input('active_number'),
        'status' => 'DRAFT'
      ]);



    //files rename + storing code

    $valid_id =  $request->file('valid_id');
    $recent_valid_id =  $request->input('recent_valid_id');
    if (!empty($valid_id)) {
      $valid_id_file = $valid_id->getClientOriginalName();
      $valid_id_file_name = $control_number . '_' . $valid_id_file;
      $path_valid_id = $valid_id->storeAs('loan_applications', $valid_id_file_name, 'public');
    } else if (empty($valid_id) && !empty($recent_valid_id)) {
      $valid_id_file_name = $recent_valid_id;
    } else {
      $valid_id_file_name = null;
    }

    $payslip_1 =  $request->file('payslip_1');
    $recent_payslip_1 =  $request->input('recent_payslip_1');
    if (!empty($payslip_1)) {
      $payslip_1_file = $payslip_1->getClientOriginalName();
      $payslip_1_file_name = $control_number . '_' . $payslip_1_file;
      $path_payslip_1 =  $payslip_1->storeAs('loan_applications', $payslip_1_file_name, 'public');
    } else if (empty($payslip_1) && !empty($recent_payslip_1)) {
      $payslip_1_file_name = $recent_payslip_1;
    } else {
      $payslip_1_file_name = null;
    }

    $payslip_2 =  $request->file('payslip_2');
    $recent_payslip_2 =  $request->input('recent_payslip_2');
    if (!empty($payslip_2)) {
      $payslip_2_file = $payslip_2->getClientOriginalName();
      $payslip_2_file_name = $control_number . '_' . $payslip_2_file;
      $path_payslip_2 = $payslip_2->storeAs('loan_applications', $payslip_2_file_name, 'public');
    } else if (empty($payslip_2) && !empty($recent_payslip_2)) {
      $payslip_2_file_name = $recent_payslip_2;
    } else {
      $payslip_2_file_name = null;
    }

    $passbook =  $request->file('passbook');
    $recent_passbook =  $request->input('recent_passbook');
    if (!empty($passbook)) {
      $passbook_file = $passbook->getClientOriginalName();
      $passbook_file_name = $control_number . '_' . $passbook_file;
      $path_passbook =  $passbook->storeAs('loan_applications', $passbook_file_name, 'public');
    } else if (empty($passbook) && !empty($recent_passbook)) {
      $passbook_file_name = $recent_passbook;
    } else {

      $passbook_file_name = null;
    }




    //end file code
    if (!empty($loan_peb_id)) {
      $edit_loan_peb = DB::table('loan_applications_peb')->insertGetId(
        [
          'bank' =>  $request->input('bank') == '' ? null : $request->input('bank'),
          'loan_app_id' => $loan_app_id,
          'p_id' => $valid_id_file_name,
          'payslip_1' => $payslip_1_file_name,
          'payslip_2' => $payslip_2_file_name,
          'atm_passbook' => $passbook_file_name,
          'amount' => $request->input('approved_amount') == '' ? null : $request->input('approved_amount'),
          'account_name' => $request->input('account_name') == '' ? null : $request->input('account_name'),
          'account_number' => $request->input('account_number') == '' ? null : $request->input('account_number'),
          'type' => 'NEW',
          'amount' => $request->input('loan_amount') == '' ? null : $request->input('loan_amount'),
        ]

      );
    } else {
      $edit_loan_peb = DB::table('loan_applications_peb')
        ->where('loan_app_id', $loan_app_id)
        ->update([
          'bank' =>  $request->input('bank') == '' ? null : $request->input('bank'),
          'loan_app_id' => $loan_app_id,
          'p_id' => $valid_id_file_name,
          'payslip_1' => $payslip_1_file_name,
          'payslip_2' => $payslip_2_file_name,
          'atm_passbook' => $passbook_file_name,
          'amount' => $request->input('approved_amount') == '' ? null : $request->input('approved_amount'),
          'account_name' => $request->input('account_name') == '' ? null : $request->input('account_name'),
          'account_number' => $request->input('account_number') == '' ? null : $request->input('account_number'),
          'type' => 'NEW',
          'amount' => $request->input('loan_amount') == '' ? null : $request->input('loan_amount'),
        ]);
    }


    return response()->json(['success' => true]);
  }

  //submit from edit pel loan drafts
  public function editNewPelLoan(Request $request)
  {

    $control_number = $request->input('control_number');
    $loan_app_id = $request->input('loan_app_id');

    try {
      $update_loan_application = DB::table('loan_applications')

        ->where('id', $loan_app_id)
        ->update([
          'member_no' => $request->input('member_no'),
          'loan_type' => 1,
          'year_terms' => $request->input('year_terms'),
          'control_number' => $control_number,
          'net_proceeds' => $request->input('net_proceeds'),
          'active_email' => $request->input('active_email'),
          'active_number' => $request->input('active_number'),
          'status' => 'PROCESSING'
        ]);
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json(['success' => false]);
    } catch (\Exception $e) {
      return response()->json(['success' => false]);
    }



    //files rename + storing code

    $valid_id =  $request->file('valid_id');
    $recent_valid_id =  $request->input('recent_valid_id');
    if (!empty($valid_id)) {
      $valid_id_file = $valid_id->getClientOriginalName();
      $valid_id_file_name = $control_number . '_' . $valid_id_file;
      $path_valid_id = $valid_id->storeAs('loan_applications', $valid_id_file_name, 'public');
    } else if (empty($valid_id) && !empty($recent_valid_id)) {
      $valid_id_file_name = $recent_valid_id;
    } else {
      $valid_id_file_name = null;
    }

    $payslip_1 =  $request->file('payslip_1');
    $recent_payslip_1 =  $request->input('recent_payslip_1');
    if (!empty($payslip_1)) {
      $payslip_1_file = $payslip_1->getClientOriginalName();
      $payslip_1_file_name = $control_number . '_' . $payslip_1_file;
      $path_payslip_1 =  $payslip_1->storeAs('loan_applications', $payslip_1_file_name, 'public');
    } else if (empty($payslip_1) && !empty($recent_payslip_1)) {
      $payslip_1_file_name = $recent_payslip_1;
    } else {
      $payslip_1_file_name = null;
    }

    $payslip_2 =  $request->file('payslip_2');
    $recent_payslip_2 =  $request->input('recent_payslip_2');
    if (!empty($payslip_2)) {
      $payslip_2_file = $payslip_2->getClientOriginalName();
      $payslip_2_file_name = $control_number . '_' . $payslip_2_file;
      $path_payslip_2 = $payslip_2->storeAs('loan_applications', $payslip_2_file_name, 'public');
    } else if (empty($payslip_2) && !empty($recent_payslip_2)) {
      $payslip_2_file_name = $recent_payslip_2;
    } else {
      $payslip_2_file_name = null;
    }

    $passbook =  $request->file('passbook');
    $recent_passbook =  $request->input('recent_passbook');
    if (!empty($passbook)) {
      $passbook_file = $passbook->getClientOriginalName();
      $passbook_file_name = $control_number . '_' . $passbook_file;
      $path_passbook =  $passbook->storeAs('loan_applications', $passbook_file_name, 'public');
    } else if (empty($passbook) && !empty($recent_passbook)) {
      $passbook_file_name = $recent_passbook;
    } else {

      $passbook_file_name = null;
    }

    //end file code
    if (!empty($loan_peb_id)) {
      try {
        $edit_loan_peb = DB::table('loan_applications_peb')->insertGetId(
          [
            'bank' =>  $request->input('bank'),
            'loan_app_id' => $loan_app_id,
            'p_id' => $valid_id_file_name,
            'payslip_1' => $payslip_1_file_name,
            'payslip_2' => $payslip_2_file_name,
            'atm_passbook' => $passbook_file_name,
            'amount' => $request->input('approved_amount'),
            'account_name' => $request->input('account_name'),
            'account_number' => $request->input('account_number'),
            'type' => 'NEW',
          ]

        );
      } catch (\Illuminate\Database\QueryException $e) {
        return response()->json(['success' => false]);
      } catch (\Exception $e) {
        return response()->json(['success' => false]);
      }
    } else {
      try {
        $edit_loan_peb =  DB::table('loan_applications_peb')
          ->where('loan_app_id', $loan_app_id)
          ->update([
            'bank' =>  $request->input('bank'),
            'loan_app_id' => $loan_app_id,
            'p_id' => $valid_id_file_name,
            'payslip_1' => $payslip_1_file_name,
            'payslip_2' => $payslip_2_file_name,
            'atm_passbook' => $passbook_file_name,
            'amount' => $request->input('approved_amount'),
            'account_name' => $request->input('account_name'),
            'account_number' => $request->input('account_number'),
            'type' => 'NEW',
          ]);
      } catch (\Illuminate\Database\QueryException $e) {
        return response()->json(['success' => false]);
      } catch (\Exception $e) {
        return response()->json(['success' => false]);
      }
    }


    return response()->json(['success' => true]);
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
    if (!empty($update_member_details) || !empty($update_user_details) || !empty($update_member)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }


  public function benefits()
  {
    if (Auth::check()) {
      return view('member.benefits.index');
    } else {
      return redirect('/login');
    }
  }

  public function benefitsClaim()
  {
    if (Auth::check()) {
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
      return view('member.benefits.claim')->with($data);
    } else {
      return redirect('/login');
    }
  }


  public function benefitsApply()
  {
    if (Auth::check()) {

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
      return view('member.benefits.apply')->with($data);
    } else {
      return redirect('/login');
    }
  }

  public function votingDashboard()
  {
    if (Auth::check()) {

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
      return view('member.vote.index')->with($data);
    } else {
      return redirect('/login');
    }
  }
}
