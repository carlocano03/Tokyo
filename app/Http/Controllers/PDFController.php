<?php

namespace App\Http\Controllers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use PDF;
use ZipArchive;
use File;
use DB;

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

    public function generateCocolife() {
        $pdf = PDF::loadView( 'pdf.cocolife' );
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

    public function downloadForm() {
        $zip = new ZipArchive;
        $filename = 'forms.zip';
        if($zip->open(public_path($filename), ZipArchive::CREATE) === TRUE)
        {
            $files = File::files(public_path('forms'));
            foreach($files as $key => $value) {
                $relativeItemName = basename($value);
                $zip->addFile($value,$relativeItemName);
            }
            $zip->close();
        }
        return response()->download(public_path($filename));
    }
}