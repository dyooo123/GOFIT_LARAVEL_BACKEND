@extends('dashboard')
@section('main')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    <main class="container">     
        <!-- START DATA -->
        <div class="my-3 p-2 bg-body rounded shadow-sm">
            <h1 class="text-dark mt-2 mb-3">Transaksi Deposit Kelas</h1>     
                
                <!-- TOMBOL TAMBAH DATA -->
                <div class="pb-3">
                  <a href='{{ url('/createTransaksiDepositKelas') }}' class="btn btn-success">Deposit Kelas</a>
                </div>

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
          
                <table class="table table-striped table-sm table-responsive">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-1">ID Aktivasi</th>
                            <th class="col-md-1">ID Member</th>
                            <th class="col-md-3">Nama Member</th>
                            <th class="col-md-4">Nama Promo</th>
                            <th class="col-md-4">Nama Kasir</th>
                            <th class="col-md-4">Nama Kelas</th>
                            <th class="col-md-2">Jumlah Deposit Kelas</th>
                            <th class="col-md-2">Tanggal Deposit Kelas</th>
                            <th class="col-md-2">Bonus Deposit Kelas</th>
                            <th class="col-md-2">Total Deposit Kelas</th>
                            <th class="col-md-2">Jumlah Pembayaran</th>
                            <th class="col-md-2">Aksi</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $transaksiDepositKelas->firstItem() ?>

                        @foreach ($transaksiDepositKelas as $item)
                            
                        <tr>
                            <td>{{ $i }}</td>
                            <td class='text-nowrap'>{{ $item->ID_TRANSAKSI_DEPOSIT_KELAS }}</td>
                            <td class='text-nowrap'>{{ $item->ID_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->member->NAMA_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->promo->NAMA_PROMO }}</td>
                            <td class='text-nowrap'>{{ $item->pegawai->NAMA_PEGAWAI }}</td>
                            <td class='text-nowrap'>{{ $item->kelas->NAMA_KELAS}}</td>
                            <td class='text-nowrap'>{{ $item->JUMLAH_DEPOSIT_KELAS }}</td>
                            <td class='text-nowrap'>{{ $item->TANGGAL_DEPOSIT_KELAS }}</td>
                            <td class='text-nowrap'>{{ $item->BONUS_DEPOSIT_KELAS }}</td>
                            <td class='text-nowrap'>{{ $item->TOTAL_DEPOSIT_KELAS }}</td>
                            <td class='text-nowrap'>{{ $item->JUMLAH_PEMBAYARAN }}</td>

                            <td class="text-nowrap d-flex gap-2 align-items-center">
                                <a href="{{ url('/transaksiDepositKelasStruk/'.$item->ID_TRANSAKSI_DEPOSIT_KELAS ) }}" class="btn btn-success mt-1 d-inline">Cetak Struk Aktivasi</a>
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
                {{ $transaksiDepositKelas->links() }}
               
          </div>
          <!-- AKHIR transaksiDepositKelas -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
@endsection