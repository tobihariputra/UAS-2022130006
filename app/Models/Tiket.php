<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = ['jadwal_id', 'kode_tiket', 'kelas_tiket', 'harga', 'jumlah', 'status'];

    protected $attributes = [
        'status' => 'available', // Default status saat tiket dibuat
    ];

    public function kereta()
    {
        return $this->belongsTo(Kereta::class);
    }
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function pemesanans()
    {
        return $this->belongsToMany(Pemesanan::class, 'pemesanan_tiket', 'tiket_id', 'pemesanan_id');
    }
}
