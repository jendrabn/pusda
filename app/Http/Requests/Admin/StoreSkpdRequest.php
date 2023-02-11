<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreSkpdRequest extends FormRequest
{

  public function authorize()
  {
    return auth()->user()->role === User::ROLE_ADMIN;
  }

  public function rules()
  {
    return [
      'nama' => ['required', 'string', 'max:255'],
      'singkatan' => ['required', 'string', 'max:255'],
      'kategori_skpd_id' => ['required', 'integer', 'exists:kategori_skpd,id']
    ];
  }
}
