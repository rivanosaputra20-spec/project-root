<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('login', 'Auth::login');
$routes->post('login/proses', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');

// Grup yang harus login
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Home::index');
    
    // Transaksi
    $routes->get('transaksi', 'Transaksi::index');
    $routes->get('transaksi/create', 'Transaksi::create');
    $routes->post('transaksi/store', 'Transaksi::store');

    // Pelanggan
    $routes->get('pelanggan', 'Pelanggan::index');

    // Grup khusus Admin (Hanya bisa dibuka jika role == admin)
    $routes->group('produk', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('/', 'Produk::index');
    });
});