<?php

namespace App\Repositories;
use App\Models\IsiIndikator;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;

class IndikatorRepository implements DataImpl
{

	public function grafik(int $uraian_indikator_id)
	{
		$uraian = UraianIndikator::where('id', $uraian_indikator_id)->firstOrFail();
		$uraian->isi = $uraian->isiindikator()
			->whereNotNull('tahun')
			->groupBy('tahun')
			->orderBy('tahun', 'asc')
			->get();

		return $uraian;
	}

	public function all_isi_uraian(int $uraian_indikator_id)
	{
		return IsiIndikator::where('uraian_indikator_id', $uraian_indikator_id)
			->whereNotNull('tahun')
			->orderBy('tahun', 'asc')
			->get();
	}

	public function all_uraian(int $tabel_indikator_id)
	{
		return UraianIndikator::with(['childs', 'childs.isiIndikator'])
			->where('tabel_indikator_id', $tabel_indikator_id)
			->whereNull('parent_id')
			->get();
	}

	public function all_tahun(int $tabel_indikator_id)
	{
		return IsiIndikator::select('tahun')
			->whereHas('uraianIndikator', fn($q) => $q->where('tabel_indikator_id', $tabel_indikator_id))
			->orderBy('tahun', 'asc')
			->distinct('tahun')
			->get()
			->map(fn($item) => $item->tahun);
	}

	public function all_kategori()
	{
		return TabelIndikator::with(['childs', 'childs.childs', 'childs.childs.childs'])->get();
	}

	public function tabel_ids(int $skpd_id)
	{
		return UraianIndikator::select('tabel_indikator_id as tabel_id')
			->where('skpd_id', $skpd_id)
			->groupBy('tabel_id')
			->get();
	}
}
