@extends('customer.layouts.app_upload')
@section('title', 'Upload Documents')

@section('content')

<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0"> </h4> 
			</div>
		</div>
	</div>
	<!-- end page title -->
	<div class="row">
	<div class="col-lg-12">
		<div class="card">			  

			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Account Status </h4>

			</div>

			<div class="card-body">
				<div class="live-preview">
					 
					<div class="row gy-4">
						 
						<div class="col-xxl-12 col-md-12">
							<div class="card ribbon-box border shadow-none mb-lg-0">
								<div class="card-body">
									<div class="ribbon ribbon-success round-shape">Success</div>
									<h5 class="fs-14 text-end">&nbsp; </h5>
									<div class="ribbon-content mt-4 text-muted">
										<p class="mb-0">Please wait for Admin Approval or Contact to Admin!!</p>
									</div>
								</div>
							</div>
						</div>			 
						<!--end col-->
						
					  
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
