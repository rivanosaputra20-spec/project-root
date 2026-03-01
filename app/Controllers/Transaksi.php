<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    public function index()
    {
        $model = new ProdukModel();
        
        // Ambil kategori unik untuk filter navigasi
        $produkAll = $model->findAll();
        $kategori = array_unique(array_column($produkAll, 'kategori'));

        return view('transaksi/index', [
            'title'    => 'Order Menu',
            'produk'   => $produkAll,
            'kategori' => $kategori,
            'role'     => session()->get('role'), // WAJIB: Agar View tahu siapa yang sedang login
            'cart'     => session()->get('cart') ?? []
        ]);
    }

    public function addToCart($id)
    {
        // Proteksi: Jika admin mencoba menambah ke keranjang via URL/AJAX, tolak!
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON([
                'status'  => 'error', 
                'message' => 'Admin hanya diizinkan memantau menu.'
            ], 403);
        }

        $model = new ProdukModel();
        $produk = $model->find($id);

        if ($produk) {
            // Cek apakah stok masih ada
            if ($produk['stok'] <= 0) {
                return $this->response->setJSON([
                    'status'  => 'error', 
                    'message' => 'Maaf, stok habis!'
                ], 400);
            }

            $cart = session()->get('cart') ?? [];
            if (isset($cart[$id])) {
                $cart[$id]['qty']++;
            } else {
                $cart[$id] = [
                    'id'    => $id,
                    'nama'  => $produk['nama_produk'],
                    'harga' => $produk['harga'],
                    'qty'   => 1,
                    'foto'  => $produk['image']
                ];
            }
            session()->set('cart', $cart);
            session_write_close();

            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error'], 404);
    }

    public function getCart()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['harga'] * $item['qty']);
        }

        return $this->response->setJSON([
            'cart'            => array_values($cart),
            'total'           => $total,
            'total_formatted' => number_format($total, 0, ',', '.')
        ]);
    }

    public function save()
    {
        $produkModel = new ProdukModel();
        $transaksiModel = new TransaksiModel();

        $cart = session()->get('cart');
        $total = $this->request->getPost('total_akhir');
        $nama_pelanggan = $this->request->getPost('nama_pelanggan') ?: 'Pelanggan Umum';
        $metode = $this->request->getPost('metode_pembayaran') ?: 'Cash';

        if (!$cart || !$total || $total == 0) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        // --- MULAI PROSES DATABASE DENGAN TRANSACTION (DB INTEGRITY) ---
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Simpan Header Transaksi
        $data = [
            'nama_pelanggan' => $nama_pelanggan,
            'total_harga'    => $total,
            'metode_bayar'   => ucfirst($metode),
            'status'         => 'Selesai',
            'created_at'     => date('Y-m-d H:i:s')
        ];
        $transaksiModel->insert($data);
        $insertID = $transaksiModel->getInsertID();

        // 2. Loop Keranjang untuk Potong Stok
        foreach ($cart as $item) {
            $p = $produkModel->find($item['id']);
            if ($p) {
                // Kurangi stok di database berdasarkan qty beli
                $stokBaru = $p['stok'] - $item['qty'];
                $produkModel->update($item['id'], ['stok' => $stokBaru]);
            }
        }

        $db->transComplete();
        // --- SELESAI PROSES DATABASE ---

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses transaksi!');
        }

        // Simpan data keranjang ke flashdata untuk keperluan cetak struk sebelum dihapus
        session()->setFlashdata('cetak_cart', $cart);
        session()->remove('cart');

        return redirect()->to(base_url('transaksi/print/' . $insertID))->with('success', 'Transaksi Berhasil!');
    }

    // --- METHOD KHUSUS UNTUK POSTMAN / API ---
    public function saveApi()
    {
        $produkModel = new ProdukModel();
        $transaksiModel = new TransaksiModel();

        $json = $this->request->getJSON();

        if (!$json || empty($json->items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid'])->setStatusCode(400);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $transaksiModel->insert([
            'nama_pelanggan' => $json->nama_pelanggan ?? 'API User',
            'total_harga'    => $json->total_harga,
            'metode_bayar'   => 'Digital',
            'status'         => 'Selesai',
            'created_at'     => date('Y-m-d H:i:s')
        ]);
        $insertID = $transaksiModel->getInsertID();

        foreach ($json->items as $item) {
            $p = $produkModel->find($item->id_produk);
            if ($p) {
                $produkModel->update($item->id_produk, ['stok' => $p['stok'] - $item->qty]);
            }
        }

        $db->transComplete();

        return $this->response->setJSON([
            'status'       => 'success',
            'message'      => 'Transaksi API Berhasil & Stok Berkurang',
            'id_transaksi' => $insertID
        ]);
    }

    public function riwayat()
    {
        $model = new TransaksiModel();
        return view('transaksi/riwayat', [
            'title'     => 'Riwayat Transaksi',
            'transaksi' => $model->orderBy('id', 'DESC')->findAll()
        ]);
    }

    public function print($id)
    {
        $model = new TransaksiModel();
        $transaksi = $model->find($id);

        if (!$transaksi) {
            return redirect()->to(base_url('transaksi'));
        }

        $items = session()->getFlashdata('cetak_cart') ?? [];

        return view('transaksi/print', [
            'title'     => 'Cetak Struk #' . $id,
            'transaksi' => $transaksi,
            'items'     => $items
        ]);
    }

    public function clearCart()
    {
        session()->remove('cart');
        return redirect()->to(base_url('transaksi'));
    }
}