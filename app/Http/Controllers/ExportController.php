<?php

namespace App\Http\Controllers;

use App\Exports\IsiUraianExport;
use App\Models\Tabel8KelData;
use App\Models\TabelBps;
use App\Models\TabelIndikator;
use App\Models\TabelRpjmd;
use App\Repositories\BpsRepository;
use App\Repositories\DelapanKelDataRepository;
use App\Repositories\IndikatorRepository;
use App\Repositories\RpjmdRepository;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
	/**
	 * Exports 8 Kel Data to an Excel file.
	 *
	 * @param Tabel8KelData $tabel
	 * @param DelapanKelDataRepository $repository
	 * @return BinaryFileResponse
	 */
	public function export8KelData(Tabel8KelData $tabel, DelapanKelDataRepository $repository): BinaryFileResponse
	{
		$uraians = $repository->all_uraian($tabel->id);
		$tahuns = $repository->all_tahun($tabel->id);
		$fitur = $tabel->fitur8KelData->first();
		$routePart = 'delapankeldata';
		$fileName = sprintf('%s_%s.xlsx', $tabel->nama_menu, date('dmy'));

		return Excel::download(new IsiUraianExport($routePart, $fitur, $uraians, $tahuns), $fileName);
	}


	/**
	 * Exports Rpjmd data to an Excel file.
	 *
	 * @param TabelRpjmd $tabel
	 * @param RpjmdRepository $repository
	 * @return BinaryFileResponse
	 */
	public function exportRpjmd(TabelRpjmd $tabel, RpjmdRepository $repository): BinaryFileResponse
	{
		$uraians = $repository->all_uraian($tabel->id);
		$tahuns = $repository->all_tahun($tabel->id);
		$fitur = $tabel->fiturRpjmd->first();
		$routePart = 'rpjmd';
		$fileName = sprintf('%s_%s.xlsx', $tabel->nama_menu, date('dmy'));

		return Excel::download(new IsiUraianExport($routePart, $fitur, $uraians, $tahuns), $fileName);
	}

	/**
	 * Exports BPS data to an Excel file.
	 *
	 * @param TabelBps $tabel
	 * @param BpsRepository $repository
	 * @return BinaryFileResponse
	 */
	public function exportBps(TabelBps $tabel, BpsRepository $repository): BinaryFileResponse
	{
		$uraians = $repository->all_uraian($tabel->id);
		$tahuns = $repository->all_tahun($tabel->id);
		$fitur = $tabel->fiturBps->first();
		$routePart = 'bps';
		$fileName = sprintf('%s_%s.xlsx', $tabel->nama_menu, date('dmy'));

		return Excel::download(new IsiUraianExport($routePart, $fitur, $uraians, $tahuns), $fileName);
	}

	/**
	 * Exports Indikator data to an Excel file.
	 *
	 * @param TabelIndikator $tabel
	 * @param IndikatorRepository $repository
	 * @return BinaryFileResponse
	 */
	public function exportIndikator(TabelIndikator $tabel, IndikatorRepository $repository): BinaryFileResponse
	{
		$uraians = $repository->all_uraian($tabel->id);
		$tahuns = $repository->all_tahun($tabel->id);
		$fitur = $tabel->fiturIndikator->first();
		$routePart = 'indikator';
		$fileName = sprintf('%s_%s.xlsx', $tabel->nama_menu, date('dmy'));

		return Excel::download(new IsiUraianExport($routePart, $fitur, $uraians, $tahuns), $fileName);
	}
}
