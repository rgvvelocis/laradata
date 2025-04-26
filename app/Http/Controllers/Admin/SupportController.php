<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use RealRashid\SweetAlert\Facades\Alert;
use Hash;
use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Plan; 
use DB;

class SupportController extends Controller
{
	
	public function __construct()
    {
        // Page Title
        $this->module_title = 'Support List';
        // module name
        $this->module_name = 'support';
		$this->model_name = 'App\Models\User';
     
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		abort_unless(\Gate::allows($this->module_name.'_list'), 403);
		$data = User::where('type','=',3)->orderBy('id','DESC')->paginate(10);
		DB::disconnect();
		return view('admin.supports.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()	
    {		
			abort_unless(\Gate::allows($this->module_name.'_create'), 403);
			$users = User::get();	 
			$roles = Role::whereNotIn('title',['Super Admin'])->get();		 
			$plans = Plan::all();
			
			return view('admin.supports.create',compact('roles','plans','users'));		  
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	 
		abort_unless(\Gate::allows($this->module_name.'_create'), 403);
		try{
		 //pr($request->all());
			$this->validate($request, [ 
				'company_name' => 'required',
				'password' => 'required',
				'admin_email' => 'required|unique:users,admin_email',
				'contact' => 'required',				  
				'userStatus' => 'required', 
				 
      ],[         
        'company_name.required' => 'Support name is required.',
        'admin_email.required' => 'Support email is required.',
    ]);
			 
			$username = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 36)), 0, 6); 
			//$password = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 36)), 0, 6);
      $password = hash('sha256', $request->password);
			
			$insertData = array(
					'type' => 3,
					'company_name' => $request->company_name,
					'admin_email' => $request->admin_email,
					'username' => $username,
					'password' => $password,
					'contact' => $request->contact,
					'status' => $request->userStatus,					 
					'token' => random_string(45),
				);
		    
			$user = User::create($insertData);
			 $user->roles()->attach(3);
			 
			/* $emailData = ([
				 
				 'name' => $request->name,
				 'email' => $request->email,
				 'password' => $request->password_test,
				  
				 ]);	 */
	
			//$welcomeEmailSent = Mail::to($request->email)->send(new WelcomeMail($emailData));
			 
			Alert::success('Success', 'Support created successfully');
			return redirect()->route('admin.supports.index');
		  
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
 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		 
    }  


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		abort_unless(\Gate::allows($this->module_name.'_edit'), 403);
        $user = User::find($id);
        $users = User::get();
        $roles = Role::whereNotIn('title',['Super Admin'])->get();
        
        return view('admin.supports.edit',compact('user','users','roles'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		abort_unless(\Gate::allows($this->module_name.'_edit'), 403);
		
		try{
				$this->validate($request, [				  
					'company_name' => 'required',
					'admin_email' => 'required|unique:users,admin_email,'.$id,
					'contact' => 'required',					 
					'userStatus' => 'required', 					 
					
                ]);	
				
				$updateData = array(					 
					'company_name' => $request->company_name,
					'admin_email' => $request->admin_email,					 
					'contact' => $request->contact,	
					'status' => $request->userStatus,				 
					 
				);
				$user = User::find($id);
				$user->update($updateData);
                //DB::table('role_user')->where('user_id',$id)->delete();
                //$user->roles()->attach($request->user_type);
				 
			Alert::success('Success', 'Support updated successfully');
			return redirect()->route('admin.supports.index');
		
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
	
	

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		abort_unless(\Gate::allows($this->module_name.'_delete'), 403);
        User::find($id)->delete();
        return redirect()->route('admin.supports.index')
                        ->with('success','Support deleted successfully');
    }
	
	
	/**
     * Getting district list by using state it AJAX
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
	 
     */
	 public function getDistrict(Request $request){ 
        $data = getDistrict($request->state);
        return json_encode(array('data'=>$data));

    }
}
