<?php

use App\Models\User;
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

/**
 *
 * FRONT
 *
 */
Route::middleware('visitor')->group(function () {

  // Home
  Route::get('/', \App\Http\Controllers\Front\HomeController::class)
    ->name('home');

  // BPS
  Route::controller(\App\Http\Controllers\Front\BpsController::class)
    ->prefix('bps')
    ->name('bps.')
    ->group(function () {
      Route::get('/', 'index')->name('index');
      Route::get('/{tabel}', 'tabel')->name('tabel');
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });

  // RPJMD
  Route::controller(\App\Http\Controllers\Front\RpjmdController::class)
    ->prefix('rpjmd')
    ->name('rpjmd.')
    ->group(function () {
      Route::get('/', 'index')->name('index');
      Route::get('/{tabel}', 'tabel')->name('tabel');
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });

  // 8 Kel. Data
  Route::controller(\App\Http\Controllers\Front\DelapanKelDataController::class)
    ->prefix('delapankeldata')
    ->name('delapankeldata.')
    ->group(function () {
      Route::get('/', 'index')->name('index');
      Route::get('/{tabel}', 'tabel')->name('tabel');
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });

  // Indikator
  Route::controller(\App\Http\Controllers\Front\IndikatorController::class)
    ->prefix('indiator')
    ->name('indikator.')
    ->group(function () {
      Route::get('/', 'index')->name('index');
      Route::get('/{tabel}', 'tabel')->name('tabel');
      Route::get('/chart/{uraian}', 'chart')->name('chart');
    });

  // SKPD
  Route::controller(\App\Http\Controllers\Front\SkpdController::class)
    ->group(function () {
      Route::get('/skpd', 'index')->name('skpd');
      Route::get('/skpd/{skpd}', 'menu')->name('delapankeldata.skpd');
    });
});

// Export isi uraian
Route::controller(\App\Http\Controllers\ExportsController::class)
  ->prefix('exports')
  ->name('exports.')
  ->group(function () {
    Route::get('/rpjmd/{tabel}', 'exportRpjmd')->name('rpjmd');
    Route::get('/bps/{tabel}', 'exportBps')->name('bps');
    Route::get('/delapankeldata/{tabel}', 'export8KelData')->name('delapankeldata');
    Route::get('/indikator/{tabel}', 'exportIndikator')->name('indikator');
  });

// Profile
Route::middleware(['auth'])
  ->controller(App\Http\Controllers\ProfileController::class)
  ->group(function () {
    Route::get('/profile', 'index')->name('profile');
    Route::put('/profile/profile-information', 'updateProfileInformation')->name('update_profile_information');
    Route::put('/profile/password', 'updatePassword')->name('update_password');
  });

/**
 *
 * ROLE ADMINISTRATOR
 *
 */
Route::middleware(['auth', 'role:' . User::ROLE_ADMIN])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    // Dashboard
    Route::get('/', App\Http\Controllers\Admin\DashboardController::class)
      ->name('dashboard');

    // Audit Log
    Route::resource('audit-logs', \App\Http\Controllers\Admin\AuditLogsController::class, [
      'except' => ['create', 'store', 'edit', 'update', 'destroy']
    ]);

    // User
    Route::delete('/users/massDestroy', [\App\Http\Controllers\Admin\UserController::class, 'massDestroy'])
      ->name('users.massDestroy');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // SKPD
    Route::delete('/skpd/massDestroy', [\App\Http\Controllers\Admin\SkpdController::class, 'massDestroy'])
      ->name('skpd.massDestroy');
    Route::resource('skpd', \App\Http\Controllers\Admin\SkpdController::class)
      ->except(['show']);

    // Menu Tree View
    Route::prefix('treeview')
      ->name('treeview.')
      ->group(function () {
        Route::delete('/delapankeldata/massDestroy', [\App\Http\Controllers\Admin\TreeView\DelapanKelDataController::class, 'massDestroy'])
          ->name('delapankeldata.massDestroy');
        Route::delete('/rpjmd/massDestroy', [\App\Http\Controllers\Admin\TreeView\RpjmdController::class, 'massDestroy'])
          ->name('rpjmd.massDestroy');
        Route::delete('/bps/massDestroy', [\App\Http\Controllers\Admin\TreeView\BpsController::class, 'massDestroy'])
          ->name('bps.massDestroy');
        Route::delete('/indikator/massDestroy', [\App\Http\Controllers\Admin\TreeView\IndikatorController::class, 'massDestroy'])
          ->name('indikator.massDestroy');

        Route::resource('delapankeldata', \App\Http\Controllers\Admin\TreeView\DelapanKelDataController::class)
          ->parameter('delapankeldata', 'tabel')
          ->except(['create', 'show']);
        Route::resource('rpjmd', \App\Http\Controllers\Admin\TreeView\RpjmdController::class)
          ->parameter('rpjmd', 'tabel')
          ->except(['create', 'show']);
        Route::resource('indikator', \App\Http\Controllers\Admin\TreeView\IndikatorController::class)
          ->parameter('indikator', 'tabel')
          ->except(['create', 'show']);
        Route::resource('bps', \App\Http\Controllers\Admin\TreeView\BpsController::class)
          ->parameter('bps', 'tabel')
          ->except(['create', 'show']);
      });

    // Menu Form Uraian
    Route::prefix('uraian')
      ->name('uraian.')
      ->group(function () {

        // Menu Form Uraian RPJMD
        Route::controller(\App\Http\Controllers\Admin\Uraian\RpjmdController::class)
          ->prefix('rpjmd')
          ->name('rpjmd.')
          ->group(function () {
            Route::get('/{tabel?}', 'index')->name('index');
            Route::get('/{tabel}/{uraian}/edit', 'edit')->name('edit');
            Route::post('/{tabel}', 'store')->name('store');
            Route::put('/{uraian}', 'update')->name('update');
            Route::delete('/{uraian}', 'destroy')->name('destroy');
            Route::delete('/delete/massDestroy', 'massDestroy')->name('massDestroy');
          });

        // Menu Form Uraian 8 Kel. Data
        Route::controller(\App\Http\Controllers\Admin\Uraian\DelapanKelDataController::class)
          ->prefix('delapankeldata')
          ->name('delapankeldata.')
          ->group(function () {
            Route::get('/{tabel?}', 'index')->name('index');
            Route::get('/{tabel}/{uraian}/edit', 'edit')->name('edit');
            Route::post('/{tabel}', 'store')->name('store');
            Route::put('/{uraian}', 'update')->name('update');
            Route::delete('/{uraian}', 'destroy')->name('destroy');
            Route::delete('/delete/massDestroy', 'massDestroy')->name('massDestroy');
          });

        // Menu Form Uraian BPS
        Route::controller(\App\Http\Controllers\Admin\Uraian\BpsController::class)
          ->prefix('bps')
          ->name('bps.')
          ->group(function () {
            Route::get('/{tabel?}', 'index')->name('index');
            Route::get('/{tabel}/{uraian}/edit', 'edit')->name('edit');
            Route::post('/{tabel}', 'store')->name('store');
            Route::put('/{uraian}', 'update')->name('update');
            Route::delete('/{uraian}', 'destroy')->name('destroy');
            Route::delete('/delete/massDestroy', 'massDestroy')->name('massDestroy');
          });

        // Menu Form Uraian Indikator
        Route::controller(\App\Http\Controllers\Admin\Uraian\IndikatorController::class)
          ->prefix('indikator')
          ->name('indikator.')
          ->group(function () {
            Route::get('/{tabel?}', 'index')->name('index');
            Route::get('/{tabel}/{uraian}/edit', 'edit')->name('edit');
            Route::post('/{tabel}', 'store')->name('store');
            Route::put('/{uraian}', 'update')->name('update');
            Route::delete('/{uraian}', 'destroy')->name('destroy');
            Route::delete('/delete/massDestroy', 'massDestroy')->name('massDestroy');
          });
      });

    // 8 Kel. Data
    Route::controller(App\Http\Controllers\Admin\DelapanKelDataController::class)
      ->prefix('delapankeldata')
      ->name('delapankeldata.')
      ->group(function () {
        Route::get('/{category?}', 'index')->name('index');
        Route::get('/category/{category}', 'category')->name('category');
        Route::get('/input/{tabel}/{skpd?}', 'input')->name('input');
        Route::get('/{uraian}/edit', 'edit')->name('edit');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        // Fitur
        Route::put('/fitur/{tabel}', 'updateFitur')->name('update_fitur');
        // File pendukung
        Route::get('/files/{file}', 'downloadFile')->name('files.download');
        Route::post('/files/{tabel}', 'storeFile')->name('files.store');
        Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
        // Sumber data
        Route::put('/sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
        // Tahun
        Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
        Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        // Chart
        Route::get('/chart/{uraian}', 'chart')->name('chart');
      });

    // RPJMD
    Route::controller(App\Http\Controllers\Admin\RpjmdController::class)
      ->prefix('rpjmd')
      ->name('rpjmd.')
      ->group(function () {
        Route::get('/{category?}', 'index')->name('index');
        Route::get('/category/{category?}', 'category')->name('category');
        Route::get('/input/{tabel}/{skpd?}', 'input')->name('input');
        Route::get('/{uraian}/edit', 'edit')->name('edit');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        // Fitur
        Route::put('/fitur/{tabel}', 'updateFitur')->name('update_fitur');
        // File pendukung
        Route::get('/files/{file}', 'downloadFile')->name('files.download');
        Route::post('/files/{tabel}', 'storeFile')->name('files.store');
        Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
        // Sumber data
        Route::put('/sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
        // Tahun
        Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
        Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        // Chart
        Route::get('/chart/{uraian}', 'chart')->name('chart');
      });

    // Indikator
    Route::controller(App\Http\Controllers\Admin\IndikatorController::class)
      ->prefix('indikator')
      ->name('indikator.')
      ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{tabel}', 'input')->name('input');
        Route::get('/{uraian}/edit', 'edit')->name('edit');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        //Fitur
        Route::put('/fitur/{tabel}', 'updateFitur')->name('update_fitur');
        // File pendukung
        Route::get('/files/{file}', 'downloadFile')->name('files.download');
        Route::post('/files/{tabel}', 'storeFile')->name('files.store');
        Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
        // Tahun
        Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
        Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        // Chart
        Route::get('/chart/{uraian}', 'chart')->name('chart');
      });

    // BPS
    Route::controller(App\Http\Controllers\Admin\BpsController::class)
      ->prefix('bps')
      ->name('bps.')
      ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{tabel}', 'input')->name('input');
        Route::get('/{uraian}/edit', 'edit')->name('edit');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        // Fitur
        Route::put('/fitur/{tabel}', 'updateFitur')->name('update_fitur');
        // File pendukung
        Route::get('/files/{file}', 'downloadFile')->name('files.download');
        Route::post('/files/{tabel}', 'storeFile')->name('files.store');
        Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
        // Tahun
        Route::post('/tahun/{tabel}', 'storeTahun')->name('store_tahun');
        Route::delete('/tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
        // Chart
        Route::get('/chart/{uraian}', 'chart')->name('chart');
      });
  });

/**
 *
 *  ROLE SKPD
 *
 */
Route::middleware(['auth', 'role:' . User::ROLE_SKPD])
  ->prefix('admin-skpd')
  ->name('admin_skpd.')
  ->group(function () {

    // Dashboard
    Route::get('/', App\Http\Controllers\Skpd\DashboardController::class)->name('dashboard');

    // 8 Kel. Data
    Route::controller(App\Http\Controllers\Skpd\DelapanKelDataController::class)
      ->prefix('delapankeldata')
      ->name('delapankeldata.')
      ->group(function () {
        Route::get('/{category?}', 'index')->name('index');
        Route::get('/category/{category}', 'category')->name('category');
        Route::get('/input/{tabel}', 'input')->name('input');
        Route::get('/{uraian}/edit', 'edit')->name('edit');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        // Fitur
        Route::put('/fitur/{tabel}', 'updateFitur')->name('update_fitur');
        // File pendukung
        Route::get('/files/{file}', 'downloadFile')->name('files.download');
        Route::post('/files/{tabel}', 'storeFile')->name('files.store');
        Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
        // Sumber data
        Route::put('/sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
        // Chart
        Route::get('/chart/{uraian}', 'chart')->name('chart');
      });

    // RPJMD
    Route::controller(App\Http\Controllers\Skpd\RpjmdController::class)
      ->prefix('rpjmd')
      ->name('rpjmd.')
      ->group(function () {
        Route::get('/{category?}', 'index')->name('index');
        Route::get('/category/{category?}', 'category')->name('category');
        Route::get('/input/{tabel}', 'input')->name('input');
        Route::get('/{uraian}/edit', 'edit')->name('edit');
        Route::put('/{uraian}', 'update')->name('update');
        Route::delete('/{uraian}', 'destroy')->name('destroy');
        // Fitur
        Route::put('/fitur/{tabel}', 'updateFitur')->name('update_fitur');
        // File pendukung
        Route::get('/files/{file}', 'downloadFile')->name('files.download');
        Route::post('/files/{tabel}', 'storeFile')->name('files.store');
        Route::delete('/files/{file}', 'destroyFile')->name('files.destroy');
        // Sumber data
        Route::put('/sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
        // Chart
        Route::get('/chart/{uraian}', 'chart')->name('chart');
      });
  });
