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
	
	
 {!! Form::model($data, ['method' => 'PATCH','route' => ['agent.updateAgentUser', $data->id],'files' => 'true','enctype'=>'multipart/form-data']) !!}
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
								<label for="customer_name" class="form-label">{{ __('Full Name') }} *</label>
								<input type="text" name="customer_name" class="form-control" id="customer_name" value="{{$data->customer_name ?? ''}}" required autocomplete="off">
							</div>
						</div>			 
						<!--end col-->
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_email" class="form-label">{{ __('Email address') }} *</label>
								<input type="text" onblur="javascript:checkInput('customer_email',this);" name="customer_email" class="form-control" id="customer_email" value="{{$data->customer_email ?? ''}}" required autocomplete="off">
							</div>
						</div>			 
						<!--end col-->
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_mobile" class="form-label">{{ __('Mobile No.') }} *</label>
								<input type="tel" name="customer_mobile" maxlength="10" onblur="javascript:checkInput('customer_mobile',this);" class="form-control numbersonly" value="{{$data->customer_mobile}}" id="customer_mobile" required autocomplete="off">
							</div>
						</div>
						<!--end col-->

						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_altmobile" class="form-label">{{ __('Alternate Mobile No.') }} </label>
									<input type="tel" name="customer_altmobile" maxlength="10" onblur="javascript:checkInput('customer_altmobile',this);" class="form-control form-control-icon numbersonly" value="{{$data->customer_altmobile ?? ''}}" id="customer_altmobile" required autocomplete="off">
							</div>
						</div>
						<!--end col-->
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_locality" class="form-label">{{ __('Address (as per documents)*') }}</label>
								<input type="text" name="customer_locality" class="form-control" id="customer_locality" value="{{$data->customer_locality ?? ''}}" required autocomplete="off">
							</div>
						</div>			 
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="your_state" class="form-label">{{ __('State*') }}</label>
								<select name="your_state" id="your_state" class="form-control bg-transparent"  required>
									<option value="">Select State</option>
									@foreach ($states as $state)
										<option attrid="{{$state->id}}" {{ ($data->state_id == $state->id) ? 'selected' : ''}} value="{{ucfirst($state->name)}}">{{$state->name}}</option>									
									@endforeach
								</select>
								
							</div>
						</div>			 
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="your_city" class="form-label">{{ __('City*') }}</label>
								<select name="your_city" id="your_city" class="form-control bg-transparent"  required>
									<option value="">Select City</option>									 
								</select>
								<input type="hidden" name="state_id" id="state_id" value="">
							</div>
						</div>			 
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customer_pincode" class="form-label">{{ __('Pincode *') }} </label>
								<input type="text" maxlength="6" name="customer_pincode" class="form-control form-control-icon numbersonly" value="{{$data->customer_pincode}}" id="customer_pincode" required autocomplete="off">
							</div>
						</div>
						<!--end col-->
						<div class="card-header align-items-center d-flex">
							<h4 class="card-title mb-0 flex-grow-1">upload document* (Massage- Aadhar Front/Back, Driving license front/back,/Voter id/ Pancard,)</h4>
						</div>
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="doc1" class="form-label">{{ __('Document 1') }}*
								@if(!empty($data->doc1))
									(<a target="_BLANK" href="{{asset('public/uploads/customer_doc/'.$data->doc1)}}">View Doc</a>)
									<input type="hidden" name="doc1_edit" value="{{$data->doc1}}">
								@endif
								</label>
								<input type="file" name="doc1" id="doc1" class="form-control">								 
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="doc2" class="form-label">{{ __('Document 2') }} 
								@if(!empty($data->doc2))
									(<a target="_BLANK" href="{{asset('public/uploads/customer_doc/'.$data->doc2)}}">View Doc</a>)
									<input type="hidden" name="doc2_edit" value="{{$data->doc2}}">
								@endif
								
								</label>
								<input type="file" name="doc2"  class="form-control" id="doc2">
							</div>
						</div>
						<!--end col-->
					{{--	<div class="col-xxl-3 col-md-6">
							<div>
								<label for="doc3" class="form-label">{{ __('Document 3') }} 
								@if(!empty($data->doc3))
									(<a target="_BLANK" href="{{asset('public/uploads/customer_doc/'.$data->doc3)}}">View Doc</a>)
									<input type="hidden" name="doc3_edit" value="{{$data->doc3}}">
								@endif
								</label>
								<input type="file" class="form-control" name="doc3" id="doc3">
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="doc4" class="form-label">{{ __('Document 4') }} 
								@if(!empty($data->doc4))
									(<a target="_BLANK" href="{{asset('public/uploads/customer_doc/'.$data->doc4)}}">View Doc</a>)
									<input type="hidden" name="doc4_edit" value="{{$data->doc4}}">
								@endif
								</label>
								<input type="file" class="form-control" name="doc4" id="doc4">
							</div>
						</div> --}}
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

    $(document).ready(function () {
		var state_id = $('#your_state').find('option:selected').attr('attrid');
		$.ajax({
			url: '{{route("agent.getAllCity")}}',
			type: "POST",
			data: {stateid: state_id,city_id: '{{$data->your_city}}'},			 
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (response)
			{
				$('#state_id').val(state_id);
				$('#your_city').html(response);

			}
		});
        $('#your_state').change(function () {
            var state_id = $(this).find('option:selected').attr('attrid');

            $.ajax({
                url: '{{route("agent.getAllCity")}}',
                type: "POST",
                data: {stateid: state_id},			 
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                success: function (response)
                {
                    $('#state_id').val(state_id);
                    $('#your_city').html(response);

                }
            });

        });
    });


</script>
 
@endsection
