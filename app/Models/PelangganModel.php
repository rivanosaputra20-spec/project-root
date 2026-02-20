<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table      = 'customers'; // Nama tabel di phpMyAdmin kamu
    protected $primaryKey = 'id';
    
    // Sesuaikan dengan kolom: id, nama, email, no_hp
    protected $allowedFields = ['nama', 'email', 'no_hp'];
    
    protected $useTimestamps = false; // Set false jika di tabel customers tidak ada created_at
}