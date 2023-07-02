@extends('dashboard')

@section('main')
    <section>
        {{-- <h2 class="text-center">RECEIPT</h2> --}}
        <div class="card my-3 p-3 bg-body rounded shadow-sm mx-auto"style="width: 35rem;">
            <div class="card-content">
                <h3>GoFit</h3>
                <p>Jl. Centralpark No.101 Yogyakarta</p>

                <div>
                    <p>No Struk : {{ $presensi->KODE_BOOKING_GYM }}</p>
                    @if($presensi->WAKTU_PRESENSI_GYM === null)
                    Belum Dikonfirmasi
                    @else
                    <p>Tanggal Aktivasi : {{ \Carbon\Carbon::parse($presensi->WAKTU_PRESENSI_GYM)->format('d/m/Y H:i:s') }}</p>
                    @endif
                </div>
            </div>
            <p> <b> Member </b> : {{ $presensi->ID_MEMBER }} /
                {{ $presensi->member->NAMA_MEMBER }} </p>
            <p> Slot Waktu : {{ $presensi->SLOT_WAKTU_GYM }}</p>
        </div>
        </div>
    </section>
    <script type="text/javascript">
        window.print();
    </script>
@endsection