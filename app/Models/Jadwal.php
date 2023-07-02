<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Jadwal extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'jadwal_reguler';
    protected $primaryKey = 'ID_JADWAL_REGULER';


    protected $hidden = ["remember_token"];
    
    protected $casts = [
        "email_vefiried_at" => "datetime",
    ];
    protected $fillable = [
        'ID_KELAS',
        'ID_INSTRUKTUR',
        'HARI_JADWAL_UMUM',
        'SESI_JADWAL_UMUM',
        'TANGGAL_JADWAL_UMUM',
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

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas','ID_KELAS');
    }

}

