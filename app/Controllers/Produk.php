<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct() {
        $this->produkModel = new ProdukModel();
    }

    public function index() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title'    => 'Menu Gallery',
            'produk'   => $this->produkModel->findAll(),
            'kategori' => ['Coffee', 'Non-Coffee', 'Pastry', 'Snack'],
            'role'     => session()->get('role'), 
            'username' => session()->get('username')
        ];
        
        return view('produk/index', $data);
    }

    public function save() {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/produk')->with('error', 'Akses ditolak!');
        }

        $file = $this->request->getFile('image');
        $namaGambar = 'default.png';
        
        if($file && $file->isValid() && !$file->hasMoved()) {
            $namaGambar = $file->getRandomName();
            // Gunakan FCPATH agar masuk ke folder public/uploads/menu
            $file->move(FCPATH . 'uploads/menu', $namaGambar);
        }

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

    public function update($id) {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/produk')->with('error', 'Akses ditolak!');
        }

        $data = [
            'harga' => $this->request->getPost('harga'),
            'stok'  => $this->request->getPost('stok'),
        ];

        $this->produkModel->update($id, $data);
        return redirect()->to('/produk')->with('success', 'Data menu diperbarui!');
    }

    public function hapus($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/produk')->with('error', 'Akses ditolak!');
        }

        $produk = $this->produkModel->find($id);

        if ($produk) {
            $image = $produk['image'];
            // Validasi hapus file fisik
            if ($image && $image != 'default.png' && strpos($image, 'http') === false) {
                $path = FCPATH . 'uploads/menu/' . $image;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $this->produkModel->delete($id);
            return redirect()->to('/produk')->with('success', 'Menu berhasil dihapus!');
        }

        return redirect()->to('/produk')->with('error', 'Menu tidak ditemukan!');
    }
}