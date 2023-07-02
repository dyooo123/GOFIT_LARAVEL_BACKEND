<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\MemberDepositKelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Member::orderBy('ID_MEMBER',)->paginate(5);
        return view('member.memberPage')->with([
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
        //Tampilan Create Member
        return view("member/addMemberPage")->with([
            "pegawai" => Auth::guard("pegawai")->user(),
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

        $validate = $request->validate(
            [
                "NAMA_MEMBER" => ["required"],
                "ALAMAT_MEMBER" => ["required"],
                "UMUR_MEMBER" => ["required"],
                "TANGGAL_LAHIR_MEMBER" => ["required"],
                "TELEPON_MEMBER" => ["required"],
                "EMAIL_MEMBER" => ["required"],
                // "password" => ["required"],
            ],
        );

        $dataMember = $request->all();

        $dataMember["password"] = \bcrypt($request->password);
        $dataMember["MASA_AKTIVASI"] = null;
        $dataMember["SISA_DEPOSIT_MEMBER"] = null;

        $member = Member::create($dataMember);

        session()->flash('success', 'Data member berhasil ditambahkan.');

        if ($member) {
            return redirect()
                ->intended("/member")
                ->with(["success" => "Berhasil Menambahkan Data Member"]);
        }
        return redirect()
            ->intended("/createMember")
            ->with(["error" => "Gagal Menambah Data Member"]);
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
        $member = Member::find($id);
        return view("member/editMemberPage")->with([
            "pegawai" => Auth::guard("pegawai")->user(),
            "member" => $member,
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
        $member = Member::find($id);

        if($request->NAMA_MEMBER) {
            $member->NAMA_MEMBER = $request->NAMA_MEMBER;
        }
        if($request->ALAMAT_MEMBER){
            $member->ALAMAT_MEMBER = $request->ALAMAT_MEMBER;
        }
        if($request->UMUR_MEMBER){
            $member->UMUR_MEMBER = $request->UMUR_MEMBER;
        }
        if($request->TANGGAL_LAHIR_MEMBER){
            $member->TANGGAL_LAHIR_MEMBER = $request->TANGGAL_LAHIR_MEMBER;
        }
        if($request->TELEPON_MEMBER){
            $member->TELEPON_MEMBER = $request->TELEPON_MEMBER;
        }
        if($request->EMAIL_MEMBER){
            $member->EMAIL_MEMBER = $request->EMAIL_MEMBER;
        }
        if($request->password){
            $member->password = \bcrypt ($request->password);
        }


        $member ->update();
        if($member) {
            return redirect()->intended('/member')->with(['success' => 'Berhasil Mengupdate Data Member']);
        }
        return redirect()->intended('/editMember/'.$id)->with(['error' => 'Gagal Mengupdate Data Member']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $member_delete = Member::where('ID_MEMBER',$id)->first();

        $member_delete->delete();
        session()->flash('success', 'Data member berhasil dihapus.');

        if($member_delete) {
            return redirect()->intended('/member')->with(['success' => 'Berhasil Menghapus member']);
        }
        return redirect()->intended('/deleteMember/'.$id)->with(['error' => 'Gagal menghapus member']);
    }

    // public function search(Request $request) {
    //     if($request->search != null) {
    //         $member = Member::where('NAMA_MEMBER',$request->search)->paginate(5);
    //     }
    //     else {
    //         $member = Member::orderby('ID_MEMBER')->paginate(5);
    //     }
        
    //     return view('member.memberPage')->with([
    //         'pegawai' => Auth::guard('pegawai')->user(),
    //         'data' => $member,
    //     ]);
    // }


    public function search(Request $request) {
        $member = Member::where('NAMA_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('EMAIL_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('UMUR_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('ALAMAT_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('TANGGAL_LAHIR_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('TELEPON_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('MASA_AKTIVASI', 'like','%'.$request->search.'%')
        ->orWhere('SISA_DEPOSIT_MEMBER', 'like','%'.$request->search.'%')
        ->orWhere('ID_MEMBER', 'like','%'.$request->search.'%')
        ->paginate(5);
        $member->appends(['search' => $request->search]);
 
    
        return view('member.memberPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'data' => $member,
        ]);
    }

    public function cetakMemberCard($id) {
        $member = Member::where('ID_MEMBER',$id)->first();
        return view('member.cetakMemberCardPage')->with([
            'member' => $member,
            'pegawai' => Auth::guard('pegawai')->user(),       
        ]);
    }

    public function resetPasswordMember($id){
        $member = Member::where('ID_MEMBER',$id)->first();

        $member_update = Member::where('ID_MEMBER', $id)
        ->limit(1) 
        ->update(array('password' => bcrypt($member->TANGGAL_LAHIR_MEMBER))); 

        if($member_update) {
            return redirect()->intended('/member')->with([
                'success' => 'Password Member telah berhasil di reset dengan format (YYYY-MM-DD)',
            ]);
        }else {
            return redirect()->intended('/member')->with([
                'success' => 'Password member gagal di reset'
            ]);
        }
    }

    public function deaktivasiMemberIndex(){
        $member = Member::orderby('ID_MEMBER','desc')->where('MASA_AKTIVASI','<',Carbon::now())->paginate(5);
            return view('member.deaktivasiMemberPage')->with([
            'member' => $member,
            'pegawai' => Auth::guard('pegawai')->user(),
        ]);
    }
    

    public function deaktivasiMember($id){
        $member = member::where("ID_MEMBER",$id)->first();
        
        if($member && $member->TANGGAL_NONAKTIF < Carbon::now() || $member && $member->TANGGAL_NONAKTIF == null ){
            $member->MASA_AKTIVASI = null;
            $member->SISA_DEPOSIT_KELAS = 0;
            $member->SISA_DEPOSIT_MEMBER = 0;
            $member->EXPIRED_KELAS = null;
            $member->TANGGAL_DEAKTIVASI = Carbon::now()->addDays(1);
            $member->update();
            return redirect()->intended('/deaktivasiMember')->with(['success' => 'Berhasil deaktivasi member']);
        }
        return redirect()->intended('/deaktivasiMember')->with(['error' => 'Gagal deaktivasi member']);
    }

    public function resetKelasIndex(){
        $member = MemberDepositKelas::orderby('ID_DEPOSIT_KELAS','desc')->where('MASA_BERLAKU','<',Carbon::now())->paginate(5);
        $member_after = MemberDepositKelas::orderby('ID_DEPOSIT_KELAS','desc')->where('MASA_BERLAKU',null)->paginate(5);
        
        return view('member/resetKelasPage')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'member' => $member,
            'members_after' => $member_after
        ]);
    }

    public function resetKelas(){
        $member = MemberDepositKelas::orderby('ID_DEPOSIT_KELAS','desc')->where('MASA_BERLAKU','<',Carbon::now())->get();
        if($member){
            foreach($member as $member){
                if($member->expired_reset_kelas < Carbon::now() || $member && $member->expired_reset_kelas == null ){
                    $member->SISA_DEPOSIT = 0;
                    $member->MASA_BERLAKU = null;
                    $member->expired_reset_kelas = Carbon::now()->addDays(1);
                    $member->update();
                }else {
                    return redirect()->intended('resetKelas')->with(['error' => 'Gagal Reset paket kelas'.$member->member->NAMA_MEMBER.' class '.$member->kelas->NAMA_KELAS.' karena member bisa dideaktivasi besok']);
                }
            }
            return redirect()->intended('resetKelas')->with(['success' => 'Berhasil Mereset Kelas Paket']);
        }
        return redirect()->intended('resetKelas')->with(['error' => 'Member tidak ditemukan']);
    }


    public function getDataMember(Request $request, $id)
    {
        if ($request->expectsjson()) {


            $members = DB::select(
                'SELECT m.ID_MEMBER, m.NAMA_MEMBER, m.EMAIL_MEMBER, m.MASA_AKTIVASI, m.SISA_DEPOSIT_MEMBER, md.SISA_DEPOSIT FROM member m LEFT JOIN deposit_kelas md ON m.ID_MEMBER = md.ID_MEMBER  WHERE m.ID_MEMBER = "' .
                    $id .
                    '" GROUP BY m.NAMA_MEMBER, md.SISA_DEPOSIT '
            );

            if ($members) {
                return response(
                    [
                        "message" => "Berhasil mengambil data member",
                        "data" => $members,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Member tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }

}
