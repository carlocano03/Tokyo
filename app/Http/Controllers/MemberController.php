<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
      return view('member.dashboard');
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
      return view('member.loan_application.calculator');
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
    if (Auth::check()) {
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
}
