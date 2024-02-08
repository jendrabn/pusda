<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroySkpdRequest extends FormRequest
{
  public function authorize()
  {
    return auth()->user()->role === User::ROLE_ADMIN;
  }

  public function rules()
  {
    return [
      'ids' => ['required', 'array'],
      'ids.*' => ['integer', 'exists:skpd,id']
    ];
  }
}
