<?php

namespace App\Controllers;

class Home extends BaseController
{
    // ===== TAMBAHAN FORM (BARU) =====
    public function form()
    {
        return view('form');
    }

    public function process()
    {
        $nama  = $this->request->getPost('nama');
        $email = $this->request->getPost('email');

        // kirim nama ke home
        return view('home', [
            'nama' => $nama,
            'email' => $email
        ]);
    }
    // ===== END TAMBAHAN =====


    public function index()
    {
        return view('home');
    }

    public function routing()
    {
        return view('routing');
    }

    public function controller()
    {
        $data = [
            'title' => 'Halaman Controller - Data Mahasiswa',
            'mahasiswa' => [
                [
                    'nama'  => 'Mirha jhapran',
                    'nim'   => '001',
                    'prodi' => 'Informatika'
                ],
                [
                    'nama'  => 'Rifa plenger',
                    'nim'   => '002',
                    'prodi' => 'Sistem Informasi'
                ],
                [
                    'nama'  => 'faiq alkatiri',
                    'nim'   => '003',
                    'prodi' => 'Teknik Komputer'
                ],
            ]
        ];

        return view('controller', $data);
    }

    public function view()
    {
        return view('view_page');
    }

}
