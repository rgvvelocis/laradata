@extends('customer.layouts.app')
@section('title', $title) 
@section('content')
<div class="container-fluid">

<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">View Report</h4>

				<div class="page-title-right">
					@if(!empty($data['checkSubmit_report']))  
                        <button onclick="printDiv('cnDetRep')" class="btn btn-success">PRINT REPORT</button>									
					@endif				
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
					 
					 
                        <!-- task, page, download counter  start -->
                        <div class="container-fluid well1 white">
                             

                            <div class="tab-content">

                                <div style="text-align:center;" class="tab-pane fade_ active in" id="detrep">
                                    <!-- <h3>DETAILED REPORT</h3> -->
                                    <br>
                                    
                                    <?php if (!empty($data['checkSubmit_report'])) { ?>
                                     
                                        <div id="cnDetRep">
                                            <div style="text-align:center;">
                                                <div style="padding:20px;border:1px solid gray;">
                                                    <h4>CUSTOMER-REPORT [DETAILED]</h4>
                                                    <hr>
                                                    <div style="display: inline-block;width: 100%;">
                                                    <div class="row">
                                                    <!-- task, page, download counter  start -->
                                                    <div class="col-xl-3 col-md-4">
                                                        <div class="card bg-c-yellow_ update-card_" style="background-color: #fff;border: 1px solid #ccc;">
                                                            <div class="card-block">
                                                                <div class="row align-items-end">
                                                                    <div class="col-12">
                                                                        <h4 class="text-black"><?php echo $data['totalform'] ?></h4>
                                                                        <h6 class="text-black m-b-0">ASSIGNED FORMS</h6>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                             
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-4">
                                                        <div class="card bg-c-green_ update-card_" style="background-color: #fff;border: 1px solid #ccc;">
                                                            <div class="card-block">
                                                                <div class="row align-items-end">
                                                                    <div class="col-12">
                                                                        <h4 class="text-black"><?php echo $data['complete']; ?></h4>
                                                                        <h6 class="text-black m-b-0">COMPLETED FORMS</h6>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                             
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-4">
                                                        <div class="card bg-c-pink_ update-card_" style="background-color: #fff;border: 1px solid #ccc;">
                                                            <div class="card-block">
                                                                <div class="row align-items-end">
                                                                    <div class="col-12">
                                                                        <h4 class="text-black"><?php echo $data['correct']; ?></h4>
                                                                        <h6 class="text-black m-b-0">CORRECT FORMS</h6>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                             
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-4">
                                                        <div class="card bg-c-lite-green_ update-card_" style="background-color: #fff;border: 1px solid #ccc;">
                                                            <div class="card-block">
                                                                <div class="row align-items-end">
                                                                    <div class="col-12">
                                                                        <h4 class="text-black"><?php echo $data['incorrect']; ?></h4>
                                                                        <h6 class="text-black m-b-0">INCORRECT FORMS</h6>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                             
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                    <table class="table table-striped table-bordered nowrap dataTable" style="text-align:left;">
                                                        <tbody>
                                                            <tr>
                                                                <th>CUST NAME : </th>
                                                                <td><?php if (!empty($userdetails)) echo $userdetails->customer_name; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>REG DATE : </th>
                                                                <td><?php if (!empty($userdetails)) echo $userdetails->user_reg_date; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>SUB DATE : </th>
                                                                <td><?php if (!empty($userdetails)) echo $userdetails->user_sub_date; ?></td>
                                                            </tr>
 
                                                        </tbody>
                                                    </table>
                                                     
                                                    <hr>
                                                    <div class="table-responsive">
                                                    <table cellpadding="3" border="1" class="table table-striped table-bordered nowrap_ dataTable_" style="text-align:left;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:200px;">FORM</th>
                                                                <th style="width:200px;">COLUMN</th>
                                                                <th style="width:400px;">CORRECT DATA</th>
                                                                <th style="width:400px;">INCORRECT DATA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($wrong_val)){
                                                                $i = 1;
                                                            foreach ($wrong_val as $val) {
																
																 
																	$name = $val->name ?? '';
																	$designation = $val->designation ?? '';
																	$company_name = $val->company_name ?? '';
																	$website = $val->website ?? '';
																	$address = $val->address ?? '';
																	$email = $val->email ?? '';
																	$office_contact = $val->office_contact ?? '';
																 
																
                                                                  
																
																?>
																
																@if(strcmp($val->getDataList->name, $name) !== 0) 
                                                                <tr>
                                                                    <td>QRCode-{{$val->sr_no}}</td>
                                                                    <td> :: Name :: </td>
                                                                    <td>{{$val->getDataList->name}}</td>
                                                                    <td>{{$name}}</td>
                                                                </tr>
																@endif
																
																@if(strcmp($val->getDataList->designation, $designation) !== 0) 
																<tr>
                                                                    <td>QRCode-{{$val->sr_no}}</td>
                                                                    <td> :: Designation :: </td>
                                                                    <td>{{$val->getDataList->designation}}</td>
                                                                    <td>{{$designation}}</td>
                                                                </tr>
																@endif
																
																@if(strcmp($val->getDataList->company_name, $company_name) !== 0)  
																<tr>
                                                                    <td>QRCode-{{$val->sr_no}}</td>
                                                                    <td> :: Company Name :: </td>
                                                                    <td>{{$val->getDataList->company_name}}</td>
                                                                    <td>{{$company_name}}</td>
                                                                </tr>
																@endif
																@if(strcmp($val->getDataList->website, $website) !== 0)  
																<tr>
                                                                    <td>QRCode-{{$val->sr_no}}</td>
                                                                    <td> :: Website :: </td>
                                                                    <td>{{$val->getDataList->website}}</td>
                                                                    <td>{{$website}}</td>
                                                                </tr>
																@endif
																@if(strcmp($val->getDataList->address, $address) !== 0)  
																<tr>
                                                                    <td>QRCode-{{$val->sr_no}}</td>
                                                                    <td> :: Address :: </td>
                                                                    <td>{{$val->getDataList->address}}</td>
                                                                    <td>{{$address}}</td>
                                                                </tr>
																@endif
																@if(strcmp($val->getDataList->email, $email) !== 0)  
																<tr>
                                                                    <td>QRCode-{{$val->sr_no}}</td>
                                                                    <td> :: Email :: </td>
                                                                    <td>{{$val->getDataList->email}}</td>
                                                                    <td>{{$email}}</td>
                                                                </tr>
																@endif
																@if(strcmp($val->getDataList->office_contact, $office_contact) !== 0)  
																<tr>
                                                                    <td>QRCode-{{$val->sr_no}}</td>
                                                                    <td> :: Office Contact :: </td>
                                                                    <td>{{$val->getDataList->office_contact}}</td>
                                                                    <td>{{$office_contact}}</td>
                                                                </tr>
																@endif
                                                                <?php 
																  
																$i++;
                                                            } }?>
                                                        </tbody>
                                                    </table>
                                                        <br>
                                                        <p class="links_pagination"><?php echo $wrong_val->links(); ?></p>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                        <div id="cnDetRep">
                                            <div style="text-align:center;">
                                                <h1 style="text-align:center;">ACCESS DENIED FOR THIS ACTION!</h1>
                                            </div>
                                        </div>
                                       <?php } ?>

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
