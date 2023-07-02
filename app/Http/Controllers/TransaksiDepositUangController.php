<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAktivasi;
use App\Models\TransaksiDepositUang;
use App\Models\Member;
use App\Models\Pegawai;
use App\Models\Promo;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiDepositUangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksiDepositUang = TransaksiDepositUang::orderBy('ID_TRANSAKSI_DEPOSIT_UANG','asc')->paginate(10);
        
        return view('transaksiDepositUang.transaksiDepositUangPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiDepositUang' => $transaksiDepositUang, 
        ]);
    }

    public function cetakStruk($id){
    
        $transaksiDepositUang = TransaksiDepositUang::where('ID_TRANSAKSI_DEPOSIT_UANG',$id)->first();
        return view('transaksiDepositUang.transaksiDepositUangStruk')->with([
            'depositUang' => $transaksiDepositUang,
            'pegawai' => Auth::guard('pegawai')->user(),       
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        

        $member = Member::all();
        return view('transaksiDeposituang.addTransaksiDeposituangPage')->with ([
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
    // public function store(Request $request){
    //     $validate = $request->validate([
    //         'ID_MEMBER' => ['required'],
    //         'JUMLAH_DEPOSIT_UANG' => ['required','numeric'],
    //     ],[
    //         'ID_MEMBER.required' => 'The member name field is required',
    //         'JUMLAH_DEPOSIT_UANG.required' => 'The nominal field is required',
    //         'JUMLAH_DEPOSIT_UANG.numeric' => 'Format nominal is numeric'
    //     ]);
        
    //     $members = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();

    //     if($request->JUMLAH_DEPOSIT_UANG >= 3000000 && $members->SISA_DEPOSIT_MEMBER >=500000) {
    //         $promo = Promo::where('BONUS',300000)->first();
    //         if($promo) {
    //             $idPromo = $promo->ID_PROMO;
    //             $bonus = $promo->BONUS;
    //         }else {
    //             $idPromo = null;
    //             $bonus = 0;
    //         }
    //     }else {
    //         $idPromo = null;
    //         $bonus = 0;
    //     }
        
    //     if($members->SISA_DEPOSIT_MEMBER) {
    //         $sisa = $members->SISA_DEPOSIT_MEMBER;
    //     }else {
    //         $sisa = 0;
    //     }
        
    //     $dataDepositUang = TransaksiDepositUang::create([
    //         'ID_PROMO' => $idPromo,
    //         'ID_MEMBER' => $request->ID_MEMBER,
    //         'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
    //         'JUMLAH_DEPOSIT_UANG' => $request->JUMLAH_DEPOSIT_UANG,
    //         'BONUS_DEPOSIT_UANG' => $bonus,
    //         'SISA_DEPOSIT_UANG' => $sisa,
    //         'TOTAL_DEPOSIT_UANG' => $request->JUMLAH_DEPOSIT_UANG + $sisa + $bonus,
    //         'TANGGAL_DEPOSIT_UANG' => Carbon::now(),
    //     ]);

    //     if($dataDepositUang){
    //         $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
    //         $member->SISA_DEPOSIT_MEMBER = $request->JUMLAH_DEPOSIT_UANG + $sisa + $bonus;
    //         $member->update();
    //         $data = TransaksiDepositUang::latest('ID_TRANSAKSI_DEPOSIT_UANG')->first();
    //         return redirect()->intended('transaksiDepositUangStruk/'.$data->ID_TRANSAKSI_DEPOSIT_UANG);
    //     }else {
    //         return redirect()->intended('transaksiDepositUang')->with(['error' => 'Failed deposit member']);
    //     }
    // }

    public function store(Request $request){
        $validate = $request->validate([
            'ID_MEMBER' => ['required'],
            'JUMLAH_DEPOSIT_UANG' => ['required','numeric'],
            'JUMLAH_UANG' => ['required']
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'JUMLAH_DEPOSIT_UANG.required' => 'The nominal field is required',
            'JUMLAH_DEPOSIT_UANG.numeric' => 'Format nominal is numeric',
            'JUMLAH_UANG.required' => 'The pay cost field is required'
        ]);
        
        $members = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();


        $member_check = Member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();

        if(!($member_check)) {
            return redirect()->intended('transaksiDepositUang')->with(['error' => 'Member not activated. Please activate first']);
        }
        
        if($request->JUMLAH_DEPOSIT_UANG >= 3000000 && $members->SISA_DEPOSIT_MEMBER >=500000) {
            $promo = Promo::where('BONUS',300000)->first();
            if($promo) {
                $idPromo = $promo->ID_PROMO;
                $bonus = $promo->BONUS;
            }else {
                $idPromo = null;
                $bonus = 0;
            }
        }else {
            $idPromo = null;
            $bonus = 0;
        }
        
        if($members->SISA_DEPOSIT_MEMBER) {
            $sisa = $members->SISA_DEPOSIT_MEMBER;
        }else {
            $sisa = 0;
        }

        if($request->JUMLAH_UANG < $request->JUMLAH_DEPOSIT_UANG){
            return redirect()->back()->with(['error' => 'Uang anda kurang']);
        }

        $datadepomoney = TransaksiDepositUang::create([
            'ID_PROMO' => $idPromo,
            'ID_MEMBER' => $request->ID_MEMBER,
            'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
            'JUMLAH_DEPOSIT_UANG' => $request->JUMLAH_DEPOSIT_UANG,
            'BONUS_DEPOSIT_UANG' => $bonus,
            'SISA_DEPOSIT_UANG' => $sisa,
            'TOTAL_DEPOSIT_UANG' => $request->JUMLAH_DEPOSIT_UANG + $sisa + $bonus,
            'TANGGAL_DEPOSIT_UANG' => Carbon::now(),
            'KEMBALIAN' => $request->JUMLAH_UANG - $request->JUMLAH_DEPOSIT_UANG
        ]);

        if($datadepomoney){
            $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
            $member->SISA_DEPOSIT_MEMBER = $request->JUMLAH_DEPOSIT_UANG + $sisa + $bonus;
            $member->update();
            $data = TransaksiDepositUang::latest('ID_TRANSAKSI_DEPOSIT_UANG')->first();
            return redirect()->intended('transaksiDepositUangStruk/'.$data->ID_TRANSAKSI_DEPOSIT_UANG);
        }else {
            return redirect()->intended('transaksiDepositUang')->with(['error' => 'Gagal deposit member']);
        }
    }

    public function indexKonfirmasiUang(Request $request){
        $this->validate($request,[
            'ID_MEMBER' => 'required',
            'JUMLAH_DEPOSIT_UANG' => ['required','numeric'],
        ],[
            'ID_MEMBER.required' => 'The member field is required',
            'JUMLAH_DEPOSIT_UANG.required' => 'The nominal field is required',
            'JUMLAH_DEPOSIT_UANG.numeric' => 'Format nominal is numeric'
        ]);

        $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        
        return view('transaksiDepositUang/konfirmasiDepositUangPage')->with([
            'user' => Auth::guard('pegawai')->user(),
            'member' => $member,
            'jumlah_deposit' => $request->JUMLAH_DEPOSIT_UANG
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
