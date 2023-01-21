<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class ProfileInformationUpdateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
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

  /**
   * Handle a passed validation attempt.
   *
   * @return void
   */
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
