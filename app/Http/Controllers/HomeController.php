<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function add_member(Request $request)
    {
        $datadb = DB::transaction(function () use ($request){
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
            'municipality' => $request->input('municipality'),
            'barangay' => $request->input('barangay'),
            'bldg_street' => $request->input('bldg_street'),
            'zipcode' => $request->input('zipcode'),
            'contact_no' => $request->input('contact_no'),
            'landline_no' => $request->input('landline_no'),
            'email' => $request->input('email'),
          );
          $last_id = DB::table('personal_details')->insertGetId($insertss);
        //   $last_id = (DB::getPdo()->lastInsertId()); 
          $randomString = Str::random(6);
          $mem_appinst = array(
            'app_no' => $randomString,
            'email_address' => $request->input('email'),
            'personal_id' => $last_id,
            'app_status' => 'DRAFT',
          );
          $mem_id = DB::table('mem_app')->insertGetId($mem_appinst);
          return [
            'last_id' => $last_id,
            'randomString' => $randomString,
            'mem_id' => $mem_id
            ];
        });
          return response()->json(['success' => $datadb['last_id'] , 'randomnum' => $datadb['randomString'] , 'mem_id' =>  $datadb['mem_id']]);
    }
    public function add_member_p2(Request $request)
    {
        $datadb = DB::transaction(function () use ($request){
        $insertss = array(
            'campus' => $request->input('campus'),
            'classification' => $request->input('classification'),
            'classification_others' => $request->input('classification_others'),
            'employee_no' => $request->input('employee_no'),
            'college_unit' => $request->input('college_unit'),
            'department' => $request->input('department'),
            'rank_position' => $request->input('rank_position'),
            'date_appointment' => $request->input('date_appointment'),
            'appointment' => $request->input('appointment'),
            'monthly_salary' => $request->input('monthly_salary'),
            'salary_grade' => $request->input('salary_grade'),
            'sg_category' => $request->input('sg_category'),
            'tin_no' => $request->input('tin_no'),
          );
          $last_id = DB::table('employee_details')->insertGetId($insertss);
        //   $last_id = (DB::getPdo()->lastInsertId()); 
          $mem_appinst = array(
            'employee_no' => $request->input('employee_no'),
          );
          DB::table('mem_app')->where('mem_app_ID', $request->input('mem_id'))
          ->update($mem_appinst);

          return [
            'last_id' => $last_id,
            ];
        });
          return response()->json(['success' => 1]);
    }
}
