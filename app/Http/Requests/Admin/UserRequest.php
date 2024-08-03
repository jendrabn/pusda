<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return $this->user()->role === User::ROLE_ADMIN;
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
				'skpd_id' => ['required', 'integer', 'exists:skpd,id'],
				'name' => ['required', 'string', 'min:3', 'max:50'],
				'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', 'unique:users,username'],
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
				'phone' => ['nullable', 'string', 'min:10', 'max:15', 'starts_with:62'],
				'birth_date' => ['nullable', 'date'],
				'address' => ['nullable', 'string', 'max:255'],
				'role' => ['required', 'in:' . implode(',', User::ROLES)],
				'password' => ['required', 'string', 'min:6', 'max:30'],
			];
		} else if ($this->isMethod('PUT')) {
			return [
				'skpd_id' => ['required', 'integer', 'exists:skpd,id'],
				'name' => ['required', 'string', 'max:50'],
				'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . $this->user->id],
				'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email,' . $this->user->id],
				'phone' => ['nullable', 'string', 'min:10', 'max:15', 'starts_with:62'],
				'birth_date' => ['nullable', 'date'],
				'address' => ['nullable', 'string', 'max:255'],
				'role' => ['required', 'in:' . implode(',', User::ROLES)],
				'password' => ['nullable', 'string', 'min:6', 'max:30'],
			];
		} else {
			return [];
		}
	}
}
