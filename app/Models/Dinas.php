<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    use HasFactory;

    protected $table = 'dinas';

    protected $fillable = [
        'user_id', 'latitude','longitude', 'keterangan', 'tanggal', 'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
