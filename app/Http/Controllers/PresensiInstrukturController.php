<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JadwalHarian;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\PresensiInstruktur;
use Illuminate\Support\Facades\DB;
use App\Models\Instruktur;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class PresensiInstrukturController extends Controller
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
    public function store(Request $request){
        if($request->expectsJson()){
            $validate = Validator::make($request->all(),[
                'ID_INSTRUKTUR' => ['required'],
                'TANGGAL_MENGAJAR' => ['required'],
            ]);
    
            if($validate->fails()) {
                return response(['success' => false,'message' => $validate->errors()],400);   
            }   

            $attendace = PresensiInstruktur::where('TANGGAL_MENGAJAR',$request->TANGGAL_MENGAJAR)->where('ID_INSTRUKTUR',$request->ID_INSTRUKTUR)->first();
            
            if($attendace){
                if($attendace->JAM_SELESAI == null) {
                    $attendace->JAM_SELESAI = Carbon::now()->format('H:i:s');
                    $attendace->update();
                    return response([
                        'message' => 'Succesfully Update Finish Class',
                        'data' => $attendace,
                    ], 200);
                }else {
                    return response([
                        'message' => 'You have been Update Start and Finish Class',
                        'data' => null,
                    ], 400); 
                }
                
            }else{

                if($request->TANGGAL_MENGAJAR > Carbon::now()){
                    $temp_mulai = Carbon::parse($request->TANGGAL_MENGAJAR)->format("H:i:s");
                    $temp_late = 0;
                }else {
                    $temp_late = Carbon::now()->diffInSeconds(Carbon::parse($request->TANGGAL_MENGAJAR));
                    $temp_mulai = Carbon::parse(Carbon::now()->format('H:i:s'));
                }

                $store_data = PresensiInstruktur::create([
                    'ID_INSTRUKTUR' => $request->ID_INSTRUKTUR,
                    'TANGGAL_MENGAJAR' => $request->TANGGAL_MENGAJAR,
                    'WAKTU_TERLAMBAT' => $temp_late,
                    'JAM_MULAI' => $temp_mulai,
                    'JAM_SELESAI' => null,
                    'DURASI_KELAS' => "2 jam",
                ]);
                
                if($store_data){
                    return response([
                        'message' => 'Succesfully Update Start Class',
                        'data' => $store_data,
                    ], 200);
                }else {
                    return response([
                        'message' => 'Failed Update Start Class',
                        'data' => null,
                    ], 400); 
                }
            }
        }
    }
    
    public function index_api_schedule(Request $request){
        if($request->expectsjson()){
            $schedule_daily = DB::table('jadwal_harian as jh')->select('jh.TANGGAL_JADWAL_HARIAN','i.ID_INSTRUKTUR','i.NAMA_INSTRUKTUR','k.NAMA_KELAS','ju.ID_KELAS','jh.STATUS_JADWAL_HARIAN','ju.HARI_JADWAL_UMUM', 'k.HARGA_KELAS')
            ->join('instruktur as i','jh.ID_INSTRUKTUR','i.ID_INSTRUKTUR')
            ->join('jadwal_reguler as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_REGULER')
            ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->where('jh.TANGGAL_JADWAL_HARIAN','>=',Carbon::now()->format('Y-m-d'))->where('jh.TANGGAL_JADWAL_HARIAN','<',Carbon::now()->addDays(1)->format('Y-m-d'))->where('jh.STATUS_JADWAL_HARIAN','!=','Libur')
            ->orderby('jh.TANGGAL_JADWAL_HARIAN','asc')->get();
            if($schedule_daily){
                return response([
                    'message' => 'Berhasil mendapat data presensi',
                    'data' => $schedule_daily,
                ],200);
            }else{
                return response([
                    'message' => 'Data presensi tidak ditemukan',
                    'data' => null,
                ],400);
            }
            return response([
                'message' => 'Data presensi tidak ditemukan',
                'data' => null,
            ],400);
        }
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
