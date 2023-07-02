<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Instruktur;
use App\Models\IzinInstruktur;
use App\Models\JadwalHarian;
use Illuminate\Support\Facades\Validator;

Use Carbon\Carbon;


class IzinInstrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $izin = IzinInstruktur::all();
        $izin = IzinInstruktur::where("STATUS_Izin", "Belum dikonfirmasi")->get();

        return view('izinInstruktur.IzininstrukturPage')->with([
            'izin' => $izin,
            'pegawai' => Auth::guard('pegawai')->user(),
        ]);
    }

    public function indexIzin($id){
        $izin = IzinInstruktur::where("ID_INSTRUKTUR", $id)->get();

                if(count($izin) > 0){
                    return response([
                            'message' => 'Retrieve All Success',
                            "data" => $izin
                        ], 200);
                    }
            
                    return response([
                        'message' => 'Empty',
                        "data" => null
            ],400);
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
        if ($request->expectsJson()) {
            $validate = Validator::make($request->all(), [
                "ID_INSTRUKTUR" => ["required"],
                "TANGGAL_IZIN_INSTRUKTUR" => ["required"],
                "KETERANGAN_IZIN" => ["required"],
            ]);

            if ($validate->fails()) {
                return response(
                    ["success" => false, "message" => $validate->errors()],
                    400
                );
            }

            if ($request->INSTRUKTUR_PENGGANTI) {
                $instructor = Instruktur::where(
                    "NAMA_INSTRUKTUR",
                    $request->INSTRUKTUR_PENGGANTI
                )->first();
                if ($instructor) {
                    $temp_instructor = $instructor->NAMA_INSTRUKTUR;
                } else {
                    return response(
                        [
                            "message" => "Nama Instruktur Pengganti Tidak Ada",
                            "data" => null,
                        ],
                        400
                    );
                }
            } else {
                $temp_instructor = null;
            }

            $check = IzinInstruktur::where(
                "TANGGAL_IZIN_INSTRUKTUR",
                $request->TANGGAL_IZIN_INSTRUKTUR
            )->exists();

            if ($check) {
                return response(
                    [
                        "message" =>
                            "Instruktur sudah pernah mengajukan izin pada tanggal ini",
                        "data" => null,
                    ],
                    400
                );
            }

            $store_data = IzinInstruktur::create([
                "ID_INSTRUKTUR" => $request->ID_INSTRUKTUR,
                "INSTRUKTUR_PENGGANTI" => $temp_instructor,
                "TANGGAL_IZIN_INSTRUKTUR" => $request->TANGGAL_IZIN_INSTRUKTUR,
                "KETERANGAN_IZIN" => $request->KETERANGAN_IZIN,
                "TANGGAL_MENGAJUKAN_IZIN" => Carbon::now(),
                "STATUS_IZIN" => "Belum dikonfirmasi",
                "TANGGAL_KONFIRMASI_IZIN" => null,
            ]);

            if ($store_data) {
                return response(
                    [
                        "message" => "Berhasil Menambahkan Izin Instruktur",
                        "data" => $store_data,
                    ],
                    200
                );
            }
            return response(
                [
                    "message" => "Gagal menambah izin ",
                    "data" => null,
                ],
                400
            );
        }
    }

    public function getDataSchedule(Request $request, $id)
    {
        if ($request->expectsjson()) {
            $schedule = JadwalHarian::where("ID_INSTRUKTUR", $id)
                ->where("TANGGAL_JADWAL_HARIAN", ">", Carbon::now())
                ->get();
            if ($schedule) {
                return response(
                    [
                        "message" => "Berhasil mengambil data izin",
                        "data" => $schedule,
                    ],
                    200
                );
            }
            return response(
                [
                    "message" => "Gagal mengambil data",
                    "data" => null,
                ],
                200
            );
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
        $izin = IzinInstruktur::where("ID_IZIN_INSTRUKTUR", $id)->first();

        if ($izin->STATUS_IZIN) {
            $izin->STATUS_IZIN = "Dikonfirmasi";
        }

        // if ($izin->TANGGAL_KONFIRMASI_IZIN) {
        //     $izin->TANGGAL_KONFIRMASI_IZIN = Carbon::now()->format("Y-m-d");
        // }

        if ($izin->TANGGAL_KONFIRMASI_IZIN===null) {
            $izin->TANGGAL_KONFIRMASI_IZIN = Carbon::now()->format("Y-m-d");
        }

        $updateIzin = $izin->update();

        if ($updateIzin) {
            return redirect()
                ->intended("izinInstruktur")
                ->with(["success" => "Berhasil mengupdate status izin instruktur"]);
        }
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
