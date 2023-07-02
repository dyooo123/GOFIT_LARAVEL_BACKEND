@extends('dashboard')
@section('main')
<!-- START FORM -->
<form action='{{ url('/editJadwalPage/'.$jadwal->ID_JADWAL_REGULER) }}' method='post'>
    <!-- NOTIFIKASI -->

    {{-- @if(session('success'))
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
    @endif --}}
    <!-- AKHIR NOTIFIKASI -->
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
    @method('PUT')
    <div class="my-3 p-3 mx-3 mt-4 bg-body rounded shadow-sm">
        <h1 class="text-dark mt-2 mb-3">EDIT JADWAL</h1>        

        <div class="mb-3 row">
            <label for="NAMA_KELAS" class="col-sm-2 col-form-label">KELAS</label>
            <div class="col-sm-10">
                <select type="text" class="form-control" name='ID_KELAS'>
                <option value="" hidden>Pilih Kelas</option>
                @foreach ($kelas as $item)
                <option value="{{ $item->ID_KELAS }}"
                    {{ $jadwal->ID_KELAS == $item->ID_KELAS ? 'selected' : '' }}>
                    {{ $item->NAMA_KELAS }}</option>                
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
                <option value="{{ $item->ID_INSTRUKTUR }}"
                    {{ $jadwal->ID_INSTRUKTUR == $item->ID_INSTRUKTUR ? 'selected' : '' }}>
                    {{ $item->NAMA_INSTRUKTUR }}</option>               
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="HARI_JADWAL_UMUM" class="col-sm-2 col-form-label">HARI</label>
            <div class="col-sm-10">
                <select type="text" class="form-control" name='HARI_JADWAL_UMUM' id="HARI_JADWAL_UMUM ">
                    <option value="" hidden>Pilih Hari</option>
                    @if ($jadwal->HARI_JADWAL_UMUM == 'Senin')
                        <option value="Senin" selected>Senin</option>
                    @else
                        <option value="Senin">Senin</option>
                    @endif

                    @if ($jadwal->HARI_JADWAL_UMUM == 'Selasa')
                        <option value="Selasa" selected>Selasa</option>
                    @else
                        <option value="Selasa">Selasa</option>
                    @endif

                    @if ($jadwal->HARI_JADWAL_UMUM == 'Rabu')
                        <option value="Rabu" selected>Rabu</option>
                    @else
                        <option value="Rabu">Rabu</option>
                    @endif

                    @if ($jadwal->HARI_JADWAL_UMUM == 'Kamis')
                        <option value="Kamis" selected>Kamis</option>
                    @else
                        <option value="Kamis">Kamis</option>
                    @endif

                    @if ($jadwal->HARI_JADWAL_UMUM == 'Jumat')
                        <option value="Jumat" selected>Jumat</option>
                    @else
                        <option value="Jumat">Jumat</option>
                    @endif

                    @if ($jadwal->HARI_JADWAL_UMUM == 'Sabtu')
                        <option value="Sabtu" selected>Sabtu</option>
                    @else
                        <option value="Sabtu">Sabtu</option>
                    @endif

                    @if ($jadwal->HARI_JADWAL_UMUM == 'Minggu')
                        <option value="Minggu" selected>Minggu</option>
                    @else
                        <option value="Minggu">Minggu</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="SESI_JADWAL_UMUM" class="col-sm-2 col-form-label">SESI JADWAL/WAKTU</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='SESI_JADWAL_UMUM' id="SESI_JADWAL_UMUM" value="{{ $jadwal->SESI_JADWAL_UMUM }}">
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