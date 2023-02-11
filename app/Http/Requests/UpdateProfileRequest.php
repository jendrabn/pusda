<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{

  public function authorize()
  {
    return in_array(auth()->user()->role, User::ROLES);
  }

  public function rules()
  {
    return [
      'name' => ['required', 'string', 'max:50'],
      'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . auth()->id()],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
      'phone' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
      'address' => ['nullable', 'string', 'max:255'],
      'photo' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
      'birth_date' => ['nullable', 'date']
    ];
  }

  public function attributes()
  {
    return [
      'name' => 'nama lengkap',
      'phone' => 'no. hp/whatsapp',
      'address' => 'alamat',
      'photo' => 'foto profil',
      'birth_date' => 'tanggal lahir'
    ];
  }
}
