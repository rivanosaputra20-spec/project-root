<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table      = 'products'; // Sesuaikan dengan yang ada di phpMyAdmin
    protected $primaryKey = 'id';
    // Masukkan semua kolom baru agar bisa dibaca/ditulis
    protected $allowedFields = ['nama_produk', 'kategori', 'harga', 'deskripsi', 'image', 'stok'];
}