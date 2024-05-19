<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = "absensis";
    protected $fillable = [
        'tanggal', 'jam_masuk', 'jam_keluar', 'user_id', 'opd_id', 'jabatan_id'
    ];




    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
