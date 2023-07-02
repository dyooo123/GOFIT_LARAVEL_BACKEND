<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Promo extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'promo';
    protected $primaryKey = 'ID_PROMO';
    // protected $guard = 'kelas';
    // protected $keyType = 'string';

    

    protected $fillable = [
        'ID_PROMO',
        'NAMA_PROMO',
        'TANGGAL_MULAI_PROMO',
        'TANGGAL_SELESAI_PROMO',
        'KETERANGAN_PROMO',
        'MINIMAL_PEMBELIAN',
        'JENIS_PROMO',
        'BONUS',

    ];
}
