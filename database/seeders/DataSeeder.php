<?php

namespace Database\Seeders;

use App\Models\Fitur8KelData;
use App\Models\FiturBps;
use App\Models\FiturIndikator;
use App\Models\FiturRpjmd;
use App\Models\Isi8KelData;
use App\Models\IsiBps;
use App\Models\IsiIndikator;
use App\Models\IsiRpjmd;
use App\Models\KategoriSkpd;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use App\Models\TabelBps;
use App\Models\TabelIndikator;
use App\Models\TabelRpjmd;
use App\Models\Uraian8KelData;
use App\Models\UraianBps;
use App\Models\UraianIndikator;
use App\Models\UraianRpjmd;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$data = collect(json_decode(file_get_contents(database_path('seeders/pusda.json')), true))->where('type', 'table');

		// kategori skpd
		$data_kategoriskpd = collect(['Badan', 'Dinas', 'Lainnya', 'Bagian', 'UPTD'])->map(function ($item) {
			return [
				'nama' => $item,
			];
		});

		KategoriSkpd::insert($data_kategoriskpd->toArray());

		// skpd
		$data_skpd = collect($data->where('name', 'skpd')->first()['data'])->map(function ($item) {
			return [
				'id' => $item['id_skpd'],
				'nama' => $item['nama_skpd'],
				'singkatan' => $item['singkatan_skpd'],
				'kategori_skpd_id' => KategoriSkpd::where('nama', $item['kategori_skpd'])->first()['id'] ?? null,
				'created_at' => now(),
				'updated_at' => now(),
			];
		});

		Skpd::insert($data_skpd->toArray());

		// users
		$data_users = collect($data->where('name', 'users')->first()['data'])->map(function ($item) {
			return [
				'id' => $item['id'],
				'skpd_id' => $item['id_skpd'],
				'name' => $item['name'],
				'username' => $item['username'],
				'email' => $item['email'],
				'email_verified_at' => null,
				'phone' => $item['no_hp'],
				'address' => $item['alamat'],
				'avatar' => null,
				'birth_date' => null,
				'role' => $item['level'] == "1" ? 'Administrator' : 'SKPD',
				'password' => $item['password'],
				'remember_token' => $item['remember_token'],
				'created_at' => $item['created_at'],
				'updated_at' => $item['updated_at'],
			];
		});

		User::insert($data_users->toArray());

		User::all()->each(function ($user) {
			$user->assignRole($user->role);
		});

		// tabel 8 kel. data
		$data_tabel8keldata = collect($data->where('name', 'tabel_8keldata')->first()['data']);
		$data_tabel8keldata_ids = $data_tabel8keldata->pluck(null, 'id_tabel_8keldata')->toArray();

		$data_tabel8keldata = $data_tabel8keldata->map(function ($item) use ($data_tabel8keldata_ids) {
			return [
				'id' => $item['id_tabel_8keldata'],
				'skpd_id' => $item['id_skpd'],
				'parent_id' => isset($data_tabel8keldata_ids[$item['id_parent']]) ? $item['id_parent'] : null,
				'nama_menu' => $item['nama_menu'],
				'created_at' => $item['created_at'],
				'updated_at' => $item['updated_at'],
			];
		});

		Tabel8KelData::insert($data_tabel8keldata->toArray());


		// tabel rpjmd
		$data_tabelrpjmd = collect($data->where('name', 'tabel_rpjmd')->first()['data']);
		$data_tabelrpjmd_ids = $data_tabelrpjmd->pluck(null, 'id_tabel_rpjmd')->toArray();

		$data_tabelrpjmd = $data_tabelrpjmd->map(function ($item) use ($data_tabelrpjmd_ids) {
			return [
				'id' => $item['id_tabel_rpjmd'],
				'skpd_id' => $item['id_skpd'],
				'parent_id' => isset($data_tabelrpjmd_ids[$item['id_parent']]) ? $item['id_parent'] : null,
				'nama_menu' => $item['nama_menu'],
				'created_at' => $item['created_at'],
				'updated_at' => $item['updated_at'],
			];
		});

		TabelRpjmd::insert($data_tabelrpjmd->toArray());


		// tabel bps
		$data_tabelbps = collect($data->where('name', 'tabel_bps')->first()['data']);
		$data_tabelbps_ids = $data_tabelbps->pluck(null, 'id_tabel_bps')->toArray();

		$data_tabelbps = $data_tabelbps->map(function ($item) use ($data_tabelbps_ids) {
			return [
				'id' => $item['id_tabel_bps'],
				'parent_id' => isset($data_tabelbps_ids[$item['id_parent']]) ? $item['id_parent'] : null,
				'nama_menu' => $item['nama_menu'],
				'created_at' => $item['created_at'],
				'updated_at' => $item['updated_at'],

			];
		});

		TabelBps::insert($data_tabelbps->toArray());

		// tabel indikator
		$data_tabelindikator = collect($data->where('name', 'tabel_indikator')->first()['data']);
		$data_tabelindikator_ids = $data_tabelindikator->pluck(null, 'id_tabel_indikator')->toArray();

		$data_tabelindikator = $data_tabelindikator->map(function ($item) use ($data_tabelindikator_ids) {
			return [
				'id' => $item['id_tabel_indikator'],
				'parent_id' => isset($data_tabelindikator_ids[$item['id_parent']]) ? $item['id_parent'] : null,
				'nama_menu' => $item['nama_menu'],
				'created_at' => $item['created_at'],
				'updated_at' => $item['updated_at'],
			];
		});

		TabelIndikator::insert($data_tabelindikator->toArray());

		// uraian 8 kel. data
		$data_uraian8keldata = collect($data->where('name', 'uraian_8keldata')->first()['data']);
		$data_uraian8keldata_ids = $data_uraian8keldata->pluck(null, 'id_uraian_8keldata')->toArray();

		$data_uraian8keldata = $data_uraian8keldata
			->filter(function ($item) use ($data_tabel8keldata_ids) {
				return isset($data_tabel8keldata_ids[$item['id_tabel_8keldata']]);
			})
			->map(function ($item) use ($data_uraian8keldata_ids) {
				return [
					'id' => $item['id_uraian_8keldata'] == 0 ? null : $item['id_uraian_8keldata'],
					'parent_id' => isset($data_uraian8keldata_ids[$item['id_parent']]) ? $item['id_parent'] : null,
					'skpd_id' => $item['id_skpd'],
					'tabel_8keldata_id' => $item['id_tabel_8keldata'],
					'uraian' => $item['uraian'],
					'satuan' => $item['satuan'],
					'ketersediaan_data' => $item['ketersediaan_data'],
					'created_at' => $item['created_at'],
					'updated_at' => $item['updated_at'],
				];
			});

		Uraian8KelData::insert($data_uraian8keldata->toArray());

		// uraian rpjmd
		$data_uraianrpjmd = collect($data->where('name', 'uraian_rpjmd')->first()['data']);
		$data_uraianrpjmd_ids = $data_uraianrpjmd->pluck(null, 'id_uraian_rpjmd')->toArray();

		$data_uraianrpjmd = $data_uraianrpjmd
			->filter(function ($item) use ($data_tabelrpjmd_ids) {
				return isset($data_tabelrpjmd_ids[$item['id_tabel_rpjmd']]);
			})
			->map(function ($item) use ($data_uraianrpjmd_ids) {
				return [
					'id' => $item['id_uraian_rpjmd'] == 0 ? null : $item['id_uraian_rpjmd'],
					'parent_id' => isset($data_uraianrpjmd_ids[$item['id_parent']]) ? $item['id_parent'] : null,
					'skpd_id' => $item['id_skpd'],
					'tabel_rpjmd_id' => $item['id_tabel_rpjmd'],
					'uraian' => $item['uraian'],
					'satuan' => $item['satuan'],
					'ketersediaan_data' => $item['ketersediaan_data'],
					'created_at' => $item['created_at'],
					'updated_at' => $item['updated_at'],
				];
			});

		UraianRpjmd::insert($data_uraianrpjmd->toArray());

		// uraian bps
		$data_uraianbps = collect($data->where('name', 'uraian_bps')->first()['data']);
		$data_uraianbps_ids = $data_uraianbps->pluck(null, 'id_uraian_bps')->toArray();

		$data_uraianbps = $data_uraianbps
			->filter(function ($item) use ($data_tabelbps_ids) {
				return isset($data_tabelbps_ids[$item['id_tabel_bps']]);
			})
			->map(function ($item) {
				return [
					'id' => $item['id_uraian_bps'],
					'parent_id' => $item['id_parent'] == 0 ? null : $item['id_parent'],
					'skpd_id' => $item['id_skpd'],
					'tabel_bps_id' => $item['id_tabel_bps'],
					'uraian' => $item['uraian'],
					'satuan' => $item['satuan'],
				];
			});

		UraianBps::insert($data_uraianbps->toArray());

		// uraian indikator
		$data_uraianindikator = collect($data->where('name', 'uraian_indikator')->first()['data']);
		$data_uraianindikator_ids = $data_uraianindikator->pluck(null, 'id_uraian_indikator')->toArray();

		$data_uraianindikator = $data_uraianindikator
			->filter(function ($item) use ($data_tabelindikator_ids) {
				return isset($data_tabelindikator_ids[$item['id_tabel_indikator']]);
			})
			->map(function ($item) use ($data_uraianindikator_ids, $data_tabelindikator_ids) {
				return [
					'id' => $item['id_uraian_indikator'],
					'parent_id' => $item['id_parent'] == 0 ? null : $item['id_parent'],
					'skpd_id' => $item['id_skpd'],
					'tabel_indikator_id' => $item['id_tabel_indikator'],
					'uraian' => $item['uraian'],
					'satuan' => $item['satuan'],
				];
			});

		UraianIndikator::insert($data_uraianindikator->toArray());

		// fitur 8 kel. data
		$data_fitur_8keldata = collect($data->where('name', 'fitur_8keldata')->first()['data'])
			->filter(function ($item) use ($data_tabel8keldata_ids) {
				return isset($data_tabel8keldata_ids[$item['id_tabel_8keldata']]);
			})
			->map(function ($item) {
				return [
					'id' => $item['id_fitur_8keldata'],
					'tabel_8keldata_id' => $item['id_tabel_8keldata'],
					'deskripsi' => $item['deskripsi'],
					'analisis' => $item['analisis'],
					'permasalahan' => $item['permasalahan'],
					'solusi' => $item['solusi'],
					'saran' => $item['saran'],
				];
			});

		Fitur8KelData::insert($data_fitur_8keldata->toArray());

		// fitur rpjmd
		$data_fitur_rpjmd = collect($data->where('name', 'fitur_rpjmd')->first()['data'])
			->filter(function ($item) use ($data_tabelrpjmd_ids) {
				return isset($data_tabelrpjmd_ids[$item['id_tabel_rpjmd']]);
			})
			->map(function ($fitur) {
				return [
					'id' => $fitur['id_fitur_rpjmd'],
					'tabel_rpjmd_id' => $fitur['id_tabel_rpjmd'],
					'deskripsi' => $fitur['deskripsi'],
					'analisis' => $fitur['analisis'],
					'permasalahan' => $fitur['permasalahan'],
					'saran' => $fitur['solusi'],
					'solusi' => $fitur['saran'],
				];
			});

		FiturRpjmd::insert($data_fitur_rpjmd->toArray());

		// fitur bps
		$data_fitur_bps = collect($data->where('name', 'fitur_bps')->first()['data'])
			->filter(function ($item) use ($data_tabelbps_ids) {
				return isset($data_tabelbps_ids[$item['id_tabel_bps']]);
			})
			->map(function ($fitur) {
				return [
					'id' => $fitur['id_fitur_bps'],
					'tabel_bps_id' => $fitur['id_tabel_bps'],
					'deskripsi' => $fitur['deskripsi'],
					'analisis' => $fitur['analisis'],
					'permasalahan' => $fitur['permasalahan'],
					'solusi' => $fitur['solusi'],
					'saran' => $fitur['saran'],
				];
			});

		FiturBps::insert($data_fitur_bps->toArray());

		// fitur indikator
		$data_fitur_indikator = collect($data->where('name', 'fitur_indikator')->first()['data'])
			->filter(function ($item) use ($data_tabelindikator_ids) {
				return isset($data_tabelindikator_ids[$item['id_tabel_indikator']]);
			})
			->map(function ($fitur) use ($data_tabelindikator_ids) {
				return [
					'id' => $fitur['id_fitur_indikator'],
					'tabel_indikator_id' => $fitur['id_tabel_indikator'],
					'deskripsi' => $fitur['deskripsi'],
					'analisis' => $fitur['analisis'],
					'permasalahan' => $fitur['permasalahan'],
					'solusi' => $fitur['solusi'],
					'saran' => $fitur['saran'],
				];
			});

		FiturIndikator::insert($data_fitur_indikator->toArray());

		// isi 8 kel. data
		$data_uraian8keldata_ids = $data_uraian8keldata->pluck(null, 'id');
		$data_isi_8keldata = collect($data->where('name', 'tabelisi_8keldata')->first()['data'])
			->filter(function ($item) use ($data_uraian8keldata_ids) {
				return isset($data_uraian8keldata_ids[$item['id_uraian_8keldata']]);
			})
			->map(function ($item) {
				return [
					'id' => $item['id_tabelisi_8keldata'],
					'uraian_8keldata_id' => $item['id_uraian_8keldata'],
					'tahun' => $item['tahun'],
					'isi' => str_replace([',', '.'], '', $item['isi']),
				];
			});

		foreach (array_chunk($data_isi_8keldata->toArray(), 10000) as $isi_8keldata) {
			Isi8KelData::insert($isi_8keldata);
		}

		// isi rpjmd
		$data_uraianrpjmd_ids = $data_uraianrpjmd->pluck(null, 'id');
		$data_isi_rpjmd = collect($data->where('name', 'tabelisi_rpjmd')->first()['data'])
			->filter(function ($item) use ($data_uraianrpjmd_ids) {
				return isset($data_uraianrpjmd_ids[$item['id_uraian_rpjmd']]);
			})
			->map(function ($item) {
				return [
					'id' => $item['id_tabelisi_rpjmd'],
					'uraian_rpjmd_id' => $item['id_uraian_rpjmd'],
					'tahun' => $item['tahun'],
					'isi' => str_replace([',', '.'], '', $item['isi']),
				];
			});

		foreach (array_chunk($data_isi_rpjmd->toArray(), 10000) as $isi_rpjmd) {
			IsiRpjmd::insert($isi_rpjmd);
		}

		// isi bps
		$data_uraianbps_ids = $data_uraianbps->pluck(null, 'id');
		$data_isi_bps = collect($data->where('name', 'tabelisi_bps')->first()['data'])
			->filter(function ($item) use ($data_uraianbps_ids) {
				return isset($data_uraianbps_ids[$item['id_uraian_bps']]);
			})
			->map(function ($item) {
				return [
					'id' => $item['id_tabelisi_bps'],
					'uraian_bps_id' => $item['id_uraian_bps'],
					'tahun' => $item['tahun'],
					'isi' => str_replace([',', '.'], '', $item['isi']),
				];
			});

		foreach (array_chunk($data_isi_bps->toArray(), 10000) as $isi_bps) {
			IsiBps::insert($isi_bps);
		}

		// isi indikator
		$data_uraianindikator_ids = $data_uraianindikator->pluck(null, 'id');
		$data_isi_indikator = collect($data->where('name', 'tabelisi_indikator')->first()['data'])
			->filter(function ($item) use ($data_uraianindikator_ids) {
				return isset($data_uraianindikator_ids[$item['id_uraian_indikator']]);
			})
			->map(function ($item) {
				return [
					'id' => $item['id_tabelisi_indikator'],
					'uraian_indikator_id' => $item['id_uraian_indikator'],
					'tahun' => $item['tahun'],
					'isi' => str_replace([',', '.'], '', $item['isi']),
				];
			});

		foreach (array_chunk($data_isi_indikator->toArray(), 10000) as $isi_indikator) {
			IsiIndikator::insert($isi_indikator);
		}
	}
}
