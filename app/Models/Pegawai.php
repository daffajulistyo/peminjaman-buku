<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama', 'nip', 'opd', 'bidang', 'jabatan', 'pangkat', 'status', 'no_hp'
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    // Definisikan relasi dengan model Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    // Definisikan relasi dengan model Pangkat
    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class);
    }

    // Definisikan relasi dengan model Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
