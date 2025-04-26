<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
	protected $table = 'lara_customers';
	
	protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function parentUser()
	{	   
		return $this->hasOne(User::class,'id','admin_id');
	}
	
	public function getAgent()
	{	   
		return $this->hasOne(Agent::class,'id','sub_admin_id');
	}
	
	public function getPlan()
	{	   
		return $this->hasOne(Plan::class,'id','user_plan');
	}
	
	public function getFinalSubmission()
	{	   
		return $this->hasOne(FinalSubmission::class,'user_id','id');
	}

}
