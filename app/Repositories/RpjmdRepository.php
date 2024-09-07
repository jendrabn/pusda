<?php

namespace App\Repositories;
use App\Models\IsiRpjmd;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;

class RpjmdRepository implements DataImpl
{

	public function grafik(int $uraian_rpjmd_id)
	{
		$uraian = UraianRpjmd::where('id', $uraian_rpjmd_id)->firstOrFail();

		$uraian->isi = IsiRpjmd::where('uraian_rpjmd_id', $uraian_rpjmd_id)
			->whereNotNull('tahun')
			->groupBy('tahun')
			->orderBy('tahun', 'asc')
			->get();

		return $uraian;
	}

	public function all_isi_uraian(int $uraian_rpjmd_id)
	{
		return IsiRpjmd::where('uraian_rpjmd_id', $uraian_rpjmd_id)
			->whereNotNull('tahun')
			->orderBy('tahun', 'asc')
			->get();
	}

	public function all_uraian(int $tabel_kel8data_id)
	{
		return UraianRpjmd::with(['childs', 'childs.isirpjmd'])
			->where('tabel_rpjmd_id', $tabel_kel8data_id)
			->whereNull('parent_id')
			->get();
	}

	public function all_tahun(int $tabel_kel8data_id)
	{
		return IsiRpjmd::select('tahun')
			->whereHas('uraianrpjmd', fn($q) => $q->where('tabel_rpjmd_id', $tabel_kel8data_id))
			->orderBy('tahun', 'asc')
			->distinct('tahun')
			->get()
			->map(fn($item) => $item->tahun);
	}

	public function all_kategori()
	{
		return TabelRpjmd::with(['childs', 'childs.childs', 'childs.childs.childs'])->get();
	}

	public function tabel_ids(int $skpd_id)
	{
		return UraianRpjmd::select('tabel_rpjmd_id as tabel_id')
			->where('skpd_id', $skpd_id)
			->groupBy('tabel_id')
			->get();
	}

}
