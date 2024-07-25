<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Profile\ProfileRequest;

class ProfileController extends Controller
{

	/**
	 * Retrieves the profile view with the authenticated user.
	 *
	 * @return View
	 */
	public function index(Request $request): View
	{
		return view('profile', ['user' => $request->user()]);
	}

	/**
	 * Updates the user profile based on the provided ProfileRequest.
	 *
	 * @param ProfileRequest $request
	 * @return RedirectResponse
	 */
	public function updateProfile(ProfileRequest $request): RedirectResponse
	{
		$validatedData = $request->validated();

		$user = $request->user();

		if ($request->hasFile('photo')) {
			$validatedData['photo'] = $request->file('photo')->store('images/users', 'public');

			if (Storage::disk('public')->exists($user->photo)) {
				Storage::disk('public')->delete($user->photo);
			}
		}

		$user->update($validatedData);

		toastr('Profile successfully updated.', Type::SUCCESS);

		return to_route('profile');
	}


	/**
	 * Updates the user's password based on the provided PasswordRequest.
	 *
	 * @param PasswordRequest $request
	 * @return RedirectResponse
	 */
	public function updatePassword(PasswordRequest $request): RedirectResponse
	{
		$request->user()->update($request->validated());

		toastr('Password successfully updated.', Type::SUCCESS);

		return to_route('profile');
	}
}
