<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Kelas extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'kelas';
    protected $primaryKey = 'ID_KELAS';
    // protected $guard = 'kelas';
    // protected $keyType = 'string';

    protected $hidden = ["remember_token"];
    

    protected $fillable = [
        'NAMA_KELAS',
        'HARGA_KELAS',
        'KAPASITAS_KELAS',
    ];

}
