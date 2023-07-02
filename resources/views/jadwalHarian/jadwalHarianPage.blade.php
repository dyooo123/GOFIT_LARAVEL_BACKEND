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
    
     <!-- START DATA -->
     <div class="my-3 p-2 bg-body rounded shadow-sm">
      <h1 class="text-dark mt-2 mb-3">DATA JADWAL HARIAN</h1> 
      <!-- FORM PENCARIAN -->
      <div class="pb-3">
        <form class="d-flex" action="{{ url('/searchJadwalHarian') }}" method="get">
            <input class="form-control me-1" type="search" placeholder="Masukkan keyword" aria-label="Search" name="keyword">
            <button class="btn btn-secondary" type="submit">Cari</button>
      </form>
    </div>    
      <!-- TOMBOL TAMBAH DATA -->
      <div class="pb-3 ml-3">
        <a href='{{ url('/generatejadwalHarian') }}' class="btn btn-success">Generate Jadwal Harian</a>
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
                      <td>
                        @if($tanggalJadwalHarian != null)
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->format('l') }}</div>
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->format('Y M d') }}</div>
                        @endif
                      </td>
                      @foreach($jadwalHarian as $item)
                      @if($item->jadwal->HARI_JADWAL_UMUM == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->translatedformat('l'))
                        <td class="active ">
                          <div>{{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                          <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <div>{{ $item->STATUS_JADWAL_HARIAN }}</div>
                          <a href='{{ url('/editJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <td>
                        @if($tanggalJadwalHarian != null)
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(1)->format('l') }}</div>
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(1)->format('Y M d') }}</div>
                        @endif
                      </td>
                      @foreach($jadwalHarian as $item)
                      @if($item->jadwal->HARI_JADWAL_UMUM == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(1)->translatedformat('l'))
                        <td class="active ">
                          <div>{{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                          <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <div>{{ $item->STATUS_JADWAL_HARIAN }}</div>
                          <a href='{{ url('/editJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <td>
                        @if($tanggalJadwalHarian != null)
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(2)->format('l') }}</div>
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(2)->format('Y M d') }}</div>
                        @endif
                      </td>
                      @foreach($jadwalHarian as $item)
                      @if($item->jadwal->HARI_JADWAL_UMUM == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(2)->translatedformat('l'))
                        <td class="active ">
                          <div>{{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                          <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <div>{{ $item->STATUS_JADWAL_HARIAN }}</div>
                          <a href='{{ url('/editJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <td>
                        @if($tanggalJadwalHarian != null)
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(3)->format('l') }}</div>
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(3)->format('Y M d') }}</div>
                        @endif
                      </td>
                      @foreach($jadwalHarian as $item)
                      @if($item->jadwal->HARI_JADWAL_UMUM == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(3)->translatedformat('l'))
                        <td class="active ">
                          <div>{{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                          <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <div>{{ $item->STATUS_JADWAL_HARIAN }}</div>
                          <a href='{{ url('/editJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <td>
                        @if($tanggalJadwalHarian != null)
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(4)->format('l') }}</div>
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(4)->format('Y M d') }}</div>
                        @endif
                      </td>
                      @foreach($jadwalHarian as $item)
                      @if($item->jadwal->HARI_JADWAL_UMUM == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(4)->translatedformat('l'))
                        <td class="active ">
                          <div>{{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                          <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <div>{{ $item->STATUS_JADWAL_HARIAN }}</div>
                          <a href='{{ url('/editJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <td>
                        @if($tanggalJadwalHarian != null)
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(5)->format('l') }}</div>
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(5)->format('Y M d') }}</div>
                        @endif
                      </td>
                      @foreach($jadwalHarian as $item)
                      @if($item->jadwal->HARI_JADWAL_UMUM == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(5)->translatedformat('l'))
                        <td class="active ">
                          <div>{{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                          <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <div>{{ $item->STATUS_JADWAL_HARIAN }}</div>
                          <a href='{{ url('/editJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}"
                          method="post"> 
                          @csrf
                          @method('DELETE')
                          <button type="submit" name="submit" class="btn btn-danger btn-sm d-inline"><i class="fas fa-trash"></i></button>
                        </td>
                      @endif
                      @endforeach
                    </tr>
                    <tr>
                      <td>
                        @if($tanggalJadwalHarian != null)
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(6)->format('l') }}</div>
                        <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(6)->format('Y M d') }}</div>
                        @endif
                      </td>
                      @foreach($jadwalHarian as $item)
                      @if($item->jadwal->HARI_JADWAL_UMUM == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(6)->translatedformat('l'))
                        <td class="active ">
                          <div>{{ $item->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</div>
                          <div>{{ $item->jadwal->kelas->NAMA_KELAS }}</div>
                          <div>{{ $item->instruktur->NAMA_INSTRUKTUR }}</div>
                          <div>{{ $item->STATUS_JADWAL_HARIAN }}</div>
                          <a href='{{ url('/editJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}' class="btn btn-warning btn-sm d-inline"><i class="fas fa-pencil"></i></a>

                          <form class='d-inline' action="{{ url('/deleteJadwalHarian/'.$item->TANGGAL_JADWAL_HARIAN) }}"
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