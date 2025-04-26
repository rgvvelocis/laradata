@extends('admin.layouts.app')
@section('title', 'All Agents')
 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Agent List</h4>

				<div class="page-title-right">
				@can('agent_create')				 
					<a class="btn btn-success" href="{{ route('admin.admin-agents.create') }}"> <i class="ri-add-line align-bottom me-1"></i> Add New Agent</a>
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
				 
					<div class="row gy-4">
					<div class="table-responsive">
					 <table id="example" class="table align-middle table-nowrap">
					 <thead>
						 <tr>
						   <th>No</th>	
                                                   <th>Compant Name</th>
						   <th>Username</th>
						   <th>Password</th>
						   <th>Name</th>						   						    
						   <th>Is Active</th>
						   <th>Action</th>
						 </tr>
						  </thead>
						 <tbody>
						 @php $sr = ($data->currentPage() - 1) * $data->perPage(); @endphp
						 @if(!$data->isEmpty())
							 @foreach ($data as $key => $user)
						 
							  <tr>
								<td>{{ $sr + $loop->iteration }}</td>	
                                                                <td>{{$user->parentUser->company_name}}</td>
								<td>{{ $user->username }}</td>
								<td>{{ $user->user_password }}</td>
								<td>{{ $user->name }}</td>
								  
								<td>
								 @if ($user->is_active == 1)   
									<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
										<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick= 'userStatus("{{$user->id}}",0)' {{($user->is_active == 0) ? 'checked' : '' }} >
									</div>
								@else
									<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
										<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick= 'userStatus("{{$user->id}}",1)' {{($user->is_active == 0) ? 'checked' : '' }} >
									</div>
								@endif
							 </td>
							<td>
								   
								 
								@can('agent_edit')								 
									<a class="btn btn-primary_ btn-icon waves-effect waves-light" href="{{ route('admin.admin-agents.edit',$user->id) }}"><i class="ri-pencil-fill align-bottom"></i></a>
								@endcan
								
								@can('agent_delete')			
								{!! Form::open(['method' => 'DELETE','route' => ['admin.admin-agents.destroy', $user->id],'style'=>'display:inline']) !!}
										{!! Form::button('<i class="ri-delete-bin-5-line"></i>', ['type' => 'submit','class' => 'btn btn-danger_ btn-icon waves-effect waves-light']) !!}
									{!! Form::close() !!}
								@endcan
								   
								   
								   
								</td> 
							  </tr>
							 @endforeach
							 @else
								<tr>
								 <td colspan="9">No records found!!</td>
							  </tr>
							 @endif
							 </tbody>
							</table>
							 </div>
							 {{ $data->appends(request()->query())->links() }}
						 
					</div>
					 
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
	 function userStatus(userid, status)
    {
        var con = confirm('Do You want to continue.');
        if (con == true) {
            $.ajax({
                url: '{{route("admin.updateAdminAgentStatus")}}',
                type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                data: {status: status, userid: userid},
                success: function (response)
                {
                    if (response.trim() == 'success') {
                        alert('User status has been changed!!!');
                        //window.location.href="{{route('admin.admin.index')}}";                       
                    }

                }
            });
        } else {
            return false;
        }
    }
 </script>
@endsection

 