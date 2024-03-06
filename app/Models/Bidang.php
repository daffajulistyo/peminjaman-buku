<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = ['opd_id','name'];

    public function users()
    {
        return $this->hasMany(User::class, 'bidang_id');
    }

    public function opd() {
        return $this->belongsTo(Opd::class);
    }
}
