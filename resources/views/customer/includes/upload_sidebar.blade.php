@php
$currentUrl = \Route::currentRouteName();
$module_name = (!empty($module_name) ? $module_name : '' );
@endphp
<div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                   <span class="text-white fs-1">
					{{ config('app.name') }}
                        
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    
                    <span class="text-white fs-1">
					{{ config('app.name') }}
                        
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>


            <!-- Sidebar start -->
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link menu-link {{ ($module_name == 'dashboard') ? 'active' : ''}}" href="{{route('customer.dashboard')}}"  >
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                            </a>

                        </li> <!-- end Dashboard Menu -->
						 
						 
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{route('customer.logout')}}"  >

								<i class="ri-logout-box-r-line"></i> <span data-key="t-dashboards">Logout</span>

                            </a>

                        </li> <!-- end LOgout Menu -->


                    </ul>
                </div>

            </div>
 <!-- Sidebar end -->


            <div class="sidebar-background"></div>
        </div>
