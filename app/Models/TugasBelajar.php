<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasBelajar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'opd_id',
        'jabatan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
    ];

    protected $table = 'tugas_belajar';

    // Mendapatkan opd_id dan jabatan_id dari user saat menyimpan tugas belajar
    public static function boot()
    {
        parent::boot();

        static::creating(function ($tugasBelajar) {
            $tugasBelajar->opd_id = $tugasBelajar->user->opd_id;
            $tugasBelajar->jabatan_id = $tugasBelajar->user->jabatan_id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
