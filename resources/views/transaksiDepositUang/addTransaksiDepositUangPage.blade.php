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
    <form action="{{ url('/konfirmasiDepositUang') }}" method="get" enctype="multipart/form-data" class="ml-2 mr-2">
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

                @endif

            </select>
            <div class="form-group mb-3>
                <label class="font-weightbold">Nominal Deposit</label>
                <input type="numeric"
                    class="form-control @error('EMAIL_MEMBER') is-invalid @enderror"
                    name="JUMLAH_DEPOSIT_UANG" placeholder="Rp.">
            <div class="invalid-feedback">Input Invalid</div>    
                </div>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">Pembayaran</button></div>
            </div>
        </div>

    </form>
    </div>
    <!-- AKHIR FORM -->
@endsection