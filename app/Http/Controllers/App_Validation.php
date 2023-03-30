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
use App\Mail\returnaaMail;
use App\Mail\rejectedMail;
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
        $coco = DB::table('aa_validation')->where('app_no', $request->input('app_no'))->count();
        if ($coco > 0) {
          // return response()->json(['message' => 'Exist']);
          $inserts = array(
            'app_no' => $request->input('app_no'),
            'pass_name' => $request->input('pass_name') ?? 0,
            'pass_dob' => $request->input('pass_dob') ?? 0,
            'pass_gender' => $request->input('pass_gender') ?? 0,
            'pass_civilstatus' => $request->input('pass_civilstatus') ?? 0,
            'pass_citizenship' => $request->input('pass_citizenship') ?? 0,
            'pass_currentadd' => $request->input('pass_currentadd') ?? 0,
            'pass_permaadd' => $request->input('pass_permaadd') ?? 0,
            'pass_contactnum' => $request->input('pass_contactnum') ?? 0,
            'pass_landline' => $request->input('pass_landline') ?? 0,
            'pass_email' => $request->input('pass_email') ?? 0,
            'pass_emp_no' => $request->input('pass_emp_no') ?? 0,
            'pass_campus' => $request->input('pass_campus') ?? 0,
            'pass_classification' => $request->input('pass_classification') ?? 0,
            'pass_college_unit' => $request->input('pass_college_unit') ?? 0,
            'pass_department' => $request->input('pass_department') ?? 0,
            'pass_rankpos' => $request->input('pass_rankpos') ?? 0,
            'pass_appointment' => $request->input('pass_appointment') ?? 0,
            'pass_appointdate' => $request->input('pass_appointdate') ?? 0,
            'pass_monthlysalary' => $request->input('pass_monthlysalary') ?? 0,
            'pass_sg' => $request->input('pass_sg') ?? 0,
            'pass_sgcat' => $request->input('pass_sgcat') ?? 0,
            'pass_tin_no' => $request->input('pass_tin_no') ?? 0,
            'pass_monthlycontri' => $request->input('pass_monthlycontri') ?? 0,
            'pass_equivalent' => $request->input('pass_equivalent') ?? 0,
            'pass_membershipf' => $request->input('pass_membershipf') ?? 0,
            'pass_proxyform' => $request->input('pass_proxyform') ?? 0,
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
         $last_id = DB::table('aa_validation')->where('app_no', $request->input('app_no'))
        ->update($inserts);
        }else{
          $inserts = array(
            'app_no' => $request->input('app_no'),
            'pass_name' => $request->input('pass_name') ?? 0,
            'pass_dob' => $request->input('pass_dob') ?? 0,
            'pass_gender' => $request->input('pass_gender') ?? 0,
            'pass_civilstatus' => $request->input('pass_civilstatus') ?? 0,
            'pass_citizenship' => $request->input('pass_citizenship') ?? 0,
            'pass_currentadd' => $request->input('pass_currentadd') ?? 0,
            'pass_permaadd' => $request->input('pass_permaadd') ?? 0,
            'pass_contactnum' => $request->input('pass_contactnum') ?? 0,
            'pass_landline' => $request->input('pass_landline') ?? 0,
            'pass_email' => $request->input('pass_email') ?? 0,
            'pass_emp_no' => $request->input('pass_emp_no') ?? 0,
            'pass_campus' => $request->input('pass_campus') ?? 0,
            'pass_classification' => $request->input('pass_classification') ?? 0,
            'pass_college_unit' => $request->input('pass_college_unit') ?? 0,
            'pass_department' => $request->input('pass_department') ?? 0,
            'pass_rankpos' => $request->input('pass_rankpos') ?? 0,
            'pass_appointment' => $request->input('pass_appointment') ?? 0,
            'pass_appointdate' => $request->input('pass_appointdate') ?? 0,
            'pass_monthlysalary' => $request->input('pass_monthlysalary') ?? 0,
            'pass_sg' => $request->input('pass_sg') ?? 0,
            'pass_sgcat' => $request->input('pass_sgcat') ?? 0,
            'pass_tin_no' => $request->input('pass_tin_no') ?? 0,
            'pass_monthlycontri' => $request->input('pass_monthlycontri') ?? 0,
            'pass_equivalent' => $request->input('pass_equivalent') ?? 0,
            'pass_membershipf' => $request->input('pass_membershipf') ?? 0,
            'pass_proxyform' => $request->input('pass_proxyform') ?? 0,
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
        }
        
        $mem_appinst = array(
          'validator_remarks' => "AO VERIFIED",
          'aa_cfm_user' => Auth::user()->id,
        );
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
          ->update($mem_appinst);
      $appcount = DB::table('app_trailing')->where('app_no', $request->input('app_no'))->count();
      if($appcount > 0){
        $apptrail = array(
          'status_remarks' => "AO - VERIFIED",
          'app_no' => $request->input('app_no'),
          'updateby' => Auth::user()->id,
          'user_level' => Auth::user()->user_level,
        );
        DB::table('app_trailing')->where('app_no', $request->input('app_no'))
          ->insert($apptrail);
      }
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
    }
    
    public function returnto_application(Request $request)
    {
        $datadb = DB::transaction(function () use ($request) {
        // $forreturn = DB::table('aa_validation')->where('app_no', $request->input('app_no'))
        // ->select('remarks_name, remarks_dob, remarks_gender, remarks_civilstatus, remarks_citizenship, remarks_currentadd, remarks_permaadd, review_contactnum, review_landline, remarks_email, remarks_emp_no, remarks_campus, remarks_classification, remarks_college_unit, remarks_department, remarks_rankpos, remarks_appointment, remarks_appointdate, remarks_monthlysalary, remarks_sg, remarks_sgcat, remarks_tin_no, remarks_monthlycontri, remarks_equivalent, remarks_membershipf, remarks_proxyform, general_remarks')
        // ->get()->first();
        $coco = DB::table('aa_validation')->where('app_no', $request->input('app_no'))->count();
        if ($coco > 0) {
          // return response()->json(['message' => 'Exist']);
          $inserts = array(
            'app_no' => $request->input('app_no'),
            'pass_name' => $request->input('pass_name') ?? 0,
            'pass_dob' => $request->input('pass_dob') ?? 0,
            'pass_gender' => $request->input('pass_gender') ?? 0,
            'pass_civilstatus' => $request->input('pass_civilstatus') ?? 0,
            'pass_citizenship' => $request->input('pass_citizenship') ?? 0,
            'pass_currentadd' => $request->input('pass_currentadd') ?? 0,
            'pass_permaadd' => $request->input('pass_permaadd') ?? 0,
            'pass_contactnum' => $request->input('pass_contactnum') ?? 0,
            'pass_landline' => $request->input('pass_landline') ?? 0,
            'pass_email' => $request->input('pass_email') ?? 0,
            'pass_emp_no' => $request->input('pass_emp_no') ?? 0,
            'pass_campus' => $request->input('pass_campus') ?? 0,
            'pass_classification' => $request->input('pass_classification') ?? 0,
            'pass_college_unit' => $request->input('pass_college_unit') ?? 0,
            'pass_department' => $request->input('pass_department') ?? 0,
            'pass_rankpos' => $request->input('pass_rankpos') ?? 0,
            'pass_appointment' => $request->input('pass_appointment') ?? 0,
            'pass_appointdate' => $request->input('pass_appointdate') ?? 0,
            'pass_monthlysalary' => $request->input('pass_monthlysalary') ?? 0,
            'pass_sg' => $request->input('pass_sg') ?? 0,
            'pass_sgcat' => $request->input('pass_sgcat') ?? 0,
            'pass_tin_no' => $request->input('pass_tin_no') ?? 0,
            'pass_monthlycontri' => $request->input('pass_monthlycontri') ?? 0,
            'pass_equivalent' => $request->input('pass_equivalent') ?? 0,
            'pass_membershipf' => $request->input('pass_membershipf') ?? 0,
            'pass_proxyform' => $request->input('pass_proxyform') ?? 0,
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
         $last_id = DB::table('aa_validation')->where('app_no', $request->input('app_no'))
        ->update($inserts);
        }else{
          $inserts = array(
            'app_no' => $request->input('app_no'),
            'pass_name' => $request->input('pass_name') ?? 0,
            'pass_dob' => $request->input('pass_dob') ?? 0,
            'pass_gender' => $request->input('pass_gender') ?? 0,
            'pass_civilstatus' => $request->input('pass_civilstatus') ?? 0,
            'pass_citizenship' => $request->input('pass_citizenship') ?? 0,
            'pass_currentadd' => $request->input('pass_currentadd') ?? 0,
            'pass_permaadd' => $request->input('pass_permaadd') ?? 0,
            'pass_contactnum' => $request->input('pass_contactnum') ?? 0,
            'pass_landline' => $request->input('pass_landline') ?? 0,
            'pass_email' => $request->input('pass_email') ?? 0,
            'pass_emp_no' => $request->input('pass_emp_no') ?? 0,
            'pass_campus' => $request->input('pass_campus') ?? 0,
            'pass_classification' => $request->input('pass_classification') ?? 0,
            'pass_college_unit' => $request->input('pass_college_unit') ?? 0,
            'pass_department' => $request->input('pass_department') ?? 0,
            'pass_rankpos' => $request->input('pass_rankpos') ?? 0,
            'pass_appointment' => $request->input('pass_appointment') ?? 0,
            'pass_appointdate' => $request->input('pass_appointdate') ?? 0,
            'pass_monthlysalary' => $request->input('pass_monthlysalary') ?? 0,
            'pass_sg' => $request->input('pass_sg') ?? 0,
            'pass_sgcat' => $request->input('pass_sgcat') ?? 0,
            'pass_tin_no' => $request->input('pass_tin_no') ?? 0,
            'pass_monthlycontri' => $request->input('pass_monthlycontri') ?? 0,
            'pass_equivalent' => $request->input('pass_equivalent') ?? 0,
            'pass_membershipf' => $request->input('pass_membershipf') ?? 0,
            'pass_proxyform' => $request->input('pass_proxyform') ?? 0,
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
        }

        $email = DB::table('mem_app')->where('app_no', $request->input('app_no'))->select('email_address')->value('email_address');
        $mem_appinst = array(
          'validator_remarks' => "FOR COMPLIANCE",
          'aa_cfm_user' => Auth::user()->id,
        );
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
          ->update($mem_appinst);
        $forreturn = DB::table('aa_validation')->where('app_no', $request->input('app_no'))
        ->select('remarks_name', 'remarks_dob', 'remarks_gender', 'remarks_civilstatus', 'remarks_citizenship', 'remarks_currentadd', 'remarks_permaadd', 'review_contactnum', 'review_landline', 'remarks_email', 'remarks_emp_no', 'remarks_campus', 'remarks_classification', 'remarks_college_unit', 'remarks_department', 'remarks_rankpos', 'remarks_appointment', 'remarks_appointdate', 'remarks_monthlysalary', 'remarks_sg', 'remarks_sgcat', 'remarks_tin_no', 'remarks_monthlycontri', 'remarks_equivalent', 'remarks_membershipf', 'remarks_proxyform', 'general_remarks')
        ->first();
        $mailData = [
          'title' => 'Member Application is for Processing',
          'body' => 'Your application is subject for compliance.',
          'app_no' => $request->input('app_no'),
          'for_correction' => $forreturn
        ];
        Mail::to($email)->send(new returnaaMail($mailData));
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
    }
    public function forwardto_application(Request $request)
    {
      $appNos = $request->input('app_nos');
      $forwardAction = $request->input('forward_action');
      $forwarded_user = $request->input('hrdo_user');
      $affectedRows = 0;
      if($forwardAction == 'FM'){
        foreach ($appNos as $appNo) {
          $row = DB::table('mem_app')
              ->where('app_no', $appNo)
              ->update(['validator_remarks' => 'FORWARDED TO ' . $forwardAction,
                        'fm_user' => $forwarded_user]);
          $rows = DB::table('app_trailing')
                ->insert(['status_remarks' => 'FORWARDED TO FM',
                          'updateby' => Auth::user()->id,
                          'user_level' => 'FM',
                          'app_no'=> $appNo]);
          $affectedRows += $row;
      }
      }else{
        foreach ($appNos as $appNo) {
          $row = DB::table('mem_app')
              ->where('app_no', $appNo)
              ->update(['validator_remarks' => 'FORWARDED TO ' . $forwardAction,
                        'forwarded_user' => $forwarded_user]);
          $rows = DB::table('app_trailing')
                ->insert(['status_remarks' => 'HRDO - REVIEW VALIDATION',
                          'updateby' => Auth::user()->id,
                          'user_level' => 'HRDO',
                          'app_no'=> $appNo]);
          $affectedRows += $row;
      }
      }
      


      return response()->json(['success' => $affectedRows]);
    }
    public function aa_validation_rejected(Request $request)
    {
      $datadb = DB::transaction(function () use ($request) {
        $mem_appinst = array(
          'validator_remarks' => "REJECTED",
          'app_status' => "REJECTED",
        );
        $email = DB::table('mem_app')->where('app_no', $request->input('app_no'))->select('email_address')->value('email_address');
        $last_id = DB::table('mem_app')->where('app_no', $request->input('app_no'))
          ->update($mem_appinst);
        $appcount = DB::table('app_trailing')->where('app_no', $request->input('app_no'))->count();
        if($appcount > 0){
          $apptrail = array(
            'status_remarks' => "AO - REJECTED",
            'app_no' => $request->input('app_no'),
            'updateby' => Auth::user()->id,
            'user_level' => Auth::user()->user_level,
          );
          DB::table('app_trailing')->where('app_no', $request->input('app_no'))
            ->insert($apptrail);
        }
          $mailData = [
            'title' => 'Member Application is REJECTED',
            'body' => 'Your application has been REJECTED.',
            'app_no' => $request->input('app_no'),
          ];
          Mail::to($email)->send(new rejectedMail($mailData));
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
    }
    public function hrdo_validation_save(Request $request)
    {
      $datadb = DB::transaction(function () use ($request) {
        $coco = DB::table('aa_validation')->where('app_no', $request->input('app_no'))->count();
        if ($coco > 0) {
          // return response()->json(['message' => 'Exist']);
          $inserts = array(
            'app_no' => $request->input('app_no'),
            'pass_emp_no' => $request->input('emp_no') ?? 0,
            'pass_campus' => $request->input('campus') ?? 0,
            'pass_classification' => $request->input('classification') ?? 0,
            'pass_college_unit' => $request->input('college_unit') ?? 0,
            'pass_department' => $request->input('department') ?? 0,
            'pass_rankpos' => $request->input('position') ?? 0,
            'pass_appointment' => $request->input('appoint_date') ?? 0,
            'pass_appointdate' => $request->input('appoint_date') ?? 0,
            'pass_monthlysalary' => $request->input('monthly_salary') ?? 0,
            'pass_sg' => $request->input('salary_grade') ?? 0,
            'pass_sgcat' => $request->input('sg_category') ?? 0,
            'pass_tin_no' => $request->input('tin_no') ?? 0,

            // 'remarks_emp_no' => $request->input('remarks_emp_no'),
            // 'remarks_campus' => $request->input('remarks_campus'),
            // 'remarks_classification' => $request->input('remarks_classification'),
            // 'remarks_college_unit' => $request->input('remarks_college_unit'),
            // 'remarks_department' => $request->input('remarks_department'),
            // 'remarks_rankpos' => $request->input('remarks_rankpos'),
            // 'remarks_appointment' => $request->input('remarks_appointment'),
            // 'remarks_appointdate' => $request->input('remarks_appointdate'),
            // 'remarks_monthlysalary' => $request->input('remarks_monthlysalary'),
            // 'remarks_sg' => $request->input('remarks_sg'),
            // 'remarks_sgcat' => $request->input('remarks_sgcat'),
            // 'remarks_tin_no' => $request->input('remarks_tin_no'),
            'general_remarks' => $request->input('general_remarks'), 
            'evaluate_by' => Auth::user()->id
        );
        $last_id = DB::table('hrdo_validation')->insert($inserts);
        }
        $mem_appinst = array(
          'validator_remarks' => "FORWARD TO FM",
          'app_status' => "PROCESSING",
        );
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
          ->update($mem_appinst);
        $appcount = DB::table('app_trailing')->where('app_no', $request->input('app_no'))->count();
        if($appcount > 0){
          $apptrail = array(
            'status_remarks' => "HRDO - APPROVED",
            // 'status_remarks' => "FORWARD TO FM",
            'app_no' => $request->input('app_no'),
            'updateby' => Auth::user()->id,
            'user_level' => Auth::user()->user_level,
          );
          DB::table('app_trailing')->where('app_no', $request->input('app_no'))
            ->insert($apptrail);
        }
        // return [
        //   'last_id' => $last_id,
        // ];
      });
      return response()->json(['success' => true]);
    }
    // 
    public function validate_step_aa(Request $request)
    {
      $user_step = DB::table('app_trailing')
      ->where('app_no', $request->input('app_no'))
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
      if($user_step == Auth::user()->user_level){
        $affectedRows = 1;
      }else{
        $affectedRows = 0;
      }
      return response()->json(['success' => $affectedRows]);
    }
    public function validate_step_reject(Request $request)
    {
      $user_step = DB::table('app_trailing')
      ->where('app_no', $request->input('app_no'))
      ->orderBy('app_trailing_ID', 'desc')
      ->value('user_level');
      if($user_step == Auth::user()->user_level){
        $affectedRows = 1;
      }else{
        $affectedRows = 0;
      }
      return response()->json(['success' => $affectedRows]);
    }
    public function returnto_aa_application(Request $request)
    {
        $datadb = DB::transaction(function () use ($request) {
        $coco = DB::table('aa_validation')->where('app_no', $request->input('app_no'))->count();
        if ($coco > 0) {
          // return response()->json(['message' => 'Exist']);
          $inserts = array(
            'app_no' => $request->input('app_no'),
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
            'general_remarks' => $request->input('general_remarks'), 
            'hrdo_evaluate_by' => Auth::user()->id
        );
         $last_id = DB::table('aa_validation')->where('app_no', $request->input('app_no'))
        ->update($inserts);
        }
        $mem_appinst = array(
          'validator_remarks' => "HRDO RETURNED APPLICATION",
          'forwarded_user' => 0,
        );
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
          ->update($mem_appinst);
          $appcount = DB::table('app_trailing')->where('app_no', $request->input('app_no'))->count();
      if($appcount > 0){
        $apptrail = array(
          'status_remarks' => "HRDO - RETURNED APPLICATION",
          'app_no' => $request->input('app_no'),
          'updateby' => Auth::user()->id,
          'user_level' => 'AA',
        );
        DB::table('app_trailing')->where('app_no', $request->input('app_no'))
          ->insert($apptrail);
        }
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
    }
    public function hrdo_validation_draft(Request $request)
    {
      $datadb = DB::transaction(function () use ($request) {
        $coco = DB::table('aa_validation')->where('app_no', $request->input('app_no'))->count();
        if ($coco > 0) {
          // return response()->json(['message' => 'Exist']);
          $inserts = array(
            'app_no' => $request->input('app_no'),
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
            'general_remarks' => $request->input('general_remarks'), 
            'evaluate_by' => Auth::user()->id
        );
         $last_id = DB::table('aa_validation')->where('app_no', $request->input('app_no'))
        ->update($inserts);
        }

        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => true]);
    }

    //FM validation
    public function fm_validation_save(Request $request)
    {
      $datadb = DB::transaction(function () use ($request) {
        $mem_appinst = array(
          'validator_remarks' => "FOR PAYROLL ADVISE",
          'app_status' => "PROCESSING",
        );
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
          ->update($mem_appinst);
        $appcount = DB::table('app_trailing')->where('app_no', $request->input('app_no'))->count();
        if($appcount > 0){
          $apptrail = array(
            'status_remarks' => "FOR PAYROLL ADVISE",
            'app_no' => $request->input('app_no'),
            'updateby' => Auth::user()->id,
            'user_level' => Auth::user()->user_level,
          );
          DB::table('app_trailing')->where('app_no', $request->input('app_no'))
            ->insert($apptrail);
        }
      });
      return response()->json(['success' => true]);
    }
}
