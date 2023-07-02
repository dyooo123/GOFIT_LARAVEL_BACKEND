@extends('dashboard')

@section('main')
<div class="card">
    <div class="card-header">
    <div class="card-body">
         <!-- NOTIFIKASI -->
         @if(session('success'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
        @endif
        <h1>Welcome to GO-FIT, {{ $pegawai->NAMA_PEGAWAI }} <p class="far fa-grin-beam"></p></h1> 
        <img src="https://www.itl.cat/pngfile/big/299-2992038_photo-wallpaper-bench-rod-fitness-gym-gym-wall.jpg"
          alt="Login image" class="w-100 vh-80" style="object-fit: cover; background-size: cover;">
    </div>
    {{-- <h1>aaaa</h1> --}}
</div>

@endsection