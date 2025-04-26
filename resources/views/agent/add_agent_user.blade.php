@extends('agent.layouts.app')
@section('title', 'Create User')

@section('content')

<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Add New User</h4> 
			</div>
		</div>
	</div>
	<!-- end page title -->
	{!! Form::open(array('name' => 'userFrm','id' => 'userFrm','route' => 'agent.saveAgentUser','method'=>'POST','files' => 'true','enctype'=>'multipart/form-data')) !!}
 <div class="row">
	<div class="col-lg-12">
		<div class="card">
			 @if (count($errors) > 0)
			  <div class="alert alert-danger">
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				<ul>
				   @foreach ($errors->all() as $error)
					 <li>{{ $error }}</li>
				   @endforeach
				</ul>
			  </div>
			@endif

			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">User Detail </h4>

			</div>

			<div class="card-body">
				<div class="live-preview">
					 
					<div class="row gy-4">
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="user_plan" class="form-label">{{ __('Plan*') }}</label>
								<select name="user_plan" id="user_plan" class="form-select bg-transparent"  required>
									<option value="">Select Plan</option>
									@foreach ($plans as $plan)
										<option value="{{$plan->id}}">{{$plan->plan_name}}</option>									
									@endforeach									 
								</select>
								 
							</div>
						</div>	

						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_name" class="form-label">{{ __('Full Name') }} *</label>
								<input type="text" name="customer_name" class="form-control" id="customer_name" value="{{old('customer_name')}}" required autocomplete="off">
							</div>
						</div>			 
						<!--end col-->
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_email" class="form-label">{{ __('Email address') }} *</label>
								<input type="text" onblur="javascript:checkInput('customer_email',this);" name="customer_email" class="form-control" id="customer_email" value="{{old('customer_email')}}" required autocomplete="off">
							</div>
						</div>			 
						<!--end col-->
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_mobile" class="form-label">{{ __('Mobile No.') }} *</label>
								<input type="tel" name="customer_mobile" maxlength="10" onblur="javascript:checkInput('customer_mobile',this);" class="form-control numbersonly" value="{{old('customer_mobile')}}" id="customer_mobile" required autocomplete="off">
							</div>
						</div>
						<!--end col-->

						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_altmobile" class="form-label">{{ __('Alternate Mobile No.') }} </label>
									<input type="tel" name="customer_altmobile" maxlength="10" onblur="javascript:checkInput('customer_altmobile',this);" class="form-control form-control-icon numbersonly" value="{{old('customer_altmobile')}}" id="customer_altmobile" autocomplete="off">
							</div>
						</div>
						<!--end col-->
						 
						<div class="card-header align-items-center d-flex">
							<h4 class="card-title mb-0 flex-grow-1">Upload Agreement* (PDF Only)</h4>
						</div>
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="agreement_file" class="form-label">{{ __('Agreement File') }}*(PDF only)</label>
								<input type="file" name="agreement_file" id="agreement_file" accept=".pdf" class="form-control" required="">								 
							</div>
						</div>
						<!--end col-->					 
						 
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
	</div>
</div>


{!! Form::close() !!}



</div>
@endsection

@section('script')

<script>
  
</script>
 
@endsection
