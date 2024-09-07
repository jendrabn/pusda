<?php

namespace App\Http\Controllers\Admin;

use App\Models\FileBps;
use App\Models\TabelBps;
use App\Models\UraianBps;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FiturRequest;
use App\Http\Requests\TahunRequest;
use App\Repositories\BpsRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FilePendukungRequest;
use App\Http\Requests\MassDestroyFileRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BpsController extends Controller
{

	public function __construct(private BpsRepository $repository)
	{
		\Illuminate\Support\Facades\View::share([
			'routePart' => 'bps',
			'title' => 'BPS'
		]);
	}

	/**
	 * Display a listing of the BPS
	 *
	 * @param TabelBps|null $tabel
	 * @return View
	 */
	public function index(TabelBps $tabel = null): View
	{
		$kategoris = $this->repository->all_kategori();

		if (!$tabel) {
			return view('admin.isiUraian.index', compact('kategoris'));
		}

		$tahuns = $this->repository->all_tahun($tabel->id);
		$uraians = $this->repository->all_uraian($tabel->id);
		$fitur = $tabel->fiturBps;
		$files = $tabel->fileBps;

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
	 * Displays the edit view for a given UraianBps instance.
	 *
	 * @param Request $request
	 * @param UraianBps $uraian
	 * @return View
	 */
	public function edit(Request $request, UraianBps $uraian): View
	{
		$isi = $this->repository->all_isi_uraian($uraian->id);
		$tahuns = $isi->map(fn($item) => $item->tahun);
		$tabel_id = $uraian->tabel_bps_id;

		return view('admin.isiUraian.edit', compact('uraian', 'isi', 'tahuns', 'tabel_id'));
	}

	/**
	 * Updates the UraianBps instance with the provided request data.
	 *
	 * @param Request $request
	 * @param UraianBps $uraian
	 * @return RedirectResponse
	 */
	public function update(Request $request, UraianBps $uraian): RedirectResponse
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
	 * Updates the fitur of a TabelBps instance.
	 *
	 * @param FiturRequest $request
	 * @param TabelBps $tabel
	 * @return RedirectResponse
	 */
	public function updateFitur(FiturRequest $request, TabelBps $tabel): RedirectResponse
	{
		$tabel->fiturBps()->updateOrCreate([], $request->validated());

		toastr('Fitur successfully updated', 'success');

		return back();
	}

	/**
	 * Stores the uploaded file for the given tabel.
	 *
	 * @param FilePendukungRequest $request
	 * @param TabelBps $tabel
	 * @return RedirectResponse
	 */
	public function storeFile(FilePendukungRequest $request, TabelBps $tabel): RedirectResponse
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

				$tabel->fileBps()->create([
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
	 * @param FileBps $file
	 * @return RedirectResponse
	 */
	public function destroyFile(FileBps $file): RedirectResponse
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
		$files = FileBps::whereIn('id', $request->validated('ids'))->get();

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
	 * @param FileBps $file
	 * @return StreamedResponse
	 */
	public function downloadFile(FileBps $file): StreamedResponse
	{
		return Storage::disk('public')->download('file_pendukung/' . $file->nama, $file->nama);
	}

	/**
	 * Stores a new record in the database for a specific year of a table BPS.
	 *
	 * @param TahunRequest $request
	 * @param TabelBps $tabel
	 * @return RedirectResponse
	 */
	public function storeTahun(TahunRequest $request, TabelBps $tabel): RedirectResponse
	{
		DB::transaction(function () use ($request, $tabel) {
			$tabel->uraianBps()->with('isiBps')->get()
				->each(function ($uraian) use ($request) {
					if ($uraian->parent_id) {
						$uraian->isiBps()->where('tahun', $request->tahun)->firstOrCreate([
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
	 * Deletes a specific year of a table BPS.
	 *
	 * @param TabelBps $tabel
	 * @param int $tahun
	 * @return RedirectResponse
	 */
	public function destroyTahun(TabelBps $tabel, int $tahun): RedirectResponse
	{
		DB::transaction(function () use ($tabel, $tahun) {
			$tabel->uraianBps->each(fn($uraian) => $uraian->isiBps()->where('tahun', $tahun)->delete());

		});

		toastr('Tahun successfully deleted', 'success');

		return back();
	}

	/**
	 * Retrieves chart data for a given UraianBps instance.
	 *
	 * @param UraianBps $uraian
	 * @return JsonResponse
	 */
	public function chart(UraianBps $uraian): JsonResponse
	{
		return response()->json($this->repository->grafik($uraian->id));
	}
}
