<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pemesanan',
        'user_id',
        'jadwal_id',
        'jumlah_tiket',
        'total_harga',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function tikets()
    {
        return $this->belongsToMany(Tiket::class, 'pemesanan_tiket', 'pemesanan_id', 'tiket_id');
    }
}
