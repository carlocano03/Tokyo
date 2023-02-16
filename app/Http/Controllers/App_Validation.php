<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Member;
use App\Models\Campus;
use App\Models\Classification;
use App\Models\College;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\Salarygrade;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\UploadFile;
use DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Storage;
use Mail;
class App_Validation extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
  }

  public function aa_validation_save(Request $request)
    {
      $datadb = DB::transaction(function () use ($request) {
        $inserts = array(
            'app_no' => $request->input('app_no'),
            'pass_name' => $request->input('pass_name'),
            'pass_dob' => $request->input('pass_dob'),
            'pass_gender' => $request->input('pass_gender'),
            'pass_civilstatus' => $request->input('pass_civilstatus'),
            'pass_citizenship' => $request->input('pass_citizenship'),
            'pass_currentadd' => $request->input('pass_currentadd'),
            'pass_permaadd' => $request->input('pass_permaadd'),
            'pass_contactnum' => $request->input('pass_contactnum'),
            'pass_landline' => $request->input('pass_landline'),
            'pass_email' => $request->input('pass_email'),
            'pass_emp_no' => $request->input('pass_emp_no'),
            'pass_campus' => $request->input('pass_campus'),
            'pass_classification' => $request->input('pass_classification'),
            'pass_college_unit' => $request->input('pass_college_unit'),
            'pass_department' => $request->input('pass_department'),
            'pass_rankpos' => $request->input('pass_rankpos'),
            'pass_appointment' => $request->input('pass_appointment'),
            'pass_appointdate' => $request->input('pass_appointdate'),
            'pass_monthlysalary' => $request->input('pass_monthlysalary'),
            'pass_sg' => $request->input('pass_sg'),
            'pass_sgcat' => $request->input('pass_sgcat'),
            'pass_tin_no' => $request->input('pass_tin_no'),
            'pass_monthlycontri' => $request->input('pass_monthlycontri'),
            'pass_equivalent' => $request->input('pass_equivalent'),
            'pass_membershipf' => $request->input('pass_membershipf'),
            'pass_proxyform' => $request->input('pass_proxyform'),
            'remarks_name' => $request->input('remarks_name'),
            'remarks_dob' => $request->input('remarks_dob'),
            'remarks_gender' => $request->input('remarks_gender'),
            'remarks_civilstatus' => $request->input('remarks_civilstatus'),
            'remarks_citizenship' => $request->input('remarks_citizenship'),
            'remarks_currentadd' => $request->input('remarks_currentadd'),
            'remarks_permaadd' => $request->input('remarks_permaadd'),
            'review_contactnum' => $request->input('review_contactnum'),
            'review_landline' => $request->input('review_landline'),
            'remarks_email' => $request->input('remarks_email'),
            'remarks_emp_no' => $request->input('remarks_emp_no'),
            'remarks_campus' => $request->input('remarks_campus'),
            'remarks_classification' => $request->input('remarks_classification'),
            'remarks_college_unit' => $request->input('remarks_college_unit'),
            'remarks_department' => $request->input('remarks_department'),
            'remarks_rankpos' => $request->input('remarks_rankpos'),
            'remarks_appointment' => $request->input('remarks_appointment'),
            'remarks_appointdate' => $request->input('remarks_appointdate'),
            'remarks_monthlysalary' => $request->input('remarks_monthlysalary'),
            'remarks_sg' => $request->input('remarks_sg'),
            'remarks_sgcat' => $request->input('remarks_sgcat'),
            'remarks_tin_no' => $request->input('remarks_tin_no'),
            'remarks_monthlycontri' => $request->input('remarks_monthlycontri'), 
            'remarks_equivalent' => $request->input('remarks_equivalent'), 
            'remarks_membershipf' => $request->input('remarks_membershipf'),            
            'remarks_proxyform' => $request->input('remarks_proxyform'), 
            'general_remarks' => $request->input('general_remarks'), 
            'evaluate_by' => Auth::user()->id
        );
        $last_id = DB::table('aa_validation')->insertGetId($inserts);
        $mem_appinst = array(
          'app_status' => "AA VALIDATED",
        );
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
          ->update($mem_appinst);
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
    }
}
