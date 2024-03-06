<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hp extends Model
{
    use HasFactory;

    protected $fillable = ['name','merk','nohp','identitas','odp'];
}
