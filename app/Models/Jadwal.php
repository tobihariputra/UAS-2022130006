<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = ['kereta_id', 'rute_id', 'waktu_berangkat', 'waktu_tiba'];

    // Relasi dengan Tiket
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'jadwal_id');
    }

    // Relasi dengan Kereta
    public function kereta()
    {
        return $this->belongsTo(Kereta::class);
    }

    // Relasi dengan Rute
    public function rute()
    {
        return $this->belongsTo(Rute::class);
    }
}
