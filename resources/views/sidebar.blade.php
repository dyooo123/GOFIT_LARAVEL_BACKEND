                <div class="d-flex">
                    
                    @if($pegawai->ROLE_PEGAWAI == "Kasir")
                        <div class="menu">
                            <div class="content-menu">
                                <i class="fa-solid fa-gauge"></i>
                                <a href="{{ url('dashboard')}}" style="font-weight:600">Dashboard</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa fa-user"></i>
                                <a href="{{ url('member')}}" style="font-weight:600">Data Member</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa fa-user"></i>
                                <a href="{{ url('deaktivasiMember')}}" style="font-weight:600">Deaktivasi Member</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa fa-undo"></i>
                                <a href="{{ url('resetKelas')}}" style="font-weight:600">Reset Kelas</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa fa-undo"></i>
                                <a href="{{ url('resetTerlambat')}}" style="font-weight:600">Reset Terlambat Instruktur</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-money-bill"></i>
                                <a href="{{ url('transaksiAktivasi')}}" style="font-weight:600">Transaksi Aktivasi</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-money-bill"></i>
                                <a href="{{ url('transaksiDepositUang')}}" style="font-weight:600">Transaksi Deposit Uang</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-money-bill"></i>
                                <a href="{{ url('transaksiDepositKelas')}}" style="font-weight:600">Transaksi Deposit Kelas</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-money-bill"></i>
                                <a href="{{ url('presensiBookingKelas')}}" style="font-weight:600">Booking Presensi Kelas</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-money-bill"></i>
                                <a href="{{ url('presensiBookingGym')}}" style="font-weight:600">Booking Presensi GYM</a>
                            </div>          
                            <div class="content-menu ">
                                <i class="fa fa-sign-out"></i>
                                <a href="{{ url('logout')}}" style="font-weight:600">Logout</a>
                            </div>
                            <hr>
                        </div>
                    </div>
                    @endif

                    @if($pegawai->ROLE_PEGAWAI == "Admin")
                        <div class="menu">
                            <div class="content-menu">
                                <i class="fa-solid fa-gauge"></i>
                                <a href="{{ url('dashboard')}}" style="font-weight:600">Dashboard</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa fa-user"></i>
                                <a href="{{ url('instruktur')}}" style="font-weight:600">Data Instruktur</a>
                            </div>
                            
                            <div class="content-menu ">
                                <i class="fa fa-sign-out"></i>
                                <a href="{{ url('logout')}}" style="font-weight:600">Logout</a>
                            </div>
                            <hr>
                        </div>
                    </div>
                    @endif
                    
                    @if($pegawai->ROLE_PEGAWAI == "Manajer Operasional")
                        <div class="menu">
                            <div class="content-menu">
                                <i class="fa-solid fa-gauge"></i>
                                <a href="{{ url('dashboard')}}" style="font-weight:600">Dashboard</a>
                            </div>
                            <div class="content-menu">
                            <i class="fa-solid fa-calendar-days"></i>
                            <a href="{{ url('jadwal')}}" style="font-weight:600">Data Jadwal Umum</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-calendar-days"></i>
                                <a href="{{ url('jadwalHarian')}}" style="font-weight:600">Data Jadwal Harian</a>
                             </div> 
                            <div class="content-menu">
                                <i class="fa-solid fa-scroll"></i>
                                <a href="{{ url('izinInstruktur')}}" style="font-weight:600">Data Izin Instruktur</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-scroll"></i>
                                <a href="{{ url('laporanPendapatan')}}" style="font-weight:600">Laporan Pendapatan</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-scroll"></i>
                                <a href="{{ url('laporanKelas')}}" style="font-weight:600">Laporan Aktivitas Kelas</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-scroll"></i>
                                <a href="{{ url('laporanGym')}}" style="font-weight:600">Laporan Aktivitas Gym</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa-solid fa-scroll"></i>
                                <a href="{{ url('laporanKinerjaInstruktur')}}" style="font-weight:600">Laporan Kinerja Instruktur</a>
                            </div>
                            <div class="content-menu ">
                                <i class="fa fa-sign-out"></i>
                                <a href="{{ url('logout')}}" style="font-weight:600">Logout</a>
                            </div>
                            <hr>
                        </div>
                    </div>
                    @endif

                </body>
            </div>
        </div>

    </div>
</div>