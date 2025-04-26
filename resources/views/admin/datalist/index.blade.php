@extends('admin.layouts.app')
@section('title', 'All Data')
 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Data Management</h4>

				<div class="page-title-right">
				 @can('plan_create')
					<a class="btn btn-success" href="{{ route('admin.datalist.create') }}"> <i class="ri-add-line align-bottom me-1"></i>New Data</a>
					 @endcan
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

				<form method="GET" action="{{ route('admin.datalist.index') }}">
					<div class="row gy-4">
						<div class="form-group col-md-3">
							<label for="name">Name/Email</label>
							<input type="text" name="name" id="name" value="{{ request()->input('name') }}" class="form-control">
						</div>
						
						<div class="form-group col-md-3">
							<label for="email">Designation</label>
							<input type="text" name="designation" id="designation" value="{{ request()->input('designation') }}" class="form-control">
						</div>

						<div class="form-group col-md-3">
							<label for="company_name">Company name</label>
							<input type="text" name="company_name" id="company_name" value="{{ request()->input('company_name') }}" class="form-control">
						</div>
						<div class="form-group col-md-3">
							<button type="submit" class="btn btn-primary mt-4">Filter</button>
						</div>
					</div>
				</form>
				
					<div class="row gy-4">
					<div class="table-responsive">
					 <table id="example" class="display table table-bordered dataTable  nowrap">
					  <thead>
						  <tr>
							 <th>ID</th>
							 <th>Name</th>
							<th>Designation</th>
							<th>Company name</th>
							<th>Website</th>
							<th>Address</th>
							<th>Email</th>
							<th>Office Contact</th>						 
							<th>IMAGE</th>						 
							<th>ACTION</th>
						  </tr>
					    </thead>
						 <tbody>
						@foreach ($list as $key => $value)
						<tr>
							<td>{{ ++$i }}</td>
							<td>{{ $value->name }}</td>
							<td>{{ $value->designation }}</td>
							<td>{{ $value->company_name }}</td>
							<td>{{ $value->website }}</td>
							<td>{{ $value->address }}</td>
							<td>{{ $value->email }}</td>
							<td>{{ $value->office_contact }}</td>						 
							<td>
								@if(!empty($value->create_image))
									<a target="blank"  href="{{ asset('public/admin/data_image/'.$value->create_image) }}">Image</a>
								@endif
							</td>
							
						 
						 
							 
							<td>
								@can('datalist_edit')
									 <a class="btn btn-primary_ btn-icon waves-effect waves-light" href="{{ route('admin.datalist.edit',$value->id) }}"><i class="ri-pencil-fill align-bottom"></i></a> 
								@endcan
								@can('datalist_delete')								
								 	{!! Form::open(['method' => 'DELETE','route' => ['admin.datalist.destroy', $value->id],'style'=>'display:inline']) !!}
										{!! Form::button('<i class="ri-delete-bin-5-line"></i>', ['type' => 'submit','class' => 'btn btn-danger_ btn-icon waves-effect waves-light']) !!}
									{!! Form::close() !!}  
								@endcan
							</td>
						</tr>
						@endforeach
						</tbody>
						<tfooty>
						  <tr>
							 <th>ID</th>
							<th>Name</th>
							<th>Designation</th>
							<th>Company name</th>
							<th>Website</th>
							<th>Address</th>
							<th>Email</th>
							<th>Office Contact</th>						 
							<th>IMAGE</th>						 
							<th>ACTION</th>
						  </tr>
					    </tfooty>
					</table>
					</div>

					{{ $list->appends(request()->query())->links() }}
						 
					</div>
					 
				</div>
			</div>
		</div>
	</div>
		
</div>
</div>
 
@endsection

@section('script')
 <script>
     $(document).ready(function () {
         $('#example_').DataTable({
			searching: false,
			 paging: false,
			 info: false,
		 });
     });
 </script>
@endsection
 

 
 