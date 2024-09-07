<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\DataTables\Uraian\UraianIndikatorDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Uraian\UraianIndikatorRequest;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class IndikatorController extends Controller
{

	/**
	 * Handles the index action for the IndikatorController.
	 *
	 * @param TabelIndikator|null $tabel
	 * @return mixed
	 */
	public function index(UraianIndikatorDataTable $dataTable, TabelIndikator $tabel = null): mixed
	{
		$categories = TabelIndikator::with('childs.childs.childs')->get();
		$title = 'Uraian Form Menu Indikator';
		$routePart = 'indikator';

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
	 * @param TabelIndikator $tabel
	 * @return JsonResponse
	 */
	public function uraians(TabelIndikator $tabel): JsonResponse
	{
		$uraian = UraianIndikator::where('tabel_indikator_id', $tabel->id)
			->whereNull('parent_id')
			->orderBy('id')
			->get();

		return response()->json($uraian);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param UraianIndikatorRequest $request
	 * @param TabelIndikator $tabel
	 * @return JsonResponse
	 */
	public function store(UraianIndikatorRequest $request, TabelIndikator $tabel): JsonResponse
	{
		$tabel->uraianIndikator()->create($request->validated());

		return response()->json(['message' => 'Uraian Indikator successfully created.']);
	}

	/**
	 * Updates an existing Uraian Indikator resource in storage.
	 *
	 * @param UraianIndikatorRequest $request
	 * @param UraianIndikator $uraian
	 * @return JsonResponse
	 */
	public function update(UraianIndikatorRequest $request, UraianIndikator $uraian): JsonResponse
	{
		$uraian->update($request->validated());

		return response()->json(['message' => 'Uraian Indikator successfully updated.']);
	}

	/**
	 * Deletes an UraianIndikator resource and redirects back.
	 *
	 * @param UraianIndikator $uraian
	 * @return JsonResponse
	 */
	public function destroy(UraianIndikator $uraian): JsonResponse
	{
		$uraian->delete();

		return response()->json(['message' => 'Uraian Indikator successfully deleted.']);
	}

	/**
	 * Deletes multiple UraianIndikator resources and redirects back.
	 *
	 * @param UraianIndikatorRequest $request
	 * @return JsonResponse
	 */
	public function massDestroy(UraianIndikatorRequest $request): JsonResponse
	{
		UraianIndikator::whereIn('id', $request->validated('ids'))->delete();

		return response()->json(['message' => 'Uraian Indikator successfully deleted.']);
	}
}
