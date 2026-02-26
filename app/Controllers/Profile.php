<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        // 1. Cek apakah session ID ada
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $model = new UserModel();
        $user = $model->find($userId);

        // 2. Jika user tidak ditemukan di database
        if (!$user) {
            return redirect()->to('/produk')->with('error', 'Data user tidak ditemukan.');
        }

        $data = [
            'title' => 'Profile Saya',
            'user'  => $user
        ];

        // 3. Pastikan memanggil view yang benar
        return view('profile/index', $data);
    }

    public function updateFoto()
    {
        $fileFoto = $this->request->getFile('user_image');
        if ($fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/profile/', $namaFoto);

            $model = new UserModel();
            $model->update(session()->get('id'), ['user_image' => $namaFoto]);

            return redirect()->to('/profile')->with('success', 'Foto berhasil diubah!');
        }
        return redirect()->back()->with('error', 'Gagal upload foto.');
    }

    public function updatePassword()
    {
        $newPass = $this->request->getPost('new_password');
        $model = new UserModel();
        $model->update(session()->get('id'), [
            'password' => password_hash($newPass, PASSWORD_DEFAULT)
        ]);
        return redirect()->to('/profile')->with('success', 'Password berhasil diganti!');
    }
}