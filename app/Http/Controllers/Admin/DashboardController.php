<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Customer;
use App\Models\DataAssigned;
use App\Models\CustomerFormData;
use App\Models\FinalSubmission;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;


class DashboardController extends Controller
{
    //

    public function dashboard()
    {
		$user = auth()->user();
		$user_role =  $user->roles->first()->id;
		$data = array();
        $today = date('Y-m-d');

        
        // Fetch all counts in one query using `selectRaw` with `CASE` statements
        $data = Customer::when($user_role == 2, function($q) use($user) {
                return $q->where('admin_id', $user->id);
            })
            ->selectRaw('
                COUNT(*) as total_customer,
                COUNT(CASE WHEN status = 0 THEN 1 END) as total_pending_customer,
                COUNT(CASE WHEN status = 1 THEN 1 END) as total_approve_customer,
                COUNT(CASE WHEN status = 2 THEN 1 END) as total_reject_customer,
                COUNT(CASE WHEN DATE(created_at) = ? THEN 1 END) as total_customer_today,
                COUNT(CASE WHEN status = 0 AND DATE(created_at) = ? THEN 1 END) as total_pending_customer_today,
                COUNT(CASE WHEN status = 1 AND DATE(created_at) = ? THEN 1 END) as total_approve_customer_today,
                COUNT(CASE WHEN status = 2 AND DATE(created_at) = ? THEN 1 END) as total_reject_customer_today
            ', [$today, $today, $today, $today])
            ->first()->toArray();
        
        // Convert to array for easier access if needed
        $data = (array) $data; 
        DB::disconnect();
        return view('admin.dashboard',compact('data'));
    }

    public function profile()
    {
        return view('admin.profile');
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

    public function resetPassword($token,$pageRoute)
    {
        return view('admin.reset-password', compact('token','pageRoute'));
    }

    public function resetPasswordPost(Request $request, $token,$pageRoute)
    {
       
        // Validation rules for the new password and its confirmation
         $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'new_password_confirmation.same' => 'Confirm password does not match the new password!',
            'new_password.required' => 'New password is required.',
        ]); 
    
        try {
           
            // Ensure token exists and is valid
            $user = User::where('token', $token)->first();
            
           
            if (!$user) {
                // If user is not found, return an error
                return redirect()->route($pageRoute)->with('error', 'Invalid token provided.');
            }
    
            // Hash the new password using SHA-256
            $new_password = hash('sha256', $request->new_password);
            $current_password = hash('sha256', $request->current_password);
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
    
	
	public function send_(Request $request,$id){
		try {
			$data = Customer::where('id',$id)->first();
			Mail::to($data->customer_email)->send(new WelcomeMail($data));
			
			Alert::success('Success', 'Email Send successfully');
			// return redirect()->route('admin.datalist.index')->with('loader', true);
			//return back();
		}catch(\Swift_TransportException $transportExp){
            \Log::error($e->getMessage());
			Alert::success('Success', 'Agent created successfully but email not sent!!');
			return redirect()->route('admin.admin-agents.index');
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


    // ========== [ Compose Email ] ================
    public function send(Request $request,$id){
        try{
            $customer = Customer::where('id',$id)->first();
            $template = view('emails.welcome',compact('customer'))->render();
           
            $subject = 'Registration Successfully-Find your Login details!!';
            $mail =  send_mailTemplate($customer->customer_email,$subject,$template);
            
            if( !$mail) {
                //return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
                Alert::success('Error', 'Email not sent.');		 
			    return back();
            }            
            else {
                Alert::success('Success', 'Email Send successfully');		 
			    return back();
            }
 
		}catch(\Swift_TransportException $transportExp){
            \Log::error($e->getMessage());
			Alert::success('Error', 'Email not sent!!');
			return redirect()->route('admin.admin-agents.index');
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


    public function userFinalSubmitDateOver() 
{
    $todate = date('Y-m-d');

    // Fetch customers who haven't submitted final data
    $userData = Customer::leftJoin('lara_final_submissions', 'lara_final_submissions.user_id', '=', 'lara_customers.id')
        ->where('lara_customers.user_sub_date', '<', $todate)
       // ->where('lara_customers.user_type', 2)
        ->whereNull('lara_final_submissions.user_id')
        ->select('lara_customers.*') // Select only required fields
        ->get();

    foreach ($userData as $value) {
        
        // Count total forms assigned to the user
        $totalForm = DataAssigned::where('user_id', $value->id)->count();

        // Count user form data records (all, correct, incorrect)
        $countRecordData = CustomerFormData::where('user_id', $value->id)
            ->selectRaw('COUNT(*) as allrecord, 
                        COUNT(CASE WHEN formStatus = 1 THEN 1 END) as correct, 
                        COUNT(CASE WHEN formStatus = 0 THEN 1 END) as incorrect')
            ->first();

        // Prepare final submission data
        $dt_final_submission = [
            'user_id' => $value->id,
            'sub_status' => '1',
            'non_sub_status' => '1',
            'release_report_status' => '0',
            'total_record' => $totalForm,
            'total_attempt_record' => $countRecordData->allrecord ?? 0,
            'correct' => $countRecordData->correct ?? 0,
            'incorrect' => $countRecordData->incorrect ?? 0,
            'updated_at' => now(),
        ];

        // Check if the final submission record exists
        $finalSubmissionExists = FinalSubmission::where('user_id', $value->id)->exists();

        if (!$finalSubmissionExists) {
            FinalSubmission::create($dt_final_submission);
        }
    }

    return response()->json(['message' => 'success']);
}


    public function deleteFullCustomerDetail()
    {
        if (auth()->user()->roles[0]->id == 1) { 
        
         $date = Carbon::now()->subDays(20);
         $userdatas = Customer::where('created_at', '<', $date)->orderBy('created_at','DESC')->limit(1)->get();
        
         if(!empty($userdatas))
         {
               foreach ($userdatas as $userdata) 
                   {
                    //pra($userdata);
                    $filePath = public_path('uploads/agreement/' . $userdata['agreement_pdf']); // Get full file path

                    if (File::exists($filePath) && !empty($userdata['agreement_pdf'])) {                      
                        File::delete($filePath); // Delete the file
                    }

                    $photo = $userdata['upload_own_photo']; // Get file name
                    if (!empty($photo)) {
                        $originalPath = public_path('uploads/customer_pic/' . $photo);
                        $thumbnailPath = public_path('uploads/customer_pic/thumbnail/' . $photo);

                        if (File::exists($originalPath)) {
                            File::delete($originalPath); // Delete original photo
                        }

                        if (File::exists($thumbnailPath)) {
                            File::delete($thumbnailPath); // Delete thumbnail photo
                        }
                    }

                    $signature = $userdata['upload_own_signature']; // Get file name
                    if (!empty($signature)) {
                        $originalPath = public_path('uploads/customer_signature/' . $signature);
                        $thumbnailPath = public_path('uploads/customer_signature/thumbnail/' . $signature);

                        if (File::exists($originalPath)) {
                            File::delete($originalPath); // Delete original photo
                        }

                        if (File::exists($thumbnailPath)) {
                            File::delete($thumbnailPath); // Delete thumbnail photo
                        }
                    }

                    $doc1 = public_path('uploads/customer_doc/' . $userdata['doc1']); // Get full file path
                    if (File::exists($doc1) && !empty($userdata['doc1'])) {                      
                        File::delete($doc1); // Delete the file
                    }

                    $doc2 = public_path('uploads/customer_doc/' . $userdata['doc2']); // Get full file path
                    if (File::exists($doc2) && !empty($userdata['doc2'])) {                      
                        File::delete($doc2); // Delete the file
                    }
                    
                    $userId = $userdata['id'];
                             
                    // Delete related records first
                    DataAssigned::where('user_id', $userId)->delete();
                    CustomerFormData::where('user_id', $userId)->delete();
                    FinalSubmission::where('user_id', $userId)->delete();

                    // Finally, delete the customer
                    Customer::where('id', $userId)->delete();                      
                        
                   }
            
            Alert::success('Success', 'Customer record has been deleted!!'); 	 
			return back();
         }else{            
            Alert::success('Success', 'Customer record has been deleted!!'); 
            return back(); 
         }
        }else{            
            Alert::success('Error', 'Sometheng went wrong!!!');		 
            return back();
        }
    }


     

     
}
