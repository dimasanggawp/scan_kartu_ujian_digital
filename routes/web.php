<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

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
*/

Route::get('/', [IndexController::class, 'index'])->name('get.index.index');
Route::get('/proses/{no_peserta}', [IndexController::class, 'proses'])->name('get.index.proses');


Route::get('/pengawas', [IndexController::class, 'pengawas'])->name('get.index.pengawas');
Route::get('/proses_pengawas/{no_peserta}', [IndexController::class, 'proses_pengawas'])->name('get.index.proses_pengawas');
