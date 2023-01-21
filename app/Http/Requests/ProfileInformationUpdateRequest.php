<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class ProfileInformationUpdateRequest extends FormRequest
{

  public function authorize()
  {
    return in_array(auth()->user()->role, array_keys(User::ROLES));;
  }

  public function rules()
  {
    return [
      'name' => ['required', 'string', 'max:50'],
      'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . auth()->id()],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
      'phone' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
      'address' => ['nullable', 'string', 'max:255'],
      '_photo' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
    ];
  }

  public function attributes()
  {
    return [
      'name' => 'nama lengkap',
      'phone' => 'no. hp/whatsapp',
      'address' => 'alamat rumah',
      '_photo' => 'foto profil'
    ];
  }

  protected function passedValidation()
  {
    if ($this->hasFile('_photo')) {
      if (auth()->user()->photo) {
        Storage::disk('public')->delete(auth()->user()->photo);
      }

      $this->merge([
        'photo' =>  $this->file('_photo')->storePublicly('user_photos', 'public')
      ]);
    }
  }
}
