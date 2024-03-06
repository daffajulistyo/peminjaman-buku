<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Opd;

class Koordinat extends Model
{
    use HasFactory;

    protected $fillable = ['alamat','latitude','longitude','opd_id'];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    
}
