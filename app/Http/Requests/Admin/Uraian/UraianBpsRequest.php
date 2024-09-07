<?php

namespace App\Http\Requests\Admin\Uraian;

use Illuminate\Foundation\Http\FormRequest;

class UraianBpsRequest extends FormRequest
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
		if ($this->routeIs('admin.uraian.bps.store')) {
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
		} else if ($this->routeIs('admin.uraian.bps.update')) {
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
		} else if ($this->routeIs('admin.uraian.bps.massDestroy')) {
			return [
				'ids' => [
					'required',
					'array'
				],
				'ids.*' => [
					'integer',
					'exists:uraian_bps,id'
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
		$this->merge([
			'skpd_id' => $this->user()->skpd_id
		]);
	}
}
