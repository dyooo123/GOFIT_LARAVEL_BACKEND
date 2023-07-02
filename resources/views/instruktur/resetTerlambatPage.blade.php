@extends('dashboard')
@section('main')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Instruktur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    <main class="container">  
        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1 class="text-dark mt-2 mb-3">DATA INSTRUKTUR</h1>        
                  <!-- TOMBOL TAMBAH DATA -->
                <div class="pb-3">
                    <a href='{{ url('/resetTerlambatInstruktur') }}' class="btn btn-success">Reset Terlambat Instruktur</a>
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
                            <th class="col-md-1">ID</th>
                            <th class="col-md-3 text-nowrap">Nama Instruktur</th>
                            <th class="col-md-4 text-nowrap">Alamat Instruktur</th>
                            <th class="col-md-2 text-nowrap">Telepon Instruktur</th>
                            <th class="col-md-2 text-nowrap">Umur Instruktur</th>
                            <th class="col-md-2 text-nowrap">Jenis Kelamin Instruktur</th>
                            <th class="col-md-2 text-nowrap">Tanggal Lahir Instruktur</th>
                            <th class="col-md-2 text-nowrap">Email Instruktur</th>
                            <th class="col-md-2 text-nowrap">Jumlah Terlambat</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $data->firstItem() ?>

                        @foreach ($data as $item)
                            
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $item->ID_INSTRUKTUR}}</td>
                            <td>{{ $item->NAMA_INSTRUKTUR}}</td>
                            <td>{{ $item->ALAMAT_INSTRUKTUR}}</td>
                            <td>{{ $item->TELEPON_INSTRUKTUR}}</td>
                            <td>{{ $item->UMUR_INSTRUKTUR}}</td>
                            <td>{{ $item->JENIS_KELAMIN_INSTRUKTUR}}</td>
                            <td>{{ $item->TANGGAL_LAHIR_INSTRUKTUR}}</td>
                            <td>{{ $item->EMAIL_INSTRUKTUR}}</td>
                            @if ($item->JUMLAH_TERLAMBAT != null || $item->JUMLAH_TERLAMBAT != 0)
                            <td class="col-md-5">{{ $item->JUMLAH_TERLAMBAT }}</td>
                            @else
                                <td class="col-md-5">0</td>
                            @endif
                        </tr>

                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
               
          </div>
          <!-- AKHIR DATA -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
@endsection