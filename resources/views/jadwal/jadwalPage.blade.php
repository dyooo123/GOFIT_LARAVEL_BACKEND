@extends('dashboard')
@section('main')


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    
     <!-- START DATA -->
     <div class="my-3 p-2 bg-body rounded shadow-sm">
      <h1 class="text-dark mt-2 mb-3">DATA JADWAL</h1>     
  
      
      <!-- TOMBOL TAMBAH DATA -->
      <div class="pb-3 ml-3">
        <a href='{{ url('/addJadwalPage') }}' class="btn btn-success">+ Tambah Jadwal</a>
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


    <main class="container">
        <!-- START DATA -->
        <div class="my-3 p-2 bg-body rounded shadow-sm">
              
            <div class="container">
                <table class="table table-bordered ">
                  <thead>
                    <tr>
                      <th class=" ">Hari</th>
                      <th colspan="12" class="text-center">Kegiatan</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>SENIN</th>
                      @foreach($jadwal as $item)
                        @if ($item->HARI_JADWAL_UMUM =='Senin')
                        <td class="active ">
                          <div>{{ $item->SESI_JADWAL_UMUM }}</div>
                          <div>{{ $item->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <a href='{{ url('/editJadwal/'.$item->ID_JADWAL_REGULER) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwal/'.$item->ID_JADWAL_REGULER) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                      <th>SELASA</th>
                      @foreach($jadwal as $item)
                        @if ($item->HARI_JADWAL_UMUM =='Selasa')
                        <td>
                          <div>{{ $item->SESI_JADWAL_UMUM }}</div>
                          <div>{{ $item->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <a href='{{ url('/editJadwal/'.$item->ID_JADWAL_REGULER) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwal/'.$item->ID_JADWAL_REGULER) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                      <th>RABU</th>
                      @foreach($jadwal as $item)
                        @if ($item->HARI_JADWAL_UMUM =='Rabu')
                        <td>
                          <div>{{ $item->SESI_JADWAL_UMUM }}</div>
                          <div>{{ $item->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <a href='{{ url('/editJadwal/'.$item->ID_JADWAL_REGULER) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwal/'.$item->ID_JADWAL_REGULER) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                      <th>KAMIS</th>
                      @foreach($jadwal as $item)
                      @if ($item->HARI_JADWAL_UMUM =='Kamis')
                      <td>
                        <div>{{ $item->SESI_JADWAL_UMUM }}</div>
                        <div>{{ $item->kelas->NAMA_KELAS }}</div>
                        <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                        <a href='{{ url('/editJadwal/'.$item->ID_JADWAL_REGULER) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                        <form class='d-inline' action="{{ url('/deleteJadwal/'.$item->ID_JADWAL_REGULER) }}"
                        method="post"> 
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                      </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <th>JUMAT</th>
                      @foreach($jadwal as $item)
                      @if ($item->HARI_JADWAL_UMUM =='Jumat')
                      <td>
                        <div>{{ $item->SESI_JADWAL_UMUM }}</div>
                        <div>{{ $item->kelas->NAMA_KELAS }}</div>
                        <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                        <a href='{{ url('/editJadwal/'.$item->ID_JADWAL_REGULER) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                        <form class='d-inline' action="{{ url('/deleteJadwal/'.$item->ID_JADWAL_REGULER) }}"
                        method="post"> 
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                      </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <th>SABTU</th>
                      @foreach($jadwal as $item)
                      @if ($item->HARI_JADWAL_UMUM =='Sabtu')
                      <td>
                        <div>{{ $item->SESI_JADWAL_UMUM }}</div>
                        <div>{{ $item->kelas->NAMA_KELAS }}</div>
                        <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                        <a href='{{ url('/editJadwal/'.$item->ID_JADWAL_REGULER) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                        <form class='d-inline' action="{{ url('/deleteJadwal/'.$item->ID_JADWAL_REGULER) }}"
                        method="post"> 
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                      </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <th>MINGGU</th>
                      @foreach($jadwal as $item)
                      @if ($item->HARI_JADWAL_UMUM =='Minggu')
                      <td>
                        <div>{{ $item->SESI_JADWAL_UMUM }}</div>
                        <div>{{ $item->kelas->NAMA_KELAS }}</div>
                        <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                        <a href='{{ url('/editJadwal/'.$item->ID_JADWAL_REGULER) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                        <form class='d-inline' action="{{ url('/deleteJadwal/'.$item->ID_JADWAL_REGULER) }}"
                        method="post"> 
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                      </td>
                      @endif
                      @endforeach
                    </tr>
                  </tbody>
                </table>
              </div>                
          <!-- AKHIR DATA -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>

@endsection