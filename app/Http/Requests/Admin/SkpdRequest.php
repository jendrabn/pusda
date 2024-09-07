<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SkpdRequest extends FormRequest
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
		if ($this->routeIs('admin.skpd.store')) {
			return [
				'nama' => ['required', 'string', 'min:3', 'max:255', 'unique:skpd,nama'],
				'singkatan' => ['required', 'string', 'min:3', 'max:255', 'unique:skpd,singkatan'],
				'kategori_skpd_id' => ['required', 'integer', 'exists:kategori_skpd,id']
			];
		} else if ($this->routeIs('admin.skpd.update')) {
			return [
				'nama' => ['required', 'string', 'min:3', 'max:255', 'unique:skpd,nama,' . $this->skpd->id],
				'singkatan' => ['required', 'string', 'min:3', 'max:255', 'unique:skpd,singkatan,' . $this->skpd->id],
				'kategori_skpd_id' => ['required', 'integer', 'exists:kategori_skpd,id']
			];
		} else if ($this->routeIs('admin.skpd.massDestroy')) {
			return [
				'ids' => [
					'required',
					'array'
				],
				'ids.*' => [
					'integer',
					'exists:skpd,id'
				]
			];
		} else {
			return [];
		}
	}
}
