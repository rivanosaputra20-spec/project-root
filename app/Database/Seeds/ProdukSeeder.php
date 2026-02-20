<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_produk' => 'Espresso',
                'harga' => 18000,
                'stok' => 100
            ],
            [
                'nama_produk' => 'Cappuccino',
                'harga' => 25000,
                'stok' => 100
            ],
            [
                'nama_produk' => 'Latte',
                'harga' => 27000,
                'stok' => 100
            ],
            [
                'nama_produk' => 'Americano',
                'harga' => 22000,
                'stok' => 100
            ],
            [
                'nama_produk' => 'Croissant',
                'harga' => 20000,
                'stok' => 50
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}
