<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\MediaContent;
use App\Models\Publications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Customer;

class AgentDashboardController extends Controller
{
     public function __construct()
    {
     
        $this->middleware('isAgent');
    }

    public function dashboard()
    {
		$title = 'Dashboard';
		$module_name = 'dashboard';
		$data = array();
		$user_id = Auth::guard('misagent')->user()->id;
		 
		$data = array();
        $data['total_customer_today'] = Customer::where('sub_admin_id',$user_id)->whereDate('created_at','>=',date('Y-m-d'))->whereDate('created_at','<=',date('Y-m-d'))->count();  
        
		$data['total_pending_customer_today'] = Customer::where('sub_admin_id',$user_id)->where('status',0)->whereDate('created_at','>=',date('Y-m-d'))->whereDate('created_at','<=',date('Y-m-d'))->count(); 
        $data['total_approve_customer_today'] = Customer::where('sub_admin_id',$user_id)->where('status',1)->whereDate('created_at','>=',date('Y-m-d'))->whereDate('created_at','<=',date('Y-m-d'))->count(); 
        $data['total_reject_customer_today'] = Customer::where('sub_admin_id',$user_id)->where('status',2)->whereDate('created_at','>=',date('Y-m-d'))->whereDate('created_at','<=',date('Y-m-d'))->count(); 
          
        $data['total_customer'] = Customer::where('sub_admin_id',$user_id)->count(); 
        $data['total_pending_customer'] = Customer::where('sub_admin_id',$user_id)->where('status',0)->count(); 
        $data['total_approve_customer'] = Customer::where('sub_admin_id',$user_id)->where('status',1)->count(); 
        $data['total_reject_customer'] = Customer::where('sub_admin_id',$user_id)->where('status',2)->count(); 
        
        DB::disconnect();
        return view('agent.dashboard',compact('data','title','module_name'));
    }

    public function profile()
    {
        return view('agent.profile');
    }

    public function changePassword()
    {
        return view('admin.change-password');
    }

    public function changePasswordPost(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        try {
            if ($request->current_password != $request->new_password) {
                if ($request->new_password == $request->new_password_confirmation) {
                    $user = User::find(Auth::guard('misadmin')->user()->id);
                    $user->password = $request->new_password;
                    $user->save();

                    return redirect()->back()->with('success', __('message.changed_success'));
                } else {
                    return redirect()->back()->with('error', __('message.not_match'));
                }
            } else {
                return redirect()->back()->with('error', __('message.both_password_same'));
            }
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->back()->with('error', 'Invalid Credentials.');
        }
    }


     
 
}
