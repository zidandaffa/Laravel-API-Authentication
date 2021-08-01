<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//untuk menampilkan data user yang sedang login.
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/daftar', [DaftarController::class, 'daftar']);
Route::post('/masuk', [MasukController::class, 'masuk']);
//Route ini hanya bisa di akses jika sudah melakukan proses authentication
Route::post('/keluar', [MasukController::class, 'keluar'])->middleware('auth:api');