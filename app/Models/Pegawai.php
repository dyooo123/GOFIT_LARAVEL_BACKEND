<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'pegawai';
    protected $primaryKey = 'ID_PEGAWAI';
    protected $guard = 'pegawai';

    protected $hidden = ["remember_token"];
    
    protected $casts = [
        "email_vefiried_at" => "datetime",
    ];

    protected $fillable = [
        'NAMA_PEGAWAI',
        'ALAMAT_PEGAWAI',
        'UMUR_PEGAWAI',
        'ROLE_PEGAWAI',
        'TANGGAL_LAHIR_PEGAWAI',
        'EMAIL_PEGAWAI',
        'password',
        'JENIS_KELAMIN_PEGAWAI',
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