<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    public function index()
    {
        $model = new ProdukModel();
        
        $data = [
            'title' => 'Daftar Menu - Kopi Kita',
            // Kita ambil semua produk
            'produk' => $model->findAll(),
            // Kita buat daftar kategori unik untuk filter
            'kategori' => ['Coffee', 'Non-Coffee', 'Pastry', 'Snack']
        ];

        return view('produk/index', $data);
    }
}