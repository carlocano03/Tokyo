<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\UploadFile;
use DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Storage;
use Mail;

class Settings extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
  }
    public function campus_list(Request $request)
  {
    if ($request->ajax()) {
        $data = Setting::select('*');
        return Datatables::of($data)
          ->addIndexColumn()
          ->addColumn('action', function ($row) {
            $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm edit" id="' . $row->id . '">Edit</a>
                    <a href="javascript:void(0)" class="edit btn btn-primary btn-sm delete_campus" data-id="' . $row->id . '">Remove</a>';
            return $btn;
          })
          ->rawColumns(['action'])
          ->make(true);
    
      }
  }
  public function save_campus(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
          $inserts_campus = array(
            'campus_key' => strtoupper($request->input('campus_key')),
            'name' => strtoupper($request->input('campus_name')),
            'cluster_id' => 5
          );
        $last_id = DB::table('campus')->insertGetId($inserts_campus);
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
  }
  public function remove_campus(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
        DB::table('campus')->where('id',$request->input('id_campus'))->delete();
      });
      return response()->json(['success' => true]);
  }
}

