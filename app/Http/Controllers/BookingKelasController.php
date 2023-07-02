<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingKelas;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Jadwal;
use App\Models\PresensiInstruktur;
use App\Models\JadwalHarian;
use App\Models\MemberDepositKelas;
Use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class BookingKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if($request->accepts('text/html')){
            $booking = BookingKelas::orderBy('KODE_BOOKING','desc')->where('STATUS_PRESENSI_KELAS',null)->paginate(20);
            $booking2 = BookingKelas::orderBy('KODE_BOOKING','desc')->paginate(20);
            
            return view('presensiBookingKelas/presensiBookingKelasPage')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'presensi' => $booking,
                'presensi2' => $booking2
            ]);
        }
    }

    public function booking_receipt(Request $request,$id){
        if($request->accepts('text/html')){
            $booking_receipt_reguler = DB::table('booking_presensi_kelas as bk')
            ->select('bk.KODE_BOOKING', 'm.SISA_DEPOSIT_MEMBER' ,'m.ID_MEMBER','ik.NAMA_INSTRUKTUR','m.NAMA_MEMBER','jh.ID_INSTRUKTUR','k.NAMA_KELAS','bk.TANGGAL_JADWAL_HARIAN','bk.TANGGAL_MELAKUKAN_BOOKING','bk.WAKTU_PRESENSI_KELAS','bk.STATUS_PRESENSI_KELAS','bk.TARIF_KELAS')
            ->join('jadwal_harian as jh','bk.TANGGAL_JADWAL_HARIAN','jh.TANGGAL_JADWAL_HARIAN')
            ->join('jadwal_reguler as jr','jh.ID_JADWAL_UMUM','jr.ID_JADWAL_REGULER')
            ->join('kelas as k','jr.ID_KELAS','k.ID_KELAS')
            ->join('member as m', 'bk.ID_MEMBER','m.ID_MEMBER')
            ->join('instruktur as ik','jh.ID_INSTRUKTUR','ik.ID_INSTRUKTUR')
            ->where('KODE_BOOKING',$id)->first();

            $check = BookingKelas::where('KODE_BOOKING',$id)->first();
            $check2 = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$check->TANGGAL_JADWAL_HARIAN)->first();
            $check3 = Jadwal::where('ID_JADWAL_REGULER',$check2->ID_JADWAL_UMUM)->first();
            $booking_receipt_packet = MemberDepositKelas::where('ID_MEMBER',$check->ID_MEMBER)->where('ID_KELAS',$check3->ID_KELAS)->first();

            return view('presensiBookingKelas/presensiBookingKelasStruk')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'presensi' => $booking_receipt_reguler,
                'presensi2' => $booking_receipt_packet, 
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
    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'TANGGAL_JADWAL_HARIAN' => ['required'],
        ]);

        if($validate->fails()) {
            return response(['success' => false,'message' => $validate->errors()],400);   
        }
        
        $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        $kelas = Kelas::where('ID_KELAS',$request->ID_KELAS)->first();
        $member_deposit = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();

        if($member_deposit && $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPOSIT != 0){
            
            if($member->MASA_AKTIVASI == null || $member->MASA_AKTIVASI < Carbon::now()){
                return response([
                    'message' => 'You not activated ',
                    'data' => null,
                ], 400);
            }
            
            $check_duplicate = BookingKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('TANGGAL_JADWAL_HARIAN',$request->TANGGAL_JADWAL_HARIAN)->first();
            if($check_duplicate) {
                return response([
                    'message' => 'You have been booking this class',
                    'data' => null,
                ], 400);
            }
            
            $check = BookingKelas::where('TANGGAL_JADWAL_HARIAN',$request->TANGGAL_JADWAL_HARIAN)->count();
            if($check < $kelas->KAPASITAS) {
                $store_data = BookingKelas::create([
                    'ID_MEMBER' => $request->ID_MEMBER,
                    'TANGGAL_JADWAL_HARIAN' => $request->TANGGAL_JADWAL_HARIAN,
                    'TANGGAL_MELAKUKAN_BOOKING' => Carbon::now(),
                    'TARIF_KELAS' => 1,
                    'WAKTU_PRESENSI_KELAS' => null,
                    'STATUS_PRESENSI_KELAS' => null,
                ]);

                if($store_data) {
                    // $member_deposit->SISA_DEPOSIT -= 1;
                    // $member_deposit->update();
                    
                    // if($member_deposit){
                        return response([
                            'message' => 'Succesfully create data',
                            'data' => $store_data,
                            // 'data_depo' => $member_deposit
                        ], 200);
                    // }else {
                    //     return response([
                    //         'message' => 'Failed create store member deposit class',
                    //         'data' => null,
                    //     ], 400);
                    // }
                }else {
                    return response([
                        'message' => 'Failed create store booking class',
                        'data' => null,
                    ], 400); 
                }
            }else {
                return response([
                    'message' => 'Kelas Penuh',
                    'data' => null,
                ], 400);
            }
        }else if($member->SISA_DEPOSIT_MEMBER != 0 && $member->SISA_DEPOSIT_MEMBER > $kelas->TARIF){
            
            if($member->MASA_AKTIVASI == null || $member->MASA_AKTIVASI < Carbon::now()){
                return response([
                    'message' => 'You not activated',
                    'data' => null,
                ], 400);
            }
            
            $check_duplicate = BookingKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('TANGGAL_JADWAL_HARIAN',$request->TANGGAL_JADWAL_HARIAN)->first();
            if($check_duplicate) {
                return response([
                    'message' => 'You have been booking this class',
                    'data' => null,
                ], 400);
            }
            
            $check = BookingKelas::where('TANGGAL_JADWAL_HARIAN',$request->TANGGAL_JADWAL_HARIAN)->count();
            if($check < $kelas->KAPASITAS_KELAS) {
                $store_data = BookingKelas::create([
                    'ID_MEMBER' => $request->ID_MEMBER,
                    'TANGGAL_JADWAL_HARIAN' => $request->TANGGAL_JADWAL_HARIAN,
                    'TANGGAL_MELAKUKAN_BOOKING' => Carbon::now(),
                    'TARIF_KELAS' => $kelas->TARIF,
                    'WAKTU_PRESENSI_KELAS' => null,
                    'STATUS_PRESENSI_KELAS' => null,
                ]);

                if($store_data){
                    // $member->SISA_DEPOSIT_MEMBER = $member->SISA_DEPOSIT_MEMBER - $kelas->TARIF;
                    // $member->update();
                    return response([
                        'message' => 'Berhasil create data',
                        'data' => $store_data,
                    ], 200);
                }else {
                    return response([
                        'message' => 'Gagal create booking class',
                        'data' => null,
                    ], 400); 
                }
            }else {
                return response([
                    'message' => 'Class Penuh',
                    'data' => null,
                ], 400);
            } 
        }else {
            return response([
                'message' => 'Gagal booking kelas, periksa Status aktiv / sisa deposit uang / deposit paket',
                'data' => null,
            ], 400);
        } 
    }

    public function getDataBooking($id){
        // $booking = BookingKelas::where('ID_MEMBER',$id)->first();
        $booking = DB::table('booking_presensi_kelas as bk')->select('bk.KODE_BOOKING','k.NAMA_KELAS','bk.TANGGAL_JADWAL_HARIAN','bk.TANGGAL_MELAKUKAN_BOOKING','bk.WAKTU_PRESENSI_KELAS','bk.STATUS_PRESENSI_KELAS','i.NAMA_INSTRUKTUR')
        ->join('jadwal_harian as jh','bk.TANGGAL_JADWAL_HARIAN','jh.TANGGAL_JADWAL_HARIAN')
        ->join('jadwal_reguler as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_REGULER')
        ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
        ->join("instruktur as i", "jh.ID_INSTRUKTUR", "i.ID_INSTRUKTUR")
        ->where('ID_MEMBER',$id)->get();

        if($booking){
            return response([
                'message' => 'Succesfully get data',
                'data' => $booking,
            ], 200);
        }
        return response([
            'message' => 'Failed get data',
            'data' => null,
        ], 400);
    }

    public function cancelBooking($id){
        $booking = BookingKelas::where('KODE_BOOKING',$id)->first();

        
        if($booking){
            if(Carbon::now()->format('Y-m-d') <= Carbon::parse($booking->TANGGAL_JADWAL_HARIAN)->subDays(1)->format('Y-m-d')){
                $booking->delete();
                return response([
                    'message' => 'Berhasil cancel booking',
                    'data' => $booking,
                ], 200);
            }else {
                return response([
                    'message' => 'Cancel Booking kelas maksimal h-1 ',
                    'data' => null,
                ], 400); 
            }
        }
        return response([
            'message' => 'Gagal cancel booking',
            'data' => null,
        ], 400);
    }


    public function index_api_schedule_presence(Request $request,$id){
        if($request->expectsjson()){
            $schedule_daily = DB::table('jadwal_harian as jh')->select('jh.TANGGAL_JADWAL_HARIAN','i.ID_INSTRUKTUR','i.NAMA_INSTRUKTUR','k.NAMA_KELAS','ju.ID_KELAS','jh.STATUS_JADWAL_HARIAN','ju.HARI_JADWAL_UMUM', 'k.HARGA_KELAS')
            ->join('instruktur as i','jh.ID_INSTRUKTUR','i.ID_INSTRUKTUR')
            ->join('jadwal_reguler as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_REGULER')
            ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->where('jh.TANGGAL_JADWAL_HARIAN','>=',Carbon::now()->format('Y-m-d'))->where('jh.TANGGAL_JADWAL_HARIAN','<',Carbon::now()->addDays(1)->format('Y-m-d'))->where('jh.STATUS_JADWAL_HARIAN','!=','Libur')->where('jh.ID_INSTRUKTUR',$id)
            ->orderby('jh.TANGGAL_JADWAL_HARIAN','asc')->get();
            if($schedule_daily){
                return response([
                    'message' => 'Berhasil mengambil data jadwal',
                    'data' => $schedule_daily,
                ],200);
            }
            return response([
                'message' => 'Data jadwal instruktur tidak ditemukan',
                'data' => null,
            ],400);
        }
    }

    public function index_api_history_presence(Request $request, $id){
        if($request->expectsJson()){
            $booking = DB::table('booking_presensi_kelas as bk')->select('bk.KODE_BOOKING','m.NAMA_MEMBER','m.ID_MEMBER', 'k.NAMA_KELAS','bk.TANGGAL_JADWAL_HARIAN','bk.TANGGAL_MELAKUKAN_BOOKING','bk.WAKTU_PRESENSI_KELAS','bk.STATUS_PRESENSI_KELAS')
            ->join('jadwal_harian as jh','bk.TANGGAL_JADWAL_HARIAN','jh.TANGGAL_JADWAL_HARIAN')
            ->join('jadwal_reguler as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_REGULER')
            ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->join('member as m','bk.ID_MEMBER','m.ID_MEMBER')
            ->where('jh.TANGGAL_JADWAL_HARIAN',$id)->get();
            if($booking){
                return response([
                    'message' => 'Berhasil mendapatkan data presensi',
                    'data' => $booking,
                ],200);
            }
            return response([
                'message' => 'Gagal mengambil data presensi',
                'data' => null,
            ],400);
        }
    }

    public function update_transaction(Request $request){
        if($request->expectsJson()){
            $data = $request->only('KODE_BOOKING','STATUS_PRESENSI_KELAS');
            $validate = Validator::make($data,[
                'KODE_BOOKING' => ['required'],
                'STATUS_PRESENSI_KELAS' => ['required'],
            ],[
                'KODE_BOOKING.required'=>'Kode Booking field is empty',
                'STATUS_PRESENSI_KELAS.required'=>'Status field is empty'
            ]);
    
            if($validate->fails()) {
                return response(['success' => false,'message' => $validate->errors()],400);   
            }
            
            $booking_class = BookingKelas::where('KODE_BOOKING',$request->KODE_BOOKING)->first();

            if($booking_class->STATUS_PRESENSI_KELAS != null){
                return response([
                    'message' => 'Presensi member ini telah di konfirmasi',
                    'data' => null,
                ],400);
            }
            
            if($booking_class){
                $presence = PresensiInstruktur::where('TANGGAL_MENGAJAR',$booking_class->TANGGAL_JADWAL_HARIAN)->first();
                if($presence){
                    if($presence->JAM_MULAI != null){
                        if($presence->JAM_SELESAI != null){
                            return response([
                                'message' => 'Kelas sudah selesai',
                                'data' => null,
                            ],400);
                        }
                        if($booking_class->TARIF_KELAS == 1){
                            $daily_schedule = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$booking_class->TANGGAL_JADWAL_HARIAN)->first();
                            $general_schedule = Jadwal::where('ID_JADWAL_UMUM',$daily_schedule->ID_JADWAL_UMUM)->first();
                            $member_deposit = MemberDepositKelas::where('ID_MEMBER',$booking_class->ID_MEMBER)->where('ID_KELAS',$general_schedule->ID_KELAS)->first();
                            if($member_deposit){
                                $member_deposit->SISA_DEPOSIT -= $booking_class->TARIF_KELAS;
                                $member_deposit->update();
                                $booking_class->STATUS_PRESENSI_KELAS = $request->STATUS_PRESENSI_KELAS;
                                $booking_class->WAKTU_PRESENSI_KELAS = Carbon::now();
                                $booking_class->update();
                                return response([
                                    'message' => 'Berhasil update member deposit kelas',
                                    'data' => $member_deposit,
                                ],200);
                            }else {
                                return response([
                                    'message' => 'Gagal mengambil data member deposit',
                                    'data' => null,
                                ],400);
                            }
                        }else{
                            $member = Member::where('ID_MEMBER',$booking_class->ID_MEMBER)->first();
                            $member->SISA_DEPOSIT_MEMBER -= $booking_class->TARIF_KELAS;
                            $member->update();
                            $booking_class->STATUS_PRESENSI_KELAS =  $request->STATUS_PRESENSI_KELAS;
                            $booking_class->WAKTU_PRESENSI_KELAS = Carbon::now();
                            $booking_class->update();
                            return response([
                                'message' => 'Berhasil mengupdate deposit uang member',
                                'data' => $member,
                            ],200);
                        }
                    }else{
                        return response([
                            'message' => 'Instruktur harus dikonfirmasi kehadiran oleh MO terlebih dahulu',
                            'data' => null,
                        ],400);
                    }
                }else{
                    return response([
                        'message' => 'Instruktur harus dikonfirmasi kehadiran oleh MO terlebih dahulu',
                        'data' => null,
                    ],400);
                } 
            }else {
                return response([
                    'message' => 'Gagal mengambil data booking kelas',
                    'data' => null,
                ],400);
            }
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
