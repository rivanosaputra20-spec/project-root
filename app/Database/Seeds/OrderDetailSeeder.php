<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'order_id'   => 1,
                'product_id' => 1,
                'qty'        => 1, // Ganti 'jumlah' menjadi 'qty' agar sinkron
                'subtotal'   => 18000
            ],
            [
                'order_id'   => 1,
                'product_id' => 5,
                'qty'        => 1, // Ganti 'jumlah' menjadi 'qty' agar sinkron
                'subtotal'   => 20000
            ],
        ];

        $this->db->table('order_details')->insertBatch($data);
    }
}