<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class IzinInstruktur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'izin';
    protected $primaryKey = 'ID_IZIN_INSTRUKTUR';

    protected $hidden = ["remember_token"];
    
    protected $fillable = [
        'ID_IZIN_INSTRUKTUR',
        'ID_INSTRUKTUR',
        'INSTRUKTUR_PENGGANTI',
        'TANGGAL_IZIN_INSTRUKTUR',
        'TANGGAL_MENGAJUKAN_IZIN',
        'TANGGAL_KONFIRMASI_IZIN',
        'KETERANGAN_IZIN',
        'STATUS_IZIN',
    ];

    public function instruktur()
    {
        return $this->belongsTo('App\Models\Instruktur','ID_INSTRUKTUR');
    }


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

}
