<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FiturRequest extends FormRequest
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
			'deskripsi' => ['nullable', 'string', 'max:255'],
			'analisis' => ['nullable', 'string', 'max:255'],
			'permasalahan' => ['nullable', 'string', 'max:255'],
			'solusi' => ['nullable', 'string', 'max:255'],
			'saran' => ['nullable', 'string', 'max:255']
		];
	}
}
