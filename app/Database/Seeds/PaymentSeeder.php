<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'order_id' => 1,
                'metode_pembayaran' => 'QRIS',
                'jumlah_bayar' => 43000,
                'status_pembayaran' => 'Lunas'
            ],
        ];

        $this->db->table('payments')->insertBatch($data);
    }
}
