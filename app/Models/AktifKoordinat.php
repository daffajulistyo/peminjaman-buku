<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktifKoordinat extends Model
{
    use HasFactory;

    protected $table = 'aktif_koordinat';
    protected $fillable = ['active'];

}
