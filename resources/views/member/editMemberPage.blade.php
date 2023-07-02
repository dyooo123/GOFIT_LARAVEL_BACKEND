@extends('dashboard')
@section('main')

<!-- START FORM -->
<form action='{{ url('/editMemberPage/'.$member->ID_MEMBER) }}' method='post'>
    @csrf
    @method('PUT')
    <div class="my-3 p-3 mx-3 mt-4bg-body rounded shadow-sm mx-3">
        <h1 class="text-dark mt-2 mb-3">EDIT DATA MEMBER</h1>        
        <div class="mb-3 row">
            <label for="NAMA_MEMBER" class="col-sm-2 col-form-label">NAMA MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='NAMA_MEMBER' id="NAMA_MEMBER" value="{{ $member->NAMA_MEMBER }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="ALAMAT_MEMBER" class="col-sm-2 col-form-label">ALAMAT MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='ALAMAT_MEMBER' id="ALAMAT_MEMBER" value="{{ $member->ALAMAT_MEMBER }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="UMUR_MEMBER" class="col-sm-2 col-form-label">UMUR MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='UMUR_MEMBER' id="UMUR_MEMBER" value="{{ $member->UMUR_MEMBER }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TANGGAL_LAHIR_MEMBER" class="col-sm-2 col-form-label">TANGGAL LAHIR MEMBER  </label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name='TANGGAL_LAHIR_MEMBER' id="TANGGAL_LAHIR_MEMBER" value="{{ $member->TANGGAL_LAHIR_MEMBER }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TELEPON_MEMBER" class="col-sm-2 col-form-label">TELEPON MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='TELEPON_MEMBER' id="TELEPON MEMBER" value="{{ $member->TELEPON_MEMBER }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">EMAIL MEMBER</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='EMAIL_MEMBER' id="EMAIL_MEMBER" value="{{ $member->EMAIL_MEMBER }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">PASSWORD</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='password' id="password" value="{{ $member->password }}">
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