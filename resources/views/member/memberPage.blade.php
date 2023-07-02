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
            <h1 class="text-dark mt-2 mb-3">DATA MEMBER</h1>     
                <!-- FORM PENCARIAN -->
                <div class="pb-3">
                  <form class="d-flex" action="{{ url('/searchMember') }}" method="get">
                      <input class="form-control me-1" type="search" placeholder="Masukkan nama member" aria-label="Search" name="search">
                      <button class="btn btn-secondary" type="submit">Cari</button>
                  </form>
                </div>
                
                <!-- TOMBOL TAMBAH DATA -->
                <div class="pb-3">
                  <a href='{{ url('/addMemberPage') }}' class="btn btn-success">+ Tambah Member</a>
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
                            <th class="col-md-1">ID Member</th>
                            <th class="col-md-3">Nama Member</th>
                            <th class="col-md-4">Alamat Member</th>
                            <th class="col-md-2">Umur Member</th>
                            <th class="col-md-2">Tanggal Lahir Member</th>
                            <th class="col-md-2">Telepon Member</th>
                            <th class="col-md-2">Email Member</th>
                            <th class="col-md-2">Masa Aktivasi Member</th>
                            <th class="col-md-2">Sisa Deposit Member</th>
                            <th class="col-md-2">Aksi</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $data->firstItem() ?>

                        @foreach ($data as $item)
                            
                        <tr>
                            <td>{{ $i }}</td>
                            <td class='text-nowrap'>{{ $item->ID_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->NAMA_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->ALAMAT_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->UMUR_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->TANGGAL_LAHIR_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->TELEPON_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->EMAIL_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->MASA_AKTIVASI }}</td>
                            <td class='text-nowrap'>{{ $item->SISA_DEPOSIT_MEMBER }}</td>

                            <td class="text-nowrap d-flex gap-2 align-items-center">
                                <a href='{{ url('/editMember/'.$item->ID_MEMBER) }}' class="btn btn-warning btn-sm d-inline">Edit</a>

                                <form class='d-inline' action="{{ url('deleteMember/'.$item->ID_MEMBER) }}"
                                method="post"> 
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline">Del</button>
                                </form>
                                <form action="{{ url('/resetPasswordMember/'.$item->ID_MEMBER) }}">
                                    <button type="submit" class="btn btn-primary d-inline">Reset Password</button>
                                </form>
                                <a href="{{ url('/cetakMemberCard/'.$item->ID_MEMBER) }}" class="btn btn-success mt-1 d-inline">Cetak Member</a>
                            </td>
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