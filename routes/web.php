<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => false
]);

Route::get('/view/admin3', fn () => view('layouts.admin3'));

Route::middleware('visitor')->group(function () {
    Route::get('/', \App\Http\Controllers\Front\HomeController::class)->name('home');

    Route::group(['prefix' => 'bps', 'as' => 'bps.', 'controller' => \App\Http\Controllers\Front\BpsController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'table')->name('table');
        Route::get('/chart_data/{id}', 'getUraianForChart');
        Route::get('/chart_summary/{id}', 'getSummaryUraianForChart');
    });

    Route::group(['prefix' => 'rpjmd', 'as' => 'rpjmd.', 'controller' => \App\Http\Controllers\Front\RpjmdController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'table')->name('table');
        Route::get('/chart_data/{id}', 'getUraianForChart');
    });

    Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => \App\Http\Controllers\Front\DelapanKelDataController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'table')->name('table');
        Route::get('/chart_data/{id}', 'getUraianForChart');
    });

    Route::group(['prefix' => 'indikator', 'as' => 'indikator.', 'controller' => \App\Http\Controllers\Front\IndikatorController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'table')->name('table');
        Route::get('/chart_data/{id}', 'getUraianForChart');
    });

    Route::group(['controller' => \App\Http\Controllers\Front\SkpdController::class], function () {
        Route::get('/skpd', 'index')->name('skpd');
        Route::get('/skpd/{id}', 'delapankeldata')->name('delapankeldata.skpd');
    });
});

// Export isi uraian
Route::group(['prefix' => 'exports', 'as' => 'exports.', 'controller' => \App\Http\Controllers\ExportController::class], function () {
    Route::get('/rpjmd/{tabelRpjmd}', 'exportRpjmd')->name('rpjmd');
    Route::get('/bps/{tabelBps}', 'exportBps')->name('bps');
    Route::get('/delapankeldata/{tabel8KelData}', 'export8KelData')->name('delapankeldata');
    Route::get('/indikator/{tabelIndikator}', 'exportIndikator')->name('indikator');
});

Route::group(['middleware' => ['auth']], function () {

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::put('/profile/profile-information', 'updateProfileInformation')->name('update_profile_information');
        Route::put('/profile/password', 'updatePassword')->name('update_password');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:1']], function () {

        // Dashboard
        Route::get('/', App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

        // Audit Logs
        Route::resource('audit-logs', \App\Http\Controllers\Admin\AuditLogsController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

        // Users
        Route::delete('/users/massDestroy', [\App\Http\Controllers\Admin\UsersController::class, 'massDestroy'])->name('users.massDestroy');
        Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);

        // SKPD
        Route::delete('/skpd/massDestroy', [\App\Http\Controllers\Admin\SkpdController::class, 'massDestroy'])->name('skpd.massDestroy');
        Route::resource('skpd', \App\Http\Controllers\Admin\SkpdController::class)->except(['show']);

        // Menu Tree View
        Route::group(['prefix' => 'treeview', 'as' => 'treeview.'], function () {
            Route::delete('/delapankeldata/massDestroy', [\App\Http\Controllers\Admin\TreeView\DelapanKelDataController::class, 'massDestroy'])
                ->name('delapankeldata.massDestroy');
            Route::delete('/rpjmd/massDestroy', [\App\Http\Controllers\Admin\TreeView\RpjmdController::class, 'massDestroy'])
                ->name('rpjmd.massDestroy');
            Route::delete('/indikator/massDestroy', [\App\Http\Controllers\Admin\TreeView\IndikatorController::class, 'massDestroy'])
                ->name('indikator.massDestroy');
            Route::delete('/bps/massDestroy', [\App\Http\Controllers\Admin\TreeView\BpsController::class, 'massDestroy'])
                ->name('bps.massDestroy');
            Route::resource('delapankeldata', \App\Http\Controllers\Admin\TreeView\DelapanKelDataController::class)
                ->parameter('delapankeldata', 'table')
                ->except(['create', 'show']);
            Route::resource('rpjmd', \App\Http\Controllers\Admin\TreeView\RpjmdController::class)
                ->parameter('rpjmd', 'table')
                ->except(['create', 'show']);
            Route::resource('indikator', \App\Http\Controllers\Admin\TreeView\IndikatorController::class)
                ->parameter('indikator', 'table')
                ->except(['create', 'show']);
            Route::resource('bps', \App\Http\Controllers\Admin\TreeView\BpsController::class)
                ->parameter('bps', 'table')
                ->except(['create', 'show']);
        });

        // Menu Form Uraian
        Route::group(['prefix' => 'uraian', 'as' => 'uraian.'], function () {

            // RPJMD
            Route::group(['prefix' => 'rpjmd', 'as' => 'rpjmd.', 'controller' => \App\Http\Controllers\Admin\Uraian\RpjmdController::class], function () {
                Route::get('/{table?}', 'index')->name('index');
                Route::get('/{table}/{uraian}/edit', 'edit')->name('edit');
                Route::post('/', 'store')->name('store');
                Route::put('/{uraian}', 'update')->name('update');
                Route::delete('/{uraian}', 'destroy')->name('destroy');
            });

            // 8 Kel. Data
            Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => \App\Http\Controllers\Admin\Uraian\DelapanKelDataController::class], function () {
                Route::get('/{table?}', 'index')->name('index');
                Route::get('/{table}/{uraian}/edit', 'edit')->name('edit');
                Route::post('/', 'store')->name('store');
                Route::put('/{uraian}', 'update')->name('update');
                Route::delete('/{uraian}', 'destroy')->name('destroy');
            });

            // BPS
            Route::group(['prefix' => 'bps', 'as' => 'bps.', 'controller' => \App\Http\Controllers\Admin\Uraian\BpsController::class], function () {
                Route::get('/{table?}', 'index')->name('index');
                Route::get('/{table}/{uraian}/edit', 'edit')->name('edit');
                Route::post('/', 'store')->name('store');
                Route::put('/{uraian}', 'update')->name('update');
                Route::delete('/{uraian}', 'destroy')->name('destroy');
            });

            // Indikator
            Route::group(['prefix' => 'indikator', 'as' => 'indikator.', 'controller' => \App\Http\Controllers\Admin\Uraian\IndikatorController::class], function () {
                Route::get('/{table?}', 'index')->name('index');
                Route::get('/{table}/{uraian}/edit', 'edit')->name('edit');
                Route::post('/', 'store')->name('store');
                Route::put('/{uraian}', 'update')->name('update');
                Route::delete('/{uraian}', 'destroy')->name('destroy');
            });
        });

        // 8 Kel. Data
        Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => App\Http\Controllers\Admin\DelapanKelDataController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{tabel}', 'input')->name('input');
            Route::get('/category/{category}', 'category')->name('category');
            Route::get('/skpd/{skpd}', 'skpd')->name('skpd');

            Route::put('/sumber-data/{uraian?}', 'updateSumberData')->name('updateSumberData');
            Route::get('/{uraian}/edit', 'edit')->name('edit');
            Route::get('/graphic/{uraian?}', 'graphic')->name('graphic');
            Route::put('/{uraian}', 'update')->name('update_isi_uraian');
            Route::delete('/{uraian}', 'destroy')->name('destroy');




            // Fitur
            Route::put('/fitur/{fitur}', 'updateFitur')->name('update_fitur');
            // File
            Route::post('/files/{tabel}', 'storeFile')->name('files.store');
            Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
            Route::get('/files/download/{file}', 'downloadFile')->name('files.download');
            // Sumber Data
            // Tahun
            Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
            Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        });

        // 8 Kel. Data
        Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => App\Http\Controllers\Admin\DelapanKelDataController::class], function () {
            Route::get('/{kategoriSkpd?}', 'index')->name('index');
            Route::get('/skpd/{skpd}', 'skpd')->name('skpd');
            Route::get('/input/{tabel}/{skpd?}', 'input')->name('input');
            Route::get('/{uraian}/edit', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
            Route::delete('/{uraian8KelData}', 'destroy')->name('destroy');
            Route::put('/fitur/{fitur8KelData}', 'updateFitur')->name('update_fitur');
            Route::post('/files/{tabel}', 'storeFile')->name('files.store');
            Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
            Route::get('/files/download/{file}', 'downloadFile')->name('files.download');
            Route::put('/sumber_data/{uraian8KelData}', 'updateSumberData');
            Route::post('/tahun/{tabel8KelData}', 'storeTahun')->name('store_tahun');
            Route::delete('/tahun/{tabel8KelData}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        });

        // RPJMD
        Route::group(['prefix' => 'rpjmd', 'as' => 'rpjmd.', 'controller' => App\Http\Controllers\Admin\RpjmdController::class], function () {
            Route::get('/{kategoriSkpd?}', 'index')->name('index');
            Route::get('/skpd/{skpd}', 'skpd')->name('skpd');
            Route::get('/input/{tabelRpjmd}/{skpd?}', 'input')->name('input');
            Route::get('/{uraianRpjmd}/edit', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
            Route::delete('/{uraianRpjmd}', 'destroy')->name('destroy');
            Route::put('/fitur/{fiturRpjmd}', 'updateFitur')->name('update_fitur');
            Route::post('/files/{tabelRpjmd}', 'storeFile')->name('files.store');
            Route::delete('/files/{fileRpjmd}', 'destroyFile')->name('files.destroy');
            Route::get('/files/download/{fileRpjmd}', 'downloadFile')->name('files.download');
            Route::put('/sumber_data/{uraianRpjmd}', 'updateSumberData');
            Route::post('/tahun/{tabelRpjmd}', 'storeTahun')->name('store_tahun');
            Route::delete('/tahun/{tabelRpjmd}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        });

        // Indikator
        Route::group(['prefix' => 'indikator', 'as' => 'indikator.', 'controller' => App\Http\Controllers\Admin\IndikatorController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{tabelIndikator}', 'input')->name('input');
            Route::get('/{uraianIndikator}/edit', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
            Route::delete('/{uraianIndikator}', 'destroy')->name('destroy');
            Route::put('/fitur{fiturIndikator}', 'updateFitur')->name('update_fitur');
            Route::post('/files/{tabelIndikator}', 'storeFile')->name('files.store');
            Route::delete('/files/{fileIndikator}', 'destroyFile')->name('files.destroy');
            Route::get('/files/download/{fileIndikator}', 'downloadFile')->name('files.download');
            Route::post('/tahun/{tabelIndikator}', 'storeTahun')->name('store_tahun');
            Route::delete('/tahun/{tabelIndikator}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        });

        // BPS
        Route::group(['prefix' => 'bps', 'as' => 'bps.', 'controller' => App\Http\Controllers\Admin\BpsController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/input/{tabelBps}', 'input')->name('input');
            Route::get('/{uraianBps}/edit', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
            Route::delete('/{uraianBps}', 'destroy')->name('destroy');
            Route::put('/fitur/{fiturBps}', 'updateFitur')->name('update_fitur');
            Route::post('/files/{tabelBps}', 'storeFile')->name('files.store');
            Route::delete('/files/{fileBps}', 'destroyFile')->name('files.destroy');
            Route::get('/files/download/{fileBps}', 'downloadFile')->name('files.download');
            Route::post('tahun/{tabelBps}', 'storeTahun')->name('store_tahun');
            Route::delete('tahun/{tabelBps}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        });
    });

    Route::group(['prefix' => 'admin-skpd', 'as' => 'admin-skpd.', 'middleware' => ['role:2']], function () {
        Route::get('/', App\Http\Controllers\Skpd\DashboardController::class)->name('dashboard');

        // 8 Kel. Data
        Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => App\Http\Controllers\Skpd\DelapanKelDataController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{tabel8KelData}', 'input')->name('input');
            Route::get('/{uraian8KelData}/edit', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
            Route::delete('/{uraian8KelData}', 'destroy')->name('destroy');
            Route::put('/fitur/{fitur8KelData}', 'updateFitur')->name('update_fitur');
            Route::post('/files/{tabel8KelData}', 'storeFile')->name('files.store');
            Route::delete('/files/{file8KelData}', 'destroyFile')->name('files.destroy');
            Route::get('/files/download/{file8KelData}', 'downloadFile')->name('files.download');
        });

        // RPJMD
        Route::group(['prefix' => 'rpjmd', 'as' => 'rpjmd.', 'controller' => App\Http\Controllers\Skpd\RpjmdController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{tabelRpjmd}', 'input')->name('input');
            Route::get('/{uraianRpjmd}/edit', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
            Route::delete('/{uraianRpjmd}', 'destroy')->name('destroy');
            Route::put('/fitur/{fiturRpjmd}', 'updateFitur')->name('update_fitur');
            Route::post('/files/{tabelRpjmd}', 'storeFile')->name('files.store');
            Route::delete('/files/{fileRpjmd}', 'destroyFile')->name('files.destroy');
            Route::get('/files/download/{fileRpjmd}', 'downloadFile')->name('files.download');
        });
    });
});

Route::fallback(fn () => abort(404));
