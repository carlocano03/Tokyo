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

    public function generateCocolife($id) {
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

        $pdf = PDF::loadView( 'pdf.cocolife_proxyform', $data );
        $pdf->setPaper( 'A4', 'portrait' );
        return $pdf->stream();
    }
    public function proxyForm() {
        $pdf = PDF::loadView( 'pdf.cocolife_proxyform' );
        $pdf->setPaper( 'A4', 'portrait' );
        return $pdf->stream();
    }
    
    public function memberform($id) {
        $results = DB::table('mem_app')->select('*')->whereRaw("mem_app.employee_no = '$id'")
        ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
        ->leftjoin('personal_details', 'personal_details.personal_id', '=', 'mem_app.personal_id')
        // ->leftjoin('beneficiaries', 'beneficiaries.personal_id', '=', 'employee_details.employee_no')
        ->leftjoin('membership_details', 'membership_details.app_no', '=', 'mem_app.app_no')
        ->get()->first();
        $benificiary = DB::table('beneficiaries')->select('*')->whereRaw("beneficiaries.personal_id = '$id'")
        ->get();

        $data['member'] = $results;
        $data['benificiary'] = $benificiary;
        // print_r($data);
        $pdf = PDF::loadView( 'pdf.member_form',$data );
        $pdf->setPaper( 'A4', 'portrait' );
        return $pdf->stream();
    }
    
    public function generateProxyForm($id) {
        $results = DB::table('mem_app')->select('*')->whereRaw("mem_app.app_no = '$id'")
        ->leftjoin('personal_details', 'mem_app.personal_id', '=', 'personal_details.personal_id')
        ->leftjoin('employee_details', 'mem_app.employee_no', '=', 'employee_details.employee_no')
        ->leftjoin('member_signature', 'mem_app.app_no', '=', 'member_signature.app_no')
        ->get()->first();

        $data['member'] = $results;

        $pdf = PDF::loadView( 'pdf.proxy_form', $data );
        $pdf->setPaper( 'A4', 'portrait' );
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
}