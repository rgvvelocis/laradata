<?php

namespace App\Http\Controllers\Agent;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Mail\WelcomeMail;
use RealRashid\SweetAlert\Facades\Alert;
use Hash;
use Auth; 
use App\Models\Role;
use App\Models\Plan; 
// use App\Models\State; 
// use App\Models\City; 
use App\Models\Customer; 
use App\Models\DataAssigned; 
use DB;

class AgentUserController extends Controller
{
	
	public function __construct()
    {
        $this->middleware('isAgent');		 
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function addAgentUser(Request $request)
	{	
		$title = 'Add User';
		$module_name = 'add_user';
		
		$plans = Plan::get();
		return view('agent.add_agent_user',compact('plans','title','module_name'));
        
    }
	
	 
	
	public function saveAgentUser(Request $request)
	{
		try{		 
		$this->validate($request, [ 
				'customer_name' => 'required',
				'customer_email' => 'required|unique:lara_customers,customer_email',
				'customer_mobile' => 'required|unique:lara_customers,customer_mobile',
				'agreement_file' => 'required|mimes:pdf', 
				//'upload_letterhead' => 'required|mimes:jpeg,jpg,png',
				//'company_stamp' => 'required|mimes:jpeg,jpg,png',
			]);
			
			$agreement_file = '';
            if ($request->hasFile('agreement_file')) {
				$name=$request->file('agreement_file')->getClientOriginalName();
					$isValid_Extention_Size = explode('.', $name);					 
					//if(count($isValid_Extention_Size) <= 2){
						if (in_array(strtolower($request->file('agreement_file')->getClientOriginalExtension()), ['pdf'])) {
							$documentRootPath = public_path().'/uploads/agreement/';
							$agreement_file = time().rand().'agreement_file.'.$request->file('agreement_file')->getClientOriginalExtension();
							$request->file('agreement_file')->move($documentRootPath, $agreement_file);
						}else{
							Alert::error('File Error', "Please upload valid File.(PDF)");
							return redirect()->back()->with('loader',true);
						}
				//}else{
					//Alert::error('File Error', "Please upload valid File.");
					//return redirect()->back()->with('loader',true);
				//	}
            }
			
			 
			
			 
			
			//$username = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 36)), 0, 6); 
			//$password = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 36)), 0, 6);

			$plan = Plan::where('id',$request->user_plan)->first();
			$user_reg_date = date('Y-m-d', strtotime('+1 days'));
			$user_sub_date = date('Y-m-d', strtotime('+'.($plan["plan_duration"]).' days'));
			
			$insertData = array(
                'admin_id' => Auth::guard('misagent')->user()->admin_id,
                'sub_admin_id' => Auth::guard('misagent')->user()->id,
				'username' => $request->customer_email,
				'password' => $request->customer_mobile,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_mobile' => $request->customer_mobile,
                'customer_altmobile' => $request->customer_altmobile,
                'status' => '1',                 
				'user_plan' => $request->user_plan,
				'status_date' => date('Y-m-d H:i:s'),
				'user_reg_date' => $user_reg_date,
				'user_sub_date' => $user_sub_date,                
                'agreement_pdf' => $agreement_file,				 
				'steps' => '2',				
                'token' => random_string(45),
                
            );
			$customer = Customer::create($insertData);
			
			$this->assignedData($customer->id,$plan);
			//$welcomeEmailSent = Mail::to($user->customer_email)->send(new WelcomeMail($user));

			$template = view('emails.welcome',compact('customer'))->render();
            $subject = 'Registration Successfully-Find your Login details!!';
            send_mailTemplate($customer->customer_email,$subject,$template);
 


			Alert::success('Success', 'User created successfully');
			return redirect()->route('agent.approved');
		  
		}catch(\Swift_TransportException $transportExp){
			Alert::success('Success', 'Admin created successfully but email not sent!!');
			return redirect()->route('agent.approved');
		}catch(Exception $e){
			Alert::error('Error', $e->getMessage());
			\Log::error($e->getMessage());
			abort(404);
		 }catch (\Illuminate\Database\QueryException $exception) {
			  Alert::error('Error', $exception->getMessage());
			  \Log::error($exception->getMessage());
			  Alert::error('error', "Query Exception");
			  return redirect()->back();               
		}
		
	}


	public function assignedData($userid,$plandata) {
        $dataassign = array();
 
        $assdata = DataAssigned::where('user_id',$userid)->where('plan_id', $plandata->id)->count(); 
		 $i=1;
        if ($assdata ==0 ) {
            
            $plantotalform = $plandata->plan_total_forms;
            $assigndata = DB::select("SELECT * FROM (SELECT * FROM  `lara_maindata`  ORDER BY  RAND() LIMIT  ".$plantotalform.") `lara_maindata`  ORDER BY `id` ASC ");
            foreach ($assigndata as $key => $value) {
                $dataid = $value->id;
                $dataassign['sr_no'] = $i;
                $dataassign['user_id'] = $userid;
                $dataassign['plan_id'] = $plandata->id;
                $dataassign['data_form_id'] = $dataid;
				
				DataAssigned::create($dataassign);                
                $i++;
            }
            
		  return true;
        }
    }
	
	
	 
	
	
	 

    
   /* public function pendinglist(Request $request)	
    {	
		$title = 'Pending Customer List';
		$module_name = 'pending_customer_list';
		
		$data = Customer::with('parentUser')->where('sub_admin_id',Auth::guard('misagent')->user()->id)->where('status',0)->orderBy('id','DESC')->paginate(10);	
		DB::disconnect();
		return view('agent.agreement_report.pendinglist',compact('data','title','module_name'))
             ->with('j', ($request->input('page', 1) - 1) * 10);
    } */


    public function approved(Request $request)	
    {	
		$title = 'Approved Customer List';
		$module_name = 'approved_customer_list';

		$name = $request->input('name');
        $contact = $request->input('contact');
		
		$list=Customer::query(); 
        $list->with('parentUser')
			->where('sub_admin_id',Auth::guard('misagent')->user()->id)
			->where('status',1);
		
			if ($name) {
				$list->where(function ($query) use ($name) {
					$query->where('username', 'like', '%' . $name . '%')->Orwhere('customer_email', 'like', '%' . $name . '%')
					->orWhere('lara_customers.customer_name', 'like', '%' . $name . '%');
				});
			}    
			if ($contact) {
				$list->where('customer_mobile', 'like', '%' . $contact . '%');
			} 
		$list->orderBy('created_at','DESC'); 
		$data = $list->paginate(10); 	
		
        DB::disconnect();
		return view('agent.agreement_report.approved',compact('data','title','module_name'))
			 ->with('j', ($request->input('page', 1) - 1) * 10);
    }


    /* public function reject(Request $request)	
    {	
		$title = 'Rejected Customer List';
		$module_name = 'reject_customer_list';
		
        $data = Customer::with('parentUser')->where('sub_admin_id',Auth::guard('misagent')->user()->id)->where('status',2)->orderBy('id','DESC')->paginate(10);
        DB::disconnect();

		return view('agent.agreement_report.reject',compact('data','title','module_name'))
			 ->with('j', ($request->input('page', 1) - 1) * 10);
    } */



	public function deleteAgentUser(Request $request)
	{
		//abort_unless(\Gate::allows($this->module_name.'_delete'), 403);
        Customer::where('id',$request->id)->delete();
		Alert::success('Success', 'Customer deleted successfully');
         return redirect()->route('agent.pendinglist')->with('loader', true);
	}



     
	
  
}
