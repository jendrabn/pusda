<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\DataTables\TreeView\Tabel8KelDataDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TreeView\Tabel8KelDataRequest;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use Illuminate\Http\JsonResponse;

class DelapanKelDataController extends Controller
{

	/**
	 * Display a listing of the resource
	 *
	 * @param Tabel8KelDataDataTable $dataTable
	 * @return mixed
	 */
	public function index(Tabel8KelDataDataTable $dataTable): mixed
	{
		$categories = Tabel8KelData::with(['parent', 'childs.childs'])->get();
		$skpds = Skpd::pluck('singkatan', 'id');
		$title = 'Menu Treeview 8 Kel. Data';
		$routePart = 'delapankeldata';

		return $dataTable->render('admin.treeview.index', compact(
			'categories',
			'skpds',
			'title',
			'routePart'
		));
	}

	/**
	 * Handles the creation of a new Tabel 8 Kel. Data resource.
	 *
	 * @param Tabel8KelDataRequest $request
	 * @return JsonResponse
	 */
	public function store(Tabel8KelDataRequest $request): JsonResponse
	{
		Tabel8KelData::create($request->validated());

		return response()->json(['message' => 'Tabel 8 Kel. Data successfully created.']);
	}

	/**
	 * Handles the updating of an existing Tabel 8 Kel. Data resource.
	 *
	 * @param Tabel8KelDataRequest $request
	 * @param Tabel8KelData $tabel
	 * @return JsonResponse
	 */
	public function update(Tabel8KelDataRequest $request, Tabel8KelData $tabel): JsonResponse
	{
		$tabel->update($request->validated());

		return response()->json(['message' => 'Tabel 8 Kel. Data successfully updated.']);
	}

	/**
	 * Handles the deletion of an existing Tabel 8 Kel. Data resource.
	 *
	 * @param Tabel8KelData $tabel
	 * @return JsonResponse
	 */
	public function destroy(Tabel8KelData $tabel): JsonResponse
	{
		$tabel->delete();

		return response()->json(['message' => 'Tabel 8 Kel. Data successfully deleted.']);
	}

	/**
	 * Handles the mass deletion of existing Tabel 8 Kel. Data resources.
	 *
	 * @param Tabel8KelDataRequest $request
	 * @return JsonResponse
	 */
	public function massDestroy(Tabel8KelDataRequest $request): JsonResponse
	{
		$tabel = Tabel8KelData::whereIn('id', $request->validated('ids'))->get();

		$tabel->each(fn($tabel) => $tabel->delete());

		return response()->json(['message' => 'Tabel 8 Kel. Data successfully deleted.']);
	}

	public function menuTreeView()
	{
		return view('admin.treeview.menu');
	}
}
