<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TransaksiAktivasi;
use App\Models\TransaksiDepositKelas;
use App\Models\TransaksiDepositUang;
use Illuminate\Support\Facades\DB;
use App\Models\Instruktur;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function index_income_report(){
        return view('laporan.laporanPendapatanPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'data_depo_class' => [],
            'data_activation' => [],
            'data_total_income' => []
        ]);
    }
    
    public function income_report(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required']
            ]);
            
            for($x = 0; $x < 12 ; $x++){
                $report_income_deposit[] = DB::select(
                    'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income_deposit FROM 
                    (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                    UNION ALL 
                    SELECT total_deposit_uang, tanggal_deposit_uang FROM transaksi_deposit_uang) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = '.$request->year_filter.' AND MONTH(t.TANGGAL_DEPOSIT_KELAS) ='.$x.' +1 GROUP BY bulan');

                $report_income_activaton[] = DB::select(
                    'SELECT MONTHNAME(TANGGAL_TRANSAKSI_AKTIVASI) as bulan, SUM(BIAYA_AKTIIVASI) as total_income_activation 
                    FROM transaksi_aktivasi 
                    WHERE YEAR(TANGGAL_TRANSAKSI_AKTIVASI) = '.$request->year_filter.' AND MONTH(TANGGAL_TRANSAKSI_AKTIVASI) ='.$x.' + 1 GROUP BY bulan');
                    
                $report_total[] = DB::select(
                    'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income FROM 
                    (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                    UNION ALL 
                    SELECT total_deposit_uang, tanggal_deposit_uang FROM transaksi_deposit_uang
                    UNION ALL
                    SELECT biaya_aktiivasi, tanggal_transaksi_aktivasi FROM transaksi_aktivasi ) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = '.$request->year_filter.' AND MONTH(t.TANGGAL_DEPOSIT_KELAS) ='.$x.' +1 GROUP BY bulan'
                );
            }

            $collection = collect([
                $report_total
            ]);
    
            $collapsed = $collection->collapse();
            $collapsed2 = $collapsed->collapse();

            $temp_keys =['January','February','March','April','May','June','July','August','September','October','November','December'];
            $temp_value = [0,0,0,0,0,0,0,0,0,0,0,0];
            $keys = [];
            $value = [];

            for($i = 0; $i < 12; $i++){
                if($collapsed[$i]){
                    $keys[] = $collapsed[$i][0]->bulan;
                    $value[] = $collapsed[$i][0]->total_income;
                }else{
                    $keys[] = $temp_keys[$i];
                    $value[] = $temp_value[$i];
                }
            }
            
            return redirect()->intended('laporanPendapatan')->with([
                'success' => 'Sucessfully Get Report '.$request->year_filter,
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_depo_class' => $report_income_deposit,
                'data_activation' => $report_income_activaton,
                'data_total_income' => $report_total,
                'year'=> $request->year_filter,
                'report_keys'=> $keys,
                'report_value' => $value
            ]);
        }else {
        
        }
        
    }

    public function index_gym_activity_report(Request $request){
        if($request->accepts('text/html')){
            return view('laporan.laporanGymPage')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_gym_activity' => null,
            ]);
        }
    }

    public function gym_activity_report(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);

            $data_gym_activity = DB::select('SELECT TANGGAL_BOOKING_GYM as tanggal, COUNT(KODE_BOOKING_GYM) as jumlah_member  FROM `booking_presensi_gym` 
            WHERE YEAR(TANGGAL_BOOKING_GYM) = '.$request->year_filter.'
            AND STATUS_PRESENSI_GYM = "Hadir"
            AND MONTH(TANGGAL_BOOKING_GYM) = '.$request->month_filter.'
            GROUP BY TANGGAL_BOOKING_GYM');

            return redirect()->intended('laporanGym')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter ,
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_gym_activity' => $data_gym_activity,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
        }
    }



    public function index_class_activity_report(Request $request){
        if($request->accepts('text/html')){
            return view('laporan.laporanKelasPage')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_class_activity' => null,
            ]);
        }
    }

    public function class_activity_report(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);
            
            $data_class_activity = DB::select('SELECT k.NAMA_KELAS AS kelas, i.nama_instruktur AS instruktur, 
            SUM(CASE WHEN bk.KODE_BOOKING IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_peserta_kelas, 
            SUM(CASE WHEN jh.STATUS_JADWAL_HARIAN = "Libur" THEN 1 ELSE 0 END) AS jumlah_libur 
            FROM kelas as k 
            LEFT JOIN jadwal_reguler as ju on ju.ID_KELAS = k.ID_KELAS 
            LEFT JOIN jadwal_harian as jh on ju.ID_JADWAL_REGULER = jh.ID_JADWAL_UMUM 
            LEFT JOIN instruktur AS i ON jh.id_instruktur = i.id_instruktur 
            LEFT JOIN booking_presensi_kelas as bk on jh.TANGGAL_JADWAL_HARIAN = bk.TANGGAL_JADWAL_HARIAN 
            WHERE MONTH(jh.tanggal_jadwal_harian) = '.$request->month_filter.' AND YEAR(jh.TANGGAL_JADWAL_HARIAN) = '.$request->year_filter.' GROUP BY k.NAMA_KELAS, i.NAMA_INSTRUKTUR;');

            return redirect()->intended('laporanKelas')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter ,
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_class_activity' => $data_class_activity,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
            
            
        }else{
            // $data_class_activity = DB::select('SELECT k.NAMA_KELAS AS kelas, i.nama_instruktur AS instruktur, COUNT(bk.KODE_BOOKING_KELAS) AS jumlah_peserta_kelas, 
            // COUNT(CASESTATUS = "Libur" THEN 1 ELSE NULL END) AS jumlah_libur
            // FROM booking_kelas AS bk
            // JOIN jadwal_harian AS jh ON bk.TANGGAL_JADWAL_HARIAN = jh.TANGGAL_JADWAL_HARIAN
            // JOIN jadwal_umum AS ju ON jh.id_jadwal_umum = ju.id_jadwal_umum
            // JOIN instruktur AS i ON jh.id_instruktur = i.id_instruktur
            // JOIN kelas AS k ON ju.id_kelas = k.id_kelas
            // WHERE MONTH(jh.tanggal_jadwal_harian) = 6 AND YEAR(jh.TANGGAL_JADWAL_HARIAN) = 2023
            // GROUP BY k.NAMA_KELAS, i.nama_instruktur');
            
            // return response([
            //     'data_class_activity' => $data_class_activity
            // ]);
        }
    }
    
    public function index_instructor_report(Request $request){
        if($request->accepts('text/html')){
            return view('laporan.laporanKinerjaInstrukturPage')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_instructor' => null,
            ]);
        }
    }

    public function instructor_report(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);

            // $data_instructor = DB::select('SELECT i.nama_instruktur, SUM(CASE WHEN pi.ID_PRESENSI_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_hadir, SUM(CASE WHEN iz.ID_IZIN_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_izin, 
            // IFNULL(i.jumlah_terlambat, 0) AS akumulasi_terlambat 
            // FROM instruktur AS i 
            // LEFT JOIN presensi_instruktur AS pi ON i.id_instruktur = pi.id_instruktur 
            // AND MONTH(pi.created_at) = '.$request->month_filter.' AND YEAR(pi.created_at) = '.$request->year_filter.'
            // LEFT JOIN izin AS iz ON i.id_instruktur = iz.id_instruktur 
            // AND MONTH(iz.created_at) = '.$request->month_filter.'  AND YEAR(iz.created_at) = '.$request->year_filter.'
            // GROUP BY i.NAMA_INSTRUKTUR, i.jumlah_terlambat
            // ORDER BY i.jumlah_terlambat');

            $data_instructor = DB::select('SELECT i.nama_instruktur, SUM(CASE WHEN pi.ID_PRESENSI_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_hadir, SUM(CASE WHEN iz.ID_IZIN_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_izin, 
            SUM(CASE WHEN pi.WAKTU_TERLAMBAT iS NOT NULL THEN pi.WAKTU_TERLAMBAT ELSE 0 END) AS akumulasi_terlambat 
            FROM instruktur AS i 
            LEFT JOIN presensi_instruktur AS pi ON i.id_instruktur = pi.id_instruktur 
            AND MONTH(pi.created_at) = '.$request->month_filter.' AND YEAR(pi.created_at) = '.$request->year_filter.'
            LEFT JOIN izin AS iz ON i.id_instruktur = iz.id_instruktur 
            AND MONTH(iz.created_at) = '.$request->month_filter.'  AND YEAR(iz.created_at) = '.$request->year_filter.'
            GROUP BY i.NAMA_INSTRUKTUR, i.jumlah_terlambat
            ORDER BY SUM(CASE WHEN pi.WAKTU_TERLAMBAT iS NOT NULL THEN pi.WAKTU_TERLAMBAT ELSE 0 END) ');

            return redirect()->intended('laporanKinerjaInstruktur')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter ,
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_instructor' => $data_instructor,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
