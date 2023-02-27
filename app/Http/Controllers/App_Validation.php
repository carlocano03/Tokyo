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
         $last_id = DB::table('aa_validation')->where('app_no', $request->input('app_no'))
        ->update($inserts);
        }else{
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
        }
        
        $mem_appinst = array(
          'validator_remarks' => "AA VERIFIED",
        );
        DB::table('mem_app')->where('app_no', $request->input('app_no'))
          ->update($mem_appinst);
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
         $last_id = DB::table('aa_validation')->where('app_no', $request->input('app_no'))
        ->update($inserts);
        }else{
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
        }

        $email = DB::table('mem_app')->where('app_no', $request->input('app_no'))->select('email_address')->value('email_address');
        $mem_appinst = array(
          'validator_remarks' => "FOR CORRECTION",
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
      foreach ($appNos as $appNo) {
          $row = DB::table('mem_app')
              ->where('app_no', $appNo)
              ->update(['validator_remarks' => 'FORWARDED TO ' . $forwardAction,
                        'forwarded_user' => $forwarded_user]);
          $affectedRows += $row;
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
        $coco = DB::table('hrdo_validation')->where('app_no', $request->input('app_no'))->count();
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
         $last_id = DB::table('hrdo_validation')->where('app_no', $request->input('app_no'))
        ->update($inserts);
        }else{
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
        $last_id = DB::table('hrdo_validation')->insertGetId($inserts);
        }
        
        $mem_appinst = array(
          'validator_remarks' => "HRDO VERIFIED",
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
