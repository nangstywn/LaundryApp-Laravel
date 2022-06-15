<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return view('frontend.index');
});

// Frontend
Route::get('pencarian-laundry', 'FrontController@search');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => ['auth', 'ceklevel:admin']], function () {
    //Admin Akses
    Route::get('admin-cabang', 'CabangController@index')->name('admin-cabang.index');
    Route::post('admin-cabang', 'CabangController@store')->name('admin-cabang.store');
    Route::put('admin-cabang/{id}', 'CabangController@update')->name('admin-cabang.update');
    Route::delete('admin-cabang/{id}', 'CabangController@destroy')->name('admin-cabang.destroy');
    //karyawan
    Route::get('kry', 'AdminController@kry')->name('kry');
    Route::post('kry', 'AdminController@store')->name('kry.store');

    Route::delete('kry/{id}', 'AdminController@destroy')->name('kry.destroy');


    //Data Laundy
    Route::get('data-harga', 'AdminController@dataharga')->name('data-harga');
    Route::post('harga-store', 'AdminController@hargastore')->name('harga-store');
    Route::put('harga-update/{id}', 'AdminController@hargaupdate')->name('harga-update');
    Route::delete('harga-store/{id}', 'AdminController@hargadestroy')->name('harga.destroy');

    Route::get('pendapatan', 'AdminController@pendapatan')->name('pendapatan');
    //Transaksi
    //Route::get('admin-transaksi', 'AdminController@admintransaksi')->name('admin.transaksi');
    //Route::get('filter-transaksi/{id}','AdminController@filtertransaksi')->name('filter.transaksi');
});

//Karyawan & Admin Akses
Route::middleware('auth')->group(function () {
    Route::get('invoice-kar/{id}', 'PelayananController@invoicekar')->name('invoice');
    Route::get('print/{id}', 'PelayananController@print');
    Route::get('pelayanan', 'PelayananController@index')->name('pelayanan.index');
    Route::get('profile', 'AdminController@show')->name('kry.show');
    Route::put('kry/{id}', 'AdminController@update')->name('kry.update');
});

//Karyawan Akses
Route::group(['middleware' => ['auth', 'ceklevel:karyawan']], function () {
    //Transaksi
    Route::resource('pelayanan', 'PelayananController')->except(['index']);
    Route::get('order-detail', 'PelayananController@detailorder')->name('detail.order');
    Route::delete('order-detail/{id}', 'PelayananController@destroyDetailOrder')->name('destroy.detail.order');
    Route::post('order-detail/save', 'PelayananController@save')->name('save.order');

    //Customer
    Route::get('list-customer', 'PelayananController@listcsr')->name('csr.index');
    Route::post('list-customer', 'PelayananController@addcsr')->name('csr.store');
    Route::put('list-customer/{id}', 'PelayananController@updatecsr')->name('csr.update');
    Route::delete('list-customer/{id}', 'PelayananController@destroycsr')->name('csr.destroy');

    //Transaksi
    Route::get('add-order', 'PelayananController@addorders');
    Route::get('ubah-status-order', 'PelayananController@ubahstatusorder');
    Route::get('ubah-status-bayar', 'PelayananController@ubahstatusbayar');
    Route::get('ubah-status-ambil', 'PelayananController@ubahstatusambil');

    //Filter
    Route::get('listharga', 'AjaxController@listharga');
    Route::get('/harga/{id}', 'AjaxController@harga');
    Route::get('/harga', 'AjaxController@cat');
    Route::get('getid', 'AjaxController@getid');
    Route::get('satuan', 'AjaxController@satuan');
    Route::get('/harga/jenis/{id}', 'AjaxController@jenis');

    // Laporan

    Route::get('send-wa/{id}', 'PelayananController@sendWa');
    Route::post('cetak-invoice', 'PelayananController@cetakinvoice');
    //Route::get('ctk-invoice/{id}', 'PelayananController@cetakinvoice');
    //Route::get('invoice-kar/ctk', 'PelayananController@ctk');
});

Route::get('logout', 'Auth\LoginController@logout'); //logout data
Route::get('test', function () {
    return view('auth.masuk');
});