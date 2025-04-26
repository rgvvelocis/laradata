<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                        <span class="text-white fs-1">
						{{ config('app.name') }}
                             
                        </span>
                        <span class="text-white fs-1">
						{{ config('app.name') }}
                           
                        </span>
                    </a>

                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                
            </div>

            <div class="d-flex align-items-center">

                 

               
  

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                 

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                     
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
						
                            <img class="rounded-circle header-profile-user" src="{{ asset('public/uploads/avtar/uicon.png')}}">
								
								
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->company_name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
									@if(auth()->user()->type == 1)
										Supper Admin
									@elseif(auth()->user()->type == 2)
										Admin
									@else
										Support
									@endif
								</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        
						<h6 class="dropdown-header">Welcome {{ auth()->user()->company_name }}!</h6>
                        <a class="dropdown-item" href="{{ route('admin.resetPassword',[auth()->user()->token,'admin.dashboard']) }}" ><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Change Password</span></a>
                        <a class="dropdown-item" href="{{route('admin.logout')}}" ><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
								
								 
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>