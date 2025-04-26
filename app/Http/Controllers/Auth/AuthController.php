<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    protected $redirectTo = '/';

    protected $guard = 'misadmin';

    public function __construct()
    {
        $this->middleware('guest:misadmin')->except('logout');
    }

    public function adminlogin()
    {
        return view('auth.login');
    }

    public function refreshCaptcha()
    {
        echo captcha_img('default');
        exit;
    }

    public function superadmin(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required',                 
            ] 
        );

        try {
            //////// check password for security purpose ///////////
          // echo hash('sha256', 'admin@123');
          // die;
            $user = User::
			where(function($q) use ($request){
				$q->where('admin_email', $request->input('email'))
				->orWhere('username', $request->input('email'));
			})
				
			//->where('password', $request->input('password'))
            ->where('is_active', '=', 1)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->first();
		 
            if ($user) {   
                $userPass = hash('sha256', $user->password.session('salt'));              
                if ($userPass != $request->password) {
                    return redirect()->back()->with('error', 'Invalid Password!!');
                } else {
                    Auth::guard('misadmin')->loginUsingId($user->id);

                    return redirect()->route('admin.dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid Username or Password!!');
            }

            return redirect()->back()->with('error', 'Invalid Username or Password!!');
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->back()->with('error', 'Invalid Username or Password!!');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('misadmin')->logout();
        $request->session()->flush();

        return redirect()->route('adminlogin');
    }
}
