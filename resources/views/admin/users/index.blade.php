@extends('admin.layouts.app')
@section('title', 'All Admin')
 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Admin List</h4>

				<div class="page-title-right">
				@can('user_create')				 
					<a class="btn btn-success" href="{{ route('admin.admin.create') }}"> <i class="ri-add-line align-bottom me-1"></i> Add New Admin</a>
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
					 <table id="example" class="display table table-bordered dataTable no-footer nowrap">
					 <thead>
						 <tr>
						   <th>No</th>						   
						   <th>Username</th>
						 {{--  <th>Password</th> --}}
						   <th>Comp Name</th>
						   <th>Email</th>
						   <th>Comp Logo</th>
						   <th>Letterhead</th>	
							<th>Charges</th>
							<th>Company Stamp</th>
						   <th>Is Active</th>
						   <th>Action</th>
						 </tr>
						  </thead>
						{{-- <tbody>
						 @if(!$data->isEmpty())
							 @foreach ($data as $key => $user)
						 
							  <tr>
								<td>{{ $loop->iteration }}</td>	
								<td>{{ $user->username }}</td>
								<td>{{ $user->password }}</td>
								<td>{{ $user->company_name }}</td>
								<td>{{ $user->admin_email  }}</td>
								<td>
								@if(!empty($user->company_logo))
									<a href="{{ asset('public/uploads/admin/company/'.$user->company_logo) }}" target="_BLANK">View</a>
								
								@endif
								</td>
								<td>
								@if(!empty($user->upload_letterhead))
									<a href="{{ asset('public/uploads/admin/company/'.$user->upload_letterhead) }}" target="_BLANK">View</a>
								
								@endif
								</td>
								<td>{{ $user->company_charges }}</td>
								<td>
								@if(!empty($user->company_stamp))
									<a href="{{ asset('public/uploads/admin/company/'.$user->company_stamp) }}" target="_BLANK">View</a>
								
								@endif
								 </td>
								 
								<td>
										 @if ($user->is_active == 1)   
											<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
												<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick= 'userStatus("{{$user->id}}",2)' {{($user->is_active == 1) ? 'checked' : '' }} >
											</div>
										@else
											<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
												<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick= 'userStatus("{{$user->id}}",1)' {{($user->is_active == 1) ? 'checked' : '' }} >
											</div>
										@endif
									 </td>
							<td>
								   
								  
								@can('user_edit')								 
									<a class="btn btn-primary_ btn-icon waves-effect waves-light" href="{{ route('admin.admin.edit',$user->id) }}"><i class="ri-pencil-fill align-bottom"></i></a>
								@endcan
								
								@can('user_delete')			
								{!! Form::open(['method' => 'DELETE','route' => ['admin.admin.destroy', $user->id],'style'=>'display:inline']) !!}
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
							 </tbody> --}}
							</table>
							 </div>
							 
						 
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
	$(document).ready(function() {
		table_schedule();
	});
	function table_schedule(data) 
	{
    var table_schedule = $('#example').DataTable({
            processing: true,
            language: {
                processing: '<span style="background-color: #4caf50; color: white; font-weight: bold; padding: 5px;">Please wait...</span>'
                },
            serverSide: true,
			lengthMenu: [[15,35,50,100, -1], [15,35,50,100, "All"]],
          /*   "order": [
                [1, "asc"]
            ], */
			"bFilter": true,
			"bSort": false,
			
            ajax: {
				"url": '{{ route("admin.admin.index") }}',
				"type": "GET",
				'dataType': "json",
				headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
				data: function(d) {
					//d._token = "{{ csrf_token() }}";
					//d.searchInput = $('#searchInput').val();
					//d.sdso_ndso = $('#sdso_ndso').val();
					//d.licensee_owner = $('#licensee_owner').val();
					//d.Licensee = $('#LicenseeFilter').val();
					//d.State = $('#StateFilter').val();
					//d.specified = $('#specified').val();
					//d.drip_Dam = $('#drip_Dam').val();
					//d.project_status = $('#project_status').val();
					//d.level = 1;
				},
			},
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
					searchable: false
                },
                {data: 'username',name: 'username'},
               {{-- {data: 'password',name: 'password'}, --}}
				{data: 'company_name',name: 'company_name'},
				{data: 'admin_email',name: 'admin_email'},
                {data: 'company_logo',name: 'company_logo'},
				{data: 'upload_letterhead',name: 'upload_letterhead'},
				{data: 'company_charges',name: 'company_charges'},
				{data: 'company_stamp',name: 'company_stamp'},
				{data: 'status',name: 'status'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
			'columnDefs': [{
				orderable: false,
				targets: '_all'
			}],
			dom: 'Blfrtip',
			select:true,
				buttons: [
					//'excelHtml5',
					{
						extend : 'csvHtml5',
						title : function() {
							return "ALL DAM LIST";
						},
						//orientation : 'landscape',
						//pageSize : 'A0', // You can also use "A1","A2" or "A3", most of the time "A3" works the best.
						text : '<i class="fa fa-file-csv text-primary"> CSV</i>',
						titleAttr : 'ALL DAM LIST',
						action : newexportaction,


					},
					{
						extend : 'pdfHtml5',
						title : function() {
							return "ALL DAM LIST";
						},
						orientation : 'landscape',
						pageSize : 'A4', // You can also use "A1","A2" or "A3", most of the time "A3" works the best.
						text : '<i class="fa fa-file-pdf text-primary"> PDF</i>',
						titleAttr : 'ALL DAM LIST',
						action : newexportaction,
					}
				]
        });
	}
	 
	 function userStatus(userid, status)
    {
        var con = confirm('Do You want to continue.');
        if (con == true) {
            $.ajax({
                url: '{{route("admin.updateAdminStatus")}}',
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


	$(document).on('click', '.deletedata', function() {
		var id = $(this).attr('data-value');

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {

				$.ajax({
					url: "{{ route('admin.adminDelete') }}",
					method: "POST",
					dataType: 'json',
					data: {
					'id': id,
					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(result) {
						Swal.fire('Deleted!', 'Record Deleted Successfully..', 'success');
						setTimeout(function(){
							location.reload();
						},1000);
					}
				});
			}
		});
	});
 </script>
@endsection

 