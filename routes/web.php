<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\PegawaiController;
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


// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();

Route::post('auth', [LoginController::class, 'authenticate'])->name('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('home');

    Route::group(['prefix' => 'pegawai'], function () {
        Route::get('list', [PegawaiController::class, 'getPegawai'])->name('pegawai.list');
        Route::get('', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::post('', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::post('{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::get('{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
        Route::delete('{id}', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
    });

    Route::group(['prefix' => 'akun'], function () {
        Route::get('list', [AkunController::class, 'getAkun'])->name('akun.list');
        Route::get('', [AkunController::class, 'index'])->name('akun.index');
        Route::post('', [AkunController::class, 'store'])->name('akun.store');
        Route::post('{id}', [AkunController::class, 'update'])->name('akun.update');
        Route::get('{id}', [AkunController::class, 'show'])->name('akun.show');
        Route::delete('{id}', [AkunController::class, 'destroy'])->name('akun.delete');
    });

    Route::group(['prefix' => 'gaji'], function () {
        Route::get('list', [GajiController::class, 'getGaji'])->name('gaji.list');
        Route::get('report-list', [GajiController::class, 'getReportGaji'])->name('gaji.report-list');
        Route::get('', [GajiController::class, 'index'])->name('gaji.index');
        Route::post('', [GajiController::class, 'store'])->name('gaji.store');
        Route::post('{id}', [GajiController::class, 'update'])->name('gaji.update');
        Route::get('{id}', [GajiController::class, 'show'])->name('gaji.show');
        Route::delete('{id}', [GajiController::class, 'destroy'])->name('gaji.delete');
    });

    Route::group(['prefix' => 'jurnal'], function () {
        Route::get('list', [JurnalController::class, 'getJurnal'])->name('jurnal.list');
        Route::get('report-list', [JurnalController::class, 'getReportJurnal'])->name('jurnal.report-list');
        Route::get('', [JurnalController::class, 'index'])->name('jurnal.index');
        Route::post('', [JurnalController::class, 'store'])->name('jurnal.store');
        Route::post('{id}', [JurnalController::class, 'update'])->name('jurnal.update');
        Route::get('{id}', [JurnalController::class, 'show'])->name('jurnal.show');
        Route::delete('{id}', [JurnalController::class, 'destroy'])->name('jurnal.delete');
    });

    Route::group(['prefix' => 'absen'], function () {
        Route::get('list', [AbsensiController::class, 'getAbsensi'])->name('absen.list');
        Route::get('report-list', [AbsensiController::class, 'getReportAbsensi'])->name('absen.report-list');
        Route::get('', [AbsensiController::class, 'index'])->name('absen.index');
        Route::get('report', [AbsensiController::class, 'reportAbsensi'])->name('absen.report');
        Route::post('', [AbsensiController::class, 'store'])->name('absen.store');
        Route::post('{id}', [AbsensiController::class, 'update'])->name('absen.update');
        Route::get('{id}', [AbsensiController::class, 'show'])->name('absen.show');
        Route::delete('{id}', [AbsensiController::class, 'destroy'])->name('absen.delete');
    });
});
