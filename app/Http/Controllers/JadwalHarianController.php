<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JadwalHarian;
use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use App\Models\Instruktur;
use Carbon\Carbon;

class JadwalHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $jadwalHarian = JadwalHarian::orderBy('TANGGAL_JADWAL_HARIAN','asc')->get();
    //     $tanggalJadwalHarian = JadwalHarian::first();
    //         return view('jadwalHarian.jadwalHarianPage')->with([
    //         'pegawai' => Auth::guard('pegawai')->user(),
    //         'jadwalHarian' => $jadwalHarian,
    //         'tanggalJadwalHarian' => $tanggalJadwalHarian,
    //     ]);
    // }

    public function index(){
        $jadwalHarian = JadwalHarian::where('expired_at','>=',Carbon::now()->format('Y-m-d'))->orderBy('TANGGAL_JADWAL_HARIAN','asc')->get();
        // $schedule_date = JadwalHarian::first();
        $tanggalJadwalHarian = JadwalHarian::where('expired_at','>=',Carbon::now()->format('Y-m-d'))->first();

        return view('jadwalHarian.jadwalHarianPage')->with([
        'pegawai' => Auth::guard('pegawai')->user(),
            'jadwalHarian' => $jadwalHarian,
            'tanggalJadwalHarian' => $tanggalJadwalHarian,
        ]);
    }
    
    // public function generateJadwalHarian(){
    //     $jadwal = Jadwal::all();
    //     $tanggalJadwalHarian = JadwalHarian::first();

    //     $cekGenerate = JadwalHarian::where('expired_at', '>=' ,Carbon::now())->first();

    //     if(JadwalHarian::exists() || $cekGenerate) {
    //         return redirect()->intended('jadwalHarian')->with(['error' => 'Jadwal Harian Telah DiGenerate, Silahkan Generate Setelah '. $tanggalJadwalHarian->expired_at ]);
    //     }else {
    //         // JadwalHarian::truncate();
            
    //         for($i=Carbon::now();$i<=Carbon::now()->addDays(6);$i->modify('+1 day')){
    //             $hari = Carbon::createFromFormat('Y-m-d H:i:s', $i)->translatedformat('l');
    //             foreach($jadwal as $item){
    //                 if($hari == $item->HARI_JADWAL_UMUM){
    //                     $daily = JadwalHarian::create([
    //                         'TANGGAL_JADWAL_HARIAN' => $i->format('Y-m-d').' '.$item->SESI_JADWAL_UMUM,
    //                         'ID_INSTRUKTUR' => $item->ID_INSTRUKTUR,
    //                         'ID_JADWAL_UMUM' => $item->ID_JADWAL_REGULER,
    //                         'STATUS_JADWAL_HARIAN' => '-',
    //                         'expired_at' => Carbon::now()->addDays(6)->format('Y-m-d H:i:s'),
    //                     ]);
    //                 }
    //             }
    //         }
    //         return redirect()->intended('jadwalHarian')->with(['success' => 'Berhasil Generate Jadwal Harian']);
    //     }
    // }

    public function generateJadwalHarian(){
        $jadwal = Jadwal::all();
        // $schedule_date = JadwalHarian::where('expired_at','>=',Carbon::now())->first();

        $check_generate = JadwalHarian::where('expired_at', '>=' ,Carbon::now()->format('Y-m-d'))->latest('expired_at')->first();

        if($check_generate) {
            return redirect()->intended('jadwalHarian')->with(['error' => 'Daily schedule has been generated. You can generate again on the date after '. $check_generate->expired_at ]);
        }else {
            // JadwalHarian::truncate();
            $expired = Carbon::now()->addDays(6)->format('Y-m-d H:i:s');
            for($i=Carbon::now();$i<=Carbon::now()->addDays(6);$i->modify('+1 day')){
                $hari = Carbon::createFromFormat('Y-m-d H:i:s', $i)->translatedformat('l');
                foreach($jadwal as $item){
                    if($hari == $item->HARI_JADWAL_UMUM){
                        $daily = JadwalHarian::create([
                            'TANGGAL_JADWAL_HARIAN' => $i->format('Y-m-d').' '.$item->SESI_JADWAL_UMUM,
                            'ID_INSTRUKTUR' => $item->ID_INSTRUKTUR,
                            'ID_JADWAL_UMUM' => $item->ID_JADWAL_REGULER,
                            'STATUS_JADWAL_HARIAN' => '-',
                            'expired_at' => $expired,
                        ]);
                    }
                }
            }
            return redirect()->intended('jadwalHarian')->with(['success' => 'Berhasil Generate Jadwal Harian']);
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
    public function edit($id){
        $jadwalHarian = jadwalHarian::where('TANGGAL_JADWAL_HARIAN',$id)->first();
        $instruktur = instruktur::all();

        return view('jadwalHarian.editJadwalHarianPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'jadwalHarian' => $jadwalHarian,
            'instruktur' => $instruktur
        ]);
    }

    public function update(Request $request,$id) {
        $jadwalHarian = jadwalHarian::where('TANGGAL_JADWAL_HARIAN',$id)->first();

        if($request->STATUS_JADWAL_HARIAN) {
            $jadwalHarian->STATUS_JADWAL_HARIAN = $request->STATUS_JADWAL_HARIAN;
        }
        if($request->ID_INSTRUKTUR){
            $jadwalHarian->ID_INSTRUKTUR = $request->ID_INSTRUKTUR;
        }

        $jadwalHarianNew = $jadwalHarian->update();
        
        if($jadwalHarianNew) {
            return redirect()->intended('/jadwalHarian')->with(['success' => 'Berhasil Update Jadwal Harian']);
        }
        return redirect()->intended('/jadwalHarian')->with(['error' => 'Gagal Update Jadwal Harian']);
        
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

    // public function search(Request $request){
    //     $tanggalJadwalHarian = JadwalHarian::first();
    //     if($request->keyword != null) {
    //         $instruktur = Instruktur::where('NAMA_INSTRUKTUR',$request->keyword)->first();
    //         $kelas = Kelas::where('NAMA_KELAS',$request->keyword)->first();
    //         if($instruktur) {
    //             $jadwalHarian = JadwalHarian::where('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->get();
    //         }else if($kelas){
    //             $jadwal = Jadwal::where('ID_KELAS',$kelas->ID_KELAS)->first();
    //             $jadwalHarian = JadwalHarian::where('ID_JADWAL_UMUM',$jadwal->ID_JADWAL_REGULER)->get();

    //         }else {
    //             $jadwalHarian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$request->keyword)->orWhere('STATUS_JADWAL_HARIAN',$request->keyword)->get();
    //         }
    //     }
    //     else {
    //         $jadwalHarian = JadwalHarian::orderby('TANGGAL_JADWAL_HARIAN','asc')->get();
    //     }
        
    //     return view('jadwalHarian.jadwalHarianPage')->with([
    //         'pegawai' => Auth::guard('pegawai')->user(),
    //         'jadwalHarian' => $jadwalHarian,
    //         'tanggalJadwalHarian' => $tanggalJadwalHarian
    //     ]);
    // }

    public function search(Request $request){
        // $schedule_date = DailySchedule::where('expired_at','<=',Carbon::now());
        $tanggalJadwalHarian = JadwalHarian::where('expired_at','>=',Carbon::now())->first();
        if($request->keyword != null) {
            $instruktur = Instruktur::where('NAMA_INSTRUKTUR',$request->keyword)->first();
            $kelas = Kelas::where('NAMA_KELAS',$request->keyword)->first();
            if($instruktur) {
                $jadwalHarian = JadwalHarian::where('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->where('expired_at',$tanggalJadwalHarian->expired_at)->get();
            }
            else if($kelas){
                $jadwal = Jadwal::where('ID_KELAS',$kelas->ID_KELAS)->get();
                $jadwalHarian = JadwalHarian::whereIn('ID_JADWAL_UMUM',$jadwal->pluck('ID_JADWAL_REGULER'))->where('expired_at',$tanggalJadwalHarian->expired_at)->get();
           
            }else {
                $jadwalHarian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN','like','%'.$request->keyword.'%')
                ->where('expired_at',$tanggalJadwalHarian->expired_at)
                ->orWhere('STATUS_JADWAL_HARIAN','like','%'.$request->keyword.'%')
                ->where('expired_at',$tanggalJadwalHarian->expired_at)
                ->get();
            }
        }
        else {
            $jadwalHarian = JadwalHarian::orderby('TANGGAL_JADWAL_HARIAN','asc')->where('expired_at',$tanggalJadwalHarian->expired_at)->get();
        }
        
        return view('jadwalHarian.jadwalHarianPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'jadwalHarian' => $jadwalHarian,
            'tanggalJadwalHarian' => $tanggalJadwalHarian
        ]);
    }

    public function index_api(Request $request){
        if($request->expectsjson()){
            $schedule_daily = DB::table('jadwal_harian as jh')->select('jh.TANGGAL_JADWAL_HARIAN','i.NAMA_INSTRUKTUR','k.NAMA_KELAS','ju.ID_KELAS','jh.STATUS_JADWAL_HARIAN','ju.HARI_JADWAL_UMUM', 'k.HARGA_KELAS')
            ->join('instruktur as i','jh.ID_INSTRUKTUR','i.ID_INSTRUKTUR')
            ->join('jadwal_reguler as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_REGULER')
            ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->where('jh.TANGGAL_JADWAL_HARIAN','>',Carbon::now())
            ->orderby('jh.TANGGAL_JADWAL_HARIAN','asc')->get();
            if($schedule_daily){
                return response([
                    'message' => 'Berhasilkan mendapatkan data jadwal',
                    'data' => $schedule_daily,
                ],200);
            }
            return response([
                'message' => 'Berhasil mendapatkan data permission',
                'data' => null,
            ],400);
        }
    }
}
