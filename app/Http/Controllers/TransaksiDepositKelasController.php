<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAktivasi;
use App\Models\TransaksiDepositKelas;
use App\Models\MemberDepositKelas;
use App\Models\Member;
use App\Models\Pegawai;
use App\Models\Kelas;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiDepositKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksiDepositKelas = TransaksiDepositKelas::orderBy('ID_TRANSAKSI_DEPOSIT_KELAS','asc')->paginate(10);
        $kelas = Kelas::all();

        return view('transaksiDepositKelas.transaksiDepositKelasPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiDepositKelas' => $transaksiDepositKelas, 
            'kelas' => $kelas,
        ]);
    }
    
    public function cetakStruk($id){
    
        $transaksiDepositKelas = TransaksiDepositKelas::where('ID_TRANSAKSI_DEPOSIT_KELAS',$id)->first();

        return view('transaksiDepositKelas.transaksiDepositKelasStruk')->with([
            'depositKelas' => $transaksiDepositKelas,
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
        $kelas = Kelas::all();

        return view('transaksiDepositKelas.addTransaksiDepositKelasPage')->with ([
            'pegawai'=> Auth::guard('pegawai')->user(),
            'member' => $member,
            'kelas' => $kelas,
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
    //         'ID_KELAS' => ['required'],
    //         'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
    //     ],[
    //         'ID_MEMBER.required' => 'The member name field is required',
    //         'ID_KELAS.required' => 'The kelas name field is required',
    //         'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
    //         'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric'
    //     ]);

    //     $dataDepoKelas = TransaksiDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->orderby('ID_TRANSAKSI_DEPOSIT_KELAS','desc')->first();
        
    //     $cekMemberAktivasi = Member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();
    //     if(!($cekMemberAktivasi)) {
    //         return redirect()->intended('transaksiDepositKelas')->with(['error' => 'Member belum diaktivasi, harap aktivasi dulu']);
    //     }

    //     $member_deposit = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();
    //     if($member_deposit){
    //         if($member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPOSIT != 0 || $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPOSIT == 0 || $member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPOSIT == 0) {
    //             $member_deposit->SISA_DEPOSIT = 0;
    //             $member_deposit->MASA_BERLAKU = null;
    //             $member_deposit->update();
    //         }else {
    //             return redirect()->intended('transaksiDepositKelas')->with(['error' => 'Gagal deposit kelas (Member tidak bisa deposit sebelum tanggal expired kelas atau sisa deposit = 0)']);
    //         }
    //     }

        
    //     if($request->JUMLAH_DEPOSIT_KELAS == 5 || $request->JUMLAH_DEPOSIT_KELAS == 10 ) {
    //         $promo = Promo::where('MINIMAL_PEMBELIAN',$request->JUMLAH_DEPOSIT_KELAS)->first();
    //         if($promo) {
    //             if($promo->MINIMAL_PEMBELIAN == 5) {
    //                 $month = 1;
    //             }else {
    //                 $month=2;
    //             }
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

    //     $kelas = Kelas::where('ID_KELAS',$request->ID_KELAS)->first();

    //     $dataDepoKelas = TransaksiDepositKelas::create([
    //         'ID_MEMBER' => $request->ID_MEMBER,
    //         'ID_PROMO' => $idPromo,
    //         'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
    //         'ID_KELAS' => $request->ID_KELAS,
    //         'JUMLAH_DEPOSIT_KELAS'=> $request->JUMLAH_DEPOSIT_KELAS,
    //         'TANGGAL_DEPOSIT_KELAS' => Carbon::now(),
    //         'BONUS_DEPOSIT_KELAS' => $bonus,
    //         'TOTAL_DEPOSIT_KELAS' => $request->JUMLAH_DEPOSIT_KELAS + $bonus,
    //         'JUMLAH_PEMBAYARAN'=> $kelas->HARGA_KELAS * $request->JUMLAH_DEPOSIT_KELAS,
    //         'MASA_BERLAKU_KELAS' => Carbon::now()->addMonths($month),
    //     ]);

    //     if($dataDepoKelas){
    //         $member_deposit2 = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();

    //         if($member_deposit2){
    //             $member_deposit2->SISA_DEPOSIT = $request->JUMLAH_DEPOSIT_KELAS + $bonus;
    //             $member_deposit2->MASA_BERLAKU = Carbon::now()->addMonths($month);
    //             $member_deposit2->update();
    //         }else {
    //             $member_deposit_create = MemberDepositKelas::create([
    //                 'ID_MEMBER'=>$request->ID_MEMBER,
    //                 'ID_KELAS'=> $request->ID_KELAS,
    //                 'SISA_DEPOSIT'=> $request->JUMLAH_DEPOSIT_KELAS + $bonus,
    //                 'MASA_BERLAKU'=> Carbon::now()->addMonths($month),
    //             ]);
    //         }
            
    //         $data = TransaksiDepositKelas::latest('ID_TRANSAKSI_DEPOSIT_KELAS')->first();
    //         return redirect()->intended('transaksiDepositKelasStruk/'.$data->ID_TRANSAKSI_DEPOSIT_KELAS);
    //     }else {
    //         return redirect()->intended('transaksiDepositKelas')->with(['error' => 'Gagal deposit member']);
    //     }

        
    // }


    public function store(Request $request){
        $validate = $request->validate([
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
            'JUMLAH_UANG' => ['required']
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'ID_KELAS.required' => 'The kelas name field is required',
            'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
            'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric',
            'JUMLAH_UANG.required' => 'The pay cost field is required'
        ]);

        $datadepoclass = TransaksiDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->orderby('ID_TRANSAKSI_DEPOSIT_KELAS','desc')->first();
        
        $member_check_activate = Member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();
        if(!($member_check_activate)) {
            return redirect()->intended('   transaksiDepositkelas')->with(['error' => 'Member Belum diaktivasi']);
        }

        $member_deposit = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();
        if($member_deposit){
            if($member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPOSIT != 0 || $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPOSIT == 0 || $member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPOSIT == 0) {
                $member_deposit->SISA_DEPOSIT = 0;
                $member_deposit->MASA_BERLAKU = null;
                $member_deposit->update();
            }else {
                return redirect()->intended('transaksiDepositKelas')->with(['error' => 'Gagal deposit kelas (Member tidak bisa deposit sebelum tanggal expired kelas atau sisa deposit = 0)']);
            }
        }

        
        if($request->JUMLAH_DEPOSIT_KELAS == 5 || $request->JUMLAH_DEPOSIT_KELAS == 10 ) {
            $promo = Promo::where('MINIMAL_PEMBELIAN',$request->JUMLAH_DEPOSIT_KELAS)->first();
            if($promo) {
                if($promo->MINIMAL_PEMBELIAN == 5) {
                    $month = 1;
                }else {
                    $month=2;
                }
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

        $kelas = Kelas::where('ID_KELAS',$request->ID_KELAS)->first();

        if($request->JUMLAH_UANG < ($kelas->HARGA_KELAS * $request->JUMLAH_DEPOSIT_KELAS)){
            return redirect()->back()->with(['error' => 'Your money is less']);
        }

        $datadepoclass = TransaksiDepositKelas::create([
            'ID_MEMBER' => $request->ID_MEMBER,
            'ID_PROMO' => $idPromo,
            'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
            'ID_KELAS' => $request->ID_KELAS,
            'JUMLAH_DEPOSIT_KELAS'=> $request->JUMLAH_DEPOSIT_KELAS,
            'TANGGAL_DEPOSIT_KELAS' => Carbon::now(),
            'BONUS_DEPOSIT_KELAS' => $bonus,
            'TOTAL_DEPOSIT_KELAS' => $request->JUMLAH_DEPOSIT_KELAS + $bonus,
            'JUMLAH_PEMBAYARAN'=> $kelas->HARGA_KELAS * $request->JUMLAH_DEPOSIT_KELAS,
            'MASA_BERLAKU_KELAS' => Carbon::now()->addMonths($month),
            'KEMBALIAN' => $request->JUMLAH_UANG - ($kelas->HARGA_KELAS * $request->JUMLAH_DEPOSIT_KELAS)
        ]);

        if($datadepoclass){
            $member_deposit2 = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();

            if($member_deposit2){
                $member_deposit2->SISA_DEPOSIT = $request->JUMLAH_DEPOSIT_KELAS + $bonus;
                $member_deposit2->MASA_BERLAKU = Carbon::now()->addMonths($month);
                $member_deposit2->update();
            }else {
                $member_deposit_create = MemberDepositKelas::create([
                    'ID_MEMBER'=>$request->ID_MEMBER,
                    'ID_KELAS'=> $request->ID_KELAS,
                    'SISA_DEPOSIT'=> $request->JUMLAH_DEPOSIT_KELAS + $bonus,
                    'MASA_BERLAKU'=> Carbon::now()->addMonths($month),
                ]);
            }
            
            $data = TransaksiDepositKelas::latest('ID_TRANSAKSI_DEPOSIT_KELAS')->first();
            return redirect()->intended('transaksiDepositKelasStruk/'.$data->ID_TRANSAKSI_DEPOSIT_KELAS);
        }else {
            return redirect()->intended('transaksiDepositKelas')->with(['error' => 'Gagal deposit member']);
        }
    }

    public function indexKonfirmasiKelas(Request $request){
        $this->validate($request,[
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'ID_KELAS.required' => 'The kelas name field is required',
            'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
            'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric'
        ]);

        $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        $kelas = Kelas::where('ID_KELAS',$request->ID_KELAS)->first();
        
        return view('transaksiDepositKelas/konfirmasiDepositKelasPage')->with([
            'user' => Auth::guard('pegawai')->user(),
            'member' => $member,
            'ID_KELAS' => $request->ID_KELAS,
            'NAMA_KELAS' => $kelas->NAMA_KELAS,
            'JUMLAH_DEPOSIT_KELAS' => $request->JUMLAH_DEPOSIT_KELAS,
            'BIAYA' => $request->JUMLAH_DEPOSIT_KELAS * $kelas->HARGA_KELAS
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
