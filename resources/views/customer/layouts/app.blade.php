<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} -  @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }} -  @yield('title')" name="description" />
    <meta content="RGV" name="author" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico')}}">
	
	 <!-- dropzone css -->
   <!-- <link rel="stylesheet" href="{{ asset('public/assets/libs/dropzone/dropzone.css')}}" type="text/css" /> -->

    <!-- Filepond css -->
 <!--   <link rel="stylesheet" href="{{ asset('public/assets/libs/filepond/filepond.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}"> -->
 <!-- Layout config Js -->
    <script src="{{ asset('public/assets/js/layout.js')}}"></script>
	
	
	<script src="{{ asset('public/assets/js/jquery.min.js')}}"></script>
	
   
    <!-- Bootstrap Css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('public/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('public/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
     <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> 
	<script> var base_url = "{{  url('') }}";</script>
	<style>
	.dataTables_length,.dataTables_filter {
		display: inline-flex;
	}
	#example_paginate,#example_filter,.dataTables_filter{float:right;}
	.form-control:focus,.form-select:focus
	{
		border-color: #fa5661;
	}
	table.dataTable thead th, table.dataTable tbody td {
   /*  white-space: nowrap; */
    border: 1px solid #e3e3e3;
    border-collapse: collapse;
    border-right: 0;
    border-bottom: 0;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #e3e3e3;
}
.whole-page-overlay{
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  position: fixed;
  background: rgba(0,0,0,0.6);
  width: 100%;
  height: 100% !important;
  z-index: 9999;
  display: none;
}
.whole-page-overlay .center-loader{
  top: 50%;
  left: 52%;
  position: absolute;
  color: white;
}
	</style>
	@yield('style')
</head>
<body>
    <div class="whole-page-overlay" id="whole_page_loader">
         <img class="center-loader"  style="height:100px;" src="{{ asset('public/cgwbspin.gif') }}"/>
	</div>
    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('customer.includes.header')
        <!-- ========== App Menu ========== -->
		
		@include('customer.includes.sidebar')
		<!-- Left Sidebar End -->        
        
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                @yield('content')
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> 
                        </div>
 
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
	
	
  <div class="modal fade" id="mi-modal" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true">
  <div class="modal-dialog modal-mm">
    <div class="modal-content">
        <div class="modal-header" >
            
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
	  
	  <div class="modal-body" style="text-align: center;">
			 
			{{-- <img class="alert-img"  src="{{asset('public/admin/images/question.svg')}}" /></br> --}}
            @php 
           $checkSubmit =  checkSubmit(Auth::guard('miscust')->user()->id);

            @endphp

              <?php if($checkSubmit > 0) { ?> 
              
              <h2>Already submission done!!</h2>
              
              <?php }else{?>
            
            <h1>Are you sure?</h1></br>
            
            <h3>Modification not allowed after final submission!</h3>
            
              <?php }?>
          </div>
	  
        <div class="modal-footer" style="margin: 0 auto;">
          <?php if($checkSubmit > 0) { ?> 
           <button type="button" class="btn btn-danger" style="border-radius: 20px;padding: 12px 42px;" id="modal-btn-no">Close</button>
          <?php }else{?>
           <button type="button" class="btn btn-danger" style="border-radius: 20px;padding: 12px 42px;" id="modal-btn-no">NO</button>
           <button type="button" class="btn btn-primary" style="border-radius: 20px;padding: 12px 42px;" id="modal-btn-si">YES</button>
         <?php }?>
      </div>
    </div>
  </div>
</div>

    <!-- start back-to-top -->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
     
    
    <!-- App js -->
     <script src="{{ asset('public/assets/js/app.js')}}"></script>  
	<script src="{{ asset('public/assets/js/custom.js')}}"></script>
	 
	 <script src="{{ asset('public/backend/js/sweetalert.js')}}"></script>

	@yield('script')
	<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	@include('sweetalert::alert')
	<script type="application/javascript">
	$(document).ready(function () {
        var modalConfirm = function (callback) {

            $("#btn-confirm").on("click", function () {
                $("#mi-modal").modal('show');
            });

            $("#modal-btn-si").on("click", function () {
                callback(true);
                $("#mi-modal").modal('hide');
            });

            $("#modal-btn-no").on("click", function () {
                callback(false);
                $("#mi-modal").modal('hide');
            });
        };

        modalConfirm(function (confirm) {
            if (confirm) {

                $.ajax({
                    url: '{{ route("customer.finalSubmitWork")}}',
                    type: "POST",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
                    success: function (response)
                    {
                        alert(response);
                        window.location.href = '{{ route("customer.viewReport")}}';

                    }
                });

            } else {
                //Acciones si el usuario no confirma
                $("#result").html("NO CONFIRMADO");
            }
        });



    });
</script>	
	
</body> 
</html>
 
 
