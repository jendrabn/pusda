<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\DataTables\TreeView\TabelRpjmdDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TreeView\TabelRpjmdRequest;
use App\Models\Skpd;
use App\Models\TabelRpjmd;
use Illuminate\Http\JsonResponse;

class RpjmdController extends Controller
{

	public function index(TabelRpjmdDataTable $dataTable): mixed
	{
		$categories = TabelRpjmd::with(['parent', 'childs.childs.childs'])->get();
		$skpds = Skpd::pluck('singkatan', 'id');
		$title = 'Menu Treeview RPJMD';
		$routePart = 'rpjmd';

		return $dataTable->render('admin.treeview.index', compact(
			'categories',
			'skpds',
			'title',
			'routePart'
		));
	}

	public function store(TabelRpjmdRequest $request): JsonResponse
	{
		TabelRpjmd::create($request->validated());

		return response()->json(['message' => 'Tabel RPJMD successfully created.']);
	}

	public function update(TabelRpjmdRequest $request, TabelRpjmd $tabel): JsonResponse
	{
		$tabel->update($request->validated());

		return response()->json(['message' => 'Tabel RPJMD successfully updated.']);
	}

	public function destroy(TabelRpjmd $tabel): JsonResponse
	{
		$tabel->delete();

		return response()->json(['message' => 'Tabel RPJMD successfully deleted.']);
	}

	public function massDestroy(TabelRpjmdRequest $request): JsonResponse
	{
		$tabel = TabelRpjmd::whereIn('id', $request->validated('ids'))->get();

		$tabel->each(function ($tabel) {
			$tabel->delete();
		});

		return response()->json(['message' => 'Tabel RPJMD successfully deleted.']);
	}
}
