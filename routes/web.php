<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD;
use App\Http\Controllers\MasterData\SiswaController;
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
    return view('welcome');
});

Route::get('crud', [CRUD::class,'Index']);

Route::get('siswa', [SiswaController::class,'Index'])->name('siswa');
Route::delete('siswa/delete/{id}', [SiswaController::class,'Delete'])->name('siswa.delete');