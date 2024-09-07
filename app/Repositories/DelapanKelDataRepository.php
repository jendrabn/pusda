<?php

namespace App\Repositories;
use App\Models\Isi8KelData;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;

class DelapanKelDataRepository implements DataImpl
{

	public function grafik(int $uraian_8keldata_id)
	{
		$uraian = Uraian8KelData::where('id', $uraian_8keldata_id)->firstOrFail();
		$uraian->isi = $uraian->isi8KelData()
			->whereNotNull('tahun')
			->groupBy('tahun')
			->orderBy('tahun', 'asc')
			->get();

		return $uraian;
	}

	public function all_isi_uraian(int $uraian_8keldata_id)
	{
		return Isi8KelData::where('uraian_8keldata_id', $uraian_8keldata_id)
			->whereNotNull('tahun')
			->orderBy('tahun', 'asc')
			->get();
	}

	public function all_uraian(int $tabel_kel8data_id)
	{
		return Uraian8KelData::with(['childs', 'childs.isi8KelData'])
			->where('tabel_8keldata_id', $tabel_kel8data_id)
			->whereNull('parent_id')
			->get();
	}

	public function all_tahun(int $tabel_kel8data_id)
	{
		return Isi8KelData::select('tahun')
			->whereHas('uraian8KelData', fn($q) => $q->where('tabel_8keldata_id', $tabel_kel8data_id))
			->orderBy('tahun', 'asc')
			->distinct('tahun')
			->get()
			->map(fn($item) => $item->tahun);
	}

	public function all_kategori()
	{
		return Tabel8KelData::with(['childs', 'childs.childs', 'childs.childs.childs'])->get();
	}

	public function tabel_ids(int $skpd_id)
	{
		return Uraian8KelData::select('tabel_8keldata_id as tabel_id')
			->where('skpd_id', $skpd_id)
			->groupBy('tabel_id')
			->get();
	}

}
