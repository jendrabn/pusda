<?php

namespace App\Http\Requests\Admin;

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
            'skpd_id' => ['required', 'numeric', 'exists:skpd,id'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'username' => ['required', 'string', 'min:3', 'max:25', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:1,2'],
            'password' => ['required', 'string', 'min:3', 'max:50'],
        ];
    }
}
