<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JadwalHarianController;
use App\Http\Controllers\TransaksiAktivasiController;
use App\Http\Controllers\TransaksiDepositUangController;
use App\Http\Controllers\TransaksiDepositKelasController;
use App\Http\Controllers\IzinInstrukturController;
use App\Http\Controllers\BookingKelasController;
use App\Http\Controllers\BookingGymController;
use App\Http\Controllers\LaporanController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//INDEX AWAL/LANDING PAGE
Route::get("/", [LoginController::class, "index"]);

//AUTENTIKASI
Route::post("/login", [LoginController::class,"login"]);
Route::get("/logout", [LoginController::class,"logout"]);

//DASHBOARD UTAMA
Route::get("/dashboard", [DashboardController::class, "index"]);


//MEMBER
Route::get("/member", [MemberController::class, "index"]);
Route::post("/createMember",[MemberController::class, "store"]);
Route::get("/addMemberPage",[MemberController::class, "create"]);
Route::get("/editMember/{id}",[MemberController::class,"edit"]);
Route::put("/editMemberPage/{id}",[MemberController::class,"update"]);
Route::delete("/deleteMember/{id}",[MemberController::class,"destroy"]);
Route::get("/searchMember",[MemberController::class,"search"]);
Route::get("/cetakMemberCard/{id}",[MemberController::class,"cetakMemberCard"]);
Route::get("/resetPasswordMember/{id}",[MemberController::class,"resetPasswordMember"]);

//INSTRUKTUR
Route::get("/instruktur", [InstrukturController::class, "index"]);
Route::post("/createInstruktur",[InstrukturController::class, "store"]);
Route::get("/addInstrukturPage",[InstrukturController::class, "create"]);
Route::get("/editInstruktur/{id}",[InstrukturController::class,"edit"]);
Route::put("/editInstrukturPage/{id}",[InstrukturController::class,"update"]);
Route::delete("/deleteInstruktur/{id}",[InstrukturController::class,"destroy"]);
Route::get("/searchInstruktur",[InstrukturController::class,"search"]);

//JADWAL REGULER
Route::get("/jadwal", [JadwalController::class, "index"]);
Route::post("/createJadwal", [JadwalController::class, "store"]);
Route::get("/addJadwalPage", [JadwalController::class, "create"]);
Route::get("/editJadwal/{id}", [JadwalController::class, "edit"]);
Route::put("/editJadwalPage/{id}", [JadwalController::class, "update"]);
Route::delete("/deleteJadwal/{id}", [JadwalController::class, "destroy"]);

//JADWAL HARIAN
Route::get("/jadwalHarian", [JadwalHarianController::class, "index"]);
Route::get("/generatejadwalHarian", [JadwalHarianController::class, "generateJadwalHarian"]);
Route::post("/createJadwalHarian", [JadwalHarianController::class, "store"]);
Route::get("/editJadwalHarian/{id}", [JadwalHarianController::class, "edit"]);
Route::put("/editJadwalHarianPage/{id}", [JadwalHarianController::class, "update"]);
Route::delete("/deleteJadwalHarian/{id}", [JadwalHarianController::class, "destroy"]);
Route::get("/searchJadwalHarian",[JadwalHarianController::class,"search"]);

//TRANSAKSI AKTIVASI
Route::get("/transaksiAktivasi", [TransaksiAktivasiController::class, "index"]);
Route::get("/konfirmasiTransaksiAktivasi", [TransaksiAktivasiController::class, "indexAktivasi"]);
Route::get("/transaksiAktivasiStruk/{id}",[TransaksiAktivasiController::class,"cetakStruk"]);
Route::get("/createTransaksiAktivasi",[TransaksiAktivasiController::class, "create"]);
Route::post("/addTransaksiAktivasi",[TransaksiAktivasiController::class, "store"]);

//TRANSAKSI DEPOSIT UANG
Route::get("/transaksiDepositUang", [TransaksiDepositUangController::class, "index"]);
Route::get("/konfirmasiDepositUang", [TransaksiDepositUangController::class, "indexKonfirmasiUang"]);
Route::get("/transaksiDepositUangStruk/{id}",[TransaksiDepositUangController::class,"cetakStruk"]);
Route::get("/createTransaksiDepositUang",[TransaksiDepositUangController::class, "create"]);
Route::post("/addTransaksiDepositUang",[TransaksiDepositUangController::class, "store"]);


//TRANSAKSI DEPOSIT KELAS
Route::get("/transaksiDepositKelas", [TransaksiDepositKelasController::class, "index"]);
Route::get("/konfirmasiDepositKelas", [TransaksiDepositKelasController::class, "indexKonfirmasiKelas"]);
Route::get("/transaksiDepositKelasStruk/{id}",[TransaksiDepositKelasController::class,"cetakStruk"]);
Route::get("/createTransaksiDepositKelas",[TransaksiDepositKelasController::class, "create"]);
Route::post("/addTransaksiDepositKelas",[TransaksiDepositKelasController::class, "store"]);


//IZIN INSTRUKTUR
Route::get("/izinInstruktur", [IzinInstrukturController::class, "index"]);
Route::get("/konfirmasiIzinInstruktur/{id}", [IzinInstrukturController::class, "update"]);


//Deaktivasi Member
Route::get("/deaktivasiMember", [MemberController::class, "deaktivasiMemberIndex"]);
Route::get("/deaktivasiMember/{id}", [MemberController::class, "deaktivasiMember"]);


//Reset Kelas
Route::get("/resetKelas", [MemberController::class, "resetKelasIndex"]);
Route::get("/resetKelasTombol", [MemberController::class, "resetKelas"]);



//Reset Terlambat
Route::get("/resetTerlambat", [InstrukturController::class, "resetTerlambatIndex"]);
Route::get("/resetTerlambatInstruktur", [InstrukturController::class, "resetTerlambatInstruktur"]);

//BOOKING PRESENSI KELAS

Route::get("/presensiBookingKelas",[BookingKelasController::class,"index"]);
Route::get("/cetakPresensiBookingKelas/{id}",[BookingKelasController::class,"booking_receipt"]);


//BOOKING PRESENSI GYM
Route::get("/presensiBookingGym",[BookingGymController::class,"index"]);
Route::get("/konfirmasiBookingGym/{id}",[BookingGymController::class,"konfirmasiGym"]);
Route::get("/cetakPresensiBookingGym/{id}",[BookingGymController::class,"booking_receipt"]);

//LAPORAN
Route::get("/laporanGym",[LaporanController::class,"index_gym_activity_report"]);
Route::get("/laporanGymProcess",[LaporanController::class,"gym_activity_report"]);

Route::get("/laporanKelas",[LaporanController::class,"index_class_activity_report"]);
Route::get("/laporanKelasProcess",[LaporanController::class,"class_activity_report"]);

Route::get("/laporanPendapatan",[LaporanController::class,"index_income_report"]);
Route::get("/laporanPendapatanProcess",[LaporanController::class,"income_report"]);

Route::get("/laporanKinerjaInstruktur",[LaporanController::class,"index_instructor_report"]);
Route::get("/laporanKinerjaInstrukturProcess",[LaporanController::class,"instructor_report"]);