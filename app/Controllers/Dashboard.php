<?php

namespace App\Controllers;

// Panggil Model yang dibutuhkan
use App\Models\ProdukModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // 1. Inisialisasi Model
        $produkModel = new ProdukModel();
        $transaksiModel = new TransaksiModel();

        // 2. Ambil Data Statistik (Contoh sederhana)
        // Menghitung total pendapatan dari kolom 'total_harga'
        $sumPendapatan = $transaksiModel->selectSum('total_harga')->first();
        $total_pendapatan = $sumPendapatan['total_harga'] ?? 0;

        // Menghitung jumlah baris transaksi
        $total_pesanan = $transaksiModel->countAllResults();

        // Contoh statis jika belum ada tabel pelanggan, atau hitung dari transaksi
        $total_pelanggan = $transaksiModel->distinct()->countAllResults('nama_pelanggan');

        // 3. Siapkan Array Data untuk dikirim ke View
        $produkModel = new ProdukModel();
        $transaksiModel = new TransaksiModel();

        $data = [
            'title'              => 'Dashboard | Queejuy Coffee',
            'role'               => session()->get('role'),
            'total_pendapatan'   => $total_pendapatan,
            'total_pesanan'      => $total_pesanan,
            'total_pelanggan'    => $total_pelanggan,
            'produk_populer'     => $produkModel->orderBy('id', 'DESC')->findAll(4), // Ambil 4 produk terbaru
            'transaksi_terakhir' => $transaksiModel->orderBy('created_at', 'DESC')->findAll(5)
        ];

        // 4. Kirim ke View
        return view('dashboard/index', $data);
    }
}