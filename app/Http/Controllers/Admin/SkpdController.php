<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SkpdsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkpdRequest;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use Illuminate\Http\JsonResponse;

class SkpdController extends Controller
{
	/**
	 * Displays the index page for SKPD.
	 *
	 * @param SkpdsDataTable $dataTable
	 * @return mixed
	 */
	public function index(SkpdsDataTable $dataTable): mixed
	{
		$kategori = KategoriSkpd::pluck('nama', 'id')->prepend('---', null);

		return $dataTable->render('admin.skpd.index', compact('kategori'));
	}

	/**
	 * Handles the creation of a new SKPD instance.
	 *
	 * @param SkpdRequest $request
	 * @return JsonResponse
	 */
	public function store(SkpdRequest $request): JsonResponse
	{
		Skpd::create($request->validated());

		return response()->json(['message' => 'SKPD successfully created.']);
	}

	/**
	 * Handles the update of an existing SKPD instance.
	 *
	 * @param SkpdRequest $request
	 * @param Skpd $skpd
	 * @return JsonResponse
	 */
	public function update(SkpdRequest $request, Skpd $skpd): JsonResponse
	{
		$skpd->update($request->validated());

		return response()->json(['message' => 'SKPD successfully updated.']);
	}

	/**
	 * Handles the deletion of an existing SKPD instance.
	 *
	 * @param Skpd $skpd
	 * @return JsonResponse
	 */
	public function destroy(Skpd $skpd): JsonResponse
	{
		$skpd->delete();

		return response()->json(['message' => 'SKPD successfully deleted.']);
	}

	/**
	 * Handles the mass deletion of existing SKPD instances.
	 *
	 * @param SkpdRequest $request
	 * @return JsonResponse
	 */
	public function massDestroy(SkpdRequest $request): JsonResponse
	{
		$skpds = Skpd::whereIn('id', $request->validated('ids'))->get();

		$skpds->each(function ($skpd) {
			$skpd->delete();
		});

		return response()->json(['message' => 'SKPD successfully deleted.']);
	}
}
