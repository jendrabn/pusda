<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\DataTables\Uraian\UraianRpjmdDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Uraian\UraianRpjmdRequest;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Http\JsonResponse;

class RpjmdController extends Controller
{
	/**
	 * Handles the index request for the RPJMD controller.
	 *
	 * @param TabelRpjmd|null $tabel
	 * @return mixed
	 */
	public function index(UraianRpjmdDataTable $dataTable, TabelRpjmd $tabel = null): mixed
	{
		$categories = TabelRpjmd::with('childs.childs.childs')->get();
		$title = 'Uraian Form Menu RPJMD';
		$routePart = 'rpjmd';

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
	 * @param TabelRpjmd $tabel
	 * @return JsonResponse
	 */
	public function uraians(TabelRpjmd $tabel): JsonResponse
	{
		$uraian = UraianRpjmd::where('tabel_rpjmd_id', $tabel->id)
			->whereNull('parent_id')
			->orderBy('id')
			->get();

		return response()->json($uraian);
	}

	/**
	 * Store a new UraianRpjmd resource.
	 *
	 * @param UraianRpjmdRequest $request
	 * @param TabelRpjmd $tabel
	 * @return JsonResponse
	 */
	public function store(UraianRpjmdRequest $request, TabelRpjmd $tabel): JsonResponse
	{
		$tabel->uraianRpjmd()->create($request->validated());

		return response()->json(['message' => 'Uraian RPJMD successfully created.']);
	}

	/**
	 * Updates an existing UraianRpjmd resource.
	 *
	 * @param UraianRpjmdRequest $request -
	 * @param UraianRpjmd $uraian
	 * @return JsonResponse
	 */
	public function update(UraianRpjmdRequest $request, UraianRpjmd $uraian): JsonResponse
	{
		$uraian->update($request->validated());

		return response()->json(['message' => 'Uraian RPJMD successfully updated.']);
	}

	/**
	 * Deletes an existing UraianRpjmd resource.
	 *
	 * @param UraianRpjmd $uraian
	 * @return JsonResponse
	 */
	public function destroy(UraianRpjmd $uraian): JsonResponse
	{
		$uraian->delete();

		return response()->json(['message' => 'Uraian RPJMD successfully deleted.']);
	}

	/**
	 * Deletes multiple UraianRpjmd resources.
	 *
	 * @param UraianRpjmdRequest $request
	 * @return JsonResponse
	 */
	public function massDestroy(UraianRpjmdRequest $request): JsonResponse
	{
		UraianRpjmd::whereIn('id', $request->validated('ids'))->delete();

		return response()->json(['message' => 'Uraian RPJMD successfully deleted.']);
	}
}
