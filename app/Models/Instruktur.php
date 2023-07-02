<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Instruktur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'instruktur';
    protected $primaryKey = 'ID_INSTRUKTUR';
    protected $guard = 'instruktur';

    protected $keyType = 'string';

    protected $hidden = ["remember_token"];
    
    protected $casts = [
        "email_vefiried_at" => "datetime",
    ];
    protected $fillable = [
        'NAMA_INSTRUKTUR',
        'ALAMAT_INSTRUKTUR',
        'TELEPON_INSTRUKTUR',
        'UMUR_INSTRUKTUR',
        'JENIS_KELAMIN_INSTRUKTUR',
        'TANGGAL_LAHIR_INSTRUKTUR',
        'EMAIL_INSTRUKTUR',
        'password',
        'JUMLAH_TERLAMBAT',
        'TANGGAL_EXPIRED_TERLAMBAT',
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
    
}
