<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    // WAJIB: Tambahkan 'stok' di sini agar bisa di-update
    protected $allowedFields    = ['nama_produk', 'kategori', 'harga', 'stok', 'deskripsi', 'image'];
}