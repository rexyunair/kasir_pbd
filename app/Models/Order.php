<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders'; // Tentukan nama tabel untuk model Order

    protected $fillable = [
        'kode_barang', // FK ke tabel barang
        'user_id',     // FK ke tabel users, jika aplikasi mendukung login
        'quantity',    // Jumlah barang yang dipesan
        'harga_jual',  // Harga jual per unit saat transaksi
        'total_harga', // Total harga, dapat dihitung dari quantity * harga_jual
        'tanggal_order' // Tanggal dan waktu pembuatan order
    ];

    public $timestamps = true; // Aktifkan timestamp untuk created_at dan updated_at

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'KodeBarang');
    }

    // Relasi dengan User, jika ada fitur user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
