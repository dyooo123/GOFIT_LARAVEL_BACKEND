@extends('dashboard')
@section('main')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Izin Instruktur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    <main class="container">  
        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1 class="text-dark mt-2 mb-3">DATA IZIN INSTRUKTUR</h1>        
                 <!-- NOTIFIKASI -->
                 @if(session('success'))
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ session('success') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- AKHIR NOTIFIKASI -->
          
                <table class="table table-striped table-sm table-responsive mb-3">
                    <thead>
                        <tr>
                            <th class="col-md-1">ID IZIN</th>
                            <th class="col-md-3 text-nowrap">Nama Instruktur</th>
                            <th class="col-md-4 text-nowrap">Tanggal Izin Instruktur</th>
                            <th class="col-md-2 text-nowrap">Tanggal Mengajukan Izin</th>
                            <th class="col-md-2 text-nowrap">Tanggal Konfirmasi Izin</th>
                            <th class="col-md-2 text-nowrap">Keterangan Izin</th>
                            <th class="col-md-2 text-nowrap">Status Izin</th>
                            <th class="col-md-2">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($izin as $item)
                            
                        <tr>
                            <td>{{ $item->ID_INSTRUKTUR}}</td>
                            <td>{{ $item->instruktur->NAMA_INSTRUKTUR}}</td>
                            <td>{{ $item->TANGGAL_IZIN_INSTRUKTUR}}</td>
                            <td>{{ $item->TANGGAL_MENGAJUKAN_IZIN}}</td>
                            <td>{{ $item->TANGGAL_KONFIRMASI_IZIN}}</td>
                            <td>{{ $item->KETERANGAN_IZIN}}</td>
                            <td>{{ $item->STATUS_IZIN}}</td>
                            <td class="text-nowrap">
                                <a href='{{ url('/konfirmasiIzinInstruktur/'.$item->ID_IZIN_INSTRUKTUR) }}' class="btn btn-success btn-sm d-inline mb-3">Konfirmasi Izin</a>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
               
          </div>
          <!-- AKHIR DATA -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
@endsection