<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Faiq Alkatiri',
                'email' => 'faiq@gmail.com',
                'no_hp' => '08123456789'
            ],
            [
                'nama' => 'Ripa Plenger',
                'email' => 'rina@gmail.com',
                'no_hp' => '08987654321'
            ],
        ];

        $this->db->table('customers')->insertBatch($data);
    }
}
