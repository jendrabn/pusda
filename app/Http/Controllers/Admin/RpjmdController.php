<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SumberDataRequest;
use App\Http\Requests\TahunRequest;
use App\Models\Skpd;
use App\Models\FileRpjmd;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Support\Str;
use App\Models\KategoriSkpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FiturRequest;
use App\Http\Controllers\Controller;
use App\Repositories\RpjmdRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FilePendukungRequest;
use App\Http\Requests\MassDestroyFileRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RpjmdController extends Controller
{
	public function __construct(private RpjmdRepository $repository)
	{
		\Illuminate\Support\Facades\View::share([
			'routePart' => 'rpjmd',
			'title' => 'RPJMD'
		]);
	}

	/**
	 * Displays the index page for RPJMD.
	 *
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$skpd = auth()->user()->role === User::ROLE_SKPD ? auth()->user()->skpd : Skpd::find($request->skpd);
		$kategoris = $this->repository->all_kategori();
		$tabel_ids = $skpd ? $this->repository->tabel_ids($skpd->id) : null;

		return view('admin.isiUraian.index', compact('kategoris', 'skpd', 'tabel_ids'));
	}

	/**
	 * Displays the category view for 8 Kelompok Data.
	 *
	 * @param KategoriSkpd $category
	 * @return View
	 */
	public function category(KategoriSkpd $kategoriSkpd): View
	{
		return view('admin.isiUraian.kategori', compact('kategoriSkpd'));
	}

	/**
	 * Handles the input request for RPJMD.
	 *
	 * @param Request $request
	 * @param TabelRpjmd $tabel
	 * @return View
	 */
	public function input(Request $request, TabelRpjmd $tabel): View
	{
		$tahuns = $this->repository->all_tahun($tabel->id);
		$uraians = $this->repository->all_uraian($tabel->id);
		$skpd = auth()->user()->role === User::ROLE_ADMIN ? auth()->user()->skpd : Skpd::find($request->skpd);
		$skpds = Skpd::pluck('singkatan', 'id');
		$kategoris = $this->repository->all_kategori();
		$tabel_ids = $skpd ? $this->repository->tabel_ids($skpd->id) : null;
		$fitur = $tabel->fiturRpjmd;
		$files = $tabel->fileRpjmd;

		return view('admin.isiUraian.index', compact(
			'kategoris',
			'skpd',
			'tabel',
			'uraians',
			'fitur',
			'files',
			'tahuns',
			'skpds',
			'tabel_ids'
		));
	}

	/**
	 * Retrieves the data needed to edit a UraianRpjmd and renders the edit view.
	 *
	 * @param Request $request
	 * @param UraianRpjmd $uraian
	 * @return View
	 */
	public function edit(Request $request, UraianRpjmd $uraian): View
	{
		$isi = $this->repository->all_isi_uraian($uraian->id);
		$tahuns = $isi->map(fn($item) => $item->tahun);
		$tabel_id = $uraian->tabel_rpjmd_id;

		return view('admin.isiUraian.edit', compact('uraian', 'isi', 'tahuns', 'tabel_id'));
	}

	/**
	 * Updates the UraianRpjmd instance and its associated IsiRpjmd instances.
	 *
	 * @param Request $request
	 * @param UraianRpjmd $uraian
	 * @throws \Exception
	 * @return RedirectResponse
	 */
	public function update(Request $request, UraianRpjmd $uraian): RedirectResponse
	{
		$isi = $this->repository->all_isi_uraian($uraian->id);
		$tahuns = $isi->map(fn($item) => $item->tahun);

		$rules = [
			'uraian' => ['required', 'string'],
			'satuan' => ['required', 'string'],
			'ketersediaan_data' => ['required', 'boolean'],
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
	 * Updates the fiturRpjmd instance associated with the given TabelRpjmd.
	 *
	 * @param FiturRequest $request
	 * @param TabelRpjmd $tabel
	 * @return RedirectResponse
	 */
	public function updateFitur(FiturRequest $request, TabelRpjmd $tabel): RedirectResponse
	{
		$tabel->fiturRpjmd()->updateOrCreate([], $request->validated());

		toastr('Fitur successfully updated', 'success');

		return back();
	}

	/**
	 * Stores the uploaded file for the given TabelRpjmd instance.
	 *
	 * @param FilePendukungRequest $request
	 * @param TabelRpjmd $tabel
	 * @return RedirectResponse
	 */
	public function storeFile(FilePendukungRequest $request, TabelRpjmd $tabel): RedirectResponse
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

				$tabel->fileRpjmd()->create([
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
	 * @param FileRpjmd $file
	 * @return RedirectResponse
	 */
	public function destroyFile(FileRpjmd $file): RedirectResponse
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
		$files = FileRpjmd::whereIn('id', $request->validated('ids'))->get();

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
	 * Downloads a file from the public disk.
	 *
	 * @param FileRpjmd $file
	 * @return StreamedResponse
	 */
	public function downloadFile(FileRpjmd $file): StreamedResponse
	{
		return Storage::disk('public')->download('file_pendukung/' . $file->nama, $file->nama);
	}

	/**
	 * Updates the UraianRpjmd instance with the provided SumberDataRequest.
	 *
	 * @param SumberDataRequest $request
	 * @param UraianRpjmd $uraian
	 * @return RedirectResponse
	 */
	public function updateSumberData(SumberDataRequest $request, UraianRpjmd $uraian)
	{
		$uraian->update($request->validated());

		toastr('Sumber data successfully updated', 'success');

		return back();
	}

	/**
	 * Returns a JSON response containing chart data for the given UraianRpjmd instance.
	 *
	 * @param UraianRpjmd $uraian
	 * @return JsonResponse
	 */
	public function chart(UraianRpjmd $uraian): JsonResponse
	{
		return response()->json($this->repository->grafik($uraian->id));
	}

	/**
	 * Stores the tahun data for the given TabelRpjmd instance.
	 *
	 * @param TahunRequest $request
	 * @param TabelRpjmd $tabel
	 * @return RedirectResponse
	 */
	public function storeTahun(TahunRequest $request, TabelRpjmd $tabel): RedirectResponse
	{
		DB::transaction(function () use ($request, $tabel) {
			$tabel->uraianRpjmd()->with('isiRpjmd')->get()
				->each(function ($uraian) use ($request) {
					if ($uraian->parent_id) {
						$uraian->isiRpjmd()->where('tahun', $request->tahun)->firstOrCreate([
							'tahun' => $request->tahun,
							'isi' => 0
						]);
					}
				});
		});

		toastr('Year successfully added', 'success');

		return back();
	}

	/**
	 * Deletes the tahun data for the given TabelRpjmd instance.
	 *
	 * @param TabelRpjmd $tabel
	 * @param int $tahun
	 * @throws \Exception
	 * @return RedirectResponse
	 */
	public function destroyTahun(TabelRpjmd $tabel, int $tahun)
	{
		DB::transaction(function () use ($tabel, $tahun) {
			$tabel->uraianRpjmd->each(fn($uraian) => $uraian->isiRpjmd()->where('tahun', $tahun)->delete());
		});

		toastr('Year successfully deleted', 'success');

		return back();
	}
}
