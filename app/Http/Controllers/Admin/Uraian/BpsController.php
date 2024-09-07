<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\DataTables\Uraian\UraianBpsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Uraian\UraianBpsRequest;
use App\Models\TabelBps;
use App\Models\UraianBps;
use Illuminate\Http\JsonResponse;

class BpsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @param TabelBps|null $tabel
	 * @return mixed
	 */
	public function index(UraianBpsDataTable $dataTable, TabelBps $tabel = null): mixed
	{
		$categories = TabelBps::with('childs.childs.childs')->get();
		$title = 'Uraian Form Menu BPS';
		$routePart = 'bps';

		return $dataTable->render('admin.uraian.index', compact(
			'tabel',
			'categories',
			'title',
			'routePart'
		));
	}

	/**
	 * Retrieves a collection of uraians for the given tabel.
	 *
	 * @param TabelBps $tabel
	 * @return JsonResponse
	 */
	public function uraians(TabelBps $tabel): JsonResponse
	{
		$uraian = UraianBps::where('tabel_bps_id', $tabel->id)
			->whereNull('parent_id')
			->orderBy('id')
			->get();

		return response()->json($uraian);
	}

	/**
	 * Store a new uraian BPS in the database.
	 *
	 * @param UraianBpsRequest $request
	 * @param TabelBps $tabel
	 * @return JsonResponse
	 */
	public function store(UraianBpsRequest $request, TabelBps $tabel): JsonResponse
	{
		$tabel->uraianBps()->create($request->validated());

		return response()->json(['message' => 'Uraian BPS successfully created.']);
	}

	/**
	 * Updates an existing uraian BPS in the database.
	 *
	 * @param UraianBpsRequest $request
	 * @param UraianBps $uraian
	 * @return JsonResponse
	 */
	public function update(UraianBpsRequest $request, UraianBps $uraian): JsonResponse
	{
		$uraian->update($request->validated());

		return response()->json(['message' => 'Uraian BPS successfully updated.']);
	}

	/**
	 * Deletes an existing uraian BPS from the database.
	 *
	 * @param UraianBps $uraian
	 * @return JsonResponse
	 */
	public function destroy(UraianBps $uraian): JsonResponse
	{
		$uraian->delete();

		return response()->json(['message' => 'Uraian BPS successfully deleted.']);
	}

	/**
	 * Deletes multiple uraian BPS from the database.
	 *
	 * @param UraianBpsRequest $request
	 * @return JsonResponse
	 */
	public function massDestroy(UraianBpsRequest $request): JsonResponse
	{
		UraianBps::whereIn('id', $request->validated('ids'))->delete();

		return response()->json(['message' => 'Uraian BPS successfully deleted.']);
	}
}
