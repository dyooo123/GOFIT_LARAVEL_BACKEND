@extends('dashboard')
@section('main')
<!-- START FORM -->
<form action='{{ url('/createJadwal') }}' method='post'>

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
        <h1 class="text-dark mt-2 mb-3">TAMBAH JADWAL</h1>        

        <div class="mb-3 row">
            <label for="NAMA_KELAS" class="col-sm-2 col-form-label">KELAS</label>
            <div class="col-sm-10">
                <select type="text" class="form-control" name='ID_KELAS'>
                <option value="" hidden>Pilih Kelas</option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->ID_KELAS }}">{{ $item->NAMA_KELAS }}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TANGGAL_JADWALUMUM" class="col-sm-2 col-form-label">Tanggal Jadwal</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name='TANGGAL_JADWAL_UMUM' id="TANGGAL_JADWAL_UMUM" placeholder="Masukkan Waktu">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="NAMA_INSTRUKTUR" class="col-sm-2 col-form-label">INSTRUKTUR</label>
            <div class="col-sm-10">
                <select type="text" class="form-control" name='ID_INSTRUKTUR'>
                <option value="" hidden>Pilih Instruktur</option>
                @foreach ($instruktur as $item)
                <option value="{{ $item->ID_INSTRUKTUR }}">{{ $item->NAMA_INSTRUKTUR }}</option>
                @endforeach  s
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="HARI_JADWAL_UMUM" class="col-sm-2 col-form-label">HARI</label>
            <div class="col-sm-10">
                <select type="text" class="form-control" name='HARI_JADWAL_UMUM' id="HARI_JADWAL_UMUM ">
                <option value="" hidden>Pilih Hari</option>
                <option value="" hidden>Select Day</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="SESI_JADWAL_UMUM" class="col-sm-2 col-form-label">SESI JADWAL/WAKTU</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='SESI_JADWAL_UMUM' id="SESI_JADWAL_UMUM" placeholder="Masukkan Waktu">
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