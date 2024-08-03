<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Models\Skpd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\UserRequest;
use App\Services\UserService;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
	public function __construct(private UserService $service)
	{
	}

	/**
	 * Display a listing of the users.
	 *
	 * @param UsersDataTable $dataTable
	 * @return View
	 */
	public function index(UsersDataTable $dataTable)
	{
		return $dataTable->render('admin.users.index');
	}

	/**
	 * Creates a new view for creating a user.
	 *
	 * @return View
	 */
	public function create(): View
	{
		$skpds = Skpd::pluck('nama', 'id');
		$roles = Role::pluck('name', 'id');

		return view('admin.users.create', compact('skpds', 'roles'));
	}

	/**
	 * Store a newly created user in the database.
	 *
	 * @param UserRequest $request
	 * @return RedirectResponse
	 */
	public function store(UserRequest $request): RedirectResponse
	{
		$validatedData = $request->validated();

		User::create($validatedData)?->assignRole($validatedData['role']);

		toastr('User successfully created.', Type::SUCCESS);

		return to_route('admin.users.index');
	}

	/**
	 * Edit the details of a user.
	 *
	 * @param User $user
	 * @return View
	 */
	public function edit(User $user): View
	{
		$skpds = Skpd::pluck('nama', 'id');
		$roles = Role::pluck('name', 'id');

		return view('admin.users.edit', compact('skpds', 'roles', 'user'));
	}

	/**
	 * Update the specified user with the given request data.
	 *
	 * @param UserRequest $request
	 * @param User $user
	 * @return RedirectResponse
	 */
	public function update(UserRequest $request, User $user): RedirectResponse
	{
		$validatedData = $request->validated();

		if (!$validatedData['password']) unset($validatedData['password']);

		$user->update($validatedData);
		$user->syncRoles($validatedData['role']);

		toastr('User successfully updated.', Type::SUCCESS);

		return back();
	}

	/**
	 * Delete a user and their associated photo.
	 *
	 * @param User $user
	 * @return JsonResponse
	 */
	public function destroy(User $user): JsonResponse
	{
		$this->service->deleteAvatar($user->photo);

		$user->delete();

		return response()->json(['message' => 'User successfully deleted.']);
	}


	/**
	 * Delete multiple users and their associated photos.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 * @throws ValidationException
	 */
	public function massDestroy(Request $request): JsonResponse
	{
		$request->validate([
			'ids' => [
				'required',
				'array'
			],
			'ids.*' => [
				'integer',
				'exists:users,id'
			]
		]);

		$users = User::whereIn('id', $request->ids)->get();

		$users->each(function ($user) {
			$this->service->deleteAvatar($user->photo);
			$user->delete();
		});

		return response()->json(['message' => 'User successfully deleted.']);
	}
}
