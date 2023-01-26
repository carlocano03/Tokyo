<?php

namespace App\Http\Controllers;
use App\Admin;
use App\User;
use App\Campus;
use App\Member;
use App\Tempass;
use App\LoanTransaction;
use App\ContributionTransaction;
use Auth;
use Hash;
use DB;
use PDF;
use Excel;
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
      if($loginNew){
        $lastLogin = $loginNew->login_date;
      }
    } else {
      $login = DB::table('login_logs')
              ->where('user_id', Auth::user()->id)
              ->orderBy('login_date', 'DESC')
              ->skip(1)
              ->first();
      if($login){
        $lastLogin = $login->login_date;
      }
    }
    
    $campuses = DB::table('campus')->get();
    $data = array(
      'login' => $lastLogin,
      'campuses' => $campuses,
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

  public function settings()
  {
    return view('admin.settings');
  }

  public function members_records()
  {
    return view('admin.members.records');
  }

}
