<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class BookingKelas extends Authenticatable
{
    protected $table = 'booking_presensi_kelas';
    protected $primaryKey = 'KODE_BOOKING';
    protected $keyType = 'string';

    protected $fillable = [
        'ID_MEMBER',
        'TANGGAL_JADWAL_HARIAN',
        'TANGGAL_MELAKUKAN_BOOKING',
        'TARIF_KELAS',
        'WAKTU_PRESENSI_KELAS',
        'STATUS_PRESENSI_KELAS',
    ];

    public function getCreatedAtAttribute() {
        if(!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdateAtAtrribute() {
        if(!is_null($this->attributes['update_at'])) {
            return Carbon::parse($this->attributes['update_at'])->format('Y-m-d H:i:s');
        }
    }

    protected function serializeDate(\DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member','ID_MEMBER');
    }

    public function jadwal_harian()
    {
        return $this->belongsTo('App\Models\JadwalHarian','TANGGAL_JADWAL_HARIAN');
    }
}
