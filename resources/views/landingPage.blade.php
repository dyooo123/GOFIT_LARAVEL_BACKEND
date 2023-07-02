<!DOCTYPE html>
<html lang="en" >
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOGIN PAGE</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,
    700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    </head>
<section class="vh-100" >
  <div class="container-fluid" >
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
    </div>
@endif
<!-- AKHIR NOTIFIKASI -->
    <div class="row">
      <div class="col-sm-6 text-black">
       

        <div class="px-5 ms-xl-4">
          <i class="fas fa-heartbeat fa-2x me-3 pt-5 mt-xl-4" style="color: #6C9BCF;"></i>
          <span class="h1 fw-bold mb-0">STUDIO GOFIT</span>
        </div>

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

          <form method = "POST" action = "{{ url('/login') }}" style="width: 23rem;"> 

            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login</h3>

            @csrf
            <div class="form-outline mb-4">
              <label class="form-label" for="EMAIL_PEGAWAI">Email address</label>
              <input type="email" id="EMAIL_PEGAWAI" class="form-control form-control-lg" name="EMAIL_PEGAWAI"/>
            </div>

            <div class="form-outline mb-4">
              <label class="form-label" for="password" >Password</label>
              <input type="password" id="password" class="form-control form-control-lg" name="password"/>
            </div>
            
            <div class="pt-1 mb-4" style="color: #B8E7E1">
              <button type="submit" class="btn btn-info btn-lg btn-block green" >Login</button>
            </div>
            <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
            <p>Don't have an account? <a href="#!" class="link-info">Register here</a></p>
          </form>
          
        </div>
      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="https://i.etsystatic.com/26181833/r/il/98232f/3932224528/il_fullxfull.3932224528_f9fq.jpg"
          alt="Login image" class="w-100 vh-100" style="object-fit: cover; ">
      </div>
    </div>
  <style>
    .bg-image-vertical {
    position: relative;
    overflow: hidden;
    background-repeat: no-repeat;
    background-position: right center;
    background-size: cover;
    height: 100vh!important;
    }
    
    @media (min-width: 1025px) {
    .h-custom-2 {
    height: calc(100vh - 110px);
    }
    }
  </style>

</section>
</div>

</html>