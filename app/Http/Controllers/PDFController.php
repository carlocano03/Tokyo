<?php

namespace App\Http\Controllers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use PDF;
use ZipArchive;
use File;

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

    public function generateProxyForm() {
        $pdf = PDF::loadView( 'pdf.proxy_form' );
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