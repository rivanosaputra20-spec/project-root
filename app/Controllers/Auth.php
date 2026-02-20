<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = (string)$this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id'         => $user['id'],
                    'username'   => $user['username'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true,
                ]);
                return redirect()->to('/');
            }
            return redirect()->back()->with('error', 'Password Salah!');
        }
        return redirect()->back()->with('error', 'Username Tidak Ditemukan!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}