<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    use HasFactory;

    protected $fillable = ['nama_rute', 'stasiun_asal_id', 'stasiun_tujuan_id'];

    public function stasiunAsal()
    {
        return $this->belongsTo(Stasiun::class, 'stasiun_asal_id');
    }
    public function stasiunTujuan()
    {
        return $this->belongsTo(Stasiun::class, 'stasiun_tujuan_id');
    }
}
