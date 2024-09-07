<?php

namespace App\Repositories;
use App\Models\IsiBps;
use App\Models\TabelBps;
use App\Models\UraianBps;

class BpsRepository implements DataImpl
{

	public function grafik(int $uraian_bps_id)
	{
		$uraian = UraianBps::where('id', $uraian_bps_id)->firstOrFail();
		$uraian->isi = $uraian->isibps()
			->whereNotNull('tahun')
			->groupBy('tahun')
			->orderBy('tahun', 'asc')
			->get();

		return $uraian;
	}

	public function all_isi_uraian(int $uraian_bps_id)
	{
		return IsiBps::where('uraian_bps_id', $uraian_bps_id)
			->whereNotNull('tahun')
			->orderBy('tahun', 'asc')
			->get();
	}

	public function all_uraian(int $tabel_bps_id)
	{
		return UraianBps::with(['childs', 'childs.isiBps'])
			->where('tabel_bps_id', $tabel_bps_id)
			->whereNull('parent_id')
			->get();
	}

	public function all_tahun(int $tabel_bps_id)
	{
		return IsiBps::select('tahun')
			->whereHas('uraianBps', fn($q) => $q->where('tabel_bps_id', $tabel_bps_id))
			->orderBy('tahun', 'asc')
			->distinct('tahun')
			->get()
			->map(fn($item) => $item->tahun);
	}

	public function all_kategori()
	{
		return TabelBps::with(['childs', 'childs.childs', 'childs.childs.childs'])->get();
	}

	public function tabel_ids(int $skpd_id)
	{
		return UraianBps::select('tabel_bps_id as tabel_id')
			->where('skpd_id', $skpd_id)
			->groupBy('tabel_id')
			->get();
	}
}
