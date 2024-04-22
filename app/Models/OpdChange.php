<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpdChange extends Model
{
    protected $table = 'opd_changes';

    protected $fillable = [
        'user_id',
        'old_opd_id',
        'new_opd_id',
        'tanggal_pindah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function oldOpd()
    {
        return $this->belongsTo(Opd::class, 'old_opd_id');
    }

    public function newOpd()
    {
        return $this->belongsTo(Opd::class, 'new_opd_id');
    }
}
