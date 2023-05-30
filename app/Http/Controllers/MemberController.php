<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DB;
use Hash;
use DataTables;

use App\Models\OLDBeneficiaries;
use App\Models\User;

class MemberController extends Controller
{

  // public function __construct()
  // {
  //   $this->middleware('auth');
  // }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function dashboard()
  {
    if (Auth::check()) {

      $lastLogin = '';
      $loginCount = DB::table('login_logs')
        ->where('user_id', Auth::user()->id)
        ->count();
      $loginNew = DB::table('login_logs')
        ->where('user_id', Auth::user()->id)
        ->orderBy('login_date', 'DESC')
        ->first();
      if ($loginCount == 1) {
        if ($loginNew) {
          $lastLogin = $loginNew->login_date;
        }
      } else {
        $login = DB::table('login_logs')
          ->where('user_id', Auth::user()->id)
          ->orderBy('login_date', 'DESC')
          ->skip(1)
          ->first();
        if ($login) {
          $lastLogin = $login->login_date;
        }
      }
      $member = User::where('users.id', Auth::user()->id)
      ->select('*', 'member.id as member_id', 'member_detail.*', 'users.id as user_id', 'campus.name as campus_name')
      ->leftjoin('member', 'users.id', '=', 'member.user_id')
      ->leftjoin('member_detail', 'member_detail.member_no', '=', 'member.member_no')
      ->leftjoin('campus', 'member.campus_id', '=', 'campus.id')
      ->first();
      $campuses = DB::table('campus')->get();
      $department = DB::table('department')->where('campus_id', $member->campus_id)->get();
      $membership = DB::table('mem_app')->where('employee_no', $member->employee_no)->get();
      $beneficiaries = DB::table('old_beneficiaries')->where('member_no', $member->member_no)->get();;
      $data = array(
        'login' => $lastLogin,
        'member' => $member,
        'campuses' => $campuses,
        'department' => $department,
        'membership' => $membership,
        'beneficiaries' => $beneficiaries,
        // 'user_privileges' => DB::table('users')
        // ->join('user_prev', 'users.id', '=', 'user_prev.users_id')
        // ->where('users.id', $user->id)
        // ->get()
      );
      return view('member.dashboard')->with($data);
    } else {
      return redirect('/login');
    }
  }

  public function settings()
  {
    if (Auth::check()) {
      return view('member.settings');
    } else {
      return redirect('/login');
    }
  }

  public function transaction()
  {
    if (Auth::check()) {
      return view('member.transaction');
    } else {
      return redirect('/login');
    }
  }
  public function loan()
  {
    if (Auth::check()) {
      return view('member.loan_application.index');
    } else {
      return redirect('/login');
    }
  }

  public function new_loan()
  {
    if (Auth::check()) {
      return view('member.loan_application.new_loan');
    } else {
      return redirect('/login');
    }
  }

  public function member()
  {
    if (Auth::check()) {
      return view('member.member');
    } else {
      return redirect('/login');
    }
  }

  public function equity()
  {
    if (Auth::check()) {
      return view('member.equity');
    } else {
      return redirect('/login');
    }
  }

  public function updatepassword()
  {
    if (Auth::check()) {
      return view('member.updatepassword');
    } else {
      return redirect('/login');
    }
  }

  public function application()
  {
    if (Auth::check()) {
      return view('member.loan_application.calculator');
    } else {
      return redirect('/login');
    }
  }

  public function schedule()
  {
    if (Auth::check()) {
      return view('member.loan_application.schedule');
    } else {
      return redirect('/login');
    }
  }

  public function submission()
  {
    if (Auth::check()) {
      return view('member.loan_application.submission');
    } else {
      return redirect('/login');
    }
  }

  public function view()
  {
    if (Auth::check()) {
      return view('member.loan_application.view');
    } else {
      return redirect('/login');
    }
  }

  public function changePassword(Request $request)
  {
    $this->validate($request, [
      'current_password' => 'required',
      'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
      return response()->json(['message' => 'Current password is incorrect'], 401);
    }
    $hashedPassword = Hash::make($request->new_password);

    DB::table('users')->where('id', $user->id)->update(['password' => $hashedPassword]);

    return response()->json(['message' => 'Password changed successfully']);
  }

   //add old beneficiaries
   public function addMemberBeneficiaries(Request $request)
   {
 
     $added_by = Auth::user()->id;

     $member = DB::table('member')->where('user_id', Auth::user()->id)->get();

     $payload = array(
       'member_no' => $member[0]->member_no,
       'beni_name' => $request->get('beni_name'),
       'relationship' =>  $request->get('relationship'),
       'birth_date' => $request->get('birth_date'),
       'added_by' => $added_by,
     );
     $insertOldBeneficiaries = DB::table('old_beneficiaries')->insert($payload);
 
     if (!empty($insertOldBeneficiaries)) {
       return response()->json(['success' => true]);
     } else {
       return response()->json(['success' => false]);
     }
   }

 
   //delete old beneficiaries
   public function deleteOldMemberBeneficiaries(Request $request)
   {
     $deleteOldBeneficiaries = DB::table('old_beneficiaries')->where('id', $request->get('beneficiary_id'))->delete();
 
     if (!empty($deleteOldBeneficiaries)) {
       return response()->json(['success' => true]);
     } else {
       return response()->json(['success' => false]);
     }
   }


}


