<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'max:50'],
			'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . $this->user()->id],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
			'phone' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
			'address' => ['nullable', 'string', 'max:255'],
			'avatar' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
			'birth_date' => ['nullable', 'date']
		];
	}
}
