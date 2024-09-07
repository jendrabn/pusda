<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TahunRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FileIndikator;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FiturRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Repositories\IndikatorRepository;
use App\Http\Requests\FilePendukungRequest;
use App\Http\Requests\MassDestroyFileRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndikatorController extends Controller
{

	public function __construct(private IndikatorRepository $repository)
	{
		\Illuminate\Support\Facades\View::share([
			'routePart' => 'indikator',
			'title' => 'Indikator'
		]);
	}

	/**
	 * Display a listing of the Indikator
	 *
	 * @param TabelIndikator|null $tabel
	 * @return View
	 */
	public function index(TabelIndikator $tabel = null): View
	{
		$kategoris = $this->repository->all_kategori();

		if (!$tabel) {
			return view('admin.isiUraian.index', compact('kategoris'));
		}

		$tahuns = $this->repository->all_tahun($tabel->id);
		$uraians = $this->repository->all_uraian($tabel->id);
		$fitur = $tabel->fiturIndikator;
		$files = $tabel->fileIndikator;

		return view('admin.isiUraian.index', compact(
			'kategoris',
			'tabel',
			'uraians',
			'fitur',
			'files',
			'tahuns'
		));
	}

	/**
	 * Displays the edit view for a given UraianIndikator instance.
	 *
	 * @param Request $request
	 * @param UraianIndikator $uraian
	 * @return View
	 */
	public function edit(Request $request, UraianIndikator $uraian): View
	{
		$isi = $this->repository->all_isi_uraian($uraian->id);
		$tahuns = $isi->map(fn($item) => $item->tahun);
		$tabel_id = $uraian->tabel_indikator_id;

		return view('admin.isiUraian.edit', compact('uraian', 'isi', 'tahuns', 'tabel_id'));
	}

	public function update(Request $request, UraianIndikator $uraian): RedirectResponse
	{
		$isi = $this->repository->all_isi_uraian($uraian->id);
		$tahuns = $isi->map(fn($item) => $item->tahun);

		$rules = [
			'uraian' => ['required', 'string'],
			'satuan' => ['required', 'string'],
		];

		foreach ($tahuns as $tahun) {
			$rules['tahun_' . $tahun] = ['required', 'integer'];
		}

		$request->validate($rules);

		DB::transaction(function () use ($request, $uraian, $isi) {
			$uraian->update($request->all());

			$isi->each(function ($item) use ($request) {
				$item->isi = $request->get('tahun_' . $item->tahun);
				$item->save();
			});
		});

		toastr('Isi uraian successfully updated', 'success');

		return back();
	}

	/**
	 * Updates the fitur of a TabelIndikator.
	 *
	 * @param FiturRequest $request
	 * @param TabelIndikator $tabel
	 * @return RedirectResponse
	 */
	public function updateFitur(FiturRequest $request, TabelIndikator $tabel): RedirectResponse
	{
		$tabel->fiturIndikator()->updateOrCreate([], $request->validated());

		toastr('Fitur successfully updated', 'success');

		return back();
	}

	/**
	 * Stores the uploaded file for the given tabel.
	 *
	 * @param FilePendukungRequest $request
	 * @param TabelIndikator $tabel
	 * @return RedirectResponse
	 */
	public function storeFile(FilePendukungRequest $request, TabelIndikator $tabel): RedirectResponse
	{
		$files = $request->file('file_pendukung');

		DB::transaction(function () use ($files, $tabel) {
			foreach ($files as $file) {
				$fileName = sprintf(
					'%s_%s.%s',
					Str::beforeLast($file->getClientOriginalName(), '.'),
					uniqid(),
					$file->getClientOriginalExtension()
				);

				$tabel->fileIndikator()->create([
					'nama' => str_replace('file_pendukung/', '', $file->storeAs('file_pendukung', $fileName, 'public')),
					'size' => $file->getSize(),
				]);
			}
		});

		toastr('File successfully uploaded', 'success');

		return back();
	}

	/**
	 * Deletes a file and its associated record from the database.
	 *
	 * @param FileIndikator $file
	 * @return RedirectResponse
	 */
	public function destroyFile(FileIndikator $file): RedirectResponse
	{
		$filename = 'file_pendukung/' . $file->nama;
		if (Storage::disk('public')->exists($filename)) {
			Storage::disk('public')->delete($filename);
		}

		$file->delete();

		toastr('File successfully deleted', 'success');

		return back();
	}

	/**
	 * Deletes multiple files and their associated records from the database.
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function massDestroyFile(MassDestroyFileRequest $request): RedirectResponse
	{
		$files = FileIndikator::whereIn('id', $request->validated('ids'))->get();

		$files->each(function ($file) {
			$path = 'file_pendukung/' . $file->nama;
			if (Storage::disk('public')->exists($path)) {
				Storage::disk('public')->delete($path);
			}

			$file->delete();
		});

		toastr('File successfully deleted', 'success');

		return back();
	}

	/**
	 * Downloads a file from the server.
	 *
	 * @param FileIndikator $file
	 * @return StreamedResponse
	 */
	public function downloadFile(FileIndikator $file): StreamedResponse
	{
		return Storage::disk('public')->download('file_pendukung/' . $file->nama, $file->nama);
	}


	/**
	 * Store a new record in the database for a specific year of a table indicator.
	 *
	 * @param TahunRequest $request
	 * @param TabelIndikator $tabel
	 * @throws \Exception
	 * @return RedirectResponse
	 */
	public function storeTahun(TahunRequest $request, TabelIndikator $tabel): RedirectResponse
	{
		DB::transaction(function () use ($request, $tabel) {
			$tabel->uraianIndikator()->with('isiIndikator')->get()
				->each(function ($uraian) use ($request) {
					if ($uraian->parent_id) {
						$uraian->isiIndikator()->where('tahun', $request->tahun)->firstOrCreate([
							'tahun' => $request->tahun,
							'isi' => 0
						]);
					}
				});
		});

		toastr('Tahun successfully updated', 'success');

		return back();
	}

	/**
	 * Deletes the records of a specific year for a table indicator.
	 *
	 * @param TabelIndikator $tabel
	 * @param int $tahun
	 * @return RedirectResponse
	 */
	public function destroyTahun(TabelIndikator $tabel, int $tahun): RedirectResponse
	{
		DB::transaction(function () use ($tabel, $tahun) {
			$tabel->uraianIndikator->each(fn($uraian) => $uraian->isiIndikator()->where('tahun', $tahun)->delete());

		});

		toastr('Tahun successfully deleted', 'success');

		return back();
	}

	/**
	 * Returns the chart data for a specific table indicator.
	 *
	 * @param UraianIndikator $uraian
	 * @return JsonResponse
	 */
	public function chart(UraianIndikator $uraian): JsonResponse
	{
		return response()->json($this->repository->grafik($uraian->id));
	}
}
