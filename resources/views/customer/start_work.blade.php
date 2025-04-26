@extends('customer.layouts.app')
@section('title', $title)
@section('content')

@section('style')
<style>
  @media only screen and (max-width: 768px) {
  /* For mobile phones: */
    .third_contaner {
      overflow: auto;height: 250px;
    }
    }
</style>
@endsection

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Start Work</h4> 
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">			  

                <div class="card-header align-items-center d-flex_">
                    <div class="row">
                    <div class="col-md-4">
                            <div class="row">
								<label for="select_data" class="form-label col-md-3">Select Form *</label>
                                <div class="form-group col-md-9">
                                    <select name="select_data" id="select_data" class="form-control" onchange="imageData(this);" >
                                        <option value="">--Select--</option>
                                        @forelse($getdata as $value)
                                            @php
                                                if($value['form_submit_status'] == '1')
                                                {
                                                    $color = "background: lightgreen;";
                                                }  else {
                                                    $color = "background: none;";
                                                }
                                            @endphp
                                        <option style="{{ $color}}" value="{{$value->data_form_id}}" attrsr="{{ $value->sr_no}}">QRCode - {{ $value->sr_no}}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>
                            </div>
						</div>
                    </div>


                </div>

                <div class="card-body">
                    <div class="live-preview">
					<div class="row">
					<div class="col-md-2">&nbsp;</div>
						<div class="col-md-8">
				 
                    <form name="frmData" id="frmData" action="" method="POST">
                    {!! csrf_field() !!}
					<input type="hidden" name="record_id" value="" id="record_id" >
                    <input type="hidden" id="formNo" name="forn_no" value="">
                    <input type="hidden" id="edit_id" name="edit_id" value="">
					 					
					<div class="row gy-2">
						<div class="col-md-12">
							<div id="generateimg1">
							{{--	<img style="width: 100%;" src="{{asset('public/admin/data_image/'.$getdata->customerAssignData->create_image)}}"> --}}
							</div>
						</div>
                    </div>
						<!--end col-->
                        <hr>
                        <div class="row third_contaner">
						<div class="col-md-4">
							<div>
								<label for="name" class="form-label">Name *</label>
								{!! Form::text('name', null, array('id'=>'name','placeholder' => 'Name','class' => 'form-control','required' => 'required')) !!}
								 
							</div>
						</div>
						<!--end col-->
						<div class="col-md-4">
							<div>
								<label for="labeltotal_forms" class="form-label">Designation *</label>
								{!! Form::text('designation', null, array('id'=>'designation','placeholder' => 'Designation','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						<div class="col-md-4">
							<div>
								<label for="company_name" class="form-label">Company Name *</label>
								{!! Form::text('company_name', null, array('id'=>'company_name','placeholder' => 'Company Name','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
                        <div class="col-md-4">
							<div>
								<label for="website" class="form-label">Website *</label>
								{!! Form::text('website', null, array('id'=>'website','placeholder' => 'Website','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
                        <div class="col-md-4">
							<div>
								<label for="address" class="form-label">Address *</label>
								{!! Form::text('address', null, array('id'=>'address','placeholder' => 'Address','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
                        <div class="col-md-4">
							<div>
								<label for="email" class="form-label">Email *</label>
								{!! Form::text('email', null, array('id'=>'email','placeholder' => 'Email','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
                        <div class="col-md-4">
							<div>
								<label for="office_contact" class="form-label">Office Contact *</label>
								{!! Form::text('office_contact', null, array('id'=>'office_contact','placeholder' => 'Office Contact','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						 
						 <div class="col-md-6 pt-4">
						        @if($finalSubmissionData > 0)						  
								    <button type="button"  id="submit_Btn" disabled class="btn btn-primary">Not Allowed</button>
								@else
								    <button type="button" onclick="submitForm();" id="submitBtn" class="btn btn-primary">Generate QRCode</button>
								@endif
						</div>
						 
						<!--end col-->
						 
					</div>
					 
                        </form>
					 
					 </div>
					 <div class="col-md-2">&nbsp;</div>
                </div>
				</div>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- container-fluid -->
@endsection
@section('script')

<!-- Default Modals -->

<div id="barcodeModal" class="modal fade" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barcodeModalLabel">QRCode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body" id="barcode_show" style="margin:0 auto;">
                    <img id="qrCodeImage" src="" alt="QR Code" style="width:100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Next</button>
                 
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
@if($finalSubmissionData > 0)
function submitForm()
{
    alert('You have Final Submited. So you are not Allowed now !!!');
    return false;
}

@else
 function submitForm()
    {
        $("#whole_page_loader").show();
        var record_id = $('#record_id').val();
        var formNo = $('#formNo').val();
        var edit_id = $('#edit_id').val();
        var name = $('#name').val();
        var designation = $('#designation').val();
        var company_name = $('#company_name').val();
        var website = $('#website').val();
        var address = $('#address').val();
        var email = $('#email').val();
        var office_contact = $('#office_contact').val();
		var select_data = $('#select_data').val();
		
		if(select_data == '')
		{
			alert("Please select form.");
			$('#select_data').focus();
            $("#whole_page_loader").hide();
            return false;
		}
        // Check if any field is empty
        if (name === "" && designation === "" && company_name === "" && website === "" && address === "" && email === "" && office_contact === "") {
            alert("Please fill in at least one field.");
            $("#whole_page_loader").hide();
            return false;
        }

        var currentIndex = $('#select_data option[attrsr="'+record_id+'"]').index();
        var nextOption = $('#select_data option').eq(currentIndex + 1);       
        if (nextOption.length) {
            var next_record_obj = nextOption;//.val() // Get the next value             
        } else {
            next_record_obj = '';
        }       
        
            $.ajax({
                url: "{{route('customer.storeWork')}}",
                type: "POST",
                dataType: 'json',
                data: $('#frmData').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response)
                {                  
                    $("#whole_page_loader").hide();
                    if(response.userRes === 1)
                    {
                        $('#select_data option[attrsr="'+record_id+'"]').css('background', 'lightgreen');
                        $('#qrCodeImage').attr('src',  response.userQR);; 
                        //alert('Record created successfully !!!'); 
                        $('#barcodeModal').modal('show');                       
                        if (next_record_obj) {
                            imageData(next_record_obj, 1);  // Call imageData function with the next value
                        }
                    }else if(response.userRes === 2)
                    {
                        $('#qrCodeImage').attr('src',  response.userQR); 
                        $('#barcodeModal').modal('show');
                       // alert('Record updated successfully !!!');
                        if (next_record_obj) {
                            imageData(next_record_obj, 1);  // Call imageData function with the next value
                        }
                    }else{
                        alert('Something Wrong!!! Please try Again!!');
                    }
                    
                },
                error: function(xhr, status, error) {
                    $("#whole_page_loader").hide();
                    alert('Something Wrong!!! Please try Again!!')
                }
            });
    }

@endif
 

    function isNameOnly(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 65 || charCode > 122 || charCode == 91 || charCode == 93 || charCode == 94 || charCode == 95 || charCode == 92))
            return false;
        return true;
    }

    function isNumberOnly(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 47 || charCode > 57))
            return false;
        return true;
    }

    $(document).ready(function () {
        $('#name,#designation,#company_name,#website,#address,#office_contact,#email').bind("cut copy paste", function (e) {
            e.preventDefault();
            alert('Cut, Copy & Paste not Allowed!!');
        });

    });

    function imageData($this,chk = '')
    {
		
        var select_data = $($this).val();
        if(chk != '')
        {
            var attr = $($this).attr('attrsr');
        }else{        
            var attr = $($this).find(':selected').attr('attrsr');
        }
      
        $('#loading').show();
        if (select_data == '')
        {
			$('#formNo').val('');
            $('#record_id').val('');
			$('#edit_id').val('');
			$('#generateimg1').html('');
            document.getElementById("frmData").reset();			
            $("#whole_page_loader").hide();
        } else {
            $("#whole_page_loader").show();
            //$('#form_no').html(select_data);
            $('#formNo').val(select_data);
            $('#record_id').val(attr);
            $.ajax({
                url: "{{route('customer.getgenerateImage')}}",
                type: "POST",
                dataType: 'json',
                data: {select_data: select_data},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response)
                {
                    $('#select_data').val(select_data);
                    if (response.image1)
                    {
                        $('#generateimg1').html('<img style="width: 100%;" src="{{ asset('public/admin/data_image/')}}/'+ response.image1 +'"  id="blah" alt="">');

                       // $('#datarecord').show();
                        $('.carousel').carousel({
                            interval: false,
                            wrap: false,
                        });
                    }
                    if (response.userData)
                    {
                        var userfrmdata = response.userData;
						 
                        var userId = userfrmdata.form_no;
						
                        if (userfrmdata) {
                            $('#edit_id').val(userfrmdata.id);
                            $('#name').val(userfrmdata.name);
                            $('#designation').val(userfrmdata.designation);
                            $('#company_name').val(userfrmdata.company_name);
                            $('#website').val(userfrmdata.website);
                            $('#address').val(userfrmdata.address);
                            $('#email').val(userfrmdata.email);
                            $('#office_contact').val(userfrmdata.office_contact);
                             
                        }
                        $('#whole_page_loader').hide();
                    } else {
                        $('#edit_id').val('');
                        document.getElementById("frmData").reset();
                        //$("input").removeAttr("disabled");
                        //$("button").removeAttr("disabled");
                        $('#whole_page_loader').hide();

                    }

                }
            });
        }
    }
</script>
@endsection
