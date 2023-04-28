<?php

namespace App\Http\Controllers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use PDF;
use ZipArchive;
use File;
use DB;
use Carbon\Carbon;


class PDFController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware( 'auth' );
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function generateCocolife($id)
    {
        $data['member']  = DB::table('mem_app')->select('*')->whereRaw("mem_app.app_no = '$id'")
            ->leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
            ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
            ->leftjoin('member_signature', 'mem_app.app_no', '=', 'member_signature.app_no')
            ->get()->first();

        $employee_no = $data['member']->employee_no;

        $data['benificiary'] = DB::table('beneficiaries')->select('*')->whereRaw("beneficiaries.personal_id = '$employee_no'")
            ->get();

        $data['coco_details'] = DB::table('generated_coco')->select('*')->whereRaw("app_number = '$id'")
            ->get()->first();

        $pdf = PDF::loadView('pdf.cocolife_proxyform', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }
    public function proxyForm()
    {
        $pdf = PDF::loadView('pdf.cocolife_proxyform');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }

    public function memberform($id)
    {
        $results = DB::table('mem_app')->select('*')->whereRaw("mem_app.employee_no = '$id'")
            ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
            ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
            ->leftjoin('appointment', 'employee_details.appointment', '=', 'appointment.appoint_id')
            ->leftjoin('personal_details', 'personal_details.personal_id', '=', 'mem_app.personal_id')

            ->leftjoin('college_unit', 'college_unit.cu_no', '=', 'employee_details.college_unit')
            ->leftjoin('department', 'department.dept_no', '=', 'employee_details.department')
            ->leftjoin('membership_details', 'membership_details.app_no', '=', 'mem_app.app_no')
            ->leftjoin('member_signature', 'mem_app.app_no', '=', 'member_signature.app_no')

            ->get()->first();
        $benificiary = DB::table('beneficiaries')->select('*')->whereRaw("beneficiaries.personal_id = '$id'")
            ->get();

        $AA_signatory = DB::table('mem_app')
            ->select(
                'mem_app.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS full_name")
            )
            ->whereRaw("mem_app.employee_no = '$id'")
            ->leftjoin('users', 'mem_app.aa_cfm_user', '=', 'users.id')
            ->get()
            ->first();

        $HRDO_signatory = DB::table('mem_app')
            ->select(
                'mem_app.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS full_name")
            )
            ->whereRaw("mem_app.employee_no = '$id'")
            ->leftjoin('users', 'mem_app.forwarded_user', '=', 'users.id')
            ->get()
            ->first();

        $FM_signatory = DB::table('mem_app')
            ->select(
                'mem_app.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS full_name")
            )
            ->whereRaw("mem_app.employee_no = '$id'")
            ->leftjoin('users', 'mem_app.fm_user', '=', 'users.id')
            ->get()
            ->first();

        $data['AA_signatory'] = $AA_signatory;
        $data['HRDO_signatory'] = $HRDO_signatory;
        $data['FM_signatory'] = $FM_signatory;
        $data['member'] = $results;
        $data['benificiary'] = $benificiary;
        // print_r($data);
        $pdf = PDF::loadView('pdf.member_form', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }

    public function generateProxyForm($id)
    {
        $results = DB::table('mem_app')->select('*')->whereRaw("mem_app.app_no = '$id'")
            ->leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
            ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
            ->leftjoin('member_signature', 'mem_app.app_no', '=', 'member_signature.app_no')
            ->get()->first();

        $data['member'] = $results;

        $pdf = PDF::loadView('pdf.proxy_form', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }

    // public function downloadForm() {
    //     $zip = new ZipArchive;
    //     $filename = 'forms.zip';
    //     if($zip->open(public_path($filename), ZipArchive::CREATE) === TRUE)
    //     {
    //         $files = File::files(public_path('forms'));
    //         foreach($files as $key => $value) {
    //             $relativeItemName = basename($value);
    //             $zip->addFile($value,$relativeItemName);
    //         }
    //         $zip->close();
    //     }
    //     return response()->download(public_path($filename));
    // }

    public function downloadCoco()
    {
        $path = public_path('forms/COCOLIFE_FORM.pdf');
        return response()->download($path);
    }

    public function downloadProxy()
    {
        $path = public_path('forms/PROXY_FORM.pdf');
        return response()->download($path);
    }

    public function axaForm($id)
    {
        $results = DB::table('mem_app')->select('*')->whereRaw("mem_app.app_no = '$id'")
            ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
            ->leftjoin('campus', 'employee_details.campus', '=', 'campus.campus_key')
            ->leftjoin('appointment', 'employee_details.appointment', '=', 'appointment.appoint_id')
            ->leftjoin('personal_details', 'personal_details.personal_id', '=', 'mem_app.personal_id')
            ->leftjoin('axa_form', 'mem_app.app_no', '=', 'mem_app.app_no')
            ->leftjoin('college_unit', 'college_unit.cu_no', '=', 'employee_details.college_unit')
            ->leftjoin('department', 'department.dept_no', '=', 'employee_details.department')
            ->leftjoin('membership_details', 'membership_details.app_no', '=', 'mem_app.app_no')
            ->leftjoin('member_signature', 'mem_app.app_no', '=', 'member_signature.app_no')
            ->get()->first();

        $empNO = DB::table('mem_app')
            ->where('app_no', $id)
            ->value('employee_no');
        $benificiary = DB::table('axa_beneficiaries')->select('*')->whereRaw("axa_beneficiaries.employee_id = '$empNO'")
            ->get();

        $get_member_relationship = DB::table('axa_form')->select('*')->whereRaw("axa_form.app_no = '$id'")
            ->get()->first();

        $data['axa_info'] = $get_member_relationship;
        $data['member'] = $results;
        $data['benificiary'] = $benificiary;
        // print_r($data);
        $pdf = PDF::loadView('pdf.axa_form', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream();
    }


    public function generatePayslip()
    {


        $pdf = PDF::loadView('pdf.generate-payslip');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }
}
