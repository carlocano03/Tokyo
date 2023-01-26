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
    // $user = User::find(Auth::user()->id);
    $login = DB::table('login_logs')
              ->where('user_id', Auth::user()->id)
              ->orderBy('log_id', 'DESC')
              ->first();
    $data = array(
      'login' => $login
    );

    return view('admin.dashboard')->with($data);
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
