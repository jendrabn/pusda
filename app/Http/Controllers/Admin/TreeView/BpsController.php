<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\DataTables\TreeView\TabelBpsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TreeView\TabelBpsRequest;
use App\Models\TabelBps;
use Illuminate\Http\JsonResponse;

class BpsController extends Controller
{
	/**
	 * Handles the index action for the BPS treeview.
	 *
	 * @param TabelBpsDataTable $dataTable
	 * @return mixed
	 */
	public function index(TabelBpsDataTable $dataTable): mixed
	{
		$categories = TabelBps::with(['parent', 'childs.childs.childs'])->get();
		$title = 'Menu Treeview BPS';
		$routePart = 'bps';

		return $dataTable->render('admin.treeview.index', compact(
			'categories',
			'routePart',
			'title'
		));
	}

	/**
	 * Creates a new TabelBps record.
	 *
	 * @param TabelBpsRequest $request
	 * @return JsonResponse
	 */
	public function store(TabelBpsRequest $request): JsonResponse
	{
		TabelBps::create($request->validated());

		return response()->json(['message' => 'Tabel BPS successfully created.']);
	}

	/**
	 * Updates an existing TabelBps record.
	 *
	 * @param TabelBpsRequest $request
	 * @param TabelBps $tabel
	 * @return JsonResponse
	 */
	public function update(TabelBpsRequest $request, TabelBps $tabel): JsonResponse
	{
		$tabel->update($request->validated());

		return response()->json(['message' => 'Tabel BPS successfully updated.']);
	}

	/**
	 * Deletes a single TabelBps record based on the provided TabelBps instance.
	 *
	 * @param TabelBps $tabel
	 * @return JsonResponse
	 */
	public function destroy(TabelBps $tabel): JsonResponse
	{
		$tabel->delete();

		return response()->json(['message' => 'Tabel BPS successfully deleted.']);
	}

	/**
	 * Deletes multiple TabelBps records based on the provided IDs.
	 *
	 * @param TabelBpsRequest $request
	 * @return JsonResponse
	 */
	public function massDestroy(TabelBpsRequest $request): JsonResponse
	{
		$tabel = TabelBps::whereIn('id', $request->validated('ids'))->get();

		$tabel->each(function ($tabel) {
			$tabel->delete();
		});

		return response()->json(['message' => 'Tabel BPS successfully deleted.']);
	}
}
