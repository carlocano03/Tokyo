<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Beneficiaries;
use App\Models\UploadFile;
use DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Storage;
use Mail;

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

  public function add_benefeciaries(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $addBeneficiaries = array(
        'fullname'  => strtoupper($request->input('name')),
        'date_birth' => $request->input('bday'),
        'relationship' => strtoupper($request->input('relation')),
        'personal_id'  => $request->input('employee_no'),
      );
      $dependent = Beneficiaries::where('fullname', strtoupper($request->input('name')));
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
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1:0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $request->input('date_birth'),
          'suffix' => strtoupper($request->input('suffix')),
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
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1:0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $request->input('date_birth'),
          'suffix' => strtoupper($request->input('suffix')),
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
      if ($request->input('perm_add_check') != 1) {
        $inserts = array(
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1:0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => $request->input('date_birth'),
          'suffix' => strtoupper($request->input('suffix')),
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
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1:0,
          'firstname' =>strtoupper($request->input('firstname')),
          'date_birth' => $request->input('date_birth'),
          'suffix' => strtoupper($request->input('suffix')),
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

  public function add_member_p3(Request $request)
  {
    $options = $request->input('percentage_check');
    $form = $request->input('generateForm');
    $coco = $request->file('coco');
    $proxy = $request->file('proxy');
    if ($options != 'percentage') {
      $insertMemDetails = array(
        'contribution_set' => 'Fixed Amount',
        'amount' => $request->input('fixed_amount'),
        'app_no' => $request->input('app_no')
      );
      
      if (!$request->hasFile('coco') && !$request->hasFile('proxy')) { 
        DB::table('membership_details')->insert($insertMemDetails);
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
            ->update(array('app_status' => 'SUBMITTED'));

      } else {
        //Cocolife Form
        $fileName = $request->file('coco')->getClientOriginalName();
        $newName = $request->input('app_no').'_'.$fileName;
        $filePath = 'uploaded_forms/' . $newName;
        $request->file('coco')->storeAs('uploaded_forms', $newName, 'public');
        $insertCoco = array(
          'app_no' => $request->input('app_no'),
          'coco_name' => $newName,
          'coco_path' => $filePath
        );

        //Proxy Form
        $proxyName = $request->file('proxy')->getClientOriginalName();
        $newProxyName = $request->input('app_no').'_'.$proxyName;
        $filePathProxy = 'uploaded_forms/' . $newProxyName;
        $request->file('proxy')->storeAs('uploaded_forms', $newProxyName, 'public');
        $insertProxy = array(
          'app_no' => $request->input('app_no'),
          'form_name' => $newProxyName,
          'path' => $filePathProxy
        );

        DB::table('coco_form')->insert($insertCoco);
        DB::table('proxy_form')->insert($insertProxy);
        DB::table('membership_details')->insert($insertMemDetails);
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
            ->update(array('app_status' => 'SUBMITTED'));
      }
      
    } else {
      $insertMemDetails = array(
        'contribution_set' => 'Percentage of Basic Salary',
        'amount' => $request->input('percent_amt'),
        'percentage' => $request->input('percentage_bsalary'),
        'app_no' => $request->input('app_no')
      );

      if (!$request->hasFile('coco') && !$request->hasFile('proxy')) { 

        DB::table('membership_details')->insert($insertMemDetails);
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
            ->update(array('app_status' => 'SUBMITTED'));

      } else {
        //Cocolife Form
        $fileName = $request->file('coco')->getClientOriginalName();
        $newName = $request->input('app_no').'_'.$fileName;
        $filePath = 'uploaded_forms/' . $newName;
        $request->file('coco')->storeAs('uploaded_forms', $newName, 'public');
        $insertCoco = array(
          'app_no' => $request->input('app_no'),
          'coco_name' => $newName,
          'coco_path' => $filePath
        );

        //Proxy Form
        $proxyName = $request->file('proxy')->getClientOriginalName();
        $newProxyName = $request->input('app_no').'_'.$proxyName;
        $filePathProxy = 'uploaded_forms/' . $newProxyName;
        $request->file('proxy')->storeAs('uploaded_forms', $newProxyName, 'public');
        $insertProxy = array(
          'app_no' => $request->input('app_no'),
          'form_name' => $newProxyName,
          'path' => $filePathProxy
        );

        DB::table('coco_form')->insert($insertCoco);
        DB::table('proxy_form')->insert($insertProxy);
        DB::table('membership_details')->insert($insertMemDetails);
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
            ->update(array('app_status' => 'SUBMITTED'));
      }

      
    }
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
      ->get()->first();
    
      return response()->json($results);
  }

  public function check_sg_bracket(Request $request)
  {
      $query = str_replace(',', '',$request->input('inputValue'));
      $results = DB::table('ref_salarygrade')->select('sg_no')->where('min_bracket','<=', $query)
      ->where('max_bracket','>=', $query)
      ->get()->first();
      // print_r($query);
      return response()->json($results);
  }

  public function add_proxy(Request $request)
  {
    $file = $request->file('file');

    $fileName = $file->getClientOriginalName();
    $newName = $request->input('appNo').'_'.$fileName;
    $path = $file->storeAs('signature', $newName, 'public');

    $signFile['app_no'] = $request->input('appNo');
    $signFile['sign'] = $newName;
    $signFile['sign_path'] = '/storage/'.$path;
    DB::table('member_signature')->insert($signFile);
  }

  public function addcocolife(Request $request)
  {
    $appNumber = $request->input('app_number');
    $coco = DB::table('generated_coco')->where('app_number', $appNumber)->count();

    if ($coco > 0) {
        return response()->json(['message' => 'Exist']);
    }

    if (!$request->hasFile('cocolife_sign')) {
        return response()->json(['message' => 'File not found']);
    }

    $file = $request->file('cocolife_sign');
    $fileName = $file->getClientOriginalName();
    $newName = "{$appNumber}_coco_{$fileName}";
    $path = $file->storeAs('signature', $newName, 'public');

    $insertCoco = [
        'app_number' => $appNumber,
        'place_birth' => $request->input('place_birth'),
        'height' => $request->input('height'),
        'weight' => $request->input('weight'),
        'amt_isurance' => $request->input('amt_isurance'),
        'term_coverage' => $request->input('coverage'),
        'premiums' => $request->input('premiums'),
        'occupation' => $request->input('occupation'),
        'nature_work' => $request->input('nature_work'),
        'seaman' => $request->input('seaman'),
        'ofw' => $request->input('ofw'),
        'exceptions' => $request->input('exception'),
        'sign_path' => $path,
    ];

    DB::table('generated_coco')->insert($insertCoco);

    return response()->json(['message' => 'Success']);
    
  }

  public function update_trail_member_1(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      if ($request->input('perm_add_check') != 1) {
        $inserts = array(
          'lastname' => strtoupper($request->input('lastname')),
          'middlename' => strtoupper($request->input('middlename')),
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1:0,
          'firstname' => strtoupper($request->input('firstname')),
          'date_birth' => date('mm', strtotime($request->input('date_birth'))),
          'suffix' => strtoupper($request->input('suffix')),
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
          'no_middlename' => $request->input('no_middlename') == 'N/A' ? 1:0,
          'firstname' =>strtoupper($request->input('firstname')),
          'date_birth' => $request->input('date_birth'),
          'suffix' => strtoupper($request->input('suffix')),
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

  public function psgc_munc(Request $request)
{
    $codes = $request->input('codes');
    // Perform your database query to get the data based on the $codes variable
    // ...
    // Return the response, for example:
      $results = DB::table('psgc_municipal')->select('*')->whereRaw("code LIKE '$codes%'")->orderBy('name')->get();
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
}