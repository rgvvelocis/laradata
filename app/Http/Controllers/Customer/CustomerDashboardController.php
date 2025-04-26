<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FinalSubmission;
use App\Models\DataAssigned; 
use App\Models\CustomerFormData; 
use App\Models\Datalist; 
use App\Models\Plan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Crypt;
use \Mpdf\Mpdf as PDF; 
use DB;
use Image;
use App;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use Illuminate\Validation\Rules\Password;

//use Illuminate\Support\Facades\Storage;

class CustomerDashboardController extends Controller
{
     public function __construct()
    {
     
        $this->middleware('isCustomer');
    }

    public function dashboard()
    {
		$title = 'Dashboard';
		$module_name = 'dashboard';
		$user = Auth::guard('miscust')->user(); 
		 
		$data = array();
		 
		if(($user->photo_agreement_status == 0) && ($user->status != 1))
		{
			$title = 'Upload Document';
			$module_name = 'upload_document';
			return view('customer.upload_document',compact('user','title','module_name'));
		}elseif(($user->photo_agreement_status == 1) && ($user->status != 1))
		{
			$title = 'Upload Document';
			$module_name = 'upload_document';
			return view('customer.uploaded_document_check',compact('user','title','module_name'));
		}
		else{
			$data = DB::select("SELECT (SELECT COUNT(*) FROM lara_assigned WHERE user_id = '".$user->id."') as totalform, 
			(SELECT COUNT(*) FROM lara_customer_fromdata WHERE user_id = '".$user->id."') as completeform,
			(SELECT fee FROM lara_plans WHERE id = '".$user->user_plan."') as credit_amount");
			
			$earning = FinalSubmission::select("correct")->where('user_id',$user->id)->first();
			if(!empty($earning) && $earning->correct > 0)
			{
				$plan = Plan::where('id',$user->user_plan)->first();
				$total_earning = $earning->correct * $plan->plan_rate_per_form;
			}else{
				$total_earning = 0;
			}
			DB::disconnect();
			return view('customer.dashboard',compact('data','user','total_earning','title','module_name'));
		}
       
       
    }
	
	public function storeCustomerfile(Request $request)
    {
		try 
		{
			$request->validate([
				'uploadownphoto' => 'required',
				'uploadownsignature' => 'required',
			]);
			$data = array(
				'upload_own_photo' =>$request->uploadownphoto,
				'upload_own_signature' =>$request->uploadownsignature,
				'photo_agreement_status' => '1'
			);
		 
			$user = Customer::find(Auth::guard('miscust')->user()->id); 
			Customer::where('id',Auth::guard('miscust')->user()->id)
			->where('photo_agreement_status', 0)
			->where('status', '!=',1)->update($data);
			
			$this->createAgreementPdf(Auth::guard('miscust')->user()->id);
			
			Alert::success('Success', 'Your document uploaded successfully');
			return redirect()->route('customer.dashboard');
		} catch (Exception $e) {
            Log::error($e);

            return redirect()->back()->with('error', 'Invalid Credentials.');
        }
    }
	
	public function uploadOwnPhoto(Request $request) {
        try
		{ 
				$path = public_path().'/uploads/customer_pic/';
				if (!file_exists($path)) {
					mkdir($path, 0777, true);
				}
				 $file = $request->file('upload_own_photo');
				 $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
				$filename ="customer_pic_".time().".".$extension; 
				
				if (!in_array($file->getClientOriginalExtension(), ['gif','jpg','jpeg','png'])) {
					echo 'invalid file';
				}
				
				$destinationPathThumbnail = public_path('/uploads/customer_pic/thumbnail');
					$img = Image::make($file->path());
					$img->resize(150, 150, function ($constraint) {
						$constraint->aspectRatio();
					})->save($destinationPathThumbnail.'/'.$filename);
				
				
				 $file->move($path, $filename);
					echo $customer_pic = $filename;
				 
		} catch (Exception $e) {
            Log::error($e);
            return Response::make('File not Uploaded', 400);
            
        }
        
    }
	
	public function uploadOwnSignature(Request $request) {
        try
		{ 
				$path = public_path().'/uploads/customer_signature/';
				if (!file_exists($path)) {
					mkdir($path, 0777, true);
				}
				 $file = $request->file('upload_own_signature');
				 $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
				$filename ="customer_signature_".time().".".$extension; 
				
				if (!in_array($file->getClientOriginalExtension(), ['gif','jpg','jpeg','png'])) {
					echo 'invalid file';
				}
				
				$destinationPathThumbnail = public_path('/uploads/customer_signature/thumbnail');
					$img = Image::make($file->path());
					$img->resize(150, 150, function ($constraint) {
						$constraint->aspectRatio();
					})->save($destinationPathThumbnail.'/'.$filename);
				
				
				 $file->move($path, $filename);
					echo $customer_signature = $filename;
				 
		} catch (Exception $e) {
            Log::error($e);
            return Response::make('File not Uploaded', 400);
            
        }
        
    }

     public function createAgreementPdf($id) {
         
			$data = array();
        
        $customers = Customer::join('users','users.id','lara_customers.admin_id')->where('lara_customers.id',$id)->first(); 
       //pr($customers);
        if (!empty($customers)) {
            
            $customer_detail = $customers;
        }
		//pr($customer_detail);
		 $pdf = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]); 
		 
             $html = view('customer.print_agreement_pdf', compact('customer_detail'))->render();
			 
			//$html = $this->load->view('print_agreement_pdf', $data, true);
            $pdf_file_name = "agreement_".str_replace(' ','_',$customers['customer_name']).'_'.time().".pdf";
            $pdfFilePath = public_path()."/uploads/agreement/".$pdf_file_name;
            $this->fontdata = array(
            "opensans" => array(
                'R' => "OpenSans-Regular.ttf",
                'B' => "OpenSans-Bold.ttf",
                'I' => "OpenSans-Italic.ttf",
                'BI' => "OpenSans-BoldItalic.ttf",
                ),
            );
    
 
            $letterhead_file = asset('public/uploads/admin/company/'.str_replace(' ','_',$customers['upload_letterhead']));
            $pdf->SetDefaultBodyCSS('background', "url(".$letterhead_file.")");
            $pdf->SetDefaultBodyCSS('background-image-resize', 6);
             
            
            $pdf->AddPage('', // L - landscape, P - portrait 
                '0', '0', '0', '0',
                0, // margin_left
                0, // margin right
               50, // margin top
               20, // margin bottom
                1, // margin header
                1); // margin footer
            
                $pdf->WriteHTML(($html));
               
                $pdf->Output($pdfFilePath, "F");
                //$pdf->Output($pdfFilePath, 'I'); // view in the explorer
				
				 
				Customer::where('id',$id)->update(['agreement_pdf' => $pdf_file_name]);
                
                return true ;
				
			 die;
			 
         
    }
	
	 

	public function startWork(Request $request)
	{
		//$id = Crypt::decrypt($id);
		$title = 'Start Work';
		$module_name = 'start_work';
		$user = Auth::guard('miscust')->user(); 
		$getdata = DataAssigned::where('user_id',$user->id)->get();
		 
		$finalSubmissionData = FinalSubmission::where('user_id',$user->id)->count();
		if (empty($getdata)) throw new ModelNotFoundException();
		DB::disconnect();
		return view('customer.start_work',compact('getdata','user','finalSubmissionData','title','module_name'));

	}
	
	 
	public function storeWork(Request $request)
	{
		//pr($request->all()); 
		$form_id = $request->forn_no;
		$editId = $request->edit_id;
        $user = Auth::guard('miscust')->user(); 
         
        $user_id = $user->id;
		$check_num_record = DataAssigned::where('user_id',$user_id)->where('data_form_id',$form_id)->count();
		if ($check_num_record == 0) {
			//Alert::error('Data Error', "Something Wrong!!! Please try Again!!");
			//return redirect()->back()->with('loader',true);  
			$data['userRes'] = 0;
			echo json_encode($data);
			die;          
        }		
		  
		 
		$name = trim($request->name);        
        $designation = trim($request->designation);
        $company_name = trim($request->company_name);
        $website = trim($request->website);
        $address = trim($request->address);
        $email = trim($request->email);
        $office_contact = trim($request->office_contact);
        
		$checkData = Datalist::where('name',$name)
					->where('designation',$designation)
					->where('company_name',$company_name)
					->where('website',$website)
					->where('address',$address)
					->where('email',$email)
					->where('office_contact',$office_contact)
					->first();
					
		$formdata = array(                     
			'name' => $name,  
			'designation' => $designation,   
			'company_name' => $company_name, 
			'website' => $website,	
			'address' => $address,	
			'email' => $email,	
			'office_contact' => $office_contact,	
		);
		$text = 'Name:- '.$name.', Designation:- '.$designation.', Company Name:- '.$company_name.', Website:- '.$website
				.'Address:- '.$address.', Email:- '.$email.', Office Contact:- '.$office_contact;

		if (!empty($editId)) {   
				$correct_form = (!empty($checkData)) ? 1 : 0;	 
				$incorrect_form = (!empty($checkData)) ? 0 : 1;	

				$formdata['formStatus'] = $correct_form;
				CustomerFormData::where('id' , $editId)->where('user_id' , $user_id)->update($formdata);
				DataAssigned::where('data_form_id' , $form_id)->where('user_id' , $user_id)->update(array('correct_form' => $correct_form,'incorrect_form' =>  $incorrect_form, 'form_submit_status' => '1'));
				//Alert::success('Success', 'Record updated successfully');
				//return redirect()->route('customer.startWork','page='.$request->page);	
				$data['userRes'] = 2;
				$data['userQR'] = $this->generateQRCode($text);	
				//pr($this->generateQRCode());			 
				echo json_encode($data); 
				die;   		
			 
		}else{
				$correct_form = (!empty($checkData)) ? 1 : 0;	 
				$incorrect_form = (!empty($checkData)) ? 0 : 1;	 
                $formdata['formStatus'] = $correct_form;
				$formdata['user_id'] = $user_id;
				$formdata['form_no'] = $form_id;
				CustomerFormData::create($formdata);
				DataAssigned::where('data_form_id' , $form_id)->where('user_id' , $user_id)->update(array('correct_form' => $correct_form,'incorrect_form' => $incorrect_form, 'form_submit_status' => '1'));
				 
				//Alert::success('Success', 'Record created successfully');
				//return redirect()->route('customer.startWork','page='.$request->page);   
				$data['userRes'] = 1;	
				$data['userQR'] = $this->generateQRCode($text);			
				echo json_encode($data);
				die;           
		}		
		
	}


	public function generateQRCode($text)
	{
		// Create QR code
		$qrCode = new QrCode(
			data: $text,
			encoding: new Encoding('UTF-8'),
			errorCorrectionLevel: ErrorCorrectionLevel::Low,
			size: 300,
			margin: 10,
			roundBlockSizeMode: RoundBlockSizeMode::Margin,
			foregroundColor: new Color(0, 0, 0),
			backgroundColor: new Color(255, 255, 255)
		);
	
		// Create the QR code writer
		$writer = new PngWriter();
	
		// Generate the QR code without logo and label
		$result = $writer->write($qrCode);
	
		// Return the Data URI of the generated QR code
		return $dataUri = $result->getDataUri();
	}		
	
	
	 
	 
	
	  
	
	 public function getgenerateImage(Request $request) 
	 {
        $user = Auth::guard('miscust')->user(); 		 
        $select_data = $request->select_data;       
		$result = Datalist::with(['customerData' => function($q) use ($select_data,$user){
			return $q->where('form_no',$select_data)
			->where('user_id',$user->id);
		}])->where('id',$select_data)->first();
		 
		if (!empty($result->customerData)) {
            $image['image1'] = $result->create_image;            
            $image['userData'] = $result->customerData;
        } else {
            $image['image1'] = $result->create_image; 
        }
        echo json_encode($image);
    }
	
	 
	public function viewReport(Request $request)
	 {
		//abort_unless(\Gate::allows($this->module_name.'_list'), 403);
		$title = 'View Report';
        $module_name = 'view_report';
		$user = Auth::guard('miscust')->user(); 
		$user_id = $user->id;
		$userdetails = '';
		$result = FinalSubmission::where('user_id',$user_id)
		->where('sub_status',1)
		->where('release_report_status',1)
		->first();
		
         $data['checkSubmit_report'] = $result;
       
        if (!empty($result)) {
            $data['totalform'] = $result['total_record'];
            $userdetails = Customer::where('id',$user_id)->first(); 
            $data['complete'] = $result['total_attempt_record'];
            $data['correct'] = $result['correct'];
            $data['incorrect'] = $result['incorrect'];
           
        }
		 
		 
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
		 
		 return view('customer.view_report',compact('user','data','userdetails','wrong_val',"title", "module_name"))
            ->with('i', ($request->input('page', 1) - 1) * 10);
		 
	 }
	
	public function finalSubmitWork(Request $request)
	{  
        $user_id = Auth::guard('miscust')->user()->id;	 
        $num = FinalSubmission::where('user_id',$user_id)->where('sub_status',1)->count(); 
 
        if ($num > 0) {
            echo 'Already you have submitted !!!';
        } else {
            
            $totalform = DataAssigned::where('user_id',$user_id)->count(); 
			$countRecordData = DB::select("SELECT  count(*) as allrecord, COUNT(if(`formStatus`='1',1,NULL)) as correct,COUNT(if(`formStatus`='0',1,NULL)) as incorrect FROM `lara_customer_fromdata` WHERE user_id = '" . $user_id . "'");
			if ($totalform != $countRecordData[0]->allrecord) {
				FinalSubmission::create(array('user_id' => $user_id, 'sub_status' => '1', 'non_sub_status' => '1', 'total_record' => $totalform));
            } else {
				FinalSubmission::create(array('user_id' => $user_id, 'sub_status' => '1', 'non_sub_status' => '0', 'total_record' => $totalform));
            }
            $data1['total_attempt_record'] = $countRecordData[0]->allrecord;
            $data1['correct'] = $countRecordData[0]->correct;
            $data1['incorrect'] = $countRecordData[0]->incorrect;
            $data1['updated_at'] = date('Y-m-d h:m:s');

            FinalSubmission::where('user_id', $user_id)->update($data1);

            echo 'Your final work Data submitted Successfully!!';
        }
    
	}


	public function resetPassword($token,$pageRoute)
    {
		$user = Auth::guard('miscust')->user(); 
        return view('customer.reset-password', compact('user','token','pageRoute'));
    }

    public function resetPasswordPost(Request $request, $token,$pageRoute)
    {
       
        // Validation rules for the new password and its confirmation
         $request->validate([
            'current_password' => 'required',
            'new_password' =>   'required',
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'new_password_confirmation.same' => 'Confirm password does not match the new password!',
            'new_password.required' => 'New password is required.',
        ]); 
    
        try {
           
            // Ensure token exists and is valid
            $user = Customer::where('token', $token)->first();
            
           
            if (!$user) {
                // If user is not found, return an error
                return redirect()->route($pageRoute)->with('error', 'Invalid token provided.');
            }
    
            // Hash the new password using SHA-256
            $new_password = $request->new_password;
            $current_password = $request->current_password;
           // pr($request->all());
            // If new password and confirmation match
            if ($current_password == $user->password) 
            {
                    if ($request->new_password == $request->new_password_confirmation) 
                    {
                        //$user = User::find(Auth::guard('misadmin')->user()->id);
                        $user->password = $new_password;
                        $user->save();
                
                        // Redirect back with success message
                        Alert::success('Success', 'Password changed successfully!');
                        return redirect()->route($pageRoute)->with('success', 'Password changed successfully!');
                        
                    } else {
                    // If passwords don't match
                        return redirect()->route($pageRoute)->with('error', 'Password and Confirm Password do not match!');
                    }
            }else{
                return redirect()->route($pageRoute)->with('error', 'Current Passwordis not correct!');
            }
        } catch (Exception $e) {
            // Log the error and return a fallback response
            Log::error($e);
            return redirect()->route($pageRoute)->with('error', 'An error occurred while resetting the password.');
        }
    }

     
 
}
