<?php

namespace App\Http\Requests\Profile;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
			'current_password' => [
				'required',
				'string',
				'current_password'
			],
			'password' => [
				'required',
				'string',
				Password::min(8)->max(30)->mixedCase()->numbers(),
				'confirmed'
			],
		];
	}
}
