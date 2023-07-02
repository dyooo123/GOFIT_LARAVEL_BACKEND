<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class PresensiInstruktur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'presensi_instruktur';
    protected $primaryKey = 'ID_PRESENSI_INSTRUKTUR';


    protected $hidden = ["remember_token"];
    
    
    protected $fillable = [
        'ID_INSTRUKTUR',
        'TANGGAL_MENGAJAR',
        'WAKTU_TERLAMBAT',
        'JAM_MULAI',
        'JAM_SELESAI',
        'DURASI_KELAS',
    ];


    public function getCreatedAtAttribute()
    {
        if (!is_null($this->attributes["created_at"])) {
            return Carbon::parse($this->attributes["created_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function getUpdatedAtAttribute()
    {
        if (!is_null($this->attributes["updated_at"])) {
            return Carbon::parse($this->attributes["updated_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    
    }

    public function instruktur()
    {
        return $this->belongsTo('App\Models\Instruktur','ID_INSTRUKTUR');
    }
}
