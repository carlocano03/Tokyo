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

  public function transactions()
  {
    return view('member.transaction');
  }
  public function loan()
  {
    return view('member.loan');
  }

  public function member()
  {
    return view('member.member');
  }

}
