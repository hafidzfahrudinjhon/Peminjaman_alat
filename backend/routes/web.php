<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


// =====================================================
// ADMIN
// =====================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');


        // =================================================
        // CRUD ALAT
        // =================================================

        Route::get('/alat', [AdminController::class, 'indexAlat'])
            ->name('alat.index');

        Route::get('/alat/create', [AdminController::class, 'createAlat'])
            ->name('alat.create');

        Route::post('/alat', [AdminController::class, 'storeAlat'])
            ->name('alat.store');

        Route::get('/alat/{id}/edit', [AdminController::class, 'editAlat'])
            ->name('alat.edit');

        Route::put('/alat/{id}', [AdminController::class, 'updateAlat'])
            ->name('alat.update');

        Route::delete('/alat/{id}', [AdminController::class, 'destroyAlat'])
            ->name('alat.destroy');


        // =================================================
        // CRUD USER
        // =================================================

        Route::get('/users', [AdminController::class, 'indexUser'])
            ->name('user.index');

        Route::get('/users/create', [AdminController::class, 'createUser'])
            ->name('user.create');

        Route::post('/users', [AdminController::class, 'storeUser'])
            ->name('user.store');

        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])
            ->name('user.edit');

        Route::put('/users/{id}', [AdminController::class, 'updateUser'])
            ->name('user.update');

        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])
            ->name('user.destroy');


        // =================================================
        // CRUD KATEGORI
        // =================================================

        Route::get('/kategori', [AdminController::class, 'indexKategori'])
            ->name('kategori.index');

        Route::get('/kategori/create', [AdminController::class, 'createKategori'])
            ->name('kategori.create');

        Route::post('/kategori', [AdminController::class, 'storeKategori'])
            ->name('kategori.store');

        Route::get('/kategori/{id}/edit', [AdminController::class, 'editKategori'])
            ->name('kategori.edit');

        Route::put('/kategori/{id}', [AdminController::class, 'updateKategori'])
            ->name('kategori.update');

        Route::delete('/kategori/{id}', [AdminController::class, 'destroyKategori'])
            ->name('kategori.destroy');


        // =================================================
        // CRUD PEMINJAMAN
        // =================================================

        Route::get('/peminjaman', [AdminController::class, 'listPeminjaman'])
            ->name('peminjaman.index');

        Route::get('/peminjaman/create', [AdminController::class, 'createPeminjaman'])
            ->name('peminjaman.create');

        Route::post('/peminjaman', [AdminController::class, 'storePeminjaman'])
            ->name('peminjaman.store');

        Route::put('/peminjaman/{id}/status', [AdminController::class, 'updateStatusPeminjaman'])
            ->name('peminjaman.updateStatus');

        Route::delete('/peminjaman/{id}', [AdminController::class, 'destroyPeminjaman'])
            ->name('peminjaman.destroy');


        // =================================================
        // PENGEMBALIAN ADMIN
        // =================================================

        Route::get('/pengembalian', [AdminController::class, 'indexPengembalian'])
            ->name('pengembalian.index');

        Route::get('/pengembalian/create', [AdminController::class, 'createPengembalian'])
            ->name('pengembalian.create');

        Route::post('/pengembalian', [AdminController::class, 'storePengembalian'])
            ->name('pengembalian.store');

        Route::get('/pengembalian/{id}/edit', [AdminController::class, 'editPengembalian'])
            ->name('pengembalian.edit');

        Route::put('/pengembalian/{id}', [AdminController::class, 'updatePengembalian'])
            ->name('pengembalian.update');

        Route::delete('/pengembalian/{id}', [AdminController::class, 'destroyPengembalian'])
            ->name('pengembalian.destroy');

        // Proses pengembalian dari Admin
        Route::patch('/peminjaman/{id}/kembali', [AdminController::class, 'prosesPengembalian'])
            ->name('peminjaman.kembali');


        // =================================================
        // LAPORAN ADMIN
        // =================================================

        Route::get('/laporan', [PetugasController::class, 'laporan'])
            ->name('laporan.index');

        Route::get('/laporan/cetak', [PetugasController::class, 'cetakLaporan'])
            ->name('laporan.cetak');
    });


// =====================================================
// PETUGAS
// =====================================================

Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        // =================================================
        // PEMINJAMAN & PERSETUJUAN
        // =================================================

        Route::get('/peminjaman', [PetugasController::class, 'indexPeminjaman'])
            ->name('peminjaman.index');

        Route::post('/peminjaman/{id}/setujui', [PetugasController::class, 'setujuiPeminjaman'])
            ->name('peminjaman.setujui');

        Route::post('/peminjaman/{id}/tolak', [PetugasController::class, 'tolakPeminjaman'])
            ->name('peminjaman.tolak');


        // =================================================
        // PENGEMBALIAN PETUGAS
        // =================================================

        Route::get('/pengembalian', [PetugasController::class, 'indexPengembalian'])
            ->name('pengembalian.index');

        Route::post('/pengembalian/{id}', [PetugasController::class, 'prosesPengembalian'])
            ->name('pengembalian.proses');


        // =================================================
        // LAPORAN PETUGAS
        // =================================================

        Route::get('/laporan', [PetugasController::class, 'indexLaporan'])
            ->name('laporan.index');

        Route::get('/laporan/cetak', [PetugasController::class, 'cetakLaporan'])
            ->name('laporan.cetak');
    });


// =====================================================
// PEMINJAM
// =====================================================

Route::middleware(['auth', 'role:peminjam'])
    ->prefix('peminjam')
    ->name('peminjam.')
    ->group(function () {

        // Katalog & Pengajuan
        Route::get('/katalog', [PeminjamController::class, 'katalogAlat'])
            ->name('katalog');

        Route::post('/peminjaman/ajukan', [PeminjamController::class, 'ajukanPeminjaman'])
            ->name('peminjaman.ajukan');


        // Pengembalian barang
        Route::get('/kembali', [PeminjamController::class, 'daftarBarangDipinjam'])
            ->name('kembali');

        Route::post('/peminjaman/{id}/kembali', [PeminjamController::class, 'kembalikanBarang'])
            ->name('peminjaman.kembali');


        // Riwayat
        Route::get('/riwayat', [PeminjamController::class, 'riwayatPeminjaman'])
            ->name('riwayat');
    });


// =====================================================
// TAMU
// =====================================================

Route::middleware(['guest'])->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});


// =====================================================
// LOGOUT
// =====================================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');