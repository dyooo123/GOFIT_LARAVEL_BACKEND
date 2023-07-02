@extends('dashboard')
@section('main')
<!-- START FORM -->
<form action='{{ url('/editJadwalHarianPage/'.$jadwalHarian->TANGGAL_JADWAL_HARIAN) }}' method='post'>
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
    @csrf
    @method('PUT')
    <div class="my-3 p-3 mx-3 mt-4 bg-body rounded shadow-sm">
        <h1 class="text-dark mt-2 mb-3">EDIT JADWAL HARIAN</h1>        


        <div class="mb-3 row">
            <label for="NAMA_INSTRUKTUR" class="col-sm-2 col-form-label">INSTRUKTUR</label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="ID_INSTRUKTUR">
                    <option value="" hidden>Pilih Instructor</option>
                    @foreach ($instruktur as $item)
                        <option value="{{ $item->ID_INSTRUKTUR }}"
                            {{ $jadwalHarian->ID_INSTRUKTUR == $item->ID_INSTRUKTUR ? 'selected' : '' }}>
                            {{ $item->NAMA_INSTRUKTUR }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="STATUS_JADWAL_HARIAN" class="col-sm-2 col-form-label">KETERANGAN</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='STATUS_JADWAL_HARIAN' id="STATUS_JADWAL_HARIAN" value="{{ $jadwalHarian->STATUS_JADWAL_HARIAN }}">
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