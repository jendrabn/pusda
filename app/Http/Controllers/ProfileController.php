<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileInformationUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  public function index(): View
  {
    return view('profile', ['user' => auth()->user()]);
  }

  public function updateProfileInformation(ProfileInformationUpdateRequest $request): RedirectResponse
  {
    auth()->user()->update($request->all());

    return back()->with('success-message', 'Profil berhasil diupdate.');
  }

  public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
  {
    auth()->user()->update($request->all());

    return back()->with('success-message', 'Password berhasil diupdate.');
  }
}
