<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD;
use App\Http\Controllers\AuthController;
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

Route::get('/', [AuthController::class,'index'])->name('login.index');
Route::POST('login', [AuthController::class,'login'])->name('login');

Route::group(['middleware'=>'CekLoginMiddleware'], function(){
    Route::get('logout', [AuthController::class,'logout'])->name('login.logout');
    Route::get('/dashboard', function () {return view('welcome');});
    Route::get('crud', [CRUD::class,'Index']);
    
    Route::get('siswa', [SiswaController::class,'Index'])->name('siswa')->middleware('CekLoginMiddleware');
    
    Route::delete('siswa/delete/{id}', [SiswaController::class,'Delete'])->name('siswa.delete');
});