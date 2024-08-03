<?php

namespace Database\Seeders;

use App\Models\Uraian8KelData;
use App\Models\UraianBps;
use App\Models\UraianIndikator;
use App\Models\UraianRpjmd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UraianSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// $uraians = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
		// $uraians =  collect($uraians->where('type', 'table')->where('name', 'uraian_8keldata')->first()['data']);
		// $uraians = $uraians->map(function ($uraian) {
		//     return [
		//         'id' => $uraian['id_uraian_8keldata'],
		//         'parent_id' => $uraian['id_parent'] === '0' ? null : $uraian['id_parent'],
		//         'skpd_id' => $uraian['id_skpd'],
		//         'tabel_8keldata_id' => $uraian['id_tabel_8keldata'],
		//         'uraian' => $uraian['uraian'],
		//         'satuan' => $uraian['satuan'],
		//         'ketersediaan_data' => null,
		//     ];
		// });

		// $uraians->each(function ($uraian) {
		//     $parent = Uraian8KelData::where('id', $uraian['parent_id'])->first();
		//     $tabel = Tabel8KelData::where('id', $uraian['tabel_8keldata_id'])->first();
		//     if (!is_null($parent) && !is_null($tabel) || is_null($uraian['parent_id']) && !is_null($tabel)) {
		//         Uraian8KelData::create($uraian);
		//     }
		// });

		// $uraians = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
		// $uraians = collect($uraians->where('type', 'table')->where('name', 'uraian_rpjmd')->first()['data']);
		// $uraians = $uraians->map(function ($uraian) {
		//     return [
		//         'id' => $uraian['id_uraian_rpjmd'],
		//         'parent_id'  => $uraian['id_parent'] === '0' ? null : $uraian['id_parent'],
		//         'skpd_id' => $uraian['id_skpd'],
		//         'tabel_rpjmd_id' => $uraian['id_tabel_rpjmd'],
		//         'uraian' => $uraian['uraian'],
		//         'satuan' => $uraian['satuan'],
		//         'ketersediaan_data' => null,
		//     ];
		// });

		// $uraians->each(function ($uraian) {
		//     $parent = UraianRpjmd::where('id', $uraian['parent_id'])->first();
		//     $tabel = TabelRpjmd::where('id', $uraian['tabel_rpjmd_id'])->first();
		//     if (!is_null($parent) && !is_null($tabel) || is_null($uraian['parent_id']) && !is_null($tabel)) {
		//         UraianRpjmd::create($uraian);
		//     }
		// });

		// $uraians = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
		// $uraians = collect($uraians->where('type', 'table')->where('name', 'uraian_bps')->first()['data']);
		// $uraians = $uraians->map(function ($uraian) {
		//     return [
		//         'id' => $uraian['id_uraian_bps'],
		//         'parent_id' => $uraian['id_parent'] === '0' ? null : $uraian['id_parent'],
		//         'skpd_id' => $uraian['id_skpd'],
		//         'tabel_bps_id' => $uraian['id_tabel_bps'],
		//         'uraian' => $uraian['uraian'],
		//         'satuan' => $uraian['satuan'],
		//     ];
		// });

		// $uraians->each(function ($uraian) {
		//     $parent = UraianBps::where('id', $uraian['parent_id'])->first();
		//     $tabel = TabelBps::where('id', $uraian['tabel_bps_id'])->first();
		//     if (!is_null($parent) && !is_null($tabel) || is_null($uraian['parent_id']) && !is_null($tabel)) {
		//         UraianBps::create($uraian);
		//     }
		// });

		// $uraians = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
		// $uraians = collect($uraians->where('type', 'table')->where('name', 'uraian_indikator')->first()['data']);
		// $uraians = $uraians->map(function ($uraian) {
		//     return [
		//         'id' => $uraian['id_uraian_indikator'],
		//         'parent_id'  => $uraian['id_parent'] === '0' ? null : $uraian['id_parent'],
		//         'skpd_id'  => $uraian['id_skpd'],
		//         'tabel_indikator_id'  => $uraian['id_tabel_indikator'],
		//         'uraian'  => $uraian['uraian'],
		//         'satuan'  => $uraian['satuan'],
		//     ];
		// });

		// $uraians->each(function ($uraian) {
		//     $parent = UraianIndikator::where('id', $uraian['parent_id'])->first();
		//     $tabel = TabelIndikator::where('id', $uraian['tabel_indikator_id'])->first();
		//     if (!is_null($parent) && !is_null($tabel) || is_null($uraian['parent_id']) && !is_null($tabel)) {
		//         UraianIndikator::create($uraian);
		//     }
		// });

		$pusdaBaru = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));

		$uraian8KelData = $pusdaBaru->where('type', 'table')->where('name', 'uraian_8keldata')->first()['data'];
		$uraianRpjmd = $pusdaBaru->where('type', 'table')->where('name', 'uraian_rpjmd')->first()['data'];
		$uraianIndikator = $pusdaBaru->where('type', 'table')->where('name', 'uraian_indikator')->first()['data'];
		$uraianBps = $pusdaBaru->where('type', 'table')->where('name', 'uraian_bps')->first()['data'];

		foreach (array_chunk($uraian8KelData, 1000) as $uraian) {
			Uraian8KelData::insert($uraian);
		}

		foreach (array_chunk($uraianRpjmd, 1000) as $uraian) {
			UraianRpjmd::insert($uraian);
		}

		foreach (array_chunk($uraianIndikator, 1000) as $uraian) {
			UraianIndikator::insert($uraian);
		}

		foreach (array_chunk($uraianBps, 1000) as $uraian) {
			UraianBps::insert($uraian);
		}
	}
}
