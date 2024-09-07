<?php

namespace App\Repositories;

interface DataImpl
{
	public function grafik(int $uraian_8keldata_id);

	public function all_isi_uraian(int $uraian_8keldata_id);

	public function all_uraian(int $tabel_kel8data_id);

	public function all_tahun(int $tabel_kel8data_id);

	public function all_kategori();

	public function tabel_ids(int $skpd_id);
}
