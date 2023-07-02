@extends('dashboard')

@section('main')
    <div class=" card my-5 p-3 bg-body rounded shadow-lg w-50 mx-auto no-print">
        <h3 class="card-title text-center">FILTER LAPORAN KINERJA INSTRUKTUR</h3>
        <hr style="width: 100%; color: black; height: 1px; background-color:black;" />
        <form action="{{ url('laporanKinerjaInstrukturProcess') }}" method="get" enctype="multipart/form-data">
            @csrf
            <div class="form-row mb-2">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold mb-2">Tahun</label>
                    <select class="form-control mb-3" aria-label="Default select example" name="year_filter">
                        <option value="" hidden>Pilih Tahun</option>
                        @php
                            $year = \Carbon\Carbon::now()->addYears(1);
                        @endphp
                        @for ($i = 0; $i < 3; $i++)
                            @php
                                $year->subYears(1);
                            @endphp
                            <option value={{ $year->format('Y') }}>
                                {{ $year->format('Y') }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold mb-2">Bulan</label>
                    <select class="form-control m   b-3" aria-label="Default select example" name="month_filter">
                        <option value="" hidden>Pilih Bulan</option>
                        @php
                            $month = \Carbon\Carbon::create();
                        @endphp
                        @for ($i = 0; $i < 12; $i++)
                            <option value={{ $month->format('m') }}>
                                {{ $month->format('F') }}</option>
                            @php
                                $month->addMonth(1);
                            @endphp
                        @endfor
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label class="font-weight-bold mb-2">Manajer Operasional</label>
                    <input type='text' class="form-control mb-3"name="ID_PEGAWAI"
                        placeholder="Input date of birth member" autocomplete="off"
                        value="P{{ $pegawai->ID_PEGAWAI }} / {{ $pegawai->NAMA_PEGAWAI }}" disabled />
                </div>



                <button type="submit" class="btn btn-primary btn-block mb-4">Search</button>
            </div>
        </form>
    </div>
    @if (!Session::get('print'))
        {{-- <div class="alert alert-danger">
            Data report not found. Please input month and year!
        </div> --}}
    @else
        @php
            $data_instructor = Session::get('data_instructor');
        @endphp
        <div class="card">
            <div class="pb-3 ps-3 pe-3 pt-3 d-flex flex-row-reverse justify-content-between"style="background-color:#2d3c45; color:rgb(255, 255, 255)">
                <button type="button" class="btn bg-success text-black mt-2 no-print" onclick="window.print()"> <i
                        class="fas fa-solid fa-print fa-fw me-3"></i>Cetak Laporan</button>
                <h3 class="card-title">Laporan Kinerja Instruktur {{ Session::get('year') }}</h3>
            </div>
        </div>

        <div class=" card my-1 p-3 bg-body rounded shadow-sm mt-3">

            <h3>GoFit</h3>
            <p>Jl. Centralpark No.10 Yogyakarta</p>
            <h3>LAPORAN KINERJA INSTRUKTUR BULANAN</h3>
            <div class="d-flex">
                <p>Bulan: {{ \Carbon\Carbon::now()->month(Session::get('month'))->translatedformat('F') }} </p>
                <p class="ms-3">Periode: {{ Session::get('year') }}</p>
            </div>

            <p>Tanggal cetak: {{ \Carbon\Carbon::now()->translatedformat('d M Y') }}</p>

            <hr style="width: 100%; color: black; height: 1px; background-color:black;" />

            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-2">Nama</th>
                        <th class="col-md-2">Jumlah Hadir</th>
                        <th class="col-md-2">Jumlah Libur</th>
                        <th class="col-md-2">Waktu Terlambat (detik)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_instructor as $item)
                        <tr>
                            <td>{{ $item->nama_instruktur }}</td>
                            <td>{{ $item->jumlah_hadir }}</td>
                            <td>{{ $item->jumlah_izin }}</td>
                            <td>{{ $item->akumulasi_terlambat }}</td>
                        </tr>
                    @empty
                        <div class="alert alert-danger">
                            Data report empty
                        </div>
                    @endforelse
                </tbody>
            </table>
            {{-- <div>
            {{ $members->links('pagination::bootstrap-5') }}
        </div> --}}
            {{-- </div>

        <div class="card mt-5">
            <div class="card-body mr-5">
                <canvas id="myChart" height="100px"></canvas>
            </div>
        </div> --}}
            {{-- <div class="card mt-5">
            <div class="card-body ms-5">
                <canvas id="myChart2" height="100px"></canvas>
            </div>
        </div> --}}
    @endif
@endsection