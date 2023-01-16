<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Beneficiaries;
use DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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

  // public function add_member(Request $request)
  // {
  //     $datadb = DB::transaction(function () use ($request){
  //     $insertss = array(
  //         'lastname' => $request->input('lastname'),
  //         'middlename' => $request->input('middlename'),
  //         'firstname' => $request->input('firstname'),
  //         'date_birth' => $request->input('date_birth'),
  //         'suffix' => $request->input('suffix'),
  //         'gender' => $request->input('gender'),
  //         'civilstatus' => $request->input('civilstatus'),
  //         'citizenship' => $request->input('citizenship'),
  //         'province' => $request->input('province'),
  //         'municipality' => $request->input('municipality'),
  //         'barangay' => $request->input('barangay'),
  //         'bldg_street' => $request->input('bldg_street'),
  //         'zipcode' => $request->input('zipcode'),
  //         'contact_no' => $request->input('contact_no'),
  //         'landline_no' => $request->input('landline_no'),
  //         'email' => $request->input('email'),
  //       );
  //       $last_id = DB::table('personal_details')->insertGetId($insertss);
  //     //   $last_id = (DB::getPdo()->lastInsertId()); 
  //       $randomString = Str::random(6);
  //       $mem_appinst = array(
  //         'app_no' => $randomString,
  //         'email_address' => $request->input('email'),
  //         'personal_id' => $last_id,
  //         'app_status' => 'DRAFT',
  //       );
  //       $mem_id = DB::table('mem_app')->insertGetId($mem_appinst);
  //       return [
  //         'last_id' => $last_id,
  //         'randomString' => $randomString,
  //         'mem_id' => $mem_id
  //         ];
  //     });
  //       return response()->json(['success' => $datadb['last_id'] , 'randomnum' => $datadb['randomString'] , 'mem_id' =>  $datadb['mem_id']]);
  // }
  // public function add_member_p2(Request $request)
  // {
  //     $datadb = DB::transaction(function () use ($request){
  //     $insertss = array(
  //         'campus' => $request->input('campus'),
  //         'classification' => $request->input('classification'),
  //         'classification_others' => $request->input('classification_others'),
  //         'employee_no' => $request->input('employee_no'),
  //         'college_unit' => $request->input('college_unit'),
  //         'department' => $request->input('department'),
  //         'rank_position' => $request->input('rank_position'),
  //         'date_appointment' => $request->input('date_appointment'),
  //         'appointment' => $request->input('appointment'),
  //         'monthly_salary' => $request->input('monthly_salary'),
  //         'salary_grade' => $request->input('salary_grade'),
  //         'sg_category' => $request->input('sg_category'),
  //         'tin_no' => $request->input('tin_no'),
  //       );
  //       $last_id = DB::table('employee_details')->insertGetId($insertss);
  //     //   $last_id = (DB::getPdo()->lastInsertId()); 
  //       $mem_appinst = array(
  //         'employee_no' => $request->input('employee_no'),
  //       );
  //       DB::table('mem_app')->where('mem_app_ID', $request->input('mem_id'))
  //       ->update($mem_appinst);



  public function add_benefeciaries(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $addBeneficiaries = array(
        'fullname'  => $request->input('name'),
        'date_birth' => $request->input('bday'),
        'relationship' => $request->input('relation'),
        'personal_id'  => $request->input('employee_no'),
      );
      $dependent = Beneficiaries::where('fullname', $request->input('name'));
      if ($dependent->first()) {
        $message = 'Exists';
      } else {
        DB::table('beneficiaries')->insert($addBeneficiaries);
        $message = 'Success';
      }
      return [
        'error' => $message,
      ];
    });
    return response()->json(['success' => $datadb['error']]);
  }

  public function get_beneficiary(Request $request)
  {
    if ($request->ajax()) {
      // $data = Beneficiaries::select('*');
      $empNo = $request->get('employee_no');
      $data = Beneficiaries::where('personal_id', $empNo)->select('*');
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
          $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm delete" id="' . $row->ben_ID . '">Remove</a>';
          return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
  }

  public function add_member(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      if ($request->input('perm_add_check') != 1) {
        $inserts = array(
          'lastname' => $request->input('lastname'),
          'middlename' => $request->input('middlename'),
          'firstname' => $request->input('firstname'),
          'date_birth' => $request->input('date_birth'),
          'suffix' => $request->input('suffix'),
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => $request->input('citizenship'),
          'dual_citizenship' => $request->input('dual_citizenship'),
          'province' => $request->input('province'),
          'municipality' => $request->input('municipality'),
          'barangay' => $request->input('barangay'),
          'bldg_street' => $request->input('bldg_street'),
          'zipcode' => $request->input('zipcode'),
          'present_province' => $request->input('present_province'),
          'present_municipality' => $request->input('present_municipality'),
          'present_barangay' => $request->input('present_barangay'),
          'present_bldg_street' => $request->input('present_bldg_street'),
          'present_zipcode' => $request->input('present_zipcode'),
          'contact_no' => $request->input('contact_no'),
          'landline_no' => $request->input('landline_no'),
          'email' => $request->input('email'),
        );
      } else {
        $inserts = array(
          'lastname' => $request->input('lastname'),
          'middlename' => $request->input('middlename'),
          'firstname' => $request->input('firstname'),
          'date_birth' => $request->input('date_birth'),
          'suffix' => $request->input('suffix'),
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => $request->input('citizenship'),
          'dual_citizenship' => $request->input('dual_citizenship'),
          'province' => $request->input('province'),
          'municipality' => $request->input('municipality'),
          'barangay' => $request->input('barangay'),
          'bldg_street' => $request->input('bldg_street'),
          'zipcode' => $request->input('zipcode'),
          'present_province' => $request->input('present_province'),
          'present_municipality' => $request->input('present_municipality'),
          'present_barangay' => $request->input('present_barangay'),
          'present_bldg_street' => $request->input('present_bldg_street'),
          'present_zipcode' => $request->input('present_zipcode'),
          'contact_no' => $request->input('contact_no'),
          'landline_no' => $request->input('landline_no'),
          'email' => $request->input('email'),
        );
      }

      $last_id = DB::table('personal_details')->insertGetId($inserts);

      //Application Number
      $id = IdGenerator::generate(['table' => 'mem_app', 'field' => 'app_no', 'length' => 9, 'prefix' => date('Y-')]);
      // $randomString = Str::random(6);
      $randomString = $id;
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
    return response()->json(['success' => $datadb['last_id'], 'randomnum' => $datadb['randomString'], 'mem_id' =>  $datadb['mem_id']]);
  }
  public function add_member_update1(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      if ($request->input('perm_add_check') != 1) {
        $inserts = array(
          'lastname' => $request->input('lastname'),
          'middlename' => $request->input('middlename'),
          'firstname' => $request->input('firstname'),
          'date_birth' => $request->input('date_birth'),
          'suffix' => $request->input('suffix'),
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => $request->input('citizenship'),
          'dual_citizenship' => $request->input('dual_citizenship'),
          'province' => $request->input('province'),
          'municipality' => $request->input('municipality'),
          'barangay' => $request->input('barangay'),
          'bldg_street' => $request->input('bldg_street'),
          'zipcode' => $request->input('zipcode'),
          'present_province' => $request->input('present_province'),
          'present_municipality' => $request->input('present_municipality'),
          'present_barangay' => $request->input('present_barangay'),
          'present_bldg_street' => $request->input('present_bldg_street'),
          'present_zipcode' => $request->input('present_zipcode'),
          'contact_no' => $request->input('contact_no'),
          'landline_no' => $request->input('landline_no'),
          'email' => $request->input('email'),
        );
      } else {
        $inserts = array(
          'lastname' => $request->input('lastname'),
          'middlename' => $request->input('middlename'),
          'firstname' => $request->input('firstname'),
          'date_birth' => $request->input('date_birth'),
          'suffix' => $request->input('suffix'),
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => $request->input('citizenship'),
          'dual_citizenship' => $request->input('dual_citizenship'),
          'province' => $request->input('present_province'),
          'municipality' => $request->input('present_municipality'),
          'barangay' => $request->input('present_barangay'),
          'bldg_street' => $request->input('present_bldg_street'),
          'zipcode' => $request->input('present_zipcode'),
          'present_province' => $request->input('present_province'),
          'present_municipality' => $request->input('present_municipality'),
          'present_barangay' => $request->input('present_barangay'),
          'present_bldg_street' => $request->input('present_bldg_street'),
          'present_zipcode' => $request->input('present_zipcode'),
          'contact_no' => $request->input('contact_no'),
          'landline_no' => $request->input('landline_no'),
          'email' => $request->input('email'),
        );
      }

      DB::table('personal_details')->where('personal_id', $request->input('personnel_id'))
        ->update($inserts);

      return [
        'last_id' => $request->input('personnel_id'),
        'mem_id' => $request->input('mem_id'),
      ];
    });
    return response()->json(['success' => $datadb['last_id'], 'mem_id' => $datadb['mem_id']]);
  }
  public function add_member_p2(Request $request)
  {
    $employee = DB::table('employee_details')->where('employee_no', $request->input('employee_no'))->first();
    if ($employee) {
      return response()->json(['success' => '']);
    } else {
      $datadb = DB::transaction(function () use ($request) {
        $inserts = array(
          'campus' => $request->input('campus'),
          'classification' => $request->input('classification'),
          'classification_others' => $request->input('classification_others'),
          'employee_no' => $request->input('employee_no'),
          'college_unit' => $request->input('college_unit'),
          'department' => $request->input('department'),
          'rank_position' => $request->input('rank_position'),
          'date_appointment' => $request->input('date_appointment'),
          'appointment' => $request->input('appointment'),
          'monthly_salary' => str_replace(',', '', $request->input('monthly_salary')),
          'salary_grade' => $request->input('salary_grade'),
          'sg_category' => $request->input('sg_category'),
          'tin_no' => $request->input('tin_no'),
        );
        $last_id = DB::table('employee_details')->insertGetId($inserts);
        //   $last_id = (DB::getPdo()->lastInsertId()); 
        //   $last_id = (DB::getPdo()->lastInsertId()); 
        //   $last_id = (DB::getPdo()->lastInsertId()); 
        $mem_appinst = array(
          'employee_no' => $request->input('employee_no'),
        );
        DB::table('mem_app')->where('mem_app_ID', $request->input('mem_id'))
          ->update($mem_appinst);
        return [
          'last_id' => $last_id,
          'emp_no' => $request->input('employee_no'),
        ];
      });
      return response()->json(['success' => $datadb['last_id'], 'emp_no' => $datadb['emp_no']]);
    }
  }

  public function add_member_up_p2(Request $request)
  {
    $employee = DB::table('employee_details')->where('employee_no', $request->input('employee_no'))->first();
    if ($employee) {
      return response()->json(['success' => '']);
    } else {
      $datadb = DB::transaction(function () use ($request) {
        $inserts = array(
          'campus' => $request->input('campus'),
          'classification' => $request->input('classification'),
          'classification_others' => $request->input('classification_others'),
          'employee_no' => $request->input('employee_no'),
          'college_unit' => $request->input('college_unit'),
          'department' => $request->input('department'),
          'rank_position' => $request->input('rank_position'),
          'date_appointment' => $request->input('date_appointment'),
          'appointment' => $request->input('appointment'),
          'monthly_salary' => str_replace(',', '', $request->input('monthly_salary')),
          'salary_grade' => $request->input('salary_grade'),
          'sg_category' => $request->input('sg_category'),
          'tin_no' => $request->input('tin_no'),
        );
        DB::table('employee_details')->where('employee_details_ID', $request->input('employee_details_ID'))
          ->update($inserts);
        //   $last_id = (DB::getPdo()->lastInsertId()); 
        $mem_appinst = array(
          'employee_no' => $request->input('employee_no'),
        );
        DB::table('mem_app')->where('mem_app_ID', $request->input('mem_id'))
          ->update($mem_appinst);
        return [
          'last_id' => $request->input('employee_details_ID'),
          'emp_no' => $request->input('employee_no'),
        ];
      });
      return response()->json(['success' => $datadb['last_id'], 'emp_no' => $datadb['emp_no']]);
    }
  }

  public function add_member_p3(Request $request)
  {

    $datadb = DB::transaction(function () use ($request) {
      $percentage = $request->input('percentage_check');
      if ($percentage != 'percentage') {
        $inertMemDetails = array(
          'contribution_set' => 'Fixed Amount',
          'amount' => $request->input('fixed_amount'),
          'app_no' => $request->input('reference_no'),
        );
        if ($request->hasfile('files')) {
          foreach ($request->file('files') as $key => $file) {
            $path = $file->store('public/uploaded_forms');
            $name = $file->getClientOriginalName();
            $insertFile[$key]['app_no'] = $request->input('reference_no');
            $insertFile[$key]['form_name'] = $name;
            $insertFile[$key]['path'] = $path;
          }
        }
      } else {
        $inertMemDetails = array(
          'contribution_set' => 'Percentage of Basic Salary',
          'amount' => $request->input('total_amount'),
          'percentage' => $request->input('percentage_bsalary'),
          'app_no' => $request->input('reference_no'),
        );
      } 
      DB::table('membership_details')->insert($inertMemDetails);
      DB::table('uploaded_forms')->insert($insertFile);
    });
    return response()->json(['success' => 1]);
  }

  public function delete_beneficiary(Request $request)
  {
    $benID = $request->input('ben_ID');
    Beneficiaries::where('ben_ID', $benID)->delete();
    return response()->json(['success' => 1]);
  }
}
