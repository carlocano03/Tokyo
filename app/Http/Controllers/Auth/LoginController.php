<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Hash;
use DB;

use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function login(Request $request)
    {
        $credentials = $this->credentials($request);
        if ($request->usertype == 'member') {
            $member = DB::table('member')->where('member_no', $request->memberNo)
                ->leftJoin('users', 'member.user_id', '=', 'users.id')
                ->first();
            if ($member) {
                if ($member->membership_status == 'ACTIVE' || $member->membership_status == 'WITHDREW' || $member->membership_status == 'INACTIVE') {
                    $credentials[$this->username()] = $member->email;
                } else {
                    return redirect('login')->with(['error' => 'This account is no longer active.', 'user' => $request->memberNo]);
                }
            } else {
                return redirect('login')->with(['error' => 'The member ID is incorrect.', 'user' => $request->memberNo]);
            }
        }

        if (Auth::attempt($credentials)) {
            if ($request->usertype == 'admin') {
                $user = User::find(Auth::user()->id);
                if ($user->password_set == 0) {
                    // return redirect('/admin/onboarding');
                    return redirect('/admin/dashboard');
                } else {
                    $insertLoginHistory = array(
                        'user_id' => Auth::user()->id,
                    );
                    DB::table('login_logs')->insert($insertLoginHistory);
                    return redirect('/admin/dashboard');
                }
            } else {
                $user = User::find(Auth::user()->id);
                if ($user->password_set == 0) {
                    // return redirect('/admin/onboarding');
                    return redirect('/member/dashboard');
                } else {
                    $insertLoginHistory = array(
                        'user_id' => Auth::user()->id,
                    );
                    DB::table('login_logs')->insert($insertLoginHistory);
                    return redirect('/member/dashboard');
                }
            }
        } else {
            $url = '';
            $error = '';
            if ($request->usertype == 'admin') {
                $url = 'admin';
                $error = 'The email or password you entered is incorrect.';
                $user = $request->email;
            } else {
                $url = 'login';
                $error = 'The member ID or password you entered is incorrect.';
                $user = $request->memberNo;
            }

            return redirect($url)->with(['error' => $error, 'user' => $user]);
        }
    }
}
