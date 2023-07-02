<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class MemberDepositKelas extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'deposit_kelas';
    protected $primaryKey = 'ID_DEPOSIT_KELAS';
    protected $guard = 'member';

    protected $hidden = ["remember_token"];
    
    protected $casts = [
        "email_vefiried_at" => "datetime",
    ];

    protected $fillable = [
        'ID_DEPOSIT_KELAS',
        'ID_MEMBER',
        'ID_KELAS',
        'SISA_DEPOSIT',
        'MASA_BERLAKU',
        'TELEPON_MEMBER',
        'EMAIL_MEMBER',
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

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas','ID_KELAS');
    }

}
