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
/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\Account\ChangePasswordController;

Route::get('admin/account/password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password-form');
Route::post('admin/account/password', [ChangePasswordController::class, 'changePassword'])->name('change-password');

use App\Http\Controllers\Account\ChangeProfile;

Route::get('admin/account/profile', [ChangeProfile::class, 'showProfile'])->name('change-profile-form');
Route::post('admin/account/profile', [ChangeProfile::class, 'changeProfile'])->name('change-profile');

use App\Http\Controllers\Master\MasterAlatController;

Route::get('/admin/master/alat', [MasterAlatController::class, 'index'])->name('master.alat.index');
Route::get('/admin/master/alat/new', [MasterAlatController::class, 'create'])->name('master.alat.create');
Route::post('/admin/master/alat/new', [MasterAlatController::class, 'store'])->name('master.alat.store');
Route::get('/admin/master/alat/edit/{id}', [MasterAlatController::class, 'edit'])->name('master.alat.edit');
Route::put('/admin/master/alat/edit/{id}', [MasterAlatController::class, 'update'])->name('master.alat.update');
Route::delete('/admin/master/alat/{id}', [MasterAlatController::class, 'destroy'])->name('master.alat.destroy');

use App\Http\Controllers\Master\MasterPlantController;

Route::get('/admin/master/plant', [MasterPlantController::class, 'index'])->name('master.plant.index');
Route::get('/admin/master/plant/new', [MasterPlantController::class, 'create'])->name('master.plant.create');
Route::post('/admin/master/plant/new', [MasterPlantController::class, 'store'])->name('master.plant.store');
Route::get('/admin/master/plant/edit/{id}', [MasterPlantController::class, 'edit'])->name('master.plant.edit');
Route::put('/admin/master/plant/edit/{id}', [MasterPlantController::class, 'update'])->name('master.plant.update');
Route::delete('/admin/master/plant/{id}', [MasterPlantController::class, 'destroy'])->name('master.plant.destroy');

use App\Http\Controllers\Penerimaan\TransaksiPenerimaanController;

Route::get('/admin/get-transaksi-id/{tipeTransaksi}', [TransaksiPenerimaanController::class, 'generateTransaksiID'])->name('get.transaksi.id');
Route::get('/admin/get-harga-barang/{kodeBarang}', [TransaksiPenerimaanController::class, 'getHarga'])->name('get.harga.barang');
Route::get('/admin/transaksi/penerimaan', [TransaksiPenerimaanController::class, 'create'])->name('transaksi.penerimaan.create');
Route::post('/admin/transaksi/penerimaan', [TransaksiPenerimaanController::class, 'store'])->name('transaksi.penerimaan.store');
Route::get('/admin/transaksi/penerimaan/edit/{id}', [TransaksiPenerimaanController::class, 'edit'])->name('transaksi.penerimaan.edit');
Route::put('/admin/transaksi/penerimaan/edit/{id}', [TransaksiPenerimaanController::class, 'update'])->name('transaksi.penerimaan.update');
Route::delete('/admin/transaksi/penerimaan/{id}', [TransaksiPenerimaanController::class, 'destroy'])->name('transaksi.penerimaan.destroy');

use App\Http\Controllers\Pengeluaran\TransaksiPemakaianController;

Route::get('/admin/transaksi/pemakaian', [TransaksiPemakaianController::class, 'create'])->name('transaksi.pemakaian.create');
Route::post('/admin/transaksi/pemakaian', [TransaksiPemakaianController::class, 'store'])->name('transaksi.pemakaian.store');
Route::get('/admin/transaksi/pemakaian/edit/{id}', [TransaksiPemakaianController::class, 'edit'])->name('transaksi.pemakaian.edit');
Route::put('/admin/transaksi/pemakaian/edit/{id}', [TransaksiPemakaianController::class, 'update'])->name('transaksi.pemakaian.update');
Route::delete('/admin/transaksi/pemakaian/{id}', [TransaksiPemakaianController::class, 'destroy'])->name('transaksi.pemakaian.destroy');

use App\Http\Controllers\Master\MasterJenisBarcodeController;

Route::get('/admin/master/barcode', [MasterJenisBarcodeController::class, 'index'])->name('master.barcode.index');
Route::get('/admin/master/barcode/new', [MasterJenisBarcodeController::class, 'create'])->name('master.barcode.create');
Route::post('/admin/master/barcode/new', [MasterJenisBarcodeController::class, 'store'])->name('master.barcode.store');
Route::get('/admin/master/barcode/edit/{id}', [MasterJenisBarcodeController::class, 'edit'])->name('master.barcode.edit');
Route::put('/admin/master/barcode/edit/{id}', [MasterJenisBarcodeController::class, 'update'])->name('master.barcode.update');
Route::delete('/admin/master/barcode/{id}', [MasterJenisBarcodeController::class, 'destroy'])->name('master.barcode.destroy');

use App\Http\Controllers\Master\MasterBarangController;

Route::get('/admin/master/barang/import', [MasterBarangController::class, 'importForm']);
Route::post('/admin/master/barang/import', [MasterBarangController::class, 'import']);
Route::get('/admin/master/barang', [MasterBarangController::class, 'index'])->name('master.barang.index');
Route::get('/admin/master/barang/edit/{id}', [MasterBarangController::class, 'editForm'])->name('master.barang.edit');
Route::put('/admin/master/barang/edit/{id}', [MasterBarangController::class, 'updateData'])->name('master.barang.update');
Route::delete('/admin/master/barang/hapus/{id}', [MasterBarangController::class, 'destroy'])->name('master.barang.destroy');
Route::get('/admin/master/barang/input', [MasterBarangController::class, 'create'])->name('master.barang.create');
Route::post('/admin/master/barang/store', [MasterBarangController::class, 'store'])->name('master.barang.store');
Route::get('/admin/master/barang/export', [MasterBarangController::class, 'excelReport'])->name('master.barang.excelReportAll');

use App\Http\Controllers\Laporan\TrendBulanController;

Route::get('/admin/laporan/trend-bulan', [TrendBulanController::class, 'index'])->name('laporan.trend.bulan.index');
Route::post('/admin/laporan/trend-bulan', [TrendBulanController::class, 'export'])->name('laporan.trend.bulan.export');
