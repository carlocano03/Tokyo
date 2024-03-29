<?php

namespace App\Http\Controllers;

use App\Models\MemApp;
use App\Models\PayrollAdvise;
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
      $payroll = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($payroll) {
        $query->where('mem_app.validator_remarks', $payroll);
      });
    } else if ($users == 'CFM') {
      $payroll = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($payroll) {
        $query->where('mem_app.validator_remarks', $payroll);
      });
    } else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      $approved = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($process, $approved, $allowCampus) {
        $query->where('mem_app.validator_remarks', $process)
          ->where('employee_details.campus', $allowCampus->campus_key)
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
      $payroll = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($payroll) {
        $query->where('mem_app.validator_remarks', $payroll);
      });
    } else if ($users == 'CFM') {
      $payroll = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($payroll) {
        $query->where('mem_app.validator_remarks', $payroll);
      });
    } else if ($users == 'FM') {
      $process = 'FORWARDED TO FM';
      $payroll = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($process, $payroll, $allowCampus) {
        $query->where('mem_app.validator_remarks', $process)
          ->where('employee_details.campus', $allowCampus->campus_key)
          ->orWhere('mem_app.validator_remarks', $payroll);
      });
    }

    $totalRecordswithFilter = $records->count();

    // Fetch records
    DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
    $records = MemApp::leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
      ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
      ->leftjoin('membership_details', 'mem_app.app_no', '=', 'membership_details.app_no')
      ->leftjoin('campus', 'campus.campus_key', '=', 'employee_details.campus')
      ->leftjoin('membership_id', 'mem_app.employee_no', '=' ,'membership_id.employee_no')
      ->where('mem_app.app_no', 'like', '%' . $search . '%')
      ->groupBy('mem_app.app_no');
    if ($cfmCluster > 0) {
      $records->where('campus.cluster_id', $cfmCluster);
    }
    if ($users == 'AO') {
      $payroll = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($payroll) {
        $query->where('mem_app.validator_remarks', $payroll);
      });
    } else if ($users == 'CFM') {
      $payroll = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($payroll) {
        $query->where('mem_app.validator_remarks', $payroll);
      });
    } else if ($users == 'FM') {
      $payroll = 'FOR PAYROLL ADVISE';
      $records->where(function ($query) use ($payroll, $allowCampus) {
        $query->where('mem_app.validator_remarks', $payroll)
          ->where('employee_details.campus', $allowCampus->campus_key);
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
        $row[] = '# '.$start;
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
          $amt = number_format((float)$r->amount, 2, '.', ',');
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

  public function get_payroll_advise_report(Request $request)
  {
    $campus_id = Auth::user()->campus_id;
    $allowCampus = DB::table('campus')
      ->where('id', $campus_id)
      ->first();

    if ($request->ajax()) {
      $data = PayrollAdvise::leftjoin('tbl_payrol_advise_report', 'tbl_payrol_advise.payroll_no', '=', 'tbl_payrol_advise_report.payroll_no')
      ->where('tbl_payrol_advise.cluster_id', $allowCampus->cluster_id);
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
          $btn = '<button  class="delete_btn btn btn-primary btn-sm resend_email md-tooltip--left" data-md-tooltip="Resend Email"  id="'.$row->payroll_no.'">
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>
                  </button>

                  <button  class="delete_btn btn btn-primary btn-sm download_payroll md-tooltip--left" data-md-tooltip="Download Payroll Reports"  id="'.$row->payroll_no.'" data-file="'.$row->file_name.'">
                  <i class="fa fa-download" aria-hidden="true"></i>
                  </button>';
          return $btn;
      })
      ->rawColumns(['action'])
      ->make(true);
    }
  }

  public function get_cluster(Request $request)
  {
    $cluster = $request->input('id');
    $results = DB::table('campus')->select('*')->whereRaw("campus_key = '$cluster'")
      ->get()->first();
    return response()->json($results);
  }

  public function save_payroll_advise(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $add_payroll_advise = array(
        'payroll_no' => $request->input('payroll_no'),
        'accounting_name' => $request->input('accounting_head'),
        'designation' => $request->input('designation'),
        'unit_campus' => $request->input('campus'),
        'cluster_id' => $request->input('cluster_id'),
        'payroll_partner' => $request->input('accountable_payroll'),
        'payroll_section' => $request->input('payroll_section'),
        'subject' => $request->input('subject'),
        'from_user' => $request->input('from_user'),
        'date_prepared' => date('Y-m-d'),
        'payroll_status' => 'Submitted',
      );
      DB::table('tbl_payrol_advise')->insert($add_payroll_advise);
      $message = 'Success';
      return [
        'error' => $message,
      ];
    });
    return response()->json(['success' => $datadb['error']]);
  }

  public function save_payroll_advise_report(Request $request)
  {
    $data = $request->all();
    $payroll_no = $request->input('payroll_no');
    $subject = $request->input('subject');
    $table_data = array();
    foreach ($data['data_tables'] as $row) {
      DB::table('tbl_payrol_advise_report')->insert([
        'payroll_no' => $payroll_no,
        'members_id_no' => $row[1],
        'employee_no' => $row[2],
        'contribution_type' => $row[8],
        'amount' => $row[9],
        'file_name' => 'payroll-advise-' . $payroll_no . '.pdf',
      ]);

      DB::table('mem_app')
      ->where('employee_no', $row[2])
      ->where('validator_remarks', 'FOR PAYROLL ADVISE')
      ->update(['validator_remarks' => 'ALREADY GENERATED PAYROLL']);

      $table_data[] = array(
        'payroll_no' => $payroll_no,
        'subject' => $subject,
        'members_id_no' => $row[1],
        'employee_no' => $row[2],
        'contribution_type' => $row[8],
        'amount' => $row[9],
      );
    }
    // Generate PDF file
    $pdf = PDF::loadView('admin.members.pdf.payroll-advise', ['table_data' => $table_data]);
    $pdf_file = $pdf->output();
    // Save PDF file to disk
    $filename = 'payroll-advise-' . $payroll_no . '.pdf';
    $filepath = storage_path('app/public/payroll_advise/' . $filename);
    file_put_contents($filepath, $pdf_file);

    return response()->json(['success' => true]);
  }

  public function download_payroll($filename)
  {
    $filepath = storage_path('app/public/payroll_advise/' . $filename);
    // Check if the file exists
    if (file_exists($filepath)) {
      // Generate the response to download the file
      return response()->download($filepath, $filename);
    }
    abort(404);
  }


}