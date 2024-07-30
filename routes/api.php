<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\API\AuthApiController;
use App\Http\Controllers\Backend\API\CutiApiController;
use App\Http\Controllers\Backend\API\IzinApiController;
use App\Http\Controllers\Backend\API\ChartApiController;
use App\Http\Controllers\Backend\API\DinasApiController;
use App\Http\Controllers\Backend\API\SakitApiController;
use App\Http\Controllers\Backend\API\ReportApiController;
use App\Http\Controllers\Backend\API\AbsensiApiController;
use App\Http\Controllers\Backend\Api\LaporanApiController;
use App\Http\Controllers\Backend\API\ShiftApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->get('/absensi', [AbsensiApiController::class, 'index']);
    Route::get('/absensi/name', [AbsensiApiController::class, 'findName']);
    Route::middleware('auth:api')->get('/absensi/riwayat', [AbsensiApiController::class, 'riwayatPresensi']);

    // Mendapatkan semau data absen sesuai dengan namanya
    Route::middleware('auth:api')->get('/absensi/report', [AbsensiApiController::class, 'report']);
    Route::middleware('auth:api')->post('/absensi', [AbsensiApiController::class, 'store']);
    Route::middleware('auth:api')->post('/absensi/keluar', [AbsensiApiController::class, 'storeKeluar']);

});

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/eselon/login', [AuthApiController::class, 'loginEselonDua']);
Route::middleware('auth:api')->post('logout', [AuthApiController::class, 'logout']);

Route::middleware('auth:api')->post('izin', [IzinApiController::class, 'simpanIzin']);
Route::middleware('auth:api')->post('sakit', [SakitApiController::class, 'simpanSakit']);
Route::middleware('auth:api')->post('dinas', [DinasApiController::class, 'simpanDinas']);
Route::middleware('auth:api')->post('cuti', [CutiApiController::class, 'simpanCuti']);
// Lokasi
Route::middleware('auth:api')->get('/user/details', [AuthApiController::class, 'getUserDetails']);
Route::middleware('auth:api')->get('/user/multi', [AuthApiController::class, 'getUserMultiDetails']);
Route::middleware('auth:api')->get('/user-coordinates', [AuthApiController::class, 'getUserCoordinates']);


Route::middleware('auth:api')->get('/cuti/user', [CutiApiController::class, 'index']);
Route::middleware('auth:api')->get('/dinas/user', [DinasApiController::class, 'index']);
Route::middleware('auth:api')->get('/sakit/user', [SakitApiController::class, 'index']);
Route::middleware('auth:api')->get('/izin/user', [IzinApiController::class, 'index']);

Route::middleware('auth:api')->delete('/cuti/delete', [CutiApiController::class, 'delete']);
Route::middleware('auth:api')->delete('/dinas/delete', [DinasApiController::class, 'delete']);
Route::middleware('auth:api')->delete('/izin/delete', [IzinApiController::class, 'delete']);
Route::middleware('auth:api')->delete('/sakit/delete', [SakitApiController::class, 'delete']);

Route::get('/koordinat-tambahan', [AbsensiApiController::class, 'koordinatTambahan']);
// Route::get('/users/opd', [LaporanApiController::class, 'getUsersCountByOpd']);
Route::get('/users/opd', [ReportApiController::class, 'getUsersCountByOpd']);
Route::get('/rekap/laporan', [ReportApiController::class, 'rekapLaporan']);
Route::get('/kehadiran', [ChartApiController::class, 'getTotalKehadiranPerOpd']);

// get shift
Route::get('/shift', [ShiftApiController::class, 'index']);
