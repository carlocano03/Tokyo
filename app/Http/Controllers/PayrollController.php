<?php

namespace App\Http\Controllers;

use App\Models\MemApp;
use Auth;
use Hash;
use DB;
use PDF;
use Excel;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\processMail;
// use Illuminate\Support\Facades\Log;
class PayrollController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function get_payroll_advise(Request $request)
  {
    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    // Custom search filter 
    $campus  = $request->get('campus');
    $department  = $request->get('department');
    $dt_from  = $request->get('dt_from');
    $dt_to  = $request->get('dt_to');
    $status_search  = $request->get('status');
    $validator_remarks  = $request->get('remarks');
    $search  = $request->get('searchValue');
    $users = Auth::user()->user_level;
    $userId = Auth::user()->id;
    $campus_id = Auth::user()->campus_id;
    $allowCampus = DB::table('campus')
      ->where('id', $campus_id)
      ->first();
    $cfmCluster = DB::table('user_prev')
      ->join('users', 'user_prev.users_id', '=', 'users.id')
      ->select('user_prev.cfm_cluster')
      ->where('users.id', '=', $userId)
      ->value('cfm_cluster');
    $aa_1 = '';
    $aa_2 = '';
    $aa_3 = '';

    // Total records
    // $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
    //   ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
    //   ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
    //   ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
    //   ->where('mem_app.app_no', 'like', '%' . $search . '%')
    //   ->where('mem_app.app_status', $aa_1)
    //   ->where('mem_app.app_status', $aa_2);
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->leftjoin('membership_id', 'mem_app.employee_no', '=' ,'membership_id.employee_no')
      ->where('mem_app.app_status', '!=', 'deleted');
    if ($cfmCluster > 0) {
      $records->where('campus.cluster_id', $cfmCluster);
    }
    ## Add custom filter conditions
    if (!empty($campus)) {
      $records->where('employee_details.campus', $campus);
    }
    if (!empty($department)) {
      $records->where('employee_details.department', $department);
    }
    if (!empty($search)) {
      $records->orWhere('mem_app.app_no', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.employee_no', 'like', '%' . $search . '%');
      $records->orWhere('personal_details.lastname', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.validator_remarks', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(mem_app.app_date)'), array($dt_from, $dt_to));
    }
    if (!empty($status_search)) {
      $records->where('mem_app.app_status', $status_search);
    }
    if (!empty($validator_remarks)) {
      $records->where('mem_app.validator_remarks', $validator_remarks);
    }
    if ($users == 'AO') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'HRDO') {
      // $aa_1 = $userId;
      // $cfm = 'FORWARDED TO HRDO';
      // $process = 'PROCESSING';
      // $approved = 'APPROVED APPLICATION';
      // $records->where('mem_app.forwarded_user', $aa_1);
      // $records->where('mem_app.validator_remarks', $cfm);
      // $records->orWhere('mem_app.validator_remarks', $approved);

      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.validator_remarks', $approved);
      $records->orWhere('mem_app.validator_remarks', 'FORWARD TO FM');
    } else if ($users == 'CFM') {
      $cfm = 'AO VERIFIED';
      $records->where('mem_app.app_status', $cfm);
    } else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      // $approved = 'APPROVED APPLICATION';
      $approved = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($process, $approved, $allowCampus) {
        $query->where('mem_app.validator_remarks', $process)
          ->where('employee_details.campus', $allowCampus->campus_key)
          // ->orWhere('mem_app.app_status', $approved);
          ->orWhere('mem_app.validator_remarks', $approved);
      });
    }
    $totalRecords = $records->count();

    // Total records with filter
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->leftjoin('membership_id', 'mem_app.employee_no', '=' ,'membership_id.employee_no')
      ->where('mem_app.app_no', 'like', '%' . $search . '%');
    DB::enableQueryLog();
    if ($cfmCluster > 0) {
      $records->where('campus.cluster_id', $cfmCluster);
    }
    ## Add custom filter conditions
    if (!empty($campus)) {
      $records->where('employee_details.campus', $campus);
    }
    if (!empty($department)) {
      $records->where('employee_details.department', $department);
    }
    if (!empty($search)) {
      $records->orWhere('mem_app.app_no', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.employee_no', 'like', '%' . $search . '%');
      $records->orWhere('personal_details.lastname', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.validator_remarks', 'like', '%' . $search . '%');
    }
    if (!empty($dt_from) && !empty($dt_to)) {
      $records->whereBetween(DB::raw('DATE(mem_app.app_date)'), array($dt_from, $dt_to));
    }
    if (!empty($status_search)) {
      $records->where('mem_app.app_status', $status_search);
    }
    if (!empty($validator_remarks)) {
      $records->where('mem_app.validator_remarks', $validator_remarks);
    }
    if ($users == 'AO') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'HRDO') {
      // $aa_1 = $userId;
      // $cfm = 'FORWARDED TO HRDO';
      // $process = 'PROCESSING';
      // $approved = 'APPROVED APPLICATION';
      // $records->where('mem_app.forwarded_user', $aa_1);
      // $records->where('mem_app.validator_remarks', $cfm);
      // $records->orWhere('mem_app.validator_remarks', $approved);

      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.validator_remarks', $approved);
      $records->orWhere('mem_app.validator_remarks', 'FORWARD TO FM');
    } else if ($users == 'CFM') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $records->where(function ($query) use ($aa_1, $cfm, $process) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      // $approved = 'APPROVED APPLICATION';
      $approved = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($process, $approved, $allowCampus) {
        $query->where('mem_app.validator_remarks', $process)
          ->where('employee_details.campus', $allowCampus->campus_key)
          // ->orWhere('mem_app.app_status', $approved);
          ->orWhere('mem_app.validator_remarks', $approved);
      });
    }

    $totalRecordswithFilter = $records->count();

    // Fetch records
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->leftjoin('membership_id', 'mem_app.employee_no', '=' ,'membership_id.employee_no')
      ->where('mem_app.app_no', 'like', '%' . $search . '%');
    if ($cfmCluster > 0) {
      $records->where('campus.cluster_id', $cfmCluster);
    }
    if ($users == 'AO') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $query_serch = 'DRAFT APPLICATION';
      $rejected = 'REJECTED';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $query_serch, $rejected, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $query_serch)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $rejected)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'HRDO') {
      $aa_1 = $userId;
      $cfm = 'FORWARDED TO HRDO';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where('mem_app.forwarded_user', $aa_1);
      $records->where('mem_app.validator_remarks', $cfm);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.app_status', $approved);
      $records->orWhere('mem_app.validator_remarks', $approved);
      $records->orWhere('mem_app.validator_remarks', 'FORWARD TO FM');
    } else if ($users == 'CFM') {
      $aa_1 = 'NEW APPLICATION';
      $cfm = 'AO VERIFIED';
      $process = 'PROCESSING';
      $approved = 'APPROVED APPLICATION';
      $records->where(function ($query) use ($aa_1, $cfm, $process, $approved) {
        $query->where('mem_app.app_status', $aa_1)
          ->orWhere('mem_app.validator_remarks', $cfm)
          ->orWhere('mem_app.app_status', $process)
          ->orWhere('mem_app.app_status', $approved)
          ->orWhere('mem_app.validator_remarks', '=', 'FOR COMPLIANCE');
      });
    } else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      // $approved = 'APPROVED APPLICATION';
      $approved = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($process, $approved, $allowCampus) {
        $query->where('mem_app.validator_remarks', $process)
          ->where('employee_details.campus', $allowCampus->campus_key)
          // ->orWhere('mem_app.app_status', $approved);
          ->orWhere('mem_app.validator_remarks', $approved);
      });
    }
    $dd = DB::getQueryLog();
    ## Add custom filter conditions
    if (!empty($campus)) {
      $records->where('employee_details.campus', $campus);
    }
    if (!empty($department)) {
      $records->where('employee_details.department', $department);
    }
    if (!empty($search)) {
      $records->orWhere('mem_app.app_no', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.employee_no', 'like', '%' . $search . '%');
      $records->orWhere('personal_details.lastname', 'like', '%' . $search . '%');
      $records->orWhere('mem_app.validator_remarks', 'like', '%' . $search . '%');
    }
    if (!empty($status_search)) {
      $records->where('mem_app.app_status', $status_search);
    }
    if (!empty($validator_remarks)) {
      $records->where('mem_app.validator_remarks', $validator_remarks);
    }

    $posts = $records->skip($start)
      ->take($rowperpage)
      ->get();
    $data = array();
    if ($posts) {
      foreach ($posts as $r) {
        $start++;
        $row = array();
        $row[] = '# '.$r->mem_id;
        $row[] = $r->membership_id;
        $row[] = $r->employee_no;
        $row[] = '<span class="mp-text-fw-heavy">' . $r->lastname . ', ' . $r->firstname . ' ' . $r->middlename . '</span>';
        
        if ($r->cluster_id == 1) {
            $cluster = 'Cluster 1 - DSB';
        } else if ($r->cluster_id == 2) {
            $cluster = 'Cluster 2 - LBOU';
        } else if ($r->cluster_id == 3) {
            $cluster = 'Cluster 3 - MLAPGH';
        } else if ($r->cluster_id == 4) {
            $cluster = 'Cluster 4 - CVM';
        }
        $row[] = $cluster;
        $row[] = $r->name;
        $row[] = date("D M j, Y", strtotime($r->date_of_membership));
        $row[] = number_format($r->monthly_salary, 2, '.', ',');
        $row[] = $r->contribution_set;
        if ($r->contribution_set == 'Fixed Amount') {
            $amt = number_format($r->amount, 2, '.', ',');
        } else {
            $amt = $r->percentage;
        }
        $row[] = $amt;
        $data[] = $row;
      }
    }

    $json_data = array(
      "draw" => intval($draw),
      "recordsTotal" => intval($totalRecords),
      "recordsFiltered" => intval($totalRecordswithFilter),
      "data" => $data,
      "dataxx" => $dd
    );
    echo json_encode($json_data);
  }

}