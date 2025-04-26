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
use App\Models\FinalSubmission;
use App\Models\Role;
use App\Models\Plan; 
use App\Models\Customer; 
use App\Models\Datalist; 
use App\Models\DataAssigned; 
use App\Models\CustomerFormData;
use DB;

class TaskReportController extends Controller
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
     
    public function completeList(Request $request){ 

        /* $data = Customer::join('lara_final_submissions as lfs', 'lfs.user_id','lara_customers.id')
				->where('lfs.sub_status', 1) 
				->where('lfs.non_sub_status', 0) 
				->where('lfs.release_report_status', 0) 
				->orderBy('lara_customers.id','DESC')->paginate(10); */
		$name = $request->input('name');
		$contact = $request->input('contact');
		$list = Customer::query(); 		
		$list->whereHas('getFinalSubmission', function($q){
				 $q->where('sub_status', 1) 
					->where('non_sub_status', 0)
					->where('release_report_status', 0)				;
				}) ;
				
				if ($name) {
					$list->where(function ($query) use ($name) {
						$query->where('username', 'like', '%' . $name . '%')->Orwhere('customer_email', 'like', '%' . $name . '%')
						->orWhere('lara_customers.customer_name', 'like', '%' . $name . '%');
					});
				}
			
				if ($contact) {
					$list->where('customer_mobile', 'like', '%' . $contact . '%');
				}
				$list->orderBy('lara_customers.user_reg_date','ASC');
		 $data = $list->paginate(10);
		 DB::disconnect();
        return view('admin.task_report.completelist',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function notCompleteList(Request $request){
		$name = $request->input('name');
		$contact = $request->input('contact');

        $list = Customer::query(); 		
		$list->whereHas('getFinalSubmission', function($q){
			 $q->where('sub_status', 1) 
				->where('non_sub_status', 1) ;
			}) ;
				
			if ($name) {
				$list->where(function ($query) use ($name) {
					$query->where('username', 'like', '%' . $name . '%')->Orwhere('customer_email', 'like', '%' . $name . '%')
                    ->orWhere('lara_customers.customer_name', 'like', '%' . $name . '%');
				});
			}
		
			if ($contact) {
				$list->where('customer_mobile', 'like', '%' . $contact . '%');
			}
			$list->orderBy('lara_customers.user_reg_date','ASC');
	 $data = $list->paginate(10);
	 DB::disconnect();
        return view('admin.task_report.notcompletelist',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }


    public function reportRelease(Request $request){

       /*  $data = Customer::join('lara_final_submissions as lfs', 'lfs.user_id','lara_customers.id')
				->where('lfs.sub_status', 1) 
				->where('lfs.non_sub_status', 0) 
				->where('lfs.release_report_status', 1) 
				->orderBy('lara_customers.id','DESC')->paginate(10); */
		$name = $request->input('name');
		$contact = $request->input('contact');

		$list = Customer::query(); 		
		$list->whereHas('getFinalSubmission', function($q){
				 $q->where('sub_status', 1) 
					->where('non_sub_status', 0)
					->where('release_report_status', 1)				;
				}) ;
				
				if ($name) {
					$list->where(function ($query) use ($name) {
						$query->where('username', 'like', '%' . $name . '%')->Orwhere('customer_email', 'like', '%' . $name . '%')
						->orWhere('lara_customers.customer_name', 'like', '%' . $name . '%');
					});
				}
			
				if ($contact) {
					$list->where('customer_mobile', 'like', '%' . $contact . '%');
				}
				$list->orderBy('lara_customers.user_reg_date','ASC');
		 $data = $list->paginate(10);
		 DB::disconnect();
			//pra($data);
        return view('admin.task_report.report',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 public function reportReleased(Request $request) {
		try{
			FinalSubmission::where('user_id',$request->userid)->update(array('non_sub_status' => '0', 'release_report_status' => '1'));       
			echo 'success';  
		
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
    
    
    
    public function userResubmissionForm(Request $request) {
		try{  
			FinalSubmission::where('user_id',$request->userid)->delete(); 
			echo 'success';
		
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
	 
	 
	 public function viewReport(Request $request,$user_id,$report_type)
	 {
		//abort_unless(\Gate::allows($this->module_name.'_list'), 403);
		$module_title = 'View Report';
        $module_name = $report_type;
		$userdetails ='';
		$result = FinalSubmission::where('user_id',$user_id)->where('sub_status',1)->first();
		
         $data['checkSubmit_report'] = $result;
       
        if (!empty($result)) {
            $data['totalform'] = $result['total_record'];
            $userdetails = Customer::where('id',$user_id)->first(); 
            $data['complete'] = $result['total_attempt_record'];
            $data['correct'] = $result['correct'];
            $data['incorrect'] = $result['incorrect'];
           
        }
		 
		/* $wrong_val = DataAssigned::has('customerStoreData')->with(['customerAssignData', 'customerStoreData' => function($query) use ($user_id) {
			$query->where('user_id', $user_id);
		}])
		->where('user_id',$user_id)
		->paginate(10); */

		$wrong_val = CustomerFormData::select('lara_customer_fromdata.*','lara_assigned.sr_no')
			->with('getDataList')
			->join('lara_assigned', function ($join) {
				$join->on('lara_assigned.user_id', '=', 'lara_customer_fromdata.user_id')
					->whereColumn('lara_assigned.data_form_id', 'lara_customer_fromdata.form_no');
			})
			->where('lara_customer_fromdata.user_id', $user_id)
			->orderBy('sr_no','ASC')
			->paginate(10); 
        DB::disconnect();
		// pra($wrong_val);
		 return view('admin.view_report',compact('data','userdetails','wrong_val',"module_title", "module_name"))
            ->with('i', ($request->input('page', 1) - 1) * 10);
		 
	 }
 

     

 
  
}
