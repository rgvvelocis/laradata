<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<title>Sign In | {{ config('app.name') }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- LINEARICONS -->
		<link rel="stylesheet" href="https://colorlib.com/etc/regform/colorlib-regform-26/fonts/linearicons/style.css">
		
        
    <link rel="stylesheet" href="{{ asset('public/flogin/css/style.css')}}" media="screen">
    <script> var base_url = "{{  url('') }}";</script>
</head>

	<body>
		<div class="wrapper">
			<div class="inner">
            
				<!-- <img src="{{ asset('public/flogin/image-1.png')}}" alt="" class="image-1"> -->
				<form method="POST" action="{{ route('customer.login') }}" class="w-100" id="login_frm" autocomplete="off">
                @csrf					
                <h3>Login {{ config('app.name') }}</h3>
                    <div>                                          
                    @if (session('error'))
                            <div class="alert alert-danger">
                            {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                            {{ session('success') }}
                            </div>
                        @endif                                                           
                    </div>
					<div class="form-holder">
						<span class="lnr lnr-user"></span>
						<input type="text" class="form-control" name="username" value="" required autocomplete="off" autofocus placeholder="Username">
					</div>
					 
					 
					<div class="form-holder">
						<span class="lnr lnr-lock"></span>
						<input type="password" class="form-control" name="password" required autocomplete="off" placeholder="Password">
					</div>
				 
				 					 
                        <button class="btn btn-success w-100" type="submit">Sign In</button>
					 
				</form>
				<img src="{{ asset('public/flogin/image-2.png')}}" alt="" class="image-2">
			</div>
			
		</div>
		
		<!-- <script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/main.js"></script> -->
	 
</body> 
</html>