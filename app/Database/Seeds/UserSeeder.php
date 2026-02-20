<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
   public function run()
{
    // Matikan pengecekan relasi agar bisa menghapus data
    $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
    $this->db->table('users')->truncate();
    $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

    $data = [
        [
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'username'   => 'kasir',
            'password'   => password_hash('kasir123', PASSWORD_DEFAULT),
            'role'       => 'user',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
    ];

    $this->db->table('users')->insertBatch($data);
}
}