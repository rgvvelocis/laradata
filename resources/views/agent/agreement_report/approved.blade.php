@extends('agent.layouts.app')
@section('title', 'Approved Customer List')
 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">User List</h4>

				<div class="page-title-right"> 
				 			 
					<a class="btn btn-success" href="{{ route('agent.addAgentUser') }}"> <i class="ri-add-line align-bottom me-1"></i> Add User</a>
			 
				</div>

			</div>
		</div>
	</div>
	<!-- end page title -->
 <div class="row">
	<div class="col-lg-12">
		<div class="card">
			  
			<div class="card-body">
				<div class="live-preview">
				<form method="GET" action="{{ route('agent.approved') }}">
					<div class="row gy-4">
						<div class="form-group col-md-3">
							<label for="name">Username/Email</label>
							<input type="text" name="name" id="name" value="{{ request()->input('name') }}" class="form-control">
						</div>
						
						<div class="form-group col-md-3">
							<label for="contact">Contact</label>
							<input type="text" name="contact" id="contact" value="{{ request()->input('contact') }}" class="form-control">
						</div>

						 
						<div class="form-group col-md-3">
							<button type="submit" class="btn btn-primary mt-4">Filter</button>
						</div>
					</div>
				</form>
				 
					<div class="row gy-4">
					 
					<div class="table-responsive">       
						<table id="example" class="display table table-bordered dataTable  nowrap" width="100%" cellspacing="0">
							<thead>

								<tr>
									<th>ID</th>
									<th>DATE</th>
									<th>COMP NAME</th>
								    <th>NAME</th>  
									<th>EMAIL</th>
									<th>Mobile</th>
									<th>ALT MOBILE</th>	
									<th>REG DATE</th>
									<th>SUB DATE</th>
									<th>AGREEMENT</th>  
									 
								</tr>
							</thead>
							<tbody>
							@php $sr = ($data->currentPage() - 1) * $data->perPage(); @endphp
								@if(!$data->isEmpty())
									@foreach ($data as $key => $user)
								
									 <tr>
									   <td>{{ $sr + $loop->iteration }} </td>	
									   <td>{{ date('d-m-Y',strtotime($user->updated_at)) }} </td> 									    
									   <td> {{ $user->parentUser->company_name}}</td>									   
									   <td>{{ $user->customer_name }} </td>
									   <td>{{ $user->customer_email }}</td>
									   <td>{{ $user->customer_mobile  }} </td>
									   <td>{{ $user->customer_altmobile }} </td>
									    <td>{{ date('d-m-Y',strtotime($user->user_reg_date)) }} </td>
									   <td>{{ date('d-m-Y',strtotime($user->user_sub_date)) }} </td>
									    
										<td> 
											@if(!empty($user['agreement_pdf']))
												<a target="blank" href="{{ asset('public/uploads/agreement/'.$user->agreement_pdf)}}">View</a>
										    @endif
										</td>
									  
									 </tr>
									@endforeach
									@else
									   <tr>
										<td colspan="9">No records found!!</td>
									 </tr>
									@endif
									</tbody>
									<tfoot>
										<tr>
											<th>ID</th>
											<th>DATE</th>
											<th>COMP NAME</th>
											<th>NAME</th>  
											<th>EMAIL</th>
											<th>Mobile</th>
											<th>ALT MOBILE</th>	
											<th>REG DATE</th>
									        <th>SUB DATE</th>
											<th>AGREEMENT</th>  
											 
										</tr>
									</tfoot>
						</table>
					</div>
					{{ $data->appends(request()->query())->links() }}




					 
				</div>
			</div>
		</div>
	</div>
		
</div>
</div>
 <script>
     $(document).ready(function () {
         $('#example').DataTable({
			 paging: false,
			 info: false,
		 });
     });
 </script>
@endsection

 