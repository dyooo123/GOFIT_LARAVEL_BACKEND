<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class TransaksiDepositUang extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'transaksi_deposit_uang';
    protected $primaryKey = 'ID_TRANSAKSI_DEPOSIT_UANG';
    protected $keyType = 'string';



    protected $fillable = [
        'ID_TRANSAKSI_DEPOSIT_UANG', 
        'ID_PROMO',     
        'ID_MEMBER',
        'ID_PEGAWAI',
        'JUMLAH_DEPOSIT_UANG',
        'BONUS_DEPOSIT_UANG',
        'TOTAL_DEPOSIT_UANG',
        'TANGGAL_DEPOSIT_UANG',
        'SISA_DEPOSIT_UANG',
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

    public function promo()
    {
        return $this->belongsTo('App\Models\Promo','ID_PROMO');
    }

}
