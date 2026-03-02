<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    
    // Pastikan 'total_harga' ada di sini agar bisa disimpan ke database
    // Saya juga menambahkan 'created_at' jika kamu ingin CI4 mengisinya otomatis
    protected $allowedFields    = [
        'nama_pelanggan', 
        'total_harga', 
        'metode_bayar', 
        'status', 
        'created_at', 
        'updated_at'
    ];

    // Aktifkan timestamps agar kolom created_at terisi otomatis saat insert
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}