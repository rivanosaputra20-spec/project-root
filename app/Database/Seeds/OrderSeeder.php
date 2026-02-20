<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'customer_id' => 1,
                'total_harga' => 43000,
                'status' => 'selesai'
            ],
            [
                'customer_id' => 2,
                'total_harga' => 25000,
                'status' => 'proses'
            ],
        ];

        $this->db->table('orders')->insertBatch($data);
    }
}
