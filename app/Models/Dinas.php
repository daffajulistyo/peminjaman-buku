<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    use HasFactory;

    protected $table = 'dinas';

    protected $fillable = [
        'user_id', 'tanggal','latitude','longitude', 'keterangan', 'tanggal_mulai', 'tanggal_selesai'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
