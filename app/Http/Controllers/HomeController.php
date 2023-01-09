<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Member;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function add_member(Request $request)
    {
        $insertss = array(
            'lastname' => $request->input('lastname'),
            'middlename' => $request->input('middlename'),
            'firstname' => $request->input('firstname'),
            'date_birth' => $request->input('date_birth'),
            'suffix' => $request->input('suffix'),
            'gender' => $request->input('gender'),
            'civilstatus' => $request->input('civilstatus'),
            'citizenship' => $request->input('citizenship'),
            'province' => $request->input('province'),
            'city' => $request->input('city'),
            'barangay' => $request->input('barangay'),
            'bldg_street' => $request->input('bldg_street'),
            'zipcode' => $request->input('zipcode'),
            'contact_no' => $request->input('contact_no'),
            'landline_no' => $request->input('landline_no'),
            'email' => $request->input('email'),
          );
          DB::table('personal_details')->insert($insertss);
          $message = (DB::getPdo()->lastInsertId()); 
          $output = array(
            'message' => $message,
          );
          echo json_encode($output);
    }
}
