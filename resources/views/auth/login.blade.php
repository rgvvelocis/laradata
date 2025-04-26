
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="page_type" content="">
    <title>Sign In | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('public/login/css/style.css')}}" media="screen">
    <script> var base_url = "{{  url('') }}"</script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <style class="u-style">.u-section-2 .u-sheet-1 {
  min-height: 703px;
}
.u-section-2 .u-layout-wrap-1 {
  margin-top: 1%;
  margin-bottom: -1%;
}
.u-section-2 .u-layout-cell-1 {
  min-height: 583px;
  height : 100%;
}
.u-section-2 .u-container-layout-1 {
  padding: 30px;
}
.u-section-2 .u-image-1 {
  width: 343px;
  height: 376px;
  margin: 0 auto;
}
.u-section-2 .u-text-1 {
  font-size: 0.875rem;
  margin: 30px auto 0;
}
.u-section-2 .u-btn-1 {
  background-image: none;
  padding: 0;
}
.u-section-2 .u-layout-cell-2 {
  min-height: 583px;
  background-image: none;
}
.u-section-2 .u-container-layout-2 {
  padding: 25px 30px;
}
.u-section-2 .u-form-1 {
  height: 382px;
  background-image: none;
  width: 451px;
  margin: 0 auto;
}
.u-section-2 .u-input-1 {
  background-image: none;
}
.u-section-2 .u-input-2 {
  background-image: none;
}
.u-section-2 .u-btn-2 {
  width: 100%;
  background-image: none;
  border-style: none;
  padding: 10px 31px 10px 29px;
}
.u-section-2 .u-btn-3 {
  align-self: center;
  border-style: none;
  margin: 20px auto 0;
  padding: 0;
}
.u-section-2 .u-btn-4 {
  border-style: none;
  margin: 20px auto 0;
  padding: 0;
}
@media (max-width: 1199px) {
  .u-section-2 .u-sheet-1 {
    min-height: 643px;
  }
  .u-section-2 .u-layout-wrap-1 {
    margin-bottom: -503px;
  }
  .u-section-2 .u-layout-cell-1 {
    min-height: 481px;
  }
  .u-section-2 .u-layout-cell-2 {
    min-height: 481px;
  }
  .u-section-2 .u-form-1 {
    width: 410px;
  }
}
@media (max-width: 991px) {
  .u-section-2 .u-layout-wrap-1 {
    margin-bottom: -648px;
  }
  .u-section-2 .u-layout-cell-1 {
    min-height: 100px;
  }
  .u-section-2 .u-image-1 {
    width: 300px;
    height: 329px;
  }
  .u-section-2 .u-layout-cell-2 {
    min-height: 100px;
  }
  .u-section-2 .u-form-1 {
    width: 300px;
  }
}
@media (max-width: 767px) {
  .u-section-2 .u-sheet-1 {
    min-height: 1084px;
  }
  .u-section-2 .u-layout-wrap-1 {
    margin-bottom: -617px;
  }
  .u-section-2 .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-2 .u-layout-cell-2 {
    min-height: 523px;
  }
  .u-section-2 .u-container-layout-2 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-2 .u-form-1 {
    width: 470px;
    margin-left: 25px;
    margin-right: 25px;
  }
}
@media (max-width: 575px) {
  .u-section-2 .u-layout-wrap-1 {
    margin-bottom: -403px;
  }
  .u-section-2 .u-form-1 {
    width: 280px;
    margin-left: auto;
    margin-right: auto;
  }
}</style>
    <style class="u-style"> .u-cookies-consent {
  background-image: none;
}
.u-cookies-consent .u-sheet-1 {
  min-height: 212px;
}
.u-cookies-consent .u-layout-wrap-1 {
  margin-top: 30px;
  margin-bottom: 30px;
}
.u-cookies-consent .u-layout-cell-1 {
  min-height: 152px;
}
.u-cookies-consent .u-container-layout-1 {
  padding: 30px 60px;
}
.u-cookies-consent .u-text-1 {
  margin-top: 0;
  margin-right: 20px;
  margin-bottom: 0;
}
.u-cookies-consent .u-text-2 {
  margin: 8px 20px 0 0;
}
.u-cookies-consent .u-layout-cell-2 {
  min-height: 152px;
}
.u-cookies-consent .u-container-layout-2 {
  padding: 30px;
}
.u-cookies-consent .u-btn-1 {
  margin: 0 auto 0 0;
}
@media (max-width: 1199px) {
  .u-cookies-consent .u-sheet-1 {
    min-height: 131px;
  }
  .u-cookies-consent .u-layout-cell-1 {
    min-height: 125px;
  }
  .u-cookies-consent .u-text-1 {
    margin-right: 0;
  }
  .u-cookies-consent .u-text-2 {
    margin-right: 0;
  }
  .u-cookies-consent .u-layout-cell-2 {
    min-height: 125px;
  }
}
@media (max-width: 991px) {
  .u-cookies-consent .u-sheet-1 {
    min-height: 106px;
  }
  .u-cookies-consent .u-layout-cell-1 {
    min-height: 100px;
  }
  .u-cookies-consent .u-container-layout-1 {
    padding-left: 30px;
    padding-right: 30px;
  }
  .u-cookies-consent .u-layout-cell-2 {
    min-height: 100px;
  }
}
@media (max-width: 767px) {
  .u-cookies-consent .u-sheet-1 {
    min-height: 225px;
  }
  .u-cookies-consent .u-layout-cell-1 {
    min-height: 154px;
  }
  .u-cookies-consent .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
    padding-bottom: 20px;
  }
  .u-cookies-consent .u-layout-cell-2 {
    min-height: 65px;
  }
  .u-cookies-consent .u-container-layout-2 {
    padding: 10px;
  }
}
@media (max-width: 575px) {
  .u-cookies-consent .u-sheet-1 {
    min-height: 121px;
  }
  .u-cookies-consent .u-layout-cell-1 {
    min-height: 100px;
  }
  .u-cookies-consent .u-layout-cell-2 {
    min-height: 15px;
  }
}
.alert-danger
{
    color:red;
}
</style>
 
</head>
  <body class="u-body u-xl-mode">
    
    <section class="u-align-center u-clearfix u-section-2" id="sec-05d1">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
          <div class="u-layout">
            <div class="u-layout-row">
              <div class="u-align-center u-container-style u-layout-cell u-size-30 u-layout-cell-1">
                <div class="u-container-layout u-valign-middle u-container-layout-1">
                   <h2 style="color:#8945e8;">Welcome to Superadmin Login</h2>
                  <img class="u-image u-image-contain u-image-default u-image-1" src="{{ asset('public/login/login_banner.png') }}" alt="" data-image-width="473" data-image-height="464">
                   
                </div>
              </div>
              <div class="u-align-center u-container-style u-layout-cell u-palette-1-base u-radius-50 u-shape-round u-size-30 u-layout-cell-2">
                <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-xl u-container-layout-2">
                  <div class="u-form u-login-control u-radius-50 u-white u-form-1">
                    <form action="{{ route('superadmin.login') }}" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-29 u-form-vertical u-inner-form" source="custom" name="login_frm" id="login_frm" style="padding: 30px;">
                    @if (session('error'))
                                       <div class="alert alert-danger text-center" style=" margin: 0 auto;">
                                          {{ session('error') }}
                                       </div>
                                       @endif
                                       @if (session('success'))
                                       <div class="alert alert-success">
                                          {{ session('success') }}
                                       </div>
                                       @endif
                    @csrf  
                    <div class="u-form-group u-form-name">
                        <label for="username-a30d" class="u-label">Username *</label>
                        <input type="text" placeholder="Enter your Username" id="email" name="email" value="{{ old('email') }}" autocomplete="off" autofocus class="@error('email') is-invalid @enderror u-border-1 u-border-grey-30 u-input u-input-rectangle u-input-1" required="">
                             @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      <div class="u-form-group u-form-password">
                        <label for="password-input" class="u-label">Password *</label>
                        <input id="password-input" type="password" placeholder="Enter your Password" autocomplete="off"  name="password" class="password-input  @error('password') is-invalid @enderror u-border-1 u-border-grey-30 u-input u-input-rectangle u-input-2" required="">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="u-form-checkbox u-form-group">
                        <input type="checkbox" id="checkbox-a30d" name="remember" value="On">
                        <label for="checkbox-a30d" class="u-label">Remember me</label>
                      </div>
                      <div class="u-align-left u-form-group u-form-submit">
                        
                        <input type="submit" value="Login" class="u-border-none u-btn u-btn-submit u-button-style u-palette-3-base u-btn-2">
                      </div>
                       
                    </form>
                  </div>
                   
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="{{asset('public/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- password-addon init -->
    <script src="{{ asset('public/assets/js/pages/password-addon.init.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/backend/js/sha.js') }}"></script>
	@include('sweetalert::alert')

    @php $salt = rand('1000','9999');
session(['salt' => $salt]);
@endphp
     <script>
     $(document).on('submit','#login_frm',function(){  
           
           var salt = '{{ $salt }}';
         var secret = $('#password-input').val();
         var shaObj = new jsSHA("SHA-256", "TEXT");
           shaObj.update(secret); 
           var hashPass = shaObj.getHash("HEX");
         var shaObj1 = new jsSHA("SHA-256", "TEXT");
         shaObj1.update(hashPass+salt);   
         var hashSalt = shaObj1.getHash("HEX");
         $('#password-input').val(hashSalt);
     }); 
     </script>
    
  </body>
</html>