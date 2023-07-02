@extends('dashboard')
@section('main')

<!-- START FORM -->
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
    <form action="{{ url('/konfirmasiTransaksiAktivasi') }}" method="get" enctype="multipart/form-data" class="ml-2 mr-2">
        @csrf
        <div class=" p-3 mt-4 bg-body rounded shadow-sm">
        <div class="form-group">
            <label>Member</label>
            <select class="form-control mb-3" aria-label="select member" name="ID_MEMBER">
                <option value="" hidden>Pilih Member</option>
                @if ($member->first() != null)
                    @foreach ($member as $item_member)
                        <option value="{{ $item_member->ID_MEMBER }}">
                            {{ $item_member->NAMA_MEMBER }}</option>
                    @endforeach
                @else
                    <option value=""disabled>Semua member sudah di Aktivasi</option>
                @endif

            </select>
            <label class="font-weight-bold mb-2">TANGGAL AKTIVASI</label>
            <input type='text' class="form-control mb-3"name="TANGGAL_TRANSAKSI_AKTIVASI"
                placeholder="Input date of birth member" autocomplete="off"
                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" disabled />

            <label class="font-weight-bold mb-2">TANGGAL EXPIRED</label>
            <input type='text' class="form-control mb-3"name="TANGGAL_EXPIRED" placeholder="Input date of birth member"
                autocomplete="off" value="{{ Carbon\Carbon::now()->addYears(1)->format('Y-m-d') }}" disabled />

                    

                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
            </div>
        </div>

    </form>
    </div>
    <!-- AKHIR FORM -->
@endsection