@extends('admin.layouts.app')

@section('content')
<div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Change Password</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                                        <li class="breadcrumb-item active">Change Password</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>


<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Change Password</h4>
                                
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
								@if($errors)
									@foreach ($errors->all() as $error)
										<div class="alert alert-danger">{{ $error }}</div>
									@endforeach
								@endif     
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="live-preview">
                                        <form method="POST" action="{{ route('superadmin.changePasswordPost') }}" id="password_frm" class="w-100" autocomplete="off">
										{{ csrf_field() }}
                                        <div class="row gy-6">
                                             
                                            
                                            <!--end col-->
                                            <div class="col-xxl-6 col-md-6 gy-3">
                                                <div>
                                                    <label for="placeholderInput" class="form-label">Current Password</label>
                                                    <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Current Password" required>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 gy-3">
                                                <div>
                                                    <label for="placeholderInput" class="form-label">New Password</label>
                                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" required>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 gy-3">
                                                <div>
                                                    <label for="placeholderInput" class="form-label">Confirm Password</label>
                                                    <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm Password" required>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 gy-3">
												<div>
													<label for="placeholderInput" class="form-label" >. </label>
												<input class=" form-control btn btn-primary" type="submit" value="Change Password">
												</div>
											</div>
                                            
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <div class="d-none code-view">
                                        <pre class="language-markup" style="height: 450px;"><code> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>


 
	@php
		$salt = rand('1000','9999');
        session(['salt' => $salt]);
	@endphp


@endsection
@push('script')
		<script type="text/javascript" src="{{ asset('public/backend/js/sha.js') }}"></script>
		<script>
           
			
			 $(document).on('submit','#password_frm_',function(){

                var salt = '{{ $salt }}';
                var secret = $('#new_password').val();
                var shaObj = new jsSHA("SHA-256", "TEXT");
                shaObj.update(secret);
                var hashPass = shaObj.getHash("HEX");
                $('#new_password').val(hashPass);


                var secretcurrent = $('#current_password').val();
                var shaObjcurrent = new jsSHA("SHA-256", "TEXT");
                shaObjcurrent.update(secretcurrent);
                var hashPasscurrent = shaObjcurrent.getHash("HEX");
                $('#current_password').val(hashPasscurrent);

                var secretconfirm = $('#new_password_confirmation').val();
                var shaObjconfirm = new jsSHA("SHA-256", "TEXT");
                shaObjconfirm.update(secretconfirm);
                var hashPassconfirm = shaObjconfirm.getHash("HEX");
                $('#new_password_confirmation').val(hashPassconfirm);
            });
			
		</script>
@endpush

