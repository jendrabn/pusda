<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Prepare the data for validation.
	 */
	protected function prepareForValidation(): void
	{
		$this->merge([
			'remember' => filter_var($this->remember, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
		]);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		if ($this->isMethod('POST')) {
			return [
				'username' => [
					'required',
					'string'
				],
				'password' => [
					'required',
					'string'
				],
				'remember' => [
					'nullable',
					'boolean'
				]
			];
		} else {
			return [];
		}
	}
}
