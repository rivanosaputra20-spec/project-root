<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Home extends BaseController
{
    /**
     * Halaman Dashboard Utama
     */
    public function index()
    {
        // Jika belum login, redirect ke login (opsional, sudah dijaga filter)
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $produkModel = new ProdukModel();
        
        $data = [
            'title'          => 'Dashboard - Kopi Kita',
            'user'           => session()->get('username'),
            'produk_populer' => $produkModel->findAll(), // Ambil 4 produk saja
        ];

       
        return view('dashboard/index', $data);
    }

    
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}