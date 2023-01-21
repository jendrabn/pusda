<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  protected $maxAttempts = 3;
  protected $decayMinutes = 1;

  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function redirectTo()
  {
    $role = auth()->user()->role ?? null;

    if ($role == 1) {
      return route('admin.dashboard');
    } elseif ($role == 2) {
      return route('admin-skpd.dashboard');
    } else {
      return route('/');
    }
  }

  public function username()
  {
    $fieldType = filter_var(request('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    request()->merge([$fieldType => request('username')]);

    return $fieldType;
  }
}
