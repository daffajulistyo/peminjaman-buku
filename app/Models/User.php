<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Opd;
use App\Models\Bidang;
use App\Models\Pangkat;
use App\Models\Jabatan;
use App\Models\Absensi;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'status',
        'nohp',
        'opd_id',
        'bidang_id',
        'jabatan_id',
        'pangkat_id',
        'eselon_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class);
    }
    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }
    public function dinas()
    {
        return $this->hasMany(Dinas::class);
    }
    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }
    public function izin()
    {
        return $this->hasMany(Izin::class);
    }
    public function sakit()
    {
        return $this->hasMany(Sakit::class);
    }
}
