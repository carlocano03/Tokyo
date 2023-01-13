<?php

namespace App\Http\Controllers;
use PDF;

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
        $pdf = PDF::loadView('pdf.cocolife');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }

    public function generateProxyForm() {
        $pdf = PDF::loadView('pdf.proxy_form');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }
}