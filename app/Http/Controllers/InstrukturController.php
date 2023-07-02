<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Instruktur;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class InstrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Instruktur::orderBy('ID_INSTRUKTUR')->paginate(5);
        return view('instruktur.instrukturPage')->with([
            'data' => $data,
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
        return view("instruktur/addInstrukturPage")->with([
            "pegawai" => Auth::guard("pegawai")->user(),
        ]);
    }

    public function getDataInstruktur(Request $request, $id)
    {
        if ($request->expectsjson()) {

            $dataInstruktur = Instruktur::where("ID_INSTRUKTUR", $id)->first();

            if ($dataInstruktur) {
                return response(
                    [
                        "message" => "Berhasil mengambil data instruktur",
                        "data" => $dataInstruktur,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Instruktur tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                "NAMA_INSTRUKTUR" => ["required"],
                "ALAMAT_INSTRUKTUR" => ["required"],
                "TELEPON_INSTRUKTUR" => ["required"],
                "UMUR_INSTRUKTUR" => ["required"],
                "JENIS_KELAMIN_INSTRUKTUR" => ["required"],
                "TANGGAL_LAHIR_INSTRUKTUR" => ["required"],
                "EMAIL_INSTRUKTUR" => ["required"],
                // "password" => ["required"],
            ],
        );

        $dataInstruktur = $request->all();

        $dataInstruktur["password"] = \bcrypt($request->password);
        $instruktur = Instruktur::create($dataInstruktur);

        if ($instruktur) {
            return redirect()
                ->intended("/instruktur")
                ->with(["success" => "Berhasil Menambahkan Data Instruktur"]);
        }
        return redirect()
            ->intended("/createInstruktur")
            ->with(["error" => "Gagal Menambah Data Instruktur"]);
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
        $instruktur = Instruktur::find($id);
        return view("instruktur/editInstrukturPage")->with([
            "pegawai" => Auth::guard("pegawai")->user(),
            "instruktur" => $instruktur,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $instruktur = Instruktur::find($id);

        if($request->NAMA_INSTRUKTUR) {
            $instruktur->NAMA_INSTRUKTUR = $request->NAMA_INSTRUKTUR;
        }
        if($request->ALAMAT_INSTRUKTUR){
            $instruktur->ALAMAT_INSTRUKTUR = $request->ALAMAT_INSTRUKTUR;
        }
        if($request->TELEPON_INSTRUKTUR){
            $instruktur->TELEPON_INSTRUKTUR = $request->TELEPON_INSTRUKTUR;
        }
        if($request->UMUR_INSTRUKTUR){
            $instruktur->UMUR_INSTRUKTUR= $request->UMUR_INSTRUKTUR;
        }
        if($request->TANGGAL_LAHIR_INSTRUKTUR){
            $instruktur->TANGGAL_LAHIR_INSTRUKTUR = $request->TANGGAL_LAHIR_INSTRUKTUR;
        }
        if($request->TANGGAL_LAHIR_INSTRUKTUR){
            $instruktur->JENIS_KELAMIN_INSTRUKTUR = $request->JENIS_KELAMIN_INSTRUKTUR;
        }
        if($request->EMAIL_INSTRUKTUR){
            $instruktur->EMAIL_INSTRUKTUR = $request->EMAIL_INSTRUKTUR;
        }
        if($request->password){
            $instruktur->password = \bcrypt ($request->password);
        }

        $instruktur ->update();
        if($instruktur) {
            return redirect()->intended('/instruktur')->with(['success' => 'Berhasil Mengupdate Data Instruktur']);
        }
        return redirect()->intended('/editInstruktur/'.$id)->with(['error' => 'Gagal Mengupdate Data Instruktur']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $instruktur_delete = Instruktur::where('ID_INSTRUKTUR',$id)->first();

        $instruktur_delete->delete();

        if($instruktur_delete) {
            return redirect()->intended('/instruktur')->with(['success' => 'Berhasil Menghapus instruktur']);
        }
        return redirect()->intended('/deleteInstruktur/'.$id)->with(['error' => 'Gagal menghapus instruktur']);
    }

    // public function search(Request $request) {
    //     if($request->search != null) {
    //         $instruktur = Instruktur::where('NAMA_INSTRUKTUR',$request->search)->paginate(5);
    //     }
    //     else {
    //         $instruktur = Instruktur::orderby('ID_INSTRUKTUR')->paginate(5);
    //     }
        
    //     return view('instruktur.instrukturPage')->with([
    //         'pegawai' => Auth::guard('pegawai')->user(),
    //         'data' => $instruktur,
    //     ]);
    // }

    public function search(Request $request) {
        $instruktur = Instruktur::where('NAMA_INSTRUKTUR', 'like' , '%'.$request->search.'%')
        ->orWhere('ALAMAT_INSTRUKTUR', 'like' , '%'.$request->search.'%')
        ->orWhere('TELEPON_INSTRUKTUR', 'like' , '%'.$request->search.'%')
        ->orWhere('UMUR_INSTRUKTUR', 'like' , '%'.$request->search.'%')
        ->orWhere('JENIS_KELAMIN_INSTRUKTUR', 'like' , '%'.$request->search.'%')
        ->orWhere('TANGGAL_LAHIR_INSTRUKTUR', 'like' , '%'.$request->search.'%')
        ->orWhere('EMAIL_INSTRUKTUR', 'like' , '%'.$request->search.'%')
        ->orWhere('JUMLAH_TERLAMBAT', 'like' , '%'.$request->search.'%')
        ->paginate(5);
        $instruktur->appends(['search' => $request->search]);
       
        return view('instruktur.instrukturPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'data' => $instruktur,
        ]);
    }

    public function resetTerlambatIndex()
    {
        $data = Instruktur::orderBy('ID_INSTRUKTUR')->paginate(5);
        return view('instruktur.resetTerlambatPage')->with([
            'data' => $data,
            'pegawai' => Auth::guard('pegawai')->user(),
        ]);
    }

    public function resetTerlambatInstruktur(){
        $instruktur = Instruktur::all();
        
        if($instruktur){
            if($instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT < Carbon::now() || $instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT == null ) {
                foreach($instruktur as $item){
                    $item->JUMLAH_TERLAMBAT = 0;
                    $item->TANGGAL_EXPIRED_TERLAMBAT = Carbon::now()->addMonths(1);
                    $item->update();
                }
                return redirect()->intended('resetTerlambat')->with(['success' => 'Berhasil Reset Instruktur, Silahkan Reset lagi pada '.$item->TANGGAL_EXPIRED_TERLAMBAT]);
            }else {
                
                return redirect()->intended('resetTerlambat')->with(['error' => 'Gagal reset keterlambatan instruktur, Silahkan Reset lagi pada '.$instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT]);
            }
            
        }
        return redirect()->intended('resetTerlambat')->with(['error' => 'Gagal mereset keterlambatan instruktur']);
    }

    public function getAktivitasInstruktur(Request $request, $id)
    {
        if ($request->expectsjson()) {

            $dataInstruktur = DB::table("instruktur as i")
                ->select(
                    "k.NAMA_KELAS",
                    "k.HARGA_KELAS",
                    "ju.TANGGAL_JADWAL_UMUM",
                    "ju.SESI_JADWAL_UMUM",
                    "ju.HARI_JADWAL_UMUM",
                    "i.NAMA_INSTRUKTUR",
                    "pi.JAM_MULAI",
                    "pi.JAM_SELESAI"
                )
                ->leftjoin(
                    "jadwal_reguler as ju",
                    "i.ID_INSTRUKTUR",
                    "=",
                    "ju.ID_INSTRUKTUR"
                )
                ->leftjoin("kelas as k", "ju.ID_KELAS", "=", "k.ID_KELAS")
                ->leftjoin(
                    "presensi_instruktur as pi",
                    "ju.ID_KELAS",
                    "=",
                    "pi.ID_INSTRUKTUR"
                )
                ->where("i.ID_INSTRUKTUR", $id)
                ->get();

            if ($dataInstruktur) {
                return response(
                    [
                        "message" => "Berhasil mengambil data instruktur",
                        "data" => $dataInstruktur,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Instruktur tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }
}
