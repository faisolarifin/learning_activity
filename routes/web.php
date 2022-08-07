<?php

use App\Http\Controllers\{Activity, Login, Master};
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

Route::get('/', [Login::class, 'login'])->name('auth');
Route::post('/', [Login::class, 'actionLogin'])->name('auth.check');
Route::get('/logout', [Login::class, 'logout'])->name('auth.logout');

Route::middleware('activity')->group(function() {

    Route::get('/home', [Activity::class, 'index'])->name('home');
    Route::post('/home', [Activity::class, 'jadwalAktivitas'])->name('lr.activity');
    
    Route::prefix('activity')->group(function() {
        Route::get('/trash', [Activity::class, 'indexTrashAktivitas'])->name('activity.trash.i');
        Route::get('/data', [Activity::class, 'getTrashAktivitas'])->name('activity.trash.r');
        Route::post('/restore', [Activity::class, 'restoreTrashAktivitas'])->name('activity.trash.res');
        Route::post('/delete', [Activity::class, 'deleteTrashAktivitas'])->name('activity.trash.d');
        Route::post('/restore/all', [Activity::class, 'restoreAllTrashAktivitas'])->name('activity.trash.resll');
        Route::post('/activity/delete/all', [Activity::class, 'deleteAllTrashAktivitas'])->name('activity.trash.dll');
        
        Route::get('/', [Activity::class, 'indexAktivitas'])->name('activity.i');
        Route::post('/activitydata/{id?}', [Activity::class, 'getAktivitas'])->name('activity.r');
        Route::post('/', [Activity::class, 'saveAktivitas'])->name('activity.s');
        Route::delete('/', [Activity::class, 'deleteAktivitas'])->name('activity.d');
        Route::put('/', [Activity::class, 'updateAktivitas'])->name('activity.u');
    });
    Route::prefix('bulan')->group(function() {
        Route::get('/trash', [Master::class, 'indexTrashBulan'])->name('bulan.trash.i');
        Route::get('/data', [Master::class, 'getTrashBulan'])->name('bulan.trash.r');
        Route::post('/restore', [Master::class, 'restoreTrashBulan'])->name('bulan.trash.res');
        Route::post('/delete', [Master::class, 'deleteTrashBulan'])->name('bulan.trash.d');
        Route::post('/restore/all', [Master::class, 'restoreAllTrashBulan'])->name('bulan.trash.resll');
        Route::post('/delete/all', [Master::class, 'deleteAllTrashBulan'])->name('bulan.trash.dll');
        
        Route::get('/', [Master::class, 'indexBulan'])->name('bulan.i');
        Route::get('/bulandata/{id?}', [Master::class, 'getBulan'])->name('bulan.r');
        Route::post('/', [Master::class, 'saveBulan'])->name('bulan.s');
        Route::delete('/', [Master::class, 'deleteBulan'])->name('bulan.d');
        Route::put('/', [Master::class, 'updateBulan'])->name('bulan.u');
    });
    Route::prefix('metode')->group(function() {
        Route::get('/trash', [Master::class, 'indexTrashMetode'])->name('metode.trash.i');
        Route::get('/data', [Master::class, 'getTrashMetode'])->name('metode.trash.r');
        Route::post('/restore', [Master::class, 'restoreTrashMetode'])->name('metode.trash.res');
        Route::post('/delete', [Master::class, 'deleteTrashMetode'])->name('metode.trash.d');
        Route::post('/restore/all', [Master::class, 'restoreAllTrashMetode'])->name('metode.trash.resll');
        Route::post('/delete/all', [Master::class, 'deleteAllTrashMetode'])->name('metode.trash.dll');
        
        Route::get('/', [Master::class, 'indexMetode'])->name('metode.i');
        Route::post('/metodedata/{id?}', [Master::class, 'getMetode'])->name('metode.r');
        Route::post('/', [Master::class, 'saveMetode'])->name('metode.s');
        Route::delete('/', [Master::class, 'deleteMetode'])->name('metode.d');
        Route::put('/', [Master::class, 'updateMetode'])->name('metode.u');
    });
    Route::prefix('tahun')->group(function() {
        Route::get('/trash', [Master::class, 'indexTrashTahun'])->name('tahun.trash.i');
        Route::get('/data', [Master::class, 'getTrashTahun'])->name('tahun.trash.r');
        Route::post('/restore', [Master::class, 'restoreTrashTahun'])->name('tahun.trash.res');
        Route::post('/delete', [Master::class, 'deleteTrashTahun'])->name('tahun.trash.d');
        Route::post('/restore/all', [Master::class, 'restoreAllTrashTahun'])->name('tahun.trash.resll');
        Route::post('/delete/all', [Master::class, 'deleteAllTrashTahun'])->name('tahun.trash.dll');
        
        Route::get('/', [Master::class, 'indexTahun'])->name('tahun.i');
        Route::get('/tahundata/{id?}', [Master::class, 'getTahun'])->name('tahun.r');
        Route::post('/', [Master::class, 'saveTahun'])->name('tahun.s');
        Route::delete('/', [Master::class, 'deleteTahun'])->name('tahun.d');
        Route::put('/', [Master::class, 'updateTahun'])->name('tahun.u');
    });
});    
