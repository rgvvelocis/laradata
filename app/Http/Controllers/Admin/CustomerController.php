<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Plan;
use App\Models\State;
use App\Models\City;
use App\Models\CustomerFormData;
use App\Models\DataAssigned;
use App\Models\FinalSubmission;
use DB;
use File;

class CustomerController extends Controller
{
	public function __construct()
    {
        // Page Title
        $this->module_title = 'User Detail';
        // module name
        $this->module_name = 'customer';
		$this->model_name = 'App\Models\Customer';
     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(\Gate::allows($this->module_name.'_list'), 403);
		$module_title = $this->module_title;
        $module_name = $this->module_name;

        $name = $request->input('name');
        $contact = $request->input('contact');
         
        $list=Customer::query();  
        $list->with('getPlan');
        if ($name) {
            $list->where(function ($query) use ($name) {
                $query->where('username', 'like', '%' . $name . '%')->Orwhere('customer_email', 'like', '%' . $name . '%')
                ->orWhere('lara_customers.customer_name', 'like', '%' . $name . '%');
            });
        }
    
        if ($contact) {
            $list->where('customer_mobile', 'like', '%' . $contact . '%');
        }
        $list->where('status',1)->orderBy('id','DESC');
        // Paginate the filtered results
        $data = $list->paginate(10);
        DB::disconnect();
        return view("admin.customer.index",compact('data',"module_title", "module_name"))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }
	
	public function updateCustomertatus(Request $request)
	{
		$id = $request->userid;
        $status = $request->status;
		Customer::where('id',$id)->update(['user_status' => $status]);         
        echo 'success';
	}
	
	public function assignedData(Request $request)
	{
		$id = $request->userid;
        $status = $request->status;
		Customer::where('id',$id)->update(['user_status' => $status]);         
        echo 'success';
	}

    public function updateUserStatus(Request $request)
    {
        $userid = $request->userid;
        $status = $request->status;
        if('extend_date' == $status)
        {
         $select_date = date('Y-m-d',strtotime($request->select_date));
        
         Customer::where('id',$userid)->update(array('user_sub_date' => $select_date));
       // $this->db->update('dt_users', array('user_sub_date' => $select_date), array('UserId' => $tokenid));
         echo 'success';
        }else{
         echo 'failed';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Customer';
		$module_name = 'add_customer';
		
        try{		
            $states = State::orderBy('name','ASC')->get();
            $data = Customer::where('id',$id)
                    //->where('admin_id' , Auth::guard('misagent')->user()->admin_id)
                   // ->where('sub_admin_id' , Auth::guard('misagent')->user()->id )
                    ->first();
                    
            if (empty($data)) {
                throw new ModelNotFoundException('User not found by ID');
            }
            return view('admin.customer.edit_customer_user',compact('data','states','title','module_name'));
            
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       pr($request->all());
    }


    public function getAllCity(Request $request)
	{
		$selected_city = $request->city_id;
		$cities = City::where('state_id',$request->stateid)->orderBy('city','ASC')->get();
		$city = '<option value="">Select City</option>';
		foreach($cities as $value)
		{
			$selected = '';
			if(!empty($selected_city) && $value->city == $selected_city)
			{
				$selected = 'selected';
			}
			$city .= '<option '.$selected.' value="'.$value->city.'">'.$value->city.'</option>';
		}
		echo $city;
        die;
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('customer_delete'), 403);
        Customer::where('id',$id)->delete();
		Alert::success('Success', 'Customer deleted successfully');
        return redirect()->route('admin.datalist.index')->with('loader', true);
    }

    public function deleteCustomer($id,$type)
    {
        abort_unless(\Gate::allows($this->module_name.'_delete'), 403);
        
        $user = Customer::where('id',$id)->first();
        FinalSubmission::where('user_id',$id)->delete();
        CustomerFormData::where('user_id',$id)->delete();
        DataAssigned::where('user_id',$id)->delete();

        $path = public_path('uploads/agreement/' . $user->agreement_pdf);

        if (File::exists($path) && !empty($user->agreement_pdf)) {
            File::delete($path);
        }
        
        Customer::where('id',$id)->delete();
		Alert::success('Success', 'Customer deleted successfully');
		 
			return redirect()->route('admin.admin-customer.index')->with('loader', true);
		 	
    }


    public function activeUsers(Request $request)	
    {	
		abort_unless(\Gate::allows($this->module_name.'_list'), 403);
		DB::statement("SET SQL_MODE=''");
		$title = 'Active Customer List';
		$module_name = 'active_customer_list';
        $name = $request->input('name');
        $contact = $request->input('contact');
        $order_by = $request->input('order_by');

       
		$list = CustomerFormData::join('lara_customers', 'lara_customers.id', '=', 'lara_customer_fromdata.user_id')
		->join('lara_plans', 'lara_plans.id', '=', 'lara_customers.user_plan')
		->select('lara_customers.*','lara_plans.plan_name','lara_plans.plan_total_forms')
		->selectRaw('sum(if(lara_customer_fromdata.formStatus = 1,1,0)) as correctForm')
		->selectRaw('sum(if(lara_customer_fromdata.formStatus = 0,1,0)) as IncorrectForm')
		->groupBy('lara_customer_fromdata.user_id');
		
		if(!empty($order_by))
		{
		    $list->orderBy('lara_customers.user_reg_date', $order_by);
		}else{
		    $list->orderBy('lara_customers.user_reg_date', 'ASC');
		}
		
		
        
        // Apply conditional filters
        if ($name) {
            $list->where(function ($query) use ($name) {
                $query->where('lara_customers.username', 'like', '%' . $name . '%')
                    ->orWhere('lara_customers.customer_email', 'like', '%' . $name . '%')
                    ->orWhere('lara_customers.customer_name', 'like', '%' . $name . '%');
            });
        }

        if ($contact) {
            $list->where('lara_customers.customer_mobile', 'like', '%' . $contact . '%');
        }
        // Paginate results
        
        $data = $list->paginate(100);
		 DB::disconnect();	
		
		//pra($data);
		return view('admin.active_users',compact('data','title','module_name'))
             ->with('j', ($request->input('page', 1) - 1) * 100); 
    }

}
