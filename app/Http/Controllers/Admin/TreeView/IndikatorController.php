<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\DataTables\TreeView\TabelIndikatorDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TreeView\TabelIndikatorRequest;
use App\Models\TabelIndikator;
use Illuminate\Http\JsonResponse;

class IndikatorController extends Controller
{
	/**
	 * Display a listing of the Tabel Indikator.
	 *
	 * @param TabelIndikatorDataTable $dataTable
	 * @return mixed
	 */
	public function index(TabelIndikatorDataTable $dataTable): mixed
	{
		$categories = TabelIndikator::with(['parent', 'childs.childs.childs'])->get();
		$title = 'Menu Treeview Indikator';
		$routePart = 'indikator';

		return $dataTable->render('admin.treeview.index', compact(
			'categories',
			'title',
			'routePart'
		));
	}

	/**
	 * Handles the creation of a new Tabel Indikator record.
	 *
	 * @param TabelIndikatorRequest $request
	 * @return JsonResponse
	 */
	public function store(TabelIndikatorRequest $request): JsonResponse
	{
		TabelIndikator::create($request->validated());

		return response()->json(['message' => 'Tabel Indikator successfully created.']);
	}

	/**
	 * Updates an existing Tabel Indikator record.
	 *
	 * @param TabelIndikatorRequest $request
	 * @param TabelIndikator $tabel
	 * @return JsonResponse
	 */
	public function update(TabelIndikatorRequest $request, TabelIndikator $tabel): JsonResponse
	{
		$tabel->update($request->validated());

		return response()->json(['message' => 'Tabel Indikator successfully updated.']);
	}

	/**
	 * Deletes a Tabel Indikator record.
	 *
	 * @param TabelIndikator $tabel
	 * @return JsonResponse
	 */
	public function destroy(TabelIndikator $tabel): JsonResponse
	{
		$tabel->delete();

		return response()->json(['message' => 'Tabel Indikator successfully deleted.']);
	}

	/**
	 * Handles the mass deletion of Tabel Indikator records.
	 *
	 * @param TabelIndikatorRequest $request
	 * @return JsonResponse
	 */
	public function massDestroy(TabelIndikatorRequest $request): JsonResponse
	{
		$tabel = TabelIndikator::whereIn('id', $request->validated('ids'))->get();

		$tabel->each(function ($tabel) {
			$tabel->delete();
		});

		return response()->json(['message' => 'Tabel Indikator successfully deleted.']);
	}
}
