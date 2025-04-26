@extends('admin.layouts.app')
@section('title', 'Edit Data')
 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Edit Data</h4>

				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="{{ route('admin.datalist.index') }}">Data</a></li>
						<li class="breadcrumb-item active">Edit Data</li>
					</ol>
				</div>

			</div>
		</div>
	</div>
	<!-- end page title -->
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
			<div class="card-body">
				<div class="live-preview">
				{!! Form::model($datalist, ['method' => 'PATCH','route' => ['admin.datalist.update', $datalist->id]]) !!}
					<div class="row gy-4">
					 
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="name" class="form-label">Name *</label>
								{!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="designation" class="form-label">Designation *</label>
								{!! Form::text('designation', null, array('placeholder' => 'Designation','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="company_name" class="form-label">Company name *</label>
								{!! Form::text('company_name', null, array('placeholder' => 'Company name','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="website" class="form-label">Website *</label>
								{!! Form::text('website', null, array('placeholder' => 'Website','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="address" class="form-label">Address *</label>
								{!! Form::text('address', null, array('placeholder' => 'Address','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="email" class="form-label">Email *</label>
								{!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->

						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="office_contact" class="form-label">Office Contact *</label>
								{!! Form::text('office_contact', null, array('placeholder' => 'Office Contact','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						 
						 <div class="col-xxl-3 col-md-6 pt-4">
							<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
						</div>
						 
						<!--end col-->
						 
					</div>
					{!! Form::close() !!}
					 
				</div>
			</div>
		</div>
	</div>
					 



</div>
</div>		 
@endsection

 