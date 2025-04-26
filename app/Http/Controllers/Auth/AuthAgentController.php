<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Auth;
use Illuminate\Http\Request;

class AuthAgentController extends Controller
{
    //

    protected $redirectTo = '/';

    protected $guard = 'misagent';

    public function __construct()
    {
        $this->middleware('guest:misagent')->except('logout');
    }

    public function agentlogin()
    {
        return view('auth.agent_login');
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
            //////// check password for security purpose ///////////

            $user = Agent::where('username', $request->input('username'))
			->where('user_password', $request->input('password'))
            ->where('is_active', '=', 0)             
            ->first();
		  
            if ($user) {                 
                if ($user->user_password != $request->password) {
                    return redirect()->back()->with('error', 'Invalid Username or Password!!');
                } else {
                    Auth::guard('misagent')->loginUsingId($user->id);

                    return redirect()->route('agent.dashboard');
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
        Auth::guard('misagent')->logout();
        $request->session()->flush();

        return redirect()->route('agentlogin');
    }
}
