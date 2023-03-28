<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Models\Campus;
use App\Models\Classification;
use App\Models\College;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\Salarygrade;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    $campus = Campus::when($searchValue, function ($query) use ($searchValue) {
      $query->where('campus_key', 'like', "%{$searchValue}%")->orWhere('name', 'like', "%{$searchValue}%");
    })
      ->orderBy($order, $dir)
      ->offset($start)
      ->limit($limit)
      ->get();

    $totalFiltered = Campus::when($searchValue, function ($query) use ($searchValue) {
      $query->where('campus_key', 'like', "%{$searchValue}%")->orWhere('name', 'like', "%{$searchValue}%");
    })
      ->count();

    $data = [];
    foreach ($campus as $row) {
      $nestedData['campus_key'] = $row->campus_key;
      $nestedData['name'] = $row->name;
      $nestedData['cluster_id'] = $row->cluster_id;
      $nestedData['action'] = '
            <button class="up-button-green edit_campus" style="border-radius: 5px;" data-id='  . $row->id . ' >
            <span>
              <i class="fa fa-edit" style="padding:3px;font-size:17px;" aria-hidden="true"></i>
            </span>
          </button>
            
          <button class="up-button delete_campus" style="border-radius: 5px;" data-id=' . $row->id .  ' >
            <span>
              <i class="fa fa-trash" style="color:white;padding:3px;font-size:17px;" aria-hidden="true"></i>
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
  public function save_campus(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      $inserts_campus = array(
        'campus_key' => strtoupper($request->input('campus_key')),
        'name' => strtoupper($request->input('campus_name')),
        'cluster_id' => $request->input('cluster_id')
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
        'cluster_id' => $request->input('cluster_id')
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
      DB::table('campus')->where('id', $request->input('id_campus'))->delete();
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

    $classification = Classification::when($searchValue, function ($query) use ($searchValue) {
      $query->where('classification_name', 'like', "%{$searchValue}%");
    })
      ->orderBy($order, $dir)
      ->offset($start)
      ->limit($limit)
      ->get();

    $totalFiltered = Classification::when($searchValue, function ($query) use ($searchValue) {
      $query->where('classification_name', 'like', "%{$searchValue}%");
    })
      ->count();

    $data = [];

    foreach ($classification as $class) {
      $nestedData['classification_name'] = $class->classification_name;
      $nestedData['status'] = $class->status == 1 ? 'Active' : 'In Active';
      $nestedData['time_stamp'] = $class->time_stamp;
      $nestedData['action'] = $class->status == 1 ? '<label class="switch">
            <input type="checkbox" id="up_status" data-id=' . $class->classification_id . ' checked>
            <span class="slider round"></span>
            </label>' : '<label class="switch">
              <input type="checkbox" id="up_status" data-id=' . $class->classification_id . ' unchecked>
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

    $college = College::when($searchValue, function ($query) use ($searchValue) {
      $query->where('college_unit_name', 'like', "%{$searchValue}%");
    })
      ->join('campus', 'campus.id', '=', 'college_unit.campus_id')
      ->select('college_unit.*', 'campus.name as camp_name')
      ->orderBy($order, $dir)
      ->offset($start)
      ->limit($limit)
      ->get();

    $totalFiltered = College::when($searchValue, function ($query) use ($searchValue) {
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
      $nestedData['action'] = '<button class="up-button remove_coll" style="border-radius: 5px;" data-id=' . $row->cu_no . ' >
            <span>
              <i class="fa fa-trash" style="padding:3px;font-size:17px;" aria-hidden="true"></i>
            </span>
          </button>
          </button>
          <button class="up-button-green edit_coll" style="border-radius: 5px;" data-id=' . $row->cu_no . ' >
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
      return DB::table('college_unit')->where('cu_no', $request->input('id_college'))->delete();
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
      ->select('college_unit.*', 'campus.name as camp_name', 'campus.id as camp_id')
      ->get()->first();
    return response()->json($results);
  }

  public function filter_college_unit(Request $request)
  {

    $query = $request->camp_id;

    if ($query === "all") {
      $results = DB::table('college_unit')->get();
    } else {
      $results = DB::table('college_unit')->whereRaw("college_unit.campus_id = '$query'")
        ->join('campus', 'campus.id', '=', 'college_unit.campus_id')
        ->select('college_unit.*', 'campus.name as camp_name', 'campus.id as camp_id')
        ->orderBy('college_unit_name', 'asc')->get();
    };
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

    $dept = Department::when($searchValue, function ($query) use ($searchValue) {
      $query->where('department_name', 'like', "%{$searchValue}%");
    })
      ->join('campus', 'campus.id', '=', 'department.campus_id')
      ->join('college_unit', 'department.cu_no', '=', 'college_unit.cu_no')
      ->select('department.*', 'campus.name as camp_name', 'college_unit.college_unit_name')
      ->orderBy($order, $dir)
      ->offset($start)
      ->limit($limit)
      ->get();

    $totalFiltered = Department::when($searchValue, function ($query) use ($searchValue) {
      $query->where('department_name', 'like', "%{$searchValue}%");
    })
      ->join('campus', 'campus.id', '=', 'department.campus_id')
      ->join('college_unit', 'department.cu_no', '=', 'college_unit.cu_no')
      ->select('department.*', 'campus.name as camp_name', 'campus_id', 'cu_no', 'college_unit.college_unit_name')
      ->count();

    $data = [];

    foreach ($dept as $row) {
      $nestedData['department_name'] = $row->department_name;
      $nestedData['camp_name'] = $row->camp_name;
      $nestedData['college_unit_name'] = $row->college_unit_name;
      $nestedData['time_stamp'] = $row->time_stamp;
      $nestedData['action'] = '<button class="up-button remove_dept" style="border-radius: 5px;" data-id=' . $row->dept_no . ' >
            <span>
              <i class="fa fa-trash" style="padding:3px;font-size:17px;" aria-hidden="true"></i>
            </span>
          </button>
          </button>
          <button class="up-button-green edit_dept" id="editDepartment" style="border-radius: 5px;" 
          data-id=' . $row->dept_no . '  data-campus_id=' . $row->campus_id . ' data-cu_no=' . $row->cu_no . '>
            <span>
              <i class="fa fa-edit"  style="padding:3px;font-size:17px;" aria-hidden="true"></i>
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
      DB::table('department')->where('dept_no', $request->input('id_dept'))->delete();
    });
    return response()->json(['success' => true]);
  }
  public function get_department(Request $request)
  {
    $query = $request->input('id_department');
    $results = DB::table('department')->whereRaw("department.dept_no = '$query'")
      ->join('campus', 'campus.id', '=', 'department.campus_id')
      ->join('college_unit', 'department.cu_no', '=', 'college_unit.cu_no')
      ->select('department.*', 'campus.name as camp_name', 'college_unit.college_unit_name')
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

    $classification = Appointment::when($searchValue, function ($query) use ($searchValue) {
      $query->where('appointment_name', 'like', "%{$searchValue}%");
    })
      ->orderBy($order, $dir)
      ->offset($start)
      ->limit($limit)
      ->get();

    $totalFiltered = Appointment::when($searchValue, function ($query) use ($searchValue) {
      $query->where('appointment_name', 'like', "%{$searchValue}%");
    })
      ->count();

    $data = [];

    foreach ($classification as $class) {
      $nestedData['appointment_name'] = $class->appointment_name;
      $nestedData['status'] = $class->status_flag == 1 ? 'Active' : 'In Active';
      $nestedData['time_stamp'] = $class->time_stamp;
      $nestedData['action'] = $class->status_flag == 1 ? '<label class="switch">
              <input type="checkbox" id="up_status" data-id=' . $class->appoint_id . ' checked>
              <span class="slider round"></span>
              </label>' : '<label class="switch">
                <input type="checkbox" id="up_status" data-id=' . $class->appoint_id . ' unchecked>
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

    $classification = Salarygrade::when($searchValue, function ($query) use ($searchValue) {
      $query->where('min_bracket', 'like', "%{$searchValue}%")->orWhere('max_bracket', 'like', "%{$searchValue}%");
    })
      ->orderBy($order, $dir)
      ->offset($start)
      ->limit($limit)
      ->get();

    $totalFiltered = Salarygrade::when($searchValue, function ($query) use ($searchValue) {
      $query->where('min_bracket', 'like', "%{$searchValue}%")->orWhere('max_bracket', 'like', "%{$searchValue}%");
    })
      ->count();

    $data = [];

    foreach ($classification as $class) {
      $nestedData['sg_no'] = $class->sg_no;
      $nestedData['min_bracket'] = $class->min_bracket;
      $nestedData['max_bracket'] = $class->max_bracket;
      $nestedData['salary_cat'] = $class->salary_cat;
      $nestedData['action'] = '<button class="up-button-green update_sg" style="border-radius: 10px;" data-id=' . $class->ref_sg_ID . '>
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
  public function users_table(Request $request)
  {
    $columns = [
      0 => 'email',
      1 => 'password',
      2 => 'full_name',
      3 => 'campus_name',
      4 => 'user_level',
      5 => 'status_flag',
    ];
    $totalData = Users::count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $searchValue = $request->input('search.value');

    $users = Users::when($searchValue, function ($query) use ($searchValue) {
      $query->where('email', 'like', "%{$searchValue}%")
        ->orWhere('first_name', 'like', "%{$searchValue}%")
        ->orWhere('middle_name', 'like', "%{$searchValue}%")
        ->orWhere('last_name', 'like', "%{$searchValue}%");
    })
      ->Leftjoin('campus', 'campus.id', '=', 'users.campus_id')
      ->select('users.*', 'campus.name as camp_name')
      ->orderBy($order, $dir)
      ->offset($start)
      ->limit($limit)
      ->get();

    $totalFiltered = Users::when($searchValue, function ($query) use ($searchValue) {
      $query->where('email', 'like', "%{$searchValue}%")
        ->orWhere('first_name', 'like', "%{$searchValue}%")
        ->orWhere('middle_name', 'like', "%{$searchValue}%")
        ->orWhere('last_name', 'like', "%{$searchValue}%");
    })
      ->Leftjoin('campus', 'campus.id', '=', 'users.campus_id')
      ->count();

    $data = [];

    foreach ($users as $class) {
      $nestedData['email'] = $class->email;
      $nestedData['intial_password'] = $class->intial_password;
      $nestedData['full_name'] = $class->first_name . ' ' . $class->middle_name . ' ' . $class->last_name;
      $nestedData['camp_name'] = $class->camp_name;
      $nestedData['user_level'] = $class->user_level;
      $nestedData['status_flag'] = $class->status_flag == 1 ? 'Active' : 'In Active';
      $nestedData['password_set'] = $class->password_set == 1 ? 'Changed Password' : 'Not yet change';
      $nestedData['action'] = '<button class="up-button remove_users" style="border-radius: 5px;" data-id=' . $class->id . ' >
            <span>
              <i class="fa fa-trash" style="padding:3px;font-size:17px;" aria-hidden="true"></i>
            </span>
          </button>
          </button>
          <button class="up-button-green edit_users" style="border-radius: 5px;" data-id=' . $class->id . ' >
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
  public function save_users(Request $request)
  {

    $datadb = DB::transaction(function () use ($request) {
      $inserts_users = array(
        'first_name' => strtoupper($request->input('firstname')),
        'middle_name' => strtoupper($request->input('middlename')),
        'last_name' => strtoupper($request->input('lastname')),
        'email' => $request->input('email'),
        'intial_password' => $request->input('initial_pass'),
        'password' => Hash::make($request->input('initial_pass')),
        'contact_no' => $request->input('contact_no'),
        'user_level' => strtoupper($request->input('user_level')),
        'campus_id' => $request->input('campus'),
      );
      $last_id = DB::table('users')->insertGetId($inserts_users);
      $inserts_user_prev = array(
        'users_id' => $last_id,
        'setting_config' => $request->input('setting_access'),
        'election_mod' => $request->input('election_access'),
        'loan_mod' => $request->input('loan_access'),
        'benifits_mod' => $request->input('benifits_access'),
        'trans_equity_mod' => $request->input('transaction_access'),
        'memberapp_mod' => $request->input('memberapp_access'),
        'member_mod' => $request->input('membermod_access'),
      );
      $last_userprev = DB::table('user_prev')->insertGetId($inserts_user_prev);
      return [
        'last_id' => $last_id,
        'prev_id' => $last_userprev
      ];
    });
    return response()->json(['success' => $datadb['last_id'], 'prev_id' => $datadb['prev_id']]);
  }
  public function update_users(Request $request)
  {

    $affectedRows = DB::transaction(function () use ($request) {
      DB::enableQueryLog();
      $users_id = $request->input('users_id');
      // Check if the user exists in the user_prev table
      $userPrevExists = DB::table('user_prev')->where('users_id', $request->input('users_id'))->count();
      if ($request->input('user_level') == 'CFM') {
        $cfm_clus = $request->input('cfm_cluster');
      } else if ($request->input('user_level') == 'AA') {
        $cfm_clus = $request->input('cfm_cluster');
      } else {
        $cfm_clus = 0;
      }
      $update_users = array(
        'first_name' => strtoupper($request->input('firstname')),
        'middle_name' => strtoupper($request->input('middlename')),
        'last_name' => strtoupper($request->input('lastname')),
        'email' => $request->input('email'),
        'intial_password' => $request->input('initial_pass'),
        'contact_no' => $request->input('contact_no'),
        'user_level' => $request->input('user_level'),
        'campus_id' => $request->input('campus'),
      );
      DB::table('users')->where('id', $users_id)->update($update_users);
      if ($userPrevExists != 0) {
        $update_user_prev = array(
          'setting_config' => $request->input('setting_access'),
          'election_mod' => $request->input('election_access'),
          'loan_mod' => $request->input('loan_access'),
          'benifits_mod' => $request->input('benifits_access'),
          'trans_equity_mod' => $request->input('transaction_access'),
          'memberapp_mod' => $request->input('memberapp_access'),
          'member_mod' => $request->input('membermod_access'),
          'cfm_cluster' => $cfm_clus,
        );
        return DB::table('user_prev')->where('users_id', $users_id)->update($update_user_prev);
        // Insert the user_prev into the user_prev table
      } else {
        $update_user_prev = array(
          'users_id' => $users_id,
          'setting_config' => $request->input('setting_access'),
          'election_mod' => $request->input('election_access'),
          'loan_mod' => $request->input('loan_access'),
          'benifits_mod' => $request->input('benifits_access'),
          'trans_equity_mod' => $request->input('transaction_access'),
          'memberapp_mod' => $request->input('memberapp_access'),
          'member_mod' => $request->input('membermod_access'),
          'cfm_cluster' => $cfm_clus,
        );
        DB::table('user_prev')->insert($update_user_prev);
      }
    });

    // if ($affectedRows > 0) {
    return response()->json(['success' => $affectedRows]);
    // } else {
    //     return response()->json(['success' => false]);
    // }
  }

  public function get_users(Request $request)
  {
    $query = $request->input('users_id');
    $results = DB::table('users')->whereRaw("users.id = '$query'")
      ->Leftjoin('user_prev', 'users.id', '=', 'user_prev.users_id')
      ->select('*')
      ->get()->first();
    return response()->json($results);
  }
  public function remove_users(Request $request)
  {
    $datadb = DB::transaction(function () use ($request) {
      DB::table('users')->where('id', $request->input('users_id'))->delete();
      DB::table('user_prev')->where('users_id ', $request->input('users_id'))->delete();
    });
    return response()->json(['success' => true]);
  }
}
