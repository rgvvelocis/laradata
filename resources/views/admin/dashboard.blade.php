@extends('admin.layouts.app')
 
@section('content')
<div class="container-fluid">

	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Dashboard</h4>

				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div>

			</div>
		</div>
	</div>
	<!-- end page title -->
	<div class="row">
	<div class="col-lg-12">
		<div class="card">	  
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">TODAY SUMMARY </h4>
			</div>
			<div class="card-body">
				<div class="live-preview">	 
					<div class="row gy-4">				 
						<div class="col-md-3">
							<div class="card card-animate bg-gradient bg-success">
								<div class="card-body">
									<div class="d-flex justify-content-between">
										<div>
											<p class="fw-medium text-white mb-0">Total Client</p>
											<h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $data['total_customer_today']}}">0</span></h2>
											<p class="mb-0 text-white">&nbsp;</p>
										</div>
										<div>
											<div class="avatar-sm flex-shrink-0">
												<span class="avatar-title bg-soft-info rounded-circle fs-2">
													<i data-feather="activity" class="text-info"></i>
												</span>
											</div>
										</div>
									</div>
								</div><!-- end card body -->
							</div> <!-- end card-->
						</div> <!-- end col-->

						<div class="col-md-3">
							<div class="card card-animate bg-gradient bg-warning">
								<div class="card-body">
									<div class="d-flex justify-content-between">
										<div>
											<p class="fw-medium text-white mb-0">Total Pending</p>
											<h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $data['total_pending_customer_today']}}">0</span></h2>
											<p class="mb-0 text-white">&nbsp;</p>
										</div>
										<div>
											<div class="avatar-sm flex-shrink-0">
												<span class="avatar-title bg-soft-info rounded-circle fs-2">
													<i data-feather="activity" class="text-info"></i>
												</span>
											</div>
										</div>
									</div>
								</div><!-- end card body -->
							</div> <!-- end card-->
						</div> <!-- end col-->
						<div class="col-md-3">
							<div class="card card-animate bg-gradient bg-info">
								<div class="card-body">
									<div class="d-flex justify-content-between">
										<div>
											<p class="fw-medium text-white mb-0">Total Receive</p>
											<h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value_">{{ $data['total_approve_customer_today']}}</span></h2>
											<p class="mb-0 text-white">&nbsp;</p>
										</div>
										<div>
											<div class="avatar-sm flex-shrink-0">
												<span class="avatar-title bg-soft-info rounded-circle fs-2">
													<i data-feather="activity" class="text-info"></i>
												</span>
											</div>
										</div>
									</div>
								</div><!-- end card body -->
							</div> <!-- end card-->
						</div> <!-- end col-->
						<div class="col-md-3">
							<div class="card card-animate bg-gradient bg-info">
								<div class="card-body">
									<div class="d-flex justify-content-between">
										<div>
											<p class="fw-medium text-white mb-0">Total Reject</p>
											<h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value_">{{ $data['total_reject_customer_today']}}</span></h2>
											<p class="mb-0 text-white">&nbsp;</p>
										</div>
										<div>
											<div class="avatar-sm flex-shrink-0">
												<span class="avatar-title bg-soft-info rounded-circle fs-2">
													<i data-feather="activity" class="text-info"></i>
												</span>
											</div>
										</div>
									</div>
								</div><!-- end card body -->
							</div> <!-- end card-->
						</div> <!-- end col-->
						 
						
					</div> <!-- end row-->
 
				</div>
			</div>
		</div>
		
		
		<div class="card">	  
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">OVERALL STATISTICS</h4>
			</div>
			<div class="card-body">
				<div class="live-preview">	 
					<div class="row gy-4">				 
						<div class="col-md-3">
							<div class="card card-animate bg-gradient bg-success">
								<div class="card-body">
									<div class="d-flex justify-content-between">
										<div>
											<p class="fw-medium text-white mb-0">Total Client</p>
											<h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $data['total_customer']}}">0</span></h2>
											<p class="mb-0 text-white">&nbsp;</p>
										</div>
										<div>
											<div class="avatar-sm flex-shrink-0">
												<span class="avatar-title bg-soft-info rounded-circle fs-2">
													<i data-feather="activity" class="text-info"></i>
												</span>
											</div>
										</div>
									</div>
								</div><!-- end card body -->
							</div> <!-- end card-->
						</div> <!-- end col-->

						<div class="col-md-3">
							<div class="card card-animate bg-gradient bg-warning">
								<div class="card-body">
									<div class="d-flex justify-content-between">
										<div>
											<p class="fw-medium text-white mb-0">Total Pending</p>
											<h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $data['total_pending_customer']}}">0</span></h2>
											<p class="mb-0 text-white">&nbsp;</p>
										</div>
										<div>
											<div class="avatar-sm flex-shrink-0">
												<span class="avatar-title bg-soft-info rounded-circle fs-2">
													<i data-feather="activity" class="text-info"></i>
												</span>
											</div>
										</div>
									</div>
								</div><!-- end card body -->
							</div> <!-- end card-->
						</div> <!-- end col-->
						<div class="col-md-3">
							<div class="card card-animate bg-gradient bg-info">
								<div class="card-body">
									<div class="d-flex justify-content-between">
										<div>
											<p class="fw-medium text-white mb-0">Total Receive</p>
											<h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value_">{{ $data['total_approve_customer']}}</span></h2>
											<p class="mb-0 text-white">&nbsp;</p>
										</div>
										<div>
											<div class="avatar-sm flex-shrink-0">
												<span class="avatar-title bg-soft-info rounded-circle fs-2">
													<i data-feather="activity" class="text-info"></i>
												</span>
											</div>
										</div>
									</div>
								</div><!-- end card body -->
							</div> <!-- end card-->
						</div> <!-- end col-->
						<div class="col-md-3">
							<div class="card card-animate bg-gradient bg-info">
								<div class="card-body">
									<div class="d-flex justify-content-between">
										<div>
											<p class="fw-medium text-white mb-0">Total Reject</p>
											<h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value_">{{ $data['total_reject_customer']}}</span></h2>
											<p class="mb-0 text-white">&nbsp;</p>
										</div>
										<div>
											<div class="avatar-sm flex-shrink-0">
												<span class="avatar-title bg-soft-info rounded-circle fs-2">
													<i data-feather="activity" class="text-info"></i>
												</span>
											</div>
										</div>
									</div>
								</div><!-- end card body -->
							</div> <!-- end card-->
						</div> <!-- end col-->
						 
						
					</div> <!-- end row-->
					<?php if (auth()->user()->roles[0]->id == 1) { ?>
						<div class="row">
							<div class="col-md-6 col-xl-4">
								<div class="card mb-3 widget-content bg-premium-dark_">
									<div class="widget-content-wrapper text-white">
										<div class="widget-content-left" style="margin: 0 auto;">
											
											<div class="widget-numbers text-white"><span>
												<a class="btn btn-primary" href="{{ route('admin.deleteFullCustomerDetail')}}">Delete 20days old all Customer & User</a>
												</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?> 
						<?php if (auth()->user()->roles[0]->id == 3) { ?>
						<div class="row">
							<div class="col-md-6 col-xl-4">
								<div class="card mb-3 widget-content bg-premium-dark_">
									<div class="widget-content-wrapper text-white">
										<div class="widget-content-left" style="margin: 0 auto;">
											<div class="widget-numbers text-white"><span><button class="btn btn-primary" onclick="final_submit_after_date_over();" id="" name="">User Final Submit Date Over</button></span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?> 
 
				</div>
			</div>
		</div>
		
	</div>
	 
	</div>
                    
 


</div>
<!-- container-fluid -->
<script>

function final_submit_after_date_over() {
        var con = confirm("Do You want to continue.");
        if (con == true) {
            $.ajax({
                url: "{{ route('admin.userFinalSubmitDateOver')}}",
                type: "POST",
                data: { status: 0 },
				headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
                success: function (response) {
                    if (response.trim() == "success") {
                        alert("Your aperation has been done!!");
                        window.location.href = "{{ route('admin.dashboard')}}";
                    }
                },
            });
        } else {
            return false;
        }
    }
</script>
@endsection
