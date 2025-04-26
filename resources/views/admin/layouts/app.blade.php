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
	
	
	{{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> --}}
	    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">


	 <!-- dropzone css -->
    <link rel="stylesheet" href="{{ asset('public/assets/libs/dropzone/dropzone.css')}}" type="text/css" />

    <!-- Filepond css -->
    <link rel="stylesheet" href="{{ asset('public/assets/libs/filepond/filepond.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">
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
	
     
	<script> var base_url = "{{  url('') }}"; </script>
	<style>
	.dataTables_length,.dataTables_filter {
		display: inline-flex;
	}
	#example_paginate,#example_filter,.dataTables_filter{float:right;}
	.form-control:focus,.form-select:focus
	{
		border-color: #fa5661;
	}
    .table-nowrap td, .table-nowrap th {
        white-space: normal;
    }
	 
	</style>
	@yield('style')
</head>
<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('admin.includes.header')
        <!-- ========== App Menu ========== -->
		
		@include('admin.includes.sidebar')
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

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
   <!-- <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.js"></script> -->
    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
   <!-- <script src="{{ asset('public/assets/js/plugins.js')}}"></script> -->

    <!-- apexcharts -->
  <!--  <script src="{{ asset('public/assets/libs/apexcharts/apexcharts.min.js')}}"></script> -->

    <!-- Dashboard init -->
  <!--  <script src="{{ asset('public/assets/js/pages/dashboard-crm.init.js')}}"></script> -->

 
	
    <!-- App js -->
   <script src="{{ asset('public/assets/js/app.js')}}"></script> 
	<script src="{{ asset('public/assets/js/custom.js')}}"></script>
	<!-- <script src="{{ asset('public/assets/scripts/choices.min.js')}}"></script> -->
	
    <script src="{{ asset('public/backend/js/sweetalert.js')}}"></script>

	
	<!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
	 <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

	@include('sweetalert::alert')
    
    <script>
    function newexportaction(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
             // Just this once, load all data from the server...
             data.start = 0;
             data.length = 2147483647;
             dt.one('preDraw', function (e, settings) {
                 // Call the original action function
                 if (button[0].className.indexOf('buttons-copy') >= 0) {
                     $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                     $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                     $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                     $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-print') >= 0) {
                     $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                 }
                 dt.one('preXhr', function (e, s, data) {
                     // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                     // Set the property to what it was before exporting.
                     settings._iDisplayStart = oldStart;
                     data.start = oldStart;
                 });
                 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                 setTimeout(dt.ajax.reload, 0);
                 // Prevent rendering of the full data to the DOM
                 return false;
             });
         });
         // Requery the server with the new one-time export settings
         dt.ajax.reload();
     }
    </script>

	@yield('script')
	
	
</body> 
</html>
 
 
