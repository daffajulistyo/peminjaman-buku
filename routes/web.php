<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\OpdController;
use App\Http\Controllers\Backend\CutiController;
use App\Http\Controllers\Backend\IzinController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DinasController;
use App\Http\Controllers\Backend\SakitController;
use App\Http\Controllers\Backend\BidangController;
use App\Http\Controllers\Backend\EselonController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\AbsensiController;
use App\Http\Controllers\Backend\JabatanController;
use App\Http\Controllers\Backend\PangkatController;
use App\Http\Controllers\Backend\PegawaiController;
use App\Http\Controllers\Backend\KoordinatController;
use App\Http\Controllers\Backend\API\AuthApiController;
use App\Http\Controllers\Backend\LiburNasionalController;
use App\Http\Controllers\Backend\RekapitulasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekap.index');
    Route::get('/opd/{opdId}/rekap', [RekapitulasiController::class, 'show'])->name('rekap.user');
    Route::prefix('master')->group(function () {
        Route::get('/libur', [LiburNasionalController::class, 'index'])->name('libur.index');
        Route::post('/insert_libur', [LiburNasionalController::class, 'store'])->name('libur.insert');
        Route::get('/delete_libur/{id}', [LiburNasionalController::class, 'destroy'])->name('libur.delete');


        Route::get('list_pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::post('/insert_pegawai', [PegawaiController::class, 'store'])->name('pegawai.insert');
        Route::get('/add_pegawai', [PegawaiController::class, 'create'])->name('pegawai.show');
        Route::get('/edit_pegawai/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::post('/update_pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::get('/delete_pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
        Route::get('/', function () {
            return view('backend.master.list_master');
        })->name('master.index');

        Route::prefix('bidang')->group(function () {
            Route::get('/', [BidangController::class, 'index'])->name('bidang.index');
            Route::post('/insert_bidang', [BidangController::class, 'store'])->name('bidang.insert');
            Route::get('/add_bidang', [BidangController::class, 'create'])->name('bidang.show');
            Route::get('/edit_bidang/{id}', [BidangController::class, 'edit'])->name('bidang.edit');
            Route::post('/update_bidang/{id}', [BidangController::class, 'update'])->name('bidang.update');
            Route::get('/delete_bidang/{id}', [BidangController::class, 'destroy'])->name('bidang.delete');
        });
        Route::prefix('opd')->group(function () {
            Route::get('/', [OpdController::class, 'index'])->name('opd.index');
            Route::post('/insert_opd', [OpdController::class, 'store'])->name('opd.insert');
            Route::get('/add_opd', [OpdController::class, 'create'])->name('opd.show');
            Route::get('/edit_opd/{id}', [OpdController::class, 'edit'])->name('opd.edit');
            Route::post('/update_opd/{id}', [OpdController::class, 'update'])->name('opd.update');
            Route::get('/delete_opd/{id}', [OpdController::class, 'destroy'])->name('opd.delete');
        });
        Route::prefix('jabatan')->group(function () {
            Route::get('/', [JabatanController::class, 'index'])->name('jabatan.index');
            Route::post('/insert_jabatan', [JabatanController::class, 'store'])->name('jabatan.insert');
            Route::get('/add_jabatan', [JabatanController::class, 'create'])->name('jabatan.show');
            Route::get('/edit_jabatan/{id}', [JabatanController::class, 'edit'])->name('jabatan.edit');
            Route::post('/update_jabatan/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
            Route::get('/delete_jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.delete');
        });
        Route::prefix('eselon')->group(function () {
            Route::get('/', [EselonController::class, 'index'])->name('eselon.index');
            Route::post('/insert_eselon', [EselonController::class, 'store'])->name('eselon.insert');
            Route::get('/delete_eselon/{id}', [EselonController::class, 'destroy'])->name('eselon.delete');
        });
        Route::prefix('pangkat')->group(function () {
            Route::get('/', [PangkatController::class, 'index'])->name('pangkat.index');
            Route::post('/insert_pangkat', [PangkatController::class, 'store'])->name('pangkat.insert');
            Route::get('/add_pangkat', [PangkatController::class, 'create'])->name('pangkat.show');
            Route::get('/edit_pangkat/{id}', [PangkatController::class, 'edit'])->name('pangkat.edit');
            Route::post('/update_pangkat/{id}', [PangkatController::class, 'update'])->name('pangkat.update');
            Route::get('/delete_pangkat/{id}', [PangkatController::class, 'destroy'])->name('pangkat.delete');
        });
    });

    Route::prefix('pegawai')->group(function () {
        Route::get('list_pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::post('/insert_pegawai', [PegawaiController::class, 'store'])->name('pegawai.insert');
        Route::get('/add_pegawai', [PegawaiController::class, 'create'])->name('pegawai.show');
        Route::get('/edit_pegawai/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::post('/update_pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::get('/delete_pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
        
    });

    Route::prefix('absensi')->group(function () {
        // Route::get('list_absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        // Route::post('/insert_absensi', [AbsensiController::class, 'store'])->name('absensi.insert');
        Route::get('/add_absensi', [AbsensiController::class, 'create'])->name('absensi.show');
        Route::post('/update_absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
        Route::get('/delete_absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.delete');

        Route::post('/simpan-dinas', [DinasController::class, 'simpanDinas'])->name('simpan-dinas');
        Route::post('/simpan-cuti', [CutiController::class, 'simpanCuti'])->name('simpan-cuti');
        Route::post('/simpan-izin', [IzinController::class, 'simpanIzin'])->name('simpan-izin');
        Route::post('/simpan-sakit', [SakitController::class, 'simpanSakit'])->name('simpan-sakit');
        Route::post('/simpan-absen', [AbsensiController::class, 'simpanAbsen'])->name('simpan-absen');
    });

    Route::prefix('koordinat')->group(function () {
        Route::get('/', [KoordinatController::class, 'index'])->name('koordinat.index');
        Route::post('/insert_koordinat', [KoordinatController::class, 'store'])->name('koordinat.insert');
        Route::get('/add_koordinat', [KoordinatController::class, 'create'])->name('koordinat.show');
        Route::get('/edit_koordinat/{id}', [KoordinatController::class, 'edit'])->name('koordinat.edit');
        Route::post('/update_koordinat/{id}', [KoordinatController::class, 'update'])->name('koordinat.update');
        Route::get('/delete_koordinat/{id}', [KoordinatController::class, 'destroy'])->name('koordinat.delete');
        Route::get('pick-location', [KoordinatController::class, 'pickLocation'])->name('koordinat.pick_location');
        Route::post('/toggle-koordinat', [KoordinatController::class, 'toggleKoordinat'])->name('toggle.koordinat');

    });
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/insert_user', [UserController::class, 'store'])->name('user.insert');
        Route::get('/add_user', [UserController::class, 'create'])->name('user.show');
        Route::get('/edit_user/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update_user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/delete_user/{id}', [UserController::class, 'destroy'])->name('user.delete');
        Route::get('/user/resetpassword/{id}', [UserController::class, 'resetPassword'])->name('user.resetpassword');
        Route::post('/user/resetpassword/{id}', [UserController::class, 'resetPassword'])->name('user.resetpassword');
        Route::post('/user/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('user.toggle_status');

    });

    Route::prefix('faq')->group(function () {
        Route::get('/create', [FaqController::class, 'index'])->name('faqs.index');
        Route::post('/store', [FaqController::class, 'store'])->name('faqs.store');
        Route::get('/delete/{id}', [FaqController::class, 'destroy'])->name('faq.delete');
        Route::post('/update_faq/{id}', [FaqController::class, 'update'])->name('faq.update');
    });
});

Route::middleware('auth')->get('/report/absensi', [ReportController::class, 'index'])->name('report.index');
Route::middleware('auth')->get('/report/admin/bkpsdm', [ReportController::class, 'indexAdmin'])->name('report.admin');


Route::prefix('absen')->middleware('auth')->group(function () {
    Route::get('hadir', [AbsensiController::class, 'index'])->name('absensi.index');

    // Dinas
    Route::post('/simpan-dinas', [DinasController::class, 'simpanDinas'])->name('simpan-dinas');
    Route::post('/simpan-cuti', [CutiController::class, 'simpanCuti'])->name('simpan-cuti');
    Route::post('/simpan-izin', [IzinController::class, 'simpanIzin'])->name('simpan-izin');
    Route::post('/simpan-sakit', [SakitController::class, 'simpanSakit'])->name('simpan-sakit');

    Route::get('dinas', [DinasController::class, 'index'])->name('dinas.index');
    Route::get('/edit_dinas/{id}', [DinasController::class, 'edit'])->name('dinas.edit');
    Route::post('/update_dinas/{id}', [DinasController::class, 'update'])->name('dinas.update');
    Route::get('/delete_dinas/{id}', [DinasController::class, 'destroy'])->name('dinas.delete');

    // Cuti
    Route::get('cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/edit_cuti/{id}', [CutiController::class, 'edit'])->name('cuti.edit');
    Route::post('/update_cuti/{id}', [CutiController::class, 'update'])->name('cuti.update');
    Route::get('/delete_cuti/{id}', [CutiController::class, 'destroy'])->name('cuti.delete');

    // Izin
    Route::get('izin', [IzinController::class, 'index'])->name('izin.index');
    Route::get('/edit_izin/{id}', [IzinController::class, 'edit'])->name('izin.edit');
    Route::post('/update_izin/{id}', [IzinController::class, 'update'])->name('izin.update');
    Route::get('/delete_izin/{id}', [IzinController::class, 'destroy'])->name('izin.delete');

    // Sakit
    Route::get('sakit', [SakitController::class, 'index'])->name('sakit.index');
    Route::get('/edit_sakit/{id}', [SakitController::class, 'edit'])->name('sakit.edit');
    Route::post('/update_sakit/{id}', [SakitController::class, 'update'])->name('sakit.update');
    Route::get('/delete_sakit/{id}', [SakitController::class, 'destroy'])->name('sakit.delete');

    // Absen
    Route::post('/insert_absensi', [AbsensiController::class, 'store'])->name('absensi.insert');
    Route::post('/absen/insert_keluar/{id}', [AbsensiController::class, 'insertKeluar'])->name('absensi.insert_keluar');

    Route::get('/filter', [ReportController::class, 'filterLaporan'])->name('filter');
    Route::get('/print/report/{opd}', [ReportController::class, 'cetakLaporan'])->name('print.report');
});
// Route::get('/report/admin', [ReportController::class, 'filterLaporanAdmin'])->name('filter.admin');
Route::get('/report/admin/name', [ReportController::class, 'cetakLaporanByAdmin'])->name('filter.admin')->middleware(['auth']);

Route::post('/select-opd', [DinasController::class, 'selectOpd'])->name('select-opd');
Route::post('/filter-data', [ReportController::class, 'filterLaporan'])->name('filter-laporan');
Route::get('/user-coordinates', [AuthApiController::class, 'getUserCoordinates'])->middleware(['auth']);

Route::get('report/name', [ReportController::class, 'cetakLaporanByNama'])->name('report.nama')->middleware(['auth']);
Route::get('report/opd/name', [ReportController::class, 'cetakLaporanByOpdNama'])->name('report.opd.nama')->middleware(['auth']);

Route::get('report/mingguan', [ReportController::class, 'cetakLaporanMingguan'])->name('report.minggu')->middleware(['auth']);
Route::get('report/harian', [ReportController::class, 'cetakLaporanHarian'])->name('report.hari')->middleware(['auth']);


Route::get('/table/chart', [ChartController::class, 'index'])->name('report.table')->middleware(['auth']);
// routes/web.php
Route::get('/opd/get-users/{opd}', 'UserController@getUsersByOpd')->name('get.users.by.opd');
Route::get('/faq', [FaqController::class, 'show'])->name('faqs.show');

// Route::get('report/name', [ReportController::class, 'cetakLaporanUser'])->name('report.user');
Route::get('/select', function () {
    return view('select');
})->name('select.index');

Route::get('/get-jabatans/{opdId}', [OpdController::class, 'getJabatans']);
Route::get('/get-bidangs/{opdId}', [OpdController::class, 'getBidangs']);

Route::get('admin/user/insert_user', function () {
    abort(403, 'Forbidden'); // Melemparkan pengecualian 403 Forbidden jika metode HTTP adalah GET
})->name('insert_user')->middleware('auth');