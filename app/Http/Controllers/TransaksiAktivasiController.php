<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAktivasi;
use App\Models\Member;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiAktivasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $transaksiAktivasi = TransaksiAktivasi::orderBy('ID_TRANSAKSI_AKTIVASI','asc')->paginate(10);
        $member = Member::where('MASA_AKTIVASI','<',Carbon::now())->orWhere('MASA_AKTIVASI',null)->get();
        
        return view('transaksiAktivasi.transaksiAktivasiPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiAktivasi' => $transaksiAktivasi, 
            'member' => $member,
        ]);
    }
    public function cetakStruk($id){
    
        $transaksiAktivasi = TransaksiAktivasi::where('ID_TRANSAKSI_AKTIVASI',$id)->first();
        return view('transaksiAktivasi.transaksiAktivasiStruk')->with([
            'aktivasi' => $transaksiAktivasi,
            'pegawai' => Auth::guard('pegawai')->user(),       
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
    
        $member = Member::where('MASA_AKTIVASI','<',Carbon::now())->orWhere('MASA_AKTIVASI',null)->get();
        return view('transaksiAktivasi.addTransaksiAktivasiPage')->with ([
            'pegawai'=> Auth::guard('pegawai')->user(),
            'member' => $member,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                "ID_MEMBER" => "required",
                "JUMLAH_UANG" => "required",
            ],
            [
                "ID_MEMBER.required" => "ID Member Tidak Boleh Kosong",
                "JUMLAH_UANG.required" =>
                    "Jumlah Uang Yang Diinputkan tidak boleh kosong",
            ]
        );

        $member = Member::where("ID_MEMBER", $request->ID_MEMBER)->first();
        $pegawai = Auth::guard("pegawai")->user();

        if ($request->JUMLAH_UANG < 3000000) {
            return redirect()
                ->back()
                ->with(["error" => "Uang yang dimasukan kurang"]);
        }

        if ($member) {
            $activation_transaction = TransaksiAktivasi::create([
                "ID_MEMBER" => $member->ID_MEMBER,
                "ID_PEGAWAI" => $pegawai->ID_PEGAWAI,
                "TANGGAL_TRANSAKSI_AKTIVASI" => Carbon::now()->format("Y-m-d H:i:s"),
                "TANGGAL_EXPIRED_TRANSAKSI_AKTIVASI" => Carbon::now()
                    ->addYears(1)
                    ->format("Y-m-d H:i:s"),
                "BIAYA_AKTIIVASI" => 3000000,
                "STATUS_TRANSAKSI_AKTIVASI" => "Sudah Dibayar",
                "KEMBALIAN" => $request->JUMLAH_UANG - 3000000,
            ]);

            if ($activation_transaction) {
                // generate masa aktif member di table member
                $member->MASA_AKTIVASI = Carbon::now()
                    ->addYears(1)
                    ->format("Y-m-d H:i:s");
                $member->update();
                $data = TransaksiAktivasi::latest(
                    "ID_TRANSAKSI_AKTIVASI"
                )->first();
                return redirect()->intended("transaksiAktivasi");
            } else {
                return redirect()
                    ->intended("transaksiAktivasi")
                    ->with(["error" => "Tidak Berhasil Aktivasi Member"]);
            }
        } else {
            return redirect()
                ->intended("transaksiAktivasi")
                ->with(["error" => "Tidak Berhasil Aktivasi Member"]);
        }
    }

    public function indexAktivasi(Request $request)
    {
        $this->validate(
            $request,
            [
                "ID_MEMBER" => "required",
            ],
            [
                "ID_MEMBER.required" => "ID Member tidak boleh kosong",
            ]
        );

        $member = Member::where("ID_MEMBER", $request->ID_MEMBER)->first();

        return view("transaksiAktivasi/konfirmasiAktivasiPage")->with([
            "pegawai" => Auth::guard("pegawai")->user(),
            "member" => $member,
        ]);
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
