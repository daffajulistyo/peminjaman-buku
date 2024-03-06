<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = "absen_pegawai";
    protected $fillable = [
        'tanggal', 'jam_masuk', 'jam_keluar', 'user_id'
    ];




    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
