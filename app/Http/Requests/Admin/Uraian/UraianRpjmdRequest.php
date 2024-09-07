<?php

namespace App\Http\Requests\Admin\Uraian;

use Illuminate\Foundation\Http\FormRequest;

class UraianRpjmdRequest extends FormRequest
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
		if ($this->routeIs('admin.uraian.rpjmd.store')) {
			return [
				'parent_id' => [
					'nullable',
					'integer'
				],
				'uraian' => [
					'required',
					'string',
					'min:1',
					'max:200'
				],
			];
		} else if ($this->routeIs('admin.uraian.rpjmd.update')) {
			return [
				'parent_id' => [
					'nullable',
					'integer'
				],
				'uraian' => [
					'required',
					'string',
					'min:1',
					'max:200'
				],
			];
		} else if ($this->routeIs('admin.uraian.rpjmd.massDestroy')) {
			return [
				'ids' => [
					'required',
					'array'
				],
				'ids.*' => [
					'integer',
					'exists:uraian_rpjmd,id'
				]
			];
		} else {
			return [
				//
			];
		}
	}

	public function prepareForValidation(): void
	{
		// Kebanyakan ID SKPD  null
		$this->merge([
			'skpd_id' => $this->user()->skpd_id
		]);
	}
}
