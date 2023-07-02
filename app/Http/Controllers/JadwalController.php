<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Instruktur;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // $kelas = Kelas::all();
        $jadwal = Jadwal::orderBy('SESI_JADWAL_UMUM','asc')->get();

        return view('jadwal.jadwalPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'jadwal' => $jadwal
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $kelas = Kelas::all();
        $jadwal = Jadwal::all();
        $instruktur = Instruktur::all();
        return view('jadwal.addJadwalPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'kelas' => $kelas,
            'instruktur' => $instruktur,
            'jadwal' => $jadwal,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validate = $request->validate([
            'ID_KELAS' => ['required', 'numeric'],
            'ID_INSTRUKTUR' => ['required','numeric'],
            'HARI_JADWAL_UMUM' => ['required'],
            'SESI_JADWAL_UMUM' => ['required','date_format:H:i:s'],
        ],[
            'ID_KELAS.required' => 'The kelas field is required',
            'ID_INSTRUKTUR.required' => 'The instruktur field is required',
            'HARI_JADWAL_UMUM' => 'The day field is required',
            'SESI_JADWAL_UMUM' => 'The time field is required'
        ]);

        $dataJadwal = $request->all();

        //cek apakah jadwal instruktur bertabrakan
        $cekJadwal = Jadwal::where('ID_INSTRUKTUR',$request->ID_INSTRUKTUR)->where('HARI_JADWAL_UMUM',$request->HARI_JADWAL_UMUM)->where('SESI_JADWAl_UMUM',$request->SESI_JADWAL_UMUM)->first();

        if($cekJadwal) {
            return redirect()->intended('/addJadwalPage')->with(['error' => 'Jadwal instruktur bertabrakan pada jam ini!']);
        }else {
            $jadwal = Jadwal::create($dataJadwal);

            if($jadwal) {
                return redirect()->intended('/jadwal')->with(['success' => 'Berhasil menambahkan jadwal']);
            }
            return redirect()->intended('/addJadwalPage')->with(['error' => 'Gagal menambahkan jadwal']);
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
    public function edit($id){
        $jadwal = Jadwal::where('ID_JADWAL_REGULER',$id)->first();
        $kelas = Kelas::all();
        $instruktur = Instruktur::all();

        return view('jadwal/editJadwalPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'jadwal' => $jadwal,
            'kelas' => $kelas,
            'instruktur' => $instruktur
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id) {
        $jadwal = Jadwal::find($id);
        $temp = Jadwal::find($id);

        if($request->ID_KELAS != $temp->ID_KELAS && $request->ID_INSTRUKTUR == $temp->ID_INSTRUKTUR && $request->HARI_JADWAL_UMUM == $temp->HARI_JADWAL_UMUM && $request->SESI_JADWAL_UMUM == $temp->SESI_JADWAL_UMUM) {
            $jadwal->ID_KELAS = $request->ID_KELAS;
            $jadwal->update();
            if($jadwal) {
                return redirect()->intended('/jadwal')->with(['success' => 'Berhasil Upadte Jadwal']);
            }
            return redirect()->intended('/editJadwal/'.$id)->with(['error' => 'Gagal update jadwal']);
        }
        if($request->ID_INSTRUKTUR){
            $jadwal->ID_INSTRUKTUR = $request->ID_INSTRUKTUR;
        }
        if($request->HARI_JADWAL_UMUM){
            $jadwal->HARI_JADWAL_UMUM = $request->HARI_JADWAL_UMUM;
        }
        if($request->SESI_JADWAL_UMUM){
            $jadwal->SESI_JADWAL_UMUM = $request->SESI_JADWAL_UMUM;
        }

        $cekJadwal = Jadwal::where('ID_INSTRUKTUR',$request->ID_INSTRUKTUR)->where('HARI_JADWAL_UMUM',$request->HARI_JADWAL_UMUM)->where('SESI_JADWAL_UMUM',$request->SESI_JADWAL_UMUM)->first();

        if($cekJadwal) {
            return redirect()->intended('/editJadwal/'.$id)->with(['error' =>'Jadwal Instruktur Bertabrakan pada jam ini!']);
        }else {            
            $jadwal->ID_KELAS = $request->ID_KELAS;
            $jadwal_update = $jadwal->update();

            if($jadwal_update) {
                return redirect()->intended('/jadwal')->with(['success' => 'Sukses Update jadwal']);
            }
            return redirect()->intended('/editJadwal/'.$id)->with(['error' => 'Gagal update jadwal']);
        }
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $jadwal = Jadwal::find($id);

        $jadwal->delete();

        if($jadwal) {
            return redirect()->intended('/jadwal')->with([
                'success' => 'Jadwal berhasil di delete'
            ]);
        }else {
            return redirect()->intended('/jadwal')->with([
                'error' => 'Jadwal Gagal di delete'
            ]);
        }
    }
}
