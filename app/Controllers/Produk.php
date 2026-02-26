<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct() {
        $this->produkModel = new ProdukModel();
    }

   public function index()
    {
        $produkModel = new ProdukModel();
        
        $data = [
            'title'    => 'Menu Gallery - Queejuy Coffee',
            'produk'   => $produkModel->findAll(), // Mengambil semua data produk dari tabel
            'kategori' => ['Coffee', 'Non-Coffee', 'Pastry', 'Snack'] // INI YANG WAJIB ADA
        ];

        return view('produk/index', $data);
    }

    public function tambah() {
        return view('produk/tambah');
    }

    public function save() {
        $file = $this->request->getFile('image');
        $namaGambar = ($file && $file->isValid()) ? $file->getRandomName() : 'default.jpg';
        if($file && $file->isValid()) $file->move('uploads/menu', $namaGambar);

        $this->produkModel->save([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori'    => $this->request->getPost('kategori'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'image'       => $namaGambar
        ]);

        return redirect()->to('/produk')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function hapus($id) {
        $this->produkModel->delete($id);
        return redirect()->to('/produk')->with('success', 'Menu berhasil dihapus!');
    }
}