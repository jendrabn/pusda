<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skpd;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\File8KelData;
use App\Models\KategoriSkpd;
use Illuminate\Http\Request;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FiturRequest;
use App\Http\Requests\TahunRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SumberDataRequest;
use App\Http\Requests\FilePendukungRequest;
use App\Http\Requests\MassDestroyFileRequest;
use App\Repositories\DelapanKelDataRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DelapanKelDataController extends Controller
{
	public function __construct(private DelapanKelDataRepository $repository)
	{
		\Illuminate\Support\Facades\View::share([
			'routePart' => 'delapankeldata',
			'title' => '8 Kelompok Data'
		]);
	}

	/**
	 * Displays the index page for 8 Kelompok Data.
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
	 * @param KategoriSkpd $kategori
	 * @return View
	 */
	public function category(KategoriSkpd $kategoriSkpd): View
	{
		return view('admin.isiUraian.kategori', compact('kategoriSkpd'));
	}

	/**
	 * Handles the input for 8 Kelompok Data.
	 *
	 * @param Request $request
	 * @param Tabel8KelData $tabel
	 * @return View
	 */
	public function input(Request $request, Tabel8KelData $tabel): View
	{
		$tahuns = $this->repository->all_tahun($tabel->id);
		$uraians = $this->repository->all_uraian($tabel->id);
		$skpd = auth()->user()->role === User::ROLE_SKPD ? auth()->user()->skpd : Skpd::find($request->skpd);
		$skpds = Skpd::pluck('singkatan', 'id');
		$kategoris = $this->repository->all_kategori();
		$tabel_ids = $skpd ? $this->repository->tabel_ids($skpd->id) : null;
		$fitur = $tabel->fitur8KelData;
		$files = $tabel->file8KelData;

		return view('admin.isiUraian.index', compact(
			'kategoris',
			'skpd',
			'tabel',
			'uraians',
			'tahuns',
			'skpds',
			'tabel_ids',
			'fitur',
			'files'
		));
	}

	/**
	 * Handles the edit functionality for Uraian 8 Kelompok Data.
	 *
	 * @param Request $request
	 * @param Uraian8KelData $uraian
	 * @return View
	 */
	public function edit(Request $request, Uraian8KelData $uraian): View
	{
		$isi = $this->repository->all_isi_uraian($uraian->id);
		$tahuns = $isi->map(fn($item) => $item->tahun);
		$tabel_id = $uraian->tabel_8keldata_id;

		return view('admin.isiUraian.edit', compact('uraian', 'isi', 'tahuns', 'tabel_id'));
	}

	/**
	 * Handles the update functionality for Uraian 8 Kelompok Data.
	 *
	 * Updates the Uraian8KelData model instance and its associated isi uraian data.
	 *
	 * @param Request $request
	 * @param Uraian8KelData $uraian
	 * @return RedirectResponse
	 */
	public function update(Request $request, Uraian8KelData $uraian): RedirectResponse
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

		request()->validate($rules);

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
	 * Updates or creates a fitur 8 kelompok data for the given tabel.
	 *
	 * @param FiturRequest $request
	 * @param Tabel8KelData $tabel
	 * @return RedirectResponse
	 */
	public function updateFitur(FiturRequest $request, Tabel8KelData $tabel): RedirectResponse
	{
		$tabel->fitur8KelData()->updateOrCreate([], $request->validated());

		toastr('Fitur 8 kelompok data successfully updated', 'success');

		return back();
	}

	/**
	 * Stores the uploaded file for the given tabel.
	 *
	 * @param FilePendukungRequest $request
	 * @param Tabel8KelData $tabel
	 * @return RedirectResponse
	 */
	public function storeFile(FilePendukungRequest $request, Tabel8KelData $tabel): RedirectResponse
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

				$tabel->file8KelData()->create([
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
	 * @param File8KelData $file
	 * @return RedirectResponse
	 */
	public function destroyFile(File8KelData $file): RedirectResponse
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
		$files = File8KelData::whereIn('id', $request->validated('ids'))->get();

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
	 * @param File8KelData $file
	 * @return StreamedResponse
	 */
	public function downloadFile(File8KelData $file): StreamedResponse
	{
		return Storage::disk('public')->download('file_pendukung/' . $file->nama, $file->nama);
	}

	/**
	 * Updates the sumber data for the given uraian.
	 *
	 * @param SumberDataRequest $request
	 * @param Uraian8KelData $uraian
	 * @return RedirectResponse
	 */
	public function updateSumberData(SumberDataRequest $request, Uraian8KelData $uraian): RedirectResponse
	{
		$uraian->update($request->validated());

		toastr('Sumber data successfully updated', 'success');

		return back();
	}

	/**
	 * Retrieves the chart data for a given Uraian8KelData instance and returns it as a JSON response.
	 *
	 * @param Uraian8KelData $uraian
	 * @return JsonResponse
	 */
	public function chart(Uraian8KelData $uraian): JsonResponse
	{
		$uraian = $this->repository->grafik($uraian->id);

		return response()->json($uraian);
	}

	/**
	 * Stores a new year for the given table.
	 *
	 * @param TahunRequest $request
	 * @param Tabel8KelData $tabel
	 * @return RedirectResponse
	 */
	public function storeTahun(TahunRequest $request, Tabel8KelData $tabel): RedirectResponse
	{
		DB::transaction(function () use ($request, $tabel) {
			$tabel->uraian8KelData()->with('isi8KelData')->get()
				->each(function ($uraian) use ($request) {
					if ($uraian->parent_id) {
						$uraian->isi8KelData()->where('tahun', $request->tahun)->firstOrCreate([
							'tahun' => $request->tahun,
							'isi' => 0
						]);
					}
				});
		});

		toastr('Year successfully created', 'success');

		return back();
	}

	/**
	 * Deletes a year from the given table.
	 *
	 * @param Tabel8KelData $tabel
	 * @param int $tahun
	 * @return RedirectResponse
	 */
	public function destroyTahun(Tabel8KelData $tabel, int $tahun): RedirectResponse
	{
		DB::transaction(function () use ($tabel, $tahun) {
			$tabel->uraian8KelData->each(
				fn($uraian) => $uraian->isi8KelData()->where('tahun', $tahun)->delete()
			);
		});

		toastr('Year successfully deleted', 'success');

		return back();
	}
}
