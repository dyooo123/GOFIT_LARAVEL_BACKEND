<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingKelas;
use App\Models\BookingGym;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Jadwal;
use App\Models\JadwalHarian;
use App\Models\MemberDepositKelas;
Use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;



class BookingGymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if($request->accepts('text/html')){
            $booking_gym = BookingGym::orderBy('KODE_BOOKING_GYM','desc')->where('STATUS_PRESENSI_GYM',null)->paginate(20);
            $booking_gym_after = BookingGym::orderBy('KODE_BOOKING_GYM','desc')->where('STATUS_PRESENSI_GYM','!=',null)->paginate(20);

            return view('presensiBookingGym/presensiBookingGymPage')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'booking_gym' => $booking_gym,
                'booking_gym_after' => $booking_gym_after, 
            ]);            
        }
    }

    public function indexBookingGym($id)
    {
        $bookingGym = BookingGym::where("ID_MEMBER", $id)->get();

        if ($bookingGym) {
            return response(
                [
                    "message" => "Berhasil mengambil data booking gym",
                    "data" => $bookingGym,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Tidak berhasil mengambil data booking gym",
                "data" => null,
            ],
            200
        );
    }

    public function cancelBookingGym($id){
        $booking = BookingGym::where('KODE_BOOKING_GYM',$id)->first();

        if($booking){
            if(Carbon::now()->format('Y-m-d') <= Carbon::parse($booking->TANGGAL_BOOKING_GYM)->subDays(1)){
                $booking->delete();
                return response([
                    'message' => 'Berhasil cancel booking',
                    'data' => $booking,
                ], 200);
            }else {
                return response([
                    'message' => 'Gagal cancel booking,Booking maksimal h-1 hari',
                    'data' => null,
                ], 400); 
            }
        }
        return response([
            'message' => 'Failed cancel booking',
            'data' => null,
        ], 400);
    }

    public function konfirmasiGym(Request $request,$id){
        if($request->accepts('text/html')){
            $booking = BookingGym::where('KODE_BOOKING_GYM',$id)->first();
            if($booking){
                $booking->WAKTU_PRESENSI_GYM = Carbon::now();
                $booking->STATUS_PRESENSI_GYM = 'Hadir';
                $booking->update();
                return redirect()->intended('presensiBookingGym')->with(['success' => 'Berhasil konfirmasi booking gym']);
            }
            return redirect()->intended('presensiBookingGym')->with(['error' => 'Gagal konfirmasi booking gym']);
        }
    }

    public function booking_receipt($id){
        $presensi = BookingGym::where('KODE_BOOKING_GYM',$id)->first();
        return view('presensiBookingGym.presensiBookingGymStruk')->with([
            'presensi' => $presensi,
            'pegawai' => Auth::guard('pegawai')->user(),
        ]);
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
                'ID_MEMBER' => ['required'],
                'SLOT_WAKTU_GYM' => ['required'],
                'TANGGAL_BOOKING_GYM' => ['required'],
            ]);
    
            if($validate->fails()) {
                return response(['success' => false,'message' => $validate->errors()],400);   
            }

            if($request->TANGGAL_BOOKING_GYM < Carbon::now()->format('Y-m-d')){
                return response([
                    'message' => 'please input date more than or same date now  ',
                    'data' => null,
                ], 400);
            }

            $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();

            if($member->MASA_AKTIVASI == null || $member->MASA_AKTIVASI < Carbon::now()){
                return response([
                    'message' => 'Anda belum aktivasi ',
                    'data' => null,
                ], 400);
            }

            $check_duplicate = BookingGym::where('ID_MEMBER',$request->ID_MEMBER)->where('TANGGAL_BOOKING_GYM',$request->TANGGAL_BOOKING_GYM)->where('SLOT_WAKTU_GYM',$request->SLOT_WAKTU_GYM)->first();
            if($check_duplicate) {
                return response([
                    'message' => 'Kelas ini sudah di booking',
                    'data' => null,
                ], 400);
            }

            $check = BookingGym::where('SLOT_WAKTU_GYM',$request->SLOT_WAKTU_GYM)->where('TANGGAL_BOOKING_GYM',$request->TANGGAL_BOOKING_GYM)->count();

            if($check <= 10){
                $store_data = BookingGym::create([
                    'ID_MEMBER' => $request->ID_MEMBER,
                    'SLOT_WAKTU_GYM' => $request->SLOT_WAKTU_GYM,
                    'TANGGAL_BOOKING_GYM' => $request->TANGGAL_BOOKING_GYM,
                    'TANGGAL_MELAKUKAN_BOOKING' => Carbon::now(),
                    'WAKTU_PRESENSI_GYM' => null,
                    'STATUS_PRESENSI_GYM' => null,
                ]);
                
                if($store_data){
                    return response([
                        'message' => 'Berhasil booking gym',
                        'data' => $store_data,
                        // 'data_depo' => $member_deposit
                    ], 200);
                }else {
                    return response([
                        'message' => 'Gagal booking gym',
                        'data' => null,
                    ], 400);
                }
            }else {
                return response([
                    'message' => 'Kelas Gym Penuh',
                    'data' => null,
                ], 400);
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
