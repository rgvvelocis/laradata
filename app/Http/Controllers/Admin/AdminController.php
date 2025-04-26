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
use App\Models\Customer; 
use App\Models\Agent; 
use App\Models\DataAssigned; 
use App\Models\CustomerFormData; 
use App\Models\FinalSubmission; 
use DB;
use Image;
use App;
use Yajra\DataTables\DataTables;


class AdminController extends Controller
{
	
	public function __construct()
    {
        //$this->middleware('isBusiness');		 
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		abort_unless(\Gate::allows('user_access'), 403);
		$list = User::where('type','=',2)->orderBy('id','DESC');
		if ($request->ajax()) {

			return Datatables::of($list)
				   ->addIndexColumn()
				   ->addColumn('action', function($row){
						$btn = '<a class="btn btn-primary_ btn-icon waves-effect waves-light" href="'.route('admin.resetPassword',[$row->token,'admin.admin.index']).'" alt="Change Password"> <i class="ri-key-2-fill"></i></a>';
						$btn .= '<a class="btn btn-primary_ btn-icon waves-effect waves-light" href="'.route('admin.admin.edit',[$row->id]).'" alt="Edit"><i alt="Edit" class="ri-pencil-fill align-bottom"></i></a>';
						//$btn .= '<a class="btn btn-primary_ btn-icon waves-effect waves-light" href="'.route('admin.admin.destroy',[$row->id]).'" alt="Delete"><i class="ri-delete-bin-5-line"></i></a>';
						$btn .= '<a href="JavaScript:void(0);" data-href="'.route('admin.admin.destroy',[$row->id]).'" class="deletedata" data-value="'.$row->id.'"><span><i class="mdi mdi-delete-circle text-muted fs-16 align-middle me-1" data-toggle="tooltip" title="Delete"></i></span></a>';
						
					   return $btn;
				   })
				   ->editColumn('username', function ($row) {
					   return $row->username;
					})
				    
				   ->editColumn('password', function ($row) {
					   return $row->password;
					})
				   ->editColumn('company_name', function ($row) {
					   return $row->company_name;
					})
				   ->editColumn('admin_email', function ($row) {
					   return $row->admin_email;
					})
				   ->editColumn('company_logo', function ($row) {
						if(!empty($row->company_logo)){
							return '<a href="'.asset('public/uploads/admin/company/'.$row->company_logo).'" target="_BLANK">View</a>';
						}else{return '';}
					})
				   ->editColumn('upload_letterhead', function ($row) {
						if(!empty($row->upload_letterhead)){
							return '<a href="'.asset('public/uploads/admin/company/'.$row->upload_letterhead).'" target="_BLANK">View</a>';
						}else{return '';}
					})
				   ->editColumn('company_charges', function ($row) {
					   return $row->company_charges;
					})
				   ->editColumn('company_stamp', function ($row) {
						if(!empty($row->company_stamp)){
							return '<a href="'.asset('public/uploads/admin/company/'.$row->company_stamp).'" target="_BLANK">View</a>';
						}else{return '';}
					})
				    

					->addColumn('status', function ($row) {
						if($row->is_active == '1')
						{
						   return '<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
												<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick="userStatus('.$row->id.',2)" checked />
											</div>';
						}else{
						   return '<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
												<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick="userStatus('.$row->id.',1)"  >
											</div>';
						}


					})
				   ->rawColumns(['action','status','company_logo','upload_letterhead','company_stamp'])
				   ->make(true);
	   }

		return view('admin.users.index',compact('list'));
           // ->with('i', ($request->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()	
    {		
			abort_unless(\Gate::allows('user_create'), 403);
			$users = User::get();	 
			$roles = Role::whereNotIn('title',['Super Admin'])->get();		 
			$plans = Plan::all();
			
			return view('admin.users.create',compact('roles','plans','users'));		  
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	 
		abort_unless(\Gate::allows('user_create'), 403);
		try{
		 //pr($request->all());
			$this->validate($request, [ 
				'company_name' => 'required',
				'admin_email' => 'required|unique:users,admin_email',
				'password' => 'required',
				'contact' => 'required',
				'company_charges' => 'required',
				'address' => 'required',	         
				'agreement_text' => 'required', 
				'userStatus' => 'required', 
				'company_logo' => 'required|mimes:jpeg,jpg,png', 
				'upload_letterhead' => 'required|mimes:jpeg,jpg,png',
				'company_stamp' => 'required|mimes:jpeg,jpg,png',
			]);
			
			$company_logo = '';
            if ($request->hasFile('company_logo')) {
				$file = $request->file('company_logo');
				$name=$request->file('company_logo')->getClientOriginalName();
					$isValid_Extention_Size = explode('.', $name);					 
					if(count($isValid_Extention_Size) <= 2){
						if (in_array(strtolower($request->file('company_logo')->getClientOriginalExtension()), ['jpg','jpeg','png'])) {
							$documentRootPath = public_path().'/uploads/admin/company/';
							$company_logo = time().rand().'company_logo.'.$request->file('company_logo')->getClientOriginalExtension();
							$request->file('company_logo')->move($documentRootPath, $company_logo);
							
							$destinationPathThumbnail = public_path('/uploads/admin/company/thumbnail');
							$img = Image::make($documentRootPath.$company_logo);
							$img->resize(150, 150, function ($constraint) {
								$constraint->aspectRatio();
							})->save($destinationPathThumbnail.'/'.$company_logo);
							
						}else{
							Alert::error('File Error', "Please upload valid File.");
							return redirect()->back()->with('loader',true);
						}
				}else{
					Alert::error('File Error', "Please upload valid File.");
					return redirect()->back()->with('loader',true);
					}
            }
			
			$upload_letterhead = '';			
            if ($request->hasFile('upload_letterhead')) {
				$file = $request->file('upload_letterhead');
				$name=$request->file('upload_letterhead')->getClientOriginalName();
					$isValid_Extention_Size = explode('.', $name);					 
					if(count($isValid_Extention_Size) <= 2){
						if (in_array(strtolower($request->file('upload_letterhead')->getClientOriginalExtension()), ['jpg','jpeg','png'])) {
							$documentRootPath = public_path().'/uploads/admin/company/';
							$upload_letterhead = time().rand().'upload_letterhead.'.$request->file('upload_letterhead')->getClientOriginalExtension();
							$request->file('upload_letterhead')->move($documentRootPath, $upload_letterhead);
							
							$destinationPathThumbnail = public_path('/uploads/admin/company/thumbnail');
							$img = Image::make($documentRootPath.$upload_letterhead);
							$img->resize(150, 150, function ($constraint) {
								$constraint->aspectRatio();
							})->save($destinationPathThumbnail.'/'.$upload_letterhead);
							
						}else{
							Alert::error('File Error', "Please upload valid File.");
							return redirect()->back()->with('loader',true);
						}
				}else{
					Alert::error('File Error', "Please upload valid File.");
					return redirect()->back()->with('loader',true);
					}
            }
			
			$company_stamp = '';			
            if ($request->hasFile('company_stamp')) {
				$file = $request->file('company_stamp');
				$name=$request->file('company_stamp')->getClientOriginalName();
					$isValid_Extention_Size = explode('.', $name);					 
					if(count($isValid_Extention_Size) <= 2){
						if (in_array(strtolower($request->file('company_stamp')->getClientOriginalExtension()), ['jpg','jpeg','png'])) {
							 $documentRootPath = public_path().'/uploads/admin/company/';
							 $company_stamp = time().rand().'company_stamp.'.$request->file('company_stamp')->getClientOriginalExtension();
							$request->file('company_stamp')->move($documentRootPath, $company_stamp);
							
							$destinationPathThumbnail = public_path('/uploads/admin/company/thumbnail');
							$img = Image::make($documentRootPath.$company_stamp);
							$img->resize(150, 150, function ($constraint) {
								$constraint->aspectRatio();
							})->save($destinationPathThumbnail.'/'.$company_stamp);
							
						}else{
							Alert::error('File Error', "Please upload valid File.");
							return redirect()->back()->with('loader',true);
						}
				}else{
					Alert::error('File Error', "Please upload valid File.");
					return redirect()->back()->with('loader',true);
					}
            }
			$username = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 36)), 0, 6); 
			//$password = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 36)), 0, 6);
			 
			
			$insertData = array(
					'type' => 2,
					'company_name' => $request->company_name,
					'admin_email' => $request->admin_email,
					'username' => $username,
					'password' => hash('sha256', $request->password),
					'contact' => $request->contact,					
					'company_charges' => $request->company_charges,
					'address' => $request->address,
					'status' => $request->userStatus,
					'agreement_text' => $request->agreement_text,
					'company_logo' => $company_logo,
					'upload_letterhead' => $upload_letterhead,
					'company_stamp' => $company_stamp,
					'token' => random_string(45),
				);
		    
			$user = User::create($insertData);
			 $user->roles()->attach(2);
			 
			/* $emailData = ([
				 
				 'name' => $request->name,
				 'email' => $request->email,
				 'password' => $request->password_test,
				  
				 ]);	 */
	
			//$welcomeEmailSent = Mail::to($request->email)->send(new WelcomeMail($emailData));
			 
			Alert::success('Success', 'Admin created successfully');
			return redirect()->route('admin.admin.index');
		  
		}catch(\Swift_TransportException $transportExp){
			Alert::success('Success', 'Admin created successfully but email not sent!!');
			return redirect()->route('admin.users.index');
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
    /* public function show($id)
    {
		abort_unless(\Gate::allows('user_show'), 403);
        $user = User::find($id);
		$states = getState();
		$roles = Role::whereNotIn('name',['Super Admin'])->pluck('name','name')->all();

		$userRole = $user->roles->pluck('name','name')->all();
		$application_modules = ApplicationModulesMaster::all();
        return view('admin.users.show',compact('user','roles','userRole','application_modules','states'));
    }   */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		abort_unless(\Gate::allows('user_edit'), 403);
        $user = User::find($id);
        $users = User::get();
        $roles = Role::whereNotIn('title',['Super Admin'])->get();
        
        return view('admin.users.edit',compact('user','users','roles'));
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
		abort_unless(\Gate::allows('user_edit'), 403);
		try{
				$this->validate($request, [
				  
					'company_name' => 'required',
					'admin_email' => 'required|unique:users,admin_email,'.$id,
					'contact' => 'required',
					'company_charges' => 'required',
					'address' => 'required',	         
					'agreement_text' => 'required', 
					'userStatus' => 'required', 
					'company_logo' => 'mimes:jpeg,jpg,png', 
					'upload_letterhead' => 'mimes:jpeg,jpg,png',
					'company_stamp' => 'mimes:jpeg,jpg,png',
					
                ]);
				
				$company_logo = '';
            if ($request->hasFile('company_logo')) {
				$file = $request->file('company_logo');
				$name=$request->file('company_logo')->getClientOriginalName();
					$isValid_Extention_Size = explode('.', $name);					 
					if(count($isValid_Extention_Size) <= 2){
						if (in_array(strtolower($request->file('company_logo')->getClientOriginalExtension()), ['jpg','jpeg','png'])) {
							$documentRootPath = public_path().'/uploads/admin/company/';
							$company_logo = time().rand().'company_logo.'.$request->file('company_logo')->getClientOriginalExtension();
							$request->file('company_logo')->move($documentRootPath, $company_logo);
							
							$destinationPathThumbnail = public_path('/uploads/admin/company/thumbnail');
							$img = Image::make($documentRootPath.$company_logo);
							$img->resize(150, 150, function ($constraint) {
								$constraint->aspectRatio();
							})->save($destinationPathThumbnail.'/'.$company_logo);
							
						}else{
							Alert::error('File Error', "Please upload valid File.");
							return redirect()->back()->with('loader',true);
						}
				}else{
					Alert::error('File Error', "Please upload valid File.");
					return redirect()->back()->with('loader',true);
					}
            }else{
				$company_logo = $request->company_logo_edit;
			}
			
			$upload_letterhead = '';			
            if ($request->hasFile('upload_letterhead')) {
				
				$name=$request->file('upload_letterhead')->getClientOriginalName();
					$isValid_Extention_Size = explode('.', $name);					 
					if(count($isValid_Extention_Size) <= 2){
						if (in_array(strtolower($request->file('upload_letterhead')->getClientOriginalExtension()), ['jpg','jpeg','png'])) {
							$documentRootPath = public_path().'/uploads/admin/company/';
							$upload_letterhead = time().rand().'upload_letterhead.'.$request->file('upload_letterhead')->getClientOriginalExtension();
							$request->file('upload_letterhead')->move($documentRootPath, $upload_letterhead);
						 
							$destinationPathThumbnail = public_path('/uploads/admin/company/thumbnail');
							$img = Image::make($documentRootPath.$upload_letterhead);
							$img->resize(150, 150, function ($constraint) {
								$constraint->aspectRatio();
							})->save($destinationPathThumbnail.'/'.$upload_letterhead);
							
						}else{
							Alert::error('File Error', "Please upload valid File.");
							return redirect()->back()->with('loader',true);
						}
				}else{
					Alert::error('File Error', "Please upload valid File.");
					return redirect()->back()->with('loader',true);
					}
            }else{
				$upload_letterhead = $request->upload_letterhead_edit;
			}
			
			$company_stamp = '';			
            if ($request->hasFile('company_stamp')) {
				$file = $request->file('company_stamp');
				$name=$request->file('company_stamp')->getClientOriginalName();
					$isValid_Extention_Size = explode('.', $name);					 
					if(count($isValid_Extention_Size) <= 2){
						if (in_array(strtolower($request->file('company_stamp')->getClientOriginalExtension()), ['jpg','jpeg','png'])) {
							 $documentRootPath = public_path().'/uploads/admin/company/';
							 $company_stamp = time().rand().'company_stamp.'.$request->file('company_stamp')->getClientOriginalExtension();
							$request->file('company_stamp')->move($documentRootPath, $company_stamp);
							
							$destinationPathThumbnail = public_path('/uploads/admin/company/thumbnail');
							$img = Image::make($documentRootPath.$company_stamp);
							$img->resize(150, 150, function ($constraint) {
								$constraint->aspectRatio();
							})->save($destinationPathThumbnail.'/'.$company_stamp);
							
						}else{
							Alert::error('File Error', "Please upload valid File.");
							return redirect()->back()->with('loader',true);
						}
				}else{
					Alert::error('File Error', "Please upload valid File.");
					return redirect()->back()->with('loader',true);
					}
            }else{
				$company_stamp = $request->company_stamp_edit;
			}

				$updateData = array( 
					'company_name' => $request->company_name,
					'admin_email' => $request->admin_email,					 
					'contact' => $request->contact,					
					'company_charges' => $request->company_charges,
					'address' => $request->address,
					'status' => $request->userStatus,
					'agreement_text' => $request->agreement_text,
					'company_logo' => $company_logo,
					'upload_letterhead' => $upload_letterhead,
					'company_stamp' => $company_stamp,
					 
				);
				 
				$user = User::find($id);
				$user->update($updateData);
                //DB::table('role_user')->where('user_id',$id)->delete();
                //$user->roles()->attach($request->user_type);
				 
			Alert::success('Success', 'Admin updated successfully');
			return redirect()->route('admin.admin.index');
						
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
    public function adminDelete(Request $request)
    {
		abort_unless(\Gate::allows('user_delete'), 403);
		$id = $request->id;
		$cust_ids = Customer::where('admin_id',$id)->pluck('id');		 
		FinalSubmission::whereIn('user_id',$cust_ids)->delete();
		CustomerFormData::whereIn('user_id',$cust_ids)->delete();
		DataAssigned::whereIn('user_id',$cust_ids)->delete();	
		 
		Customer::where('admin_id',$id)->delete();
		Agent::where('admin_id',$id)->delete();	
        User::find($id)->delete();
			 
		
        return redirect()->route('admin.admin.index')
                        ->with('success','Admin deleted successfully');
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
	
	
	public function updateAdminStatus(Request $request)
	{
		$id = $request->userid;
        $status = $request->status;
		User::where('id',$id)->update(['is_active' => $status]);         
        echo 'success';
	}
}
