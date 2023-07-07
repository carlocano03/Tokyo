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
use App\Models\BenefitApplications;
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
      $total_new = DB::table('loan_applications')->where('status', '=', 'NEW APPLICATION')->where('member_no', $member->member_no)->count();

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
        'total_new' => $total_new,
      );

      return view('member.dashboard')->with($data);
    } else {
      return redirect('/login');
    }
  }

  public function generateequity()
  {
    $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();

    // $equity=ContributionTransaction::select('contribution_transaction.id as id', 'date', 'account_id', 'contribution_id', 'reference_no', 'amount','contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date  order by date desc, contribution_transaction.id desc) as balance'))
    // ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
    // ->leftjoin('member','contribution.member_id','member.id')
    // ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
    // ->where('contribution.member_id','=',$member->member_id)
    // ->Where('contribution_transaction.amount','<>',0.00)
    // ->orderBy('date','desc')
    // ->orderBy('contribution_transaction.id','desc')
    // ->get();

    $equity = ContributionTransaction::select('contribution_transaction.id as id', DB::raw('ABS(amount) as abs'), 'date', 'account_id', 'contribution_id', 'reference_no', 'amount', 'contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date order by date desc, contribution_transaction.id desc) as balance'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->leftjoin('member', 'contribution.member_id', 'member.id')
      ->leftjoin('contribution_account', 'contribution_transaction.account_id', 'contribution_account.id')
      ->where('contribution.member_id', '=', $member->member_id)
      ->where('contribution_transaction.amount', '<>', 0.00)
      ->orderBy('date', 'desc')
      ->orderBy('contribution.reference_no', 'desc')
      ->orderBy('abs', 'desc')
      ->orderBy('contribution_transaction.id', 'desc')
      ->get();



    $data['equity'] = $equity;
    $data['member'] = $member;



    $pdf = PDF::loadView('pdf.equity', $data);
    return $pdf->setPaper('a4', 'landscape')->stream('eqity.pdf');
  }

  public function exportLoanTransaction($id, $dt_from, $dt_to)
  {
    DB::enableQueryLog();
    if (!empty($id) && $id != 0) {
      $member = User::where('users.id', Auth::user()->id)
        ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
        ->leftjoin('member', 'users.id', '=', 'member.user_id')
        ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
        ->first();
      $equity = LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date  order by date desc) as balance'))
        ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
        ->leftjoin('member', 'loan.member_id', 'member.id')
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.member_id', '=', $member->member_id)
        ->Where('loan_transaction.amount', '<>', 0.00)
        ->orderBy('loan.type_id', 'ASC')
        ->orderBy('date', 'desc')
        ->where('loan.type_id', $id);
    } else {
      $member = User::where('users.id', Auth::user()->id)
        ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
        ->leftjoin('member', 'users.id', '=', 'member.user_id')
        ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
        ->first();
      $equity = LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date  order by date desc) as balance'))
        ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
        ->leftjoin('member', 'loan.member_id', 'member.id')
        ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
        ->where('loan.member_id', '=', $member->member_id)
        ->Where('loan_transaction.amount', '<>', 0.00)
        ->orderBy('loan.type_id', 'ASC')
        ->orderBy('date', 'desc');
    }
    if (!empty($dt_from) && !empty($dt_to) && $dt_from != 0 && $dt_to != 0) {
      $equity->whereBetween(DB::raw('DATE(contribution.date_added)'), array($dt_from, $dt_to));
    }

    $curdate = '';
    $amount = '';
    $amort = '';
    $inte = '';
    $type = '';
    $contriData = "";
    $posts = $equity->get();

    if (count($posts) > 0) {
      $contriData .= '
        <table>
          <tr>
            <th>Date</th>
            <th>Transaction</th>
            <th>Account</th>
            <th>Monthly Amortization</th>
            <th>Interest</th>
            <th>Amount</th>
            <th>Principal Balance</th>
          </tr>
        ';
      foreach ($posts as $key => $value) {
        if ($curdate == $value->date && $value->name == $type && number_format(abs($value->amount), 2) == $amount && number_format(abs($value->amortization), 2) == $amort && number_format(abs($value->interest), 2) == $inte) {
          unset($posts[$key - 1]);
          unset($posts[$key]);
        }
        $curdate = $value->date;
        $amount = number_format(abs($value->amount), 2);
        $amort = number_format(abs($value->amortization), 2);
        $inte = number_format(abs($value->interest), 2);
        $type = $value->name;
      }
      $date = '';

      foreach ($posts as $contri) {
        $samedate = true;
        if ($date == date('m/d/Y', strtotime($contri->date))) {
          $samedate = false;
        } else {
          $samedate = true;
        }
        $date = date('m/d/Y', strtotime($contri->date));
        $amortization = $contri->amortization == 0 ? '' : 'PHP ' . number_format($contri->amortization, 2);
        $interest = $contri->interest == 0 ? '' : 'PHP ' . number_format($contri->interest, 2);
        $bal = !$samedate ? '' : 'PHP ' . number_format($contri->balance, 2);

        $contriData .= '
          <tr>
            <td>' . date('m/d/Y', strtotime($contri->date)) . '</td>
            <td>' . $contri->reference_no . '</td>
            <td>' . $contri->name . '</td>
            <td>' . $amortization . '</td>
            <td>' . $interest  . '</td>
            <td>' . 'PHP ' . number_format($contri->amount, 2) . '</td>
            <td>' . $bal . '</td>
          </tr>
          ';
      }
      $contriData .= '</table>';
    }



    header('Content-Disposition: attachment; filename=Loan Transactions.xls');
    header('Content-Type: application/xls');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    $query = DB::getQueryLog();
    echo ($contriData);
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
      $loan_type = DB::table('loan_type')
        ->get();
      $data = array(
        'loan_type' => $loan_type,
      );
      // dd($loans);
      return view('member.transaction')->with($data);
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
          
                <a href="/member/loan/view/' . $row->loan_id .  '" data-md-tooltip="View Loan" class="view_member md-tooltip--right" id="view-loan" style="cursor: pointer">
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
      $total_new = DB::table('loan_applications')->where('status', '=', 'NEW APPLICATION')->where('member_no', $member->member_no)->count();
    }

    $data = array(
      'total_processing' => $total_processing,
      'total_confirmed' => $total_confirmed,
      'total_for_review' => $total_for_review,
      'total_approved' => $total_approved,
      'total_rejected' => $total_rejected,
      'total_new' => $total_new
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
      $account = DB::table('contribution_account')
        ->get();
      $data = array(
        'account' => $account,
      );
      return view('member.equity')->with($data);
    } else {
      return redirect('/login');
    }
  }

  public function membersEquity(Request $request)
  {
    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    // $columnIndex_arr = $request->get('order');
    // $columnName_arr = $request->get('columns');
    // $order_arr = $request->get('order');
    // $search_arr = $request->get('search');

    // $columnIndex = $columnIndex_arr[0]['column']; // Column index
    // $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    // $searchValue = $search_arr['value']; // Search value

    // Custom search filter 
    $account  = $request->get('account');
    $dt_from  = $request->get('dt_from');
    $dt_to  = $request->get('dt_to');
    $search  = $request->get('searchValue');

    $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();

    $records = ContributionTransaction::select('contribution_transaction.id as id', DB::raw('ABS(amount) as abs'), 'date', 'account_id', 'contribution_id', 'reference_no', 'amount', 'contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date order by date desc, contribution_transaction.id desc) as balance'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->leftjoin('member', 'contribution.member_id', 'member.id')
      ->leftjoin('contribution_account', 'contribution_transaction.account_id', 'contribution_account.id')
      ->where('contribution.member_id', '=', $member->member_id)
      ->where('contribution_transaction.amount', '<>', 0.00)
      ->orderBy('date', 'desc')
      ->orderBy('contribution.reference_no', 'desc')
      ->orderBy('abs', 'desc')
      ->orderBy('contribution_transaction.id', 'desc')
      ->where('contribution.reference_no', 'like', '%' . $search . '%');
    ## Add custom filter conditions
    if (!empty($account)) {
      $records->where('contribution_transaction.account_id', $account);
    }
    if (!empty($search)) {
      $records->where('contribution.reference_no', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(date)'), array($dt_from, $dt_to));
    }
    $totalRecords = $records->count();

    $records = ContributionTransaction::select('contribution_transaction.id as id', DB::raw('ABS(amount) as abs'), 'date', 'account_id', 'contribution_id', 'reference_no', 'amount', 'contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date order by date desc, contribution_transaction.id desc) as balance'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->leftjoin('member', 'contribution.member_id', 'member.id')
      ->leftjoin('contribution_account', 'contribution_transaction.account_id', 'contribution_account.id')
      ->where('contribution.member_id', '=', $member->member_id)
      ->where('contribution_transaction.amount', '<>', 0.00)
      ->orderBy('date', 'desc')
      ->orderBy('contribution.reference_no', 'desc')
      ->orderBy('abs', 'desc')
      ->orderBy('contribution_transaction.id', 'desc')
      ->where('contribution.reference_no', 'like', '%' . $search . '%');
    ## Add custom filter conditions
    if (!empty($account)) {
      $records->where('contribution_transaction.account_id', $account);
    }
    if (!empty($search)) {
      $records->where('contribution.reference_no', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(date)'), array($dt_from, $dt_to));
    }
    $totalRecordswithFilter = $records->count();

    $records = ContributionTransaction::select('contribution_transaction.id as id', DB::raw('ABS(amount) as abs'), 'date', 'account_id', 'contribution_id', 'reference_no', 'amount', 'contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date order by date desc, contribution_transaction.id desc) as balance'))
      ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
      ->leftjoin('member', 'contribution.member_id', 'member.id')
      ->leftjoin('contribution_account', 'contribution_transaction.account_id', 'contribution_account.id')
      ->where('contribution.member_id', '=', $member->member_id)
      ->where('contribution_transaction.amount', '<>', 0.00)
      ->orderBy('date', 'desc')
      ->orderBy('contribution.reference_no', 'desc')
      ->orderBy('abs', 'desc')
      ->orderBy('contribution_transaction.id', 'desc')
      ->where('contribution.reference_no', 'like', '%' . $search . '%');

    ## Add custom filter conditions
    if (!empty($account)) {
      $records->where('contribution_transaction.account_id', $account);
    }
    if (!empty($search)) {
      $records->where('contribution.reference_no', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(contribution.date_added)'), array($dt_from, $dt_to));
    }

    $posts = $records->skip($start)
      ->take($rowperpage)
      ->get();
    $data = array();
    $curdate = '';
    $amount = '';
    $reference = '';
    $contriData = "";
    if ($posts) {
      foreach ($posts as $key => $value) {
        if ($curdate == $value->date && number_format($value->amount, 2) == $amount && $reference == $value->reference_no) {
          unset($posts[$key - 1]);
          unset($posts[$key]);
        }
        $curdate = $value->date;
        $amount = number_format(abs($value->amount), 2);
      }
      foreach ($posts as $contri) {
        $start++;
        $row = array();
        if ($curdate == $contri->date) {
          $bal = '';
        } else {
          $bal = 'PHP ' . number_format($contri->balance, 2);
          $curdate = $contri->date;
        }
        $debit = $contri->amount < 0 ? 'PHP ' . number_format(abs($contri->amount), 2) : '';
        $credit = $contri->amount >= 0 ? 'PHP ' . number_format($contri->amount, 2) : '';

        $row[] = date('m/d/Y', strtotime($contri->date));
        $row[] = $contri->reference_no;
        $row[] = $contri->name;
        $row[] = $debit;
        $row[] = $credit;
        $row[] = $bal;

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

  public function exportEquity($id, $dt_from, $dt_to)
  {
    DB::enableQueryLog();
    if (!empty($id) && $id != 0) {
      $member = User::where('users.id', Auth::user()->id)
        ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
        ->leftjoin('member', 'users.id', '=', 'member.user_id')
        ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
        ->first();
      $equity = ContributionTransaction::select('contribution_transaction.id as id', DB::raw('ABS(amount) as abs'), 'date', 'account_id', 'contribution_id', 'reference_no', 'amount', 'contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date order by date desc, contribution_transaction.id desc) as balance'))
        ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
        ->leftjoin('member', 'contribution.member_id', 'member.id')
        ->leftjoin('contribution_account', 'contribution_transaction.account_id', 'contribution_account.id')
        ->where('contribution.member_id', '=', $member->member_id)
        ->where('contribution_transaction.amount', '<>', 0.00)
        ->orderBy('date', 'desc')
        ->orderBy('contribution.reference_no', 'desc')
        ->orderBy('abs', 'desc')
        ->orderBy('contribution_transaction.id', 'desc')
        ->where('contribution_transaction.account_id', $id);
    } else {
      $member = User::where('users.id', Auth::user()->id)
        ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
        ->leftjoin('member', 'users.id', '=', 'member.user_id')
        ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
        ->first();
      $equity = ContributionTransaction::select('contribution_transaction.id as id', DB::raw('ABS(amount) as abs'), 'date', 'account_id', 'contribution_id', 'reference_no', 'amount', 'contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date order by date desc, contribution_transaction.id desc) as balance'))
        ->leftjoin('contribution', 'contribution_transaction.contribution_id', 'contribution.id')
        ->leftjoin('member', 'contribution.member_id', 'member.id')
        ->leftjoin('contribution_account', 'contribution_transaction.account_id', 'contribution_account.id')
        ->where('contribution.member_id', '=', $member->member_id)
        ->where('contribution_transaction.amount', '<>', 0.00)
        ->orderBy('date', 'desc')
        ->orderBy('contribution.reference_no', 'desc')
        ->orderBy('abs', 'desc')
        ->orderBy('contribution_transaction.id', 'desc');
    }
    if (!empty($dt_from) && !empty($dt_to) && $dt_from != 0 && $dt_to != 0) {
      $equity->whereBetween(DB::raw('DATE(contribution.date_added)'), array($dt_from, $dt_to));
    }
    $curdate = '';
    $amount = '';
    $reference = '';
    $contriData = "";
    $posts = $equity->get();

    $curdate = '';
    $reference = '';
    if (count($posts) > 0) {
      $contriData .= '
        <table>
          <tr>
            <th>Date</th>
            <th>Transaction</th>
            <th>Account</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
          </tr>
        ';
      foreach ($posts as $key => $value) {
        if ($curdate == $value->date && number_format($value->amount, 2) == $amount && $reference == $value->reference_no) {
          unset($posts[$key - 1]);
          unset($posts[$key]);
        }
        $curdate = $value->date;
        $amount = number_format(abs($value->amount), 2);
      }
      foreach ($posts as $contri) {
        if ($curdate == $contri->date) {
          $bal = '';
        } else {
          $bal = 'PHP ' . number_format($contri->balance, 2);
          $curdate = $contri->date;
        }
        $debit = $contri->amount < 0 ? 'PHP ' . number_format(abs($contri->amount), 2) : '';
        $credit = $contri->amount >= 0 ? 'PHP ' . number_format($contri->amount, 2) : '';

        $contriData .= '
          <tr>
            <td>' . date('m/d/Y', strtotime($contri->date)) . '</td>
            <td>' . $contri->reference_no . '</td>
            <td>' . $contri->name . '</td>
            <td>' . $debit . '</td>
            <td>' . $credit . '</td>
            <td>' . $bal . '</td>
          </tr>
          ';
      }
      $contriData .= '</table>';
    }

    header('Content-Disposition: attachment; filename=Equity report.xls');
    header('Content-Type: application/xls');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    $query = DB::getQueryLog();
    echo ($contriData);
  }

  public function generateloans()
  {
    $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();

    $loans = LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date order by date desc) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('member', 'loan.member_id', 'member.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where('loan.member_id', '=', $member->member_id)
      ->Where('loan_transaction.amount', '<>', 0.00)
      ->orderBy('loan.type_id', 'ASC')
      ->orderBy('date', 'desc')
      ->get();


    $data['loans'] = $loans;
    $data['member'] = $member;



    $pdf = PDF::loadView('pdf.loans', $data);
    return $pdf->setPaper('a4', 'landscape')->stream('loan.pdf');
  }

  public function memberloans(Request $request)
  {
    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    // Custom search filter 
    $loan  = $request->get('loan');
    $dt_from  = $request->get('dt_from');
    $dt_to  = $request->get('dt_to');
    $search  = $request->get('searchValue');

    $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();

    $records = LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date  order by date desc) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('member', 'loan.member_id', 'member.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where('loan.member_id', '=', $member->member_id)
      ->Where('loan_transaction.amount', '<>', 0.00)
      ->orderBy('loan.type_id', 'ASC')
      ->orderBy('date', 'desc')
      ->where('loan_transaction.reference_no', 'like', '%' . $search . '%');
    ## Add custom filter conditions
    if (!empty($loan)) {
      $records->where('loan.type_id', $loan);
    }
    if (!empty($search)) {
      $records->where('loan_transaction.reference_no', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(date)'), array($dt_from, $dt_to));
    }
    $totalRecords = $records->count();

    $records = LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date  order by date desc) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('member', 'loan.member_id', 'member.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where('loan.member_id', '=', $member->member_id)
      ->Where('loan_transaction.amount', '<>', 0.00)
      ->orderBy('loan.type_id', 'ASC')
      ->orderBy('date', 'desc')
      ->where('loan_transaction.reference_no', 'like', '%' . $search . '%');
    ## Add custom filter conditions
    if (!empty($loan)) {
      $records->where('loan.type_id', $loan);
    }
    if (!empty($search)) {
      $records->where('loan_transaction.reference_no', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(date)'), array($dt_from, $dt_to));
    }
    $totalRecordswithFilter = $records->count();

    $records = LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount', 'loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date  order by date desc) as balance'))
      ->leftjoin('loan', 'loan_transaction.loan_id', 'loan.id')
      ->leftjoin('member', 'loan.member_id', 'member.id')
      ->leftjoin('loan_type', 'loan.type_id', 'loan_type.id')
      ->where('loan.member_id', '=', $member->member_id)
      ->Where('loan_transaction.amount', '<>', 0.00)
      ->orderBy('loan.type_id', 'ASC')
      ->orderBy('date', 'desc')
      ->where('loan_transaction.reference_no', 'like', '%' . $search . '%');
    ## Add custom filter conditions
    if (!empty($loan)) {
      $records->where('loan.type_id', $loan);
    }
    if (!empty($search)) {
      $records->where('loan_transaction.reference_no', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(contribution.date_added)'), array($dt_from, $dt_to));
    }

    $posts = $records->skip($start)
      ->take($rowperpage)
      ->get();
    $curdate = '';
    $amount = '';
    $amort = '';
    $inte = '';
    $type = '';
    $data = array();
    if ($posts) {
      foreach ($posts as $key => $value) {
        if ($curdate == $value->date && $value->name == $type && number_format(abs($value->amount), 2) == $amount && number_format(abs($value->amortization), 2) == $amort && number_format(abs($value->interest), 2) == $inte) {
          unset($posts[$key - 1]);
          unset($posts[$key]);
        }
        $curdate = $value->date;
        $amount = number_format(abs($value->amount), 2);
        $amort = number_format(abs($value->amortization), 2);
        $inte = number_format(abs($value->interest), 2);
        $type = $value->name;
      }
      $date = '';
      foreach ($posts as $loan) {
        $start++;
        $row = array();
        $samedate = true;
        if ($date == date('m/d/Y', strtotime($loan->date))) {
          $samedate = false;
        } else {
          $samedate = true;
        }
        $date = date('m/d/Y', strtotime($loan->date));
        $amortization = $loan->amortization == 0 ? '' : 'PHP ' . number_format($loan->amortization, 2);
        $interest = $loan->interest == 0 ? '' : 'PHP ' . number_format($loan->interest, 2);
        $row[] = date('m/d/Y', strtotime($loan->date));
        $row[] = $loan->reference_no;
        $row[] = $loan->name;
        $row[] = $amortization;
        $row[] = $interest;
        $row[] = 'PHP ' . number_format($loan->amount, 2);
        $row[] = !$samedate ? '' : 'PHP ' . number_format($loan->balance, 2);

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
        ->select("loan_applications.*", "loan_applications_peb.*", "loan_applications.id as loan_app_id", "loan_applications_peb.id as loan_peb_id", "loan_applications.control_number as control_number")
        ->join("loan_applications_peb", "loan_applications_peb.loan_app_id", "=", "loan_applications.id")
        ->where('loan_applications.id', $id)
        ->get()
        ->first();

      return view(
        'member.loan_application.pel_calculator_draft',
        array(
          'member_details' => $member_details,

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
        'loan_interest' => $request->input('interest'),
        'status' => 'NEW APPLICATION'
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
        'type' => $request->input('type_of_loan'),
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
        'loan_interest' => $request->input('interest') == '' ? null : $request->input('interest'),
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

        'account_name' => $request->input('account_name') == '' ? null : $request->input('account_name'),
        'account_number' => $request->input('account_number') == '' ? null : $request->input('account_number'),

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
        'loan_interest' => $request->input('interest') == '' ? null : $request->input('interest'),
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

    $edit_loan_peb = DB::table('loan_applications_peb')->updateOrInsert(
      ['loan_app_id' => $loan_app_id],
      [
        'bank' =>  $request->input('bank') == '' || $request->input('bank') == "undefined" ? null : $request->input('bank'),
        'loan_app_id' => $loan_app_id,
        'p_id' => $valid_id_file_name,
        'payslip_1' => $payslip_1_file_name,
        'payslip_2' => $payslip_2_file_name,
        'atm_passbook' => $passbook_file_name,
        'account_name' => $request->input('account_name') == '' ? null : $request->input('account_name'),
        'account_number' => $request->input('account_number') == '' ? null : $request->input('account_number'),

        'amount' => $request->input('loan_amount') == '' ? null : $request->input('loan_amount'),
      ]
    );


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
          'loan_interest' => $request->input('interest'),
          'status' => 'NEW APPLICATION'
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

    try {

      $edit_loan_peb = DB::table('loan_applications_peb')->updateOrInsert(
        ['loan_app_id' => $loan_app_id],
        [
          'bank' =>  $request->input('bank'),
          'loan_app_id' => $loan_app_id,
          'p_id' => $valid_id_file_name,
          'payslip_1' => $payslip_1_file_name,
          'payslip_2' => $payslip_2_file_name,
          'atm_passbook' => $passbook_file_name,
          'amount' => $request->input('loan_amount'),
          'account_name' => $request->input('account_name'),
          'account_number' => $request->input('account_number'),

        ]
      );
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json(['success' => false]);
    } catch (\Exception $e) {
      return response()->json(['success' => false]);
    }



    return response()->json(['success' => true]);
  }


  public function bl_application()
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
        'member.loan_application.loan_type.bl_calculator',
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

  public function eml_application()
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
        'member.loan_application.loan_type.eml_calculator',
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


  public function btl_application()
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
        'member.loan_application.loan_type.btl_calculator',
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

  public function cbl_application()
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
        'member.loan_application.loan_type.cbl_calculator',
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

  public function view($id)
  {
    if (Auth::check()) {
      $loan_app_id = $id;
      $member = User::where('users.id', Auth::user()->id)
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

      $loan_details = DB::table('loan_applications')
        ->select("loan_applications.*", "loan_applications_peb.*", "loan_applications.id as loan_app_id", "loan_applications_peb.id as loan_peb_id", "loan_applications.control_number as control_number")
        ->join("loan_applications_peb", "loan_applications_peb.loan_app_id", "=", "loan_applications.id")
        ->where('loan_applications.id', $loan_app_id)
        ->get()
        ->first();

      $years = OLDMembers::select(DB::raw("YEAR(original_appointment_date) - YEAR(CURDATE()) - (DATE_FORMAT(original_appointment_date,'%m%d') < DATE_FORMAT(CURDATE(),'%m%d')) as years"))
        ->where('user_Id', '=', Auth::user()->id)->get();


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


      );
      return view('member.loan_application.view')->with($data);;
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



  public function addBenefitApplication(Request $request)
  {

    $member_no =  $request->input('member_no');
    $mode_of_seperation =  $request->input('mode_of_seperation');
    $mode_of_seperation_others =  $request->input('mode_of_seperation_others');
    $effectivity_date =  $request->input('effectivity_date');
    $remarks =  $request->input('remarks');

    $hrdo_file = $request->file('hrdo_file');
    $valid_id_1 = $request->file('valid_id_1');
    $valid_id_2 = $request->file('valid_id_2');
    $up_clearance = $request->file('up_clearance');
    $atty_file = $request->file('atty_file');
    $authorize_valid_id_1 = $request->file('authorize_valid_id_1');
    $authorize_valid_id_2 = $request->file('authorize_valid_id_2');
    $written_request   = $request->file('written_request');
    $e_signature = $request->file('e_signature');


    //files rename + storing code
    $hrdo_file_file = $hrdo_file->getClientOriginalName();
    $hrdo_file_name = $member_no . '_' . $hrdo_file_file;
    $path_hrdo_file = $hrdo_file->storeAs('benefit_applications', $hrdo_file_name, 'public');

    $valid_id_1_file = $valid_id_1->getClientOriginalName();
    $valid_id_1_name = $member_no . '_' . $valid_id_1_file;
    $path_valid_id_1 = $valid_id_1->storeAs('benefit_applications', $valid_id_1_name, 'public');

    $valid_id_2_file = $valid_id_2->getClientOriginalName();
    $valid_id_2_name = $member_no . '_' . $valid_id_2_file;
    $path_valid_id_2 = $valid_id_2->storeAs('benefit_applications', $valid_id_2_name, 'public');

    $up_clearance_file = $up_clearance->getClientOriginalName();
    $up_clearance_name = $member_no . '_' . $up_clearance_file;
    $path_up_clearance = $up_clearance->storeAs('benefit_applications', $up_clearance_name, 'public');

    $atty_file_file = $atty_file->getClientOriginalName();
    $atty_file_name = $member_no . '_' . $atty_file_file;
    $path_atty_file = $atty_file->storeAs('benefit_applications', $atty_file_name, 'public');

    $authorize_valid_id_1_file = $authorize_valid_id_1->getClientOriginalName();
    $authorize_valid_id_1_name = $member_no . '_' . $authorize_valid_id_1_file;
    $path_authorize_valid_id_1 = $authorize_valid_id_1->storeAs('benefit_applications', $authorize_valid_id_1_name, 'public');

    $authorize_valid_id_2_file = $authorize_valid_id_2->getClientOriginalName();
    $authorize_valid_id_2_name = $member_no . '_' . $authorize_valid_id_2_file;
    $path_authorize_valid_id_2 = $authorize_valid_id_2->storeAs('benefit_applications', $authorize_valid_id_2_name, 'public');

    $written_request_file = $written_request->getClientOriginalName();
    $written_request_name = $member_no . '_' . $written_request_file;
    $path_written_request = $written_request->storeAs('benefit_applications', $written_request_name, 'public');

    $e_signature_file = $e_signature->getClientOriginalName();
    $e_signature_name = $member_no . '_' . $e_signature_file;
    $path_e_signature = $e_signature->storeAs('benefit_applications', $e_signature_name, 'public');



    $benefit_insert_id = DB::table('benefit_applications')->insertGetId(
      [
        'member_no' => $member_no,
        'status' => 'NEW APPLICATION',
        'mode_of_seperation' => $mode_of_seperation,
        'mode_of_seperation_others' => $mode_of_seperation_others,
        'effectivity_date' => $effectivity_date,
        'remarks' => $remarks,
        'hrdo_file' => $hrdo_file_name,
        'valid_id_1' => $valid_id_1_name,
        'valid_id_2' => $valid_id_2_name,
        'up_clearance' => $up_clearance_name,
        'atty_file' => $atty_file_name,
        'authorize_valid_id_1' => $authorize_valid_id_1_name,
        'authorize_valid_id_2' => $authorize_valid_id_2_name,
        'written_request' => $written_request_name,
        'e_signature' => $e_signature_name,
      ]

    );
    if (!empty($benefit_insert_id)) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }

  public function getBenefitApplications(Request $request)
  {
    $columns = [
      0 => 'benefit_applications.id',
      1 => 'benefit_applications.mode_of_seperation',
      2 => 'benefit_applications.effectivity_date',
      3 => 'benefit_applications.remarks',
      4 => 'benefit_applications.date_created',
      5 => 'benefit_applications.status',
    ];

    $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'member_detail.*', 'users.id as user_id', 'old_campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('member_detail', 'member_detail.member_no', '=', 'member.member_no')
      ->leftjoin('old_campus', 'member.campus_id', '=', 'old_campus.id')
      ->first();
    $totalData = BenefitApplications::where('member_no', $member->member_no)->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $searchValue =  $request->input('search.value');

    $mode_of_seperation_select = $request->input('mode_of_seperation_select');
    $status_select = $request->input('status_select');
    $membership_date_from_select = $request->input('membership_date_from_select');
    $membership_date_to_select = $request->input('membership_date_to_select');


    //filter codes
    if (!empty($searchValue)) {

      $benefit_applications = DB::table('benefit_applications')
        ->select(
          'benefit_applications.*',
        )
        ->where('benefit_applications.member_no', '=', $member->member_no)
        ->where('benefit_applications.status', 'like', "%{$searchValue}%")
        ->orWhere('benefit_applications.mode_of_seperation', 'like', "%{$searchValue}%")
        ->orderBy('benefit_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    } else {
      $benefit_applications = DB::table('benefit_applications')
        ->select(
          'benefit_applications.*',
        )
        ->where('benefit_applications.member_no', '=', $member->member_no)
        ->orderBy('benefit_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }

    if (!empty($membership_date_to_select) && !empty($membership_date_from_select)) {
      $benefit_applications = DB::table('benefit_applications')
        ->select(
          'benefit_applications.*',
        )
        ->where('benefit_applications.member_no', '=', $member->member_no)
        ->where('benefit_applications.member_no', '=', $member->member_no)
        ->where('benefit_applications.date_created', '>=',  $membership_date_from_select)
        ->where('benefit_applications.date_created', '<=',  $membership_date_to_select)
        ->orderBy('benefit_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }


    if (!empty($status_select)) {
      $benefit_applications = DB::table('benefit_applications')
        ->select(
          'benefit_applications.*',
        )
        ->where('benefit_applications.member_no', '=', $member->member_no)
        ->where('benefit_applications.member_no', '=', $member->member_no)
        ->where('benefit_applications.status', '=',  $status_select)
        ->orderBy('benefit_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }
    if (!empty($mode_of_seperation_select)) {
      $benefit_applications = DB::table('benefit_applications')
        ->select(
          'benefit_applications.*',
        )
        ->where('benefit_applications.member_no', '=', $member->member_no)
        ->where('benefit_applications.member_no', '=', $member->member_no)
        ->where('benefit_applications.mode_of_seperation', '=',  $mode_of_seperation_select)
        ->orderBy('benefit_applications.date_created', 'desc')
        ->offset($start)
        ->limit($limit)
        ->get();
    }


    $totalFiltered = BenefitApplications::when($searchValue, function ($query) use ($searchValue) {
      $query->where('id', 'like', "%{$searchValue}%")->orWhere('status', 'like', "%{$searchValue}%");
    })->count();

    $data = [];
    foreach ($benefit_applications as $row) {
      $nestedData['date_created'] = $row->date_created;
      $nestedData['member_no'] = $row->member_no;
      $nestedData['remarks'] = $row->remarks;
      $nestedData['effectivity'] = $row->effectivity_date;
      $nestedData['status'] = $row->status;
      $nestedData['mode_of_seperation'] = $row->mode_of_seperation;
      $nestedData['mode_of_seperation_others'] = $row->mode_of_seperation_others;

      $nestedData['action'] = '
      <a href="/admin/loan/loan-application/details/' . $row->id .  '"
          target="_blank" data-md-tooltip="View Loan Details"
          class="view_member md-tooltip--top view-member" 
          style="cursor: pointer">
          <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
      </a>';

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
      $years = OLDMembers::select(DB::raw("YEAR(original_appointment_date) - YEAR(CURDATE()) - (DATE_FORMAT(original_appointment_date,'%m%d') < DATE_FORMAT(CURDATE(),'%m%d')) as years"))
        ->where('user_Id', '=', Auth::user()->id)->get();

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

        'contributions' => $contributions,
        'totalcontributions' => $totalcontributions,
        'outstandingloans' => $outstandingloans,
        'totalloanbalance' => $totalloanbalance,
        'years' => abs($years[0]->years),

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
      $years = OLDMembers::select(DB::raw("YEAR(original_appointment_date) - YEAR(CURDATE()) - (DATE_FORMAT(original_appointment_date,'%m%d') < DATE_FORMAT(CURDATE(),'%m%d')) as years"))
        ->where('user_Id', '=', Auth::user()->id)->get();

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

        'contributions' => $contributions,
        'totalcontributions' => $totalcontributions,
        'outstandingloans' => $outstandingloans,
        'totalloanbalance' => $totalloanbalance,
        'years' => abs($years[0]->years),

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
