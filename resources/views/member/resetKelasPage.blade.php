@extends('dashboard')
@section('main')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    <main class="container">     
        <!-- START DATA -->
        <div class="my-3 p-2 bg-body rounded shadow-sm">
            <h1 class="text-dark mt-2 mb-3">RESET KELAS</h1>  
            <!-- TOMBOL TAMBAH DATA -->
            <div class="pb-3">
                <a href="{{ url('/resetKelasTombol') }}" class="btn btn-danger mt-1 d-inline">Reset Kelas</a>   
            </div>
                <!-- FORM PENCARIAN -->
                <div class="pb-3">
                  <form class="d-flex" action="{{ url('/searchMember') }}" method="get">
                      <input class="form-control me-1" type="search" placeholder="Masukkan nama member" aria-label="Search" name="search">
                      <button class="btn btn-secondary" type="submit">Cari</button>
                  </form>
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
                            <th class="col-md-1">ID Deposit Kelas</th>
                            <th class="col-md-1">Nama Member</th>
                            <th class="col-md-3">Nama Kelas</th>
                            <th class="col-md-4">Sisa Deposit</th>
                            <th class="col-md-2">Masa Berlaku</th>
             
                         

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $member->firstItem() ?>

                        @foreach ($member as $item)
                            
                        <tr>
                            <td>{{ $i }}</td>
                            <td class='text-nowrap'>{{ $item->ID_DEPOSIT_KELAS }}</td>
                            <td class='text-nowrap'>{{ $item->member->NAMA_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->kelas->NAMA_KELAS }}</td>
                            <td class='text-nowrap'>{{ $item->SISA_DEPOSIT }}</td>
                            <td class='text-nowrap'>{{ $item->MASA_BERLAKU }}</td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
                {{ $member->links() }}
               
          </div>
          <!-- AKHIR DATA -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
@endsection