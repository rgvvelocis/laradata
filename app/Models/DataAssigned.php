<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 

class DataAssigned extends Authenticatable
{
    use  HasFactory;
	protected $table = 'lara_assigned';
        protected $guarded = [];
    
	public function customerAssignData()
	{	   
		return $this->hasOne(Datalist::class,'id','data_form_id');
	}
	
	 public function customerStoreData()
	{	   
		return $this->hasOne(CustomerFormData::class,'form_no','data_form_id');
	}
	
	/*  public function finalSubmissionData()
	{	   
		return $this->hasOne(FinalSubmission::class,'user_id','user_id');
	} */
     
}
