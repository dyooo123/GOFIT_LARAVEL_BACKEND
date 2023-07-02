@extends('dashboard')

@section('main')
    <section>
        {{-- <h2 class="text-center">RECEIPT</h2> --}}
        <div class="card my-3 p-3 bg-body rounded shadow-sm mx-auto"style="width: 35rem;">
            <div class="card-content">
                <h3>GoFit</h3>
                <p>Jl. Centralpark No.101 Yogyakarta</p>

                <hr style="width: 100%; color: black; height: 1px; background-color:black;" />
                <h3>STRUK PRESENSI KELAS</h3>
                <p>No Struk: {{ $presensi->KODE_BOOKING }} </p>
                @if ($presensi->WAKTU_PRESENSI_KELAS != null)
                    <p>Tanggal :
                        {{ \Carbon\Carbon::parse($presensi->WAKTU_PRESENSI_KELAS)->format('d/m/Y H:i:s') }}
                    </p>
                @else
                    <p>Tanggal : Belum dikonfirmasi </p>
                @endif

                <hr style="width: 100%; color: black; height: 1px; background-color:black;" />
                <p>Member : {{ $presensi->ID_MEMBER }} / {{ $presensi->NAMA_MEMBER }}</p>
                <p>Kelas : {{ $presensi->NAMA_KELAS }}</p>
                <p>Instruktur : {{ $presensi->NAMA_INSTRUKTUR }}</p>
                @if ($presensi->TARIF_KELAS != 1)
                    <p>Tarif : Rp.{{ $presensi->TARIF_KELAS }}</p>
                    <p>Sisa deposit : Rp.{{ $presensi->SISA_DEPOSIT_MEMBER }}</p>
                @else
                    <p>Sisa Deposit: {{ $presensi2->SISA_DEPOSIT_KELAS }}1</p>
                    <p>Berlaku Sampai: {{ \Carbon\Carbon::parse($presensi2->MASA_BERLAKU)->format('d/m/Y H:i:s') }}</p>
                @endif


            </div>
        </div>
    </section>
    <script type="text/javascript">
        window.print();
    </script>
@endsection