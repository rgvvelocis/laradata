@extends('admin.layouts.app')
@section('title', 'Active Users')
 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Active Users</h4>

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
				<form method="GET" action="{{ route('admin.activeUsers') }}">
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
							<label for="contact">Order By</label>
							<select name="order_by" id="order_by" class="form-select">
							    <option value="">--Select--</option>
							    <option {{ (request()->input('order_by') == 'ASC') ? 'selected' : '' }} value="ASC">ASC Order</option>
							    <option {{ (request()->input('order_by') == 'DESC') ? 'selected' : '' }} value="DESC">DESC Order</option>
							</select>
						</div>

						 
						<div class="form-group col-md-3">
							<button type="submit" class="btn btn-primary mt-4">Filter</button>
						</div>
					</div>
				</form>
					<div class="row gy-4">
					 
					<div class="table-responsive">
					 <table id="example" class="display table table-bordered dataTable no-footer nowrap">
					 <thead>
								<tr>
									<th>SNo</th>
									<th>CUST NAME</th>
									<th>REG DATE</th>
									<th>SUB DATE</th>
									<th>PLAN NAME</th>
									<th>TOTAL FORMS</th>
									<th>COMPLETED FORMS</th>
									<th>CORRECT</th>
									<th>INCORRECT</th>
									<th>IS ACTIVE</th>
									 
								</tr>
							</thead>
							<tbody>	
							@php $sr = ($data->currentPage() - 1) * $data->perPage(); @endphp							 
									@forelse ($data as $key => $user)
									@php
									$color = "";
									$percent = 0;
									$correct = $user->correctForm;
									$incorrect = $user->IncorrectForm;
									$completed_form_data = $correct + $incorrect;

									if ($correct > 0) {
										$percent = round($correct / $completed_form_data * 100);
									}

									if ($percent >= '91') {
										$color = '#00FF00';
									} elseif ($percent >= '81') {
										$color = '#990000';
									} elseif ($percent >= '71') {
										$color = '#FF0000';
									} elseif ($percent >= '61') {
										$color = '#FF6666';
									} elseif ($percent >= '51') {
										$color = '#00FF00';
									} elseif ($percent >= '41') {
										$color = '#0080FF';
									} else {
										$color = '#333333';
									}
									@endphp
									
									 <tr>
									   <td>{{ $sr + $loop->iteration }} </td>	
									   <td>{{ $user->customer_name }} </td>
									   <td>{{ date('d-m-Y',strtotime($user->user_reg_date)) }} </td> 
									   <td>{{ date('d-m-Y',strtotime($user->user_sub_date)) }} </td> 
										<td>{{ $user->plan_name }} </td>		
									   <td>{{ $user->plan_total_forms }} </td>									   
									   <td>{{  $user->correctForm + $user->IncorrectForm  }} </td>
									   <td style="background-color:{{$color}};color:#ffffff;">{{  $user->correctForm }} </td>
									   <td>{{ $user->IncorrectForm }} </td>
									     <td>
											@if ($user->user_status == 1)   
											<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
												<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick='userStatus("{{$user->id}}",2)' {{($user->user_status == 1) ? 'checked' : '' }} >
											</div>
										@else
											<div class="form-check form-switch form-switch-lg text-center" dir="ltr">
												<input type="checkbox" class="form-check-input" id="customSwitchsizelg" onclick='userStatus("{{$user->id}}",1)' {{($user->user_status == 1) ? 'checked' : '' }} >
											</div>
										@endif
									   </td> 								    
									 </tr>
									 
									@empty
									   <tr>
										<td colspan="11">No records found!!</td>
									 </tr>
									@endforelse
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
 <script>
   /*  $(document).ready(function () {
         $('#example').DataTable({
			 paging: false,
			 info: false,
		 });
     }); */
	 function userStatus(userid, status) 
      {  
        var con =confirm('Do You want to continue!!');
             if(con == true){
                  $.ajax ({              
                      url:'{{route("admin.updateCustomertatus")}}',
                      type: "POST",
                      data:{status:status, userid:userid},
					  headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
                      success: function(response)
                     {  
                       if(response.trim() =='success'){
                          window.location.href="{{route('admin.activeUsers')}}";                       
                         }   
                    
                     }
                  });
                }else{
                  return false;
                }  
      }
 </script>
@endsection

 