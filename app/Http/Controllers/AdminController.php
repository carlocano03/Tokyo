<?php

namespace App\Http\Controllers;


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
  public function index()
  {
    return view('admin.dashboard');
  }


}
