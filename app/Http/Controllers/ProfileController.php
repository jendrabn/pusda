<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  public function index()
  {
    $user = auth()->user();

    return view('profile', compact('user'));
  }

  public function updateProfileInformation(UpdateProfileRequest $request)
  {
    $user = auth()->user();

    $user->fill($request->validated());

    if ($request->hasFile('photo')) {
      Storage::disk('public')->delete($user->photo);

      $user->photo = $request->file('photo')->storePublicly('user_photos', 'public');
    }

    $user->save();

    return back()->with('success-message', 'Profile successfully updated.');
  }

  public function updatePassword(UpdatePasswordRequest $request)
  {
    auth()->user()->update($request->validated());

    return back()->with('success-message', 'Password successfully updated.');
  }
}
