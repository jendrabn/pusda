<?php

namespace App\Http\Controllers\Admin\Uraian;

use Illuminate\Http\Request;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\DataTables\Uraian\Uraian8KelDataDataTable;
use App\Http\Requests\Admin\Uraian\Uraian8KelDataRequest;

class DelapanKelDataController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @param Tabel8KelData|null $tabel
	 * @return mixed
	 */
	public function index(Request $request, Uraian8KelDataDataTable $dataTable, Tabel8KelData $tabel = null): mixed
	{
		$categories = Tabel8KelData::with('childs.childs.childs')->get();
		$title = 'Uraian Form Menu 8 Kelompok Data';
		$routePart = 'delapankeldata';

		return $dataTable->render('admin.uraian.index', compact(
			'tabel',
			'categories',
			'title',
			'routePart',
		));
	}

	/**
	 * Retrieves a collection of uraians for the given tabel.
	 *
	 * @param Tabel8KelData $tabel
	 * @return JsonResponse
	 */
	public function uraians(Tabel8KelData $tabel): JsonResponse
	{
		$uraian = Uraian8KelData::where('tabel_8keldata_id', $tabel->id)
			->whereNull('parent_id')
			->orderBy('id')
			->get();

		return response()->json($uraian);
	}

	/**
	 * Stores a new uraian 8 kelompok data.
	 *
	 * @param Uraian8KelDataRequest $request
	 * @param Tabel8KelData $tabel
	 * @return JsonResponse
	 */
	public function store(Uraian8KelDataRequest $request, Tabel8KelData $tabel): JsonResponse
	{
		$tabel->uraian8KelData()->create($request->validated());

		return response()->json(['message' => 'Uraian 8 kelompok data successfully created.']);
	}

	/**
	 * Updates the Uraian8KelData resource.
	 *
	 * @param Uraian8KelDataRequest $request
	 * @param Uraian8KelData $uraian
	 * @return JsonResponse
	 */
	public function update(Uraian8KelDataRequest $request, Uraian8KelData $uraian): JsonResponse
	{
		$uraian->update($request->validated());

		return response()->json(['message' => 'Uraian 8 kelompok data successfully updated.']);
	}

	/**
	 * Deletes an existing Uraian8KelData resource.
	 *
	 * @param Uraian8KelData $uraian
	 * @return JsonResponse
	 */
	public function destroy(Uraian8KelData $uraian): JsonResponse
	{
		$uraian->delete();

		return response()->json(['message' => 'Uraian 8 kelompok data successfully deleted.']);
	}

	/**
	 * Deletes multiple Uraian8KelData resources.
	 *
	 * @param Uraian8KelDataRequest $request
	 * @return JsonResponse
	 */
	public function massDestroy(Uraian8KelDataRequest $request): JsonResponse
	{
		Uraian8KelData::whereIn('id', $request->validated('ids'))->delete();

		return response()->json(['message' => 'Uraian 8 kelompok data successfully deleted.']);
	}
}
