@extends('admin.layouts.app')
@section('title', 'Complete Task List')
 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Complete Task List</h4>

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
				<form method="GET" action="{{ route('admin.completeList') }}">
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
						<table id="submission_report" class="display table table-bordered dataTable  nowrap">
							<thead>
								<tr>
									<th>SNo</th>
									<th>USERNAME</th>
									<th>PASSWORD</th>
									<th>CUST NAME</th>
									<th>CONTACT No</th>
									<th>EMAIL</th>
									<th>REG DATE</th>
									<th>SUB DATE</th>
									<th>TOTAL</th>
									 <th>CORRECT</th>
									 <th>INCORRECT</th>
									<th>VIEW REPORT</th>
									<th>IS ACTIVE</th>
									<th>RELEASE REPORT</th>
								</tr>
							</thead>
							<tbody>
							@php $sr = ($data->currentPage() - 1) * $data->perPage(); @endphp
								@if(!$data->isEmpty())
								@foreach($data as $key=>$user)
								<tr>
									<td>{{ $sr + $loop->iteration }} </td>	
									   <td>{{ $user->username }} </td> 
									   <td>{{ $user->password }} </td> 
									   <td>{{ $user->customer_name }} </td> 
									   <td>{{ $user->customer_mobile  }} </td> 
									   <td>{{ $user->customer_email   }} </td>
									   <td>{{ date('d-m-Y',strtotime($user->user_reg_date)) }} </td>
									   <td>{{ date('d-m-Y',strtotime($user->user_sub_date)) }} </td>
									   <td>{{$user->getFinalSubmission->total_record}}</td>
									   <td>{{$user->getFinalSubmission->correct}}</td>
									   <td>{{$user->getFinalSubmission->incorrect}}</td>   
									   <td><a  style="text-align: center;display: block;" href="{{ route('admin.viewReport', [$user->id,'completeList']) }}"><i class="ri-eye-fill"></i></a> </td>  
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
									   <td> 
										<a onclick="released_report('{{$user->id}}')"  href="javascript:void(0);"><button class="btn btn-primary" type="button">Release</button></a>
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
									<th>SNo</th>
									<th>USERNAME</th>
									<th>PASSWORD</th>
									<th>CUST NAME</th>
									<th>CONTACT No</th>
									<th>EMAIL</th>
									<th>REG DATE</th>
									<th>SUB DATE</th>
									<th>TOTAL</th>
									 <th>CORRECT</th>
									 <th>INCORRECT</th>
									<th>VIEW REPORT</th>
									<th>IS ACTIVE</th>
									<th>RELEASE REPORT</th>
									
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
 <script>
     $(document).ready(function () {
         $('#example').DataTable({
			 paging: false,
			 info: false,
		 });
     });
	 
	 function userStatus(userid, status) 
      {  
        var con =confirm('Do You want to continue!!');
             if(con == true){
                  $.ajax ({              
                      url:'{{route("admin.userResubmissionForm")}}',
                      type: "POST",
                      data:{status:status, userid:userid},
					  headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
                      success: function(response)
                     {  
                       if(response.trim() =='success'){
                          window.location.href="{{route('admin.notCompleteList')}}";                       
                         }   
                    
                     }
                  });
                }else{
                  return false;
                }  
      }
      
      function released_report(userid) 
      {  
        var con =confirm('Do You want to continue.');
             if(con == true){
                  $.ajax ({              
                      url:"{{route('admin.reportReleased')}}",
                      type: "POST",
                      data:{status:status, userid:userid},
					  headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
                      success: function(response)
                     {  
                       if(response.trim() =='success'){
                          window.location.href="{{route('admin.completeList')}}";                       
                         }   
                    
                     }
                  });
                }else{
                  return false;
                }  
      }
 </script>
@endsection

 