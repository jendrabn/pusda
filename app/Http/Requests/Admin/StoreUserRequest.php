<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{

  public function authorize()
  {
    return auth()->user()->role === User::ROLE_ADMIN;
  }

  public function rules()
  {
    return [
      'skpd_id' => ['required', 'numeric', 'exists:skpd,id'],
      'name' => ['required', 'string', 'min:3', 'max:50'],
      'username' => ['required', 'string', 'min:3', 'max:25', 'alpha_dash', 'unique:users,username'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
      'phone' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
      'address' => ['nullable', 'string', 'max:255'],
      'role' => ['required', 'in:' . implode(',', User::ROLES)],
      'password' => ['required', 'string', 'min:3', 'max:50'],
    ];
  }
}
