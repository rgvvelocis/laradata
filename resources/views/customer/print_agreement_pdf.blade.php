 
<!DOCTYPE html>
<html lang="en">
    <head>
        <style  type="text/css">
            .container{line-height: 25px;width: 1024px;margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="container">
            <div style="text-align: justify;width: 90%; margin: 0 auto; padding: 30px 0px 20px 0px; font-family: Roboto, 'Segoe UI', Tahoma, sans-serif;" class="flyleaf">    
                <div style="width: 100%;text-align: right;float: left;">
                    <p>Date : {{ date('d-m-Y')}}</p>
                </div>
                <div style="width: 100%;text-align: right;float: left;">
                    <h3 style="text-align: center">Legal Employment Contract({{ date('Y')}})</h3>
                </div>

                <p style="text-align: center;">BETWEEN:</p>
                <div style="width: 100%;float: left;">
                    <div style="width: 50%;float: left;">
                        <h3 style="text-align: left;">M/s. {{ $customer_detail->company_name}}</h3>
                        <h4>ADDRESS: - {{  $customer_detail->address}}</h4>
                    </div>
                    <div style="width: 50%;float: left;text-align: center;">
                        <br><p>(THE EMPLOYER)<br>OF THE FIRST PARTY</p>
                    </div>
                </div>
                <div style="width: 100%;text-align: center;float: left;">
                    <h3>AND</h3>
                </div>
                <div style="width: 100%;float: left;">
                    <div style="width: 50%;float: left;">
                        <h3 style="text-align: left;">Mr. / Mrs / Ms. {{  $customer_detail->customer_name}}</h3>
                        <h4>ADDRESS: - {{ $customer_detail->customer_locality}} {{ html_entity_decode($customer_detail->your_city)}} {{ $customer_detail->your_state}} {{$customer_detail->customer_pincode}}</h4>
                    </div>
                    <div style="width: 50%;float: left;text-align: center;">
                        <br><p>(THE EMPLOYEE)<br>OF THE SECOND PARTY</p>
                    </div>
                </div>
                <h4 style="float: left;width: 100%;">BACKGROUND:</h4> 
                <div style="width: 100%;float: left;">
                {!!  $customer_detail->agreement_text !!}
                </div>
 
                
                <div style="width: 100%;float: left;">
                    <div style="width: 50%;float: left;">
                        <h3 style="text-align: center;margin: 1em 0 0 0;">A. Employer :- (First Party)</h3>
                        <h4 style="text-align: center;margin: 0;">Name - (M/s. {{ $customer_detail->company_name}})</h4>
                        
                    </div>
                    <div style="width: 50%;float: left;text-align: center;">
                        <h3 style="text-align: center;margin: 1em 0 0 0;">B. Employee :- (Second Party)</h3>
                        <h4 style="text-align: center;margin: 0;">Name - ({{ $customer_detail->customer_name}})</h4>
                    </div>
                </div>
                <div style="width: 100%;float: left;">
                    <div style="width: 50%;float: left;text-align: center;">
                        @if(!empty($customer_detail->company_stamp)) 
                        <img style="width: 100px;" src="{{ asset('public/uploads/admin/company/'.$customer_detail->company_stamp)}}">  
						@endif
                    </div>
                    <div style="width: 50%;float: left;text-align: center;">
                         @if(!empty($customer_detail->upload_own_photo)) 
                        <img style="width: 100px;" src="{{ asset('public/uploads/customer_pic/'.$customer_detail->upload_own_photo)}}"> 
						@endif
					   <br>
                        @if(!empty($customer_detail->upload_own_signature)) 
                        <img style="width: 100px;" src="{{ asset('public/uploads/customer_signature/'.$customer_detail->upload_own_signature)}}"> 
						@endif 
                    </div>
                </div>
                <div style="width: 100%;float: left;">
                    <div style="width: 50%;float: left;text-align: center;">
                        <p>Authorized Stamp & Signature</p>
                    </div>
                    <div style="width: 50%;float: left;text-align: center;">
                        <p>Associate Photo & Signature</p>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>