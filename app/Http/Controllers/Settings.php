<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Member;
use App\Models\Classification;
use App\Models\College;
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
  public function save_classif(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
          $inserts_campus = array(
            'classification_name' => strtoupper($request->input('classif_name')),
            'status' => $request->input('status'),
            'added_by' => Auth::user()->id
          );
        $last_id = DB::table('classification')->insertGetId($inserts_campus);
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
  }
  public function classification_table(Request $request)
    {
        $columns = [
            0 => 'classification_name',
            1 => 'status',
            2 => 'time_stamp',
        ];
        $totalData = Classification::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $classification = Classification::when($searchValue, function($query) use ($searchValue) {
                $query->where('classification_name', 'like', "%{$searchValue}%");
            })
            ->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $totalFiltered = Classification::when($searchValue, function($query) use ($searchValue) {
          $query->where('classification_name', 'like', "%{$searchValue}%");
            })
            ->count();

        $data = [];

        foreach ($classification as $class) {
            $nestedData['classification_name'] = $class->classification_name;
            $nestedData['status'] = $class->status== 1 ? 'Active':'In Active';
            $nestedData['time_stamp'] = $class->time_stamp;
            $nestedData['action'] = $class->status== 1 ? '<label class="switch">
            <input type="checkbox" id="up_status" data-id='.$class->classification_id.' checked>
            <span class="slider round"></span>
            </label>':'<label class="switch">
              <input type="checkbox" id="up_status" data-id='.$class->classification_id.' unchecked>
              <span class="slider round"></span>
            </label>';
            
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }
    public function up_status(Request $request)
    {
        $affectedRows = DB::transaction(function () use ($request) {
            $update_status = [
                'status' => $request->input('status'),
            ];
            return DB::table('classification')->where('classification_id', $request->input('data_id'))->update($update_status);
        });
        if ($affectedRows > 0) {
          return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    
    public function save_college(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
          $inserts_college = array(
            'college_unit_name' => strtoupper($request->input('college_name')),
            'campus_id' => $request->input('campus'),
            'added_by' => Auth::user()->id
          );
        $last_id = DB::table('college_unit')->insertGetId($inserts_college);
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
  }
  public function college_table(Request $request)
    {
        $columns = [
            0 => 'college_unit_name',
            1 => 'status',
            2 => 'time_stamp',
        ];
        $totalData = College::join('campus', 'campus.id', '=', 'college_unit.campus_id')->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $college = College::when($searchValue, function($query) use ($searchValue) {
                $query->where('college_unit_name', 'like', "%{$searchValue}%");
            })
            ->join('campus', 'campus.id', '=', 'college_unit.campus_id')
            ->select('college_unit.*', 'campus.name as camp_name' )
            ->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $totalFiltered = College::when($searchValue, function($query) use ($searchValue) {
          $query->where('college_unit_name', 'like', "%{$searchValue}%");
            })
            ->join('campus', 'campus.id', '=', 'college_unit.campus_id')
            ->select('college_unit.*', 'campus.name as camp_name')
            ->count();

        $data = [];

        foreach ($college as $row) {
            $nestedData['college_unit_name'] = $row->college_unit_name;
            $nestedData['camp_name'] = $row->camp_name;
            $nestedData['time_stamp'] = $row->time_stamp;
            $nestedData['action'] = '<button class="up-button remove_coll" style="border-radius: 5px;" data-id='.$row->cu_no.' >
            <span>
              <i class="fa fa-trash" style="padding:3px;font-size:17px;" aria-hidden="true"></i>
            </span>
          </button>
          </button>
          <button class="up-button-green edit_coll" style="border-radius: 5px;" data-id='.$row->cu_no.' >
            <span>
              <i class="fa fa-edit" style="padding:3px;font-size:17px;" aria-hidden="true"></i>
            </span>
          </button>';
            
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }
    public function remove_college(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
        return DB::table('college_unit')->where('cu_no',$request->input('id_college'))->delete();
      });
      if ($datadb > 0) {
        return response()->json(['success' => true]);
      } else {
          return response()->json(['success' => false]);
      }
  }
  public function get_college(Request $request)
  {
      $query = $request->input('id_college');
      $results = DB::table('college_unit')->whereRaw("college_unit.cu_no = '$query'")
      ->join('campus', 'campus.id', '=', 'college_unit.campus_id')
      ->select('college_unit.*', 'campus.name as camp_name','campus.id as camp_id')
      ->get()->first();
      return response()->json($results);
  }
  public function update_college(Request $request)
    {
        $affectedRows = DB::transaction(function () use ($request) {
            $update_college = [
              'college_unit_name' => strtoupper($request->input('college_name')),
              'campus_id' => $request->input('campus'),
              // 'added_by' => Auth::user()->id
            ];
            return DB::table('college_unit')->where('cu_no', $request->input('cu_no'))->update($update_college);
        });
        if ($affectedRows > 0) {
          return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}

