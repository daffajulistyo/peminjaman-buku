<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'opd_id');
    }
    public function koordinats()
    {
        return $this->hasMany(Koordinat::class, 'opd_id');
    }

    public function bidangs(){
        return $this->hasMany(Bidang::class, 'opd_id');
    }

    public function jabatans(){
        return $this->hasMany(Jabatan::class, 'opd_id');
    }
}
