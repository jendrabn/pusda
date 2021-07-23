<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->level === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'skpd_id' => ['required', 'numeric', 'exists:skpd,id'],
            'name' => ['required', 'string', 'min:3', 'max:25'],
            'username' => ['required', 'string', 'min:3', 'max:30', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email'],
            'no_hp' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'level' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:3', 'max:25'],
        ];
    }
}
