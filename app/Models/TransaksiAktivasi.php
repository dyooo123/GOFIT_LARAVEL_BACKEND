<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class TransaksiAktivasi extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'transaksi_aktivasi';
    protected $primaryKey = 'ID_TRANSAKSI_AKTIVASI';
    protected $keyType = 'string';

    protected $fillable = [
        'ID_TRANSAKSI_AKTIVASI',
        'ID_MEMBER',
        'ID_PEGAWAI',
        'TANGGAL_TRANSAKSI_AKTIVASI',
        'TANGGAL_EXPIRED_TRANSAKSI_AKTIVASI',
        'BIAYA_AKTIIVASI',
        'STATUS_TRANSAKSI_AKTIVASI',
        'KEMBALIAN',

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

}
