<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterData\SiswaController;
use App\Http\Controllers\Report\LaporanEkskulController;
use App\Http\Controllers\Transaction\PendaftaranEkskulController;
use App\Http\Controllers\Transaction\InputNilaiController;
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

Route::get('/', [AuthController::class,'index'])->name('login.index');
Route::POST('login', [AuthController::class,'login'])->name('login');

Route::get('crud', [CRUD::class,'Index']);

Route::get('siswa', [SiswaController::class,'Index'])->name('siswa');
Route::delete('siswa/delete/{id}', [SiswaController::class,'Delete'])->name('siswa.delete');

Route::group(['middleware'=>'CekLoginMiddleware'], function(){
    Route::get('logout', [AuthController::class,'logout'])->name('login.logout');
    Route::get('/dashboard', function () {return view('welcome');});
    Route::get('crud', [CRUD::class,'Index']);
    
    Route::get('siswa', [SiswaController::class,'Index'])->name('siswa')->middleware('CekLoginMiddleware');
    
    Route::delete('siswa/delete/{id}', [SiswaController::class,'Delete'])->name('siswa.delete');

    Route::group(['prefix'=>'daftar_ekskul'], function() {
        Route::get('/', [PendaftaranEkskulController::class,'index'])->name('daftar_ekskul');
        Route::post('/daftar', [PendaftaranEkskulController::class,'daftar'])->name('daftar_ekskul.daftar');
        Route::post('/update_daftar', [PendaftaranEkskulController::class,'update_daftar'])->name('daftar_ekskul.update');
        Route::post('/delete_daftar', [PendaftaranEkskulController::class,'delete_daftar'])->name('daftar_ekskul.delete');
        Route::post('/read', [PendaftaranEkskulController::class,'read'])->name('daftar_ekskul.read');
        Route::get('/get_siswa', [PendaftaranEkskulController::class,'get_siswa'])->name('daftar_ekskul.get_siswa');
        Route::get('/get_pembina', [PendaftaranEkskulController::class,'get_pembina'])->name('daftar_ekskul.get_pembina');
        Route::get('/get_ekskul', [PendaftaranEkskulController::class,'get_ekskul'])->name('daftar_ekskul.get_ekskul');
    });

    Route::group(['prefix'=>'report'], function() {
        Route::get('/', [LaporanEkskulController::class,'index'])->name('laporan_ekskul.index');
        Route::post('/read', [LaporanEkskulController::class,'read'])->name('laporan_ekskul.read');
        Route::get('/exportToExcel/{kelas}', [LaporanEkskulController::class,'exportToExcel'])->name('laporan_ekskul.export');
    });

    Route::group(['prefix'=>'input_nilai'], function() {
        Route::get('/', [InputNilaiController::class,'index'])->name('input_nilai');
        Route::post('/read', [InputNilaiController::class,'read'])->name('input_nilai.read');
        Route::post('/store', [InputNilaiController::class,'store'])->name('input_nilai.store');
    });
});