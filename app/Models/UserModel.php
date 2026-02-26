<?php

// Isi file app/Models/UserModel.php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users'; // Sesuaikan nama tabelmu
    protected $primaryKey = 'id';
    
    // PASTIKAN 'user_image' ADA DI SINI!
    protected $allowedFields = ['username', 'password', 'role', 'user_image']; 
}