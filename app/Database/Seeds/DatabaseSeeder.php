<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('CustomerSeeder');
        $this->call('ProdukSeeder');
        $this->call('OrderSeeder');
        $this->call('OrderDetailSeeder');
        $this->call('PaymentSeeder');
    }
}
