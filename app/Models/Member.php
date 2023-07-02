<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'member';
    protected $primaryKey = 'ID_MEMBER';
    protected $guard = 'member';
    protected $keyType = 'string';

    protected $hidden = ["remember_token"];
    
    protected $casts = [
        "email_vefiried_at" => "datetime",
    ];

    protected $fillable = [
        'NAMA_MEMBER',
        'ALAMAT_MEMBER',
        'UMUR_MEMBER',
        'TANGGAL_LAHIR_MEMBER',
        'TELEPON_MEMBER',
        'EMAIL_MEMBER',
        'password',
        'MASA_AKTIVASI',
        'SISA_DEPOSIT_MEMBER',
        'SISA_DEPOSIT_KELAS',
        'EXPIRED_KELAS',
        'TANGGAL_DEAKTIVASI',
        'TANGGAL_RESET_KELAS',
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
