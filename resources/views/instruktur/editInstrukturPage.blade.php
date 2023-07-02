@extends('dashboard')
@section('main')

<!-- START FORM -->
<form action='{{ url('/editInstrukturPage/'.$instruktur->ID_INSTRUKTUR) }}' method='post'>
    @csrf
    @method('PUT')
    <div class="my-3 p-3 mx-3 mt-4 bg-body rounded shadow-sm">
        <h1 class="text-dark mt-2 mb-3">EDIT DATA INSTRUKTUR</h1>        

        <div class="mb-3 row">
            <label for="NAMA_INSTRUKTUR" class="col-sm-2 col-form-label">NAMA INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='NAMA_INSTRUKTUR' id="NAMA_INSTRUKTUR" value="{{ $instruktur->NAMA_INSTRUKTUR }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="ALAMAT_INSTRUKTUR" class="col-sm-2 col-form-label">ALAMAT INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='ALAMAT_INSTRUKTUR' id="ALAMAT_INSTRUKTUR"  value="{{ $instruktur->NAMA_INSTRUKTUR }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TELEPON_INSTRUKTUR" class="col-sm-2 col-form-label">TELEPON INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='TELEPON_INSTRUKTUR' id="TELEPON INSTRUKTUR"  value="{{ $instruktur->NAMA_INSTRUKTUR }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="UMUR_INSTRUKTUR" class="col-sm-2 col-form-label">UMUR INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='UMUR_INSTRUKTUR' id="UMUR_INSTRUKTUR"  value="{{ $instruktur->UMUR_INSTRUKTUR }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="JENIS_KELAMIN_INSTRUKTUR" class="col-sm-2 col-form-label">JENIS KELAMIN INSTRUKTUR</label>
            <div class="col-sm-10">
                <select type="text" class="form-control" name='JENIS_KELAMIN_INSTRUKTUR' id="JENIS_KELAMIN_INSTRUKTUR">
                    @if ($instruktur->JENIS_KELAMIN_INSTRUKTUR == 'Laki-Laki')
                    <option value="Laki-Laki" selected>Laki-Laki</option>
                @else
                    <option value="Laki-Laki">Laki-Laki</option>
                @endif
                @if ($instruktur->JENIS_KELAMIN_INSTRUKTUR == 'Perempuan')
                <option value="Perempuan" selected>Perempuan</option>
            @else
                <option value="Perempuan">Perempuan</option>
            @endif
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="TANGGAL_LAHIR_INSTRUKTUR" class="col-sm-2 col-form-label">TANGGAL LAHIR INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name='TANGGAL_LAHIR_INSTRUKTUR' id="TANGGAL_LAHIR_INSTRUKTUR"  value="{{ $instruktur->TANGGAL_LAHIR_INSTRUKTUR }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">EMAIL INSTRUKTUR</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='EMAIL_INSTRUKTUR' id="EMAIL_INSTRUKTUR"  value="{{ $instruktur->EMAIL_INSTRUKTUR }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">PASSWORD</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='password' id="password"  value="{{ $instruktur->password}}">
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