@php
$currentUrl = \Route::currentRouteName();
$module_name = (!empty($module_name) ? $module_name : '' );
@endphp
<div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                   <span class="text-white fs-1" style="font-size: 25px !important;">
					{{ config('app.name') }}
                        
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    
                    <span class="text-white fs-1"  style="font-size: 25px !important;">
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
                            <a class="nav-link menu-link" href="{{route('admin.dashboard')}}"  >
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                            </a>

                        </li> <!-- end Dashboard Menu -->
                    
						<!-- User management -->
			@can('admin_access')
                          	{{-- <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarorganizations" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Admin</span>
                            </a>
                            <div class="collapse menu-dropdown {{($currentUrl == 'admin.admin.index' || $currentUrl == 'admin.admin.edit' || $currentUrl == 'admin.admin.create' || $currentUrl == 'admin.roles.index' || $currentUrl == 'admin.roles.edit' || $currentUrl == 'admin.roles.create' || $currentUrl == 'admin.roles.show' ) ? 'show' : '' }}" id="sidebarorganizations">
                                <ul class="nav nav-sm flex-column">                                   
                                    <li class="nav-item">
                                        <a href="{{route('admin.admin.index')}}" class="nav-link {{($currentUrl == 'admin.admin.index' || $currentUrl == 'admin.admin.create' || $currentUrl == 'admin.admin.edit' ) ? 'active' : '' }}" data-key="t-crm"> Admin List </a>
                                    </li>
									 

								<li class="nav-item">
                                        <a href="{{route('admin.roles.index')}}" class="nav-link {{($currentUrl == 'admin.roles.index' || $currentUrl == 'admin.roles.edit' || $currentUrl == 'admin.roles.create' || $currentUrl == 'admin.roles.show') ? 'active' : '' }}" data-key="t-crm"> Role </a>
                                    </li> 


                                </ul>
                            </div>
                        </li> --}}
                    @endcan
                    
                    @can('agent_access')
						 
						 <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                                <i class="ri-pages-line"></i> <span data-key="t-pages">Agent List</span>
                            </a>
                            <div class="collapse menu-dropdown {{($currentUrl == 'admin.admin-agents.index' || $currentUrl == 'admin.admin-agents.edit' || $currentUrl == 'admin.admin-agents.create' || $currentUrl == 'admin.admin-agents.show' ) ? 'show' : '' }}" id="sidebarPages">
                                <ul class="nav nav-sm flex-column">

                                    <li class="nav-item">
                                        <a href="{{route('admin.admin-agents.index')}}" class="nav-link {{($currentUrl == 'admin.admin-agents.index' || $currentUrl == 'admin.admin-agents.edit' || $currentUrl == 'admin.admin-agents.create' || $currentUrl == 'admin.admin-agents.show') ? 'active' : '' }}" data-key="t-crm"> Agent List </a>
                                    </li>
									 

                                </ul>
                            </div>
                        </li>
					@endcan	
                        @can('support_access')
						<li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarSupportList" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSupportList">
                                <i class="ri-pages-line"></i> <span data-key="t-pages">Support List</span>
                            </a>
                            <div class="collapse menu-dropdown {{($currentUrl == 'admin.supports.index' || $currentUrl == 'admin.supports.edit' || $currentUrl == 'admin.supports.create' || $currentUrl == 'admin.category.show' || $currentUrl == 'admin.permissions.index' || $currentUrl == 'admin.permissions.edit' || $currentUrl == 'admin.permissions.create') ? 'show' : '' }}" id="sidebarSupportList">
                                <ul class="nav nav-sm flex-column">

                                    <li class="nav-item">
                                        <a href="{{route('admin.supports.index')}}" class="nav-link {{($currentUrl == 'admin.supports.index' || $currentUrl == 'admin.supports.create' || $currentUrl == 'admin.supports.edit' || $currentUrl == 'admin.category.create' || $currentUrl == 'admin.category.show') ? 'active' : '' }}" data-key="t-crm"> Support List </a>
                                    </li>
									 
                                </ul>
                            </div>
                        </li>
			@endcan	
                        
                       
						@can('work_report_access')  
						<li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarWorkReport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarWorkReport">
                                <i class="ri-pages-line"></i> <span data-key="t-pages">Work Report</span>
                            </a>
                            <div class="collapse menu-dropdown {{( $module_name == 'customer' || $module_name == 'plan' || $module_name == 'datalist' ||  $module_name == 'active_customer_list') ? 'show' : '' }}" id="sidebarWorkReport">
                                <ul class="nav nav-sm flex-column">

                                    <li class="nav-item">
                                        <a href="{{route('admin.admin-customer.index')}}" class="nav-link {{($currentUrl == 'admin.admin-customer.index') ? 'active' : '' }}" data-key="t-crm"> Customer List </a>
                                    </li>
									<li class="nav-item">
                                        <a href="{{route('admin.plan.index')}}" class="nav-link {{($module_name == 'plan' ) ? 'active' : '' }}" data-key="t-crm"> Plan List </a>
                                    </li>
									<li class="nav-item">
                                        <a href="{{route('admin.datalist.index')}}" class="nav-link {{($module_name == 'datalist') ? 'active' : '' }}" data-key="t-crm"> Data List </a>
                                    </li>
									<li class="nav-item">
                                        <a href="{{route('admin.activeUsers')}}" class="nav-link {{($module_name == 'active_customer_list') ? 'active' : '' }}" data-key="t-crm"> Active User </a>
                                    </li>
									 
                                </ul>
                            </div>
                        </li>
						@endcan
						@can('task_report_access')
						<li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarTaskReport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTaskReport">
                                <i class="ri-pages-line"></i> <span data-key="t-pages">Task Report</span>
                            </a>
                            <div class="collapse menu-dropdown {{($module_name == 'completeList' || $module_name == 'notcomplete' || $module_name == 'release' || $currentUrl == 'admin.completeList' || $currentUrl == 'admin.notCompleteList' || $currentUrl == 'admin.reportRelease' ) ? 'show' : '' }}" id="sidebarTaskReport">
                                <ul class="nav nav-sm flex-column">
 
                                    <li class="nav-item">
                                        <a href="{{ route('admin.completeList')}} " class="nav-link {{($module_name == 'completeList' || $currentUrl == 'admin.completeList' ) ? 'active' : '' }}" data-key="t-crm"> Completed List </a>
                                    </li>
									<li class="nav-item">
                                        <a href="{{ route('admin.notCompleteList')}} " class="nav-link {{($module_name == 'notcomplete' || $currentUrl == 'admin.notCompleteList' ) ? 'active' : '' }}" data-key="t-crm"> Non-Completed List </a>
                                    </li>
									<li class="nav-item">
                                        <a href="{{ route('admin.reportRelease')}} " class="nav-link {{($module_name == 'release' ||  $currentUrl == 'admin.reportRelease' ) ? 'active' : '' }}"   data-key="t-crm"> Report Release List </a>
                                    </li>
									 
                                </ul>
                            </div>
                        </li>
                     @endcan
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{route('admin.logout')}}"  >

								<i class="ri-logout-box-r-line"></i> <span data-key="t-dashboards">Logout</span>

                            </a>

                        </li> <!-- end LOgout Menu -->


                    </ul>
                </div>

            </div>
 <!-- Sidebar end -->


            <div class="sidebar-background"></div>
        </div>
