@extends('dashboard')
@section('main')

<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center ">
            <div class="col-xl-8 col-md-12 ">
                <div class="card user-card-full" style="border-radius: 15px">
                            <div class="mx-7 card-block">
                        <div class="row">
                            <div class="col-sm-8">

                            <h6 class="p-b-1 mb-0 f-w-600">GOFIT  </h6>
                            <p class="m-b-20 p-b-5">Jl. Centralpark No. 10 Yogyakarta</p>
                            

                        </div>
                             <div class="col-sm-4">
                                <p class="m-b-10 f-w-600">No Struk :  {{ $depositKelas->ID_TRANSAKSI_DEPOSIT_KELAS }}</p>
                                <p class="m-b-10 f-w-600">Tanggal  :  {{ $depositKelas->TANGGAL_DEPOSIT_KELAS }}</p>
                            </div>
                            <div class="col-sm-8">

                            </div>
                         

                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <p class="m-b-10 f-w-600">Member                                 :  {{ $depositKelas->member->ID_MEMBER }} / {{ $depositKelas->member->NAMA_MEMBER }}</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="m-b-10 f-w-600">Deposit ({{ $depositKelas->promo->KETERANGAN_PROMO}})       :  Rp.{{ $depositKelas->JUMLAH_PEMBAYARAN}},- ({{ $depositKelas->JUMLAH_DEPOSIT_KELAS}} x  Rp.{{ $depositKelas->kelas->HARGA_KELAS  }})</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="m-b-10 f-w-600">Jenis Kelas :  {{ $depositKelas->kelas->NAMA_KELAS}}</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="m-b-10 f-w-600">Total Deposit {{ $depositKelas->kelas->NAMA_KELAS}} : {{ $depositKelas->TOTAL_DEPOSIT_KELAS }}</p>
                            </div>
                         
                            <div class="col-sm-8">
                                <p class="m-b-10 f-w-600">Berlaku Sampai Dengan : {{ $depositKelas->MASA_BERLAKU_KELAS}}</p>
                            </div>

                            <br>
                            <div class="col-sm-4">
                                <p class="m-b-10 f-w-600">Kasir  :  {{ $depositKelas->pegawai->ID_PEGAWAI }} / {{ $depositKelas->pegawai->NAMA_PEGAWAI }}</p>
                                </p>
                            </div>
                            <button type="submit" class="btn btn-success" value="print" onclick="window.print()">Print Struk</button>

                        </div>

                    </div>

        </div>

    </div>
  </div>
</div>
</div>                 
@endsection
<style>
    body {
    background-color: #f9f9fa
}

.padding {
    padding: 3rem !important
}

.user-card-full {
    overflow: hidden;
}

.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 20px 0 rgba(69,90,100,0.08);
    box-shadow: 0 1px 20px 0 rgba(69,90,100,0.08);
    border: none;
    margin-bottom: 30px;
}

.m-r-0 {
    margin-right: 0px;
}

.m-l-0 {
    margin-left: 0px;
}

.user-card-full .user-profile {
    border-radius: 5px 0 0 5px;
}

.bg-c-lite-green {
    background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(57,57,89,1) 59%, rgba(89,121,128,1) 95%);
}

.user-profile {
    padding: 20px 0;
}

.card-block {
    padding: 1.25rem;
}

.m-b-25 {
    margin-bottom: 25px;
}

.img-radius {
    border-radius: 5px;
}


 
h6 {
    font-size: 14px;
}

.card .card-block p {
    line-height: 25px;
}

@media only screen and (min-width: 1400px){
p {
    font-size: 14px;
}
}

.card-block {
    padding: 1.25rem;
}

.b-b-default {
    border-bottom: 1px solid #e0e0e0;
}

.m-b-20 {
    margin-bottom: 20px;
}

.p-b-5 {
    padding-bottom: 5px !important;
}

.card .card-block p {
    line-height: 25px;
}

.m-b-10 {
    margin-bottom: 10px;
}

.text-muted {
    color: #919aa3 !important;
}

.b-b-default {
    border-bottom: 1px solid #e0e0e0;
}

.f-w-600 {
    font-weight: 600;
}

.m-b-20 {
    margin-bottom: 20px;
}

.m-t-40 {
    margin-top: 20px;
}

.p-b-5 {
    padding-bottom: 5px !important;
}

.m-b-10 {
    margin-bottom: 10px;
}

.m-t-40 {
    margin-top: 20px;
}

.user-card-full .social-link li {
    display: inline-block;
}

.user-card-full .social-link li a {
    font-size: 20px;
    margin: 0 10px 0 0;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

</style>