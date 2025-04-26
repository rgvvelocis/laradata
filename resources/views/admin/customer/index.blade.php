@extends('admin.layouts.app')
@section('title', 'User LIst')
 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">User LIst</h4>

				<div class="page-title-right"> 
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
				<form method="GET" action="{{ route('admin.admin-customer.index') }}">
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
									<th> ID</th>
									<th>USERNAME</th>
									<th>PASSWORD</th>
									<th>USER NAME</th>
									<th>EMAIL</th>
									<th>CONTACT</th>
									<th>PLAN</th>
									<th>REG DATE</th>
									<th>SUB DATE</th>
									<th>AGREEMENT</th>
								{{--	<th>ASSIGN DATA</th> --}}
									<th>IS ACTIVE</th>
									<th>ACTION</th>
								</tr>
							</thead>
							<tbody>
							@php $sr = ($data->currentPage() - 1) * $data->perPage(); @endphp
								@if(!$data->isEmpty())
									@foreach ($data as $key => $user)
								
									 <tr>
									   <td>{{ $sr + $loop->iteration }} </td>										  
									   <td>{{ $user->username }} </td>
									   <td>{{ $user->password }} </td>
									   <td>{{ $user->customer_name }} </td>
									   <td>{{ $user->customer_email }}</td>
									   <td>{{ $user->customer_mobile  }} </td>
									   <td>{{ $user->getPlan->plan_name }} </td>									   
									   <td>{{ date('d-m-Y',strtotime($user->user_reg_date)) }} </td>
									   <td>{{ date('d-m-Y',strtotime($user->user_sub_date)) }} </td>
									   	<td> 
											@if(!empty($user['agreement_pdf']))
												<a target="blank" href="{{ asset('public/uploads/agreement/'.$user->agreement_pdf)}}">View</a>
										    @endif
										</td>
									    
									   {{--	<td> 
											@if(assigndata_num($user->id,$user->user_plan) > 0)   
												 <span id='assignData{{$user->id}}'><input class='btn btn-danger' type='text' value='DATA ASSIGNED'  checked></span>       
											@else         
												 <span id='assignData{{$user->id}}'><input class='btn btn-primary' type='text' value='ASSIGN DATA' onclick= 'assignData("{{$user->id}} ","{{$user->user_plan}}")' ></span>        
											@endif
 
										</td> --}}
									 <td>
										 @if ($user->user_status == 1)   
											<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
												<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick= 'userStatus("{{$user->id}}",2)' {{($user->user_status == 1) ? 'checked' : '' }} >
											</div>
										@else
											<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
												<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick= 'userStatus("{{$user->id}}",1)' {{($user->user_status == 1) ? 'checked' : '' }} >
											</div>
										@endif
									 </td> 
									 <td>
										@can('customer_delete')
											@php
											$user_sub_date = $user->user_sub_date;
											@endphp
										<a class="btn btn-primary_ btn-icon waves-effect waves-light" onclick="user_status('{{$user->id}}','extend_date','{{$user_sub_date}}')" href="javascript:void(0);"> <i class="ri-pencil-fill align-bottom"></i></a>
											{!! Form::open(['method' => 'DELETE','route' => ['admin.deleteCustomer', $user->id, 'approve'],'style'=>'display:inline', 'id' => 'delete-form-'.$user->id]) !!}
    {!! Form::button('<i class="ri-delete-bin-5-line"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger_ btn-icon waves-effect waves-light',
        'onclick' => 'return confirm("Are you sure you want to delete this customer?")'
    ]) !!}
{!! Form::close() !!}
										@endcan
									<a href="{{route('admin.sendEmail',$user->id)}}"><i class="ri-mail-send-line" aria-hidden="true"></i></a>
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
											<th> ID</th>
											<th>USERNAME</th>
											<th>PASSWORD</th>
											<th>USER NAME</th>
											<th>EMAIL</th>
											<th>CONTACT</th>
											<th>PLAN</th>
											<th>REG DATE</th>
											<th>SUB DATE</th>
											<th>AGREEMENT</th>
											{{--	<th>ASSIGN DATA</th> --}}
											<th>IS ACTIVE</th>
											<th>ACTION</th>
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

@endsection

@section('script')
<!-- Modal Popup -->
<div id="MyPopupwrite_date" class="modal fade" tabindex="-1" aria-labelledby="MyPopupwrite_dateLabel" aria-hidden="true" style="display: none;">
 
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body" style="padding: 15px !important;">
			<label>Select Date*</label>
			<input type="date" name="select_date" id="select_date"  class="form-control" value="" required />
		 
			<br/>
		 
            </div>
            <div class="modal-footer">
                <input type="hidden" name="user_token" id="user_token" value="">
                <input type="hidden" name="user_status" id="user_status" value="">
                <input type="button" onclick="user_status_change();" value="Submit" data-dismiss="modal" class="btn btn-primary" />
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Popup -->

 <script>
     $(document).ready(function () {
       /*  $('#example').DataTable({
			 paging: false,
			 info: false,
		 }); */
     });
	 
	 
 </script>
 <script>
    function userStatus(userid, status)
    {
        var con = confirm('Do You want to continue.');
        if (con == true) {
            $.ajax({
                url: '{{route("admin.updateCustomertatus")}}',
                type: "POST",
                data: {status: status, userid: userid},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                success: function (response)
                {
                    if (response.trim() == 'success') {
                        alert('User status has been changed!!!');
                                             
                    }

                }
            });
        } else {
            return false;
        }
    }

 
      function assignData(userid, plan) 
      {  
        var con =confirm('Do You want to continue.');
             if(con == true){
                  $.ajax ({              
                      url:'{{route("admin.assignedData")}}',
                      type: "POST",
                      data:{userid:userid, planid:plan},
					  headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
                      success: function(response)
                     {  
                         
                       if(response.trim() =='success'){
                          $('#assignData'+userid).html('<input type="text" checked="" value="DATA ASSIGNED" class="btn btn-danger">');                    
                         }   
                    
                     }
                  });
                }else{
                  return false;
                }  
      }


	  function user_status(userid, status,user_sub_date)
        {
            $("#MyPopupwrite_date .modal-title").html('Extend Date');
            $('#select_date').val(user_sub_date);
             $('#user_token').val(userid);
            $('#user_status').val(status);
             $('#select_date').attr('min',user_sub_date)
            $("#MyPopupwrite_date").modal("show");
        }
        
         function user_status_change(userid, status)
            {
                    var user_token = $('#user_token').val();
                    var user_status = $('#user_status').val();
                   // var cust_comment = $('#cust_comment').val();
                    var select_date = $('#select_date').val();
                    if(select_date == ''){
        				alert('Please select Date!');
                        return false;
        			}else{
                    $('#loading').show();
                    $.ajax({
                        url: '{{route("admin.updateUserStatus")}}',
                        type: "POST",
                        data: {status: user_status, userid: user_token,select_date:select_date},
                        headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						success: function (response)
                        {
                            console.log(response);
                            if (response.trim() == 'success') {
                                 // $('#loading').hide();
                               // alert('User status has been changed!!!');
                               location.reload(true);   
                                  
                            }
        
                        }
                    });
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
                        url: $(this).attr('data-href'),
                        method: "DELETE",
                        dataType: 'json',
                        data: {
                            'id': id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            table_schedule.draw();
                            Swal.fire(
                                'Deleted!',
                                'Record Deleted Successfully..',
                                'success'
                            )

                        }
                    });

                }
            })

        });
      
         </script> 
@endsection

 