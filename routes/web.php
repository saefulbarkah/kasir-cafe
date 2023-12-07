<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('logout', function () {
    if (auth()->user()->roles->pluck('name')->implode(',') == "kasir") {
        activity()
            ->causedBy(auth()->user()->id)
            ->log("Keluar");
    }
    Auth::logout();
    return redirect('login');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

// Route for admin
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin', 'auth']], function () {
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    Route::post('ubah-password/{id}', 'Admin\UserController@ubahPassword')->name('admin.ubah.password');


    Route::get('kasir', 'Admin\KasirController@index')->name('admin.kasir');
    Route::get('kasir/create', 'Admin\KasirController@create')->name('admin.kasir.create');
    Route::get('kasir/edit/{id}', 'Admin\KasirController@edit')->name('admin.kasir.edit');
    Route::post('kasir/store', 'Admin\KasirController@store')->name('admin.kasir.store');
    Route::post('kasir/update/{id}', 'Admin\KasirController@update')->name('admin.kasir.update');
    Route::get('kasir/delete/{id}', 'Admin\KasirController@destroy')->name('admin.kasir.delete');


    Route::get('manager', 'Admin\ManagerController@index')->name('admin.manager');
    Route::get('manager/create', 'Admin\ManagerController@create')->name('admin.manager.create');
    Route::post('manager/store', 'Admin\ManagerController@store')->name('admin.manager.store');
    Route::get('manager/edit/{id}', 'Admin\ManagerController@edit')->name('admin.manager.edit');
    Route::post('manager/update/{id}', 'Admin\ManagerController@update')->name('admin.manager.update');
    Route::get('manager/delete/{id}', 'Admin\ManagerController@destroy')->name('admin.manager.delete');

    // Route::get('manage/user', 'Admin\UserController@index')->name('admin.manage.user');
    // Route::get('manage/user/create', 'Admin\UserController@create')->name('admin.create.user');
    // Route::post('manage/user/store', 'Admin\UserController@store')->name('admin.store.user');
    // Route::get('manage/user/edit/{id}', 'Admin\UserController@edit')->name('admin.edit.user');
    // Route::post('manage/user/update/{id}', 'Admin\UserController@update')->name('admin.update.user');
    // Route::get('manage/user/delete/{id}', 'Admin\UserController@delete')->name('admin.delete.user');


    Route::get('aktifitas-pegawai', 'Admin\AktifitasController@index')->name('admin.aktifitas');
    Route::get('aktifitas-pegawai/clean', 'Admin\AktifitasController@delete')->name('admin.aktifitas.delete');
});

// Route for Manager
Route::group(['prefix' => 'manager', 'middleware' => ['role:manager', 'auth']], function () {
    Route::get('dashboard', 'Manager\DashboardController@index')->name('manager.dashboard');
    Route::post('ubah-password/{id}', 'Manager\UserController@ubahPassword')->name('manager.ubah.password');

    // Route menu
    Route::get('menu', 'Manager\MenuController@index')->name('manager.menu');
    Route::get('menu/create', 'Manager\MenuController@create')->name('manager.menu.create');
    Route::post('menu/store', 'Manager\MenuController@store')->name('manager.menu.store');
    Route::get('menu/edit/{id}', 'Manager\MenuController@edit')->name('manager.menu.edit');
    Route::post('menu/update/{id}', 'Manager\MenuController@update')->name('manager.menu.update');
    Route::get('menu/delete/{id}', 'Manager\MenuController@destroy')->name('manager.menu.delete');

    // Route History transaksi
    Route::get('riwayat-transaksi', 'Manager\TransaksiController@riwayatTransaksi')->name('manager.riwayat.transaksi');
    Route::get('riwayat-transaksi/filter', 'Manager\TransaksiController@filter')->name('manager.riwayat.transaksi.filter');

    // Laporan Pendapatan
    Route::get('laporan-pendapatan', 'Manager\PendapatanController@index')->name('manager.laporan.pendapatan');
    Route::get('laporan-pendapatan/filter', 'Manager\PendapatanController@filter')->name('manager.pendapatan.filter');
    Route::get('laporan-pendapatan/filter/bulan', 'Manager\PendapatanController@filterBulan')->name('manager.pendapatan.filter.bulan');
    Route::get('laporan-pendapatan/cetak/{id}', 'Manager\PendapatanController@cetak')->name('manager.cetak.pendapatan');

    // Route aktifitas
    Route::get('aktifitas-pegawai', 'Manager\AktifitasController@index')->name('manager.aktifitas');
});

// Route for kasir
Route::group(['prefix' => 'kasir', 'middleware' => ['role:kasir', 'auth']], function () {
    Route::post('ubah-password/{id}', 'Kasir\UserController@ubahPassword')->name('kasir.ubah.password');

    // Pesanan
    Route::get('pesanan', 'Kasir\PesananController@index')->name('kasir.pesanan');

    // add to cart
    Route::post('pesanan/add_order', 'Kasir\PesananController@addOrder')->name('kasir.pesanan.add_order');
    Route::get('pesanan/delete_order/{id}', 'Kasir\PesananController@deleteOrder')->name('kasir.pesanan.delete.order');
    Route::post('pesanan/update_order/{id}', 'Kasir\PesananController@updateOrder')->name('kasir.pesanan.update.order');
    Route::post('pesanan/bayar_order/', 'Kasir\PesananController@bayarOrder')->name('kasir.pesanan.bayar.order');
    Route::get('pesanan/delete/order', 'Kasir\PesananController@deleteAllOrder')->name('kasir.pesanan.delete.all.order');

    // struk pembayaran
    Route::get('struk/pembayaran/{id}', 'Kasir\StrukController@index')->name('kasir.struk.pembayaran');
    Route::post('struk/pembayaran/{id}', 'Kasir\StrukController@cetakStruk')->name('kasir.struk.pembayaran');
    // riwayat transaksi
    Route::get('riwayat-transaksi', 'Kasir\TransaksiController@riwayat')->name('kasir.riwayat.transaksi');
});
