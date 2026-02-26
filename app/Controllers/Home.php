<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\TransaksiModel;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $transaksiModel = new TransaksiModel();
        $produkModel = new ProdukModel();

        // Menggunakan try-catch atau pengecekan manual untuk menghindari error column
        $revenueData = $transaksiModel->selectSum('total_harga')->first();
        
        $data = [
            'title'         => 'Dashboard Overview',
            'user'          => session()->get('username'),
            'role'          => session()->get('role'),
            'totalRevenue'  => $revenueData['total_harga'] ?? 0,
            'totalOrders'   => $transaksiModel->countAll(),
            'totalProducts' => $produkModel->countAll(),
            'recentOrders'  => $transaksiModel->orderBy('created_at', 'DESC')->findAll(5),
            'topProducts'   => $produkModel->orderBy('stok', 'ASC')->findAll(4)
        ];

        if (session()->get('role') == 'admin') {
            return view('dashboard/admin_index', $data);
        }

        return view('dashboard/index', $data);
    }
}