<?php

namespace App\Http\Traits;

use App\Models\User;
use App\Models\File8KelData;
use App\Repositories\DelapanKelDataRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait DelapanKelDataTrait
{
	public function __construct(private DelapanKelDataRepository $repository)
	{
	}

	public function edit(Request $request, Uraian8KelData $uraian)
	{
		$isi = $this->repository->all_isi_uraian($uraian->id);
		$tahuns = $isi->map(fn($item) => $item->tahun);
		$tabelId = $uraian->tabel_8keldata_id;

		$viewPath = match (request()->user()->role) {
			User::ROLE_ADMIN => 'admin.isiUraian.edit',
			User::ROLE_SKPD => 'skpd.isiUraian.edit',
			default => null
		};

		abort_if(!$viewPath, Response::HTTP_NOT_FOUND);

		return view($viewPath, compact('uraian', 'isi', 'tahuns', 'tabelId'));
	}

	public function update(Request $request, Uraian8KelData $uraian)
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

		DB::beginTransaction();
		try {
			$uraian->update($request->all());

			$isi->each(function ($item) use ($request) {
				$item->isi = $request->get('tahun_' . $item->tahun);
				$item->save();
			});

			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();

			throw new \Exception($e->getMessage());
		}

		toastr('Isi uraian successfully updated', 'success');

		return back();
	}

	public function destroy(Request $request, Uraian8KelData $uraian)
	{
		$uraian->delete();

		toastr('Isi uraian successfully deleted', 'success');

		return to_route('admin.delapankeldata.input', [$uraian->tabel_8keldata_id, 'tab' => $request->input('tab')]);
	}

	/**
	 * Updates the fitur of a Tabel8KelData instance.
	 *
	 * @param Request $request
	 * @param Tabel8KelData $tabel
	 * @throws ValidationException
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateFitur(Request $request, Tabel8KelData $tabel)
	{
		$request->validate([
			'deskripsi' => ['nullable', 'string', 'max:255'],
			'analisis' => ['nullable', 'string', 'max:255'],
			'permasalahan' => ['nullable', 'string', 'max:255'],
			'solusi' => ['nullable', 'string', 'max:255'],
			'saran' => ['nullable', 'string', 'max:255']
		]);

		$tabel->fitur8KelData()->updateOrCreate([], $request->all());

		toastr('Fitur 8 kelompok data successfully updated', 'success');

		return to_route('admin.delapankeldata.input', [$tabel->id, 'tab' => $request->input('tab')]);
	}

	/**
	 * Stores a file associated with a Tabel8KelData instance.
	 *
	 * @param Request $request
	 * @param Tabel8KelData $tabel
	 * @throws ValidationException
	 * @return RedirectResponse
	 */
	public function storeFile(Request $request, Tabel8KelData $tabel): RedirectResponse
	{
		$request->validate([
			'file_pendukung' => [
				'required',
				'max:25600',
				'mimes:jpeg,png,gif,bmp,svg,webp,mp4,avi,mov,wmv,flv,mkv,webm,3gp,pdf,doc,docx,xls,xlsx,txt,rtf,csv,ppt,pptx,odp'
			],
		]);

		$file = $request->file('file_pendukung');

		$fileName = sprintf('%s_%s.%s', $file->getClientOriginalName(), time(), $file->getClientOriginalExtension());

		$tabel->file8KelData()->create([
			'nama' => str_replace('file_pendukung/', '', $file->storeAs('file_pendukung', $fileName, 'public')),
		]);

		toastr('File successfully uploaded', 'success');

		return to_route('admin.delapankeldata.input', [$tabel->id, 'tab' => $request->input('tab')]);
	}

	/**
	 * Deletes a file from the public disk and removes the corresponding File8KelData record.
	 *
	 * @param File8KelData $file The file to be deleted.
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroyFile(Request $request, File8KelData $file)
	{
		Storage::disk('public')->delete('file_pendukung/' . $file->nama);

		$file->delete();

		toastr('File successfully deleted', 'success');

		return to_route('admin.delapankeldata.input', [$file->tabel_8keldata_id, 'tab' => $request->input('tab')]);
	}

	/**
	 * Downloads a file from the public disk.
	 *
	 * @param File8KelData $file
	 * @return StreamedResponse
	 */
	public function downloadFile(File8KelData $file): StreamedResponse
	{
		return Storage::disk('public')->download('file_pendukung/' . $file->nama, $file->nama);
	}

	/**
	 * Updates the sumber data of a Uraian8KelData instance.
	 *
	 * @param Request $request The incoming HTTP request.
	 * @param Uraian8KelData $uraian The Uraian8KelData instance to be updated.
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateSumberData(Request $request, Uraian8KelData $uraian)
	{
		$request->validate(['skpd_id' => ['required', 'integer', 'exists:skpd,id']]);

		$uraian->skpd_id = $request->skpd_id;
		$uraian->save();

		toastr('Sumber data successfully updated', 'success');

		return to_route('admin.delapankeldata.input', [$uraian->tabel_8keldata_id, 'tab' => $request->input('tab')]);
	}

	public function chart(Uraian8KelData $uraian)
	{
		$uraian = $this->repository->grafik($uraian->id);

		return response()->json($uraian, 200);
	}

}
