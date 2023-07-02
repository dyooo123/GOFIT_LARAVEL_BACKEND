<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class TransaksiDepositKelas extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'transaksi_deposit_kelas';
    protected $primaryKey = 'ID_TRANSAKSI_DEPOSIT_KELAS';
    protected $keyType = 'string';

    protected $fillable = [
        'ID_TRANSAKSI_DEPOSIT_KELAS',
        'ID_MEMBER',
        'ID_PROMO',
        'ID_PEGAWAI',
        'ID_KELAS',
        'JUMLAH_DEPOSIT_KELAS',
        'TANGGAL_DEPOSIT_KELAS',
        'BONUS_DEPOSIT_KELAS',
        'TOTAL_DEPOSIT_KELAS',
        'JUMLAH_PEMBAYARAN',
        'KEMBALIAN',
        'MASA_BERLAKU_KELAS',
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

    public function member()
    {
        return $this->belongsTo('App\Models\Member','ID_MEMBER');
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai','ID_PEGAWAI');
    }

    public function promo()
    {
        return $this->belongsTo('App\Models\Promo','ID_PROMO');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas','ID_KELAS');
    }

}
