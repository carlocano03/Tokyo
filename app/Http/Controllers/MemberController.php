<?php

namespace App\Http\Controllers;


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
    return view('member.dashboard');
  }

  public function settings()
  {
    return view('member.settings');
  }

  public function transaction()
  {
    return view('member.transaction');
  }
  public function loan()
  {
    return view('member.loan_application.index');
  }

  public function new_loan()
  {
    return view('member.loan_application.new_loan');
  }

  public function member()
  {
    return view('member.member');
  }

  public function equity()
  {
    return view('member.equity');
  }

  public function updatepassword()
  {
    return view('member.updatepassword');
  }

  public function calculator()
  {
    return view('member.loan_application.calculator');
  }

  public function schedule()
  {
    return view('member.loan_application.schedule');
  }
  
}
