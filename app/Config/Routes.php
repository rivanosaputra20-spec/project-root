<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('login', 'Auth::login');
$routes->post('login/proses', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');

// Grup yang harus login
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Home::index');
    
    // Menu routes
    $routes->get('menu', 'Menu::index');
    $routes->get('menu/tambah', 'Menu::tambah');
    $routes->post('menu/simpan', 'Menu::simpan');
    
    // Transaksi
    $routes->get('transaksi', 'Transaksi::index');
    $routes->get('transaksi/create', 'Transaksi::create');
    $routes->post('transaksi/store', 'Transaksi::store');

    // Menambahkan Produk admin only
    $routes->get('/produk', 'Produk::index');
    $routes->post('/produk/save', 'Produk::save');
    // Pelanggan
    $routes->get('pelanggan', 'Pelanggan::index');

    // Grup khusus Admin (Hanya bisa dibuka jika role == admin)
    $routes->group('produk', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('/', 'Produk::index');

        $routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Home::index');
    
    // Menu & Produk (Disatukan ke Menu Controller agar tidak bingung)
    $routes->get('menu', 'Menu::index');
    $routes->get('menu/tambah', 'Menu::tambah');
    $routes->post('menu/simpan', 'Menu::simpan');
    $routes->get('menu/edit/(:num)', 'Menu::edit/$1');
    $routes->post('menu/update/(:num)', 'Menu::update/$1');
    $routes->get('menu/hapus/(:num)', 'Menu::hapus/$1');

    // Transaksi
    $routes->get('transaksi', 'Transaksi::index');
    $routes->get('transaksi/create', 'Transaksi::create');
    $routes->post('transaksi/store', 'Transaksi::store');

    // Pelanggan
    $routes->get('pelanggan', 'Pelanggan::index');
});
    });
});