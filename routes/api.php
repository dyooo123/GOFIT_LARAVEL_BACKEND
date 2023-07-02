<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("loginUser", "App\Http\Controllers\LoginController@login");
Route::get("izinInstruktur/{id}", "App\Http\Controllers\IzinInstrukturController@indexIzin");
Route::get(
    "dataJadwalHarian/{id}",
    "App\Http\Controllers\IzinInstrukturController@getDataSchedule"
);
route::post("tambahIzin","App\Http\Controllers\IzinInstrukturController@store");
// Route::resource('izinInstruktur',\App\Http\Controllers\IzinInstrukturController::class);
Route::post(
    "gantiPassword",
    "App\Http\Controllers\LoginController@gantiPassword");
Route::group(   
    ["middleware" => "auth:pegawai-api,member-api,instruktur-api"],
    function () {
        Route::post("logout", "App\Http\Controllers\LoginController@logout");
    }
);

//Jadwal Harian

Route::get(
    "dataJadwal",
    "App\Http\Controllers\JadwalHarianController@index_api"
);


//Booking Gym

Route::post(
    "storeBookingGym",
    "App\Http\Controllers\BookingGymController@store"
);
Route::get(
    "indexGym/{id}",
    "App\Http\Controllers\BookingGymController@indexBookingGym"
);
Route::delete(
    "batalGym/{id}",
    "App\Http\Controllers\BookingGymController@cancelBookingGym"
);

//Booking Kelas
Route::post(
    "storeBookingKelas",
    "App\Http\Controllers\BookingKelasController@store"
);
Route::get(
    "indexKelas/{id}",
    "App\Http\Controllers\BookingKelasController@getDataBooking"
);
Route::delete(
    "batalKelas/{id}",
    "App\Http\Controllers\BookingKelasController@cancelBooking"
);  

Route::get(
    "indexPresensi",
    "App\Http\Controllers\PresensiInstrukturController@index_api_schedule"
);
Route::post("storePresensi","App\Http\Controllers\PresensiInstrukturController@store");

Route::get(
    "dataMember/{id}",
    "App\Http\Controllers\MemberController@getDataMember"
);

Route::get(
    "dataInstruktur/{id}",
    "App\Http\Controllers\InstrukturController@getDataInstruktur"
);



Route::get(
    "historyInstruktur/{id}",
    "App\Http\Controllers\InstrukturController@getAktivitasInstruktur"
);



Route::get('presensiKelas/{id}','App\Http\Controllers\BookingKelasController@index_api_schedule_presence');
Route::get('presensiMember/{id}','App\Http\Controllers\BookingKelasController@index_api_history_presence');
Route::post('updatePresensi','App\Http\Controllers\BookingKelasController@update_transaction');