<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  /**
   * Undocumented function
   *
   * @return View
   */
  public function index(): View
  {
    return view('profile', ['user' => auth()->user()]);
  }

  /**
   * Undocumented function
   *
   * @param UpdateProfileRequest $request
   * @return RedirectResponse
   */
  public function updateProfile(UpdateProfileRequest $request): RedirectResponse
  {
    $user = auth()->user();

    $user->fill($request->validated());

    if ($request->hasFile('photo')) {
      Storage::disk('public')->delete($user->photo);

      $user->photo = $request->file('photo')->store('images/users', 'public');
    }

    $user->save();

    toastr()->addSuccess('Profile successfully updated.');

    return to_route('profile');
  }

  /**
   * Undocumented function
   *
   * @param UpdatePasswordRequest $request
   * @return RedirectResponse
   */
  public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
  {
    auth()->user()->update($request->validated());

    toastr()->addSuccess('Password successfully updated.');

    return to_route('profile');
  }
}
