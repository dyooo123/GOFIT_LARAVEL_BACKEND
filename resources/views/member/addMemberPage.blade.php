@extends('dashboard')
@section('main')

<!-- START FORM -->
<form action='{{ url('/createMember') }}' method='post'>
     <!-- NOTIFIKASI -->
     @if(session('success'))
     <div class="alert alert-success alert-dismissible fade show" role="alert">
         {{ session('success') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
     @endif
     @if(session('error'))
     <div class="alert alert-danger alert-dismissible fade show" role="alert">
         {{ session('error') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
     @endif
     <!-- AKHIR NOTIFIKASI -->
    @csrf
    <div class="my-3 p-3 mx-3 mt-4 bg-body rounded shadow-sm">
        <h1 class="text-dark mt-2 mb-3">TAMBAH DATA MEMBER</h1>        

        <div class="mb-3 row">
            <label for="NAMA_MEMBER" class="col-sm-2 col-form-label">NAMA MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='NAMA_MEMBER' id="NAMA_MEMBER"  placeholder="Masukkan Nama Member">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="ALAMAT_MEMBER" class="col-sm-2 col-form-label">ALAMAT MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='ALAMAT_MEMBER' id="ALAMAT_MEMBER"  placeholder="Masukkan Alamat Member">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="UMUR_MEMBER" class="col-sm-2 col-form-label">UMUR MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='UMUR_MEMBER' id="UMUR_MEMBER"  placeholder="Masukkan Umur Member">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TANGGAL_LAHIR_MEMBER" class="col-sm-2 col-form-label">TANGGAL LAHIR MEMBER</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name='TANGGAL_LAHIR_MEMBER' id="TANGGAL_LAHIR_MEMBER"  placeholder="Masukkan Tanggal Lahir Member">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TELEPON_MEMBER" class="col-sm-2 col-form-label">TELEPON MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='TELEPON_MEMBER' id="TELEPON MEMBER"  placeholder="Masukkan Telepon Member">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="EMAIL_MEMBER" class="col-sm-2 col-form-label">EMAIL MEMBER</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name='EMAIL_MEMBER' id="EMAIL_MEMBER"  placeholder="example@gmail.com">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">PASSWORD</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='password' id="password" placeholder="*****">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jurusan" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
        </div>
      </form>
    </div>
    <!-- AKHIR FORM -->
@endsection