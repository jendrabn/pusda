<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SkpdsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkpdRequest;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use Flasher\Prime\Notification\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SkpdController extends Controller
{
	/**
	 * Render the index view for the SkpdsDataTable.
	 *
	 * @param SkpdsDataTable $dataTable
	 * @return JsonResponse|View|BinaryFileResponse
	 */
	public function index(SkpdsDataTable $dataTable): JsonResponse|View|BinaryFileResponse
	{
		return $dataTable->render('admin.skpd.index');
	}

	/**
	 * Renders the view for creating a new SKPD
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function create(): View
	{
		$kategori = KategoriSkpd::pluck('nama', 'id');

		return view('admin.skpd.create', compact('kategori'));
	}

	/**
	 * Store a new SKPD.
	 *
	 * @param SkpdRequest $request
	 * @return RedirectResponse
	 */
	public function store(SkpdRequest $request): RedirectResponse
	{
		Skpd::create($request->validated());

		toastr('SKPD successfully created.', Type::SUCCESS);

		return to_route('admin.skpd.index');
	}

	/**
	 * Render the view for editing a specific SKPD.
	 *
	 * @param Skpd $skpd
	 * @return View
	 */
	public function edit(Skpd $skpd): View
	{
		$kategori = KategoriSkpd::pluck('nama', 'id');

		return view('admin.skpd.edit', compact('skpd', 'kategori'));
	}

	/**
	 * Update an existing SKPD.
	 *
	 * @param SkpdRequest $request
	 * @param Skpd $skpd
	 * @return RedirectResponse
	 */
	public function update(SkpdRequest $request, Skpd $skpd): RedirectResponse
	{
		$skpd->update($request->validated());

		toastr('SKPD successfully updated.', Type::SUCCESS);

		return back();
	}

	/**
	 * Delete an SKPD if its ID is not 1.
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
	 * Mass delete SKPDs based on the provided IDs.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function massDestroy(Request $request): JsonResponse
	{
		$validatedData = $request->validate([
			'ids' => [
				'required',
				'array'
			],
			'ids.*' => [
				'integer',
				'exists:skpd,id'
			]
		]);

		Skpd::whereIn('id', $validatedData['ids'])->delete();

		return response()->json(['message' => 'SKPD successfully deleted.']);
	}
}
