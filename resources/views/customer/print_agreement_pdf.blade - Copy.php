<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
       <meta charset="utf-8" />
    <title>{{ config('app.name') }} -  @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }} -  @yield('title')" name="description" />
    <meta content="RGV" name="author" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Layout config Js -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        
     
		<style  type="text/css">
            .container{line-height: 25px;margin: 0 auto;}
        </style>
    </head>
    <body>
	<div class="col-lg-12">
                                        <div class="card-body p-4 border-top border-top-dashed">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Billing Address</h6>
                                                    <p class="fw-medium mb-2" id="billing-name">Valentine Morin</p>
                                                    <p class="text-muted mb-1" id="billing-address-line-1">5114 Adipiscing St. Puno United States 46782</p>
                                                    <p class="text-muted mb-1"><span>Phone: +</span><span id="billing-phone-no">(926) 817-7835</span></p>
                                                    <p class="text-muted mb-0"><span>Tax: </span><span id="billing-tax-no">123456789</span> </p>
                                                </div>
                                                <!--end col-->
                                                <div class="col-md-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Shipping Address</h6>
                                                    <p class="fw-medium mb-2" id="shipping-name">Quamar Payne</p>
                                                    <p class="text-muted mb-1" id="shipping-address-line-1">534-1477 Non, Av. Bury St. Edmunds France 10846</p>
                                                    <p class="text-muted mb-1"><span>Phone: +</span><span id="shipping-phone-no">(926) 817-7835</span></p>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </div>
                                        <!--end card-body-->
                                    </div>
        <div class="container" >
			<div class="row">	
		
                 <div class="col-lg-12">
                    <p>Date : {{ date('d-M-Y')}}</p>
                </div>
               <div class="col-lg-12">
                    <h3 style="text-align: center">Legal Employment Contract({{ date('Y')}})</h3>
                </div>

               <div class="col-lg-12">BETWEEN:</div>
                
                    <div class="col-lg-6">
                        <h3 style="text-align: left;">M/s. {{ $customer_detail->company_name}}</h3>
                        <h4>ADDRESS: - {{  $customer_detail->address}}</h4>
                    </div>
                    <div class="col-lg-6">
                        <br>
						<p>(THE EMPLOYER)<br>OF THE FIRST PARTY</p>
                    </div>
               
				 <div class="col-lg-12">AND:</div>
                
				  
                
                   <div class="col-lg-6">
                        <h3 style="text-align: left;">Mr. / Mrs / Ms. {{  $customer_detail->customer_name}}</h3>
                        <h4>ADDRESS: - {{ $customer_detail->customer_locality}} {{ $customer_detail->your_city}} {{ $customer_detail->your_state}} {{$customer_detail->customer_pincode}}</h4>
                    </div>
                    <div class="col-lg-6">
                        <br><p>(THE EMPLOYEE)<br>OF THE SECOND PARTY</p>
                    </div>
                 
                <div  class="col-lg-12">
				<h4>BACKGROUND:</h4> 
                {!!  $customer_detail->agreement_text !!}
                </div>
				
                <div class="col-lg-6">
					<h3 style="text-align: center;">A. Employer :- (First Party)</h3>
                    <h4 style="text-align: center;margin: 0;">Name - (M/s.{{ $customer_detail->company_name}})</h4>
                        
				</div>
				<div class="col-lg-6">
					<h3 style="text-align: center;">B. Employee :- (Second Party)</h3>
                    <h4 style="text-align: center;margin: 0;">Name - ({{ $customer_detail->customer_name}})</h4>
				</div>
                <div class="col-lg-12">
                    <div class="col-lg-6">
                        <h3 style="text-align: center;">A. Employer :- (First Party)</h3>
                        <h4 style="text-align: center;margin: 0;">Name - (M/s.{{ $customer_detail->company_name}})</h4>
                        
                    </div>
                    <div style="col-lg-6">
                        <h3 style="text-align: center;">B. Employee :- (Second Party)</h3>
                        <h4 style="text-align: center;margin: 0;">Name - ({{ $customer_detail->customer_name}})</h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-6">
                        @if(!empty($customer_detail->company_stamp)) 
                        <img style="width: 100px;" src="{{ asset('public/uploads/admin/company/'.$customer_detail->company_stamp)}}">  
						@endif
					</div>
                    <div class="col-lg-6">
                        @if(!empty($customer_detail->upload_own_photo)) 
                        <img style="width: 100px;" src="{{ asset('public/uploads/customer_pic/'.$customer_detail->upload_own_photo)}}"> 
						@endif
					   <br>
                        @if(!empty($customer_detail->upload_own_signature)) 
                        <img style="width: 100px;" src="{{ asset('public/uploads/customer_signature/'.$customer_detail->upload_own_signature)}}"> 
						@endif
					</div>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-6">
                        <p>Authorized Stamp & Signature</p>
                    </div>
                    <div class="col-lg-6" style="text-align: center;">
                        <p>Associate Photo & Signature</p>
                    </div>
                </div>
            </div>
			           
        </div>
    </body>
</html>