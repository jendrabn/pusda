<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
  public function authorize()
  {
    return in_array(auth()->user()->role, User::ROLES);
  }

  public function rules()
  {
    return [
      'current_password' => ['required', 'string', 'current_password'],
      'password' => ['required', 'string', Password::min(6)->mixedCase()->numbers(), 'confirmed'],
    ];
  }

  public function attributes()
  {
    return [
      'current_password' => 'password saat ini',
      'password' => 'password baru'
    ];
  }
}
