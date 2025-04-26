@extends('customer.layouts.app')
 @section('title', $title)
@section('content')
<div class="container-fluid">
<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">User Dashboard</h4> 
			</div>
		</div>
	</div>
	<!-- end page title -->
	<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">WORK SUMMARY </h4>
			</div>
			<div class="card-body">
				<div class="live-preview">					 
					<div class="row gy-4">						 
				<div class="col-12 col-sm-12">
                   <div class="row">
                    <div class="col-12 col-sm-12">                        
                    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
						 <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-animate bg-gradient bg-success">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-white mb-0">Work Completed</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $data[0]->completeform}}">0</span></h2>
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

                                    <div class="col-md-4">
                                        <div class="card card-animate bg-gradient bg-warning">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-white mb-0">Total Assign Work</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $data[0]->totalform}}">0</span></h2>
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
									<div class="col-md-4">
                                        <div class="card card-animate bg-gradient bg-info">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-white mb-0">Work End Date</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value_">{{ $user->user_sub_date}}</span></h2>
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
