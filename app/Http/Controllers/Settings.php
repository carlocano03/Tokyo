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
  //   public function campus_lists(Request $request)
  // {
  //   if ($request->ajax()) {
  //       $data = Setting::select('*');
  //       return Datatables::of($data)
  //         ->addIndexColumn()
  //         ->addColumn('action', function ($row) {
  //           $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm edit_campus" data-id="' . $row->id . '">Edit</a>
  //                   <a href="javascript:void(0)" class="btn btn-primary btn-sm delete_campus" data-id="' . $row->id . '">Remove</a>';
  //           return $btn;
  //         })
  //         ->rawColumns(['action'])
  //         ->make(true);
    
  //     }
  // }
  public function campus_list(Request $request)
    {
        $columns = [
            0 => 'campus_key',
            1 => 'name',
        ];
        $totalData = Campus::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $campus = Campus::when($searchValue, function($query) use ($searchValue) {
                $query->where('campus_key', 'like', "%{$searchValue}%")->orWhere('name', 'like', "%{$searchValue}%");
            })
            ->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $totalFiltered = Campus::when($searchValue, function($query) use ($searchValue) {
          $query->where('campus_key', 'like', "%{$searchValue}%")->orWhere('name', 'like', "%{$searchValue}%");
            })
            ->count();

        $data = [];
        foreach ($campus as $row) {
            $nestedData['campus_key'] = $row->campus_key;
            $nestedData['name'] = $row->name;
            $nestedData['action'] = '<a href="javascript:void(0)" class="btn btn-primary btn-sm edit_campus" data-id="' . $row->id . '">Edit</a>
            <a href="javascript:void(0)" class="btn btn-primary btn-sm delete_campus" data-id="' . $row->id . '">Remove</a>';
            
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
  public function get_campus(Request $request)
  {
      $query = $request->input('id_campus');
      $results = DB::table('campus')->whereRaw("campus.id = '$query'")
      ->select('*')
      ->get()->first();
      return response()->json($results);
  }
  public function update_campus(Request $request)
    {
        $affectedRows = DB::transaction(function () use ($request) {
            $update_campus = [
              'campus_key' => strtoupper($request->input('campus_key')),
              'name' => strtoupper($request->input('campus_name')),
              'cluster_id' => 5
            ];
            return DB::table('campus')->where('id', $request->input('campus_id'))->update($update_campus);
        });
        if ($affectedRows > 0) {
          return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
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
    public function save_department(Request $request)
    {
      $datadb = DB::transaction(function () use ($request) {
            $inserts_department = array(
              'department_name' => strtoupper($request->input('dept_name')),
              'campus_id' => $request->input('campus'),
              'cu_no' => $request->input('college_unit'),
              'added_by' => Auth::user()->id
            );
          $last_id = DB::table('department')->insertGetId($inserts_department);
          return [
            'last_id' => $last_id,
          ];
        });
        return response()->json(['success' => $datadb['last_id']]);
    }
    public function department_table(Request $request)
    {
        $columns = [
            0 => 'department_name',
            1 => 'status',
            2 => 'time_stamp',
        ];
        $totalData = Department::join('campus', 'campus.id', '=', 'department.campus_id')->join('college_unit', 'department.cu_no', '=', 'college_unit.cu_no')->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $dept = Department::when($searchValue, function($query) use ($searchValue) {
                $query->where('department_name', 'like', "%{$searchValue}%");
            })
            ->join('campus', 'campus.id', '=', 'department.campus_id')
            ->join('college_unit', 'department.cu_no', '=', 'college_unit.cu_no')
            ->select('department.*', 'campus.name as camp_name', 'college_unit.college_unit_name' )
            ->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $totalFiltered = Department::when($searchValue, function($query) use ($searchValue) {
          $query->where('department_name', 'like', "%{$searchValue}%");
            })
            ->join('campus', 'campus.id', '=', 'department.campus_id')
            ->join('college_unit', 'department.cu_no', '=', 'college_unit.cu_no')
            ->select('department.*', 'campus.name as camp_name', 'college_unit.college_unit_name' )
            ->count();

        $data = [];

        foreach ($dept as $row) {
            $nestedData['department_name'] = $row->department_name;
            $nestedData['camp_name'] = $row->camp_name;
            $nestedData['college_unit_name'] = $row->college_unit_name;
            $nestedData['time_stamp'] = $row->time_stamp;
            $nestedData['action'] = '<button class="up-button remove_dept" style="border-radius: 5px;" data-id='.$row->dept_no.' >
            <span>
              <i class="fa fa-trash" style="padding:3px;font-size:17px;" aria-hidden="true"></i>
            </span>
          </button>
          </button>
          <button class="up-button-green edit_dept" style="border-radius: 5px;" data-id='.$row->dept_no.' >
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
    public function remove_department(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
        DB::table('department')->where('dept_no',$request->input('id_dept'))->delete();
      });
      return response()->json(['success' => true]);
  }
  public function get_department(Request $request)
  {
      $query = $request->input('id_department');
      $results = DB::table('department')->whereRaw("department.dept_no = '$query'")
      ->join('campus', 'campus.id', '=', 'department.campus_id')
      ->join('college_unit', 'department.cu_no', '=', 'college_unit.cu_no')
      ->select('department.*', 'campus.name as camp_name', 'college_unit.college_unit_name' )
      ->get()->first();
      return response()->json($results);
  }
  public function update_department(Request $request)
    {
        $affectedRows = DB::transaction(function () use ($request) {
          $update_dept = array(
            'department_name' => strtoupper($request->input('dept_name')),
            'campus_id' => $request->input('campus'),
            'cu_no' => $request->input('college_unit'),
          );
            return DB::table('department')->where('dept_no', $request->input('dept_no'))->update($update_dept);
        });
        if ($affectedRows > 0) {
          return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function save_appointment(Request $request)
    {
      $datadb = DB::transaction(function () use ($request) {
            $inserts_appt = array(
              'appointment_name' => strtoupper($request->input('appointment_name')),
              'status_flag' => 1,
              'added_by' => Auth::user()->id
            );
          $last_id = DB::table('appointment')->insertGetId($inserts_appt);
          return [
            'last_id' => $last_id,
          ];
        });
        return response()->json(['success' => $datadb['last_id']]);
    }
    public function appointment_table(Request $request)
      {
          $columns = [
              0 => 'appointment_name',
              1 => 'status_flag',
              2 => 'time_stamp',
          ];
          $totalData = Appointment::count();
          $limit = $request->input('length');
          $start = $request->input('start');
          $order = $columns[$request->input('order.0.column')];
          $dir = $request->input('order.0.dir');
          $searchValue = $request->input('search.value');
  
          $classification = Appointment::when($searchValue, function($query) use ($searchValue) {
                  $query->where('appointment_name', 'like', "%{$searchValue}%");
              })
              ->orderBy($order, $dir)
              ->offset($start)
              ->limit($limit)
              ->get();
  
          $totalFiltered = Appointment::when($searchValue, function($query) use ($searchValue) {
            $query->where('appointment_name', 'like', "%{$searchValue}%");
              })
              ->count();
  
          $data = [];
  
          foreach ($classification as $class) {
              $nestedData['appointment_name'] = $class->appointment_name;
              $nestedData['status'] = $class->status_flag== 1 ? 'Active':'In Active';
              $nestedData['time_stamp'] = $class->time_stamp;
              $nestedData['action'] = $class->status_flag== 1 ? '<label class="switch">
              <input type="checkbox" id="up_status" data-id='.$class->appoint_id.' checked>
              <span class="slider round"></span>
              </label>':'<label class="switch">
                <input type="checkbox" id="up_status" data-id='.$class->appoint_id.' unchecked>
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
      public function up_appstatus(Request $request)
      {
          $affectedRows = DB::transaction(function () use ($request) {
              $update_status = [
                  'status_flag' => $request->input('status'),
              ];
              return DB::table('appointment')->where('appoint_id', $request->input('data_id'))->update($update_status);
          });
          if ($affectedRows > 0) {
            return response()->json(['success' => true]);
          } else {
              return response()->json(['success' => false]);
          }
      }
      public function sg_table(Request $request)
    {
        $columns = [
            0 => 'sg_no',
            1 => 'min_bracket',
            2 => 'max_bracket',
            2 => 'salary_cat',
        ];
        $totalData = Salarygrade::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $classification = Salarygrade::when($searchValue, function($query) use ($searchValue) {
                $query->where('min_bracket', 'like', "%{$searchValue}%")->orWhere('max_bracket', 'like', "%{$searchValue}%");
            })
            ->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $totalFiltered = Salarygrade::when($searchValue, function($query) use ($searchValue) {
          $query->where('min_bracket', 'like', "%{$searchValue}%")->orWhere('max_bracket', 'like', "%{$searchValue}%");
            })
            ->count();

        $data = [];

        foreach ($classification as $class) {
            $nestedData['sg_no'] = $class->sg_no;
            $nestedData['min_bracket'] = $class->min_bracket;
            $nestedData['max_bracket'] = $class->max_bracket;
            $nestedData['salary_cat'] = $class->salary_cat;
            $nestedData['action'] = '<button class="up-button-green update_sg" style="border-radius: 10px;" data-id='.$class->ref_sg_ID.'>
                                  <span>
                                    Update <i class="fa fa-edit" aria-hidden="true"></i>
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
    public function save_salaryg(Request $request)
{
    $salaryg_num = $request->input('salaryg_num');
    $existing = DB::table('ref_salarygrade')
      ->where('sg_no', $salaryg_num)
      ->count();

    if ($existing > 0) {
      return response()->json(['error' => true]);
    }
    $datadb = DB::transaction(function () use ($request) {
          $inserts_sg = array(
            'sg_no' => $request->input('salaryg_num'),
            'min_bracket' => $request->input('salaryg_frm'),
            'max_bracket' => $request->input('slaryg_to'),
            'salary_cat' => $request->input('salarycat')
          );
        $last_id = DB::table('ref_salarygrade')->insertGetId($inserts_sg);
        return [
          'last_id' => $last_id,
        ];
      });
      return response()->json(['success' => $datadb['last_id']]);
}
public function get_sg(Request $request)
  {
      $query = $request->input('ref_sgno');
      $results = DB::table('ref_salarygrade')->whereRaw("ref_salarygrade.ref_sg_ID = '$query'")
      ->select('*')
      ->get()->first();
      return response()->json($results);
  }
  public function up_salaryg(Request $request)
    {
        $affectedRows = DB::transaction(function () use ($request) {
            $update_sg = [
              'sg_no' => strtoupper($request->input('salaryg_num')),
              'min_bracket' => strtoupper($request->input('salaryg_frm')),
              'max_bracket' => strtoupper($request->input('slaryg_to')),
              'salary_cat' => strtoupper($request->input('salarycat'))
            ];
            return DB::table('ref_salarygrade')->where('ref_sg_ID', $request->input('ref_sgid'))->update($update_sg);
        });
        if ($affectedRows > 0) {
          return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}

