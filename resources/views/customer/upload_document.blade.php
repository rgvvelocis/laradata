@extends('customer.layouts.app_upload')
@section('title', 'Upload Documents')

@section('content')

<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Upload your Document</h4> 
			</div>
		</div>
	</div>
	<!-- end page title -->
	{!! Form::open(array('name' => 'userFrm','id' => 'userFrm','route' => 'customer.storeCustomerfile','method'=>'POST','files' => 'true','enctype'=>'multipart/form-data')) !!}
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
								<label for="customername" class="form-label">{{ __('Full Name') }} *</label>
								<input type="text"  class="form-control" id="customername" value="{{$user->customer_name}}" disabled >
							</div>
						</div>			 
						<!--end col-->
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customeremail" class="form-label">{{ __('Email address') }} *</label>
								<input type="text" class="form-control" id="customeremail" value="{{$user->customer_email}}" disabled >
							</div>
						</div>			 
						<!--end col-->
						
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="customermobile" class="form-label">{{ __('Mobile No.') }} *</label>
								<input type="tel"  maxlength="10" class="form-control numbersonly" value="{{$user->customer_mobile}}" id="customermobile" disabled >
							</div>
						</div>
						<!--end col-->
  
				 <div class="card-header align-items-center d-flex">
							 
						</div>
						 
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="upload_own_photo" class="form-label" style="width:100%;">{{ __('Upload Photo (gif,jpg,jpeg,png)') }}*</label>
								<input type="file" name="upload_own_photo" id="upload_own_photo" onchange="upload_doc(this);" class="form-control" style="width: 74%;display: inline-block;" required="">		
								<img src="{{ asset('public/img/photos/user.png')}}" class="img-circle" id="blah" style="width: 80px; height: 80px;"  alt=""/>
                                <input type="hidden" name="uploadownphoto" id="uploadownphoto" value="">
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-6">
							<div>
								<label for="upload_own_signature" class="form-label" style="width:100%;">{{ __('Upload Signature (gif,jpg,jpeg,png)') }} </label>
								<input type="file" name="upload_own_signature" id="upload_own_signature" onchange="upload_signature(this);" class="form-control" style="width: 74%;display: inline-block;" required>
								<img src="{{ asset('public/img/photos/user.png')}}" class="img-circle" id="blah1" style="width: 80px; height: 80px;"  alt=""/>
                                <input type="hidden" name="uploadownsignature" id="uploadownsignature" value="">
							</div>
						</div>
						<!--end col-->
						    
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
	</div>
</div>


{!! Form::close() !!}



</div>
@endsection

@section('script')

<script>

function upload_signature($this) {
            var fileName = '';
            fileName = $($this).val();
            $('#loading').show();
            var imageData = new FormData();
            imageData.append('upload_own_signature', $('#upload_own_signature')[0].files[0]);
          
            //Make ajax call here:
            $.ajax({
                url: '{{route("customer.uploadOwnSignature")}}',
                type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                processData: false, // important
                contentType: false, // important
                data: imageData,
                beforeSend: function () {
                    $("#err").fadeOut();
                },
                success: function (result) {
                    if (result == 'invalid file') {
                        // invalid file format.
                        $("#err").html("Invalid File. Image must be JPEG, PNG or GIF.").fadeIn();
                        $('#loading').hide();
                    } else {

                        // view uploaded file.
                        $("#blah1").attr('src', '{{ asset("public/uploads/customer_signature/")}}/' + result);
                        $("#uploadownsignature").val(result); 
                        $('#loading').hide();
                    }
                    
                },
                error: function (result) {
                    $("#err").html("errorcity").fadeIn();
                    $('#loading').hide();
                }
            });
        } 
        
        function upload_doc($this) {
            var fileName = '';
            fileName = $($this).val();
            $('#loading').show();
            var imageData = new FormData();
            imageData.append('upload_own_photo', $('#upload_own_photo')[0].files[0]);
           
            //Make ajax call here:
            $.ajax({
                url: '{{route("customer.uploadOwnPhoto")}}',
                type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                processData: false, // important
                contentType: false, // important
                data: imageData,
                beforeSend: function () {
                    $("#err").fadeOut();
                },
                success: function (result) {
                    if (result == 'invalid file') {
                        // invalid file format.
                        $("#err").html("Invalid File. Image must be JPEG, PNG or GIF.").fadeIn();
                        $('#loading').hide();
                    } else {

                        // view uploaded file.
                        $("#blah").attr('src', '{{ asset("public/uploads/customer_pic")}}/' + result);
                        $("#uploadownphoto").val(result); 
                        $('#loading').hide();
                    }
                    
                },
                error: function (result) {
                    $("#err").html("errorcity").fadeIn();
                    $('#loading').hide();
                }
            });
        }

    $(document).ready(function () {
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
