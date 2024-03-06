<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $fillable = ['opd_id','name'];

    public function users()
    {
        return $this->hasMany(User::class, 'jabatan_id');
    }

    public function opd() {
        return $this->belongsTo(Opd::class);
    }
}
