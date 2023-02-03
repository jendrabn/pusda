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

Route::middleware('visitor')->group(function () {
  Route::get('/', \App\Http\Controllers\Front\HomeController::class)->name('home');

  Route::group(['prefix' => 'bps', 'as' => 'bps.', 'controller' => \App\Http\Controllers\Front\BpsController::class], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{tabel}', 'tabel')->name('tabel');
    Route::get('/chart/{uraian}', 'chart')->name('chart');
  });

  Route::group(['prefix' => 'rpjmd', 'as' => 'rpjmd.', 'controller' => \App\Http\Controllers\Front\RpjmdController::class], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{tabel}', 'tabel')->name('tabel');
    Route::get('/chart/{uraian}', 'chart')->name('chart');
  });

  Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => \App\Http\Controllers\Front\DelapanKelDataController::class], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{tabel}', 'tabel')->name('tabel');
    Route::get('/chart/{uraian}', 'chart')->name('chart');
  });

  Route::group(['prefix' => 'indikator', 'as' => 'indikator.', 'controller' => \App\Http\Controllers\Front\IndikatorController::class], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{tabel}', 'tabel')->name('tabel');
    Route::get('/chart/{uraian}', 'chart')->name('chart');
  });

  Route::group(['controller' => \App\Http\Controllers\Front\SkpdController::class], function () {
    Route::get('/skpd', 'index')->name('skpd');
    Route::get('/skpd/{skpd}', 'menu')->name('delapankeldata.skpd');
  });
});

// Export isi uraian
Route::group(['prefix' => 'exports', 'as' => 'exports.', 'controller' => \App\Http\Controllers\ExportsController::class], function () {
  Route::get('/rpjmd/{tabel}', 'exportRpjmd')->name('rpjmd');
  Route::get('/bps/{tabel}', 'exportBps')->name('bps');
  Route::get('/delapankeldata/{tabel}', 'export8KelData')->name('delapankeldata');
  Route::get('/indikator/{tabel}', 'exportIndikator')->name('indikator');
});

Route::group(['middleware' => ['auth']], function () {

  Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile');
    Route::put('/profile/profile-information', 'updateProfileInformation')->name('update_profile_information');
    Route::put('/profile/password', 'updatePassword')->name('update_password');
  });

  Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:Administrator']], function () {

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
      Route::resource('delapankeldata', \App\Http\Controllers\Admin\TreeView\DelapanKelDataController::class)
        ->parameter('delapankeldata', 'tabel')
        ->except(['create', 'show']);
      Route::delete('/delapankeldata/massDestroy', [\App\Http\Controllers\Admin\TreeView\DelapanKelDataController::class, 'massDestroy'])
        ->name('delapankeldata.massDestroy');
      Route::resource('rpjmd', \App\Http\Controllers\Admin\TreeView\RpjmdController::class)
        ->parameter('rpjmd', 'tabel')
        ->except(['create', 'show']);
      Route::delete('/rpjmd/massDestroy', [\App\Http\Controllers\Admin\TreeView\RpjmdController::class, 'massDestroy'])
        ->name('rpjmd.massDestroy');
      Route::resource('indikator', \App\Http\Controllers\Admin\TreeView\IndikatorController::class)
        ->parameter('indikator', 'tabel')
        ->except(['create', 'show']);
      Route::delete('/indikator/massDestroy', [\App\Http\Controllers\Admin\TreeView\IndikatorController::class, 'massDestroy'])
        ->name('indikator.massDestroy');
      Route::resource('bps', \App\Http\Controllers\Admin\TreeView\BpsController::class)
        ->parameter('bps', 'tabel')
        ->except(['create', 'show']);
      Route::delete('/bps/massDestroy', [\App\Http\Controllers\Admin\TreeView\BpsController::class, 'massDestroy'])
        ->name('bps.massDestroy');
    });

    // Menu Form Uraian
    Route::group(['prefix' => 'uraian', 'as' => 'uraian.'], function () {

      // Menu Form Uraian RPJMD
      Route::group(['prefix' => 'rpjmd', 'as' => 'rpjmd.', 'controller' => \App\Http\Controllers\Admin\Uraian\RpjmdController::class], function () {
        Route::get('/{tabel?}', 'index')->name('index');
        Route::get('/{tabel}/{uraian}/edit', 'edit')->name('edit');
        Route::post('/{tabel}', 'store')->name('store');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        Route::delete('/delete/massDestroy', 'massDestroy')->name('massDestroy');
      });

      // Menu Form Uraian 8 Kel. Data
      Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => \App\Http\Controllers\Admin\Uraian\DelapanKelDataController::class], function () {
        Route::get('/{tabel?}', 'index')->name('index');
        Route::get('/{tabel}/{uraian}/edit', 'edit')->name('edit');
        Route::post('/{tabel}', 'store')->name('store');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        Route::delete('/delete/massDestroy', 'massDestroy')->name('massDestroy');
      });

      // Menu Form Uraian BPS
      Route::group(['prefix' => 'bps', 'as' => 'bps.', 'controller' => \App\Http\Controllers\Admin\Uraian\BpsController::class], function () {
        Route::get('/{tabel?}', 'index')->name('index');
        Route::get('/{tabel}/{uraian}/edit', 'edit')->name('edit');
        Route::post('/{tabel}', 'store')->name('store');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        Route::delete('/delete/massDestroy', 'massDestroy')->name('massDestroy');
      });

      // Menu Form Uraian Indikator
      Route::group(['prefix' => 'indikator', 'as' => 'indikator.', 'controller' => \App\Http\Controllers\Admin\Uraian\IndikatorController::class], function () {
        Route::get('/{tabel?}', 'index')->name('index');
        Route::get('/{tabel}/{uraian}/edit', 'edit')->name('edit');
        Route::post('/{tabel}', 'store')->name('store');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        Route::delete('/delete/massDestroy', 'massDestroy')->name('massDestroy');
      });
    });

    // 8 Kel. Data
    Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => App\Http\Controllers\Admin\DelapanKelDataController::class], function () {
      Route::get('/{category?}', 'index')->name('index');
      Route::get('/category/{category}', 'category')->name('category');
      Route::get('/input/{tabel}/{skpd?}', 'input')->name('input');
      Route::get('/{uraian}/edit', 'edit')->name('edit');
      Route::put('/{uraian}', 'update')->name('update');
      Route::delete('/{uraian}', 'destroy')->name('destroy');
      // fitur
      Route::put('/fitur/{fitur}', 'updateFitur')->name('update_fitur');
      // file pendukung
      Route::get('/files/{file}', 'downloadFile')->name('files.download');
      Route::post('/files/{tabel}', 'storeFile')->name('files.store');
      Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
      // sumber data
      Route::put('/sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
      // tahun
      Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
      Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
      // chart
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });

    // RPJMD
    Route::group(['prefix' => 'rpjmd', 'as' => 'rpjmd.', 'controller' => App\Http\Controllers\Admin\RpjmdController::class], function () {
      Route::get('/{category?}', 'index')->name('index');
      Route::get('/category/{category?}', 'category')->name('category');
      Route::get('/input/{tabel}/{skpd?}', 'input')->name('input');
      Route::get('/{uraian}/edit', 'edit')->name('edit');
      Route::put('/{uraian}', 'update')->name('update');
      Route::delete('/{uraian}', 'destroy')->name('destroy');
      // fitur
      Route::put('/fitur/{fitur}', 'updateFitur')->name('update_fitur');
      // file pendukung
      Route::get('/files/{file}', 'downloadFile')->name('files.download');
      Route::post('/files/{tabel}', 'storeFile')->name('files.store');
      Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
      // sumber data
      Route::put('/sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
      // tahun
      Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
      Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
      // chart
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });

    // Indikator
    Route::group(['prefix' => 'indikator', 'as' => 'indikator.', 'controller' => App\Http\Controllers\Admin\IndikatorController::class], function () {
      Route::get('/', 'index')->name('index');
      Route::get('/{tabel}', 'input')->name('input');
      Route::get('/{uraian}/edit', 'edit')->name('edit');
      Route::put('/{uraian}', 'update')->name('update');
      Route::delete('/{uraian}', 'destroy')->name('destroy');
      // fitur
      Route::put('/fitur/{fitur}', 'updateFitur')->name('update_fitur');
      // file pendukung
      Route::get('/files/{file}', 'downloadFile')->name('files.download');
      Route::post('/files/{tabel}', 'storeFile')->name('files.store');
      Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
      // tahun
      Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
      Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
      // chart
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });

    // BPS
    Route::group(['prefix' => 'bps', 'as' => 'bps.', 'controller' => App\Http\Controllers\Admin\BpsController::class], function () {
      Route::get('/', 'index')->name('index');
      Route::get('/{tabel}', 'input')->name('input');
      Route::get('/{uraian}/edit', 'edit')->name('edit');
      Route::put('/{uraian}', 'update')->name('update');
      Route::delete('/{uraian}', 'destroy')->name('destroy');
      // fitur
      Route::put('/fitur/{fitur}', 'updateFitur')->name('update_fitur');
      // file pendukung
      Route::get('/files/{file}', 'downloadFile')->name('files.download');
      Route::post('/files/{tabel}', 'storeFile')->name('files.store');
      Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
      // tahun
      Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
      Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
      // chart
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });
  });

  Route::group(['prefix' => 'admin-skpd', 'as' => 'admin_skpd.', 'middleware' => ['role:SKPD']], function () {
    Route::get('/', App\Http\Controllers\Skpd\DashboardController::class)->name('dashboard');

    // 8 Kel. Data
    Route::group(['prefix' => 'delapankeldata', 'as' => 'delapankeldata.', 'controller' => App\Http\Controllers\Skpd\DelapanKelDataController::class], function () {
      Route::get('/{category?}', 'index')->name('index');
      Route::get('/category/{category}', 'category')->name('category');
      Route::get('/input/{tabel}/{skpd?}', 'input')->name('input');
      Route::get('/{uraian}/edit', 'edit')->name('edit');
      Route::put('/{uraian}', 'update')->name('update');
      Route::delete('/{uraian}', 'destroy')->name('destroy');
      // fitur
      Route::put('/fitur/{fitur}', 'updateFitur')->name('update_fitur');
      // file pendukung
      Route::get('/files/{file}', 'downloadFile')->name('files.download');
      Route::post('/files/{tabel}', 'storeFile')->name('files.store');
      Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
      // sumber data
      Route::put('/sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
      // chart
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });

    // RPJMD
    Route::group(['prefix' => 'rpjmd', 'as' => 'rpjmd.', 'controller' => App\Http\Controllers\Skpd\RpjmdController::class], function () {
      Route::get('/{category?}', 'index')->name('index');
      Route::get('/category/{category?}', 'category')->name('category');
      Route::get('/input/{tabel}/{skpd?}', 'input')->name('input');
      Route::get('/{uraian}/edit', 'edit')->name('edit');
      Route::put('/{uraian}', 'update')->name('update');
      Route::delete('/{uraian}', 'destroy')->name('destroy');
      // fitur
      Route::put('/fitur/{fitur}', 'updateFitur')->name('update_fitur');
      // file pendukung
      Route::get('/files/{file}', 'downloadFile')->name('files.download');
      Route::post('/files/{tabel}', 'storeFile')->name('files.store');
      Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
      // sumber data
      Route::put('/sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
      // chart
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });
  });
});

Route::fallback(fn () => abort(404));
