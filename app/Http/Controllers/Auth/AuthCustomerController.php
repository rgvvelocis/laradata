<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Auth;
use Illuminate\Http\Request;

class AuthCustomerController extends Controller
{
    //

    protected $redirectTo = '/';

    protected $guard = 'miscust';

    public function __construct()
    {
        $this->middleware('guest:miscust')->except('logout');
    }

    public function customerlogin()
    {
        return view('auth.customer_login');
    }

   

    public function login(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'required',
                'password' => 'required',                 
            ] 
        );

        try {
             
            $user = Customer::where('username', $request->input('username'))
			->where('password', $request->input('password'))
            ->where('user_status', '=', 1)             
            ->first();
		  
            if ($user) {                 
                if ($user->password != $request->password) {
                    return redirect()->back()->with('error', 'Invalid Password!!');
                } else {
                    Auth::guard('miscust')->loginUsingId($user->id);

                    return redirect()->route('customer.dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid Username, Password or account is not active!!');
            }

            return redirect()->back()->with('error', 'Invalid Username or Password!!');
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->back()->with('error', 'Invalid Username or Password!!');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('miscust')->logout();
        $request->session()->flush();

        return redirect()->route('customerlogin');
    }
}
