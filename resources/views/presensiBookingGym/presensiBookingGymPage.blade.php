@extends('dashboard')
@section('main')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Presensi Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    <main class="container">     
        <!-- START DATA -->
        <div class="my-3 p-2 bg-body rounded shadow-sm">
            <h1 class="text-dark mt-2 mb-3">Booking Presensi Gym</h1>     
                

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
                            <th class="col-md-1">Kode Booking</th>
                            <th class="col-md-3">Nama Member</th>
                            <th class="col-md-3">Slot Waktu</th>
                            <th class="col-md-4">Tanggal Gym</th>
                            <th class="col-md-2">Tanggal Booking</th>
                            <th class="col-md-2">Waktu Presensi</th>
                            <th class="col-md-2">Status</th>
                            <th class="col-md-2">Aksi</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $booking_gym->firstItem() ?>

                        @foreach ($booking_gym as $item)
                            
                        <tr>
                            <td>{{ $i }}</td>
                            <td class='text-nowrap'>{{ $item->KODE_BOOKING_GYM }}</td>
                            <td class='text-nowrap'>{{ $item->member->NAMA_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->SLOT_WAKTU_GYM }}</td>
                            <td class='text-nowrap'>{{ $item->TANGGAL_BOOKING_GYM }}</td>
                            <td class='text-nowrap'>{{ $item->TANGGAL_MELAKUKAN_BOOKING}}</td>

                            @if ($item->WAKTU_PRESENSI_GYM != null)
                            <td class="col-md-3">{{ $item->WAKTU_PRESENSI_GYM }}</td>
                        @else
                            <td class="col-md-3">-</td>
                        @endif
                        @if ($item->STATUS_PRESENSI_GYM	 != null)
                            <td class="col-md-1">{{ $item->STATUS_PRESENSI_GYM	 }}</td>
                        @else
                            <td class="col-md-1">Belum dikonfirmasi</td>
                        @endif
                       
                            <td class="text-nowrap d-flex gap-2 align-items-center">
        
                                <a href="{{ url('/konfirmasiBookingGym/'.$item->KODE_BOOKING_GYM) }}" class="btn btn-success mt-1 d-inline">Konfirmasi</a>
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>


                <table class="table table-striped table-sm table-responsive">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-1">Kode Booking</th>
                            <th class="col-md-3">Nama Member</th>
                            <th class="col-md-3">Slot Waktu</th>
                            <th class="col-md-4">Tanggal Gym</th>
                            <th class="col-md-2">Tanggal Booking</th>
                            <th class="col-md-2">Waktu Presensi</th>
                            <th class="col-md-2">Status</th>
                            <th class="col-md-2">Aksi</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $booking_gym_after->firstItem() ?>

                        @foreach ($booking_gym_after as $item)
                            
                        <tr>
                            <td>{{ $i }}</td>
                            <td class='text-nowrap'>{{ $item->KODE_BOOKING_GYM }}</td>
                            <td class='text-nowrap'>{{ $item->member->NAMA_MEMBER }}</td>
                            <td class='text-nowrap'>{{ $item->SLOT_WAKTU_GYM }}</td>
                            <td class='text-nowrap'>{{ $item->TANGGAL_BOOKING_GYM }}</td>
                            <td class='text-nowrap'>{{ $item->TANGGAL_MELAKUKAN_BOOKING}}</td>

                            @if ($item->WAKTU_PRESENSI_GYM != null)
                            <td class="col-md-3">{{ $item->WAKTU_PRESENSI_GYM }}</td>
                        @else
                            <td class="col-md-3">-</td>
                        @endif
                        @if ($item->STATUS_PRESENSI_GYM	 != null)
                            <td class="col-md-1">{{ $item->STATUS_PRESENSI_GYM	 }}</td>
                        @else
                            <td class="col-md-1">Belum dikonfirmasi</td>
                        @endif
                       
                            <td class="text-nowrap d-flex gap-2 align-items-center">
        
                                <a href="{{ url('/cetakPresensiBookingGym/'.$item->KODE_BOOKING_GYM) }}" class="btn btn-success mt-1 d-inline">Cetak Struk</a>
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
                {{ $booking_gym_after->links() }}
               
          </div>
          <!-- AKHIR DATA -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
@endsection