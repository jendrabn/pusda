<?php

namespace App\Http\Requests\Admin\Uraian;

use Illuminate\Foundation\Http\FormRequest;

class Uraian8KelDataRequest extends FormRequest
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
		if ($this->routeIs('admin.uraian.delapankeldata.store')) {
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
				'skpd_id' => [
					'required',
					'integer',
					'exists:skpd,id'
				]
			];
		} else if ($this->routeIs('admin.uraian.delapankeldata.update')) {
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
		} else if ($this->routeIs('admin.uraian.delapankeldata.massDestroy')) {
			return [
				'ids' => [
					'required',
					'array'
				],
				'ids.*' => [
					'integer',
					'exists:uraian_8keldata,id'
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
		// Kebanyakan ID SKPD tidak null
		$this->merge([
			'skpd_id' => $this->user()->skpd_id
		]);
	}
}
