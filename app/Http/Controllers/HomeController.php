<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Beneficiaries;
use App\Models\BeneficiariesAxa;
use App\Models\UploadFile;
use DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Mail\DemoMail;
use App\Mail\ApplicationMail;
use Illuminate\Support\Facades\Storage;
use Mail;
use Carbon\Carbon;

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
  public function returned_application($id)
  {
    return view('auth.returnedapp');
  }
  public function add_benefeciaries(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $addBeneficiaries = array(
        'fullname'  => strtoupper($request->input('name')),
        'date_birth' => $request->input('bday'),
        'relationship' => strtoupper($request->input('relation')),
        'personal_id'  => $request->input('employee_no'),
      );
      $dependent = Beneficiaries::where('fullname', strtoupper($request->input('name')))
        ->where('personal_id', $request->input('employee_no'))
        ->where('date_birth', $request->input('bday'))
        ->first();
      if ($dependent) {
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

  public function get_beneficiary_axa(Request $request)
  {
    if ($request->ajax()) {
      // $data = Beneficiaries::select('*');
      $empNo = $request->get('employee_no');
      $data = BeneficiariesAxa::where('employee_id', $empNo)
        ->select('*', DB::raw("CONCAT(first_name, ' ', last_name) AS fullname"));
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

  public function add_beneficiary_axa(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $axa_beneficiaries = array(
        'employee_id' => $request->input('employee_no'),
        'first_name' => $request->input('dependent_first_name'),
        'middle_name' => $request->input('dependent_middle_name'),
        'last_name' => $request->input('dependent_last_name'),
        'date_of_bday' => $request->input('bday'),
        'ben_relationship' => $request->input('relationship_tomember'),
        'insured_type' => $request->input('dependent_insurance'),
        'according_rights' => $request->input('dependent_rights'),
      );
      DB::table('axa_beneficiaries')->insert($axa_beneficiaries);
      $message = 'Success';
      return [
        'error' => $message,
      ];
    });
    return response()->json(['success' => $datadb['error']]);
  }

  public function add_member(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $bdyear = $request->input('date_birth_years');
      $bdmonth = $request->input('date_birth_month');
      $bdday = $request->input('date_birth_days');
      // create a date string in the format YYYY-MM-DD
      $dateOfBirth = sprintf('%04d-%02d-%02d', $bdyear, $bdmonth, $bdday);
      if ($request->input('perm_add_check') != 1) {
        $inserts = array(
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1 : 0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $dateOfBirth,
          'suffix' => strtoupper($request->input('suffix')),
          'no_suffix' => $request->input('no_suffix') == 'N/A' ? 1 : 0,
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => strtoupper($request->input('citizenship')),
          'dual_citizenship' => strtoupper($request->input('dual_citizenship')),
          'same_add' => 0,
          'province_code' => $request->input('province'),
          'province' => $request->input('province_name'),
          'municipality_code' => $request->input('municipality'),
          'municipality' => $request->input('municipality_name'),
          'barangay_code' => $request->input('barangay'),
          'barangay' => $request->input('barangay_name'),
          'bldg_street' => strtoupper($request->input('bldg_street')),
          'zipcode' => $request->input('zipcode'),
          'present_province_code' => $request->input('present_province'),
          'present_province' => $request->input('present_province_name'),
          'present_municipality_code' => $request->input('present_municipality'),
          'present_municipality' => $request->input('present_municipality_name'),
          'present_barangay_code' => $request->input('present_barangay'),
          'present_barangay' => $request->input('present_barangay_name'),
          'present_bldg_street' => $request->input('present_bldg_street'),
          'present_zipcode' => $request->input('present_zipcode'),
          'contact_no' => $request->input('contact_no'),
          'landline_no' => $request->input('landline_no'),
          'email' => $request->input('email'),
        );
      } else {
        $inserts = array(
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1 : 0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $dateOfBirth,
          'suffix' => strtoupper($request->input('suffix')),
          'no_suffix' => $request->input('no_suffix') == 'N/A' ? 1 : 0,
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => strtoupper($request->input('citizenship')),
          'dual_citizenship' => strtoupper($request->input('dual_citizenship')),
          'same_add' => 1,
          'province_code' => $request->input('present_province'),
          'province' => $request->input('present_province_name'),
          'municipality_code' => $request->input('present_municipality'),
          'municipality' => $request->input('present_municipality_name'),
          'barangay_code' => $request->input('present_barangay'),
          'barangay' => $request->input('present_barangay_name'),
          'bldg_street' => strtoupper($request->input('present_bldg_street')),
          'zipcode' => $request->input('present_zipcode'),
          'present_province_code' => $request->input('present_province'),
          'present_province' => $request->input('present_province_name'),
          'present_municipality_code' => $request->input('present_municipality'),
          'present_municipality' => $request->input('present_municipality_name'),
          'present_barangay_code' => $request->input('present_barangay'),
          'present_barangay' => $request->input('present_barangay_name'),
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
        'app_status' => 'DRAFT APPLICATION',
      );
      $mem_id = DB::table('mem_app')->insertGetId($mem_appinst);

      $mailData = [
        'title' => 'Member Application Draft',
        'body' => 'Your application is save as draft.',
        'app_no' => $randomString
      ];

      Mail::to($request->input('email'))->send(new DemoMail($mailData));

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
      $bdyear = $request->input('date_birth_years');
      $bdmonth = $request->input('date_birth_month');
      $bdday = $request->input('date_birth_days');
      // create a date string in the format YYYY-MM-DD
      $dateOfBirth = sprintf('%04d-%02d-%02d', $bdyear, $bdmonth, $bdday);
      if ($request->input('perm_add_check') != 1) {
        $inserts = array(
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1 : 0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $dateOfBirth,
          'suffix' => strtoupper($request->input('suffix')),
          'no_suffix' => $request->input('no_suffix') == 'N/A' ? 1 : 0,
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => strtoupper($request->input('citizenship')),
          'dual_citizenship' => strtoupper($request->input('dual_citizenship')),
          'same_add' => 0,
          'province_code' => $request->input('province'),
          'province' => $request->input('province_name'),
          'municipality_code' => $request->input('municipality'),
          'municipality' => $request->input('municipality_name'),
          'barangay_code' => $request->input('barangay'),
          'barangay' => $request->input('barangay_name'),
          'bldg_street' => strtoupper($request->input('bldg_street')),
          'zipcode' => $request->input('zipcode'),
          'present_province_code' => $request->input('present_province'),
          'present_province' => $request->input('present_province_name'),
          'present_municipality_code' => $request->input('present_municipality'),
          'present_municipality' => $request->input('present_municipality_name'),
          'present_barangay_code' => $request->input('present_barangay'),
          'present_barangay' => $request->input('present_barangay_name'),
          'present_bldg_street' => $request->input('present_bldg_street'),
          'present_zipcode' => $request->input('present_zipcode'),
          'contact_no' => $request->input('contact_no'),
          'landline_no' => $request->input('landline_no'),
          'email' => $request->input('email'),
        );
      } else {
        $inserts = array(
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1 : 0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $dateOfBirth,
          'suffix' => strtoupper($request->input('suffix')),
          'no_suffix' => $request->input('no_suffix') == 'N/A' ? 1 : 0,
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => strtoupper($request->input('citizenship')),
          'dual_citizenship' => strtoupper($request->input('dual_citizenship')),
          'same_add' => 1,
          'province_code' => $request->input('present_province'),
          'province' => $request->input('present_province_name'),
          'municipality_code' => $request->input('present_municipality'),
          'municipality' => $request->input('present_municipality_name'),
          'barangay_code' => $request->input('present_barangay'),
          'barangay' => $request->input('present_barangay_name'),
          'bldg_street' => strtoupper($request->input('present_bldg_street')),
          'zipcode' => $request->input('present_zipcode'),
          'present_province_code' => $request->input('present_province'),
          'present_province' => $request->input('present_province_name'),
          'present_municipality_code' => $request->input('present_municipality'),
          'present_municipality' => $request->input('present_municipality_name'),
          'present_barangay_code' => $request->input('present_barangay'),
          'present_barangay' => $request->input('present_barangay_name'),
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
        $appointyear = $request->input('date_appoint_years');
        $appointmonth = $request->input('date_appoint_months');
        $appointday = $request->input('date_appoint_days');
        // create a date string in the format YYYY-MM-DD
        $dateOfappoint = sprintf('%04d-%02d-%02d', $appointyear, $appointmonth, $appointday);
        $inserts = array(
          'campus' => $request->input('campus'),
          'classification' => $request->input('classification'),
          'classification_others' => $request->input('classification_others'),
          'employee_no' => $request->input('employee_no'),
          'college_unit' => $request->input('college_unit'),
          'department' => $request->input('department') === "OTHER" ? null : $request->input('department'),
          'department_others' => $request->input('other_department') === "" ? null : $request->input('other_department'),
          'rank_position' => $request->input('rank_position'),
          'date_appointment' => date('Y-m-d', strtotime($dateOfappoint)),
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
    $datadb = DB::transaction(function () use ($request) {
      $appointyear = $request->input('date_appoint_years');
      $appointmonth = $request->input('date_appoint_months');
      $appointday = $request->input('date_appoint_days');
      // create a date string in the format YYYY-MM-DD
      $dateOfappoint = sprintf('%04d-%02d-%02d', $appointyear, $appointmonth, $appointday);
      $inserts = array(
        'campus' => $request->input('campus'),
        'classification' => $request->input('classification'),
        'classification_others' => $request->input('classification_others'),
        'employee_no' => $request->input('employee_no'),
        'college_unit' => $request->input('college_unit'),
        'department' => $request->input('department'),
        'rank_position' => $request->input('rank_position'),
        'date_appointment' => $dateOfappoint,
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

  public function add_member_p3(Request $request)
  {
    DB::enableQueryLog();

    $options = $request->input('percentage_check');
    $form = $request->input('generateForm');
    $coco = $request->file('coco');
    $proxy = $request->file('proxy');
    if ($options != 'percentage') {
      $insertMemDetails = array(
        'contribution_set' => 'Fixed Amount',
        'amount' =>  str_replace(',', '', $request->input('fixed_amount')),
        'app_no' => $request->input('app_no')
      );
      DB::table('membership_details')->insert($insertMemDetails);
      DB::table('mem_app')->where('app_no', $request->input('app_no'))
        ->update(array('app_status' => 'NEW APPLICATION'));
    } else {
      $insertMemDetails = array(
        'contribution_set' => 'Percentage of Basic Salary',
        'amount' => $request->input('percent_amt'),
        'percentage' => $request->input('percentage_bsalary'),
        'app_no' => $request->input('app_no')
      );
      DB::table('membership_details')->insert($insertMemDetails);
      DB::table('mem_app')->where('app_no', $request->input('app_no'))
        ->update(array('app_status' => 'NEW APPLICATION'));
    }
    $apptrail = array(
      'status_remarks' => "NEW APPLICATION",
      'app_no' => $request->input('app_no'),
      'user_level' => 'AO',
    );
    DB::table('app_trailing')->where('app_no', $request->input('app_no'))
      ->insert($apptrail);

    // $email = DB::table('mem_app')
    //   ->where('app_no', $request->input('app_no'))
    //   ->value('email_address');
    // $mailData = [
    //   'title' => 'Member Application is Submitted',
    //   'body' => 'Your application is Submitted and subject for review.',
    //   'app_no' => $request->input('app_no')
    // ];
    // if (!empty($email)) {
    //   Mail::to($email)->send(new ApplicationMail($mailData));
    // } else {
    //   echo $email;
    // }

    $quries = DB::getQueryLog();

    return response()->json(['success' => $quries]);
  }

  public function delete_beneficiary(Request $request)
  {
    $benID = $request->input('ben_ID');
    Beneficiaries::where('ben_ID', $benID)->delete();
    return response()->json(['success' => 1]);
  }

  public function getCampuses()
  {
    $options = DB::table('campus')->select('campus_key', 'name')->get();
    return response()->json($options);
  }

  public function getClassification()
  {
    $options = DB::table('classification')->select('classification_id', 'classification_name')->where('status', 1)->get();
    return response()->json($options);
  }

  public function getcollege_unit(Request $request)
  {
    $campus_key = $request->input('campus_key');
    $options = DB::table('college_unit')
      ->join('campus', 'college_unit.campus_id', '=', 'campus.id')
      ->select('cu_no', 'college_unit_name')
      ->where('campus_key', $campus_key)
      ->orderBy('college_unit_name', 'asc')
      ->get();
    return response()->json($options);
  }

  public function getdepartment(Request $request)
  {
    $college_id = $request->input('college_id');
    $options = DB::table('department')
      ->join('college_unit', 'college_unit.cu_no', '=', 'department.cu_no')
      ->select('dept_no', 'department_name')
      ->where('department.cu_no', $college_id)
      ->get();
    return response()->json($options);
  }

  public function getappointment()
  {
    $options = DB::table('appointment')->select('appoint_id', 'appointment_name')->where('status_flag', 1)->get();
    return response()->json($options);
  }

  public function getpsgc_prov()
  {
    $psgc_province = DB::table('psgc_province')->orderBy('name')->get();
    return response()->json($psgc_province);
  }


  public function search_app_trail(Request $request)
  {
    $query = $request->input('query');
    $results = DB::table('mem_app')->select('*')->whereRaw("mem_app.app_no = '$query'")
      ->leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->get()->first();

    return response()->json($results);
  }

  public function continued_trail_status(Request $request)
  {
    $query = $request->input('app_trailno');
    $results = DB::table('mem_app')->select('*')->whereRaw("mem_app.app_no = '$query'")
      ->leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'membership_details.app_no', '=', 'mem_app.app_no')
      ->get()->first();

    return response()->json($results);
  }

  public function check_sg_bracket(Request $request)
  {
    $query = str_replace(',', '', $request->input('inputValue'));
    $results = DB::table('ref_salarygrade')->select('sg_no')->where('min_bracket', '<=', $query)
      ->where('max_bracket', '>=', $query)
      ->get()->first();
    // print_r($query);
    return response()->json($results);
  }

  public function add_proxy(Request $request)
  {
    // $file = $request->file('file');

    // $fileName = $file->getClientOriginalName();
    // $newName = $request->input('appNo') . '_' . $fileName;
    // $path = $file->storeAs('signature', $newName, 'public');

    $signFile['app_no'] = $request->input('appNo');
    $signFile['sign'] = $request->input('esig');
    // $signFile['sign_path'] = '/storage/' . $path;
    DB::table('member_signature')->insert($signFile);

    $email = DB::table('mem_app')
      ->where('app_no', $request->input('appNo'))
      ->value('email_address');
    $mailData = [
      'title' => 'Member Application is Submitted',
      'body' => 'Your application is Submitted and subject for review.',
      'app_no' => $request->input('appNo')
    ];
    if (!empty($email)) {
      Mail::to($email)->send(new ApplicationMail($mailData));
    } else {
      echo $email;
    }
  }

  public function addaxa_form(Request $request)
  {
    $appNumber = $request->input('app_number');
    $file = $request->file('esig_axa');
    if ($file) {
      $fileName = $file->getClientOriginalName();
      $newName = $request->input('app_number') . '_' . $fileName;
      $path = $file->storeAs('signature', $newName, 'public');
    } else {
      // Handle the case where no file was uploaded
      $path = null;
    }

    $insertCoco = [
      'app_no' => $appNumber,
      'personal_id' => $request->input('personnel_id'),
      'place_birth' => strtoupper($request->input('place_birth')),
      'emp_union_assoc' => strtoupper($request->input('emp_union_assoc')),
      'occupation' => strtoupper($request->input('occupation')),
      'sss_gsis' => $request->input('sss_gsis'),
      'spouse_name' => strtoupper($request->input('spouse_name')),
      'maiden_name' => strtoupper($request->input('maiden_name')),
      'insuted_type' => $request->input('insuted_type'),
      'last_name' => strtoupper($request->input('last_name')),
      'first_name' => strtoupper($request->input('first_name')),
      'middle_name' => strtoupper($request->input('middle_name')),
      'relationship_tomember' => strtoupper($request->input('relationship_tomember')),
      'contact_no' => $request->input('axa_contact_no'),
      'email_add' => $request->input('email_add'),
      'signature' => '/storage/' . $path
    ];
    DB::table('axa_form')->insert($insertCoco);
    // $coco = DB::table('member_signature')->where('app_no', $appNumber)->count();
    // $axa_exist = DB::table('axa_form')->where('app_no', $appNumber)->count();
    // if($axa_exist > 0){
    //   return response()->json(['message' => 'Exist']);
    // }else{
    // if ($coco > 0) {
    //   $insertCoco = [
    //     'app_no' => $appNumber,
    //     'personal_id' => $request->input('personnel_id'),
    //     'place_birth' => strtoupper($request->input('place_birth')),
    //     'emp_union_assoc' => strtoupper($request->input('emp_union_assoc')),
    //     'occupation' => strtoupper($request->input('occupation')),
    //     'sss_gsis' => $request->input('sss_gsis'),
    //     'spouse_name' => strtoupper($request->input('spouse_name')),
    //     'maiden_name' => strtoupper($request->input('maiden_name')),
    //     'insuted_type' => $request->input('insuted_type'),
    //     'last_name' => strtoupper($request->input('last_name')),
    //     'first_name' => strtoupper($request->input('first_name')),
    //     'middle_name' => strtoupper($request->input('middle_name')),
    //     'relationship_tomember' => strtoupper($request->input('relationship_tomember')),
    //     'contact_no' => $request->input('axa_contact_no'),
    //     'email_add' => $request->input('email_add'),
    //   ];
    //   DB::table('axa_form')->insert($insertCoco);
    // }else{
    //   $signFile['app_no'] = $appNumber;
    //   $signFile['sign'] = strtoupper($request->input('e_sig'));
    //   DB::table('member_signature')->insert($signFile);
    //   $insertCoco = [
    //     'app_no' => $appNumber,
    //     'personal_id' => $request->input('personnel_id'),
    //     'place_birth' => strtoupper($request->input('place_birth')),
    //     'emp_union_assoc' => strtoupper($request->input('emp_union_assoc')),
    //     'occupation' => strtoupper($request->input('occupation')),
    //     'sss_gsis' => $request->input('sss_gsis'),
    //     'spouse_name' => strtoupper($request->input('spouse_name')),
    //     'maiden_name' => strtoupper($request->input('maiden_name')),
    //     'insuted_type' => $request->input('insuted_type'),
    //     'last_name' => strtoupper($request->input('last_name')),
    //     'first_name' => strtoupper($request->input('first_name')),
    //     'middle_name' => strtoupper($request->input('middle_name')),
    //     'relationship_tomember' => strtoupper($request->input('relationship_tomember')),
    //     'contact_no' => $request->input('axacontact_no'),
    //     'email_add' => $request->input('email_add'),
    //   ];
    //   DB::table('axa_form')->insert($insertCoco);
    // }
    // }

    return response()->json(['message' => 'Success']);
  }

  public function update_trail_member_1(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $bdyear = $request->input('date_birth_years');
      $bdmonth = $request->input('date_birth_month');
      $bdday = $request->input('date_birth_days');
      // create a date string in the format YYYY-MM-DD
      $dateOfBirth = sprintf('%04d-%02d-%02d', $bdyear, $bdmonth, $bdday);

      $appointyear = $request->input('date_appoint_years');
      $appointmonth = $request->input('date_appoint_months');
      $appointday = $request->input('date_appoint_days');
      // create a date string in the format YYYY-MM-DD
      $dateOfappoint = sprintf('%04d-%02d-%02d', $appointyear, $appointmonth, $appointday);
      if ($request->input('perm_add_check') != 1) {
        $inserts = array(
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1 : 0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $dateOfBirth,
          'suffix' => strtoupper($request->input('suffix')),
          'no_suffix' => $request->input('no_suffix') == 'N/A' ? 1 : 0,
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => strtoupper($request->input('citizenship')),
          'dual_citizenship' => strtoupper($request->input('dual_citizenship')),
          'same_add' => 0,
          'province_code' => $request->input('province'),
          'province' => $request->input('province_name'),
          'municipality_code' => $request->input('municipality'),
          'municipality' => $request->input('municipality_name'),
          'barangay_code' => $request->input('barangay'),
          'barangay' => $request->input('barangay_name'),
          'bldg_street' => strtoupper($request->input('bldg_street')),
          'zipcode' => $request->input('zipcode'),
          'present_province_code' => $request->input('present_province'),
          'present_province' => $request->input('present_province_name'),
          'present_municipality_code' => $request->input('present_municipality'),
          'present_municipality' => $request->input('present_municipality_name'),
          'present_barangay_code' => $request->input('present_barangay'),
          'present_barangay' => $request->input('present_barangay_name'),
          'present_bldg_street' => $request->input('present_bldg_street'),
          'present_zipcode' => $request->input('present_zipcode'),
          'contact_no' => $request->input('contact_no'),
          'landline_no' => $request->input('landline_no'),
          'email' => $request->input('email'),
        );
      } else {
        $inserts = array(
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1 : 0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $dateOfBirth,
          'suffix' => strtoupper($request->input('suffix')),
          'no_suffix' => $request->input('no_suffix') == 'N/A' ? 1 : 0,
          'gender' => $request->input('gender'),
          'civilstatus' => $request->input('civilstatus'),
          'citizenship' => strtoupper($request->input('citizenship')),
          'dual_citizenship' => strtoupper($request->input('dual_citizenship')),
          'same_add' => 1,
          'province_code' => $request->input('present_province'),
          'province' => $request->input('present_province_name'),
          'municipality_code' => $request->input('present_municipality'),
          'municipality' => $request->input('present_municipality_name'),
          'barangay_code' => $request->input('present_barangay'),
          'barangay' => $request->input('present_barangay_name'),
          'bldg_street' => strtoupper($request->input('present_bldg_street')),
          'zipcode' => $request->input('present_zipcode'),
          'present_province_code' => $request->input('present_province'),
          'present_province' => $request->input('present_province_name'),
          'present_municipality_code' => $request->input('present_municipality'),
          'present_municipality' => $request->input('present_municipality_name'),
          'present_barangay_code' => $request->input('present_barangay'),
          'present_barangay' => $request->input('present_barangay_name'),
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
  public function update_trail_member_2(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $appointyear = $request->input('date_appoint_years');
      $appointmonth = $request->input('date_appoint_months');
      $appointday = $request->input('date_appoint_days');
      // create a date string in the format YYYY-MM-DD
      $dateOfappoint = sprintf('%04d-%02d-%02d', $appointyear, $appointmonth, $appointday);
      $inserts = array(
        'campus' => $request->input('campus'),
        'classification' => $request->input('classification'),
        'classification_others' => $request->input('classification_others'),
        'employee_no' => $request->input('employee_no'),
        'college_unit' => $request->input('college_unit'),
        'department' => $request->input('department'),
        'rank_position' => $request->input('rank_position'),
        'date_appointment' => $dateOfappoint,
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

  public function psgc_munc(Request $request)
  {
    $codes = $request->input('codes');
    // Perform your database query to get the data based on the $codes variable
    // ...
    // Return the response, for example:
    if ($codes == 1339) {
      $results = DB::table('psgc_municipal')->select('*')->whereRaw("code LIKE '1339%' OR code LIKE '1374%' OR code LIKE '1375%' OR code LIKE '1376%'")->orderBy('name')->get();
    } else {
      $results = DB::table('psgc_municipal')->select('*')->whereRaw("code LIKE '$codes%'")->orderBy('name')->get();
    }

    return response()->json(['data' => $results]);
  }
  public function psgc_brgy(Request $request)
  {
    $codes = $request->input('codes');
    // Perform your database query to get the data based on the $codes variable
    // ...
    // Return the response, for example:
    $results = DB::table('psgc_brgy')->select('*')->whereRaw("code LIKE '$codes%'")->orderBy('name')->get();
    return response()->json(['data' => $results]);
  }
  public function save_draft_step3(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $options = $request->input('percentage_check');
      $couuunt = DB::table('membership_details')->where('app_no', $request->input('app_no'))->count();

      if ($couuunt > 0) {
        if ($options != 'percentage') {
          $insertMemDetails = array(
            'contribution_set' => 'Fixed Amount',
            'amount' =>  str_replace(',', '', $request->input('fixed_amount')),
            'app_no' => $request->input('app_no')
          );
          $last_id = DB::table('membership_details')->where('app_no', $request->input('app_no'))->update($insertMemDetails);
        } else {
          $insertMemDetails = array(
            'contribution_set' => 'Percentage of Basic Salary',
            'amount' => $request->input('percent_amt'),
            'percentage' => $request->input('percentage_bsalary'),
            'app_no' => $request->input('app_no')
          );
          $last_id = DB::table('membership_details')->where('app_no', $request->input('app_no'))->update($insertMemDetails);
        }
      } else {
        if ($options != 'percentage') {
          $insertMemDetails = array(
            'contribution_set' => 'Fixed Amount',
            'amount' =>  str_replace(',', '', $request->input('fixed_amount')),
            'app_no' => $request->input('app_no'),
            'percentage' => '',
          );
          $last_id = DB::table('membership_details')->insert($insertMemDetails);
        } else {
          $insertMemDetails = array(
            'contribution_set' => 'Percentage of Basic Salary',
            'amount' => $request->input('percent_amt'),
            'percentage' => $request->input('percentage_bsalary'),
            'app_no' => $request->input('app_no')
          );
          $last_id = DB::table('membership_details')->insert($insertMemDetails);
        }
      }

      //  DB::table('membership_details')->insertGetId($inserts);
      //   $last_id = (DB::getPdo()->lastInsertId()); 
      return [
        'last_id' => $last_id
      ];
    });
    return response()->json(['success' => $datadb['last_id']]);
  }

  public function update_employee(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $appointyear = $request->input('date_appoint_years');
      $appointmonth = $request->input('date_appoint_months');
      $appointday = $request->input('date_appoint_days');
      // create a date string in the format YYYY-MM-DD
      $dateOfappoint = sprintf('%04d-%02d-%02d', $appointyear, $appointmonth, $appointday);

      $update = array(
        'employee_no' => $request->input('emp_no'),
        'campus' => $request->input('campus'),
        'classification' => $request->input('classification'),
        'college_unit' => $request->input('college_unit'),
        'department' => $request->input('department'),
        'rank_position' => $request->input('rank_position'),
        'date_appointment' => date('Y-m-d', strtotime($dateOfappoint)),
        'appointment' => $request->input('appointment'),
        'monthly_salary' => str_replace(',', '', $request->input('monthly_salary')),
        'salary_grade' => $request->input('salary_grade'),
        'sg_category' => $request->input('sg_category'),
        'tin_no' => $request->input('tin_no'),
      );
      DB::table('employee_details')->where('employee_details_ID', $request->input('employee_details_id'))
        ->update($update);
      $mem_appinst = array(
        'employee_no' => $request->input('emp_no'),
      );
      DB::table('mem_app')->where('mem_app_ID', $request->input('mem_app_id'))
        ->update($mem_appinst);
      return [
        'emp_no' => $request->input('emp_no'),
      ];
    });
    return response()->json(['success' => $datadb['emp_no']]);
  }
}
