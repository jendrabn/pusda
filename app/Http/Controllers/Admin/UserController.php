<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassDestroyUserRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

	/**
	 * Return view for index, given as follows:
	 *
	 * @param Request $request
	 * @return JsonResponse theView
	 */
	public function index(Request $request): JsonResponse|View
	{
		if ($request->ajax()) {
			$model = User::with(['skpd'])->select(sprintf('%s.*', (new User())->getTable()));
			$table = Datatables::eloquent($model);

			$table->addColumn('placeholder', '&nbsp;');
			$table->addColumn('actions', '&nbsp;');

			$table->editColumn('actions', function ($row) {
				$crudRoutePart = 'users';

				return view('partials.datatablesActions', compact('crudRoutePart', 'row'));
			});

			$table->editColumn('role', fn($row) => sprintf(
				'<span class="badge badge-info rounded-0">%s</span>',
				$row->role
			));

			$table->rawColumns(['actions', 'placeholder', 'role']);

			return $table->toJson();
		}

		return view('admin.users.index');
	}

	/**
	 * Show the specified user.
	 *
	 * @param User $user
	 * @return View
	 */
	public function show(User $user): View
	{
		return view('admin.users.show', compact('user'));
	}

	/**
	 * Create a new user instance after a valid request.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create(): View
	{
		$skpd = Skpd::pluck('nama', 'id');

		return view('admin.users.create', compact('skpd'));
	}


	/**
	 * Create a new user instance after a valid request.
	 *
	 * @param StoreUserRequest $request
	 * @return RedirectResponse
	 */
	public function store(StoreUserRequest $request): RedirectResponse
	{
		User::create($request->validated());

		toastr()->addSuccess('Pengguna berhasil disimpan.');

		return back();
	}

	/**
	 * Edit the specified user.
	 *
	 * @param User $user
	 * @return View
	 */
	public function edit(User $user): View
	{
		$skpd = Skpd::pluck('nama', 'id');

		return view('admin.users.edit', compact('skpd', 'user'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param UpdateUserRequest $request
	 * @param User $user
	 * @return RedirectResponse
	 */
	public function update(UpdateUserRequest $request, User $user): RedirectResponse
	{
		$user->update($request->validated());

		toastr()->addSuccess('Pengguna berhasil diperbarui.');

		return back();
	}


	/**
	 * Hapus pengguna yang spes the user.

	 *
	 * @param User $user
	 * @return RedirectResponse
	 */
	public function destroy(User $user): RedirectResponse
	{
		Storage::disk('public')->delete($user->photo);

		$user->delete();

		toastr()->addSuccess('Pengguna berhasil dihapus.');

		return back();
	}


	/**
	 * Mass delete users
	 *
	 * @param MassDestroyUserRequest $request
	 * @return HttpResponse
	 */
	public function massDestroy(MassDestroyUserRequest $request)
	{
		User::whereIn('id', $request->ids)->delete();

		return response(null, Response::HTTP_NO_CONTENT);
	}
}
