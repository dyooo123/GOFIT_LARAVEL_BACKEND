<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class JadwalHarian extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'jadwal_harian';
    protected $primaryKey = 'TANGGAL_JADWAL_HARIAN';
    protected $keyType = 'datetime';

    protected $fillable = [
        'TANGGAL_JADWAL_HARIAN',
        'ID_INSTRUKTUR',
        'ID_JADWAL_UMUM',
        'STATUS_JADWAL_HARIAN',
        'expired_at',
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

    public function jadwal()
    {
        return $this->belongsTo('App\Models\Jadwal','ID_JADWAL_UMUM');
    }

    protected function serializeDate(\DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }


}
