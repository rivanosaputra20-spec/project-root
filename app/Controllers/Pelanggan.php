<?php

namespace App\Controllers;

use App\Models\PelangganModel;

class Pelanggan extends BaseController
{
    protected $pelangganModel;

    public function __construct() {
        $this->pelangganModel = new PelangganModel();
    }

    public function index() {
        $data = [
            'title'     => 'Pelanggan - Kopi Kita',
            'pelanggan' => $this->pelangganModel->findAll(),
        ];
        return view('pelanggan/index', $data);
    }

    public function save() {
        $this->pelangganModel->save([
            'nama'    => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat'  => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/pelanggan')->with('success', 'Member ditambahkan!');
    }
}