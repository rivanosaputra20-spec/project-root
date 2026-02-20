<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table            = 'order_details';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['order_id', 'product_id', 'qty', 'subtotal'];
    protected $useTimestamps    = true;

    // Fungsi untuk mengambil item-item berdasarkan ID pesanan
    public function getDetailByOrder($orderId)
    {
        return $this->select('order_details.*, products.nama_produk, products.harga')
                    ->join('products', 'products.id = order_details.product_id')
                    ->where('order_id', $orderId)
                    ->findAll();
    }
}