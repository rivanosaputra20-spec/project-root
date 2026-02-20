<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    public function index()
    {
        $model = new TransaksiModel();
        $data = [
            'title'     => 'Riwayat Transaksi',
            'transaksi' => $model->orderBy('id', 'DESC')->findAll()
        ];
        return view('Transaksi/index', $data); 
    }

    public function create()
    {
        $produkModel = new ProdukModel();
        $data = [
            'title'  => 'Kasir - Kopi Kita',
            'produk' => $produkModel->findAll()
        ];
        return view('Transaksi/create', $data);
    }

    // --- TAMBAHKAN FUNGSI SAVE UNTUK MENYIMPAN TRANSAKSI ---
    public function save()
    {
        $model = new TransaksiModel();
        
        $data = [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan') ?? 'Pelanggan Umum',
            'total'          => $this->request->getPost('total'),
            'metode_bayar'   => $this->request->getPost('metode_bayar'),
            'status'         => 'Selesai'
        ];

        $model->insert($data);
        $insertID = $model->insertID(); // Ambil ID transaksi yang baru saja disimpan

        // Setelah simpan, langsung lempar ke halaman print
        return redirect()->to('/transaksi/print/' . $insertID);
    }

    // --- TAMBAHKAN FUNGSI PRINT ---
    public function print($id)
    {
        $model = new TransaksiModel();
        $data = [
            'title'     => 'Cetak Struk #' . $id,
            'transaksi' => $model->find($id)
        ];

        if (!$data['transaksi']) {
            return redirect()->to('/transaksi')->with('error', 'Data tidak ditemukan');
        }

        return view('Transaksi/print', $data);
    }
}