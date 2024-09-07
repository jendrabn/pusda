<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SkpdController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuditLogController;

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

// Auth
Route::controller(AuthController::class)->middleware('guest')->prefix('auth')->name('auth.')->group(function () {
	Route::get('login', 'login')->name('login');
	Route::post('login', 'login')->name('login.post');
	Route::get('forgot-password', 'forgotPassword')->name('forgot-password');
	Route::post('forgot-password', 'sendResetPasswordLink')->name('forgot-password.post');
	Route::get('reset-password', 'resetPassword')->name('reset-password');
	Route::put('reset-password', 'resetPassword')->name('reset-password.put');
});
Route::middleware('auth')->post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Front
Route::middleware('visitor_counter')->group(function () {

	// Home
	Route::get('/', \App\Http\Controllers\Front\HomeController::class)->name('home');

	// BPS
	Route::controller(\App\Http\Controllers\Front\BpsController::class)->prefix('bps')->name('bps.')->group(function () {
		Route::get('/', 'index')->name('index');
		Route::get('/{tabel}', 'tabel')->name('tabel');
		Route::get('/chart/{uraian}', 'chart')->name('chart');
	});

	// RPJMD
	Route::controller(\App\Http\Controllers\Front\RpjmdController::class)->prefix('rpjmd')->name('rpjmd.')->group(function () {
		Route::get('/', 'index')->name('index');
		Route::get('/{tabel}', 'tabel')->name('tabel');
		Route::get('/chart/{uraian}', 'chart')->name('chart');
	});

	// 8 Kel. Data
	Route::controller(\App\Http\Controllers\Front\DelapanKelDataController::class)->prefix('delapankeldata')->name('delapankeldata.')->group(function () {
		Route::get('/', 'index')->name('index');
		Route::get('/{tabel}', 'tabel')->name('tabel');
		Route::get('/chart/{uraian}', 'chart')->name('chart');
	});

	// Indikator
	Route::controller(\App\Http\Controllers\Front\IndikatorController::class)->prefix('indiator')->name('indikator.')->group(function () {
		Route::get('/', 'index')->name('index');
		Route::get('/{tabel}', 'tabel')->name('tabel');
		Route::get('/chart/{uraian}', 'chart')->name('chart');
	});

	// SKPD
	Route::controller(\App\Http\Controllers\Front\SkpdController::class)->group(function () {
		Route::get('/skpd', 'index')->name('skpd');
		Route::get('/skpd/{skpd}', 'menu')->name('delapankeldata.skpd');
	});
});



// Admin Panel
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
	// Dashboard
	Route::get('/', DashboardController::class)->name('dashboard');

	// Export Isi Uraian
	Route::middleware('role:' . implode('|', User::ROLES))->prefix('exports')->controller(\App\Http\Controllers\ExportController::class)->prefix('exports')->name('exports.')->group(function () {
		Route::get('rpjmd/{tabel}', 'exportRpjmd')->name('rpjmd');
		Route::get('bps/{tabel}', 'exportBps')->name('bps');
		Route::get('delapankeldata/{tabel}', 'export8KelData')->name('delapankeldata');
		Route::get('indikator/{tabel}', 'exportIndikator')->name('indikator');
	});

	// Profile
	Route::middleware('role:' . implode('|', User::ROLES))->controller(App\Http\Controllers\ProfileController::class)->middleware('auth')->group(function () {
		Route::get('profile', 'index')->name('profile');
		Route::put('profile/profile', 'updateProfile')->name('update_profile');
		Route::put('profile/password', 'updatePassword')->name('update_password');
	});

	// Audit Logs
	Route::resource('audit-logs', AuditLogController::class)->middleware('role:' . User::ROLE_ADMIN)->only('index', 'show');

	// User
	Route::delete('users/massDestroy', [UserController::class, 'massDestroy'])->middleware('role:' . User::ROLE_ADMIN)->name('users.massDestroy');
	Route::resource('users', UserController::class)->middleware('role:' . User::ROLE_ADMIN);

	// SKPD
	Route::delete('skpd/massDestroy', [SkpdController::class, 'massDestroy'])->middleware('role:' . User::ROLE_ADMIN)->name('skpd.massDestroy');
	Route::resource('skpd', SkpdController::class)->middleware('role:' . User::ROLE_ADMIN)->except('show');

	// Menu Tree View
	Route::middleware('role:' . User::ROLE_ADMIN)->prefix('treeview')->name('treeview.')->group(function () {
		Route::delete('delapankeldata/massDestroy', [\App\Http\Controllers\Admin\TreeView\DelapanKelDataController::class, 'massDestroy'])->name('delapankeldata.massDestroy');
		Route::delete('rpjmd/massDestroy', [\App\Http\Controllers\Admin\TreeView\RpjmdController::class, 'massDestroy'])
			->name('rpjmd.massDestroy');
		Route::delete('bps/massDestroy', [\App\Http\Controllers\Admin\TreeView\BpsController::class, 'massDestroy'])
			->name('bps.massDestroy');
		Route::delete('indikator/massDestroy', [\App\Http\Controllers\Admin\TreeView\IndikatorController::class, 'massDestroy'])
			->name('indikator.massDestroy');

		Route::resource('delapankeldata', \App\Http\Controllers\Admin\TreeView\DelapanKelDataController::class)
			->parameter('delapankeldata', 'tabel')
			->except(['create', 'show', 'edit']);
		Route::resource('rpjmd', \App\Http\Controllers\Admin\TreeView\RpjmdController::class)
			->parameter('rpjmd', 'tabel')
			->except(['create', 'show', 'edit']);
		Route::resource('indikator', \App\Http\Controllers\Admin\TreeView\IndikatorController::class)
			->parameter('indikator', 'tabel')
			->except(['create', 'show', 'edit']);
		Route::resource('bps', \App\Http\Controllers\Admin\TreeView\BpsController::class)
			->parameter('bps', 'tabel')
			->except(['create', 'show', 'edit']);
	});

	// Menu Form Uraian
	Route::middleware('role:' . User::ROLE_ADMIN)->prefix('uraian')->name('uraian.')->group(function () {
		// Menu Form Uraian RPJMD
		Route::controller(\App\Http\Controllers\Admin\Uraian\RpjmdController::class)->prefix('rpjmd')->name('rpjmd.')->group(function () {
			Route::get('{tabel?}', 'index')->name('index');
			Route::get('uraians/{tabel}', 'uraians')->name('uraians');
			Route::post('{tabel}', 'store')->name('store');
			Route::put('{uraian}', 'update')->name('update');
			Route::delete('massDestroy', 'massDestroy')->name('massDestroy');
			Route::delete('{uraian}', 'destroy')->name('destroy');
		});

		// Menu Form Uraian 8 Kel. Data
		Route::controller(\App\Http\Controllers\Admin\Uraian\DelapanKelDataController::class)->prefix('delapankeldata')->name('delapankeldata.')->group(function () {
			Route::get('{tabel?}', 'index')->name('index');
			Route::get('uraians/{tabel}', 'uraians')->name('uraians');
			Route::post('{tabel}', 'store')->name('store');
			Route::put('{uraian}', 'update')->name('update');
			Route::delete('massDestroy', 'massDestroy')->name('massDestroy');
			Route::delete('{uraian}', 'destroy')->name('destroy');
		});

		// Menu Form Uraian BPS
		Route::controller(\App\Http\Controllers\Admin\Uraian\BpsController::class)->prefix('bps')->name('bps.')->group(function () {
			Route::get('{tabel?}', 'index')->name('index');
			Route::get('uraians/{tabel}', 'uraians')->name('uraians');
			Route::post('{tabel}', 'store')->name('store');
			Route::put('{uraian}', 'update')->name('update');
			Route::delete('massDestroy', 'massDestroy')->name('massDestroy');
			Route::delete('{uraian}', 'destroy')->name('destroy');
		});

		// Menu Form Uraian Indikator
		Route::controller(\App\Http\Controllers\Admin\Uraian\IndikatorController::class)->prefix('indikator')->name('indikator.')->group(function () {
			Route::get('{tabel?}', 'index')->name('index');
			Route::get('uraians/{tabel}', 'uraians')->name('uraians');
			Route::post('{tabel}', 'store')->name('store');
			Route::put('{uraian}', 'update')->name('update');
			Route::delete('massDestroy', 'massDestroy')->name('massDestroy');
			Route::delete('{uraian}', 'destroy')->name('destroy');
		});
	});

	// 8 Kel. Data
	Route::middleware('role:' . implode('|', User::ROLES))->controller(App\Http\Controllers\Admin\DelapanKelDataController::class)->prefix('delapankeldata')->name('delapankeldata.')->group(function () {
		Route::get('/', 'index')->name('index');
		Route::get('kategori/{kategoriSkpd}', 'category')->name('category');
		Route::get('input/{tabel}/{skpd?}', 'input')->name('input');
		Route::get('{uraian}/edit', 'edit')->name('edit');
		Route::put('{uraian}', 'update')->name('update');
		// Fitur
		Route::put('fitur/{tabel}', 'updateFitur')->name('update_fitur');
		// File pendukung
		Route::get('files/{file}', 'downloadFile')->name('files.download');
		Route::get('files/{file}', 'downloadFile')->name('files.download');
		Route::post('files/{tabel}', 'storeFile')->name('files.store');
		Route::delete('files/massDestroy', 'massDestroyFile')->name('files.massDestroyFile');
		Route::delete('files/{file}', 'destroyFile')->name('files.destroy');
		// Sumber data
		Route::put('sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
		// Tahun
		Route::post('tahun/{tabel}', 'storeTahun')->name('store_tahun');
		Route::delete('tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
		// Chart
		Route::get('chart/{uraian}', 'chart')->name('chart');
	});

	// RPJMD
	Route::middleware('role:' . implode('|', User::ROLES))->controller(App\Http\Controllers\Admin\RpjmdController::class)->prefix('rpjmd')->name('rpjmd.')->group(function () {
		Route::get('{category?}', 'index')->name('index');
		Route::get('category/{kategoriSkpd}', 'category')->name('category');
		Route::get('input/{tabel}/{skpd?}', 'input')->name('input');
		Route::get('{uraian}/edit', 'edit')->name('edit');
		Route::put('{uraian}', 'update')->name('update');
		// Fitur
		Route::put('fitur/{tabel}', 'updateFitur')->name('update_fitur');
		// File pendukung
		Route::get('files/{file}', 'downloadFile')->name('files.download');
		Route::post('files/{tabel}', 'storeFile')->name('files.store');
		Route::delete('files/massDestroy', 'massDestroyFile')->name('files.massDestroyFile');
		Route::delete('files/{file}', 'destroyFile')->name('files.destroy');
		// Sumber data
		Route::put('sumber_data/{uraian}', 'updateSumberData')->name('update_sumber_data');
		// Tahun
		Route::post('tahun/{tabel}', 'storeTahun')->name('store_tahun');
		Route::delete('tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
		// Chart
		Route::get('chart/{uraian}', 'chart')->name('chart');
	});

	// Indikator
	Route::middleware('role:' . User::ROLE_ADMIN)->controller(App\Http\Controllers\Admin\IndikatorController::class)->prefix('indikator')->name('indikator.')->group(function () {
		Route::get('{tabel?}', 'index')->name('index');
		Route::get('input/{tabel}/{skpd?}', 'index')->name('input');
		Route::get('{uraian}/edit', 'edit')->name('edit');
		Route::put('{uraian}', 'update')->name('update');
		//Fitur
		Route::put('fitur/{tabel}', 'updateFitur')->name('update_fitur');
		// File pendukung
		Route::get('files/{file}', 'downloadFile')->name('files.download');
		Route::post('files/{tabel}', 'storeFile')->name('files.store');
		Route::delete('files/massDestroy', 'massDestroyFile')->name('files.massDestroyFile');
		Route::delete('files/{file}', 'destroyFile')->name('files.destroy');
		// Tahun
		Route::post('tahun/{tabel}', 'storeTahun')->name('store_tahun');
		Route::delete('tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
		// Chart
		Route::get('chart/{uraian}', 'chart')->name('chart');
	});

	// BPS
	Route::middleware('role:' . User::ROLE_ADMIN)->controller(App\Http\Controllers\Admin\BpsController::class)->prefix('bps')->name('bps.')->group(function () {
		Route::get('{tabel?}', 'index')->name('index');
		Route::get('input/{tabel}/{skpd?}', 'index')->name('input');
		Route::get('{uraian}/edit', 'edit')->name('edit');
		Route::put('{uraian}', 'update')->name('update');
		// Fitur
		Route::put('fitur/{tabel}', 'updateFitur')->name('update_fitur');
		// File pendukung
		Route::get('files/{file}', 'downloadFile')->name('files.download');
		Route::post('files/{tabel}', 'storeFile')->name('files.store');
		Route::delete('files/massDestroy', 'massDestroyFile')->name('files.massDestroyFile');
		Route::delete('files/{file}', 'destroyFile')->name('files.destroy');
		// Tahun
		Route::post('tahun/{tabel}', 'storeTahun')->name('store_tahun');
		Route::delete('tahun/{tabel}/{tahun}', 'destroyTahun')->name('destroy_tahun');
		// Chart
		Route::get('chart/{uraian}', 'chart')->name('chart');
	});
});

// Role SKPD
Route::fallback(function () {
	return abort(404);
});
