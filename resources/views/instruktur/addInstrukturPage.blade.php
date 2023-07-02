@extends('dashboard')
@section('main')

<!-- START FORM -->
<form action='{{ url('/createInstruktur') }}' method='post'>
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
        <h1 class="text-dark mt-2 mb-3">TAMBAH DATA INSTRUKTUR</h1>        

        <div class="mb-3 row">
            <label for="NAMA_INSTRUKTUR" class="col-sm-2 col-form-label">NAMA INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='NAMA_INSTRUKTUR' id="NAMA_INSTRUKTUR" placeholder="Masukkan Nama Instruktur">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="ALAMAT_INSTRUKTUR" class="col-sm-2 col-form-label">ALAMAT INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='ALAMAT_INSTRUKTUR' id="ALAMAT_INSTRUKTUR" placeholder="Masukkan Alamat Instruktur">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TELEPON_INSTRUKTUR" class="col-sm-2 col-form-label">TELEPON INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='TELEPON_INSTRUKTUR' id="TELEPON INSTRUKTUR" placeholder="Masukkan Telepon Instruktur">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="UMUR_INSTRUKTUR" class="col-sm-2 col-form-label">UMUR INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='UMUR_INSTRUKTUR' id="UMUR_INSTRUKTUR" placeholder="Masukkan Umur Instruktur">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="JENIS_KELAMIN_INSTRUKTUR" class="col-sm-2 col-form-label">JENIS KELAMIN INSTRUKTUR</label>
            <div class="col-sm-10">
                <select type="text" class="form-control" name='JENIS_KELAMIN_INSTRUKTUR' id="JENIS_KELAMIN_INSTRUKTUR" placeholder="Masukkan Jenis Kelamin Instruktur">
                <option value="" selected disabled>Pilih Jenis Kelamin</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TANGGAL_LAHIR_INSTRUKTUR" class="col-sm-2 col-form-label">TANGGAL LAHIR INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name='TANGGAL_LAHIR_INSTRUKTUR' id="TANGGAL_LAHIR_INSTRUKTUR" placeholder="Masukkan Tanggal Lahir Instruktur">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">EMAIL INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name='EMAIL_INSTRUKTUR' id="EMAIL_INSTRUKTUR" placeholder="contoh@gmail.com">
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