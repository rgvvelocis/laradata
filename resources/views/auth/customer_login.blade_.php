<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <meta charset="utf-8" />
    <title>Sign In | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="CGWB - Publications and Media Warehouse" name="description" />
    <meta content="CGWB - Publications and Media Warehouse" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">
    <!-- Layout config Js -->
    <script src="{{ asset('public/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('public/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
	<script> var base_url = "{{  url('') }}"</script>
</head>

<body>
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper pt-5_">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        <canvas class="particles-js-canvas-el" width="1343" height="380" style="width: 100%; height: 100%;"></canvas></div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="assets/images/logo-light.png" alt="" height="20">
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to {{ config('app.name') }}.</p>
                                </div>
                                <div class="p-2 mt-4">
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
                                    <form method="POST" action="{{ route('customer.login') }}" class="w-100" id="login_frm" autocomplete="off">

                                        @csrf
										<div class="mb-3">
											<label for="username" class="form-label">{{ __('Username') }}</label>
											<input type="text" id="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="off" autofocus>
											@error('username')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
										<div class="mb-3">
											 
											<label class="form-label" for="password-input">{{ __('Password') }}</label>
											<div class="position-relative auth-pass-inputgroup mb-3">

												<input id="password-input" type="password" class="password-input form-control @error('password') is-invalid @enderror pe-5" name="password" required autocomplete="off">
												<button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
												@error('password')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
											</div>
										</div>

                                        <div class="form-check">
                                            <input name="remember_me" class="form-check-input" type="checkbox" value="1" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>
 
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
 

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
	<script src="{{asset('public/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins.js') }}"></script>

    <!-- password-addon init -->
    <script src="{{ asset('public/assets/js/pages/password-addon.init.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/backend/js/sha.js') }}"></script>
	@include('sweetalert::alert')

	<script>
function handlePreloader() {
		 if($('.preloader').length){
			 $('body').removeClass('active-preloader-ovh');
			 $('.preloader').fadeOut();
		 }
	 }


	 jQuery(window).on('load', function() {
		 (function($) {
			 handlePreloader()
		 })(jQuery);
    });
 

$(document).ready(function(){
	$('.changelogin').click(function(){
		var checkedval=$(this).val();
		if(checkedval=='Login'){
			$('#login_frm').show();
			$('#registerform').hide();
		}else{
			$('#login_frm').hide();
			$('#registerform').show();
		}
	});
});

 

 
</script>

</body>
</html>


