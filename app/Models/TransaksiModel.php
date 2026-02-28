<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_pelanggan', 'total_harga', 'total', 'metode_bayar', 'status'];
    protected $useTimestamps = true; // Ini harus true karena kita pakai created_at & updated_at
}