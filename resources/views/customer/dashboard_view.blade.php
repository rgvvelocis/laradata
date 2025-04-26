@extends('customer.layouts.app')
 @section('title', $title)
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
	<div class="row">
	<div class="col-lg-12">
		<div class="card">			  

			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">User Detail </h4>

			</div>

			<div class="card-body">
				<div class="live-preview">
					 
					<div class="row gy-4">
						 
				<div class="col-12 col-sm-12">

                    <div class="row justify-content-md-center align-items-center mb-4">
                        <div class="col-12 col-sm-8 col-offset-1">
                            <div class="col-md-6" style="background: #fff;">
                                <a href="<?php echo base_url().'view-profile/'.$customer_details['token'];?>">
                                <div class="d-flex flex-column align-items-center text-center border rounded p-4 m-1 border-primary">
                                    <img class="rounded-circle" width="130px" src="<?php echo base_url()?>assets/avatar.png">
                                    <span class="font-weight-bold">View Profile</span>
                                     
                                </div>
                                </a>
                            </div> 
                            <div class="col-md-6" style="background: #fff;">
                                <a href="<?php echo base_url().'email-verify/'.$customer_details['token'];?>">
                                <div class="d-flex flex-column align-items-center text-center border rounded p-4 m-1 border-primary">
                                    <img class="rounded-circle" width="130px" src="<?php echo base_url()?>assets/upload.png">
                                    <span class="font-weight-bold">Upload Photo</span>
                                 </div>
                                </a>
                            </div> 
                            <div class="col-md-6" style="background: #fff;">
                                <a href="<?php echo base_url('term-condition');?>">
                                <div class="d-flex flex-column align-items-center text-center border rounded p-4 m-1 border-primary">
                                    <img class="rounded-circle_" width="104px" src="<?php echo base_url()?>assets/terms-and-conditions.png">
                                    <span class="font-weight-bold">Read Term & Condition</span>
                                </div>
                                </a>
                            </div> 
                            <div class="col-md-6" style="background: #fff;">
                                <a <?php if($customer_details['status'] == '1'){ echo 'target="_blank"';}?> href="<?php if($customer_details['status'] == '1'){ echo base_url().'uploads/agreement/'.$customer_details['agreement_pdf'];}?>">
                                <div class="d-flex flex-column align-items-center text-center border rounded p-4 m-1 border-primary">
                                    <img class="rounded-circle_" width="130px" src="<?php echo base_url()?>assets/PDF-Document.ico">
                                    <span class="font-weight-bold">Download Agreement
                                        <?php if($customer_details['status'] == '1')
                                            echo 'Available';
                                        else
                                            echo 'Not Available';
                                            ?>
                                        </span>
                                </div>
                                </a>
                            </div> 
                            
                            <div class="col-md-10">
                                <a class="mt-5 btn-sm btn btn-info" href="<?php echo base_url('/');?>">Back...</a>
                                 
                            </div> 
                             
                        </div>
                        
                    </div>
                </div>
						
					  
					</div>
				</div>
			</div>
		</div>
	</div>
	 
	</div>
 

</div>
<!-- container-fluid -->
<script>

    $(document).ready(function () {
        
	 });
</script>
@endsection
